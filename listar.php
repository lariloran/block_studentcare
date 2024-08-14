<?php
require_once('../../config.php');

$courseid = required_param('courseid', PARAM_INT);

// Verifica se o usuário está logado e tem acesso ao curso
require_login($courseid);

// Configura a página
$context = context_course::instance($courseid);
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/ifcare/listar.php', array('courseid' => $courseid)));
$PAGE->set_title(get_string('listar', 'block_ifcare'));
$PAGE->set_heading(get_string('listar', 'block_ifcare'));

// Adiciona o cabeçalho da página
echo $OUTPUT->header();

// Exibe a lista (isso é um exemplo, você deve substituir pelo seu código para listar os dados)
echo html_writer::tag('h2', get_string('list_of_entries', 'block_ifcare'));
// Aqui você pode adicionar código para exibir a lista de entradas

// Adiciona o rodapé da página
echo $OUTPUT->footer();
?>
