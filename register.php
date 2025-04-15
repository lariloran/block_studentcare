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
 * faq javascript
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once(__DIR__ . '/register_form.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/studentcare/register.php'));
$PAGE->set_title( get_string('add-collection', 'block_studentcare'));
$PAGE->set_heading( get_string('add-collection', 'block_studentcare'));


// Renderiza o formulário
$mform = new register_form();

if ($mform->is_cancelled()) {
    // Redireciona para a página inicial do plugin
    redirect(new moodle_url('/blocks/studentcare/index.php'));
} else if ($data = $mform->get_data()) {
    // Processa os dados do formulário
    $mform->process_form($data);

    // Redireciona com mensagem de sucesso
    global $SESSION;
    $SESSION->mensagem_sucesso = get_string('mensagem_sucesso', 'block_studentcare');
    redirect(new moodle_url('/blocks/studentcare/index.php'));
}

echo $OUTPUT->header();

// Exibe o formulário
$mform->display();

echo $OUTPUT->footer();
