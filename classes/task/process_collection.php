<?php
namespace block_ifcare\task;

class process_collection extends \core\task\scheduled_task
{
    public function get_name()
    {
        return get_string('process_collection', 'block_ifcare');
    }

    public function execute()
    {
        global $DB;

        $agora = time();
        mtrace("Iniciando tarefa cron de coleta...");

        // **1. Processar coletas que precisam enviar notificação de início**
        $sql = "SELECT c.*
            FROM {ifcare_cadastrocoleta} c
            WHERE :agora BETWEEN c.data_inicio AND c.data_fim
            AND c.notificar_alunos = 1
            AND c.notificacao_enviada = 0";

        try {
            $coletas = $DB->get_records_sql($sql, [
                'agora' => date('Y-m-d H:i:s', $agora),
            ]);
        } catch (\dml_exception $e) {
            mtrace("Erro ao buscar coletas: " . $e->getMessage());
            return;
        }


        if (!empty($coletas_iniciar)) {
            foreach ($coletas_iniciar as $coleta) {
                mtrace("Processando notificação de início para a coleta: " . $coleta->nome);

                $curso = $DB->get_record('course', ['id' => $coleta->curso_id]);

                $this->adicionar_recurso_url($coleta, $curso);

                $this->enviar_notificacao($coleta);

                $DB->set_field('ifcare_cadastrocoleta', 'notificacao_enviada', 1, ['id' => $coleta->id]);

                mtrace("Notificação de início enviada e coleta processada: " . $coleta->nome);
            }
        } else {
            mtrace("Nenhuma coleta encontrada para notificar início.");
        }

        // **2. Processar coletas que precisam enviar notificação de fim**
        $sql_finalizar = "SELECT c.*
                      FROM {ifcare_cadastrocoleta} c
                      WHERE :agora >= c.data_fim
                      AND c.receber_alerta = 1
                      AND c.notificacao_finalizada = 0";

        try {
            $coletas_finalizar = $DB->get_records_sql($sql_finalizar, [
                'agora' => date('Y-m-d H:i:s', $agora),
            ]);
        } catch (\dml_exception $e) {
            mtrace("Erro ao buscar coletas para notificação de fim: " . $e->getMessage());
            return;
        }

        if (!empty($coletas_finalizar)) {
            foreach ($coletas_finalizar as $coleta) {
                mtrace("Processando notificação de fim para a coleta: " . $coleta->nome);

                $this->enviar_notificacao_fim($coleta);

                // Atualizar a flag de notificação de fim no banco de dados
                $DB->set_field('ifcare_cadastrocoleta', 'notificacao_finalizada', 1, ['id' => $coleta->id]);

                mtrace("Notificação de fim enviada para a coleta: " . $coleta->nome);
            }
        } else {
            mtrace("Nenhuma coleta encontrada para notificar fim.");
        }
    }


    private function enviar_notificacao_fim($coleta)
    {
        global $DB, $CFG;

        // Verificar se a notificação já foi enviada
        if ($coleta->notificacao_finalizada) {
            mtrace("Notificação de fim já enviada para a coleta: {$coleta->nome}");
            return;
        }

        $usuario = $DB->get_record('user', ['id' => $coleta->usuario_id]);
        if (!$usuario) {
            mtrace("Erro: Usuário que cadastrou a coleta não foi encontrado. Coleta: {$coleta->nome}");
            return;
        }

        $curso = $DB->get_record('course', ['id' => $coleta->curso_id]);
        if (!$curso) {
            mtrace("Erro: Curso não encontrado para a coleta {$coleta->nome} (ID do curso: {$coleta->curso_id})");
            return;
        }

        $nome_disciplina = $curso->fullname;

        $eventdata = new \core\message\message();
        $eventdata->component = 'block_ifcare';
        $eventdata->name = 'collection_finished';
        $eventdata->userfrom = \core_user::get_noreply_user();
        $eventdata->userto = $usuario->id;
        
        $listagem_url = new \moodle_url('/blocks/ifcare/index.php');

        $eventdata->subject = "IFCare - Coleta finalizada: {$coleta->nome}";
        $eventdata->fullmessage = "Olá! A coleta de emoções '{$coleta->nome}' para a disciplina {$nome_disciplina} foi finalizada. Confira as respostas acessando o painel do IFCARE: {$listagem_url->out()}.";
        $eventdata->fullmessageformat = FORMAT_PLAIN;
        $eventdata->fullmessagehtml = "<p>Olá!</p>
            <p>A coleta de emoções <strong>{$coleta->nome}</strong> para a disciplina <strong>{$nome_disciplina}</strong> foi finalizada.</p>
            <p>Confira as respostas no painel do IFCARE clicando <a href='{$listagem_url->out()}'>aqui</a>.</p>";
        $eventdata->smallmessage = "A coleta '{$coleta->nome}' foi finalizada. Confira as respostas no painel do IFCARE <a href='{$listagem_url->out()}'>aqui</a>.";
        $eventdata->notification = 1;
        
        // Enviar a mensagem
        message_send($eventdata);

        // Atualizar a flag de notificação no banco de dados
        $DB->set_field('ifcare_cadastrocoleta', 'notificacao_finalizada', 1, ['id' => $coleta->id]);

        mtrace("Notificação de fim enviada com sucesso para a coleta: {$coleta->nome}");
    }

