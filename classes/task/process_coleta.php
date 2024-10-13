<?php
namespace block_ifcare\task;

class process_coleta extends \core\task\scheduled_task
{
    public function get_name()
    {
        return get_string('process_coleta', 'block_ifcare');
    }

    public function execute()
    {
        global $DB;
    
        // Obtém a data e hora atual
        $agora = time();
        mtrace("Iniciando tarefa cron de coleta..."); // Adiciona um log ao rodar a tarefa
    
        // Consulta as coletas cujo data_inicio seja agora ou anterior, e que ainda não enviaram notificação
        // E a data atual esteja entre o inicio e o fim da coleta
        $sql = "SELECT c.*
                FROM {ifcare_cadastrocoleta} c
                WHERE :agora >= c.data_inicio 
                AND :agora_fim <= c.data_fim
                AND c.notificar_alunos = 1
                AND c.notificacao_enviada = 0";
    
        // Passa dois parâmetros diferentes para data_inicio e data_fim
        $coletas = $DB->get_records_sql($sql, ['agora' => date('Y-m-d H:i:s', $agora), 'agora_fim' => date('Y-m-d H:i:s', $agora)]);
    
        if (!empty($coletas)) {
            mtrace("Coletas encontradas: " . count($coletas)); // Log da quantidade de coletas encontradas
            foreach ($coletas as $coleta) {
                mtrace("Processando coleta: " . $coleta->nome); // Log do nome da coleta
    
                // Enviar notificação para os alunos matriculados
                $this->enviar_notificacao($coleta);
    
                // Atualizar o campo para indicar que a notificação foi enviada
                $DB->set_field('ifcare_cadastrocoleta', 'notificacao_enviada', 1, ['id' => $coleta->id]);
    
                mtrace("Notificação enviada e campo atualizado para coleta: " . $coleta->id); // Log após atualização
            }
        } else {
            mtrace("Nenhuma coleta encontrada para notificar.");
        }
    }
    
    private function enviar_notificacao($coleta)
    {
        global $DB;

        // Obter os alunos matriculados no curso da coleta
        $enrols = $DB->get_records_sql("
            SELECT u.id, u.email
            FROM {user_enrolments} ue
            JOIN {enrol} e ON ue.enrolid = e.id
            JOIN {user} u ON ue.userid = u.id
            WHERE e.courseid = :courseid",
            ['courseid' => $coleta->curso_id]);

        foreach ($enrols as $aluno) {
            // Cria os dados da notificação
            $eventdata = new \core\message\message();
            $eventdata->component = 'block_ifcare'; // O componente que envia a mensagem (nome do plugin)
            $eventdata->name = 'coleta_criada'; // Nome da mensagem definida em messages.php
            $eventdata->userfrom = \core_user::get_noreply_user(); // Enviado pelo sistema (usuário sem resposta)
            $eventdata->userto = $aluno->id; // Destinatário (aluno)
            $eventdata->subject = "Nova coleta de emoções criada: " . $coleta->nome;
            $eventdata->fullmessage = "A coleta \"{$coleta->nome}\" foi criada e está pronta para ser realizada.";
            $eventdata->fullmessageformat = FORMAT_PLAIN; // Formato da mensagem
            $eventdata->fullmessagehtml = "<p>A coleta <strong>{$coleta->nome}</strong> foi criada e está pronta para ser realizada.</p>";
            $eventdata->smallmessage = "Coleta \"{$coleta->nome}\" foi criada.";
            $eventdata->notification = 1; // É uma notificação

            // Envia a mensagem para o aluno
            message_send($eventdata);
        }
    }
}
