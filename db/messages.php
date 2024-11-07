<?php

$messageproviders = array(
    'created_collection' => array(
        'capability'  => 'block/ifcare:receivenotifications',
    ),
);

$defaultmessageoutputs = array(
    'created_collection' => array(
        'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN,  
        'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN,  
    ),
);
