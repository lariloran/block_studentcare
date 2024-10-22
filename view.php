<?php
require_once('../../config.php');
require_login();

$coletaid = required_param('coletaid', PARAM_INT); // Recebe o ID da coleta
$context = context_course::instance($COURSE->id);  // Contexto do curso
$PAGE->set_url('/blocks/ifcare/view.php', array('coletaid' => $coletaid));
$PAGE->set_context($context);
$PAGE->set_title("Coleta de Emoções");

$userid = $USER->id; // Obtém o ID do aluno

$coletaR = $DB->get_record('ifcare_cadastrocoleta', ['id' => $coletaid]);

// Verifica se o aluno já respondeu a esta coleta
$respostasExistentes = $DB->get_records('ifcare_resposta', ['coleta_id' => $coletaid, 'aluno_id' => $userid]);

if ($respostasExistentes) {
    // Se o aluno já respondeu, exibe o modal informando
    echo $OUTPUT->header();
    echo '
    
    <script>
function irParaHome() {
    window.location.href = "' . $CFG->wwwroot . '";
}
</script>
    <style>
/* Estilo para o modal quando o aluno já respondeu à coleta */
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
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra para destaque */
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

.modal h2 {
    color: #000000;
    font-size: 24px;
    margin-bottom: 15px;
    font-weight: bold;
}

.modal p {
    font-size: 16px;
    margin-bottom: 20px;
    color: #333;
}

.modal-btn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.modal-btn:hover {
    background-color: #45a049;
}
</style>
    <div id="modal-ja-respondido" class="modal" style="display:block;">
        <div class="modal-content">
            <span class="close" onclick="irParaHome()">&times;</span>
            <h2>Coleta já Respondida</h2>
            <p>Você já respondeu a esta coleta de emoções. Obrigado pela sua participação!</p>
            <button class="modal-btn" onclick="irParaHome()">Ir para Home</button>
        </div>
    </div>';
    echo $OUTPUT->footer();
    return;
}

