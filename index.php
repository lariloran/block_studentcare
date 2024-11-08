<?php

require_once('../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once(__DIR__ . '/register_form.php');
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

function create_section($id, $title, $content) 
{
    global $SESSION;
    global $USER, $COURSE;

    if (isset($SESSION->mensagem_sucesso)) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo $SESSION->mensagem_sucesso;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>'; 
        echo '</button>';
        echo '</div>';
        unset($SESSION->mensagem_sucesso); 
    }
    
    if (isset($SESSION->mensagem_erro)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo $SESSION->mensagem_erro;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
        unset($SESSION->mensagem_erro); 
    }

    echo html_writer::start_tag('li', [
        'id' => "section-$id",
        'class' => 'section course-section main clearfix custom-width',
        'data-sectionid' => $id,
        'data-for' => 'section',
        'data-id' => $id,
        'data-number' => $id,
        'aria-busy' => 'false'
    ]);

    echo html_writer::start_tag('div', ['class' => 'section-item']);

    echo html_writer::start_tag('div', ['class' => 'course-section-header d-flex']);
    echo html_writer::start_tag('a', [
        'role' => 'button',
        'data-toggle' => 'collapse',
        'data-for' => 'sectiontoggler',
        'href' => "#coursecontentcollapse$id",
        'id' => "collapsesection$id",
        'aria-expanded' => 'false',
        'aria-controls' => "coursecontentcollapse$id",
        'class' => 'btn btn-icon mr-3 icons-collapse-expand justify-content-center collapsed',
        'aria-label' => $title
    ]);
    echo html_writer::start_tag('span', ['class' => 'expanded-icon icon-no-margin p-2', 'title' => 'Collapse']);
    echo html_writer::tag('i', '', ['class' => 'icon fa fa-chevron-down fa-fw', 'aria-hidden' => 'true']);
    echo html_writer::end_tag('span');
    echo html_writer::start_tag('span', ['class' => 'collapsed-icon icon-no-margin p-2', 'title' => 'Expand']);
    echo html_writer::start_tag('span', ['class' => 'dir-rtl-hide']);
    echo html_writer::tag('i', '', ['class' => 'icon fa fa-chevron-right fa-fw', 'aria-hidden' => 'true']);
    echo html_writer::end_tag('span');
    echo html_writer::start_tag('span', ['class' => 'dir-ltr-hide']);
    echo html_writer::tag('i', '', ['class' => 'icon fa fa-chevron-left fa-fw', 'aria-hidden' => 'true']);
    echo html_writer::end_tag('span');
    echo html_writer::end_tag('span');
    echo html_writer::end_tag('a');
    echo html_writer::tag('h3', html_writer::link('', $title, ['href' => '#']), [
        'class' => 'h4 sectionname course-content-item d-flex align-self-stretch align-items-center mb-0',
        'id' => "sectionid-$id-title"
    ]);
    echo html_writer::end_tag('div'); 

    echo html_writer::start_tag('div', ['id' => "coursecontentcollapse$id", 'class' => 'content course-content-item-content collapse']);
    echo html_writer::start_tag('div', ['class' => 'my-3']);
    echo html_writer::tag('div', '', ['class' => 'section_availability']);
    echo html_writer::end_tag('div'); 

if ($id == 1) { 
    $mform = new register_form();

    echo $mform->render();
    
 if ($data = $mform->get_data()) {
    $mform->process_form($data);
}

 else if ($mform->is_cancelled()) {

    }

} else if ($id == 2) { 
    $collectionManager = new collection_manager();

    $professor_id = $USER->id;

    $coletas_html = $collectionManager->listar_coletas($professor_id);
    echo $coletas_html; 

} else {
    echo $content; 
}
    
    echo html_writer::end_tag('div'); 
    echo html_writer::end_tag('div'); 
    echo html_writer::end_tag('li'); 
}


create_section(1, '<i class="fa fa-smile-o"></i> Nova Coleta de Emoções', '');

create_section(2, '<i class="fa fa-list"></i> Coletas cadastradas', '
    <ul>
        <li><i class="fa fa-file-text-o"></i> Item 1: Fake Content 1</li>
        <li><i class="fa fa-file-text-o"></i> Item 2: Fake Content 2</li>
    </ul>
');


echo html_writer::end_tag('div'); 
echo html_writer::end_tag('div'); 
echo html_writer::end_tag('div'); 

echo $OUTPUT->footer();
?>
