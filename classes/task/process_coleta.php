<?php
namespace block_ifcare\task;

class process_coleta extends \core\task\scheduled_task
{
    public function get_name() {
        return get_string('process_coleta', 'block_ifcare');
    }

    public function execute() {
        global $DB;

        $agora = time();
        mtrace("Iniciando tarefa cron de coleta...");

        // Consulta coletas que ainda não enviaram notificação
        $sql = "SELECT c.*
                FROM {ifcare_cadastrocoleta} c
                WHERE :agora >= c.data_inicio 
                AND :agora_fim <= c.data_fim
                AND c.notificar_alunos = 1
                AND c.notificacao_enviada = 0";

        $coletas = $DB->get_records_sql($sql, [
            'agora' => date('Y-m-d H:i:s', $agora),
            'agora_fim' => date('Y-m-d H:i:s', $agora),
        ]);

        if (!empty($coletas)) {
            foreach ($coletas as $coleta) {
                mtrace("Processando coleta: " . $coleta->nome);

                // Envia notificações para alunos matriculados
                $this->enviar_notificacao($coleta);

                // Marca a coleta como notificada
                $DB->set_field('ifcare_cadastrocoleta', 'notificacao_enviada', 1, ['id' => $coleta->id]);

                mtrace("Notificação enviada e coleta processada: " . $coleta->nome);
            }
        } else {
            mtrace("Nenhuma coleta encontrada para notificar.");
        }
    }

    private function adicionar_recurso_url($coleta, $curso) {
        global $DB, $USER, $CFG;
        
        // Incluir a biblioteca de módulos do Moodle para usar add_moduleinfo()
        require_once($CFG->dirroot . '/course/modlib.php');
    
        // Log do início do método
        mtrace("Iniciando a adição de recurso URL para a coleta: {$coleta->nome}, Curso ID: {$curso->id}");
    
        // Verifica se o curso foi fornecido corretamente
        if (!isset($curso->id)) {
            mtrace("Erro: Curso não encontrado ou inválido para adicionar o recurso URL.");
            return;
        }
    
        // Obter informações rápidas do curso
        mtrace("Obtendo informações do curso (get_fast_modinfo)...");
    
        $modinfo = get_fast_modinfo($curso->id);
        $sections = $modinfo->get_sections(); // Obtem todas as seções do curso
    
        // Verifica se o curso possui seções
        if (empty($sections)) {
            mtrace("Nenhuma seção encontrada no curso. Criando recurso na seção zero.");
            $sections[0] = []; // Adiciona manualmente a seção zero, pois ela sempre existe
        }
    
        // Garantir que o recurso seja sempre adicionado à primeira seção (seção 0)
        reset($sections); // Reseta o array para garantir que começamos da primeira seção
        $first_section_num = key($sections); // Obtém o número da primeira seção
    
        mtrace("Total de seções encontradas: " . count($sections));
        mtrace("Processando a primeira seção disponível: Seção {$first_section_num}");
    
        // Preparar os dados do recurso URL
        $urlparams = new \stdClass();
        $urlparams->course = $curso->id;
        $urlparams->module = $DB->get_field('modules', 'id', ['name' => 'url']); // ID do módulo de tipo 'url'
    
        // Verificar se o módulo URL foi encontrado
        if (!$urlparams->module) {
            mtrace("Erro: Não foi possível encontrar o módulo do tipo 'url' no banco de dados.");
            return;
        }
    
        mtrace("ID do módulo URL encontrado: {$urlparams->module}");
    
        $urlparams->modulename = 'url';
        $urlparams->visible = 1;
        $urlparams->format = FORMAT_MOODLE;
    
        // Definir o valor de 'display' para evitar os warnings
        $urlparams->display = 0;  // 0: Exibir no mesmo frame (padrão)
    
        // Dados do recurso URL que será criado na primeira seção
        $urlparams->section = $first_section_num; // Sempre na primeira seção
        $urlparams->name = "Coleta: {$coleta->nome}";
        $urlparams->intro = "Acesse a coleta de emoções: <a href='{$CFG->wwwroot}/blocks/ifcare/view.php?coletaid={$coleta->id}'>Clique aqui</a>";
        $urlparams->introformat = FORMAT_HTML;
        $urlparams->externalurl = "{$CFG->wwwroot}/blocks/ifcare/view.php?coletaid={$coleta->id}";
        $urlparams->timemodified = time();
    
        mtrace("Preparando para adicionar o recurso URL na primeira seção (Seção {$first_section_num})");
        mtrace("Nome do recurso: {$urlparams->name}");
        mtrace("URL: {$urlparams->externalurl}");
    
        // Criar a URL como um recurso dentro da primeira seção
        $cmid = \add_moduleinfo((object) $urlparams, $curso, null); // Agora a função será encontrada após o require
    
        if ($cmid) {
            mtrace("Recurso URL adicionado com sucesso na seção {$first_section_num} para a coleta: {$coleta->nome}");
        } else {
            mtrace("Falha ao adicionar recurso URL na seção {$first_section_num}.");
        }
    
        mtrace("Finalizando a adição de recurso URL para a coleta: {$coleta->nome}");
    }
    
    
    private function enviar_notificacao($coleta) {
        global $DB, $CFG;
    
        // Busca todas as informações do curso usando o curso_id da coleta
        $curso = $DB->get_record('course', ['id' => $coleta->curso_id]);
    
        if (!$curso) {
            mtrace("Erro: Curso não encontrado para a coleta {$coleta->nome} (ID do curso: {$coleta->curso_id})");
            return; // Se o curso não foi encontrado, não continua o processamento
        }
    
        $nome_disciplina = $curso->fullname;
    
        // Formata a data final da coleta
        $data_fim_formatada = date('d/m/Y H:i', strtotime($coleta->data_fim));
    
        // Busca os alunos matriculados no curso
        $enrols = $DB->get_records_sql("
            SELECT u.id, u.email
            FROM {user_enrolments} ue
            JOIN {enrol} e ON ue.enrolid = e.id
            JOIN {user} u ON ue.userid = u.id
            WHERE e.courseid = :courseid", 
            ['courseid' => $coleta->curso_id]);
    
        foreach ($enrols as $aluno) {
            $eventdata = new \core\message\message();
            $eventdata->component = 'block_ifcare';
            $eventdata->name = 'coleta_criada';
            $eventdata->userfrom = \core_user::get_noreply_user();
            $eventdata->userto = $aluno->id;
            $eventdata->subject = "Nova coleta de emoções: " . $coleta->nome;
            $eventdata->fullmessage = "A coleta \"{$coleta->nome}\" da disciplina {$nome_disciplina} foi criada e está pronta para ser realizada até {$data_fim_formatada}.";
            $eventdata->fullmessageformat = FORMAT_PLAIN;
            $eventdata->fullmessagehtml = "<p>A coleta de emoções para a disciplina <strong>{$nome_disciplina}</strong> está pronta para ser realizada até <strong>{$data_fim_formatada}</strong>. <a href='{$CFG->wwwroot}/blocks/ifcare/view.php?coletaid={$coleta->id}'>Clique aqui</a> para mais informações.</p>";
            $eventdata->smallmessage = "Coleta \"{$coleta->nome}\" da disciplina {$nome_disciplina} foi criada. <a href='{$CFG->wwwroot}/blocks/ifcare/view.php?coletaid={$coleta->id}'>Clique aqui</a>";
            $eventdata->notification = 1;
    
            // Envia a notificação
            message_send($eventdata);
        }
    
        // Adiciona o recurso URL em todas as seções do curso
        $this->adicionar_recurso_url($coleta, $curso);
    }
    
    
}
