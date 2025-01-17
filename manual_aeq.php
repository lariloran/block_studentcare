<?php
require_once('../../config.php');
require_login();

global $PAGE, $OUTPUT;

$courseid = optional_param('courseid', 0, PARAM_INT);
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/studentcare/manual_aeq.php');
$PAGE->set_title(get_string('manual_aeq', 'block_studentcare'));
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

echo '<style>
    .manual_aeq-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
 .manual_aeq-title {
    position: relative;
    font-family: "Roboto", sans-serif;
    font-size: 24px;
    color: #333;
    text-align: center; /* Centraliza o texto */
    margin-bottom: 20px; /* Adiciona espaço abaixo do título */

}

.manual_aeq-header .manual_aeq-title::after {
    content: "";
    display: block;
    width: 50%; /* Ajuste conforme necessário */
    margin: 10px auto 0; /* Margem para separar do texto */
    height: 4px;
    background: linear-gradient(90deg, #4caf50, #81c784); /* Gradiente de verde */
    border-radius: 2px; /* Bordas arredondadas */
}

    .manual_aeq-header h3 {
        font-size: 2em;
        color: #333;
    }
    .manual_aeq-search {
        margin-bottom: 20px;
        text-align: center;
    }
    .manual_aeq-search input {
        width: 80%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: border-color 0.3s;
    }
    .manual_aeq-search input:focus {
        border-color: #4CAF50;
        outline: none;
    }
    .manual_aeq-topics {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }
    .manual_aeq-topic {
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
    .manual_aeq-topic:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
    }
    .manual_aeq-topic-icon {
        font-size: 50px;
        color: #4CAF50;
        margin-bottom: 10px;
    }
    .manual_aeq-topic-title {
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
.modal-content h3, .modal-content h4, .modal-content h5 {
    margin-bottom: 10px;
    color: #333;
}
.modal-content ul {
    list-style-type: decimal;
    padding-left: 20px;
    margin-bottom: 20px;
}
.modal-content li {
    margin-bottom: 5px;
}

.accordion {
    font-family: "Roboto", sans-serif;
    font-size: 16px;
}
.accordion summary {
    cursor: pointer;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px; /* Adiciona um espaçamento inferior */
}

.accordion details {
    margin-bottom: 20px; /* Espaçamento geral entre os detalhes */
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    background: #f9f9f9;
}

.accordion .accordion-content {
    margin-top: 0px; /* Espaçamento entre o resumo e o conteúdo expandido */
}


.accordion summary:hover {
    color: #4CAF50;
}

.accordion .accordion-list {
    margin: 15px 0 0 20px;
    list-style: none;
    padding: 0;
}

.accordion .accordion-list li {
    margin-bottom: 5px;
    color: #555;
}
</style>';

global $DB;

// Consulta SQL para buscar perguntas, emoções e classes AEQ, ordenadas pelo ID da classe AEQ
$sql = "SELECT 
            p.id AS pergunta_id, -- Coluna única
            c.id AS classe_id, -- ID da classe para ordenação
            c.nome_classe AS classe_nome,
            e.nome AS emocao_nome,
            p.pergunta_texto 
        FROM {studentcare_pergunta} p
        JOIN {studentcare_emocao} e ON p.emocao_id = e.id
        JOIN {studentcare_classeaeq} c ON p.classeaeq_id = c.id
        ORDER BY c.id, e.nome, p.id"; // Ordenar pelo ID da classe, depois pela emoção e pela pergunta

$perguntas = $DB->get_records_sql($sql);

$dados_organizados = [];
foreach ($perguntas as $pergunta) {
    $classe = $pergunta->classe_nome;
    $emocao = $pergunta->emocao_nome;
    if (!empty($pergunta->pergunta_texto) && get_string_manager()->string_exists($pergunta->pergunta_texto, 'block_studentcare')) {
        $texto = get_string($pergunta->pergunta_texto, 'block_studentcare');
    } else {
        $texto = 'Texto não definido'; // Texto padrão ou mensagem de fallback
    }
        

    if (!isset($dados_organizados[$classe])) {
        $dados_organizados[$classe] = [];
    }
    if (!isset($dados_organizados[$classe][$emocao])) {
        $dados_organizados[$classe][$emocao] = [];
    }
    $dados_organizados[$classe][$emocao][] = $texto;
}

echo html_writer::start_div('manual_aeq-container');

echo html_writer::start_div('manual_aeq-search');
echo html_writer::empty_tag('input', array(
    'type' => 'text', 
    'id' => 'manual_aeqSearch', 
    'placeholder' => get_string('manual_aeq_search_placeholder', 'block_studentcare')
));
echo html_writer::end_div();

echo html_writer::start_div('manual_aeq-header');
echo html_writer::tag('h3', get_string('manual_aeq_title', 'block_studentcare'), ['class' => 'manual_aeq-title']);
echo html_writer::end_div();

echo html_writer::start_div('manual_aeq-topics');


function render_acordion($dados) {
    $html = '<div class="accordion">';
    foreach ($dados as $classe => $emocoes) {
        // Nível 1: Classe
        $html .= '<details class="accordion-class">';
        $html .= '<summary class="accordion-summary">' . htmlspecialchars($classe) . '</summary>';
        $html .= '<div class="accordion-content">';
        foreach ($emocoes as $emocao => $perguntas) {
            // Nível 2: Emoção
            $html .= '<details class="accordion-emotion">';
            $html .= '<summary class="accordion-summary">' . htmlspecialchars($emocao) . '</summary>';
            $html .= '<ul class="accordion-list">';
            foreach ($perguntas as $index => $pergunta) {
                // Adiciona o índice antes da pergunta
                $index++;
                $pergunta_texto = htmlspecialchars($pergunta);
                $html .= "<li>{$index} - {$pergunta_texto}</li>";
            }
            $html .= '</ul>';
            $html .= '</details>';
        }
        $html .= '</div>';
        $html .= '</details>';
    }
    $html .= '</div>';
    return $html;
}

echo html_writer::start_div('manual_aeq-topic', array(
    'onclick' => 'openModal("", ` 
    <div class="modal-header">
        <h2><i class="fas fa-question-circle"></i> ' . get_string('start_here_title', 'block_studentcare') . '</h2>
    </div>
    <div class="modal-content-body">
        <p>' . get_string('start_here_description', 'block_studentcare') . '</p>
        <h3><i class="fas fa-cogs"></i> ' . get_string('how_it_works', 'block_studentcare') . '</h3>
        <p>' . get_string('start_here_questionnaire_description', 'block_studentcare') . '</p>
        <ul>
            <li><strong>' . get_string('emotion_classrooms', 'block_studentcare') . '</strong>: ' . get_string('emotion_classrooms_description', 'block_studentcare') . '</li>
            <li><strong>' . get_string('emotion_study', 'block_studentcare') . '</strong>: ' . get_string('emotion_study_description', 'block_studentcare') . '</li>
            <li><strong>' . get_string('emotion_exams', 'block_studentcare') . '</strong>: ' . get_string('emotion_exams_description', 'block_studentcare') . '</li>
        </ul>
        <h3><i class="fas fa-clipboard-list"></i> ' . get_string('how_to_use', 'block_studentcare') . '</h3>
        <p>' . get_string('start_here_usage', 'block_studentcare') . '</p>
        <ul>
            <li>' . get_string('evaluate_impact', 'block_studentcare') . '</li>
            <li>' . get_string('identify_patterns', 'block_studentcare') . '</li>
            <li>' . get_string('assist_educators', 'block_studentcare') . '</li>
        </ul>
        <h3><i class="fas fa-bullseye"></i> ' . get_string('purpose', 'block_studentcare') . '</h3>
        <p>' . get_string('main_objective', 'block_studentcare') . '</p>
        <div class="emotion-chip-container">
            <span class="emotion-chip" style="background-color: #FFCDD2;">' . get_string('anger', 'block_studentcare') . '</span>
            <span class="emotion-chip" style="background-color: #C8E6C9;">' . get_string('joy', 'block_studentcare') . '</span>
            <span class="emotion-chip" style="background-color: #FFECB3;">' . get_string('anxiety', 'block_studentcare') . '</span>
            <span class="emotion-chip" style="background-color: #D1C4E9;">' . get_string('shame', 'block_studentcare') . '</span>
        </div>
    </div>
    `)'
));
echo html_writer::tag('div', '🏃‍♂️‍➡️', array('class' => 'manual_aeq-topic-icon'));
echo html_writer::tag('div', get_string('start_here', 'block_studentcare'), array('class' => 'manual_aeq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('manual_aeq-topic', array(
    'onclick' => 'openModal("Classes AEQ 📖", ` 
    <div class="modal-header">
        <h2><i class="fas fa-layer-group"></i> ' . get_string('classes_aeq', 'block_studentcare') . '</h2>
    </div>
    <div class="modal-content-body">
        <p><strong>' . get_string('what_are_aeq_classes', 'block_studentcare') . '</strong></p>
        <p>' . get_string('aeq_classes_description', 'block_studentcare') . '</p>
        <h3><i class="fas fa-book"></i> ' . get_string('classroom_related_emotions', 'block_studentcare') . '</h3>
        <p>' . get_string('classroom_emotions_description', 'block_studentcare') . '</p>
        <ul>
            <li><strong>' . get_string('joy', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('hope', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('pride', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('anger', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('anxiety', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('shame', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('hopelessness', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('boredom', 'block_studentcare') . '</strong></li>
        </ul>
        <h3><i class="fas fa-graduation-cap"></i> ' . get_string('learning_related_emotions', 'block_studentcare') . '</h3>
        <p>' . get_string('learning_emotions_description', 'block_studentcare') . '</p>
        <ul>
            <li><strong>' . get_string('joy', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('hope', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('pride', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('anger', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('anxiety', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('shame', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('hopelessness', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('boredom', 'block_studentcare') . '</strong></li>
        </ul>
        <h3><i class="fas fa-edit"></i> ' . get_string('test_related_emotions', 'block_studentcare') . '</h3>
        <p>' . get_string('test_emotions_description', 'block_studentcare') . '</p>
        <ul>
            <li><strong>' . get_string('joy', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('hope', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('pride', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('relief', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('anger', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('anxiety', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('shame', 'block_studentcare') . '</strong></li>
            <li><strong>' . get_string('hopelessness', 'block_studentcare') . '</strong></li>
        </ul>
        <div class="emotion-chip-container">
            <span class="emotion-chip" style="background-color: #FFCDD2;">' . get_string('anger', 'block_studentcare') . '</span>
            <span class="emotion-chip" style="background-color: #C8E6C9;">' . get_string('joy', 'block_studentcare') . '</span>
            <span class="emotion-chip" style="background-color: #FFECB3;">' . get_string('anxiety', 'block_studentcare') . '</span>
            <span class="emotion-chip" style="background-color: #D1C4E9;">' . get_string('shame', 'block_studentcare') . '</span>
        </div>
    </div>
    `)'
));

echo html_writer::tag('div', '📖', array('class' => 'manual_aeq-topic-icon'));
echo html_writer::tag('div', get_string('classes_aeq', 'block_studentcare'), array('class' => 'manual_aeq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('manual_aeq-topic', array(
    'onclick' => 'openModal("Emoções Acadêmicas 🎭", ` 
    <div class="modal-header">
        <h2><i class="fas fa-layer-group"></i> ' . get_string('academic_emotions', 'block_studentcare') . '</h2>
    </div>
    <p>' . get_string('aeq_description', 'block_studentcare') . '</p>

    <h3><i class="fas fa-book"></i> ' . get_string('classroom_related_emotions', 'block_studentcare') . '</h3>
    <ul>
        <li>😄 <strong>' . get_string('joy', 'block_studentcare') . ' (' . get_string('enjoyment', 'block_studentcare') . '):</strong> ' . get_string('classroom_joy_description', 'block_studentcare') . '</li>
        <li>✨ <strong>' . get_string('hope', 'block_studentcare') . ' (' . get_string('hope', 'block_studentcare') . '):</strong> ' . get_string('classroom_hope_description', 'block_studentcare') . '</li>
        <li>🏅 <strong>' . get_string('pride', 'block_studentcare') . ' (' . get_string('pride', 'block_studentcare') . '):</strong> ' . get_string('classroom_pride_description', 'block_studentcare') . '</li>
        <li>😡 <strong>' . get_string('anger', 'block_studentcare') . ' (' . get_string('anger', 'block_studentcare') . '):</strong> ' . get_string('classroom_anger_description', 'block_studentcare') . '</li>
        <li>😱 <strong>' . get_string('anxiety', 'block_studentcare') . ' (' . get_string('anxiety', 'block_studentcare') . '):</strong> ' . get_string('classroom_anxiety_description', 'block_studentcare') . '</li>
        <li>🙈 <strong>' . get_string('shame', 'block_studentcare') . ' (' . get_string('shame', 'block_studentcare') . '):</strong> ' . get_string('classroom_shame_description', 'block_studentcare') . '</li>
        <li>😭 <strong>' . get_string('hopelessness', 'block_studentcare') . ' (' . get_string('hopelessness', 'block_studentcare') . '):</strong> ' . get_string('classroom_hopelessness_description', 'block_studentcare') . '</li>
        <li>😴 <strong>' . get_string('boredom', 'block_studentcare') . ' (' . get_string('boredom', 'block_studentcare') . '):</strong> ' . get_string('classroom_boredom_description', 'block_studentcare') . '</li>
    </ul>

    <h3><i class="fas fa-graduation-cap"></i> ' . get_string('learning_related_emotions', 'block_studentcare') . '</h3>
    <ul>
        <li>😄 <strong>' . get_string('joy', 'block_studentcare') . ' (' . get_string('enjoyment', 'block_studentcare') . '):</strong> ' . get_string('learning_joy_description', 'block_studentcare') . '</li>
        <li>✨ <strong>' . get_string('hope', 'block_studentcare') . ' (' . get_string('hope', 'block_studentcare') . '):</strong> ' . get_string('learning_hope_description', 'block_studentcare') . '</li>
        <li>🏅 <strong>' . get_string('pride', 'block_studentcare') . ' (' . get_string('pride', 'block_studentcare') . '):</strong> ' . get_string('learning_pride_description', 'block_studentcare') . '</li>
        <li>😡 <strong>' . get_string('anger', 'block_studentcare') . ' (' . get_string('anger', 'block_studentcare') . '):</strong> ' . get_string('learning_anger_description', 'block_studentcare') . '</li>
        <li>😱 <strong>' . get_string('anxiety', 'block_studentcare') . ' (' . get_string('anxiety', 'block_studentcare') . '):</strong> ' . get_string('learning_anxiety_description', 'block_studentcare') . '</li>
        <li>🙈 <strong>' . get_string('shame', 'block_studentcare') . ' (' . get_string('shame', 'block_studentcare') . '):</strong> ' . get_string('learning_shame_description', 'block_studentcare') . '</li>
        <li>😭 <strong>' . get_string('hopelessness', 'block_studentcare') . ' (' . get_string('hopelessness', 'block_studentcare') . '):</strong> ' . get_string('learning_hopelessness_description', 'block_studentcare') . '</li>
        <li>😴 <strong>' . get_string('boredom', 'block_studentcare') . ' (' . get_string('boredom', 'block_studentcare') . '):</strong> ' . get_string('learning_boredom_description', 'block_studentcare') . '</li>
    </ul>

    <h3><i class="fas fa-edit"></i> ' . get_string('test_related_emotions', 'block_studentcare') . '</h3>
    <ul>
        <li>😄 <strong>' . get_string('joy', 'block_studentcare') . ' (' . get_string('enjoyment', 'block_studentcare') . '):</strong> ' . get_string('test_joy_description', 'block_studentcare') . '</li>
        <li>✨ <strong>' . get_string('hope', 'block_studentcare') . ' (' . get_string('hope', 'block_studentcare') . '):</strong> ' . get_string('test_hope_description', 'block_studentcare') . '</li>
        <li>🏅 <strong>' . get_string('pride', 'block_studentcare') . ' (' . get_string('pride', 'block_studentcare') . '):</strong> ' . get_string('test_pride_description', 'block_studentcare') . '</li>
        <li>😌 <strong>' . get_string('relief', 'block_studentcare') . ' (' . get_string('relief', 'block_studentcare') . '):</strong> ' . get_string('test_relief_description', 'block_studentcare') . '</li>
        <li>😡 <strong>' . get_string('anger', 'block_studentcare') . ' (' . get_string('anger', 'block_studentcare') . '):</strong> ' . get_string('test_anger_description', 'block_studentcare') . '</li>
        <li>😱 <strong>' . get_string('anxiety', 'block_studentcare') . ' (' . get_string('anxiety', 'block_studentcare') . '):</strong> ' . get_string('test_anxiety_description', 'block_studentcare') . '</li>
        <li>🙈 <strong>' . get_string('shame', 'block_studentcare') . ' (' . get_string('shame', 'block_studentcare') . '):</strong> ' . get_string('test_shame_description', 'block_studentcare') . '</li>
        <li>😭 <strong>' . get_string('hopelessness', 'block_studentcare') . ' (' . get_string('hopelessness', 'block_studentcare') . '):</strong> ' . get_string('test_hopelessness_description', 'block_studentcare') . '</li>
    </ul>
    </div>
    `)'
));
echo html_writer::tag('div', '🎭', array('class' => 'manual_aeq-topic-icon'));
echo html_writer::tag('div', get_string('academic_emotions', 'block_studentcare'), array('class' => 'manual_aeq-topic-title'));
echo html_writer::end_div();


echo html_writer::start_div('manual_aeq-topic', array(
    'onclick' => 'openModal("' . get_string('aeq_questions', 'block_studentcare') . ' 📝", ` 
    <div class="modal-header">
        <h2><i class="fas fa-question-circle"></i> ' . get_string('aeq_questions', 'block_studentcare') . '</h2>
    </div>
    <div class="modal-content-body">
        <p>' . get_string('aeq_description', 'block_studentcare') . '</p>
        
        <h3><i class="fas fa-cogs"></i> ' . get_string('how_it_works', 'block_studentcare') . '</h3>
        <p>' . get_string('how_it_works_description', 'block_studentcare') . '</p>
        
        <h3><i class="fas fa-lightbulb"></i> ' . get_string('example_questions', 'block_studentcare') . '</h3>
        <ul>
            <li><strong>' . get_string('classroom_related', 'block_studentcare') . ':</strong> “' . get_string('example_classroom_question', 'block_studentcare') . '”</li>
            <li><strong>' . get_string('study_related', 'block_studentcare') . ':</strong> “' . get_string('example_study_question', 'block_studentcare') . '”</li>
            <li><strong>' . get_string('test_related', 'block_studentcare') . ':</strong> “' . get_string('example_test_question', 'block_studentcare') . '”</li>
        </ul>
        
        <h3><i class="fas fa-layer-group"></i> ' . get_string('question_organization', 'block_studentcare') . '</h3>
        <p>' . get_string('question_organization_description', 'block_studentcare') . '</p>
        
         <div class="accordion">
            ' . addslashes(render_acordion($dados_organizados)) . '
        </div>
    </div>
    `)'
));

echo html_writer::tag('div', '📝', array('class' => 'manual_aeq-topic-icon'));
echo html_writer::tag('div', get_string('aeq_questions', 'block_studentcare'), array('class' => 'manual_aeq-topic-title'));
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

document.addEventListener("DOMContentLoaded", function () {
    // Seleciona todos os botões de fechar modais
    const closeButtons = document.querySelectorAll(".close");

    closeButtons.forEach(button => {
        button.addEventListener("click", function () {
            const modal = button.closest(".modal"); // Encontra o modal associado
            if (modal) {
                modal.style.display = "none";
            }
        });
    });

    // Fecha o modal se clicar fora do conteúdo
    window.addEventListener("click", function (event) {
        const modal = document.getElementById("emotionModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});

document.getElementById("manual_aeqSearch").addEventListener("input", function() {
    var filter = this.value.toLowerCase();
    var topics = document.getElementsByClassName("manual_aeq-topic");
    for (var i = 0; i < topics.length; i++) {
        var title = topics[i].getElementsByClassName("manual_aeq-topic-title")[0].innerText.toLowerCase();
        var description = topics[i].getAttribute("onclick").toLowerCase();
        if (title.includes(filter) || description.includes(filter)) {
            topics[i].style.display = "block";
        } else {
            topics[i].style.display = "none";
        }
    }
});');

echo $OUTPUT->footer();
