<?php
require_once('../../config.php');
require_login();

$coletaid = required_param('coletaid', PARAM_INT);
$context = context_course::instance($COURSE->id);
$PAGE->set_url('/blocks/ifcare/view.php', array('coletaid' => $coletaid));
$PAGE->set_context($context);
$PAGE->set_title("Coleta de Emoções");


if (!$DB->record_exists('ifcare_cadastrocoleta', ['id' => $coletaid])) {
    echo $OUTPUT->header();
    echo html_writer::tag('div', 'Desculpe, esta coleta não está mais disponível. Entre em contato com o administrador ou professor para mais informações.', ['class' => 'alert alert-info']);
    echo $OUTPUT->footer();
    exit;
}

$userid = $USER->id;

$coletaR = $DB->get_record('ifcare_cadastrocoleta', ['id' => $coletaid]);
$cursoR = $DB->get_record('course', ['id' => $coletaR->curso_id]);

$is_enrolled = is_enrolled(context_course::instance($coletaR->curso_id), $userid);

if (!$is_enrolled) {
    redirect(new moodle_url('/course/view.php', ['id' => $COURSE->id]));
    exit;
}
$respostasExistentes = $DB->get_records('ifcare_resposta', [
    'coleta_id' => $coletaid,
    'usuario_id' => $userid
]);

if ($respostasExistentes) {
    echo $OUTPUT->header();

    $redirectUrl = new moodle_url("/course/view.php", ['id' => intval($coletaR->curso_id)]);
    echo '
    <script>
        function irParaHome() {
            window.location.href = "' . htmlspecialchars($redirectUrl) . '";
        }
    </script>
    <style>
        /* Estilo para o modal quando o usuario já respondeu à coleta */
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
            <button class="modal-btn" onclick="irParaHome()">Voltar para o curso</button>
        </div>
    </div>';

    echo $OUTPUT->footer();
    return;
}


$tcle_records = $DB->get_records('ifcare_tcle_resposta', ['usuario_id' => $userid, 'curso_id' => $coletaR->curso_id]);

