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
 * Index page
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$coletaid = required_param('coletaid', PARAM_INT);

$emocaorespostas = $DB->get_records_sql("
    SELECT CONCAT(p.id, '-', r.resposta) AS unique_key, p.id AS pergunta_id, p.pergunta_texto, r.resposta, COUNT(r.id) as quantidade
    FROM {studentcare_resposta} r
    JOIN {studentcare_pergunta} p ON r.pergunta_id = p.id
    WHERE r.coleta_id = :coletaid
    GROUP BY p.id, p.pergunta_texto, r.resposta
    ORDER BY p.id, r.resposta
", ['coletaid' => $coletaid]);

if (empty($emocaorespostas)) {
    header('Content-Type: application/json');
    echo json_encode([
            'tabela_dados' => [],
            'chart_data' => ['labels' => [], 'datasets' => []],
            'moda_data' => ['labels' => [], 'data' => [], 'frequencies' => []],
    ]);
    exit;
}

$tabeladados = [];
$labels = [];
$datasets = [
        ['label' => get_string('strongly_disagree', 'block_studentcare'), 'data' => [],
                'backgroundColor' => 'rgba(255, 99, 132, 0.5)'],
        ['label' => get_string('disagree', 'block_studentcare'), 'data' => [], 'backgroundColor' => 'rgba(54, 162, 235, 0.5)'],
        ['label' => get_string('neutral', 'block_studentcare'), 'data' => [], 'backgroundColor' => 'rgba(255, 206, 86, 0.5)'],
        ['label' => get_string('agree', 'block_studentcare'), 'data' => [], 'backgroundColor' => 'rgba(75, 192, 192, 0.5)'],
        ['label' => get_string('strongly_agree', 'block_studentcare'), 'data' => [],
                'backgroundColor' => 'rgba(153, 102, 255, 0.5)'],
];

$modadata = [];
$frequencies = [];

foreach ($emocaorespostas as $resposta) {
    $perguntaid = $resposta->pergunta_id;
    $pergunta = (!empty($resposta->pergunta_texto) &&
            get_string_manager()->string_exists($resposta->pergunta_texto, 'block_studentcare'))
            ? get_string($resposta->pergunta_texto, 'block_studentcare')
            : 'Texto não definido'; // Fallback para texto padrão
    $likertvalue = $resposta->resposta;
    $quantidade = $resposta->quantidade;

    if (!isset($tabeladados[$perguntaid])) {
        $tabeladados[$perguntaid] = [0, 0, 0, 0, 0];
        $labels[$perguntaid] = $pergunta;
    }
    $tabeladados[$perguntaid][$likertvalue - 1] = $quantidade;
}

foreach ($tabeladados as $perguntaid => $respostas) {
    $moda = array_keys($respostas, max($respostas))[0] + 1;
    $frequenciamoda = max($respostas);
    $modadata[] = $moda;
    $frequencies[] = $frequenciamoda;
}

foreach ($datasets as $index => &$dataset) {
    foreach ($labels as $perguntaid => $perguntatexto) {
        $dataset['data'][] = $tabeladados[$perguntaid][$index];
    }
}

header('Content-Type: application/json');
echo json_encode([
        'tabela_dados' => $tabeladados,
        'chart_data' => [
                'labels' => array_values($labels),
                'datasets' => $datasets,
        ],
        'moda_data' => [
                'labels' => array_values($labels),
                'data' => $modadata,
                'frequencies' => $frequencies,
        ],
]);
exit;