// Verifica se já existe uma resposta do TCLE para este usuário e curso
$tcle_records = $DB->get_records('ifcare_tcle_resposta', ['aluno_id' => $userid, 'curso_id' => $coletaR->curso_id]);

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
    // Verifica se os dados são uma requisição JSON para salvar respostas ou uma aceitação de TCLE
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Verifica se é uma requisição para salvar respostas
    if (isset($data['coleta_id']) && isset($data['aluno_id']) && isset($data['respostas'])) {
        try {
            $coletaid = $data['coleta_id'];
            $alunoid = $data['aluno_id'];
            
            // Verifica se o usuário já respondeu a essa coleta
            $respostasExistentes = $DB->get_records('ifcare_resposta', ['coleta_id' => $coletaid, 'aluno_id' => $alunoid]);

            if ($respostasExistentes) {
                // Se já respondeu, retorne uma mensagem de erro
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Você já respondeu a essa coleta.']);
                exit;
            }

            $respostas = $data['respostas']; // Array com as respostas do aluno

            foreach ($respostas as $pergunta_id => $resposta) {
                if ($resposta !== null) {
                    // Verifica se a pergunta existe no banco de dados
                    $pergunta = $DB->get_record('ifcare_pergunta', ['id' => $pergunta_id]);

                    if ($pergunta) {
                        // Prepara o objeto de resposta
                        $nova_resposta = new stdClass();
                        $nova_resposta->pergunta_id = $pergunta->id;
                        $nova_resposta->aluno_id = $alunoid;
                        $nova_resposta->coleta_id = $coletaid;
                        $nova_resposta->resposta = $resposta;
                        $nova_resposta->data_resposta = date('Y-m-d H:i:s');

                        // Insere no banco de dados
                        $DB->insert_record('ifcare_resposta', $nova_resposta);
                    }
                }
            }

            // Retorna uma resposta de sucesso em JSON
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;

        } catch (Exception $e) {
            // Em caso de erro, retorna a mensagem de erro em JSON
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }

    // Verifica se a aceitação do TCLE foi enviada
    $tcle_aceito_form = optional_param('tcle_aceito', 0, PARAM_INT);
    if ($tcle_aceito_form == 1 || $tcle_aceito_form == 0) {
        if (empty($tcle_records)) {
            $DB->insert_record('ifcare_tcle_resposta', (object)[
                'aluno_id' => $userid,
                'coleta_id' => $coletaid,
                'tcle_aceito' => $tcle_aceito_form,
                'curso_id' => $coletaR->curso_id,
                'data_resposta' => date('Y-m-d H:i:s')
            ]);
        }

        // Redireciona conforme a resposta do TCLE
        if ($tcle_aceito_form == 1) {
            redirect($PAGE->url); // Recarrega a página para exibir as perguntas
        } else {
            redirect($CFG->wwwroot . '/my'); // Redireciona para o dashboard se não aceitar
        }
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

// Verifica se a coleta ainda está dentro do prazo
$agora = time();
if ($agora < strtotime($coletaR->data_inicio)) {
    echo "<div class='mensagem-sucesso'>A coleta ainda não começou. Ela estará disponível a partir de " . date('d/m/Y H:i', strtotime($coletaR->data_inicio)) . ".</div>";
    echo $OUTPUT->footer();
    return;
}
if ($agora > strtotime($coletaR->data_fim)) {
    echo "<div class='mensagem-aviso'>O prazo para responder a esta coleta expirou em " . date('d/m/Y H:i', strtotime($coletaR->data_fim)) . ".</div>";
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

// Converte as perguntas para JSON
$perguntas_json = json_encode(array_values($perguntas));
?>

<!-- Exibição do TCLE (se ainda não aceito) -->
<div id="tcle-container" style="display: <?php echo $tcle_aceito ? 'none' : 'block'; ?>;">
    <form id="tcle-form" method="POST" class="tcle-form">
        <input type="hidden" id="tcle_aceito" name="tcle_aceito" value="0">
        <p class="tcle-title"><strong>Termo de Consentimento Livre e Esclarecido (TCLE)</strong></p>
        <p class="tcle-description">
            Você aceita participar desta coleta de emoções, sabendo que suas respostas (incluindo seu nome e e-mail) serão usadas para fins acadêmicos e pedagógicos?
        </p>
        <div id="respostas-tcle" class="respostas-tcle">
            <button class="buttonTcle" id="aceito-btn" type="button" onclick="enviarResposta(1)">Aceito</button>
            <button class="buttonTcle" id="nao-aceito-btn" type="button" onclick="enviarResposta(0)">Não Aceito</button>
        </div>
    </form>
</div>

<!-- Exibição do questionário -->
<?php if ($tcle_aceito): ?>
<div id="quiz-container">
    <div class="titulo-coleta">Coleta de Emoções</div>
    <div id="progress-bar-container">
        <progress id="progress-bar" value="0" max="100"></progress>
        <span id="progress-text">0%</span>
    </div>
    <div id="pergunta-container"></div>

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

    <div id="controls">
        <button id="voltar-btn" onclick="voltarPergunta()">Voltar</button>
        <button id="avancar-btn" onclick="avancarPergunta()">Avançar</button>
    </div>
</div>
<?php endif; ?>

<!-- Modais de erro e sucesso -->
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
let totalPerguntas = perguntas.length;
let respostasSelecionadas = {};

// Função para redirecionar para a página inicial do Moodle
function irParaHome() {
    window.location.href = '<?php echo $CFG->wwwroot; ?>'; // Redireciona para o dashboard ou página inicial do Moodle
}

// Função para exibir uma pergunta
function mostrarPergunta(index) {
    let pergunta = perguntas[index];
    let perguntaContainer = document.getElementById('pergunta-container');
    if (!perguntaContainer) {
        console.error("O elemento 'pergunta-container' não foi encontrado.");
        return;
    }

    perguntaContainer.innerHTML = `
        <p>
            <strong>${pergunta.emocao_nome}</strong>
            <span class="tooltip-icon">
                &#9432;
                <span class="tooltip-text">${pergunta.texto_tooltip}</span>
            </span>
        </p>
        <p class="pergunta-texto">${pergunta.pergunta_texto}</p>
    `;

    document.querySelectorAll('.emoji-button').forEach(btn => {
        btn.classList.remove('selected');
    });

    if (respostasSelecionadas[pergunta.id] !== undefined) {
        document.querySelector(`.emoji-button[data-value="${respostasSelecionadas[pergunta.id]}"]`).classList.add('selected');
    }

    let progresso = Math.round(((index + 1) / totalPerguntas) * 100);
    document.getElementById('progress-bar').value = progresso;
    document.getElementById('progress-text').innerText = `${progresso}%`;
}

// Função para capturar resposta
document.querySelectorAll('.emoji-button').forEach(button => {
    button.addEventListener('click', function() {
        let valor = this.getAttribute('data-value');
        let pergunta = perguntas[perguntaAtual];

        respostasSelecionadas[pergunta.id] = valor;

        document.querySelectorAll('.emoji-button').forEach(btn => {
            btn.classList.remove('selected');
        });
        this.classList.add('selected');
    });
});

function enviarResposta(valor) {
    document.getElementById('tcle_aceito').value = valor;
    document.getElementById('tcle-form').submit();
}



function voltarPergunta() {
    if (perguntaAtual > 0) {
        perguntaAtual--;
        mostrarPergunta(perguntaAtual);
    }
}

let coletaConcluida = false; // Variável para controlar se a coleta já foi concluída

// Função para avançar para a próxima pergunta
function avancarPergunta() {
    if (coletaConcluida) {
        abrirModal('modal-sucesso'); // Se já foi concluído, abre o modal novamente
        return;
    }

    if (respostasSelecionadas[perguntas[perguntaAtual].id] !== undefined) {
        if (perguntaAtual < totalPerguntas - 1) {
            perguntaAtual++;
            mostrarPergunta(perguntaAtual);
        } else {
            // Enviar as respostas quando todas as perguntas forem respondidas
            enviarRespostas();
        }
    } else {
        abrirModal('modal-erro'); // Exibe o modal de erro se nenhuma resposta for selecionada
    }
}

// Função para enviar as respostas para o backend
function enviarRespostas() {
    if (coletaConcluida) {
        abrirModal('modal-sucesso'); // Se já foi concluído, abre o modal novamente
        return;
    }

    const dadosRespostas = {
        coleta_id: <?php echo $coletaid; ?>,
        aluno_id: <?php echo $userid; ?>,
        respostas: respostasSelecionadas // Enviar o objeto com respostas associadas ao ID da pergunta
    };

    fetch(window.location.href, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosRespostas)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            coletaConcluida = true; // Marca a coleta como concluída
            abrirModal('modal-sucesso'); // Exibe o modal de sucesso ao concluir a coleta
        } else {
            console.error('Erro ao salvar as respostas:', data.error);
        }
    });}


function abrirModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function fecharModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onload = function() {
    if (<?php echo json_encode($tcle_aceito); ?>) {
        mostrarPergunta(perguntaAtual);
    }
};
</script>

<?php
echo $OUTPUT->footer();
?>

</script>



<style>
    /* Estilo para o container do TCLE */
#tcle-container {
    text-align: center;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
}

/* Estilo para o título do TCLE */
.tcle-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 15px;
    color: #333;
}

/* Estilo para a descrição do TCLE */
.tcle-description {
    font-size: 16px;
    margin-bottom: 20px;
    color: #555;
}

/* Alinhar os botões lado a lado */
.respostas-tcle {
    display: flex;
    justify-content: center;
    gap: 20px; /* Espaçamento entre os botões */
}

/* Estilo dos botões TCLE */
.buttonTcle {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
}

.buttonTcle:hover {
    background-color: #45a049;
}

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
