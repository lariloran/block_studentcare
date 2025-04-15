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
 * Get class emotions
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_login();

$coletaid = required_param('coletaid', PARAM_INT);
$context = context_course::instance($COURSE->id);
$PAGE->set_url('/blocks/studentcare/view.php', array('coletaid' => $coletaid));
$PAGE->set_context($context);
$PAGE->set_title(get_string('emotion-colect', 'block_studentcare'));

if (!$DB->record_exists('studentcare_cadastrocoleta', ['id' => $coletaid])) {
    echo $OUTPUT->header();
    echo html_writer::tag(
            'div',
            get_string('collection_not_available', 'block_studentcare'),
            ['class' => 'alert alert-info']
    );
    echo $OUTPUT->footer();
    exit;
}

$userid = $USER->id;

$coletar = $DB->get_record('studentcare_cadastrocoleta', ['id' => $coletaid]);
$cursor = $DB->get_record('course', ['id' => $coletar->curso_id]);

$isenrolled = is_enrolled(context_course::instance($coletar->curso_id), $userid);

if (!$isenrolled) {
    redirect(new moodle_url('/course/view.php', ['id' => $COURSE->id]));
    exit;
}
$respostasexistentes = $DB->get_records('studentcare_resposta', [
        'coleta_id' => $coletaid,
        'usuario_id' => $userid,
]);

