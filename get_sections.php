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

$courseid = required_param('courseid', PARAM_INT);

$modinfo = get_fast_modinfo($courseid);
$sections = $modinfo->get_section_info_all(); 
$response = ['sections' => []]; 

foreach ($sections as $section) {
    if ($section->uservisible) {
        $sectionname = get_section_name($courseid, $section->section);
        $response['sections'][] = [
            'value' => $section->section,
            'name' => $sectionname
        ];
    }
}

echo json_encode($response);
exit;