$tcle_aceito = false;
foreach ($tcle_records as $record) {
    if ($record->tcle_aceito == 1) {
        $tcle_aceito = true;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['coleta_id']) && isset($data['usuario_id']) && isset($data['respostas'])) {
        try {
            $coletaid = clean_param($data['coleta_id'], PARAM_INT);
            $usuarioid = clean_param($data['usuario_id'], PARAM_INT);

            $respostasExistentes = $DB->get_records('ifcare_resposta', ['coleta_id' => $coletaid, 'usuario_id' => $usuarioid]);

            if ($respostasExistentes) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Você já respondeu a essa coleta.']);
                exit;
            }

            $respostas = $data['respostas'];
            foreach ($respostas as $pergunta_id => $resposta) {
                $pergunta_id = clean_param($pergunta_id, PARAM_INT);
                $resposta = clean_param($resposta, PARAM_TEXT);

                if ($resposta !== null) {
                    $pergunta = $DB->get_record('ifcare_pergunta', ['id' => $pergunta_id]);
                    if ($pergunta) {
                        $nova_resposta = new stdClass();
                        $nova_resposta->pergunta_id = $pergunta->id;
                        $nova_resposta->usuario_id = $usuarioid;
                        $nova_resposta->coleta_id = $coletaid;
                        $nova_resposta->resposta = $resposta;
                        $nova_resposta->data_resposta = date('Y-m-d H:i:s');

                        $DB->insert_record('ifcare_resposta', $nova_resposta);
                    }
                }
            }


            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;

        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }


    $tcle_aceito_form = optional_param('tcle_aceito', 0, PARAM_INT);
    if ($tcle_aceito_form == 1) {
        if (empty($tcle_records)) {
            $DB->insert_record('ifcare_tcle_resposta', (object) [
                'usuario_id' => $userid,
                'coleta_id' => $coletaid,
                'tcle_aceito' => $tcle_aceito_form,
                'curso_id' => $coletaR->curso_id,
                'data_resposta' => date('Y-m-d H:i:s')
            ]);
        }
        redirect($PAGE->url);
    } else {
        redirect(new moodle_url("/course/view.php", ['id' => intval($coletaR->curso_id)]));
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

$perguntas = $DB->get_records_sql("
    SELECT p.id, p.pergunta_texto, e.nome AS emocao_nome, e.txttooltip AS texto_tooltip, p.classeaeq_id AS classe_id
    FROM {ifcare_pergunta} p
    JOIN {ifcare_emocao} e ON e.id = p.emocao_id
    JOIN {ifcare_associacao_classe_emocao_coleta} a ON a.emocao_id = e.id
    WHERE a.cadastrocoleta_id = :coletaid
", ['coletaid' => $coletaid]);

$cursoNome = $cursoR->fullname;

if (!$perguntas) {
    $mensagem = "Nenhuma pergunta foi encontrada para esta coleta. Entre em contato com o professor da disciplina de <strong>{$cursoNome}</strong> para mais informações.";
    echo html_writer::tag('div', $mensagem, ['class' => 'alert alert-info']);
    echo $OUTPUT->footer();
    exit;
}

$perguntas_json = json_encode(array_values($perguntas));
?>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<div id="tcle-container" style="display: <?php echo $tcle_aceito ? 'none' : 'block'; ?>;">
    <form id="tcle-form" method="POST" class="tcle-form">
        <input type="hidden" id="tcle_aceito" name="tcle_aceito" value="0">
        <p class="tcle-title"><strong>Termo de Consentimento Livre e Esclarecido (TCLE)</strong></p>
        <p class="tcle-description">
            Sua participação nesta coleta de emoções para a disciplina <strong><?php echo $cursoR->fullname; ?></strong>
            é muito importante para nós. Ao responder, você autoriza o uso das suas respostas (incluindo seu nome e
            e-mail) para fins acadêmicos e pedagógicos, contribuindo para pesquisas que buscam aprimorar o ensino e a
            aprendizagem, promovendo um ambiente educacional mais acolhedor e eficaz. Agradecemos sua colaboração!
        </p>
        <div id="respostas-tcle" class="respostas-tcle">
            <button class="buttonTcle" id="aceito-btn" type="button" onclick="enviarResposta(1)">Aceito</button>
            <button class="buttonTcle" id="nao-aceito-btn" type="button" onclick="enviarResposta(0)">Não Aceito</button>
        </div>
    </form>
</div>

<?php if ($tcle_aceito): ?>
    <div id="quiz-container">
        <div id="titulo-coleta" class="titulo-coleta"></div>
        <div id="progress-bar-container">
            <progress id="progress-bar" value="0" max="100"></progress>
            <span id="progress-text">0%</span>
        </div>

        <div id="pergunta-container">
        </div>


        <div id="respostas-container">
            <button class="emoji-button" data-value="1">
                <span class="emoji" id="emoji-1"></span>
                <span>Discordo Totalmente</span>
            </button>
            <button class="emoji-button" data-value="2">
                <span class="emoji" id="emoji-2"></span>
                <span>Discordo</span>
            </button>
            <button class="emoji-button" data-value="3">
                <span class="emoji" id="emoji-3"></span>
                <span>Neutro</span>
            </button>
            <button class="emoji-button" data-value="4">
                <span class="emoji" id="emoji-4"></span>
                <span>Concordo</span>
            </button>
            <button class="emoji-button" data-value="5">
                <span class="emoji" id="emoji-5"></span>
                <span>Concordo Totalmente</span>
            </button>
        </div>

        <div id="controls">
            <button id="voltar-btn" onclick="voltarPergunta()">Voltar</button>
            <a href="https://poa.ifrs.edu.br/index.php/editais-2/apoio-academico" target="_blank"
                id="ajuda-emocional-link">Precisa de ajuda emocional?</a>

            <button id="avancar-btn" onclick="avancarPergunta()">Avançar</button>
        </div>
    </div>
<?php endif; ?>

<div id="feedback-container"
    style="display: none; text-align: center; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px;">
    <h3 class="feedback-title" style="font-size: 18px; font-weight: bold; margin-bottom: 15px; color: #333;">O que você
        achou desta coleta?</h3>
    <textarea id="feedback-text" rows="4" cols="50" placeholder="Escreva seu feedback aqui..."
        style="width: 100%; max-width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 15px; font-size: 16px;"></textarea>
    <div class="feedback-btn-container" style="display: flex; justify-content: center;">
        <button class="buttonTcle" onclick="enviarFeedback()" style="padding: 10px 20px;">Enviar Feedback</button>
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
        <button class="modal-btn" onclick="irParaHome()">Voltar para o curso</button>
    </div>
</div>

<script>
    const emotionEmojiMap = {
        'Alegria': ['😐', '🙂', '😀', '😄', '😍'],
        'Esperança': ['😟', '😐', '🙂', '😊', '✨'],
        'Orgulho': ['😔', '😐', '🙂', '😌', '🏅'],
        'Raiva': ['😌', '😐', '😕', '😠', '😡'],
        'Ansiedade': ['😌', '😐', '😬', '😰', '😱'],
        'Vergonha': ['😌', '😐', '😳', '😖', '🙈'],
        'Desespero': ['😌', '😐', '😔', '😟', '😭'],
        'Tédio': ['🤩', '🙂', '😐', '😕', '😴']
    };

    function updateEmojisForEmotion(emocao) {
        const emojis = emotionEmojiMap[emocao] || ['😕', '😟', '😐', '🙂', '😀'];
        document.getElementById('emoji-1').textContent = emojis[0];
        document.getElementById('emoji-2').textContent = emojis[1];
        document.getElementById('emoji-3').textContent = emojis[2];
        document.getElementById('emoji-4').textContent = emojis[3];
        document.getElementById('emoji-5').textContent = emojis[4];
    }

    let perguntas = <?php echo $perguntas_json; ?>;
    let perguntaAtual = 0;
    let totalPerguntas = perguntas.length;
    let respostasSelecionadas = {};

    function irParaHome() {
        window.location.href = '<?php echo new moodle_url("/course/view.php", ['id' => intval($coletaR->curso_id)]); ?>';
    }



    let ultimaClasseId = null;
    let introducoesExibidas = {};

    function gerarMensagem(emocoes, tooltips, classeId, cursoNome, nomeRecurso = null) {
    const plural = emocoes.length > 1;

    const emocoesComTooltip = emocoes.map((emocao, index) => {
        return `
        <strong>${emocao}</strong>
        <span class="tooltip-icon">
            &#9432;
            <span class="tooltip-text">${tooltips[index]}</span>
        </span>
    `;
    }).join(", ");

    let textoAtividade;

    switch (classeId) {
        case "1": // Emoções Relacionadas às Aulas
            textoAtividade = nomeRecurso
                ? `da aula <strong>${nomeRecurso}</strong> da disciplina de <strong>${cursoNome}</strong>`
                : `das aulas da disciplina de <strong>${cursoNome}</strong>`;
            break;

        case "2": // Emoções Relacionadas ao Aprendizado
            textoAtividade = nomeRecurso
                ? `do estudo do <strong>${nomeRecurso}</strong> pertencente à disciplina de <strong>${cursoNome}</strong>`
                : `da sua rotina de estudos na disciplina de <strong>${cursoNome}</strong>`;
            break;

        case "3": // Emoções Relacionadas às Atividades Avaliativas
            textoAtividade = nomeRecurso
                ? `da atividade avaliativa <strong>${nomeRecurso}</strong> da disciplina de <strong>${cursoNome}</strong>`
                : `de atividades avaliativas da disciplina de <strong>${cursoNome}</strong>`;
            break;

        default:
            textoAtividade = `da disciplina de <strong>${cursoNome}</strong>`;
    }

    return `
    <p>
        As perguntas a seguir referem-se ${plural ? 'às emoções' : 'à emoção'} 
        ${emocoesComTooltip}
        que você pode sentir 
        <strong>antes</strong>, <strong>durante</strong> ou <strong>depois</strong> ${textoAtividade}. 
        Por favor, leia cada item com atenção e responda utilizando a escala fornecida.
    </p>`;
}

function mostrarTextoInicial(pergunta, emocoesDaClasse, tooltipsDaClasse) {
    let cursoNome = <?php echo json_encode($cursoNome); ?>;

    // Obter o nome do recurso atrelado
    let nomeRecurso = <?php
        $resource_name = '--';
        $coleta = $DB->get_record('ifcare_cadastrocoleta', ['id' => $coletaid], '*');

        if ($coleta && $coleta->resource_id_atrelado) {
            $module = $DB->get_record('course_modules', ['id' => $coleta->resource_id_atrelado], 'module');
            if ($module) {
                $mod_info = $DB->get_record('modules', ['id' => $module->module], 'name');
                if ($mod_info) {
                    $resource_name_record = $DB->get_record('course_modules', ['id' => $coleta->resource_id_atrelado], 'id, instance');
                    if ($resource_name_record) {
                        $resource_name = $DB->get_field($mod_info->name, 'name', ['id' => $resource_name_record->instance]);
                    }
                }
            }
        }
        echo json_encode($resource_name);
    ?>;

    let mensagemInicial = gerarMensagem(
        emocoesDaClasse,
        tooltipsDaClasse,
        pergunta.classe_id,
        cursoNome,
        nomeRecurso !== '--' ? nomeRecurso : null
    );

    document.getElementById('titulo-coleta').innerHTML = mensagemInicial;
    document.getElementById('pergunta-container').innerHTML = '';
    document.getElementById('pergunta-container').style.display = 'none'; 
    document.getElementById('respostas-container').style.display = 'none'; 
    document.getElementById('progress-bar-container').style.display = 'none'; 
}



    let contadorPerguntas = 1; // Variável para rastrear o número da pergunta exibida
    let ultimaDirecao = "avancar"; // Variável para rastrear a última direção de navegação

    function mostrarPergunta(index) {
        let pergunta = perguntas[index];
        let cursoNome = <?php echo json_encode($cursoNome); ?>;

        const emocoesDaClasse = [...new Set(
            perguntas
                .filter(p => p.classe_id === pergunta.classe_id)
                .map(p => p.emocao_nome)
        )];
        const tooltipsDaClasse = [...new Set(
            perguntas
                .filter(p => p.classe_id === pergunta.classe_id)
                .map(p => p.texto_tooltip)
        )];

        if (pergunta.classe_id !== ultimaClasseId) {
            if (!introducoesExibidas[pergunta.classe_id]) {
                mostrarTextoInicial(pergunta, emocoesDaClasse, tooltipsDaClasse);
                introducoesExibidas[pergunta.classe_id] = true;
                ultimaClasseId = pergunta.classe_id;
                return;
            }
        }

        document.getElementById('pergunta-container').style.display = 'block';

        updateEmojisForEmotion(pergunta.emocao_nome);

        document.getElementById('titulo-coleta').innerHTML = `
        ${cursoNome} - ${pergunta.emocao_nome}
        <span class="tooltip-icon">
            &#9432;
            <span class="tooltip-text">${pergunta.texto_tooltip}</span>
        </span>
    `;

        let perguntaContainer = document.getElementById('pergunta-container');
        if (!perguntaContainer) {
            console.error("O elemento 'pergunta-container' não foi encontrado.");
            return;
        }

        perguntaContainer.classList.remove('animate');

        setTimeout(() => {
            perguntaContainer.innerHTML = `
          <p class="pergunta-texto">${contadorPerguntas}. ${pergunta.pergunta_texto}</p>
        `;
            perguntaContainer.classList.add('animate');
        }, 100);

        document.getElementById('respostas-container').style.display = 'flex';
        document.getElementById('progress-bar-container').style.display = 'block';

        let progresso = Math.round(((index + 1) / totalPerguntas) * 100);
        document.getElementById('progress-bar').value = progresso;
        document.getElementById('progress-text').innerText = `${progresso}%`;

        document.querySelectorAll('.emoji-button').forEach(btn => btn.classList.remove('selected'));
        if (respostasSelecionadas[pergunta.id] !== undefined) {
            document
                .querySelector(`.emoji-button[data-value="${respostasSelecionadas[pergunta.id]}"]`)
                .classList.add('selected');
        }
    }

    document.querySelectorAll('.emoji-button').forEach(button => {
        button.addEventListener('click', function () {
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

            let pergunta = perguntas[perguntaAtual];
            let classeAtual = pergunta.classe_id;

            let primeiraPerguntaDaClasse = perguntas.findIndex(p => p.classe_id === classeAtual);

            if (perguntaAtual === primeiraPerguntaDaClasse) {
                let emocoesDaClasse = [...new Set(
                    perguntas.filter(p => p.classe_id === classeAtual).map(p => p.emocao_nome)
                )];
                let tooltipsDaClasse = [...new Set(
                    perguntas.filter(p => p.classe_id === classeAtual).map(p => p.texto_tooltip)
                )];
                mostrarTextoInicial(pergunta, emocoesDaClasse, tooltipsDaClasse);
            } else {
                mostrarPergunta(perguntaAtual);
            }
            contadorPerguntas--; // Decrementa o contador ao voltar

        }
    }


    let coletaConcluida = false;
    let feedbackEnviado = false;

    function avancarPergunta() {
    let pergunta = perguntas[perguntaAtual];
    let tituloAtual = document.getElementById('titulo-coleta').innerText;

    if (tituloAtual.includes('As perguntas a seguir referem-se')) {
        perguntaAtual++;
        mostrarPergunta(perguntaAtual);
        return;
    }

    if (respostasSelecionadas[pergunta.id] !== undefined) {
        if (perguntaAtual < totalPerguntas - 1) {
            perguntaAtual++;
            mostrarPergunta(perguntaAtual);
            contadorPerguntas++;
        } else {
            // Finaliza coleta e exibe modal de feedback
            enviarRespostas().then(() => {
                console.log("Respostas enviadas com sucesso.");
                mostrarFeedback();
            }).catch(error => {
                console.error("Erro ao finalizar coleta:", error);
                abrirModal('modal-erro');
            });
        }
    } else {
        abrirModal('modal-erro');
    }
}

function mostrarFeedback() {
    // Oculta o quiz
    const quizContainer = document.getElementById('quiz-container');
    if (quizContainer) {
        quizContainer.style.display = 'none';
    }

    // Exibe o modal de feedback
    const feedbackContainer = document.getElementById('feedback-container');
    if (feedbackContainer) {
        feedbackContainer.style.display = 'block';
    } else {
        console.error("Container de feedback não encontrado.");
    }
}



function enviarRespostas() {
    const dadosRespostas = {
        coleta_id: <?php echo $coletaid; ?>,
        usuario_id: <?php echo $userid; ?>,
        respostas: respostasSelecionadas
    };

    // Retorna a Promise gerada pelo fetch
    return fetch(window.location.href, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosRespostas)
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            throw new Error(data.error || "Erro desconhecido");
        }
    });
}

    function enviarFeedback() {
    const feedbackText = document.getElementById('feedback-text').value;

    const dadosFeedback = {
        coleta_id: <?php echo $coletaid; ?>,
        usuario_id: <?php echo $userid; ?>,
        feedback: feedbackText || ""
    };

    fetch('feedback.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosFeedback)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Feedback enviado com sucesso.");
            irParaHome(); // Redireciona para o curso após o feedback
        } else {
            console.error("Erro ao enviar o feedback:", data.error);
        }
    })
    .catch(error => console.error("Erro ao enviar o feedback:", error));
}



    function abrirModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function fecharModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    window.onload = function () {
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
    #ajuda-emocional-link {
        color: #0073e6;
        font-size: 16px;
        text-decoration: none;
        margin: 0 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.3s ease;
    }

    #ajuda-emocional-link:hover {
        color: #005bb5;
        text-decoration: underline;
    }

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

    .tcle-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }

    .tcle-description {
        font-size: 16px;
        margin-bottom: 20px;
        color: #555;
    }

    .respostas-tcle {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

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

    .modal-btn-container {
        display: inline-flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
        width: auto;
    }

    .modal-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: auto;
        min-width: 100px;
        text-align: center;
        display: inline-block;
        margin-bottom: 4px;
    }

    .modal-btn:hover {
        background-color: #45a049;
    }

    .titulo-coleta {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    #quiz-container {
        width: 100%;
        max-width: 700px;
        min-height: 500px;
        margin: 0 auto;
        height: auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

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

    #pergunta-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 20px;
        text-align: center;
        font-weight: bold;
        color: #333;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
        transform: translateY(10px);
        opacity: 0;
        height: 100px;
        width: 100%;
        max-width: 700px;
        margin: 20px auto;
    }

    .titulo-coleta p {
        margin-top: 100px;
    }

    #pergunta-container.animate {
        transform: translateY(0);
        opacity: 1;
    }

    .pergunta-texto {
        font-family: 'Roboto', sans-serif;
        font-size: 24px;
        color: #333;
        margin: 0;
        padding: 0;
    }


    .pergunta-texto::after {
        content: '';
        display: block;
        width: 50%;
        margin: 10px auto 0;
        height: 4px;
        background: linear-gradient(90deg, #4caf50, #81c784);
        border-radius: 2px;
    }

    .etiqueta {
        display: inline-block;
        background-color: #4caf50;
        color: white;
        font-size: 12px;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 20px;
        margin-bottom: 10px;
    }


    .tooltip-icon {
        position: relative;
        cursor: pointer;
        margin-left: 5px;
        color: #0073e6;
        font-size: 16px;
        display: inline-block;
    }

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

    .tooltip-icon:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    #respostas-container {
        display: flex;
        justify-content: space-evenly;
        margin-bottom: 20px;
    }

    .emoji-button {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        cursor: pointer;
        text-align: center;
        transition: transform 0.2s ease-in-out, border 0.3s ease-in-out;
        margin: 0 10px;
        padding: 10px;
        position: relative;
    }


    .emoji-button span {
        font-size: 14px;
        /* Tamanho do texto */
        color: #000;
        text-align: center;
        padding-top: 5px;
    }

    .emoji-button:hover,
    .emoji-button.selected {
        transform: scale(1.1);
        /* Cresce suavemente */
    }


    .emoji-button:hover {
        border-image-source: linear-gradient(45deg, #2196F3, #81C784, #4CAF50);
        /* Gradiente alternado no hover */
    }


    .emoji-button span.emoji {
        font-size: 48px;
        /* Tamanho base dos emojis */
        transition: transform 0.3s ease, filter 0.3s ease;
        display: inline-block;
    }

    .emoji-button.selected span.emoji {
        transform: scale(1.5);
        /* Aumenta o tamanho do emoji selecionado */
        filter: drop-shadow(0 0 5px #4caf50);
        /* Adiciona um leve brilho */
    }

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