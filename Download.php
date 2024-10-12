<?php
require_once('coleta/ColetaManager.php');
require_once(__DIR__ . '/../../config.php'); // Ajuste conforme a localização do seu arquivo

$coleta_id = required_param('coleta_id', PARAM_INT); // Obter o ID da coleta

$manager = new ColetaManager();
$manager->download_csv($coleta_id);
