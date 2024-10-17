<?php
require_once('../../config.php');
require_login();

$coletaid = required_param('coletaid', PARAM_INT); // Recebe o ID da coleta
$context = context_course::instance($COURSE->id);  // Contexto do curso
$PAGE->set_url('/blocks/ifcare/view.php', array('coletaid' => $coletaid));
$PAGE->set_context($context);
$PAGE->set_title("Coleta de Emoções");
$PAGE->set_heading("Coleta de Emoções");

echo $OUTPUT->header();

// Busca as perguntas associadas às emoções da coleta
$perguntas = $DB->get_records_sql("
    SELECT p.id, p.pergunta_texto, e.nome AS emocao_nome
    FROM {ifcare_pergunta} p
    JOIN {ifcare_emocao} e ON e.id = p.emocao_id
    JOIN {ifcare_associacao_classe_emocao_coleta} a ON a.emocao_id = e.id
    WHERE a.cadastrocoleta_id = :coletaid
", ['coletaid' => $coletaid]);

if (!$perguntas) {
    echo "Nenhuma pergunta foi encontrada para esta coleta.";
    echo $OUTPUT->footer();
    exit;
}

// Convertemos as perguntas em JSON para facilitar a manipulação com JavaScript
$perguntas_json = json_encode(array_values($perguntas));
?>

<div id="quiz-container">
    <!-- Barra de progresso -->
    <div id="progress-bar-container">
        <progress id="progress-bar" value="0" max="100"></progress>
        <span id="progress-text">0%</span>
    </div>

    <!-- Pergunta -->
    <div id="pergunta-container"></div>

    <!-- Botões de resposta (escala Likert com emojis como botões) -->
    <div id="respostas-container">
        <button class="emoji-button" data-value="1">
            <img src="<?php echo $CFG->wwwroot; ?>/blocks/ifcare/pix/discordoTotalmente.png" alt="Discordo Totalmente" class="emoji-img">
            <span>Discordo Totalmente</span>
        </button>
        <button class="emoji-button" data-value="2">
            <img src="<?php echo $CFG->wwwroot; ?>/blocks/ifcare/pix/discordo.png" alt="Discordo" class="emoji-img">
            <span>Discordo</span>
        </button>
        <button class="emoji-button" data-value="3">
            <img src="<?php echo $CFG->wwwroot; ?>/blocks/ifcare/pix/neutro.png" alt="Neutro" class="emoji-img">
            <span>Neutro</span>
        </button>
        <button class="emoji-button" data-value="4">
            <img src="<?php echo $CFG->wwwroot; ?>/blocks/ifcare/pix/concordo.png" alt="Concordo" class="emoji-img">
            <span>Concordo</span>
        </button>
        <button class="emoji-button" data-value="5">
            <img src="<?php echo $CFG->wwwroot; ?>/blocks/ifcare/pix/concordoTotalmente.png" alt="Concordo Totalmente" class="emoji-img">
            <span>Concordo Totalmente</span>
        </button>
    </div>

    <!-- Controles de navegação -->
<div id="controls">
    <button id="voltar-btn" onclick="voltarPergunta()">Voltar</button>
    <button id="avancar-btn" onclick="avancarPergunta()">Avançar</button>
</div>
</div>



<script>
    let perguntas = <?php echo $perguntas_json; ?>;
    let perguntaAtual = 0;
    let totalPerguntas = perguntas.length;
    let respostaSelecionada = null;

    // Função para capturar o valor do botão clicado
    function selecionarResposta(valor) {
        respostaSelecionada = valor;
        console.log("Resposta selecionada: ", respostaSelecionada);
    }

    document.querySelectorAll('.emoji-button').forEach(button => {
        button.addEventListener('click', function() {
            selecionarResposta(this.getAttribute('data-value'));
        });
    });

    function mostrarPergunta(index) {
        if (index >= 0 && index < totalPerguntas) {
            let perguntaContainer = document.getElementById('pergunta-container');

            perguntaContainer.innerHTML = `
                <p><strong>${perguntas[index].emocao_nome}</strong></p>
                <p>${perguntas[index].pergunta_texto}</p>
            `;

            // Atualiza a barra de progresso
            let progresso = Math.round(((index + 1) / totalPerguntas) * 100);
            document.getElementById('progress-bar').value = progresso;
            document.getElementById('progress-text').innerText = `${progresso}%`;
        }
    }

    function avancarPergunta() {
        if (respostaSelecionada !== null) {
            if (perguntaAtual < totalPerguntas - 1) {
                perguntaAtual++;
                mostrarPergunta(perguntaAtual);
                respostaSelecionada = null; // Resetar a seleção para a próxima pergunta
            } else {
                alert('Você completou todas as perguntas!');
            }
        } else {
            alert('Por favor, selecione uma resposta.');
        }
    }

    function voltarPergunta() {
        if (perguntaAtual > 0) {
            perguntaAtual--;
            mostrarPergunta(perguntaAtual);
        }
    }

    // Exibe a primeira pergunta ao carregar a página
    mostrarPergunta(perguntaAtual);
</script>

<?php
echo $OUTPUT->footer();
?>

<style>
/* Centralizar o modal na página */
#quiz-container {
    width: 100%;
    max-width: 700px;
    margin: 0 auto;
    height: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

/* Configuração da barra de progresso */
#progress-bar-container {
    position: relative;
    text-align: center;
    margin-bottom: 20px;
}

#progress-bar {
    width: 100%;
    height: 20px;
    border-radius: 5px;
    background-color: #e0e0e0;
    position: relative;
}

#progress-bar::-webkit-progress-value {
    background-color: #4caf50;
    border-radius: 5px;
}

#progress-bar::-moz-progress-bar {
    background-color: #4caf50;
    border-radius: 5px;
}

#progress-text {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    font-weight: bold;
    color: black;
}

/* Estilo da pergunta */
#pergunta-container {
    margin-bottom: 20px;
    font-size: 18px;
    text-align: center;
}

/* Alinha os botões emoji em linha */
#respostas-container {
    display: flex;
    justify-content: space-evenly;
    margin-bottom: 20px;
}

/* Estilo dos botões de emoji */
.emoji-button {
    display: flex;
    flex-direction: column; /* Coloca a imagem e o texto em coluna */
    align-items: center; /* Centraliza horizontalmente */
    justify-content: center; /* Centraliza verticalmente */
    background: none;
    border: none;
    cursor: pointer;
    text-align: center;
    transition: transform 0.2s ease-in-out; /* Animação suave na transformação */
    margin: 0 10px; /* Espaçamento lateral entre os itens */
}

.emoji-img {
    display: block;
    margin-bottom: 5px;
    width: 48px;  /* Tamanho ajustado do emoji */
    height: 48px; 
}

/* Estilo do texto Likert abaixo dos emojis */
.emoji-button span {
    font-size: 14px;
    color: #000;
    text-align: center;
}

/* Efeito de hover - faz o botão crescer */
.emoji-button:hover {
    transform: scale(1.2); /* Aumenta o tamanho em 20% ao passar o mouse */
}


/* Botões de navegação */
#controls {
    display: flex;
    justify-content: space-between; /* Coloca os botões nas pontas */
    margin-top: 10px; /* Reduz o espaço entre o modal e os botões */
    padding: 0 20px; /* Adiciona um espaçamento interno para não encostar nas bordas da tela */
}

/* Botões de navegação */
#controls button {
    background-color: #28a745; /* Cor de fundo do botão (verde, por exemplo) */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s;
}

#controls button:hover {
    background-color: #218838; /* Cor de fundo quando o mouse está sobre o botão (um tom mais escuro de verde) */
}


</style>
