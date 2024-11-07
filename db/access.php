<?php
$capabilities = [
    'block/ifcare:myaddinstance' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'archetypes' => [
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'student' => CAP_PREVENT,
        ],
    ],
    'block/ifcare:addinstance' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'archetypes' => [
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'student' => CAP_PREVENT,
        ],
    ],
    'block/ifcare:view' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'student' => CAP_PREVENT,
        ],
    ],
    'block/ifcare:receivenotifications' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => [
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
        ],
    ],
    'block/ifcare:managecollections' => [  // Nova capacidade
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'guest' => CAP_PREVENT,
            'student' => CAP_PREVENT,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ],
    ],
];
