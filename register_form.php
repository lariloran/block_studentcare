<?php
require_once("$CFG->libdir/formslib.php");
require_once("$CFG->libdir/classes/notification.php");

use core\notification;

class register_form extends moodleform
{
    
    public function get_user_courses($userid) {
        global $DB;
    
        return enrol_get_users_courses($userid, true); 
    }
    

    public function __construct()
    {
        global $COURSE,$PAGE;

        $context = context_course::instance($COURSE->id);

        $PAGE->set_context($context);

        
        parent::__construct();
    }

    public function definition()
    {
        global $PAGE, $COURSE, $DB,$USER,$PAGE;
        $mform = $this->_form;

        $context = context_course::instance($COURSE->id);

        $PAGE->set_context($context);

        $dataAtual = date('Y-m-d H:i:s'); 
        $microsegundos = explode(' ', microtime())[0] * 1000; 
        $milissegundos = str_pad((int)$microsegundos, 3, '0', STR_PAD_LEFT); 
        
        $nomeColeta = "COLETA-" . date('YmdHis') . $milissegundos; 
        
        $mform->addElement('text', 'name', get_string('name', 'block_ifcare'), array('size' => '50', 'readonly' => 'readonly'));
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', $nomeColeta); 

        $cursos = $this->get_user_courses($USER->id); 
        $options = array();

        if (!empty($cursos)) {
            usort($cursos, function($a, $b) {
                return strcmp($a->fullname, $b->fullname);
            });

            foreach ($cursos as $curso) {
                $options[$curso->id] = $curso->fullname; 
            }
        } else {
       
        }

        $mform->addElement('select', 'courseid', get_string('select_course', 'block_ifcare'), $options); 
        $mform->setType('courseid', PARAM_INT);

        $mform->addElement('select', 'sectionid', get_string('select_section', 'block_ifcare'), array());
        $mform->setType('sectionid', PARAM_INT);

        $mform->addElement('select', 'resourceid', get_string('select_resource', 'block_ifcare'), array());
        $mform->setType('resourceid', PARAM_INT);

        $mform->addElement('date_time_selector', 'starttime', get_string('starttime', 'block_ifcare'), array('optional' => false));

        $current_time = time(); 
        $future_time = $current_time + (30 * 60);
        $mform->addElement('date_time_selector', 'endtime', get_string('endtime', 'block_ifcare'), array('optional' => false));
        $mform->setDefault('endtime', $future_time);

        $mform->addElement('textarea', 'description', get_string('description', 'block_ifcare'), 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('description', PARAM_TEXT);

        $mform->addElement('hidden', 'emocao_selecionadas', '', array('id' => 'emocao_selecionadas'));
        $mform->setType('emocao_selecionadas', PARAM_RAW);

        $mform->addElement('hidden', 'setor', '', array('id' => 'setor'));
        $mform->setType('setor', PARAM_INT);

        $mform->addElement('hidden', 'recurso', '', array('id' => 'recurso'));
        $mform->setType('recurso', PARAM_INT);

        $classes2 = $DB->get_records('ifcare_classeaeq');
        $options2 = array();
        foreach ($classes2 as $class) {
            $classeAeq2 = new ClasseAeq($class->nome_classe);
            $options2[$class->id] = $classeAeq2->getNomeClasse();
        }

        $mform->addElement('select', 'classe_aeq', get_string('aeqclasses', 'block_ifcare'), $options2);
        $mform->setType('classe_aeq', PARAM_TEXT);

        $mform->addElement('select', 'emocoes', get_string('emotions', 'block_ifcare'), array(), array('multiple' => 'multiple', 'size' => 8));
        $mform->setType('emocoes', PARAM_INT);

        $mform->addElement('html', '
            <div class="fitem">
                <div class="fitemtitle">Resumo das Seleções</div>
                    <div id="emocoes-selecionadas" class="selected-emotions-container"></div>
            </div>
        ');

        $mform->addElement('advcheckbox', 'alertprogress', get_string('alertprogress', 'block_ifcare'), null, array('group' => 1), array(0, 1));
        $mform->setDefault('alertprogress', 1);

        $mform->addElement('advcheckbox', 'notify_students', get_string('notify_students', 'block_ifcare'), null, array('group' => 1), array(0, 1));
        $mform->setDefault('notify_students', 1);

        $mform->addElement('submit', 'save', get_string('submit', 'block_ifcare'));
        $mform->setType('save', PARAM_ACTION);

        $mform->addElement('hidden', 'userid', $USER->id);
        $mform->setType('userid', PARAM_INT);
    
        $PAGE->requires->js(new moodle_url('/blocks/ifcare/js/dynamicform.js'));

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
        $sectionId = !empty($data->setor) ? $data->setor : 0;
        $resourceId = !empty($data->recurso) ? $data->recurso : 0;
    
        $registro = new stdClass();
        $registro->nome = $nome;
        $registro->data_inicio = $dataInicioFormatada;
        $registro->data_fim = $dataFimFormatada;
        $registro->descricao = $descricao;
        $registro->receber_alerta = $receberAlerta;
        $registro->notificar_alunos = $notificarAlunos;
        $registro->curso_id = $cursoId;
        $registro->professor_id = $professorId;
        $registro->section_id = $sectionId;
        $registro->resource_id = $resourceId;
    
        $inserted = $DB->insert_record('ifcare_cadastrocoleta', $registro);
    
        if ($inserted) {
            $cadastroColetaId = $inserted;
    
            $emocaoSelecionadas = json_decode($data->emocao_selecionadas, true);
    
            if (is_array($emocaoSelecionadas) && !empty($emocaoSelecionadas)) {
                foreach ($emocaoSelecionadas as $classeAeqId => $emocoes) {
                    if (is_array($emocoes)) {
                        foreach ($emocoes as $emocaoId) {
                            $associacao = new stdClass();
                            $associacao->cadastrocoleta_id = $cadastroColetaId;
                            $associacao->classeaeq_id = $classeAeqId; 
                            $associacao->emocao_id = $emocaoId;
    
                            $DB->insert_record('ifcare_associacao_classe_emocao_coleta', $associacao);
                        }
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

