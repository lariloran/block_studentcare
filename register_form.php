<?php
require_once("$CFG->libdir/formslib.php");
require_once("$CFG->libdir/classes/notification.php");

use core\notification;

class register_form extends moodleform {

    public function __construct() {
        global $COURSE, $PAGE;

        $context = context_course::instance($COURSE->id);

        $PAGE->set_context($context);

        parent::__construct();
    }

    public function definition() {
        global $PAGE, $COURSE, $DB, $USER, $PAGE, $OUTPUT;
        $mform = $this->_form;

        $context = context_course::instance($COURSE->id);

        $PAGE->set_context($context);

        // $mform->addElement('text', 'name', get_string('name', 'block_studentcare'), array('size' => '50', 'readonly' => 'readonly'));
        // $mform->setType('name', PARAM_NOTAGS);
        // $mform->setDefault('name', $nomecoleta);

        $cursos = $this->get_user_courses($USER->id);
        $options = array();

        if (!empty($cursos)) {
            usort($cursos, function($a, $b) {
                return strcmp($a->fullname, $b->fullname);
            });

            foreach ($cursos as $curso) {
                $options[$curso->id] = $curso->fullname;
            }
        }

        $mform->addElement('select', 'courseid', get_string('select_course', 'block_studentcare'), $options);
        $mform->setType('courseid', PARAM_INT);

        $mform->addElement('select', 'sectionid', get_string('select_section', 'block_studentcare'), array());
        $mform->setType('sectionid', PARAM_INT);
        $mform->addHelpButton('sectionid', 'select_section', 'block_studentcare');

        $mform->addElement('select', 'resourceid', get_string('select_resource', 'block_studentcare'), array());
        $mform->setType('resourceid', PARAM_INT);
        $mform->addHelpButton('resourceid', 'select_resource', 'block_studentcare');
        $currenttime = time();

        // Ajustar para a próxima hora redonda
        $starttime = strtotime(date('Y-m-d H:00:00', $currenttime)) + 3600; // Próxima hora cheia
        $futuretime = $starttime + 3600; // Adiciona 1 hora ao start_time

        $mform->addElement('date_time_selector', 'starttime', get_string('starttime', 'block_studentcare'),
                array('optional' => false));
        $mform->setDefault('starttime', $starttime);

        $mform->addElement('date_time_selector', 'endtime', get_string('endtime', 'block_studentcare'), array('optional' => false));
        $mform->setDefault('endtime', $futuretime);

        $mform->addElement('textarea', 'description', get_string('description', 'block_studentcare'),
                'wrap="virtual" rows="5" cols="50" maxlength="200"');
        $mform->setType('description', PARAM_TEXT);

        $mform->addElement('hidden', 'emocao_selecionadas', '', array('id' => 'emocao_selecionadas'));
        $mform->setType('emocao_selecionadas', PARAM_RAW);

        $mform->addElement('hidden', 'setor', '', array('id' => 'setor'));
        $mform->setType('setor', PARAM_INT);

        $mform->addElement('hidden', 'recurso', '', array('id' => 'recurso'));
        $mform->setType('recurso', PARAM_INT);

        $classes2 = $DB->get_records('studentcare_classeaeq');
        $options2 = array();
        foreach ($classes2 as $class) {
            $classeaeq2 = new ClasseAeq(get_string($class->nome_classe, 'block_studentcare'));
            $options2[$class->id] = $classeaeq2->getNomeClasse();
        }

        $mform->addElement('select', 'classe_aeq', get_string('aeqclasses', 'block_studentcare'), $options2);
        $mform->setType('classe_aeq', PARAM_TEXT);
        $mform->addHelpButton('classe_aeq', 'aeqclasses', 'block_studentcare');

        $mform->addElement('select', 'emocoes', get_string('emotions', 'block_studentcare'), array(),
                array('multiple' => 'multiple', 'size' => 8));
        $mform->setType('emocoes', PARAM_INT);
        $mform->addHelpButton('emocoes', 'emotions', 'block_studentcare');

        $mform->addElement('html', '
        <div class="fitem">
            <div class="fitemtitle">' . get_string('selection_summary', 'block_studentcare') . '</div>
            <div id="emocoes-selecionadas" class="selected-emotions-container"></div>
        </div>
    ');

        $mform->addElement('advcheckbox', 'alertprogress', get_string('alertprogress', 'block_studentcare'), null,
                array('group' => 1), array(0, 1));
        $mform->setDefault('alertprogress', 1);
        $mform->addHelpButton('alertprogress', 'alertprogress', 'block_studentcare');

        $mform->addElement('advcheckbox', 'notify_students', get_string('notify_students', 'block_studentcare'), null,
                array('group' => 1), array(0, 1));
        $mform->setDefault('notify_students', 1);
        $mform->addHelpButton('notify_students', 'notify_students', 'block_studentcare');

        echo '<div id="confirmation-data"
        data-title="' . get_string('confirm_title', 'block_studentcare') . '"
        data-message="' . get_string('confirm_message', 'block_studentcare') . '"
         data-yes="' . get_string('confirm_button_yes', 'block_studentcare') . '"
        data-no="' . get_string('confirm_button_no', 'block_studentcare') . '"
       >
         </div>';

        // Botões de enviar e cancelar agrupados
        $buttonarray = [];
        $buttonarray[] = $mform->createElement('submit', 'save', get_string('submit', 'block_studentcare'));
        $buttonarray[] = $mform->createElement('cancel', 'cancel', get_string('cancel'));
        $mform->addGroup($buttonarray, 'buttonar', '', [' '], false);

        $mform->addElement('hidden', 'userid', $USER->id);
        $mform->setType('userid', PARAM_INT);

        $PAGE->requires->js(new moodle_url('/blocks/studentcare/js/shared.js'));
        $PAGE->requires->js(new moodle_url('/blocks/studentcare/js/register_form.js'));
    }

    public function get_user_courses($userid) {
        global $DB;
        $courses = enrol_get_users_courses($userid, true);
        $teachercourses = [];

        foreach ($courses as $course) {
            $context = context_course::instance($course->id);

            if (has_capability('moodle/course:update', $context, $userid)) {
                $teachercourses[] = $course;
            }
        }
        return $teachercourses;
    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        $currenttime = time();

        if ($data['starttime'] < $currenttime) {
            $errors['starttime'] = get_string('starttime_past_error', 'block_studentcare');
        }

        if ($data['endtime'] <= $data['starttime']) {
            $errors['endtime'] = get_string('endtime_before_start_error', 'block_studentcare');
        }

        return $errors;
    }

    public function process_form($data) {
        global $DB, $SESSION, $COURSE, $PAGE;

        global $DB;

        global $DB;

        // Obtém o número total de coletas existentes (contagem geral)
        $numerocoleta = $DB->count_records('studentcare_cadastrocoleta', ['curso_id' => $data->courseid]) + 1;

        // Formata a data de criação
        $datacriacao = date('d/m/Y');

        // Obtém o nome completo do curso
        $cursonome = $DB->get_field('course', 'fullname', ['id' => $data->courseid]);
        $cursonomeFormatado = format_string($cursonome);

        // Cria o nome da coleta com o nome completo do curso
        $nomecoleta = 'Coleta #' . $numerocoleta . ' - ' . $cursonomeFormatado . ' - ' . $datacriacao;

        // Sanitização de campos numéricos e texto
        $userid = clean_param($data->userid, PARAM_INT);
        $courseid = clean_param($data->courseid, PARAM_INT);
        $nome = $nomecoleta;
        $datainicioformatada = clean_param(date('Y-m-d H:i:s', $data->starttime), PARAM_TEXT);
        $datafimFormatada = clean_param(date('Y-m-d H:i:s', $data->endtime), PARAM_TEXT);
        $descricao = clean_param($data->description, PARAM_TEXT);
        $receberalerta = clean_param($data->alertprogress, PARAM_INT);
        $notificaralunos = clean_param($data->notify_students, PARAM_INT);
        $sectionid = clean_param($data->setor, PARAM_INT);
        $resourceidatrelado = clean_param($data->recurso, PARAM_INT);

        $registro = new stdClass();
        $registro->nome = clean_param($nome, PARAM_TEXT);
        $registro->data_inicio = clean_param($datainicioformatada, PARAM_TEXT);
        $registro->data_fim = clean_param($datafimFormatada, PARAM_TEXT);
        $registro->descricao = clean_param($descricao, PARAM_TEXT);
        $registro->receber_alerta = clean_param($receberalerta, PARAM_INT);
        $registro->notificar_alunos = clean_param($notificaralunos, PARAM_INT);
        $registro->curso_id = clean_param($courseid, PARAM_INT);
        $registro->usuario_id = clean_param($userid, PARAM_INT);
        $registro->section_id = clean_param($sectionid, PARAM_INT);
        $registro->resource_id_atrelado = clean_param($resourceidatrelado, PARAM_INT);
        $registro->resource_id = 0;

        $inserted = $DB->insert_record('studentcare_cadastrocoleta', $registro);

        if ($inserted) {
            $cadastrocoletaid = $inserted;

            $emocaoselecionadas = json_decode($data->emocao_selecionadas, true);
            if (is_array($emocaoselecionadas)) {
                foreach ($emocaoselecionadas as $classeaeqid => $emocoes) {
                    if (is_array($emocoes)) {
                        foreach ($emocoes as $emocao) {
                            $emocaoid = clean_param($emocao['id'], PARAM_INT); // Pega o ID da emoção
                            $associacao = new stdClass();
                            $associacao->cadastrocoleta_id = $cadastrocoletaid;
                            $associacao->classeaeq_id = $classeaeqid;
                            $associacao->emocao_id = $emocaoid;

                            // Salva a associação no banco
                            $DB->insert_record('studentcare_associacao_classe_emocao_coleta', $associacao);
                        }
                    }
                }
            } else {
                $SESSION->mensagem_erro = get_string('mensagem_erro', 'block_studentcare');
                redirect(new moodle_url("/blocks/studentcare/index.php"));
            }

            $SESSION->mensagem_sucesso = get_string('mensagem_sucesso', 'block_studentcare');
        } else {
            $SESSION->mensagem_erro = get_string('mensagem_erro', 'block_studentcare');
        }

        redirect(new moodle_url("/blocks/studentcare/index.php"));

    }
}

class CadastroColeta {
    private $nome;
    private $datainicio;
    private $horainicio;
    private $datafim;
    private $horafim;
    private $descricao;
    private $receberalerta;
    private $notificaralunos;
    private $cursoid;
    private $professorid;
    private $classesAEQ;

    public function __construct($nome, $datainicio, $horainicio, $datafim, $horafim, $descricao, $receberalerta, $notificaralunos,
            $cursoid, $professorid) {
        $this->nome = $nome;
        $this->dataInicio = $datainicio;
        $this->horaInicio = $horainicio;
        $this->dataFim = $datafim;
        $this->horaFim = $horafim;
        $this->descricao = $descricao;
        $this->receberAlerta = $receberalerta;
        $this->notificarAlunos = $notificaralunos;
        $this->cursoId = $cursoid;
        $this->professorId = $professorid;
        $this->classesAEQ = [];
    }

    public function adicionarClasse($classe, $emoções) {
        $this->classesAEQ[$classe] = $emoções;
    }
}

class ClasseAeq {
    private $nomeClasse;

    public function __construct($nomeClasse) {
        $this->nomeClasse = $nomeClasse;
    }

    public function getNomeClasse() {
        return $this->nomeClasse;
    }

    public function setNomeClasse($nomeClasse) {
        $this->nomeClasse = $nomeClasse;
    }
}

