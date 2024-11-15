<?php

require_once('../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once(__DIR__ . '/edit_form.php');

require_login();

$coletaid = required_param('coletaid', PARAM_INT); // Obtém o ID da coleta via URL

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/ifcare/edit.php', ['coletaid' => $coletaid]));
$PAGE->set_title('Editar Coleta');
$PAGE->set_heading('Editar Coleta');

echo $OUTPUT->header();

// Renderiza o formulário de edição
try {
    $mform = new edit_form($coletaid);

    if ($mform->is_cancelled()) {
        // Redireciona para a página inicial do plugin se o formulário for cancelado
        redirect(new moodle_url('/blocks/ifcare/index.php'));
    } else if ($data = $mform->get_data()) {
        // Processa os dados do formulário
        $mform->process_form($data);

        // Redireciona com mensagem de sucesso
        global $SESSION;
        $SESSION->mensagem_sucesso = get_string('mensagem_sucesso', 'block_ifcare');
        redirect(new moodle_url('/blocks/ifcare/index.php'));
    }

    // Exibe o formulário
    $mform->display();
} catch (Exception $e) {
    echo $OUTPUT->notification($e->getMessage(), 'error');
    echo $OUTPUT->continue_button(new moodle_url('/blocks/ifcare/index.php'));
}

echo $OUTPUT->footer();

?>
