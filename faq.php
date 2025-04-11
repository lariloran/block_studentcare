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
 * the first page to view the studentcare
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_login();

global $PAGE, $OUTPUT;

$courseid = optional_param('courseid', 0, PARAM_INT);
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/studentcare/faq.php');
$PAGE->set_title(get_string('faq', 'block_studentcare'));
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

echo '<style>
    .faq-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
 .faq-title {
    position: relative;
    font-family: "Roboto", sans-serif;
    font-size: 24px;
    color: #333;
    text-align: center; /* Centraliza o texto */
    margin-bottom: 20px; /* Adiciona espaço abaixo do título */

}

.faq-header .faq-title::after {
    content: "";
    display: block;
    width: 50%; /* Ajuste conforme necessário */
    margin: 10px auto 0; /* Margem para separar do texto */
    height: 4px;
    background: linear-gradient(90deg, #4caf50, #81c784); /* Gradiente de verde */
    border-radius: 2px; /* Bordas arredondadas */
}

    .faq-header h3 {
        font-size: 2em;
        color: #333;
    }
    .faq-search {
        margin-bottom: 20px;
        text-align: center;
    }
    .faq-search input {
        width: 80%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s;
    }
    .faq-search input:focus {
        border-color: #4CAF50;
        outline: none;
    }
    .faq-topics {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    .faq-topic {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        max-width: 300px;
        min-height: 200px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease;
        cursor: pointer;
    }
    .faq-topic:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
    }
    .faq-topic-icon {
        font-size: 50px;
        color: #4CAF50;
        margin-bottom: 10px;
    }
    .faq-topic-title {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    overflow-y: auto; /* Permite scroll para toda a janela, se necessário */
    padding-top: 20px; /* Adiciona um espaçamento superior geral */
}


.modal-content {
    position: relative;
    background-color: white;
    margin: 50px auto; /* Define uma margem superior mínima */
    padding: 30px;
    border-radius: 15px;
    width: 90%; /* Aumenta a largura para ocupar 90% da tela */
    max-width: 800px; /* Aumenta a largura máxima */
    max-height: 90vh; /* Limita a altura máxima */
    overflow-y: auto; /* Adiciona scroll para conteúdo longo */
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
}
    .modal-content h2 {
        font-size: 1.8em;
        color: #333;
        margin-bottom: 15px;
    }
    .modal-content p {
        font-size: 1.1em;
        color: #555;
        line-height: 1.6;
    }
    .modal-content ul {
        list-style-type: disc;
        padding-left: 20px;
    }
    .modal-content li {
        margin-bottom: 10px;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: #555;
        text-decoration: none;
        cursor: pointer;
    }
</style>';

echo html_writer::start_div('faq-container');

// Campo de busca com placeholder traduzido
echo html_writer::start_div('faq-search');
echo html_writer::empty_tag('input', array(
    'type' => 'text',
    'id' => 'faqSearch',
    'placeholder' => get_string('faq_search_placeholder', 'block_studentcare')
));
echo html_writer::end_div();

// Título da seção traduzido
echo html_writer::start_div('faq-header');
echo html_writer::tag('h3', get_string('faq_title', 'block_studentcare'), ['class' => 'faq-title']);
echo html_writer::end_div();

echo html_writer::start_div('faq-topics');

echo html_writer::start_div('faq-topic', array(
    'onclick' => 'openModal("' . get_string('faq_topic_title', 'block_studentcare') . '", `
        <div class="modal-header">
            <h2>' . get_string('faq_modal_header', 'block_studentcare') . '</h2>
        </div>
        <div class="modal-content-body">
            <p>' . get_string('faq_modal_body', 'block_studentcare') . '</p>
            <h3>' . get_string('faq_functionalities_title', 'block_studentcare') . '</h3>
            <ul>' . get_string('faq_functionalities_list', 'block_studentcare') . '</ul>
            <h3>' . get_string('faq_objective_title', 'block_studentcare') . '</h3>
            <p>' . get_string('faq_objective_text', 'block_studentcare') . '</p>
            <h3>' . get_string('faq_benefits_title', 'block_studentcare') . '</h3>
            <ul>' . get_string('faq_benefits_list', 'block_studentcare') . '</ul>
        </div>
    `)'
));

echo html_writer::tag('div', '🧠', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', get_string('faq_topic_title', 'block_studentcare'), array('class' => 'faq-topic-title'));
echo html_writer::end_div();


echo html_writer::start_div('faq-topic', array(
    'onclick' => 'openModal("' . get_string('faq_how_to_use_title', 'block_studentcare') . '", `

    <div class="modal-header">
        <h2><i class="fas fa-info-circle"></i> ' . get_string('faq_how_to_use_title', 'block_studentcare') . '</h2>
    </div>
    <p>' . get_string('faq_how_to_use_intro', 'block_studentcare') . '</p>

    <h3>' . get_string('faq_how_to_use_teacher_steps_title', 'block_studentcare') . '</h3>
    <ul>
        <li>' . get_string('faq_teacher_step_1', 'block_studentcare') . '</li>
        <li>' . get_string('faq_teacher_step_2', 'block_studentcare') . '</li>
        <li>' . get_string('faq_teacher_step_3', 'block_studentcare') . '</li>
        <li>' . get_string('faq_teacher_step_4', 'block_studentcare') . '</li>
        <li>' . get_string('faq_teacher_step_5', 'block_studentcare') . '</li>
    </ul>

    <h3>' . get_string('faq_after_registration_title', 'block_studentcare') . '</h3>
    <ul>
        <li>' . get_string('faq_after_registration_export', 'block_studentcare') . '</li>
        <li>' . get_string('faq_after_registration_graphs', 'block_studentcare') . '</li>
        <li>' . get_string('faq_after_registration_delete', 'block_studentcare') . '</li>
    </ul>

    <h3>' . get_string('faq_for_students_title', 'block_studentcare') . '</h3>
    <ul>
        <li>' . get_string('faq_students_notifications', 'block_studentcare') . '</li>
        <li>' . get_string('faq_students_answer', 'block_studentcare') . '</li>
        <li>' . get_string('faq_students_tcle', 'block_studentcare') . '</li>
    </ul>

    <h3>' . get_string('faq_additional_resources_title', 'block_studentcare') . '</h3>
    <ul>
        <li>' . get_string('faq_resources_manual', 'block_studentcare') . '</li>
        <li>' . get_string('faq_resources_auto_creation', 'block_studentcare') . '</li>
        <li>' . get_string('faq_resources_graphs', 'block_studentcare') . '</li>
    </ul>

    <p>' . get_string('faq_how_to_use_conclusion', 'block_studentcare') . '</p>
`)'
));



echo html_writer::tag('div', '📋', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', get_string('faq_how_to_use_title', 'block_studentcare'), array('class' => 'faq-topic-title'));
echo html_writer::end_div();


echo html_writer::start_div('faq-topic', array(
    'onclick' => 'openModal("' . get_string('faq_topic_functionalities_title', 'block_studentcare') . '", `
    <div class="modal-header">
        <h2><i class="fas fa-tools"></i> ' . get_string('faq_topic_functionalities_title', 'block_studentcare') . '</h2>
    </div>
    <div class="modal-content-body">
        <p>' . get_string('faq_topic_functionalities_description', 'block_studentcare') . '</p>
        ' . get_string('faq_topic_functionalities_list', 'block_studentcare') . '
        <p>' . get_string('faq_topic_functionalities_closing', 'block_studentcare') . '</p>
    </div>
    `)'
));

echo html_writer::tag('div', '🛠️', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', get_string('faq_topic_functionalities_title', 'block_studentcare'), array('class' => 'faq-topic-title'));
echo html_writer::end_div();




echo html_writer::start_div('faq-topic', array(
    'onclick' => 'openModal("' . get_string('faq_topic_developers_title', 'block_studentcare') . '", `
    <div class="modal-header">
        <h2><i class="fas fa-user-graduate"></i> ' . get_string('faq_topic_developers_title', 'block_studentcare') . '</h2>
    </div>
    <div class="modal-content-body">
        <p>' . get_string('faq_topic_developers_description', 'block_studentcare') . '</p>
        <h3><i class="fas fa-chalkboard-teacher"></i> ' . get_string('faq_topic_developers_guidance', 'block_studentcare') . '</h3>
        <p>' . get_string('faq_topic_developers_guidance_description', 'block_studentcare') . '</p>
        <h3><i class="fas fa-envelope"></i> ' . get_string('faq_topic_developers_contact', 'block_studentcare') . '</h3>
        <p>' . get_string('faq_topic_developers_contact_description', 'block_studentcare') . '</p>
        <ul>
            <li><a href="mailto:lariloran2@gmail.com">lariloran2@gmail.com</a></li>
        </ul>
    </div>
    `)'
));

echo html_writer::tag('div', '📟', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', get_string('faq_topic_developers_title', 'block_studentcare'), array('class' => 'faq-topic-title'));
echo html_writer::end_div();





echo html_writer::end_div();

echo '<div id="emotionModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitle"></h2>
        <p id="modalDescription"></p>
    </div>
</div>';

echo html_writer::script('function openModal(title, description) {
    document.getElementById("modalDescription").innerHTML = description;
    document.getElementById("emotionModal").style.display = "block";
}
document.querySelector(".close").onclick = function() {
    document.getElementById("emotionModal").style.display = "none";
};
window.onclick = function(event) {
    if (event.target == document.getElementById("emotionModal")) {
        document.getElementById("emotionModal").style.display = "none";
    }
}

document.getElementById("faqSearch").addEventListener("input", function() {
    var filter = this.value.toLowerCase();
    var topics = document.getElementsByClassName("faq-topic");
    for (var i = 0; i < topics.length; i++) {
        var title = topics[i].getElementsByClassName("faq-topic-title")[0].innerText.toLowerCase();
        var description = topics[i].getAttribute("onclick").toLowerCase();
        if (title.includes(filter) || description.includes(filter)) {
            topics[i].style.display = "block";
        } else {
            topics[i].style.display = "none";
        }
    }
});');

echo $OUTPUT->footer();
