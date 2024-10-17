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

    <!-- Opções de resposta -->
    <div id="respostas-container">
    <div id="respostas">

        <label>
            <input type="radio" name="resposta" value="1">
        </label>
        <label>
            <input type="radio" name="resposta" value="2">
            <img src="<?php echo $CFG->wwwroot; ?>/blocks/ifcare/pix/emoji1.png" alt="Discordo" width="64" height="64">
        </label>
        <label>
            <input type="radio" name="resposta" value="3">
            <img src="<?php echo $CFG->wwwroot; ?>/blocks/ifcare/pix/emoji1.png" alt="Neutro" width="64" height="64">
        </label>
        <label>
            <input type="radio" name="resposta" value="4">
            <img src="<?php echo $CFG->wwwroot; ?>/blocks/ifcare/pix/emoji1.png" alt="Concordo" width="64" height="64">
        </label>
        <label>
            <input type="radio" name="resposta" value="5">
            <img src="<?php echo $CFG->wwwroot; ?>/blocks/ifcare/pix/emoji1.png" alt="Concordo Totalmente" width="64" height="64">
        </label>
    </div>
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

    function mostrarPergunta(index) {
        if (index >= 0 && index < totalPerguntas) {
            let perguntaContainer = document.getElementById('pergunta-container');
            let respostasContainer = document.getElementById('respostas-container');

            perguntaContainer.innerHTML = `
                <p><strong>${perguntas[index].emocao_nome}</strong></p>
                <p>${perguntas[index].pergunta_texto}</p>
            `;

            respostasContainer.innerHTML = `
                <div id="respostas">
                    <label><input type="radio" name="resposta" value="1"> Discordo Totalmente</label>
                    <label><input type="radio" name="resposta" value="2"> Discordo</label>
                    <label><input type="radio" name="resposta" value="3"> Neutro</label>
                    <label><input type="radio" name="resposta" value="4"> Concordo</label>
                    <label><input type="radio" name="resposta" value="5"> Concordo Totalmente</label>
                </div>
            `;

            // Atualiza a barra de progresso
            let progresso = Math.round(((index + 1) / totalPerguntas) * 100);
            document.getElementById('progress-bar').value = progresso;
            document.getElementById('progress-text').innerText = `${progresso}%`;
        }
    }

    function avancarPergunta() {
        if (perguntaAtual < totalPerguntas - 1) {
            perguntaAtual++;
            mostrarPergunta(perguntaAtual);
        } else {
            alert('Você completou todas as perguntas!');
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

<style>/* Centralizar o modal na página */
#quiz-container {
    width: 100%;
    max-width: 700px; /* Aumentei a largura máxima */
    margin: 0 auto; /* Centraliza o modal horizontalmente */
    height: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff; /* Cor de fundo branca para contraste */
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
    background-color: #e0e0e0; /* Fundo mais claro */
    position: relative;
}

#progress-bar::-webkit-progress-value {
    background-color: #4caf50; /* Cor de preenchimento (verde) */
    border-radius: 5px;
}

#progress-bar::-moz-progress-bar {
    background-color: #4caf50; /* Cor de preenchimento (verde) */
    border-radius: 5px;
}

#progress-text {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    font-weight: bold;
    color: black; /* Cor do texto */
}

/* Estilo da pergunta */
#pergunta-container {
    margin-bottom: 20px;
    font-size: 18px;
    text-align: center;
}

/* Alinha as imagens e os inputs de rádio */
#respostas-container label {
    display: inline-block; /* Mostra tudo na mesma linha */
    text-align: center;
    margin-right: 10px;
}

#respostas-container img {
    display: block;
    margin-top: 5px;
}

#respostas-container input[type="radio"] {
    margin-bottom: 5px;
}

/* Botões de navegação */
#controls {
    display: flex;
    justify-content: space-between;
}

#controls button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

#controls button:hover {
    background-color: #0056b3;
}
#respostas-container img {
    display: block;
    max-width: 100%;
    height: auto;
}

</style>