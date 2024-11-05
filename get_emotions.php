<?php
require_once('../../config.php');
require_login();

$classeaeqid = required_param('classeaeqid', PARAM_INT);

global $DB;
$response = ['emotions' => []]; // Inicialize o array de resposta com 'emotions'

// Obtenha as emoções com base no ID da classe AEQ
$emotions = $DB->get_records('ifcare_emocao', array('classeaeq_id' => $classeaeqid), '', 'id, nome');

// Estruture cada emoção como um objeto no array 'emotions'
foreach ($emotions as $emotion) {
    $response['emotions'][] = [
        'value' => $emotion->id,
        'name' => $emotion->nome
    ];
}

// Retorne a resposta formatada como JSON
echo json_encode($response);
exit;
