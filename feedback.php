<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * the first page to view the studentcare
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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
