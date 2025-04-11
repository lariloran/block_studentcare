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
require_once('collection_manager.php'); 

require_login();

$coleta_id = required_param('coleta_id', PARAM_INT);

try {
    $manager = new collection_manager();
    $emocoes_classes = $manager->obter_emocoes_e_classes($coleta_id);

    if (empty($emocoes_classes)) {
        echo get_string('noemotion', 'block_studentcare');
        exit;
    }

    $output = '';
    foreach ($emocoes_classes as $item) {
        $output .= '<p><strong>' . s(get_string($item->nome_classe, 'block_studentcare')) . ':</strong> ' . s(get_string($item->emocoes, 'block_studentcare')) . '</p>';
    }

    echo $output;
} catch (Exception $e) {
    echo '<p>Erro ao carregar emoções e classes AEQ: ' . s($e->getMessage()) . '</p>';
}

exit;
