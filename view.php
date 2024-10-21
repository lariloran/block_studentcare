<?php
require_once('../../config.php');
require_login();

$coletaid = required_param('coletaid', PARAM_INT); // Recebe o ID da coleta
$context = context_course::instance($COURSE->id);  // Contexto do curso
$PAGE->set_url('/blocks/ifcare/view.php', array('coletaid' => $coletaid));
$PAGE->set_context($context);
$PAGE->set_title("Coleta de Emoções");

$userid = $USER->id; // Obtém o ID do aluno

// Verifica se já existe uma resposta do TCLE para este usuário e curso
$tcle_records = $DB->get_records('ifcare_tcle_resposta', ['aluno_id' => $userid, 'curso_id' => $COURSE->id]);

// Verifica se algum dos registros tem o TCLE aceito
$tcle_aceito = false;
foreach ($tcle_records as $record) {
    if ($record->tcle_aceito == 1) {
        $tcle_aceito = true;
        break;
    }
}

// Adiciona o evento de aceitação ou recusa do TCLE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura a resposta do TCLE do formulário
    $tcle_aceito_form = optional_param('tcle_aceito', 0, PARAM_INT);

    if (empty($tcle_records)) {
        // Insere a resposta na tabela ifcare_tcle_resposta
        $DB->insert_record('ifcare_tcle_resposta', (object)[
            'aluno_id' => $userid,
            'coleta_id' => $coletaid,
            'tcle_aceito' => $tcle_aceito_form,
            'curso_id' => $COURSE->id,  // Adiciona o ID do curso
            'data_resposta' => date('Y-m-d H:i:s')
        ]);
    }

    // Se o aluno aceitou o TCLE, recarrega a página para exibir as perguntas
    if ($tcle_aceito_form == 1) {
        redirect($PAGE->url);
    } else {
        // Usuário não aceitou o TCLE, redireciona para o dashboard
        redirect($CFG->wwwroot . '/my', 'Você deve aceitar o TCLE para continuar.');
    }
}

echo $OUTPUT->header();

echo '<style>
/* Estilo para mensagens de aviso */
.mensagem-aviso {
    color: #ff0000;
    background-color: #ffe6e6;
    border: 1px solid #ff6666;
    padding: 15px;
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 20px auto;
}

/* Estilo para mensagens de sucesso */
.mensagem-sucesso {
    color: #006600;
    background-color: #e6ffe6;
    border: 1px solid #66cc66;
    padding: 15px;
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 20px auto;
}

</style>';

// Busca os detalhes da coleta, incluindo as datas de início e fim
$coleta = $DB->get_record('ifcare_cadastrocoleta', ['id' => $coletaid], '*', MUST_EXIST);

// Verifica se a coleta ainda está dentro do prazo
$agora = time(); // Timestamp atual

if ($agora < strtotime($coleta->data_inicio)) {
    echo "<div class='mensagem-sucesso'>A coleta ainda não começou. Ela estará disponível a partir de " . date('d/m/Y H:i', strtotime($coleta->data_inicio)) . ".</div>";
    echo $OUTPUT->footer();
    return;
}

if ($agora > strtotime($coleta->data_fim)) {
    echo "<div class='mensagem-aviso'>O prazo para responder a esta coleta expirou em " . date('d/m/Y H:i', strtotime($coleta->data_fim)) . ".</div>";
    echo $OUTPUT->footer();
    return;
}

