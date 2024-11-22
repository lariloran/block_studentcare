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


        $this->coleta->emocoes = $DB->get_records_menu(
            'ifcare_associacao_classe_emocao_coleta',
            ['cadastrocoleta_id' => $coleta_id],
            null,
            'emocao_id, emocao_id'
        );

        parent::__construct();
    }

    public function definition()
    {
        global $PAGE, $DB, $USER;

        $mform = $this->_form;
        $mform->addElement('hidden', 'coletaid', $this->coleta->id);
        $mform->setType('coletaid', PARAM_INT);


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

        // Recursos da seção específica
        $modinfo = get_fast_modinfo($this->coleta->curso_id);
        $resources = [];

        // Adiciona a opção padrão
        $resources[''] = 'Não vincular a nenhuma atividade/recurso';

        if (isset($modinfo->sections[$this->coleta->section_id])) {
            foreach ($modinfo->sections[$this->coleta->section_id] as $cmid) {
                $cm = $modinfo->cms[$cmid];
                if ($cm->uservisible) {
                    $resources[$cm->id] = $cm->name;
                }
            }
        } else {
            mtrace("Seção {$this->coleta->section_id} não encontrada ou sem recursos visíveis.");
        }

        $mform->addElement('select', 'resourceid', get_string('select_resource', 'block_ifcare'), $resources);
        $mform->setType('resourceid', PARAM_INT);

        // Define a opção padrão como selecionada, se nenhuma for encontrada
        $default_resourceid = $this->coleta->resource_id_atrelado ?? '';
        $mform->setDefault('resourceid', $default_resourceid);



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

        $selected_emotions = array_keys($this->coleta->emocoes);

        $emotions = $DB->get_records('ifcare_emocao');
        $emotion_options = [];
        foreach ($emotions as $emotion) {
            $emotion_options[$emotion->id] = $emotion->nome;
        }

        $mform->addElement('select', 'emocoes', get_string('emotions', 'block_ifcare'), $emotion_options, ['multiple' => 'multiple', 'size' => 8]);
        $mform->setType('emocoes', PARAM_SEQUENCE);
        $mform->addElement('hidden', 'emocao_associadas', '', ['id' => 'emocao_associadas']);
        $mform->setType('emocao_associadas', PARAM_RAW);

        $mform->setDefault('emocao_associadas', json_encode($selected_emotions));


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
        $mform->addElement('submit', 'save', get_string('update', 'block_ifcare'));
        
        $mform->addElement('hidden', 'setor', '', array('id' => 'setor'));
        $mform->setType('setor', PARAM_INT);

        $mform->addElement('hidden', 'recurso', '', array('id' => 'recurso'));
        $mform->setType('recurso', PARAM_INT);


        $PAGE->requires->js(new moodle_url('/blocks/ifcare/js/shared.js'));
        $PAGE->requires->js(new moodle_url('/blocks/ifcare/js/edit_form.js'));
    }

    public function process_form($data)
    {
        global $DB, $SESSION;
        // Atualizar os dados principais da coleta
        $update_data = new stdClass();
        $update_data->id = clean_param($data->coletaid, PARAM_INT);
        $update_data->nome = clean_param($data->name, PARAM_TEXT);
        $update_data->data_inicio = date('Y-m-d H:i:s', clean_param($data->starttime, PARAM_INT));
        $update_data->data_fim = date('Y-m-d H:i:s', clean_param($data->endtime, PARAM_INT));
        $update_data->descricao = clean_param($data->description, PARAM_TEXT);
        $update_data->curso_id = clean_param($data->courseid, PARAM_INT);
        $update_data->section_id = clean_param($data->setor, PARAM_INT);
        $update_data->resource_id_atrelado =  clean_param($data->recurso, PARAM_INT);
        $update_data->receber_alerta = clean_param($data->alertprogress, PARAM_INT);
        $update_data->notificar_alunos = clean_param($data->notify_students, PARAM_INT);

        // Atualizar o registro principal
        try {
            $DB->update_record('ifcare_cadastrocoleta', $update_data);
        } catch (dml_exception $e) {
            debugging('Erro ao atualizar os dados da coleta: ' . $e->getMessage());
            throw new moodle_exception('erro_ao_atualizar_coleta', 'block_ifcare');
        }

        // Atualizar associações de emoções
        try {
            // Deletar as emoções antigas
            $DB->delete_records('ifcare_associacao_classe_emocao_coleta', ['cadastrocoleta_id' => $this->coleta->id]);

            // Adicionar as novas emoções
            if (!empty($data->emocoes)) {
                foreach ($data->emocoes as $emocao_id) {
                    $assoc = new stdClass();
                    $assoc->cadastrocoleta_id = $this->coleta->id;
                    $assoc->classeaeq_id = clean_param($data->classe_aeq, PARAM_INT);
                    $assoc->emocao_id = clean_param($emocao_id, PARAM_INT);

                    $DB->insert_record('ifcare_associacao_classe_emocao_coleta', $assoc);
                }
            }
        } catch (dml_exception $e) {
            debugging('Erro ao atualizar as emoções associadas: ' . $e->getMessage());
            throw new moodle_exception('erro_ao_atualizar_emocoes', 'block_ifcare');
        }

        // Redirecionar com sucesso
        $SESSION->mensagem_sucesso = get_string('coleta_atualizada_com_sucesso', 'block_ifcare');
        redirect(new moodle_url('/blocks/ifcare/index.php', ['courseid' => $data->courseid]));
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

