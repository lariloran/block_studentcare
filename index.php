<?php
require_once('../../config.php');
$PAGE->requires->css('/blocks/ifcare/styles.css');

$courseid = required_param('courseid', PARAM_INT);

// Verifica se o usuário está logado e tem acesso ao curso
require_login($courseid);

// Configura a página
$context = context_course::instance($courseid);
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/ifcare/index.php', array('courseid' => $courseid)));
$PAGE->set_title(get_string('pluginname', 'block_ifcare'));
$PAGE->set_heading(get_string('pluginname', 'block_ifcare'));

// Adiciona o cabeçalho da página
echo $OUTPUT->header();

// Container principal
echo html_writer::start_tag('div', ['class' => 'container-fluid']);

// Container do conteúdo
echo html_writer::start_tag('div', ['class' => 'row']);

// Alinhamento com o menu secundário
echo html_writer::start_tag('div', ['class' => 'col-md-12']);

// Função para criar a estrutura da seção
function create_section($id, $title, $content) {
    echo html_writer::start_tag('li', [
        'id' => "section-$id",
        'class' => 'section course-section main clearfix',
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
        'id' => "collapssesection$id",
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
    echo html_writer::end_tag('div'); // End course-section-header

    echo html_writer::start_tag('div', ['id' => "coursecontentcollapse$id", 'class' => 'content course-content-item-content collapse']);
    echo html_writer::start_tag('div', ['class' => 'my-3']);
    echo html_writer::tag('div', '', ['class' => 'section_availability']);
    echo html_writer::end_tag('div'); // End my-3

    echo html_writer::start_tag('ul', ['class' => 'section m-0 p-0 img-text d-block']);
    echo html_writer::start_tag('li', ['class' => 'activity activity-wrapper', 'id' => "module-$id"]);
    echo html_writer::start_tag('div', ['class' => 'activity-item focus-control']);
    echo html_writer::start_tag('div', ['class' => 'activity-grid']);
    echo html_writer::start_tag('div', ['class' => 'activity-icon activityiconcontainer smaller collaboration courseicon align-self-start mr-2']);
    echo html_writer::empty_tag('img', [
        'src' => 'http://localhost/theme/image.php/boost/forum/1723638691/monologo?filtericon=1',
        'class' => 'activityicon',
        'data-region' => 'activity-icon',
        'alt' => ''
    ]);
    echo html_writer::end_tag('div'); // End activity-icon

    echo html_writer::start_tag('div', ['class' => 'activity-name-area activity-instance d-flex flex-column mr-2']);
    echo html_writer::start_tag('div', ['class' => 'activitytitle modtype_forum position-relative align-self-start']);
    echo html_writer::start_tag('div', ['class' => 'activityname']);
    echo html_writer::link('', $content, ['class' => 'aalink stretched-link']);
    echo html_writer::end_tag('div'); // End activityname
    echo html_writer::end_tag('div'); // End activitytitle
    echo html_writer::end_tag('div'); // End activity-name-area
    echo html_writer::end_tag('div'); // End activity-grid
    echo html_writer::end_tag('div'); // End activity-item
    echo html_writer::end_tag('li'); // End activity-wrapper
    echo html_writer::end_tag('ul'); // End section
    echo html_writer::end_tag('div'); // End content
    echo html_writer::end_tag('div'); // End section-item
    echo html_writer::end_tag('li'); // End section
}

// Adiciona as seções
create_section(1, 'Cadastrar', 'Cadastrar Content');
create_section(2, 'Listar', 'Listar Content');

// Fecha o container
echo html_writer::end_tag('div'); // End col-md-12
echo html_writer::end_tag('div'); // End row
echo html_writer::end_tag('div'); // End container-fluid

// Adiciona o rodapé da página
echo $OUTPUT->footer();
?>
