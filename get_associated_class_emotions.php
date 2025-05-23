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
 * Get class emotions
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('collection_manager.php');

require_login();

$coletaid = required_param('coleta_id', PARAM_INT);

try {
    $manager = new collection_manager();
    $emocoesclasses = $manager->obter_emocoes_e_classes($coletaid);

    if (empty($emocoesclasses)) {
        echo get_string('noemotion', 'block_studentcare');
        exit;
    }

    $output = '';
    foreach ($emocoesclasses as $item) {
        $emotions = explode(', ', $item->emocoes);
        $output .= '<p><strong>' . s(get_string($item->nome_classe, 'block_studentcare')) . ':</strong> ';
        foreach ($emotions as $emotion) {
            $output .= get_string($emotion, 'block_studentcare') . ', ';
        }
        $output .= '</p>';
    }
    echo $output;
} catch (Exception $e) {
    echo '<p>Erro ao carregar emoções e classes AEQ: ' . s($e->getMessage()) . '</p>';
}

exit;
