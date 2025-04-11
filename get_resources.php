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

$courseid = required_param('courseid', PARAM_INT);
$sectionnum = required_param('sectionid', PARAM_INT);

$response = ['resources' => []]; 

try {
    $modinfo = get_fast_modinfo($courseid);

    if (!isset($modinfo->get_sections()[$sectionnum])) {
        throw new Exception("Não há atividade/recurso nesta seção.");
    }

    $section_modules = $modinfo->get_sections()[$sectionnum];

    $default_option = [
        'value' => '',
        'name' => get_string('dontlink', 'block_studentcare')
    ];
    $response['resources'][] = $default_option;

    $resources = []; 
    foreach ($section_modules as $cmid) {
        $mod = $modinfo->cms[$cmid];
        
        if ($mod->uservisible) {
            $resources[] = [
                'value' => $cmid,
                'name' => $mod->name
            ];
        }
    }

    usort($resources, function ($a, $b) {
        return strcmp($a['name'], $b['name']);
    });

    $response['resources'] = array_merge([$default_option], $resources);
} catch (Exception $e) {
    $response['resources'][] = [
        'value' => '',
        'name' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;
