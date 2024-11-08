<?php
require_once('../../config.php');
require_login();

global $PAGE, $OUTPUT;

$courseid = optional_param('courseid', 0, PARAM_INT);
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/ifcare/manual_aeq.php', array('courseid' => $courseid));
$PAGE->set_title(get_string('aeq_manual_title', 'block_ifcare'));
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();

echo '<style>
    .faq-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .faq-header {
        text-align: center;
        margin-bottom: 30px;
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
    }
    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 30px;
        border-radius: 15px;
        width: 80%;
        max-width: 600px;
        border: 1px solid #ddd;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
        max-height: 80vh;
        overflow-y: auto;
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

echo html_writer::start_div('faq-search');
echo html_writer::empty_tag('input', array('type' => 'text', 'id' => 'faqSearch', 'placeholder' => 'Pesquise pelo título ou conteúdo...'));
echo html_writer::end_div();

echo html_writer::start_div('faq-header');
echo html_writer::tag('h3', 'Como podemos ajudar?');
echo html_writer::end_div();

echo html_writer::start_div('faq-topics');

echo html_writer::start_div('faq-topic', array('onclick' => 'openModal("O que é o AEQ?", "<p>O <strong>AEQ (Achievement Emotions Questionnaire)</strong> é um instrumento desenvolvido para medir as emoções acadêmicas dos alunos. Ele está estruturado em três classes principais:</p><ul><li><em>Emoções relacionadas às aulas</em>: Refere-se a como os alunos se sentem durante as aulas, incluindo emoções como <strong>diversão</strong> e <strong>tédio</strong>.</li><li><em>Emoções relacionadas às provas</em>: Incluem emoções como <strong>ansiedade</strong> e <strong>orgulho</strong>, e são ligadas à preparação e realização de avaliações.</li><li><em>Emoções relacionadas ao aprendizado</em>: Emoções como <strong>esperança</strong> e <strong>frustração</strong> surgem durante o processo de aprendizado.</li></ul><p>Cada classe é composta por um conjunto de emoções, incluindo diversão, esperança, orgulho, raiva, ansiedade, vergonha, tédio, e desânimo. O objetivo do AEQ é entender como essas emoções influenciam o envolvimento e desempenho dos estudantes.</p>")'));
echo html_writer::tag('div', '😄', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', 'O que é o AEQ?', array('class' => 'faq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('faq-topic', array('onclick' => 'openModal("Qual o propósito e finalidade do AEQ?", "<p>O propósito do <strong>AEQ</strong> é medir e compreender as emoções acadêmicas dos estudantes, de forma a melhorar o ambiente de aprendizagem e o desempenho acadêmico. As emoções acadêmicas podem afetar diretamente o envolvimento e a motivação dos estudantes, sendo fundamentais para ajustar estratégias pedagógicas que favoreçam um ambiente positivo e produtivo.</p><p><strong>Referências utilizadas no desenvolvimento do projeto:</strong></p><ul><li>ABREU E SILVA, F. Emoções, Autoconceito, Motivação e Desempenho Acadêmico em Crianças do 3º e 4º anos de escolaridade. 2015.</li><li>BZUNECK, J. A. Emoções acadêmicas, autorregulação e seu impacto sobre motivação e aprendizagem. ETD-Educação Temática Digital, 2018.</li><li>PEKRUN, R. The Control-Value Theory of Achievement Emotions: Assumptions, Corollaries, and Implications for Educational Research and Practice. 2006.</li><li>COBO-RENDÓN, R. et al. Academic emotions, college adjustment, and dropout intention in university students. Frontiers in Education, 2023.</li></ul>")'));
echo html_writer::tag('div', '😉', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', 'Qual o propósito e finalidade do AEQ?', array('class' => 'faq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('faq-topic', array('onclick' => 'openModal("Como utilizar o plugin IFCare?", "<p>O plugin <strong>IFCare</strong> é uma ferramenta integrada ao Moodle que possibilita o cadastro de coletas de emoções acadêmicas. Para cadastrar uma coleta, o professor deve:</p><ul><li>Acessar o plugin no curso desejado e iniciar o cadastro.</li><li>Fornecer informações básicas, como o nome da coleta, datas de início e fim, descrição e, opcionalmente, escolher se deseja notificar os alunos.</li><li>Selecionar o curso, seção e recurso onde a coleta será realizada.</li><li>Escolher as classes de emoções do AEQ e as emoções específicas que deseja investigar. Essas informações são selecionadas através do formulário.</li></ul><p>Os alunos devem responder às coletas utilizando uma escala <em>Likert</em> de 1 a 5, fornecendo insights sobre suas emoções relacionadas à disciplina.</p>")'));
echo html_writer::tag('div', '😏', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', 'Como utilizar o plugin IFCare?', array('class' => 'faq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('faq-topic', array('onclick' => 'openModal("O que é a Teoria de Controle-Valorização?", "<p>A <strong>Teoria de Controle-Valorização</strong>, proposta por <em>Pekrun</em>, serve como base para a construção do AEQ. Essa teoria sugere que as emoções acadêmicas estão relacionadas a dois fatores principais:</p><ul><li><strong>Controle percebido</strong> sobre as atividades e desempenho acadêmico.</li><li><strong>Valorização</strong> atribuída ao sucesso ou fracasso nessas atividades.</li></ul><p>Esses dois fatores determinam as emoções dos alunos, que, por sua vez, afetam diretamente sua motivação, engajamento e resultados acadêmicos. Emoções positivas, como <strong>orgulho</strong> e <strong>diversão</strong>, estão associadas a maiores níveis de engajamento e desempenho, enquanto emoções negativas, como <strong>ansiedade</strong> e <strong>tédio</strong>, podem ter o efeito oposto.</p>")'));
echo html_writer::tag('div', '😊', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', 'O que é a Teoria de Controle-Valorização?', array('class' => 'faq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('faq-topic', array('onclick' => 'openModal("Principais funcionalidades do plugin IFCare", "<p>O plugin <strong>IFCare</strong> oferece diversas funcionalidades úteis para professores e administradores:</p><ul><li><strong>Cadastro de coletas de emoções</strong>: Professores podem criar coletas específicas para suas disciplinas, permitindo um entendimento detalhado sobre as emoções dos alunos.</li><li><strong>Escolha de classes e emoções</strong>: Professores podem selecionar quais classes do AEQ e emoções específicas desejam monitorar.</li><li><strong>Notificação automática</strong>: Após a criação de uma coleta, o sistema notifica os alunos através de e-mail e notificações no Moodle, garantindo que todos estejam cientes da nova atividade.</li><li><strong>Visualização de resultados</strong>: Os dados coletados são apresentados ao professor em forma de relatórios e gráficos, ajudando a identificar padrões emocionais e ajustar estratégias pedagógicas conforme necessário.</li><li><strong>Exportação de dados</strong>: As respostas dos alunos podem ser exportadas em formatos como JSON e CSV, para uma análise mais aprofundada ou arquivamento.</li></ul>")'));
echo html_writer::tag('div', '😁', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', 'Principais funcionalidades do plugin IFCare', array('class' => 'faq-topic-title'));
echo html_writer::end_div();

echo html_writer::end_div();
echo html_writer::end_div();

// Modal HTML
echo '<div id="emotionModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitle"></h2>
        <p id="modalDescription"></p>
    </div>
</div>';

echo html_writer::script('function openModal(title, description) {
    document.getElementById("modalTitle").innerText = title;
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
