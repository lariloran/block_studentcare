<?php
$messageproviders = array(

    // Provedor para notificação de criação de coleta.
    'coleta_criada' => array(
        'capability'  => 'block/ifcare:receivenotifications',  // Capacidade para receber a notificação.
    ),
);

// Configurações padrão para os métodos de notificação.
$defaultmessageoutputs = array(
    'coleta_criada' => array(
        'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN,  // Habilita por padrão o envio por e-mail.
        'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN,  // Habilita por padrão o envio por pop-up.
    ),
);
