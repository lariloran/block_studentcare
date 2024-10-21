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

    private function enviar_notificacao($coleta) {
        global $DB, $CFG;
    
        // Busca o nome da disciplina (curso) usando o curso_id da coleta
        $curso = $DB->get_record('course', ['id' => $coleta->curso_id], 'fullname');
        $nome_disciplina = $curso ? $curso->fullname : 'Disciplina desconhecida';

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
    
            message_send($eventdata);
        }
    }
}
