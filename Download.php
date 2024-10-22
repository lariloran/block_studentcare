<?php
require_once(__DIR__ . '/../../config.php'); // Inclui o arquivo de configuração do Moodle
require_once('coleta/ColetaManager.php'); // Inclui o arquivo ColetaManager.php

$coleta_id = required_param('coleta_id', PARAM_INT); // Obter o ID da coleta

// Certifique-se de que o usuário está logado
require_login();

// Define o contexto da página. Se você está baixando dados de uma coleta de um curso, defina o contexto do curso.
$courseid = optional_param('courseid', 0, PARAM_INT); // Obtém o ID do curso (caso exista)
if ($courseid) {
    $context = context_course::instance($courseid); // Define o contexto do curso
} else {
    $context = context_system::instance(); // Caso não haja curso, use o contexto do sistema
}
$PAGE->set_context($context); // Define o contexto da página

// Limpa qualquer saída anterior antes de enviar os cabeçalhos para download
ob_clean();

// Instancia o ColetaManager
$manager = new ColetaManager(); // Use $manager ao invés de $coletaManager

// Verifica o formato de download e chama o método apropriado
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    $manager->download_json($coleta_id); // Chama o método para baixar em JSON
} else {
    $manager->download_csv($coleta_id); // Chama o método para baixar em CSV
}
