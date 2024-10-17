<?php
require_once('../../config.php');

$courseid = required_param('courseid', PARAM_INT);
$userid = required_param('userid', PARAM_INT);
$coletaid = required_param('coletaid', PARAM_INT);

global $DB, $OUTPUT;

// Aqui você consulta as perguntas e as emoções associadas à coleta
$perguntas = $DB->get_records_sql("SELECT p.* FROM {ifcare_pergunta} p 
                                   JOIN {ifcare_associacao_classe_emocao_coleta} acec ON acec.emocao_id = p.emocao_id
                                   WHERE acec.cadastrocoleta_id = :coletaid", ['coletaid' => $coletaid]);

// Gera o HTML do chat para ser inserido no DOM
$html = '<div id="coletaChat" class="coleta-chat">';
$html .= '<div class="coleta-chat-header">Coleta de Emoções</div>';
$html .= '<div class="coleta-chat-body">';

foreach ($perguntas as $pergunta) {
    $html .= "<p>{$pergunta->pergunta_texto}</p>";
    $html .= '<div class="likert-scale">';
    for ($i = 1; $i <= 5; $i++) {
        $html .= "<label><input type='radio' name='resposta_{$pergunta->id}' value='{$i}'> {$i}</label>";
    }
    $html .= '</div>';
}

$html .= '</div>';
$html .= '<button onclick="submitRespostas()">Enviar Respostas</button>';
$html .= '</div>';

echo $html;
