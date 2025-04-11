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

require_once(__DIR__ . '/../../config.php');
require_once('collection_manager.php');

$coleta_id = required_param('coleta_id', PARAM_INT);

require_login();

$courseid = optional_param('courseid', 0, PARAM_INT);
if ($courseid) {
    $context = context_course::instance($courseid);
} else {
    $context = context_system::instance();
}
$PAGE->set_context($context);

ob_clean();

$manager = new collection_manager();

if (isset($_GET['format']) && $_GET['format'] === 'json') {
    $manager->download_json($coleta_id);
} elseif (isset($_GET['format']) && $_GET['format'] === 'csv') {
    $manager->download_csv($coleta_id);
} else {
    echo "Formato de download inválido.";
    exit();
}
?>
