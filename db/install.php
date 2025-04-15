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
 * Code to edit collection
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


/**
 * Need documentation.
 *
 */
function xmldb_block_studentcare_install() {
    global $DB;

    // AEQ CLASS INSERTS.
    $records_aeq_class = [
            (object) ['id' => 1, 'nome_classe' => 'class-related'],
            (object) ['id' => 2, 'nome_classe' => 'learning-related'],
            (object) ['id' => 3, 'nome_classe' => 'test-related']
    ];

    foreach ($records_aeq_class as $record) {
        $DB->insert_record('studentcare_classeaeq', $record);
    }

    // EMOTIONS-CLASS INSERTS.
    $records_emotions = [
            (object) ['id' => 1, 'classeaeq_id' => 1, 'nome' => 'enjoyment', 'txttooltip' => 'enjoyment-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 2, 'classeaeq_id' => 1, 'nome' => 'hope', 'txttooltip' => 'hope-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 3, 'classeaeq_id' => 1, 'nome' => 'pride', 'txttooltip' => 'pride-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 4, 'classeaeq_id' => 1, 'nome' => 'anger', 'txttooltip' => 'anger-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 5, 'classeaeq_id' => 1, 'nome' => 'anxiety', 'txttooltip' => 'anxiety-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 6, 'classeaeq_id' => 1, 'nome' => 'shame', 'txttooltip' => 'shame-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 7, 'classeaeq_id' => 1, 'nome' => 'hopelessness', 'txttooltip' => 'hopelessness-txttooltip',
                    'antes' => 1, 'durante' => 1, 'depois' => 1],
            (object) ['id' => 8, 'classeaeq_id' => 1, 'nome' => 'boredom', 'txttooltip' => 'boredom-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],

            (object) ['id' => 9, 'classeaeq_id' => 2, 'nome' => 'enjoyment', 'txttooltip' => 'enjoyment-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 10, 'classeaeq_id' => 2, 'nome' => 'hope', 'txttooltip' => 'hope-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 11, 'classeaeq_id' => 2, 'nome' => 'pride', 'txttooltip' => 'pride-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 12, 'classeaeq_id' => 2, 'nome' => 'anger', 'txttooltip' => 'anger-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 13, 'classeaeq_id' => 2, 'nome' => 'anxiety', 'txttooltip' => 'anxiety-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 14, 'classeaeq_id' => 2, 'nome' => 'shame', 'txttooltip' => 'shame-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 15, 'classeaeq_id' => 2, 'nome' => 'hopelessness', 'txttooltip' => 'hopelessness-txttooltip',
                    'antes' => 1, 'durante' => 1, 'depois' => 1],
            (object) ['id' => 16, 'classeaeq_id' => 2, 'nome' => 'boredom', 'txttooltip' => 'boredom-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],

            (object) ['id' => 17, 'classeaeq_id' => 3, 'nome' => 'enjoyment', 'txttooltip' => 'enjoyment-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 18, 'classeaeq_id' => 3, 'nome' => 'hope', 'txttooltip' => 'hope-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 19, 'classeaeq_id' => 3, 'nome' => 'pride', 'txttooltip' => 'pride-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 20, 'classeaeq_id' => 3, 'nome' => 'relief', 'txttooltip' => 'relief-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 21, 'classeaeq_id' => 3, 'nome' => 'anger', 'txttooltip' => 'anger-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 22, 'classeaeq_id' => 3, 'nome' => 'anxiety', 'txttooltip' => 'anxiety-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 23, 'classeaeq_id' => 3, 'nome' => 'shame', 'txttooltip' => 'shame-txttooltip', 'antes' => 1,
                    'durante' => 1, 'depois' => 1],
            (object) ['id' => 24, 'classeaeq_id' => 3, 'nome' => 'hopelessness', 'txttooltip' => 'hopelessness-txttooltip',
                    'antes' => 1, 'durante' => 1, 'depois' => 1]
    ];

    foreach ($records_emotions as $record) {
        $DB->insert_record('studentcare_emocao', $record);
    }

    $records_questions = [
            (object) ['id' => 1, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-1'],
            (object) ['id' => 2, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-2'],
            (object) ['id' => 3, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-3'],
            (object) ['id' => 4, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-4'],
            (object) ['id' => 5, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-5'],
            (object) ['id' => 6, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-6'],
            (object) ['id' => 7, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-7'],
            (object) ['id' => 8, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-8'],
            (object) ['id' => 9, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-9'],
            (object) ['id' => 10, 'emocao_id' => 1, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-enjoyment-10'],

            (object) ['id' => 11, 'emocao_id' => 2, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hope-1'],
            (object) ['id' => 12, 'emocao_id' => 2, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hope-2'],
            (object) ['id' => 13, 'emocao_id' => 2, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hope-3'],
            (object) ['id' => 14, 'emocao_id' => 2, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hope-4'],
            (object) ['id' => 15, 'emocao_id' => 2, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hope-5'],
            (object) ['id' => 16, 'emocao_id' => 2, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hope-6'],
            (object) ['id' => 17, 'emocao_id' => 2, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hope-7'],
            (object) ['id' => 18, 'emocao_id' => 2, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hope-8'],

            (object) ['id' => 19, 'emocao_id' => 3, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-pride-1'],
            (object) ['id' => 20, 'emocao_id' => 3, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-pride-2'],
            (object) ['id' => 21, 'emocao_id' => 3, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-pride-3'],
            (object) ['id' => 22, 'emocao_id' => 3, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-pride-4'],
            (object) ['id' => 23, 'emocao_id' => 3, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-pride-5'],
            (object) ['id' => 24, 'emocao_id' => 3, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-pride-6'],
            (object) ['id' => 25, 'emocao_id' => 3, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-pride-7'],
            (object) ['id' => 26, 'emocao_id' => 3, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-pride-8'],
            (object) ['id' => 27, 'emocao_id' => 3, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-pride-9'],

            (object) ['id' => 28, 'emocao_id' => 4, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anger-1'],
            (object) ['id' => 29, 'emocao_id' => 4, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anger-2'],
            (object) ['id' => 30, 'emocao_id' => 4, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anger-3'],
            (object) ['id' => 31, 'emocao_id' => 4, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anger-4'],
            (object) ['id' => 32, 'emocao_id' => 4, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anger-5'],
            (object) ['id' => 33, 'emocao_id' => 4, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anger-6'],
            (object) ['id' => 34, 'emocao_id' => 4, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anger-7'],
            (object) ['id' => 35, 'emocao_id' => 4, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anger-8'],
            (object) ['id' => 36, 'emocao_id' => 4, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anger-9'],

            (object) ['id' => 37, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-1'],
            (object) ['id' => 38, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-2'],
            (object) ['id' => 39, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-3'],
            (object) ['id' => 40, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-4'],
            (object) ['id' => 41, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-5'],
            (object) ['id' => 42, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-6'],
            (object) ['id' => 43, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-7'],
            (object) ['id' => 44, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-8'],
            (object) ['id' => 45, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-9'],
            (object) ['id' => 46, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-10'],
            (object) ['id' => 47, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-11'],
            (object) ['id' => 48, 'emocao_id' => 5, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-anxiety-12'],

            (object) ['id' => 49, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-1'],
            (object) ['id' => 50, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-2'],
            (object) ['id' => 51, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-3'],
            (object) ['id' => 52, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-4'],
            (object) ['id' => 53, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-5'],
            (object) ['id' => 54, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-6'],
            (object) ['id' => 55, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-7'],
            (object) ['id' => 56, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-8'],
            (object) ['id' => 57, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-9'],
            (object) ['id' => 58, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-10'],
            (object) ['id' => 59, 'emocao_id' => 6, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-shame-11'],

            (object) ['id' => 60, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-1'],
            (object) ['id' => 61, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-2'],
            (object) ['id' => 62, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-3'],
            (object) ['id' => 63, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-4'],
            (object) ['id' => 64, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-5'],
            (object) ['id' => 65, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-6'],
            (object) ['id' => 66, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-7'],
            (object) ['id' => 67, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-8'],
            (object) ['id' => 68, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-9'],
            (object) ['id' => 69, 'emocao_id' => 7, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-hopelessness-10'],

            (object) ['id' => 70, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-1'],
            (object) ['id' => 71, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-2'],
            (object) ['id' => 72, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-3'],
            (object) ['id' => 73, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-4'],
            (object) ['id' => 74, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-5'],
            (object) ['id' => 75, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-6'],
            (object) ['id' => 76, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-7'],
            (object) ['id' => 77, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-8'],
            (object) ['id' => 78, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-9'],
            (object) ['id' => 79, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-10'],
            (object) ['id' => 80, 'emocao_id' => 8, 'classeaeq_id' => 1, 'pergunta_texto' => 'class-related-boredom-11'],

            (object) ['id' => 158, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-1'],
            (object) ['id' => 159, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-2'],
            (object) ['id' => 160, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-3'],
            (object) ['id' => 161, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-4'],
            (object) ['id' => 162, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-5'],
            (object) ['id' => 163, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-6'],
            (object) ['id' => 164, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-7'],
            (object) ['id' => 165, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-8'],
            (object) ['id' => 166, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-9'],
            (object) ['id' => 167, 'emocao_id' => 9, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-enjoyment-10'],

            (object) ['id' => 168, 'emocao_id' => 10, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hope-1'],
            (object) ['id' => 169, 'emocao_id' => 10, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hope-2'],
            (object) ['id' => 170, 'emocao_id' => 10, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hope-3'],
            (object) ['id' => 171, 'emocao_id' => 10, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hope-4'],
            (object) ['id' => 172, 'emocao_id' => 10, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hope-5'],
            (object) ['id' => 173, 'emocao_id' => 10, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hope-6'],

            (object) ['id' => 175, 'emocao_id' => 11, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-pride-1'],
            (object) ['id' => 176, 'emocao_id' => 11, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-pride-2'],
            (object) ['id' => 177, 'emocao_id' => 11, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-pride-3'],
            (object) ['id' => 178, 'emocao_id' => 11, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-pride-4'],
            (object) ['id' => 179, 'emocao_id' => 11, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-pride-5'],

            (object) ['id' => 180, 'emocao_id' => 12, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anger-1'],
            (object) ['id' => 181, 'emocao_id' => 12, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anger-2'],
            (object) ['id' => 182, 'emocao_id' => 12, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anger-3'],
            (object) ['id' => 183, 'emocao_id' => 12, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anger-4'],
            (object) ['id' => 184, 'emocao_id' => 12, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anger-5'],
            (object) ['id' => 185, 'emocao_id' => 12, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anger-6'],
            (object) ['id' => 186, 'emocao_id' => 12, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anger-7'],
            (object) ['id' => 187, 'emocao_id' => 12, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anger-8'],
            (object) ['id' => 188, 'emocao_id' => 12, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anger-9'],

            (object) ['id' => 189, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-1'],
            (object) ['id' => 190, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-2'],
            (object) ['id' => 191, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-3'],
            (object) ['id' => 192, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-4'],
            (object) ['id' => 193, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-5'],
            (object) ['id' => 194, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-6'],
            (object) ['id' => 195, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-7'],
            (object) ['id' => 196, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-8'],
            (object) ['id' => 197, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-9'],
            (object) ['id' => 198, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-10'],
            (object) ['id' => 199, 'emocao_id' => 13, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-anxiety-11'],

            (object) ['id' => 200, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-1'],
            (object) ['id' => 201, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-2'],
            (object) ['id' => 202, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-3'],
            (object) ['id' => 203, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-4'],
            (object) ['id' => 204, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-5'],
            (object) ['id' => 205, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-6'],
            (object) ['id' => 206, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-7'],
            (object) ['id' => 207, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-8'],
            (object) ['id' => 208, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-9'],
            (object) ['id' => 209, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-10'],
            (object) ['id' => 210, 'emocao_id' => 14, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-shame-11'],

            (object) ['id' => 211, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-1'],
            (object) ['id' => 212, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-2'],
            (object) ['id' => 213, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-3'],
            (object) ['id' => 214, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-4'],
            (object) ['id' => 215, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-5'],
            (object) ['id' => 216, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-6'],
            (object) ['id' => 217, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-7'],
            (object) ['id' => 218, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-8'],
            (object) ['id' => 219, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-9'],
            (object) ['id' => 220, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-10'],
            (object) ['id' => 221, 'emocao_id' => 15, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-hopelessness-11'],

            (object) ['id' => 222, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-1'],
            (object) ['id' => 223, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-2'],
            (object) ['id' => 224, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-3'],
            (object) ['id' => 225, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-4'],
            (object) ['id' => 226, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-5'],
            (object) ['id' => 227, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-6'],
            (object) ['id' => 228, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-7'],
            (object) ['id' => 229, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-8'],
            (object) ['id' => 230, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-9'],
            (object) ['id' => 231, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-10'],
            (object) ['id' => 232, 'emocao_id' => 16, 'classeaeq_id' => 2, 'pergunta_texto' => 'learning-related-boredom-11'],

            (object) ['id' => 81, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-1'],
            (object) ['id' => 82, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-2'],
            (object) ['id' => 83, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-3'],
            (object) ['id' => 84, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-4'],
            (object) ['id' => 85, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-5'],
            (object) ['id' => 86, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-6'],
            (object) ['id' => 87, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-7'],
            (object) ['id' => 88, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-8'],
            (object) ['id' => 89, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-9'],
            (object) ['id' => 90, 'emocao_id' => 17, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-enjoyment-10'],

            (object) ['id' => 91, 'emocao_id' => 18, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hope-1'],
            (object) ['id' => 92, 'emocao_id' => 18, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hope-2'],
            (object) ['id' => 93, 'emocao_id' => 18, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hope-3'],
            (object) ['id' => 94, 'emocao_id' => 18, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hope-4'],
            (object) ['id' => 95, 'emocao_id' => 18, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hope-5'],
            (object) ['id' => 96, 'emocao_id' => 18, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hope-6'],
            (object) ['id' => 97, 'emocao_id' => 18, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hope-7'],
            (object) ['id' => 98, 'emocao_id' => 18, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hope-8'],

            (object) ['id' => 99, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-1'],
            (object) ['id' => 100, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-2'],
            (object) ['id' => 101, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-3'],
            (object) ['id' => 102, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-4'],
            (object) ['id' => 103, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-5'],
            (object) ['id' => 104, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-6'],
            (object) ['id' => 105, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-7'],
            (object) ['id' => 106, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-8'],
            (object) ['id' => 107, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-9'],
            (object) ['id' => 108, 'emocao_id' => 19, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-pride-10'],

            (object) ['id' => 109, 'emocao_id' => 20, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-relief-1'],
            (object) ['id' => 110, 'emocao_id' => 20, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-relief-2'],
            (object) ['id' => 111, 'emocao_id' => 20, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-relief-3'],
            (object) ['id' => 112, 'emocao_id' => 20, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-relief-4'],
            (object) ['id' => 113, 'emocao_id' => 20, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-relief-5'],
            (object) ['id' => 114, 'emocao_id' => 20, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-relief-6'],

            (object) ['id' => 115, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-1'],
            (object) ['id' => 116, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-2'],
            (object) ['id' => 117, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-3'],
            (object) ['id' => 118, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-4'],
            (object) ['id' => 119, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-5'],
            (object) ['id' => 120, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-6'],
            (object) ['id' => 121, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-7'],
            (object) ['id' => 122, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-8'],
            (object) ['id' => 123, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-9'],
            (object) ['id' => 124, 'emocao_id' => 21, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anger-10'],

            (object) ['id' => 125, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-1'],
            (object) ['id' => 126, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-2'],
            (object) ['id' => 127, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-3'],
            (object) ['id' => 128, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-4'],
            (object) ['id' => 129, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-5'],
            (object) ['id' => 130, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-6'],
            (object) ['id' => 131, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-7'],
            (object) ['id' => 132, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-8'],
            (object) ['id' => 133, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-9'],
            (object) ['id' => 134, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-10'],
            (object) ['id' => 135, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-11'],
            (object) ['id' => 136, 'emocao_id' => 22, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-anxiety-12'],

            (object) ['id' => 137, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-1'],
            (object) ['id' => 138, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-2'],
            (object) ['id' => 139, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-3'],
            (object) ['id' => 140, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-4'],
            (object) ['id' => 141, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-5'],
            (object) ['id' => 142, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-6'],
            (object) ['id' => 143, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-7'],
            (object) ['id' => 144, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-8'],
            (object) ['id' => 145, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-9'],
            (object) ['id' => 146, 'emocao_id' => 23, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-shame-10'],

            (object) ['id' => 147, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-1'],
            (object) ['id' => 148, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-2'],
            (object) ['id' => 149, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-3'],
            (object) ['id' => 150, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-4'],
            (object) ['id' => 151, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-5'],
            (object) ['id' => 152, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-6'],
            (object) ['id' => 153, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-7'],
            (object) ['id' => 154, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-8'],
            (object) ['id' => 155, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-9'],
            (object) ['id' => 156, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-10'],
            (object) ['id' => 157, 'emocao_id' => 24, 'classeaeq_id' => 3, 'pergunta_texto' => 'test-related-hopelessness-11'],
    ];

    foreach ($records_questions as $record) {
        $DB->insert_record('studentcare_pergunta', $record);
    }
}

