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

require_once('../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once(__DIR__ . '/edit_form.php');

require_login();

// Obtém o ID da coleta a ser editada.
$coletaid = required_param('coletaid', PARAM_INT);

// Verifica se o ID da coleta é válido.
if (!$coletaid || !is_numeric($coletaid)) {
    print_error('invalidcoletaid', 'block_studentcare');
}

// Carrega o registro da coleta para validação e contexto.
$coleta = $DB->get_record('studentcare_cadastrocoleta', ['id' => $coletaid], '*', MUST_EXIST);

// Configuração de contexto (ajusta para o curso da coleta, se aplicável).
$context = context_system::instance(); // Contexto padrão.
if (!empty($coleta->curso_id)) {
    $context = context_course::instance($coleta->curso_id);
}
$PAGE->set_context($context);

// Configuração da página.
$PAGE->set_url(new moodle_url('/blocks/studentcare/edit.php', ['coletaid' => $coletaid]));
$PAGE->set_title(get_string('editcoleta', 'block_studentcare') . ": " . format_string($coleta->nome));
// $PAGE->set_heading(get_string('editcoleta', 'block_studentcare') . " - " . format_string($coleta->nome));.

// Verifica se a coleta já foi iniciada.
$coletainiciada = strtotime($coleta->data_inicio) <= time();

// Cabeçalho da página.
echo $OUTPUT->header();

// Exibe subtítulo ou informações adicionais.
echo html_writer::tag('h2', get_string('editcoleta_subtitle', 'block_studentcare', format_string($coleta->nome)),
    ['class' => 'coleta-subtitle']);

// Exibe uma mensagem de aviso se a coleta já foi iniciada.
if ($coletainiciada) {
    echo $OUTPUT->notification(
        get_string('coleta_limitada_aviso', 'block_studentcare', [
            'listagemurl' => new moodle_url('/blocks/studentcare/index.php'),
            'datainicio' => userdate(strtotime($coleta->data_inicio)),
        ]),
        'info'
    );
}

// Renderiza o formulário de edição.
try {
    $mform = new edit_form($coletaid);

    if ($mform->is_cancelled()) {
        // Redireciona ao cancelar.
        redirect(new moodle_url('/blocks/studentcare/index.php'));
    } else if ($data = $mform->get_data()) {
        // Processa o formulário.
        $mform->process_form($data);

        // Define mensagem de sucesso.
        $SESSION->mensagem_sucesso = get_string('coleta_atualizada_com_sucesso', 'block_studentcare');
        redirect(new moodle_url('/blocks/studentcare/index.php'));
    }

    // Exibe o formulário.
    $mform->display();
} catch (Exception $e) {
    // Exibe mensagem de erro no caso de exceção
    echo $OUTPUT->notification($e->getMessage(), 'error');
    echo $OUTPUT->continue_button(new moodle_url('/blocks/studentcare/index.php'));
}

// Rodapé da página.
echo $OUTPUT->footer();
