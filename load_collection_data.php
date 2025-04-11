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
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package block_studentcare
 */

require_once('../../config.php');

$coletaid = required_param('coletaid', PARAM_INT);

$emocao_respostas = $DB->get_records_sql("
    SELECT CONCAT(p.id, '-', r.resposta) AS unique_key, p.id AS pergunta_id, p.pergunta_texto, r.resposta, COUNT(r.id) as quantidade
    FROM {studentcare_resposta} r
    JOIN {studentcare_pergunta} p ON r.pergunta_id = p.id
    WHERE r.coleta_id = :coletaid
    GROUP BY p.id, p.pergunta_texto, r.resposta
    ORDER BY p.id, r.resposta
", ['coletaid' => $coletaid]);

if (empty($emocao_respostas)) {
    header('Content-Type: application/json');
    echo json_encode([
        'tabela_dados' => [],
        'chart_data' => ['labels' => [], 'datasets' => []],
        'moda_data' => ['labels' => [], 'data' => [], 'frequencies' => []]
    ]);
    exit;
}

$tabela_dados = [];
$labels = [];
$datasets = [
    ['label' => get_string('strongly_disagree', 'block_studentcare'), 'data' => [], 'backgroundColor' => 'rgba(255, 99, 132, 0.5)'],
    ['label' => get_string('disagree', 'block_studentcare'), 'data' => [], 'backgroundColor' => 'rgba(54, 162, 235, 0.5)'],
    ['label' => get_string('neutral', 'block_studentcare'), 'data' => [], 'backgroundColor' => 'rgba(255, 206, 86, 0.5)'],
    ['label' => get_string('agree', 'block_studentcare'), 'data' => [], 'backgroundColor' => 'rgba(75, 192, 192, 0.5)'],
    ['label' => get_string('strongly_agree', 'block_studentcare'), 'data' => [], 'backgroundColor' => 'rgba(153, 102, 255, 0.5)']
];

$moda_data = [];
$frequencies = [];

foreach ($emocao_respostas as $resposta) {
    $pergunta_id = $resposta->pergunta_id;
    $pergunta = (!empty($resposta->pergunta_texto) && get_string_manager()->string_exists($resposta->pergunta_texto, 'block_studentcare'))
    ? get_string($resposta->pergunta_texto, 'block_studentcare')
    : 'Texto não definido'; // Fallback para texto padrão
    $likert_value = $resposta->resposta;
    $quantidade = $resposta->quantidade;

    if (!isset($tabela_dados[$pergunta_id])) {
        $tabela_dados[$pergunta_id] = [0, 0, 0, 0, 0];
        $labels[$pergunta_id] = $pergunta;
    }
    $tabela_dados[$pergunta_id][$likert_value - 1] = $quantidade;
}

foreach ($tabela_dados as $pergunta_id => $respostas) {
    $moda = array_keys($respostas, max($respostas))[0] + 1;
    $frequencia_moda = max($respostas);
    $moda_data[] = $moda;
    $frequencies[] = $frequencia_moda;
}

foreach ($datasets as $index => &$dataset) {
    foreach ($labels as $pergunta_id => $pergunta_texto) {
        $dataset['data'][] = $tabela_dados[$pergunta_id][$index];
    }
}

header('Content-Type: application/json');
echo json_encode([
    'tabela_dados' => $tabela_dados,
    'chart_data' => [
        'labels' => array_values($labels),
        'datasets' => $datasets
    ],
    'moda_data' => [
        'labels' => array_values($labels),
        'data' => $moda_data,
        'frequencies' => $frequencies
    ]
]);
exit;
