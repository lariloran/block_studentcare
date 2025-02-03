<?php
namespace block_studentcare\task;

class process_collection extends \core\task\scheduled_task
{
    public function get_name()
    {
        return get_string('process_collection', 'block_studentcare');
    }

    public function execute()
    {
        global $DB;

        $agora = time();
        mtrace("Iniciando tarefa cron de coleta...");

        $sql = "SELECT c.*
        FROM {studentcare_cadastrocoleta} c
        WHERE :agora BETWEEN c.data_inicio AND c.data_fim
        AND c.notificacao_enviada = 0";

        try {
            $coletas_iniciar = $DB->get_records_sql($sql, [
                'agora' => date('Y-m-d H:i:s', $agora),
            ]);
        } catch (\dml_exception $e) {
            mtrace("Erro ao buscar coletas: " . $e->getMessage());
            return;
        }



        if (!empty($coletas_iniciar)) {
            foreach ($coletas_iniciar as $coleta) {
                mtrace("Processando a coleta: " . $coleta->nome);

                $curso = $DB->get_record('course', ['id' => $coleta->curso_id]);

                // Adicionar a URL para a coleta no curso
                $this->adicionar_recurso_url($coleta, $curso);

                // Enviar notificação de início somente se `notificar_alunos` estiver habilitado
                if ($coleta->notificar_alunos) {
                    $this->enviar_notificacao($coleta);
                }

                // Atualizar o campo `notificacao_enviada` independentemente da notificação
                $DB->set_field('studentcare_cadastrocoleta', 'notificacao_enviada', 1, ['id' => $coleta->id]);

                mtrace("Processamento concluído para a coleta: " . $coleta->nome);
            }
        } else {
            mtrace("Nenhuma coleta encontrada para processar.");
        }


        // **2. Processar coletas que precisam enviar notificação de fim**
        $sql_finalizar = "SELECT c.*
                      FROM {studentcare_cadastrocoleta} c
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
                $DB->set_field('studentcare_cadastrocoleta', 'notificacao_finalizada', 1, ['id' => $coleta->id]);

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
        $eventdata->component = 'block_studentcare';
        $eventdata->name = 'collection_finished';
        $eventdata->userfrom = \core_user::get_noreply_user();
        $eventdata->userto = $usuario->id;

        $listagem_url = new \moodle_url('/blocks/studentcare/index.php');

        $eventdata->subject = "StudentCare - Coleta finalizada: {$coleta->nome}";
        $eventdata->fullmessage = "Olá! A coleta de emoções '{$coleta->nome}' para a disciplina {$nome_disciplina} foi finalizada. Confira as respostas acessando o painel do StudentCare: {$listagem_url->out()}.";
        $eventdata->fullmessageformat = FORMAT_PLAIN;
        $eventdata->fullmessagehtml = "<p>Olá!</p>
            <p>A coleta de emoções <strong>{$coleta->nome}</strong> para a disciplina <strong>{$nome_disciplina}</strong> foi finalizada.</p>
            <p>Confira as respostas no painel do StudentCare clicando <a href='{$listagem_url->out()}'>aqui</a>.</p>";
        $eventdata->smallmessage = "A coleta '{$coleta->nome}' foi finalizada. Confira as respostas no painel do StudentCare <a href='{$listagem_url->out()}'>aqui</a>.";
        $eventdata->notification = 1;

        // Enviar a mensagem
        message_send($eventdata);

        // Atualizar a flag de notificação no banco de dados
        $DB->set_field('studentcare_cadastrocoleta', 'notificacao_finalizada', 1, ['id' => $coleta->id]);

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
        $urlparams->name = get_string('collection_title', 'block_studentcare');
        $data_inicio_formatada = date('d/m/Y H:i', strtotime($coleta->data_inicio));
        $data_fim_formatada = date('d/m/Y H:i', strtotime($coleta->data_fim));

        $urlparams->intro = clean_text(str_replace('{date}', $data_fim_formatada, get_string('collection_intro', 'block_studentcare')), FORMAT_HTML);
        $urlparams->introformat = FORMAT_HTML;
        $urlparams->showdescription = 1;
        $urlparams->externalurl = clean_param("{$CFG->wwwroot}/blocks/studentcare/view.php?coletaid={$coleta->id}", PARAM_URL);
        $urlparams->timemodified = time();

        mtrace("Preparando para adicionar o recurso URL na seção especificada (Seção {$section_id})");
        mtrace("Nome do recurso: {$urlparams->name}");
        mtrace("URL: {$urlparams->externalurl}");

        $cmid = \add_moduleinfo((object) $urlparams, $curso, null);

        if (is_object($cmid) && property_exists($cmid, 'id')) {
            $cmid = (int) $cmid->id;
            mtrace("Recurso URL adicionado com sucesso com ID: {$cmid}");

            // Atualize o campo resource_id na tabela studentcare_cadastrocoleta
            $DB->set_field('studentcare_cadastrocoleta', 'resource_id', $cmid, ['id' => $coleta->id]);
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
            $eventdata->component = 'block_studentcare';
            $eventdata->name = 'created_collection';
            $eventdata->userfrom = \core_user::get_noreply_user();
            $eventdata->userto = $usuario->id;
        
            // Substituição dos placeholders nas mensagens
            $subjectTemplate = get_string('event_subject', 'block_studentcare');
            $eventdata->subject = str_replace('{disciplina}', $nome_disciplina, $subjectTemplate);
        
            $fullMessageTemplate = get_string('event_fullmessage', 'block_studentcare');
            $eventdata->fullmessage = str_replace(
                array('{disciplina}', '{datafim}'),
                array($nome_disciplina, $data_fim_formatada),
                $fullMessageTemplate
            );
            $eventdata->fullmessageformat = FORMAT_PLAIN;
        
            $fullMessageHtmlTemplate = get_string('event_fullmessagehtml', 'block_studentcare');
            $eventdata->fullmessagehtml = str_replace(
                array('{disciplina}', '{datafim}', '{url}'),
                array($nome_disciplina, $data_fim_formatada, "{$CFG->wwwroot}/blocks/studentcare/view.php?coletaid={$coleta->id}"),
                $fullMessageHtmlTemplate
            );
        
            $smallMessageTemplate = get_string('event_smallmessage', 'block_studentcare');
            $eventdata->smallmessage = str_replace(
                array('{disciplina}', '{datafim}', '{url}'),
                array($nome_disciplina, $data_fim_formatada, "{$CFG->wwwroot}/blocks/studentcare/view.php?coletaid={$coleta->id}"),
                $smallMessageTemplate
            );
        
            $eventdata->notification = 1;
        
            message_send($eventdata);
        }
        

    }


}
