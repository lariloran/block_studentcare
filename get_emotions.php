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
