<?php
require_once('../../config.php');
require_login();

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['coleta_id']) && isset($data['usuario_id']) && isset($data['feedback'])) {
    try {
        $coletaid = clean_param($data['coleta_id'], PARAM_INT);
        $usuarioid = clean_param($data['usuario_id'], PARAM_INT);
        $feedback = clean_param($data['feedback'], PARAM_TEXT);

        $feedbackExistente = $DB->get_record('studentcare_feedback', [
            'coleta_id' => $coletaid,
            'usuario_id' => $usuarioid
        ]);

        if ($feedbackExistente) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Você já enviou feedback para esta coleta.']);
            exit;
        }

        $novo_feedback = new stdClass();
        $novo_feedback->coleta_id = $coletaid;
        $novo_feedback->usuario_id = $usuarioid;
        $novo_feedback->feedback = $feedback;
        $novo_feedback->data_feedback = date('Y-m-d H:i:s');

        $DB->insert_record('studentcare_feedback', $novo_feedback);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;

    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit;
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Dados incompletos.']);
    exit;
}
?>
