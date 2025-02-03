<?php

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

// Listagem de coletas com o card de criação
$collectionManager = new collection_manager();
$usuario_id = $USER->id;
echo $collectionManager->listar_coletas($usuario_id);

echo html_writer::end_tag('div');
echo html_writer::end_tag('div');
echo html_writer::end_tag('div');

echo $OUTPUT->footer();
?>
