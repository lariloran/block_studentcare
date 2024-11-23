<?php

require_once('../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once(__DIR__ . '/register_form.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/ifcare/register.php'));
$PAGE->set_title('Adicionar Nova Coleta');
$PAGE->set_heading('Nova Coleta');


// Renderiza o formulário
$mform = new register_form();

if ($mform->is_cancelled()) {
    // Redireciona para a página inicial do plugin
    redirect(new moodle_url('/blocks/ifcare/index.php'));
} else if ($data = $mform->get_data()) {
    // Processa os dados do formulário
    $mform->process_form($data);

    // Redireciona com mensagem de sucesso
    global $SESSION;
    $SESSION->mensagem_sucesso = get_string('mensagem_sucesso', 'block_ifcare');
    redirect(new moodle_url('/blocks/ifcare/index.php'));
}

echo $OUTPUT->header();

// Exibe o formulário
$mform->display();

echo $OUTPUT->footer();

?>
