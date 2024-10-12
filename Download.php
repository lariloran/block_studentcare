<?php
require_once('coleta/ColetaManager.php');
require_once(__DIR__ . '/../../config.php'); // Ajuste conforme a localização do seu arquivo

$coleta_id = required_param('coleta_id', PARAM_INT); // Obter o ID da coleta

$manager = new ColetaManager(); // Use $manager ao invés de $coletaManager

// Verifica o formato de download e chama o método apropriado
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    $manager->download_json($coleta_id); // Chama o método para baixar em JSON
} else {
    $manager->download_csv($coleta_id); // Chama o método para baixar em CSV
}
