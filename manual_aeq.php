<?php
require_once('../../config.php');
require_login();

global $PAGE, $OUTPUT;

$courseid = optional_param('courseid', 0, PARAM_INT);
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/ifcare/manual_aeq.php');
$PAGE->set_title(get_string('manual_aeq', 'block_ifcare'));
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

// Consulta SQL para buscar perguntas, emoções e classes AEQ
$sql = "SELECT 
            p.id AS pergunta_id, -- Coluna única
            c.nome_classe AS classe_nome,
            e.nome AS emocao_nome,
            p.pergunta_texto 
        FROM {ifcare_pergunta} p
        JOIN {ifcare_emocao} e ON p.emocao_id = e.id
        JOIN {ifcare_classeaeq} c ON p.classeaeq_id = c.id
        ORDER BY c.nome_classe, e.nome, p.id";

$perguntas = $DB->get_records_sql($sql);

$dados_organizados = [];
foreach ($perguntas as $pergunta) {
    $classe = $pergunta->classe_nome;
    $emocao = $pergunta->emocao_nome;
    $texto = $pergunta->pergunta_texto;

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
echo html_writer::empty_tag('input', array('type' => 'text', 'id' => 'manual_aeqSearch', 'placeholder' => 'Pesquise pelo título ou conteúdo...'));
echo html_writer::end_div();

echo html_writer::start_div('manual_aeq-header');
echo html_writer::tag('h3', 'Guia para Utilização do AEQ', ['class' => 'manual_aeq-title']);
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




echo html_writer::start_div('manual_aeq-topic', array('onclick' => 'openModal("Comece por aqui 🏃‍♂️‍➡️", "<p>O <strong>Achievement Emotions Questionnaire (AEQ)</strong> é um instrumento de avaliação psicológica desenvolvido para medir as emoções acadêmicas dos estudantes em contextos educacionais. Criado por <strong>Reinhard Pekrun</strong> e seus colaboradores, o AEQ é fundamentado na teoria de Controle-Valorização, que analisa como as emoções influenciam o desempenho e a motivação acadêmica.</p><p><strong>Como funciona?</strong></p><p>O AEQ utiliza um questionário estruturado com perguntas baseadas em uma escala <em>Likert</em>, onde os estudantes avaliam suas emoções relacionadas a três situações principais:</p><ul><li><strong>Emoções relacionadas às aulas:</strong> Sentimentos como alegria, tédio e raiva vivenciados antes, durante e depois de frequentar aulas.</li><li><strong>Emoções relacionadas ao estudo:</strong> Sentimentos como orgulho, frustração e ansiedade experimentados durante o processo de aprendizagem.</li><li><strong>Emoções relacionadas às provas:</strong> Sentimentos como alívio, esperança e vergonha antes, durante e após avaliações.</li></ul><p><strong>Formas de uso:</strong></p><p>O AEQ é amplamente utilizado em contextos educacionais e de pesquisa para:</p><ul><li>Avaliar o impacto das emoções acadêmicas no desempenho dos estudantes.</li><li>Identificar padrões emocionais que possam levar à desmotivação ou evasão escolar.</li><li>Auxiliar educadores e administradores a desenvolver estratégias pedagógicas que promovam um ambiente emocionalmente saudável.</li></ul><p><strong>Propósito:</strong></p><p>O principal objetivo do AEQ é fornecer uma ferramenta para compreender as emoções acadêmicas e seu papel no aprendizado, ajudando a melhorar a experiência educacional e reduzir barreiras emocionais ao sucesso acadêmico.</p><p><strong>Quem pode utilizá-lo?</strong></p><p>Pesquisadores, educadores e psicólogos educacionais utilizam o AEQ para monitorar e avaliar as emoções dos estudantes, promovendo práticas pedagógicas mais eficazes e um aprendizado emocionalmente equilibrado.</p>")'));
echo html_writer::tag('div', '🏃‍♂️‍➡️', array('class' => 'manual_aeq-topic-icon'));
echo html_writer::tag('div', 'Comece por aqui', array('class' => 'manual_aeq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('manual_aeq-topic', array('onclick' => 'openModal("Classes AEQ 📖", "<p>O que são as Classes do AEQ?</p><p>As classes do AEQ são categorias que agrupam as emoções acadêmicas com base no contexto em que elas ocorrem. Cada classe foi projetada para avaliar as emoções experimentadas antes, durante e depois de atividades acadêmicas específicas, como assistir aulas, estudar ou realizar testes/exames. Esses momentos são críticos, pois representam as situações de maior impacto emocional na trajetória acadêmica de um estudante.</p><p><strong>Quais são as Classes do AEQ?</strong></p><p><strong>Emoções Relacionadas às Aulas (Class-Related Emotions):</strong></p><p>Esta classe avalia as emoções experimentadas ao participar de aulas. Ela engloba sentimentos vivenciados antes de entrar na sala de aula (por exemplo, expectativa ou nervosismo), durante a aula (como interesse ou frustração) e depois da aula (como alívio ou orgulho).</p><p><em>Exemplos de emoções avaliadas nesta classe:</em> Alegria, Esperança, Orgulho, Raiva, Ansiedade, Vergonha, Desesperança e Tédio.</p><p><em>Aplicabilidade:</em> Ajuda a identificar como as emoções ligadas às interações em sala de aula afetam a participação, engajamento e aprendizado dos estudantes.</p><p><strong>Emoções Relacionadas ao Estudo (Learning-Related Emotions):</strong></p><p>Focada nas emoções associadas ao processo de estudo ou aprendizagem, esta classe aborda os sentimentos que surgem antes de iniciar uma sessão de estudo (como motivação ou desânimo), durante o estudo (como concentração ou irritação) e depois de estudar (como satisfação ou frustração).</p><p><em>Exemplos de emoções avaliadas nesta classe:</em> Alegria ao aprender, Orgulho pelos resultados alcançados, Ansiedade ao enfrentar desafios, e Tédio ao lidar com material desinteressante.</p><p><em>Aplicabilidade:</em> Útil para entender como as emoções influenciam o progresso no estudo, a retenção de informações e o desenvolvimento de habilidades acadêmicas.</p><p><strong>Emoções Relacionadas a Testes/Exames (Test-Related Emotions):</strong></p><p>Esta classe examina as emoções vivenciadas em momentos de avaliação, como testes e exames. Considera os sentimentos experimentados antes de uma prova (como ansiedade ou confiança), durante a realização (como nervosismo ou foco) e após o término (como alívio ou vergonha).</p><p><em>Exemplos de emoções avaliadas nesta classe:</em> Ansiedade pré-prova, Orgulho pelo desempenho, Alívio ao finalizar a avaliação, e Desesperança em situações de dificuldade.</p><p><em>Aplicabilidade:</em> Essencial para avaliar como as emoções impactam o desempenho em provas, a preparação antecipada e as estratégias de enfrentamento em avaliações de alto impacto.</p><p><strong>Aplicabilidade Geral das Classes</strong></p><p>Essas classes fornecem uma visão abrangente das emoções acadêmicas em contextos distintos, permitindo que professores, pesquisadores e administradores educacionais:</p><ul><li>Compreendam os fatores emocionais que afetam o desempenho acadêmico.</li><li>Desenvolvam intervenções pedagógicas para melhorar o engajamento e o bem-estar dos estudantes.</li><li>Identifiquem padrões emocionais que possam indicar riscos de evasão, desmotivação ou dificuldades de aprendizado.</li></ul>")'));
echo html_writer::tag('div', '📖', array('class' => 'manual_aeq-topic-icon'));
echo html_writer::tag('div', 'Classes AEQ', array('class' => 'manual_aeq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('manual_aeq-topic', array('onclick' => 'openModal("Emoções Acadêmicas 🎭", "<p>O <strong>AEQ</strong> trabalha com uma ampla gama de emoções acadêmicas, organizadas em três contextos principais: aulas, estudo e provas. Aqui estão as emoções avaliadas em cada contexto e o que elas representam:</p><h3>Emoções Relacionadas às Aulas (Class-Related Emotions)</h3><ul><li><strong>Alegria (Enjoyment):</strong> Sentimento de prazer e entusiasmo ao participar das aulas.</li><li><strong>Esperança (Hope):</strong> Confiança de que será possível acompanhar o conteúdo e participar ativamente.</li><li><strong>Orgulho (Pride):</strong> Satisfação por compreender o conteúdo ou contribuir positivamente.</li><li><strong>Raiva (Anger):</strong> Frustração ou irritação causada pela dinâmica ou qualidade da aula.</li><li><strong>Ansiedade (Anxiety):</strong> Inquietação ou nervosismo relacionado ao ambiente ou ao conteúdo da aula.</li><li><strong>Vergonha (Shame):</strong> Embaraço por dificuldades de expressão ou compreensão do conteúdo.</li><li><strong>Desesperança (Hopelessness):</strong> Sentimento de desistência ou falta de perspectiva em relação ao aprendizado.</li><li><strong>Tédio (Boredom):</strong> Sensação de monotonia ou falta de interesse na aula.</li></ul><h3>Emoções Relacionadas ao Estudo (Learning-Related Emotions)</h3><ul><li><strong>Alegria (Enjoyment):</strong> Prazer em aprender e explorar novos conhecimentos.</li><li><strong>Esperança (Hope):</strong> Otimismo sobre a capacidade de dominar o material estudado.</li><li><strong>Orgulho (Pride):</strong> Satisfação pelos resultados alcançados durante o processo de estudo.</li><li><strong>Raiva (Anger):</strong> Irritação com a quantidade de material ou dificuldades no estudo.</li><li><strong>Ansiedade (Anxiety):</strong> Medo ou tensão diante de dificuldades no aprendizado.</li><li><strong>Vergonha (Shame):</strong> Embaraço por não conseguir absorver ou aplicar o conteúdo adequadamente.</li><li><strong>Desesperança (Hopelessness):</strong> Desmotivação por acreditar que não conseguirá entender ou avançar no estudo.</li><li><strong>Tédio (Boredom):</strong> Sensação de desinteresse ao lidar com material monótono ou pouco estimulante.</li></ul><h3>Emoções Relacionadas a Testes/Exames (Test-Related Emotions)</h3><ul><li><strong>Alegria (Enjoyment):</strong> Satisfação ao demonstrar conhecimento ou enfrentar desafios em provas.</li><li><strong>Esperança (Hope):</strong> Confiança em um bom desempenho e sucesso na avaliação.</li><li><strong>Orgulho (Pride):</strong> Satisfação pelos esforços de preparação e desempenho na prova.</li><li><strong>Alívio (Relief):</strong> Sensação de tranquilidade ao concluir uma avaliação.</li><li><strong>Raiva (Anger):</strong> Frustração com o tempo, dificuldade ou injustiça percebida na prova.</li><li><strong>Ansiedade (Anxiety):</strong> Preocupação intensa antes ou durante a avaliação.</li><li><strong>Vergonha (Shame):</strong> Embaraço por desempenho insatisfatório ou erros cometidos.</li><li><strong>Desesperança (Hopelessness):</strong> Sentimento de desistência ou falta de confiança no sucesso da prova.</li></ul>")'));
echo html_writer::tag('div', '🎭', array('class' => 'manual_aeq-topic-icon'));
echo html_writer::tag('div', 'Emoções Acadêmicas', array('class' => 'manual_aeq-topic-title'));
echo html_writer::end_div();

echo html_writer::start_div('manual_aeq-topic', array(
    'onclick' => 'openModal("Perguntas do AEQ", "<p>As perguntas do <strong>Achievement Emotions Questionnaire (AEQ)</strong> foram desenvolvidas para medir as emoções acadêmicas de forma estruturada, em três contextos principais: aulas, estudo e testes/exames. Elas avaliam as emoções vivenciadas antes, durante e depois de cada uma dessas situações.</p><p><strong>Como Funcionam?</strong></p><p>Cada pergunta apresenta uma afirmação que descreve um estado emocional. Os estudantes avaliam como essa afirmação reflete suas experiências pessoais, utilizando uma escala do tipo Likert, que varia de 1 (discordo totalmente) a 5 (concordo totalmente).</p><p><strong>Exemplos de Perguntas:</strong></p><ul><li><strong>Relacionadas às Aulas:</strong> “Eu fico animado em ir para a aula.”</li><li><strong>Relacionadas ao Estudo:</strong> “Eu me sinto otimista sobre o meu progresso nos estudos.”</li><li><strong>Relacionadas a Testes/Exames:</strong> “Eu fico ansioso antes de uma prova.”</li></ul><p>As perguntas estão organizadas em blocos que ajudam os participantes a acessar memórias específicas, tornando as respostas mais representativas. Essa estrutura permite compreender melhor como as emoções afetam o desempenho acadêmico. <b>Confira abaixo as perguntas que estão relacionadas a cada Classe-Emoção:</b></p>" + `' . addslashes(render_acordion($dados_organizados)) . '`);'
));
echo html_writer::tag('div', '📝', array('class' => 'manual_aeq-topic-icon'));
echo html_writer::tag('div', 'Perguntas do AEQ', array('class' => 'manual_aeq-topic-title'));
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
