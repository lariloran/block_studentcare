<?php
require_once("$CFG->libdir/formslib.php");
require_once("$CFG->libdir/classes/notification.php");

use core\notification;

class CadastrarForm extends moodleform
{
    
    public function get_user_courses($userid) {
        global $DB;
    
        // Obter todos os cursos em que o usuário está matriculado e visíveis
        return enrol_get_users_courses($userid, true); // true para incluir cursos visíveis
    }
    

    public function __construct()
    {
        global $COURSE,$PAGE;

        $context = context_course::instance($COURSE->id);

        $PAGE->set_context($context);

        
        parent::__construct();
    }

    // Define o formulário
    public function definition()
    {
        global $PAGE, $COURSE, $DB,$USER,$PAGE;
        $mform = $this->_form;

        $context = context_course::instance($COURSE->id);

        $PAGE->set_context($context);

        // Gerar o nome da coleta no formato COLETA-DATADEHOJEHORAMINUTO
        $dataAtual = date('Y-m-d H:i'); // Obtém a data e hora atual
        $nomeColeta = "COLETA-" . date('YmdHi', strtotime($dataAtual)); // Formata conforme necessário


// Obtém todos os cursos em que o professor está matriculado
$cursos = $this->get_user_courses($USER->id); 
$options = array();

if (!empty($cursos)) {
    // Ordena os cursos em ordem alfabética
    usort($cursos, function($a, $b) {
        return strcmp($a->fullname, $b->fullname);
    });

    // Preenche o array de opções com os cursos ordenados
    foreach ($cursos as $curso) {
        $options[$curso->id] = $curso->fullname; // Adiciona o curso ao array de opções
    }
} else {
   // $options[0] = get_string('nocourses', 'block_ifcare'); // Mensagem de erro caso não haja cursos
}

$mform->addElement('select', 'courseid', get_string('select_course', 'block_ifcare'), $options); 
$mform->setType('courseid', PARAM_INT);


        // Adiciona um campo de seleção para seções (inicialmente vazio)
        $mform->addElement('select', 'sectionid', get_string('select_section', 'block_ifcare'), array());
        $mform->setType('sectionid', PARAM_INT);

        // Adiciona um campo de seleção para recursos/atividades (inicialmente vazio)
        $mform->addElement('select', 'resourceid', get_string('select_resource', 'block_ifcare'), array());
        $mform->setType('resourceid', PARAM_INT);

        // Inclui o script JavaScript para fazer a chamada AJAX
        $PAGE->requires->js(new moodle_url('/blocks/ifcare/js/dynamicform.js'));






        // Campo Data e Hora de Início da coleta
        $mform->addElement('date_time_selector', 'starttime', get_string('starttime', 'block_ifcare'), array('optional' => false));

        // Sempre inicializa o campo com 30 min a mais
        $current_time = time(); // Timestamp atual
        $future_time = $current_time + (30 * 60);
        $mform->addElement('date_time_selector', 'endtime', get_string('endtime', 'block_ifcare'), array('optional' => false));
        $mform->setDefault('endtime', $future_time);


        // Campo Descrição
        $mform->addElement('textarea', 'description', get_string('description', 'block_ifcare'), 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('description', PARAM_TEXT);

        // Adiciona o campo oculto para as emoções selecionadas com o atributo 'emocao_selecionadas'
        $mform->addElement('hidden', 'emocao_selecionadas', '', array('id' => 'emocao_selecionadas'));
        $mform->setType('emocao_selecionadas', PARAM_RAW);


        // Definir as opções para o select com os dados da tabela.
        $classes = $DB->get_records('ifcare_classeaeq');
        $options = array();
        foreach ($classes as $class) {
            $classeAeq = new ClasseAeq($class->nome_classe);
            $options[$class->id] = $classeAeq->getNomeClasse();
        }

        // Adiciona o campo select ao formulário.
        $mform->addElement('select', 'FIELDNAME', get_string('aeqclasses', 'block_ifcare'), $options);
        $mform->setType('FIELDNAME', PARAM_TEXT);

        // Adicione o contêiner para a tabela dinâmica
        $mform->addElement('html', '<div class="fitem">
                                    <div class="fitemtitle">Selecione as emoções</div>
                                    <div class="felement">
                                        <table id="container-tabela" class="generaltable"></table>
                                    </div>
                                </div>');

        // Inclui o js da tabela dinâmica
        $PAGE->requires->js('/blocks/ifcare/js/tabela_dinamica.js');


        //div resumo das seleções da tabela
        $mform->addElement('html', '<div class="fitem">
            <div class="fitemtitle">Resumo das Seleções</div>
            <div class="felement" id="resumo-selecoes">
                <ul id="resumo-lista">
                    <!-- Itens do resumo serão inseridos aqui pelo JavaScript -->
                </ul>
            </div>
        </div>');

        // Flag "Receber alerta do andamento da coleta"
        $mform->addElement('advcheckbox', 'alertprogress', get_string('alertprogress', 'block_ifcare'), null, array('group' => 1), array(0, 1));
        $mform->setDefault('alertprogress', 1);

        // Flag "Notificar os alunos"
        $mform->addElement('advcheckbox', 'notify_students', get_string('notify_students', 'block_ifcare'), null, array('group' => 1), array(0, 1));
        $mform->setDefault('notify_students', 1);

        // Botões de Salvar e Cancelar
// Botões de Salvar e Cancelar
        $mform->addElement('submit', 'save', get_string('submit', 'block_ifcare'));
        $mform->setType('save', PARAM_ACTION); // Certifique-se de definir o tipo correto

        $mform->addElement('hidden', 'userid', $USER->id);
$mform->setType('userid', PARAM_INT);




        // Adicionando o modal de confirmação
        $mform->addElement('html', '
<div class="modal fade" id="confirmacaoModal" tabindex="-1" role="dialog" aria-labelledby="confirmacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmacaoModalLabel">Confirmação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Está pronto para salvar esta coleta de emoções?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmarSalvar" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>
');

        $PAGE->requires->js_amd_inline("
    require(['jquery'], function($) {
        var isFormSubmitted = false;
        var selectedEmotions = []; // Array para armazenar emoções selecionadas

        // Função para habilitar ou desabilitar o botão de salvar
        function toggleSaveButton() {
            $('#id_save').prop('disabled', selectedEmotions.length === 0); // Habilita se houver emoções selecionadas
        }

        // Atualiza o campo de emoções selecionadas
        function updateSelectedEmotions() {
           // $('#emocao_selecionadas').val(JSON.stringify(selectedEmotions)); // Atualiza o campo oculto
            toggleSaveButton(); // Verifica se deve habilitar o botão de salvar
        }

        // Adiciona ou remove uma emoção selecionada
        function handleEmotionSelection(emotionId) {
            const index = selectedEmotions.indexOf(emotionId);
            if (index > -1) {
                // Se a emoção já estiver selecionada, remova-a
                selectedEmotions.splice(index, 1);
            } else {
                // Caso contrário, adicione-a
                selectedEmotions.push(emotionId);
            }
            updateSelectedEmotions(); // Atualiza o campo e verifica o botão
        }

        // Ao clicar no botão de salvar, exibe o modal de confirmação
        $('form.mform').on('submit', function(e) {
            e.preventDefault(); // Evita o envio imediato do formulário
            $('#confirmacaoModal').modal('show'); // Mostra o modal
        });

$('#confirmarSalvar').on('click', function() {
    // Atualiza o campo oculto antes de enviar
    //$('#emocao_selecionadas').val(JSON.stringify(selectedEmotions)); 
    $('#confirmacaoModal').modal('hide'); // Fecha o modal
    isFormSubmitted = true; // Marca o formulário como enviado
    $('form.mform').off('submit').submit(); // Envia o formulário
});



        // Monitorar mudanças nas emoções selecionadas
        $('#container-tabela').on('change', 'input[type=checkbox]', function() {
            handleEmotionSelection($(this).data('id')); // Chama a função para adicionar ou remover a emoção
        });

        // Inicialmente, desabilita o botão de salvar
        toggleSaveButton();
    });
");


    }
    
    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);

        if ($data['endtime'] <= $data['starttime']) {
            $errors['endtime'] = get_string('endtimeerror', 'block_ifcare');
        }

        return $errors;
    }

    public function process_form($data)
    {
        global $DB, $SESSION, $COURSE, $PAGE;

        $context = context_course::instance($COURSE->id);

        $PAGE->set_context($context);

        $userid = $data->userid;
        $courseid = $data->courseid;

        $nome = $data->name;
        $dataInicioFormatada = date('Y-m-d H:i:s', $data->starttime);
        $dataFimFormatada = date('Y-m-d H:i:s', $data->endtime);
        $descricao = $data->description;
        $receberAlerta = $data->alertprogress;
        $notificarAlunos = $data->notify_students;
        $cursoId = $courseid;
        $professorId = $userid;

        $dataAtualFormatada = date('Y-m-d H:i:s');


        $registro = new stdClass();
        $registro->nome = $nome;
        $registro->data_inicio = $dataInicioFormatada;
        $registro->data_fim = $dataFimFormatada;
        $registro->descricao = $descricao;
        $registro->receber_alerta = $receberAlerta;
        $registro->notificar_alunos = $notificarAlunos;
        $registro->curso_id = $cursoId;
        $registro->professor_id = $professorId;

        $inserted = $DB->insert_record('ifcare_cadastrocoleta', $registro);

        if ($inserted) {
            $cadastroColetaId = $inserted;
            $emocaoSelecionadas = json_decode($data->emocao_selecionadas, true);

            if (!empty($emocaoSelecionadas)) {
                foreach ($emocaoSelecionadas as $classe => $emocaoDados) {
                    foreach ($emocaoDados as $dados) {
                        $classeId = isset($dados['classeId']) ? $dados['classeId'] : 'N/A';
                        $emocaoId = isset($dados['emocaoId']) ? $dados['emocaoId'] : 'N/A';

                        $associacao = new stdClass();
                        $associacao->cadastrocoleta_id = $cadastroColetaId;
                        $associacao->classeaeq_id = $classeId;
                        $associacao->emocao_id = $emocaoId;

                        $DB->insert_record('ifcare_associacao_classe_emocao_coleta', $associacao);
                    }
                }
            } else {
                $SESSION->mensagem_erro = get_string('mensagem_erro', 'block_ifcare');
            }

            $SESSION->mensagem_sucesso = get_string('mensagem_sucesso', 'block_ifcare');
            redirect(new moodle_url("/blocks/ifcare/index.php?courseid=$cursoId"));


        } else {
            $SESSION->mensagem_erro = get_string('mensagem_erro', 'block_ifcare');
            redirect(new moodle_url("/blocks/ifcare/index.php?courseid=$cursoId"));
        }
    }


}

class CadastroColeta
{
    private $nome;
    private $dataInicio;
    private $horaInicio;
    private $dataFim;
    private $horaFim;
    private $descricao;
    private $receberAlerta;
    private $notificarAlunos;
    private $cursoId;
    private $professorId;
    private $classesAEQ;

    public function __construct($nome, $dataInicio, $horaInicio, $dataFim, $horaFim, $descricao, $receberAlerta, $notificarAlunos, $cursoId, $professorId)
    {
        $this->nome = $nome;
        $this->dataInicio = $dataInicio;
        $this->horaInicio = $horaInicio;
        $this->dataFim = $dataFim;
        $this->horaFim = $horaFim;
        $this->descricao = $descricao;
        $this->receberAlerta = $receberAlerta;
        $this->notificarAlunos = $notificarAlunos;
        $this->cursoId = $cursoId;
        $this->professorId = $professorId;
        $this->classesAEQ = [];
    }

    public function adicionarClasse($classe, $emoções)
    {
        $this->classesAEQ[$classe] = $emoções;
    }
}

class ClasseAeq
{
    private $nomeClasse;

    public function __construct($nomeClasse)
    {
        $this->nomeClasse = $nomeClasse;
    }

    public function getNomeClasse()
    {
        return $this->nomeClasse;
    }

    public function setNomeClasse($nomeClasse)
    {
        $this->nomeClasse = $nomeClasse;
    }
}

