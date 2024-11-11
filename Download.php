<?php
require_once(__DIR__ . '/../../config.php'); 
require_once('collection_manager.php'); 

$coleta_id = required_param('coleta_id', PARAM_INT); 

require_login();

$courseid = optional_param('courseid', 0, PARAM_INT); 
if ($courseid) {
    $context = context_course::instance($courseid); 
} else {
    $context = context_system::instance(); 
}
$PAGE->set_context($context); 

ob_clean();

$manager = new collection_manager(); 

if (isset($_GET['format']) && $_GET['format'] === 'json') {
    $manager->download_json($coleta_id); 
} elseif (isset($_GET['format']) && $_GET['format'] === 'csv') {
    $manager->download_csv($coleta_id); 
} else {
    echo "Formato de download inválido.";
    exit();
}
?>