    private function adicionar_recurso_url($coleta, $curso)
    {
        global $DB, $USER, $CFG;

        $coleta->curso_id = clean_param($coleta->curso_id, PARAM_INT);
        $section_id = clean_param($coleta->section_id, PARAM_INT);

        require_once($CFG->dirroot . '/course/modlib.php');

        mtrace("Iniciando a adição de recurso URL para a coleta: {$coleta->nome}, Curso ID: {$curso->id}");

        if (!isset($curso->id)) {
            mtrace("Erro: Curso não encontrado ou inválido para adicionar o recurso URL.");
            return null;
        }

        mtrace("Obtendo informações do curso (get_fast_modinfo)...");

        $modinfo = get_fast_modinfo($curso->id);
        $sections = $modinfo->get_sections();

        if (empty($sections)) {
            mtrace("Nenhuma seção encontrada no curso. Criando recurso na seção zero.");
            $sections[0] = [];
        }

        $section_id = $coleta->section_id;
        mtrace("Total de seções encontradas: " . count($sections));
        mtrace("Processando a seção especificada: Seção {$section_id}");

        $urlparams = new \stdClass();
        $urlparams->course = $curso->id;
        $urlparams->module = $DB->get_field('modules', 'id', ['name' => 'url']);

        if (empty($curso) || empty($urlparams->module)) {
            mtrace("Erro ao obter dados do curso ou módulo.");
            return null; // Retorna null em caso de erro
        }

        mtrace("ID do módulo URL encontrado: {$urlparams->module}");

        $urlparams->modulename = 'url';
        $urlparams->visible = 1;
        $urlparams->format = FORMAT_MOODLE;
        $urlparams->display = 0;
        $urlparams->completion = 1;
        $urlparams->completionview = 0;
        $urlparams->section = $section_id;
        $urlparams->name = "IFCare - Como você está se sentindo hoje?";
        $data_inicio_formatada = date('d/m/Y H:i', strtotime($coleta->data_inicio));
        $data_fim_formatada = date('d/m/Y H:i', strtotime($coleta->data_fim));

        $urlparams->intro = clean_text("Responda esta coleta <strong>até</strong> {$data_fim_formatada}. Participe e nos ajude a compreender melhor suas emoções!", FORMAT_HTML);
        $urlparams->introformat = FORMAT_HTML;
        $urlparams->showdescription = 1;
        $urlparams->externalurl = clean_param("{$CFG->wwwroot}/blocks/ifcare/view.php?coletaid={$coleta->id}", PARAM_URL);
        $urlparams->timemodified = time();

        mtrace("Preparando para adicionar o recurso URL na seção especificada (Seção {$section_id})");
        mtrace("Nome do recurso: {$urlparams->name}");
        mtrace("URL: {$urlparams->externalurl}");

        $cmid = \add_moduleinfo((object) $urlparams, $curso, null);

        if (is_object($cmid) && property_exists($cmid, 'id')) {
            $cmid = (int) $cmid->id;
            mtrace("Recurso URL adicionado com sucesso com ID: {$cmid}");

            // Atualize o campo resource_id na tabela ifcare_cadastrocoleta
            $DB->set_field('ifcare_cadastrocoleta', 'resource_id', $cmid, ['id' => $coleta->id]);
        } else {
            mtrace("Erro: `cmid` não contém um ID válido.");
            return null;
        }



        mtrace("Finalizando a adição de recurso URL para a coleta: {$coleta->nome}");
    }


    private function enviar_notificacao($coleta)
    {
        global $DB, $CFG;


        $curso = $DB->get_record('course', ['id' => $coleta->curso_id]);

        if (!$curso) {
            mtrace("Erro: Curso não encontrado para a coleta {$coleta->nome} (ID do curso: {$coleta->curso_id})");
            return;
        }

        $nome_disciplina = $curso->fullname;

        $data_fim_formatada = date('d/m/Y H:i', strtotime($coleta->data_fim));

        $enrols = $DB->get_records_sql("
            SELECT u.id, u.email
            FROM {user_enrolments} ue
            JOIN {enrol} e ON ue.enrolid = e.id
            JOIN {user} u ON ue.userid = u.id
            WHERE e.courseid = :courseid",
            ['courseid' => $coleta->curso_id]
        );

        foreach ($enrols as $usuario) {
            $eventdata = new \core\message\message();
            $eventdata->component = 'block_ifcare';
            $eventdata->name = 'created_collection';
            $eventdata->userfrom = \core_user::get_noreply_user();
            $eventdata->userto = $usuario->id;
            $eventdata->subject = "IFCare - Compartilhe suas emoções sobre a disciplina de {$nome_disciplina}";
            $eventdata->fullmessage = "Olá! Uma coleta de emoções para a disciplina {$nome_disciplina} foi criada e está disponível até {$data_fim_formatada} para você responder. Sua opinião é muito importante. Por favor, participe!";
            $eventdata->fullmessageformat = FORMAT_PLAIN;
            $eventdata->fullmessagehtml = "<p>Olá!</p>
            <p>Uma coleta de emoções para a disciplina <strong>{$nome_disciplina}</strong> foi criada e está disponível até <strong>{$data_fim_formatada}</strong> para você responder.</p>
            <p>Sua opinião é muito importante para nós. <a href='{$CFG->wwwroot}/blocks/ifcare/view.php?coletaid={$coleta->id}'>Clique aqui</a> para compartilhar suas emoções e nos ajudar a melhorar sua experiência de aprendizado.</p>";
            $eventdata->smallmessage = "Uma coleta de emoções para a disciplina {$nome_disciplina} foi criada e está disponível até {$data_fim_formatada}. <a href='{$CFG->wwwroot}/blocks/ifcare/view.php?coletaid={$coleta->id}'>Clique aqui</a> para participar.";
            $eventdata->notification = 1;

            message_send($eventdata);
        }

    }


}
