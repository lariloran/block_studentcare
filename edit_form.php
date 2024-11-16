<?php
require_once("$CFG->libdir/formslib.php");

class edit_form extends moodleform
{
    private $coleta;

    public function __construct($coleta_id)
    {
        global $DB;

        if (!$coleta_id || !is_numeric($coleta_id)) {
            throw new moodle_exception('invalidcoletaid', 'block_ifcare', '', $coleta_id);
        }

        $this->coleta = $DB->get_record('ifcare_cadastrocoleta', ['id' => $coleta_id]);
        if (!$this->coleta) {
            throw new moodle_exception('invalidcoletaid', 'block_ifcare', '', $coleta_id);
        }

        // Garantir que as propriedades necessárias existam com valores padrão
        $this->coleta->classeaeq_id = $this->coleta->classeaeq_id ?? 0;
        $this->coleta->emocoes = $this->coleta->emocoes ?? '';
        parent::__construct();
    }

    public function definition()
    {
        global $PAGE, $DB, $USER;

        $mform = $this->_form;

        $mform->addElement('hidden', 'is_editing');
        $mform->setType('is_editing', PARAM_INT);
        $mform->setDefault('is_editing', 1); // Define o valor padrão como 0
        
        // Nome da coleta (preenchido com o valor existente)
        $mform->addElement('text', 'name', get_string('name', 'block_ifcare'), ['size' => '50', 'readonly' => 'readonly']);
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', $this->coleta->nome);

        // Cursos do usuário
        $courses = enrol_get_users_courses($USER->id, true);
        $course_options = [];
        foreach ($courses as $course) {
            $course_options[$course->id] = $course->fullname;
        }
        $mform->addElement('select', 'courseid', get_string('select_course', 'block_ifcare'), $course_options);
        $mform->setType('courseid', PARAM_INT);
        $mform->setDefault('courseid', $this->coleta->curso_id);

        // Seções do curso
        $sections = $DB->get_records('course_sections', ['course' => $this->coleta->curso_id]);
        $section_options = [];
        foreach ($sections as $section) {
            $section_name = get_section_name($this->coleta->curso_id, $section->section);
            $section_options[$section->section] = $section_name;
        }
        $mform->addElement('select', 'sectionid', get_string('select_section', 'block_ifcare'), $section_options);
        $mform->setType('sectionid', PARAM_INT);
        $mform->setDefault('sectionid', $this->coleta->section_id);

        // Recursos do curso
        $modinfo = get_fast_modinfo($this->coleta->curso_id); // Obtém informações rápidas do curso
        $resources = [];

        foreach ($modinfo->cms as $cm) {
            if ($cm->uservisible) { // Verifica se o recurso está visível para o usuário
                $resources[$cm->id] = $cm->name; // Usa o nome do recurso
            }
        }

        $mform->addElement('select', 'resourceid', get_string('select_resource', 'block_ifcare'), $resources);
        $mform->setType('resourceid', PARAM_INT);
        $mform->setDefault('resourceid', $this->coleta->resource_id_atrelado);

        // Datas de início e fim
        $mform->addElement('date_time_selector', 'starttime', get_string('starttime', 'block_ifcare'), ['optional' => false]);
        $mform->setDefault('starttime', strtotime($this->coleta->data_inicio));

        $mform->addElement('date_time_selector', 'endtime', get_string('endtime', 'block_ifcare'), ['optional' => false]);
        $mform->setDefault('endtime', strtotime($this->coleta->data_fim));

        // Descrição
        $mform->addElement('textarea', 'description', get_string('description', 'block_ifcare'), 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('description', PARAM_TEXT);
        $mform->setDefault('description', $this->coleta->descricao);

        // Emoções associadas
        $classes = $DB->get_records('ifcare_classeaeq');
        $class_options = [];
        foreach ($classes as $class) {
            $class_options[$class->id] = $class->nome_classe;
        }
        $mform->addElement('select', 'classe_aeq', get_string('aeqclasses', 'block_ifcare'), $class_options);
        $mform->setType('classe_aeq', PARAM_INT);
        $mform->setDefault('classe_aeq', $this->coleta->classeaeq_id);

        $emotions = $DB->get_records('ifcare_emocao');
        $emotion_options = [];
        foreach ($emotions as $emotion) {
            $emotion_options[$emotion->id] = $emotion->nome;
        }
        $mform->addElement('select', 'emocoes', get_string('emotions', 'block_ifcare'), array(), array('multiple' => 'multiple', 'size' => 8));
        $mform->setType('emocoes', PARAM_INT);

        // Dividir e preencher as emoções selecionadas, se existirem
        $selected_emotions = (!empty($this->coleta->emocoes)) ? explode(',', $this->coleta->emocoes) : [];
        $mform->setDefault('emocoes', $selected_emotions);

        // Resumo de emoções
        $mform->addElement('html', '
            <div class="fitem">
                <div class="fitemtitle">Resumo das Seleções</div>
                <div id="emocoes-selecionadas" class="selected-emotions-container"></div>
            </div>
        ');

        // Checkboxes
        $mform->addElement('advcheckbox', 'alertprogress', get_string('alertprogress', 'block_ifcare'), null, ['group' => 1], [0, 1]);
        $mform->setDefault('alertprogress', $this->coleta->receber_alerta);

        $mform->addElement('advcheckbox', 'notify_students', get_string('notify_students', 'block_ifcare'), null, ['group' => 1], [0, 1]);
        $mform->setDefault('notify_students', $this->coleta->notificar_alunos);

        // Botão de envio
        $mform->addElement('submit', 'save', get_string('submit', 'block_ifcare'));


        $PAGE->requires->js(new moodle_url('/blocks/ifcare/js/shared.js'));
        $PAGE->requires->js(new moodle_url('/blocks/ifcare/js/edit_form.js'));


    }

    public function process_form($data)
    {
        global $DB;

        $update_data = new stdClass();
        $update_data->id = $this->coleta->id;
        $update_data->nome = $data->name;
        $update_data->data_inicio = date('Y-m-d H:i:s', $data->starttime);
        $update_data->data_fim = date('Y-m-d H:i:s', $data->endtime);
        $update_data->descricao = $data->description;
        $update_data->curso_id = $data->courseid;
        $update_data->section_id = $data->sectionid;
        $update_data->resource_id_atrelado = $data->resourceid;
        $update_data->receber_alerta = $data->alertprogress;
        $update_data->notificar_alunos = $data->notify_students;

        $DB->update_record('ifcare_cadastrocoleta', $update_data);

        // Atualizar as associações de emoções
        $DB->delete_records('ifcare_associacao_classe_emocao_coleta', ['cadastrocoleta_id' => $this->coleta->id]);

        if (!empty($data->emocoes)) {
            foreach ($data->emocoes as $emocao_id) {
                $assoc = new stdClass();
                $assoc->cadastrocoleta_id = $this->coleta->id;
                $assoc->classeaeq_id = $data->classe_aeq;
                $assoc->emocao_id = $emocao_id;
                $DB->insert_record('ifcare_associacao_classe_emocao_coleta', $assoc);
            }
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

