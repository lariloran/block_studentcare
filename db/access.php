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
    'block/ifcare:receivenotifications' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => [
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        ],
    ],
    'block/ifcare:managecollections' => [  // Capacidade para gerenciar coletas no bloco
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,  // Aplicada no contexto do sistema, pois é usada no painel
        'archetypes' => [
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        ],
    ],
];
