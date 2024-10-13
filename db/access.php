<?php
$capabilities = [
    // Capacidade para adicionar instâncias do bloco ao curso
    'block/ifcare:addinstance' => [
        'riskbitmask' => RISK_SPAM | RISK_XSS,  // Definindo os riscos adequados
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ],
        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ],

    // Capacidade para adicionar instâncias do bloco ao painel do usuário (My Home)
    'block/ifcare:myaddinstance' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'user' => CAP_ALLOW
        ],
        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ],

    // Capacidade para receber notificações de coletas criadas
    'block/ifcare:receivenotifications' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,  // CONTEXT_BLOCK também pode ser usado se preferir
        'archetypes' => [
            'student' => CAP_ALLOW,
            'teacher' => CAP_ALLOW,
        ],
    ],
];
