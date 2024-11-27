<?php
require_once('../../config.php');
require_login();

global $PAGE, $OUTPUT;

$courseid = optional_param('courseid', 0, PARAM_INT);
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/ifcare/faq.php');
$PAGE->set_title(get_string('faq', 'block_ifcare'));
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

echo html_writer::start_div('faq-search');
echo html_writer::empty_tag('input', array('type' => 'text', 'id' => 'faqSearch', 'placeholder' => 'Pesquise pelo título ou conteúdo...'));
echo html_writer::end_div();

echo html_writer::start_div('faq-header');
echo html_writer::tag('h3', 'Como podemos ajudar?', ['class' => 'faq-title']);
echo html_writer::end_div();

echo html_writer::start_div('faq-topics');

echo html_writer::start_div('faq-topic', array(
    'onclick' => 'openModal("O que é o IFCare?", `
    <div class="modal-header">
        <h2><i class="fas fa-info-circle"></i> O que é o IFCare?</h2>
    </div>
    <div class="modal-content-body">
        <p>O <strong>IFCare</strong> é um plugin de bloco desenvolvido para a plataforma Moodle com o objetivo de <em>monitorar as emoções acadêmicas</em> dos estudantes. Ele utiliza como base o <strong>AEQ (Achievement Emotions Questionnaire)</strong>, um instrumento amplamente reconhecido na avaliação de emoções relacionadas ao desempenho acadêmico.</p>
        <h3><i class="fas fa-tools"></i> Funcionalidades Principais</h3>
        <ul>
            <li>Permite que professores criem <strong>coletas de emoções</strong>, selecionando classes e emoções específicas.</li>
            <li>Oferece aos estudantes uma interface interativa para responder às coletas usando uma escala Likert com emojis.</li>
            <li>Gera gráficos interativos para os professores visualizarem os dados coletados, auxiliando na análise das emoções acadêmicas.</li>
            <li>Facilita a exportação dos dados em formatos como <i>CSV</i> e <i>JSON</i> para análises externas.</li>
        </ul>
        <h3><i class="fas fa-bullseye"></i> Objetivo</h3>
        <p>O principal objetivo do <strong>IFCare</strong> é auxiliar professores e instituições de ensino a identificar e monitorar as emoções acadêmicas dos estudantes, contribuindo para intervenções pedagógicas mais personalizadas e assertivas, visando melhorar o desempenho acadêmico e reduzir problemas como desmotivação e evasão escolar.</p>
        <h3><i class="fas fa-graduation-cap"></i> Benefícios</h3>
        <ul>
            <li>Apoio no <strong>planejamento pedagógico</strong> baseado em dados emocionais dos alunos.</li>
            <li>Melhoria no <strong>engajamento e bem-estar</strong> dos estudantes.</li>
            <li>Ferramenta de fácil integração ao Moodle, sendo acessível a professores e administradores.</li>
        </ul>
    </div>
    `)'
));
echo html_writer::tag('div', '🧠', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', 'O que é o IFCare?', array('class' => 'faq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('faq-topic', array(
    'onclick' => 'openModal("Como utilizar o plugin IFCare?", `
    <div class="modal-header">
        <h2><i class="fas fa-info-circle"></i> Como utilizar o plugin IFCare?</h2>
    </div>   
<p>O plugin <strong>IFCare</strong> é uma ferramenta poderosa integrada ao Moodle, que permite aos professores coletar, monitorar e analisar as emoções acadêmicas de forma interativa e eficiente. Aqui está um guia para utilizá-lo:</p>
    <h3>👩‍🏫 Passos para o professor cadastrar uma coleta:</h3>
    <ul>
        <li><strong>📋 Acesse o painel do plugin IFCare:</strong> Localize o plugin diretamente no painel do Moodle para facilitar a gestão centralizada, sem necessidade de instalação em cursos específicos.</li>
        <li><strong>📚 Preencha as informações da coleta:</strong> Adicione as datas de início e fim e descrição(opcional)</li>
        <li><strong>📝 Escolha o curso, seção e recurso:</strong> Vincule a coleta a um curso e selecione uma seção específica. Caso necessário, associe a coleta a um recurso existente.</li>
        <li><strong>🎭 Selecione as classes e emoções do AEQ:</strong> Utilize o formulário para escolher as classes de emoções acadêmicas (aulas, aprendizado, provas) e emoções específicas. Essas seleções definirão as perguntas que os alunos responderão.</li>
        <li><strong>🔔 Configure notificações e alertas:</strong> Ative notificações automáticas para alunos e receba alertas sobre o andamento da coleta.</li>
    </ul>
    <h3>📊 Após o cadastro da coleta:</h3>
    <ul>
        <li><strong>📤 Exportação de dados:</strong> Os dados das respostas podem ser exportados em formatos como JSON e CSV para análise mais detalhada.</li>
        <li><strong>📈 Visualização de gráficos:</strong> O professor pode acessar relatórios interativos com gráficos para interpretar os dados coletados e ajustar estratégias pedagógicas conforme necessário.</li>
        <li><strong>❌ Exclusão de coletas:</strong> Caso a coleta não seja mais necessária, o professor pode excluí-la diretamente pelo painel do plugin.</li>
    </ul>
    <h3>👨‍🎓 Para os alunos:</h3>
    <ul>
        <li><strong>🔔 Receba notificações personalizadas:</strong> Os alunos são notificados via e-mail e no Moodle sobre as coletas disponíveis.</li>
        <li><strong>📝 Responda às coletas:</strong> As perguntas são exibidas de forma interativa em uma escala Likert de 1 a 5, com base nas classes e emoções selecionadas pelo professor.</li>
        <li><strong>📜 Aceite ou recuse o TCLE:</strong> Antes de responder às perguntas, os alunos devem aceitar ou recusar o Termo de Consentimento Livre e Esclarecido (TCLE).</li>
    </ul>
    <h3>📘 Recursos adicionais:</h3>
    <ul>
        <li><strong>📖 Manual do AEQ:</strong> O plugin disponibiliza o <a href=' . new moodle_url('/blocks/ifcare/manual_aeq.php') . '>Manual AEQ</a>, que fornece detalhes sobre as classes, emoções e perguntas do AEQ.</li>
        <li><strong>🌐 Criação automática de recursos:</strong> Após o cadastro, o plugin cria automaticamente um recurso do tipo URL vinculado à seção escolhida pelo professor, facilitando o acesso dos alunos.</li>
        <li><strong>📊 Gráficos e relatórios:</strong> Dados das respostas são exibidos em gráficos interativos para facilitar a análise.</li>
    </ul>
    <p>O plugin IFCare foi projetado para ser intuitivo e eficiente, otimizando o processo de coleta e análise de emoções acadêmicas. Ele auxilia na criação de estratégias pedagógicas baseadas em dados reais, promovendo um ambiente de aprendizado mais saudável e adaptado às necessidades dos alunos.</p>
`)'
));


echo html_writer::tag('div', '📋', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', 'Como utilizar o plugin IFCare?', array('class' => 'faq-topic-title'));
echo html_writer::end_div();


echo html_writer::start_div('faq-topic', array(
    'onclick' => 'openModal("Principais funcionalidades do plugin IFCare", `
    <div class="modal-header">
        <h2><i class="fas fa-tools"></i> Principais funcionalidades do plugin IFCare</h2>
    </div>
    <div class="modal-content-body">
        <p>O <strong>IFCare</strong> é um plugin desenvolvido para facilitar o monitoramento das emoções acadêmicas no Moodle, trazendo diversas funcionalidades pensadas para professores e administradores. Confira algumas das principais:</p>
        <ul>
            <li><strong>📘 Manual AEQ:</strong> O plugin inclui acesso ao <a href="/blocks/ifcare/manual_aeq.php" target="_blank">Manual AEQ</a>, que explica detalhadamente o embasamento teórico e a estrutura do <em>Achievement Emotions Questionnaire (AEQ)</em>.</li>
            <li><strong>✍️ Cadastro e edição de coletas:</strong> Os professores podem criar novas coletas específicas para suas disciplinas, editar configurações de coletas já existentes e escolher quais classes e emoções do AEQ serão trabalhadas.</li>
            <li><strong>🗑️ Exclusão de coletas:</strong> Caso necessário, coletas podem ser facilmente removidas pelo professor.</li>
            <li><strong>🔗 Vinculação de recursos:</strong> Durante o cadastro, é possível associar um recurso específico de uma seção da disciplina à coleta, integrando ainda mais o conteúdo da aula com a coleta.</li>
            <li><strong>🌐 Criação automática de recurso URL:</strong> Para cada coleta criada, o plugin adiciona automaticamente um recurso do tipo URL na seção escolhida pelo professor.</li>
            <li><strong>📬 Notificações e e-mails personalizados:</strong> Após o cadastro de uma coleta, notificações e e-mails customizados para a disciplina são enviados automaticamente aos alunos.</li>
            <li><strong>📝 TCLE interativo:</strong> Antes de responder à coleta, o aluno visualiza um Termo de Consentimento Livre e Esclarecido (TCLE) e pode aceitá-lo ou recusá-lo.</li>
            <li><strong>🤖 Respostas interativas:</strong> As questões do AEQ são apresentadas de forma interativa e baseadas nas classes e emoções escolhidas pelo professor.</li>
            <li><strong>📊 Monitoramento e alertas:</strong> O professor pode acompanhar o progresso da coleta em tempo real e receber alertas sobre o andamento.</li>
            <li><strong>📈 Visualização de resultados:</strong> Os dados coletados são exibidos em gráficos interativos e relatórios, permitindo uma análise prática e visual das emoções dos alunos.</li>
            <li><strong>📂 Exportação de dados:</strong> Respostas dos alunos podem ser exportadas em formatos como JSON e CSV, facilitando análises externas ou arquivamento.</li>
            <li><strong>📋 Gerenciamento centralizado:</strong> Instalado no painel do Moodle, o plugin oferece um gerenciamento simplificado e integrado, sem a necessidade de instalá-lo separadamente em cada curso.</li>
        </ul>
        <p>Essas funcionalidades tornam o <strong>IFCare</strong> uma ferramenta poderosa e prática para compreender as emoções acadêmicas dos alunos e melhorar o processo de ensino e aprendizagem.</p>
    </div>
    `)'
));
echo html_writer::tag('div', '🛠️', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', 'Principais funcionalidades do plugin IFCare', array('class' => 'faq-topic-title'));
echo html_writer::end_div();



echo html_writer::start_div('faq-topic', array(
    'onclick' => 'openModal("Quem desenvolveu o IFCare?", `
    <div class="modal-header">
        <h2><i class="fas fa-user-graduate"></i> Quem desenvolveu o IFCare?</h2>
    </div>
    <div class="modal-content-body">
        <p>O <strong>IFCare</strong> é um projeto desenvolvido como Trabalho de Conclusão de Curso (TCC) pelo aluno <strong>Rafael Lariloran Costa Rodrigues</strong> (<a href="http://lattes.cnpq.br/1281350600184120" target="_blank">Lattes</a>), estudante do curso superior em <em>Sistemas para Internet</em> do <strong>Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Sul (IFRS) – Campus Porto Alegre</strong>.</p>
        <p>O artigo referente ao projeto está disponível no <a href="https://repositorio.ifrs.edu.br/handle/123456789/935" target="_blank">repositório do IFRS - Campus Porto Alegre</a>.</p>
        <h3><i class="fas fa-chalkboard-teacher"></i> Orientação</h3>
        <p>O projeto foi orientado pela <strong>Profa. Dra. Márcia Häfele Islabão Franco</strong> (<a href="http://lattes.cnpq.br/2551214616925074" target="_blank">Lattes</a>) e coorientado pelo <strong>Prof. Dr. Marcelo Augusto Rauh Schmitt</strong> (<a href="http://lattes.cnpq.br/1958021878056697" target="_blank">Lattes</a>), ambos docentes do IFRS Porto Alegre.</p>
        <h3><i class="fas fa-envelope"></i> Contato</h3>
        <p>Se você encontrou algum <strong>bug, problema ou possui dúvidas</strong>, envie um e-mail para:</p>
        <ul>
            <li><a href="mailto:lariloran2@gmail.com">lariloran2@gmail.com</a></li>
        </ul>
    </div>
    `)'
));
echo html_writer::tag('div', '📟', array('class' => 'faq-topic-icon'));
echo html_writer::tag('div', 'Quem desenvolveu o IFCare?', array('class' => 'faq-topic-title'));
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
