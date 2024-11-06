<?php

require_once('../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once(__DIR__ . '/coleta/CadastrarForm.php');
require_once(__DIR__ . '/coleta/ColetaManager.php');

$courseid = optional_param('courseid', null, PARAM_INT);

// Verifica se o usuário está logado e tem acesso ao curso
require_login($courseid);

// Configura a página
$context = context_course::instance($courseid);
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/ifcare/index.php', array('courseid' => $courseid)));
$PAGE->set_title(get_string('header', 'block_ifcare'));

// Adiciona o cabeçalho da página
echo $OUTPUT->header();

// Container principal
echo html_writer::start_tag('div', ['class' => 'container-fluid']);

// Container do conteúdo
echo html_writer::start_tag('div', ['class' => 'row']);

// Alinhamento com o menu secundário
echo html_writer::start_tag('div', ['class' => 'col-md-12']);

function create_section($id, $title, $content, $courseid) 
{
    global $SESSION;
    global $USER, $COURSE;

    if (isset($SESSION->mensagem_sucesso)) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo $SESSION->mensagem_sucesso;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>'; // O "X" do botão
        echo '</button>';
        echo '</div>';
        unset($SESSION->mensagem_sucesso); // Limpa a mensagem da sessão
    }
    
    if (isset($SESSION->mensagem_erro)) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo $SESSION->mensagem_erro;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>'; // O "X" do botão
        echo '</button>';
        echo '</div>';
        unset($SESSION->mensagem_erro); // Limpa a mensagem da sessão
    }

    // Adiciona a classe custom-width para restringir a largura da seção
    echo html_writer::start_tag('li', [
        'id' => "section-$id",
        'class' => 'section course-section main clearfix custom-width', // Aqui, adicionamos 'custom-width'
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
    echo html_writer::end_tag('div'); // End course-section-header

    echo html_writer::start_tag('div', ['id' => "coursecontentcollapse$id", 'class' => 'content course-content-item-content collapse']);
    echo html_writer::start_tag('div', ['class' => 'my-3']);
    echo html_writer::tag('div', '', ['class' => 'section_availability']);
    echo html_writer::end_tag('div'); // End my-3

 // Conteúdo da seção
if ($id == 1) { // Se for a seção Cadastrar
    $mform = new CadastrarForm();

    // Exiba sempre o formulário sem processá-lo
    echo $mform->render();
    
 // Apenas processe os dados se o formulário for enviado
 if ($data = $mform->get_data()) {
    $mform->process_form($data);
}

 else if ($mform->is_cancelled()) {
        // Caso o formulário tenha sido cancelado
        // Você pode simplesmente não fazer nada ou exibir uma mensagem
        // echo 'Formulário cancelado'; // Opcional para depuração
    }

} else if ($id == 2) { // Se for a seção Listar
    // Instancia o gerenciador de coletas
    $coletaManager = new ColetaManager();

    // Obtem o professor_id e course_id
    $professor_id = $USER->id;
    $course_id = $COURSE->id;

    // Chama o método que lista as coletas e exibe o conteúdo
    $coletas_html = $coletaManager->listar_coletas($professor_id);
    echo $coletas_html; // Exibe as coletas cadastradas

} else {
    echo $content; // Para outras seções, apenas exibe o conteúdo padrão
}
    
    echo html_writer::end_tag('div'); // End content
    echo html_writer::end_tag('div'); // End section-item
    echo html_writer::end_tag('li'); // End section
}


// Adiciona a seção Cadastrar com formulário
create_section(1, '<i class="fa fa-smile-o"></i> Nova Coleta de Emoções', '', $courseid);

// Adiciona a seção Listar com dois itens fictícios
create_section(2, '<i class="fa fa-list"></i> Coletas cadastradas', '
    <ul>
        <li><i class="fa fa-file-text-o"></i> Item 1: Fake Content 1</li>
        <li><i class="fa fa-file-text-o"></i> Item 2: Fake Content 2</li>
    </ul>
',$courseid);


// Fecha o container
echo html_writer::end_tag('div'); // End col-md-12
echo html_writer::end_tag('div'); // End row
echo html_writer::end_tag('div'); // End container-fluid

// Adiciona o rodapé da página
echo $OUTPUT->footer();
?>