// Busca as perguntas associadas às emoções da coleta
$perguntas = $DB->get_records_sql("
    SELECT p.id, p.pergunta_texto, e.nome AS emocao_nome, e.txttooltip AS texto_tooltip
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
    <div class="titulo-coleta">Coleta de Emoções</div>

    <!-- TCLE Container (Só será exibido se o usuário ainda não aceitou) -->
    <div id="tcle-container" style="display: <?php echo $tcle_aceito ? 'none' : 'block'; ?>;">
        <form id="tcle-form" method="POST">
            <input type="hidden" id="tcle_aceito" name="tcle_aceito" value="0">
            <p><strong>Termo de Consentimento Livre e Esclarecido (TCLE)</strong></p>
            <p>Você aceita participar desta coleta de emoções, sabendo que suas respostas (incluindo seu nome e e-mail) serão usadas para fins acadêmicos e pedagógicos?</p>
            <div id="respostas-tcle">
                <button class="emoji-button" id="aceito-btn" type="button" onclick="enviarResposta(1)">Aceito</button>
                <button class="emoji-button" id="nao-aceito-btn" type="button" onclick="enviarResposta(0)">Não Aceito</button>
            </div>
        </form>
    </div>

    <!-- Barra de progresso (inicialmente oculta) -->
    <div id="progress-bar-container" style="display: <?php echo $tcle_aceito ? 'block' : 'none'; ?>;">
        <progress id="progress-bar" value="0" max="100"></progress>
        <span id="progress-text">0%</span>
    </div>

    <!-- Perguntas (inicialmente oculto até o TCLE ser aceito) -->
    <div id="pergunta-container" style="display: <?php echo $tcle_aceito ? 'block' : 'none'; ?>;"></div>

    <!-- Botões de resposta (escala Likert com emojis como botões) -->
    <div id="respostas-container" style="display: <?php echo $tcle_aceito ? 'flex' : 'none'; ?>;">
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
    <div id="controls" style="display: <?php echo $tcle_aceito ? 'flex' : 'none'; ?>;">
        <button id="voltar-btn" onclick="voltarPergunta()">Voltar</button>
        <button id="avancar-btn" onclick="avancarPergunta()">Avançar</button>
    </div>
</div>

<div id="modal-erro" class="modal">
    <div class="modal-content">
        <span class="close" onclick="fecharModal('modal-erro')">&times;</span>
        <h2>Atenção</h2>
        <p>Por favor, selecione uma resposta antes de avançar.</p>
        <button class="modal-btn" onclick="fecharModal('modal-erro')">Entendido</button>
    </div>
</div>

<div id="modal-sucesso" class="modal">
    <div class="modal-content">
        <span class="close" onclick="fecharModal('modal-sucesso')">&times;</span>
        <h2>Coleta Concluída</h2>
        <p>Você completou todas as perguntas da coleta. Obrigado por participar!</p>
        <button class="modal-btn" onclick="fecharModal('modal-sucesso')">Fechar</button>
        <button class="modal-btn" onclick="irParaHome()">Ir para Home</button>
    </div>
</div>

<script>
let perguntas = <?php echo $perguntas_json; ?>;
let perguntaAtual = 0;

// Função para redirecionar para a página inicial do Moodle
function irParaHome() {
    window.location.href = '<?php echo $CFG->wwwroot; ?>'; // Redireciona para o dashboard ou página inicial do Moodle
}

// Função para exibir a primeira pergunta após o carregamento da página
window.onload = function() {
    if (<?php echo json_encode($tcle_aceito); ?>) {
        mostrarPergunta(perguntaAtual);
    }
};


let totalPerguntas = perguntas.length;
let respostaSelecionada = null;
let respostasSelecionadas = new Array(totalPerguntas).fill(null);

document.getElementById('nao-aceito-btn').addEventListener('click', function() {
    alert('Você deve aceitar o TCLE para continuar.');
    window.location.href = '<?php echo $CFG->wwwroot; ?>/my'; // Redireciona para a página inicial do usuário
});

function enviarResposta(valor) {
    document.getElementById('tcle_aceito').value = valor;
    document.getElementById('tcle-form').submit();
}

// Função para capturar o valor do botão clicado ou remover a seleção se clicar no mesmo
function selecionarResposta(valor) {
    if (respostaSelecionada === valor) {
        // Se o emoji clicado já estiver selecionado, desmarca a resposta
        respostaSelecionada = null;
        respostasSelecionadas[perguntaAtual] = null;

        // Remove a classe 'selected' de todos os botões
        document.querySelectorAll('.emoji-button').forEach(btn => {
            btn.classList.remove('selected');
        });
    } else {
        // Se for uma nova seleção, armazena a resposta e aplica a classe 'selected'
        respostaSelecionada = valor;
        respostasSelecionadas[perguntaAtual] = valor;

        // Remove a classe 'selected' de todos os botões e adiciona à resposta selecionada
        document.querySelectorAll('.emoji-button').forEach(btn => {
            btn.classList.remove('selected');
        });
        document.querySelector(`.emoji-button[data-value="${valor}"]`).classList.add('selected');
    }
}

document.querySelectorAll('.emoji-button').forEach(button => {
    button.addEventListener('click', function() {
        selecionarResposta(this.getAttribute('data-value'));
    });
});


// Função para exibir o modal
function abrirModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

// Função para fechar o modal
function fecharModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Função para avançar para a próxima pergunta
function avancarPergunta() {
    if (respostasSelecionadas[perguntaAtual] !== null) {
        if (perguntaAtual < totalPerguntas - 1) {
            perguntaAtual++;
            mostrarPergunta(perguntaAtual);
        } else {
            abrirModal('modal-sucesso'); // Exibe o modal de sucesso ao concluir a coleta
        }
    } else {
        abrirModal('modal-erro'); // Exibe o modal de erro se não houver resposta selecionada
    }
}

// Função para exibir a pergunta atual (já existente no seu código)
function mostrarPergunta(index) {
    if (index >= 0 && index < totalPerguntas) {
        let perguntaContainer = document.getElementById('pergunta-container');
        perguntaContainer.innerHTML = `
            <p>
                <strong>${perguntas[index].emocao_nome}</strong>
                <span class="tooltip-icon">
                    &#9432;
                    <span class="tooltip-text">${perguntas[index].texto_tooltip}</span>
                </span>
            </p>
            <p class="pergunta-texto">${perguntas[index].pergunta_texto}</p>
        `;

        // Remove a classe 'selected' de todos os botões
        document.querySelectorAll('.emoji-button').forEach(btn => {
            btn.classList.remove('selected');
        });

        // Restaura a seleção anterior se houver
        if (respostasSelecionadas[index] !== null) {
            document.querySelector(`.emoji-button[data-value="${respostasSelecionadas[index]}"]`).classList.add('selected');
            respostaSelecionada = respostasSelecionadas[index];
        }

        // Atualiza a barra de progresso
        let progresso = Math.round(((index + 1) / totalPerguntas) * 100);
        document.getElementById('progress-bar').value = progresso;
        document.getElementById('progress-text').innerText = `${progresso}%`;
    }
}
function voltarPergunta() {
    if (perguntaAtual > 0) {
        perguntaAtual--;
        mostrarPergunta(perguntaAtual);
    }
}
</script>

<?php
echo $OUTPUT->footer();
?>



<style>

    
.modal {
    display: none; /* Oculto por padrão */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Fundo escuro */
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    text-align: center;
    border-radius: 10px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

/* Container para alinhar os botões juntos */
.modal-btn-container {
    display: inline-flex; /* Usar inline-flex para garantir que o container se ajuste ao conteúdo dos botões */
    justify-content: center;
    gap: 20px; /* Espaçamento de 20px entre os botões */
    margin-top: 20px;
    width: auto; /* Garante que o container não se expanda */
}

/* Estilo dos botões no modal */
.modal-btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: auto; /* Garante que o botão tenha largura baseada no conteúdo */
    min-width: 100px; /* Define uma largura mínima para os botões */
    text-align: center;
    display: inline-block; /* Garante que o botão se comporte como um elemento inline-block */
    margin-bottom: 4px;
}

.modal-btn:hover {
    background-color: #45a049;
}


/* Centralizar o título dentro do modal */
.titulo-coleta {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
}

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

/* Estilo do ícone de interrogação ao lado da emoção */
.tooltip-icon {
    position: relative;
    cursor: pointer;
    margin-left: 5px;
    color: #0073e6;
    font-size: 16px;
    display: inline-block;
}

/* Tooltip customizado */
.tooltip-text {
    visibility: hidden;
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 5px;
    border-radius: 5px;
    position: absolute;
    z-index: 1;
    top: 125%;
    left: 50%;
    transform: translateX(-50%);
    white-space: normal;
    width: 250px;
    opacity: 0;
    transition: opacity 0.3s ease;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Exibe o tooltip quando o mouse está sobre o ícone */
.tooltip-icon:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
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
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    cursor: pointer;
    text-align: center;
    transition: transform 0.2s ease-in-out;
    margin: 0 10px;
}

.emoji-img {
    display: block;
    margin-bottom: 5px;
    width: 48px;
    height: 48px;
}

/* Estilo do texto Likert abaixo dos emojis */
.emoji-button span {
    font-size: 14px;
    color: #000;
    text-align: center;
}

/* Efeito de hover - faz o botão crescer */
.emoji-button:hover, .emoji-button.selected {
    transform: scale(1.2);
}

/* Botões de navegação */
#controls {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    padding: 0 20px;
}

#controls button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s;
}

#controls button:hover {
    background-color: #218838;
}

</style>
