<?php
require_once("$CFG->libdir/formslib.php");
require_once("$CFG->libdir/classes/notification.php");

use core\notification;

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
        parent::__construct();
    }

    public function get_user_courses($userid)
    {
        $courses = enrol_get_users_courses($userid, true);
        $teacher_courses = [];
        foreach ($courses as $course) {
            $context = context_course::instance($course->id);
            if (has_capability('moodle/course:update', $context, $userid)) {
                $teacher_courses[$course->id] = $course->fullname;
            }
        }
        return $teacher_courses;
    }

    public function definition()
    {
        global $PAGE, $DB;

        $mform = $this->_form;

        $context = context_course::instance($this->coleta->curso_id);
        $PAGE->set_context($context);

        // Nome da coleta
        $mform->addElement('text', 'name', get_string('name', 'block_ifcare'), ['size' => '50']);
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', $this->coleta->nome);

        // Cursos
        $cursos = $this->get_user_courses($this->coleta->professor_id);
        $mform->addElement('select', 'courseid', get_string('select_course', 'block_ifcare'), $cursos);
        $mform->setType('courseid', PARAM_INT);
        $mform->setDefault('courseid', $this->coleta->curso_id);

        // Buscar o nome da seção atual com base no section_id e curso_id
        $current_section_name = $DB->get_field('course_sections', 'name', [
            'section' => $this->coleta->section_id,
            'course' => $this->coleta->curso_id,
        ]);

        // Garantir que o nome tenha um valor padrão se estiver vazio
        if (!$current_section_name) {
            $current_section_name = get_string('section') . ' ' . $this->coleta->section_id;
        }

        // Carregar todas as seções do curso selecionado
        $sections = $DB->get_records('course_sections', ['course' => $this->coleta->curso_id]);
        $section_options = [];
        foreach ($sections as $section) {
            $section_name = $section->name ?: get_string('section') . ' ' . $section->section;
            $section_options[$section->section] = $section_name; // Use 'section' como chave.
        }

        // Adicionar o campo de seleção
        $mform->addElement('select', 'sectionid', get_string('select_section', 'block_ifcare'), $section_options);
        $mform->setType('sectionid', PARAM_INT);

        // Definir o valor inicial com base na seção atual da coleta
        $mform->setDefault('sectionid', $this->coleta->section_id);


        // Recursos
        $resources = $DB->get_records('course_modules', ['course' => $this->coleta->curso_id]);
        $resource_options = [];
        foreach ($resources as $resource) {
            $module_name = $DB->get_field('modules', 'name', ['id' => $resource->module]);
            $resource_options[$resource->id] = $module_name . ' - ' . $resource->id;
        }
        $mform->addElement('select', 'resourceid', get_string('select_resource', 'block_ifcare'), $resource_options);
        $mform->setType('resourceid', PARAM_INT);
        $mform->setDefault('resourceid', $this->coleta->resource_id_atrelado);

        // Datas
        $mform->addElement('date_time_selector', 'starttime', get_string('starttime', 'block_ifcare'), ['optional' => false]);
        $mform->setDefault('starttime', strtotime($this->coleta->data_inicio));

        $mform->addElement('date_time_selector', 'endtime', get_string('endtime', 'block_ifcare'), ['optional' => false]);
        $mform->setDefault('endtime', strtotime($this->coleta->data_fim));

        // Descrição
        $mform->addElement('textarea', 'description', get_string('description', 'block_ifcare'), 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('description', PARAM_TEXT);
        $mform->setDefault('description', $this->coleta->descricao);

        // Emoções
        $classes = $DB->get_records('ifcare_classeaeq');
        $class_options = [];
        foreach ($classes as $class) {
            $class_options[$class->id] = $class->nome_classe;
        }
        $mform->addElement('select', 'classe_aeq', get_string('aeqclasses', 'block_ifcare'), $class_options);
        $mform->setType('classe_aeq', PARAM_TEXT);

        $emotions = $DB->get_records('ifcare_emocao');
        $emotion_options = [];
        foreach ($emotions as $emotion) {
            $emotion_options[$emotion->id] = $emotion->nome;
        }
        $emotion_associations = $DB->get_records('ifcare_associacao_classe_emocao_coleta', ['cadastrocoleta_id' => $this->coleta->id]);
        $selected_emotions = array_map(fn($assoc) => $assoc->emocao_id, $emotion_associations);
        $mform->addElement('select', 'emocoes', get_string('emotions', 'block_ifcare'), $emotion_options, ['multiple' => 'multiple', 'size' => 8]);
        $mform->setDefault('emocoes', $selected_emotions);
        $mform->setType('emocoes', PARAM_INT);

        // Checkboxes
        $mform->addElement('advcheckbox', 'alertprogress', get_string('alertprogress', 'block_ifcare'), null, ['group' => 1], [0, 1]);
        $mform->setDefault('alertprogress', $this->coleta->receber_alerta);

        $mform->addElement('advcheckbox', 'notify_students', get_string('notify_students', 'block_ifcare'), null, ['group' => 1], [0, 1]);
        $mform->setDefault('notify_students', $this->coleta->notificar_alunos);

        // Botão de submit
        $mform->addElement('submit', 'save', get_string('submit', 'block_ifcare'));
        $PAGE->requires->js(new moodle_url('/blocks/ifcare/js/dynamicform.js'));
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
    }
}
?>