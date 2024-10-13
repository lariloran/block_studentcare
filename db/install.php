<?php
/**
 * Executa ações após a instalação do plugin.
 */
function xmldb_block_ifcare_install() {
    global $DB;

    // Query para obter todos os usuários que podem receber notificações
    $sql = "SELECT id FROM {user} WHERE deleted = 0";
    $users = $DB->get_records_sql($sql);

    // Define a preferência de notificação pop-up para todos os usuários
    foreach ($users as $user) {
        // Definindo as preferências de notificação via API do Moodle
        $provider = 'block_ifcare/coleta_criada';

        // Notificação quando logado
        message_set_user_preferences([
            'userid' => $user->id,
            'message_provider' => $provider,
            'processor' => 'popup',  // Pop-up como método de notificação
            'preference' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN  // Ativa por padrão
        ]);
    }
}
