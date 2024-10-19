<?php

$messageproviders = array(

    // Provedor de notificação para quando uma nova coleta for criada
    'coleta_criada' => array(
        'capability'  => 'block/ifcare:receivenotifications',
    ),
);

$defaultmessageoutputs = array(
    'coleta_criada' => array(
        'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN,  // Ativa e-mail por padrão
        'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN,  // Ativa popup por padrão
    ),
);
