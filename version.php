<?php
defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2024011830; // Número da versão do plugin
$plugin->requires  = 2023061300; // Requer Moodle 4.4.1+
$plugin->component = 'block_ifcare';
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = 'Version 1.0.61 (Build 2024011811)';
$plugin->cron = 60; // Tempo em segundos para rodar o cron (a cada minuto).
