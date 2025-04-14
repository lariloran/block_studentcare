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
require_once(__DIR__ . '/collection_manager.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/studentcare/index.php'));
$PAGE->set_title(get_string('header', 'block_studentcare'));


echo $OUTPUT->header();

echo '<div id="confirmation-delete" style="display: none;" 
    data-message-delete="' . get_string('confirm_message_delete', 'block_studentcare') . '"
    data-title="' . get_string('confirm_title', 'block_studentcare') . '"
    data-yes="' . get_string('confirm_button_yes', 'block_studentcare') . '"
    data-no="' . get_string('confirm_button_no', 'block_studentcare') . '"
>
</div>';



$PAGE->requires->js(new moodle_url('/blocks/studentcare/js/shared.js'));


echo html_writer::start_tag('div', ['class' => 'container-fluid']);
echo html_writer::start_tag('div', ['class' => 'row']);
echo html_writer::start_tag('div', ['class' => 'col-md-12']);

// Listagem de coletas com o card de criação.
$collectionManager = new collection_manager();
$usuarioid = $USER->id;
echo $collectionManager->listar_coletas($usuarioid);

echo html_writer::end_tag('div');
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');

echo $OUTPUT->footer();
