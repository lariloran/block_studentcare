<?php
$capabilities = [
    'block/studentcare:myaddinstance' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'archetypes' => [
            'manager' => CAP_ALLOW,
            'user' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'student' => CAP_PREVENT,
        ],
    ],
    'block/studentcare:addinstance' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'archetypes' => [
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'student' => CAP_PREVENT,
        ],
    ],
    'block/studentcare:receivenotifications' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => [
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        ],
    ],
    'block/studentcare:managecollections' => [  
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,  
        'archetypes' => [
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        ],
    ],
];