if ($respostasexistentes) {
    echo $OUTPUT->header();

    $redirecturl = new moodle_url("/course/view.php", ['id' => intval($coletar->curso_id)]);
    echo '
    <script>
        function irParaHome() {
            window.location.href = "' . htmlspecialchars($redirecturl) . '";
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
        <h2>' . get_string('collection_already_answered', 'block_studentcare') . '</h2>
        <p>' . get_string('collection_already_answered_message', 'block_studentcare') . '</p>
        <button class="modal-btn" onclick="irParaHome()">' . get_string('return_to_course', 'block_studentcare') . '</button>
    </div>
</div>';

    echo $OUTPUT->footer();
    return;
}

$tclerecords = $DB->get_records('studentcare_tcle_resposta', ['usuario_id' => $userid, 'curso_id' => $coletar->curso_id]);

$tcleaceito = false;
foreach ($tclerecords as $record) {
    if ($record->tcleaceito == 1) {
        $tcleaceito = true;
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

            $respostasexistentes = $DB->get_records('studentcare_resposta', ['coleta_id' => $coletaid, 'usuario_id' => $usuarioid]);

            if ($respostasexistentes) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Você já respondeu a essa coleta.']);
                exit;
            }

            $respostas = $data['respostas'];
            foreach ($respostas as $perguntaid => $resposta) {
                $perguntaid = clean_param($perguntaid, PARAM_INT);
                $resposta = clean_param($resposta, PARAM_TEXT);

                if ($resposta !== null) {
                    $pergunta = $DB->get_record('studentcare_pergunta', ['id' => $perguntaid]);
                    if ($pergunta) {
                        $novaresposta = new stdClass();
                        $novaresposta->pergunta_id = $pergunta->id;
                        $novaresposta->usuario_id = $usuarioid;
                        $novaresposta->coleta_id = $coletaid;
                        $novaresposta->resposta = $resposta;
                        $novaresposta->data_resposta = date('Y-m-d H:i:s');

                        $DB->insert_record('studentcare_resposta', $novaresposta);
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

    $tcleaceitoform = optional_param('tcle_aceito', 0, PARAM_INT);
    if ($tcleaceitoform == 1) {
        if (empty($tclerecords)) {
            $DB->insert_record('studentcare_tcle_resposta', (object) [
                    'usuario_id' => $userid,
                    'coleta_id' => $coletaid,
                    'tcle_aceito' => $tcleaceitoform,
                    'curso_id' => $coletar->curso_id,
                    'data_resposta' => date('Y-m-d H:i:s')
            ]);
        }
        redirect($PAGE->url);
    } else {
        redirect(new moodle_url("/course/view.php", ['id' => intval($coletar->curso_id)]));
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

if ($agora < strtotime($coletar->data_inicio)) {
    echo "<div class='mensagem-sucesso'>" .
            get_string(
                    'collection_not_started',
                    'block_studentcare',
                    userdate(strtotime($coletar->data_inicio), get_string('date_format', 'block_studentcare'))
            ) .
            "</div>";
    echo $OUTPUT->footer();
    return;
}

if ($agora > strtotime($coletar->data_fim)) {
    echo "<div class='mensagem-aviso'>" .
            get_string(
                    'collection_expired',
                    'block_studentcare',
                    userdate(strtotime($coletar->data_fim), get_string('date_format', 'block_studentcare'))
            ) .
            "</div>";
    echo $OUTPUT->footer();
    return;
}

$perguntas = $DB->get_records_sql("
    SELECT p.id, p.pergunta_texto, e.nome AS emocao_nome, e.txttooltip AS texto_tooltip, p.classeaeq_id AS classe_id
    FROM {studentcare_pergunta} p
    JOIN {studentcare_emocao} e ON e.id = p.emocao_id
    JOIN {studentcare_associacao_classe_emocao_coleta} a ON a.emocao_id = e.id
    WHERE a.cadastrocoleta_id = :coletaid
", ['coletaid' => $coletaid]);

$cursoome = $cursor->fullname;

if (!$perguntas) {
    $mensagem = get_string('no_questions_found', 'block_studentcare', format_string($cursoome));
    echo html_writer::tag('div', $mensagem, ['class' => 'alert alert-info']);
    echo $OUTPUT->footer();
    exit;
}

$perguntastraduzidas = [];

foreach ($perguntas as $pergunta) {
    if (!empty($pergunta->pergunta_texto)) {
        try {
            // Tenta traduzir a pergunta usando get_string
            $pergunta->pergunta_texto = get_string($pergunta->pergunta_texto, 'block_studentcare');
        } catch (Exception $e) {
            // Caso ocorra um erro no get_string, registra no log e usa texto padrão
            error_log('Erro no get_string: ' . $e->getMessage() . ' - Chave: ' . $pergunta->pergunta_texto);
            $pergunta->pergunta_texto = 'Texto da pergunta não disponível';
        }
    } else {
        // Caso o texto da pergunta esteja vazio, registra no log e usa texto padrão
        error_log('Pergunta texto vazio para ID: ' . $pergunta->id);
        $pergunta->pergunta_texto = 'Texto da pergunta não definido';
    }

    // Adiciona a pergunta processada ao array de perguntas traduzidas
    $perguntastraduzidas[] = $pergunta;
}

$perguntasjson = json_encode(array_values($perguntastraduzidas));

echo '<div id="translation-data" 
    data-in_course="' . get_string('in_course', 'block_studentcare') . '"
    data-from_course="' . get_string('from_course', 'block_studentcare') . '"
    data-from_class="' . get_string('from_class', 'block_studentcare') . '"
    data-from_study="' . get_string('from_study', 'block_studentcare') . '"
    data-from_assessment="' . get_string('from_assessment', 'block_studentcare') . '"
    data-questions_referring="' . get_string('questions_referring', 'block_studentcare') . '"
    data-plural_emotions="' . get_string('plural_emotions', 'block_studentcare') . '"
    data-singular_emotion="' . get_string('singular_emotion', 'block_studentcare') . '"
    data-that_you_can_feel="' . get_string('that_you_can_feel', 'block_studentcare') . '"
    data-before="' . get_string('before', 'block_studentcare') . '"
    data-during="' . get_string('during', 'block_studentcare') . '"
    data-after="' . get_string('after', 'block_studentcare') . '"
    data-please_read_each_item="' . get_string('please_read_each_item', 'block_studentcare') . '"
    data-anger_txttooltip="' . get_string('anger-txttooltip', 'block_studentcare') . '"
    data-anxiety_txttooltip="' . get_string('anxiety-txttooltip', 'block_studentcare') . '"
    data-shame_txttooltip="' . get_string('shame-txttooltip', 'block_studentcare') . '"
    data-hopelessness_txttooltip="' . get_string('hopelessness-txttooltip', 'block_studentcare') . '"
    data-boredom_txttooltip="' . get_string('boredom-txttooltip', 'block_studentcare') . '"
    data-hope_txttooltip="' . get_string('hope-txttooltip', 'block_studentcare') . '"
    data-pride_txttooltip="' . get_string('pride-txttooltip', 'block_studentcare') . '"
    data-relief_txttooltip="' . get_string('relief-txttooltip', 'block_studentcare') . '"
    data-enjoyment_txttooltip="' . get_string('enjoyment-txttooltip', 'block_studentcare') . '"
    data-anger="' . get_string('anger', 'block_studentcare') . '"
    data-joy="' . get_string('joy', 'block_studentcare') . '"
    data-anxiety="' . get_string('anxiety', 'block_studentcare') . '"
    data-shame="' . get_string('shame', 'block_studentcare') . '"
    data-hopelessness="' . get_string('hopelessness', 'block_studentcare') . '"
    data-boredom="' . get_string('boredom', 'block_studentcare') . '"
    data-hope="' . get_string('hope', 'block_studentcare') . '"
    data-pride="' . get_string('pride', 'block_studentcare') . '"
    data-relief="' . get_string('relief', 'block_studentcare') . '"
    data-enjoyment="' . get_string('enjoyment', 'block_studentcare') . '"
>
</div>';

?>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<div id="tcle-container" style="display: <?php echo $tcleaceito ? 'none' : 'block'; ?>;">
    <form id="tcle-form" method="POST" class="tcle-form">
        <input type="hidden" id="tcle_aceito" name="tcle_aceito" value="0">
        <p class="tcle-title"><strong><?php echo get_string('tcle_title', 'block_studentcare'); ?></strong></p>
        <p class="tcle-description">
            <?php echo get_string('tcle_description', 'block_studentcare', format_string($cursor->fullname)); ?>
        </p>

        <div id="respostas-tcle" class="respostas-tcle">
            <button class="buttonTcle" id="aceito-btn" type="button" onclick="enviarResposta(1)">
                <?php echo get_string('tcle_accept', 'block_studentcare'); ?>
            </button>
            <button class="buttonTcle" id="nao-aceito-btn" type="button" onclick="enviarResposta(0)">
                <?php echo get_string('tcle_decline', 'block_studentcare'); ?>
            </button>
        </div>
    </form>
</div>


<?php if ($tcleaceito): ?>
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
                <span><?php echo get_string('strongly_disagree', 'block_studentcare'); ?></span>
            </button>
            <button class="emoji-button" data-value="2">
                <span class="emoji" id="emoji-2"></span>
                <span><?php echo get_string('disagree', 'block_studentcare'); ?></span>
            </button>
            <button class="emoji-button" data-value="3">
                <span class="emoji" id="emoji-3"></span>
                <span><?php echo get_string('neutral', 'block_studentcare'); ?></span>
            </button>
            <button class="emoji-button" data-value="4">
                <span class="emoji" id="emoji-4"></span>
                <span><?php echo get_string('agree', 'block_studentcare'); ?></span>
            </button>
            <button class="emoji-button" data-value="5">
                <span class="emoji" id="emoji-5"></span>
                <span><?php echo get_string('strongly_agree', 'block_studentcare'); ?></span>
            </button>
        </div>


        <div id="controls">
            <button id="voltar-btn" onclick="voltarPergunta()">
                <?php echo get_string('back', 'block_studentcare'); ?>
            </button>
            <a href="https://poa.ifrs.edu.br/index.php/editais-2/apoio-academico" target="_blank" id="ajuda-emocional-link">
                <?php echo get_string('need_emotional_help', 'block_studentcare'); ?>
            </a>
            <button id="avancar-btn" onclick="avancarPergunta()">
                <?php echo get_string('next', 'block_studentcare'); ?>
            </button>
        </div>

    </div>
<?php endif; ?>

<div id="feedback-container"
     style="display: none; text-align: center; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px;
     background-color: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); max-width: 600px;">
    <h3 class="feedback-title" style="font-size: 18px; font-weight: bold; margin-bottom: 15px; color: #333;">
        <?php echo get_string('feedback_title', 'block_studentcare'); ?>
    </h3>
    <textarea id="feedback-text" rows="4" cols="50"
              placeholder="<?php echo get_string('feedback_placeholder', 'block_studentcare'); ?>"
              style="width: 100%; max-width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 15px; font-size: 16px;"></textarea>
    <div class="feedback-btn-container" style="display: flex; justify-content: center;">
        <button class="buttonTcle" onclick="enviarFeedback()" style="padding: 10px 20px;">
            <?php echo get_string('feedback_submit', 'block_studentcare'); ?>
        </button>
    </div>
</div>


<div id="modal-erro" class="modal">
    <div class="modal-content">
        <span class="close" onclick="fecharModal('modal-erro')">&times;</span>
        <h2><?php echo get_string('error_title', 'block_studentcare'); ?></h2>
        <p><?php echo get_string('error_message', 'block_studentcare'); ?></p>
        <button class="modal-btn" onclick="fecharModal('modal-erro')">
            <?php echo get_string('understood', 'block_studentcare'); ?>
        </button>
    </div>
</div>

<div id="modal-sucesso" class="modal">
    <div class="modal-content">
        <span class="close" onclick="fecharModal('modal-sucesso')">&times;</span>
        <h2><?php echo get_string('success_title', 'block_studentcare'); ?></h2>
        <p><?php echo get_string('success_message', 'block_studentcare'); ?></p>
        <button class="modal-btn" onclick="irParaHome()">
            <?php echo get_string('return_to_course', 'block_studentcare'); ?>
        </button>
    </div>
</div>

<script>
    // Mapa de emojis usando as chaves em português
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

    // Mapeamento para converter termos em inglês para a chave em português
    const emotionKeyMapping = {
        'enjoyment': 'Alegria',
        'hope': 'Esperança',
        'pride': 'Orgulho',
        'anger': 'Raiva',
        'anxiety': 'Ansiedade',
        'shame': 'Vergonha',
        'hopelessness': 'Desespero',
        'boredom': 'Tédio'
    };

    function updateEmojisForEmotion(emocao) {
        // Converte a emoção para minúsculas para comparação
        const emoLower = emocao.toLowerCase();
        // Se existir um mapeamento para a emoção, use-o; caso contrário, use a emoção original
        const key = emotionKeyMapping[emoLower] || emocao;
        const emojis = emotionEmojiMap[key] || ['😕', '😟', '😐', '🙂', '😀'];

        document.getElementById('emoji-1').textContent = emojis[0];
        document.getElementById('emoji-2').textContent = emojis[1];
        document.getElementById('emoji-3').textContent = emojis[2];
        document.getElementById('emoji-4').textContent = emojis[3];
        document.getElementById('emoji-5').textContent = emojis[4];
    }

    let perguntas = <?php echo $perguntasjson; ?>;
    let perguntaAtual = 0;
    let totalPerguntas = perguntas.length;
    let respostasSelecionadas = {};

    function irParaHome() {
        window.location.href = '<?php echo new moodle_url("/course/view.php", ['id' => intval($coletar->curso_id)]); ?>';
    }


    let ultimaClasseId = null;
    let introducoesExibidas = {};

    function getTranslation(attr) {
        var element = document.getElementById('translation-data');
        return element ? element.getAttribute('data-' + attr) : '';
    }

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
                    ? `${getTranslation('in_course')} <strong>${nomeRecurso}</strong> ${getTranslation('from_course')}
                    <strong>${cursoNome}</strong>`
                    : `${getTranslation('from_class')} <strong>${cursoNome}</strong>`;
                break;
            case "2": // Emoções Relacionadas ao Aprendizado
                textoAtividade = nomeRecurso
                    ? `${getTranslation('from_study')} <strong>${nomeRecurso}</strong> ${getTranslation('from_course')}
                    <strong>${cursoNome}</strong>`
                    : `${getTranslation('from_study')} ${getTranslation('from_course')} <strong>${cursoNome}</strong>`;
                break;
            case "3": // Emoções Relacionadas às Atividades Avaliativas
                textoAtividade = nomeRecurso
                    ? `${getTranslation('from_assessment')} <strong>${nomeRecurso}</strong> ${getTranslation('from_course')}
                    <strong>${cursoNome}</strong>`
                    : `${getTranslation('from_assessment')} ${getTranslation('from_course')} <strong>${cursoNome}</strong>`;
                break;
            default:
                textoAtividade = `${getTranslation('from_course')} <strong>${cursoNome}</strong>`;
        }

        return `
        <p>
            ${getTranslation('questions_referring')}
            ${plural ? getTranslation('plural_emotions') : getTranslation('singular_emotion')}
            ${emocoesComTooltip}
            ${getTranslation('that_you_can_feel')}
            <strong>${getTranslation('before')}</strong>, <strong>${getTranslation('during')}</strong> or
            <strong>${getTranslation('after')}</strong> ${textoAtividade}.
            ${getTranslation('please_read_each_item')}
        </p>`;
    }

    function mostrarTextoInicial(pergunta, emocoesDaClasse, tooltipsDaClasse) {
        let cursoNome = <?php echo json_encode($cursoome); ?>;

        // Obter o nome do recurso atrelado
        let nomeRecurso = <?php
                $resourcename = '--';
                $coleta = $DB->get_record('studentcare_cadastrocoleta', ['id' => $coletaid], '*');

                if ($coleta && $coleta->resource_id_atrelado) {
                    $module = $DB->get_record('course_modules', ['id' => $coleta->resource_id_atrelado], 'module');
                    if ($module) {
                        $modinfo = $DB->get_record('modules', ['id' => $module->module], 'name');
                        if ($modinfo) {
                            $resourcename_record = $DB->get_record('course_modules',
                                    ['id' => $coleta->resource_id_atrelado], 'id, instance');
                            if ($resourcename_record) {
                                $resourcename = $DB->get_field($modinfo->name, 'name', ['id' => $resourcename_record->instance]);
                            }
                        }
                    }
                }
                echo json_encode($resourcename);
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
        let cursoNome = <?php echo json_encode($cursoome); ?>;

        const emocoesDaClasse = [...new Set(
            perguntas
                .filter(p => p.classe_id === pergunta.classe_id)
                .map(p => {
                    // Converte para minúsculas e substitui espaços ou hífens por underlines para corresponder ao formato dos
                    // atributos.
                    let key = p.emocao_nome.replace(/[\s-]+/g, '_').toLowerCase();
                    return getTranslation(key);
                })
        )];

        const tooltipsDaClasse = [...new Set(
            perguntas
                .filter(p => p.classe_id === pergunta.classe_id)
                .map(p => getTranslation(p.texto_tooltip.replace(/-/g, '_')))
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

        const emotionKeyMapping = {
            'alegria': 'Alegria',
            'enjoyment': 'Alegria',
            'esperança': 'Esperança',
            'hope': 'Esperança',
            'orgulho': 'Orgulho',
            'pride': 'Orgulho',
            'raiva': 'Raiva',
            'anger': 'Raiva',
            'ansiedade': 'Ansiedade',
            'anxiety': 'Ansiedade',
            'vergonha': 'Vergonha',
            'shame': 'Vergonha',
            'desespero': 'Desespero',
            'hopelessness': 'Desespero',
            'tédio': 'Tédio',
            'boredom': 'Tédio'
        };

        const normalizedEmotion = emotionKeyMapping[pergunta.emocao_nome.toLowerCase()] || pergunta.emocao_nome;
        updateEmojisForEmotion(normalizedEmotion);

        document.getElementById('titulo-coleta').innerHTML = `
    ${cursoNome} - ${getTranslation(pergunta.emocao_nome.toLowerCase().replace(/-/g, '_'))}
    <span class="tooltip-icon">
        &#9432;
        <span class="tooltip-text">${getTranslation(pergunta.texto_tooltip.replace(/-/g, '_'))}</span>
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

        let progresso;

        if (index === 1) {
            progresso = 0;
        } else {
            progresso = Math.round(((index + 1) / totalPerguntas) * 100);
            if (index === totalPerguntas - 1 && !respostasSelecionadas[pergunta.id]) {
                progresso = 99;
            }
        }


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
                    perguntas
                        .filter(p => p.classe_id === classeAtual)
                        .map(p => M.util.get_string(p.emocao_nome, 'block_studentcare'))
                )];

                let tooltipsDaClasse = [...new Set(
                    perguntas
                        .filter(p => p.classe_id === classeAtual)
                        .map(p => M.util.get_string(p.texto_tooltip, 'block_studentcare'))
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

        if (tituloAtual.includes("As perguntas a seguir referem-se") || tituloAtual.includes("The following questions refer to")) {
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
        if (<?php echo json_encode($tcleaceito); ?>) {
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
