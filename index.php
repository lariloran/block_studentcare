<?php

require_once('../../config.php');
require_once(__DIR__ . '/collection_manager.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/ifcare/index.php'));
$PAGE->set_title(get_string('header', 'block_ifcare'));

echo $OUTPUT->header();

echo html_writer::start_tag('div', ['class' => 'container-fluid']);
echo html_writer::start_tag('div', ['class' => 'row']);
echo html_writer::start_tag('div', ['class' => 'col-md-12']);

// Listagem de coletas com o card de criação
$collectionManager = new collection_manager();
$professor_id = $USER->id;
echo $collectionManager->listar_coletas($professor_id);

echo html_writer::end_tag('div');
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');

echo $OUTPUT->footer();
?>
