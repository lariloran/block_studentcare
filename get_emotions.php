<?php
require_once('../../config.php');
require_login();

$classeaeqid = required_param('classeaeqid', PARAM_INT);

global $DB;
$response = ['emotions' => []]; 
$emotions = $DB->get_records('studentcare_emocao', array('classeaeq_id' => $classeaeqid), '', 'id, nome');

foreach ($emotions as $emotion) {
    $response['emotions'][] = [
        'value' => $emotion->id,
        'name' => get_string($emotion->nome, 'block_studentcare')
    ];
}

echo json_encode($response);
exit;
