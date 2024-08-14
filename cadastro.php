<?php
require_once('../../config.php');
require_once('ifcare_form.php');

$courseid = required_param('courseid', PARAM_INT);

// Verifica se o usuário está logado e tem acesso ao curso
require_login($courseid);

// Configura a página
$context = context_course::instance($courseid);
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/ifcare/cadastro.php', array('courseid' => $courseid)));
$PAGE->set_title(get_string('cadastrar', 'block_ifcare'));
$PAGE->set_heading(get_string('cadastrar', 'block_ifcare'));

// Cria o formulário
$mform = new ifcare_form();

// Processa os dados do formulário se o formulário for enviado e validado
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/blocks/ifcare/index.php', array('courseid' => $courseid)));
} else if ($data = $mform->get_data()) {
    // Processa os dados do formulário (salva em banco de dados ou outro lugar)
    redirect(new moodle_url('/blocks/ifcare/index.php', array('courseid' => $courseid)), get_string('thanks', 'block_ifcare'));
}

// Exibe o formulário na página
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
?>
