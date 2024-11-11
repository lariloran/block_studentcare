<?php
require_once('../../config.php');
require_once('collection_manager.php'); 

require_login();

$coleta_id = required_param('coleta_id', PARAM_INT);
$collection_manager = new collection_manager();
$collection_manager->excluir_coleta($coleta_id);
echo json_encode(['status' => 'success']);
exit;
?>
