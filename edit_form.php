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
 * edit_form
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

/**
 * edit_form
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class edit_form extends moodleform {
    private $coleta;

    public function __construct($coletaid) {
        global $DB;

        if (!$coletaid || !is_numeric($coletaid)) {
            throw new moodle_exception('invalidcoletaid', 'block_studentcare', '', $coletaid);
        }

        $this->coleta = $DB->get_record('studentcare_cadastrocoleta', ['id' => $coletaid]);
        if (!$this->coleta) {
            throw new moodle_exception('invalidcoletaid', 'block_studentcare', '', $coletaid);
        }

        // Garantir que as propriedades necessárias existam com valores padrão
        $this->coleta->classeaeq_id = $this->coleta->classeaeq_id ?? 0;

        $this->coleta->emocoes = $DB->get_records_menu(
                'studentcare_associacao_classe_emocao_coleta',
                ['cadastrocoleta_id' => $coletaid],
                null,
                'emocao_id, emocao_id'
        );

        parent::__construct();
    }

    public function definition() {
        global $PAGE, $DB, $USER;

        // Verifica se a coleta já foi iniciada
        $coletaniciada = strtotime($this->coleta->data_inicio) <= time();

        $mform = $this->_form;
        $mform->addElement('hidden', 'coletaid', $this->coleta->id);
        $mform->setType('coletaid', PARAM_INT);

        // Nome da coleta (preenchido com o valor existente)
        $mform->addElement('text', 'name', get_string('name', 'block_studentcare'), ['size' => '50', 'readonly' => 'readonly']);
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', $this->coleta->nome);

        if (!$coletaniciada) {
            $courses = $this->get_user_courses($USER->id, true);
            $courseoptions = [];
            foreach ($courses as $course) {
                $courseoptions[$course->id] = $course->fullname;
            }

            $mform->addElement('select', 'courseid', get_string('select_course', 'block_studentcare'), $courseoptions);
            $mform->setType('courseid', PARAM_INT);
            $mform->setDefault('courseid', $this->coleta->curso_id);
        }

        // Seções do curso
        if (!$coletaniciada) {

            $sections = $DB->get_records('course_sections', ['course' => $this->coleta->curso_id]);
            $sectionoptions = [];
            foreach ($sections as $section) {
                $sectionname = get_section_name($this->coleta->curso_id, $section->section);
                $sectionoptions[$section->section] = $sectionname;
            }
            $mform->addElement('select', 'sectionid', get_string('select_section', 'block_studentcare'), $sectionoptions);
            $mform->setType('sectionid', PARAM_INT);
            $mform->setDefault('sectionid', $this->coleta->section_id);
            $mform->addHelpButton('sectionid', 'select_section', 'block_studentcare');
        }

        // Recursos da seção específica
        $modinfo = get_fast_modinfo($this->coleta->curso_id);
        $resources = [];

        // Adiciona a opção padrão
        $resources[''] = get_string('dontlink', 'block_studentcare');

        // Verifica se a seção existe e contém recursos
        if (isset($modinfo->sections[$this->coleta->section_id]) && is_array($modinfo->sections[$this->coleta->section_id])) {
            foreach ($modinfo->sections[$this->coleta->section_id] as $cmid) {
                $cm = $modinfo->cms[$cmid];
                if ($cm->uservisible) {
                    $resources[$cm->id] = $cm->name;
                }
            }
        }

        // Adiciona o elemento de seleção ao formulário
        $mform->addElement('select', 'resourceid', get_string('select_resource', 'block_studentcare'), $resources);
        $mform->setType('resourceid', PARAM_INT);
        $mform->addHelpButton('resourceid', 'select_resource', 'block_studentcare');

        // Define a opção padrão como selecionada, se nenhuma for encontrada
        $defaultresourceid = $this->coleta->resource_id_atrelado ?? '';
        $mform->setDefault('resourceid', $defaultresourceid);

        // Datas de início e fim
        if (!$coletaniciada) {
            $mform->addElement('date_time_selector', 'starttime', get_string('starttime', 'block_studentcare'),
                    ['optional' => false]);
            $mform->setDefault('starttime', strtotime($this->coleta->data_inicio));
        }

        $mform->addElement('date_time_selector', 'endtime', get_string('endtime', 'block_studentcare'), ['optional' => false]);
        $mform->setDefault('endtime', strtotime($this->coleta->data_fim));

        // Descrição
        $mform->addElement('textarea', 'description', get_string('description', 'block_studentcare'),
                'wrap="virtual" rows="5" cols="50" maxlength="200"');
        $mform->setType('description', PARAM_TEXT);
        $mform->setDefault('description', $this->coleta->descricao);

        // Emoções associadas
        if (!$coletaniciada) {

            $classes = $DB->get_records('studentcare_classeaeq');
            $classoptions = [];
            foreach ($classes as $class) {
                $classoptions[$class->id] = get_string($class->nome_classe, 'block_studentcare');
            }
            $mform->addElement('select', 'classe_aeq', get_string('aeqclasses', 'block_studentcare'), $classoptions);
            $mform->setType('classe_aeq', PARAM_INT);
            $mform->setDefault('classe_aeq', $this->coleta->classeaeq_id);
            $mform->addHelpButton('classe_aeq', 'aeqclasses', 'block_studentcare');

            $selectedemotions = [];

            // Obter as emoções associadas organizadas por classe
            $emocaoassociadas = $DB->get_records('studentcare_associacao_classe_emocao_coleta', [
                    'cadastrocoleta_id' => $this->coleta->id,
            ]);

            foreach ($emocaoassociadas as $associacao) {
                $classeid = $associacao->classeaeq_id;
                $emocaoid = $associacao->emocao_id;

                // Buscar o nome da emoção pelo ID
                $emocao = $DB->get_record('studentcare_emocao', ['id' => $emocaoid], 'id, nome');

                if ($emocao) {
                    if (!isset($selectedemotions[$classeid])) {
                        $selectedemotions[$classeid] = [];
                    }

                    // Adicionar ao array com os detalhes completos
                    $selectedemotions[$classeid][] = [
                            'id' => $emocao->id,
                            'name' => get_string($emocao->nome, 'block_studentcare'),
                    ];
                }
            }

            $emotions = $DB->get_records('studentcare_emocao');
            $emotionoptions = [];
            foreach ($emotions as $emotion) {
                $emotionoptions[$emotion->id] = $emotion->nome;
            }

            $mform->addElement('select', 'emocoes', get_string('emotions', 'block_studentcare'), $emotionoptions,
                    ['multiple' => 'multiple', 'size' => 8]);
            $mform->setType('emocoes', PARAM_SEQUENCE);
            $mform->addHelpButton('emocoes', 'emotions', 'block_studentcare');

            $mform->addElement('hidden', 'emocao_selecionadas', '', array('id' => 'emocao_selecionadas'));
            $mform->setType('emocao_selecionadas', PARAM_RAW);

            $mform->addElement('hidden', 'emocao_associadas', '', ['id' => 'emocao_associadas']);
            $mform->setType('emocao_associadas', PARAM_RAW);
            $mform->setDefault('emocao_associadas', json_encode(value: $selectedemotions));
        }

        if (!$coletaniciada) {
            $mform->addElement('html', '
            <div class="fitem">
                <div class="fitemtitle">' . get_string('selection_summary', 'block_studentcare') . '</div>
                <div id="emocoes-selecionadas" class="selected-emotions-container"></div>
            </div>
        ');

        }
        // Checkboxes
        $mform->addElement('advcheckbox', 'alertprogress', get_string('alertprogress', 'block_studentcare'), null, ['group' => 1],
                [0, 1]);
        $mform->setDefault('alertprogress', $this->coleta->receber_alerta);
        $mform->addHelpButton('alertprogress', 'alertprogress', 'block_studentcare');

        if (!$coletaniciada) {
            $mform->addElement('advcheckbox', 'notify_students', get_string('notify_students', 'block_studentcare'), null,
                    ['group' => 1], [0, 1]);
            $mform->setDefault('notify_students', $this->coleta->notificar_alunos);
            $mform->addHelpButton('notify_students', 'notify_students', 'block_studentcare');
        }

        echo '<div id="confirmation-data"
        data-title="' . get_string('confirm_title', 'block_studentcare') . '"
        data-message="' . get_string('confirm_message_update', 'block_studentcare') . '"
        data-yes="' . get_string('confirm_button_yes', 'block_studentcare') . '"
        data-no="' . get_string('confirm_button_no', 'block_studentcare') . '">
         </div>';

        // Botões de enviar e cancelar agrupados
        $buttonarray = [];
        $buttonarray[] = $mform->createElement('submit', 'save', get_string('update', 'block_studentcare'));
        $buttonarray[] = $mform->createElement('cancel', 'cancel', get_string('cancel'));
        $mform->addGroup($buttonarray, 'buttonar', '', [' '], false);

        $mform->addElement('hidden', 'setor', '', array('id' => 'setor'));
        $mform->setType('setor', PARAM_INT);

        $mform->addElement('hidden', 'recurso', '', array('id' => 'recurso'));
        $mform->setType('recurso', PARAM_INT);

        $PAGE->requires->js(new moodle_url('/blocks/studentcare/js/shared.js'));
        $PAGE->requires->js(new moodle_url('/blocks/studentcare/js/edit_form.js'));
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

    public function process_form($data) {
        global $DB, $SESSION;

        // Verifica se a coleta já foi iniciada
        $coletaniciada = strtotime($this->coleta->data_inicio) <= time();

        // Atualiza apenas os campos permitidos dependendo do estado da coleta
        $updatedata = new stdClass();
        $updatedata->id = clean_param($data->coletaid, PARAM_INT);

        if (!$coletaniciada) {
            // Atualizações permitidas na edição completa
            $updatedata->curso_id = clean_param($data->courseid, PARAM_INT);
            $updatedata->section_id = clean_param($data->setor, PARAM_INT);
            $updatedata->data_inicio = date('Y-m-d H:i:s', clean_param($data->starttime, PARAM_INT));
        }

        // Atualizações permitidas em qualquer estado
        $updatedata->data_fim = date('Y-m-d H:i:s', clean_param($data->endtime, PARAM_INT));
        $updatedata->descricao = clean_param($data->description, PARAM_TEXT);
        $updatedata->receber_alerta = clean_param($data->alertprogress, PARAM_INT);
        $updatedata->resource_id_atrelado = clean_param($data->recurso, PARAM_INT);

        if (!$coletaniciada) {
            $updatedata->notificar_alunos = clean_param($data->notify_students, PARAM_INT);
        }

        // Atualizar o registro principal
        try {
            $DB->update_record('studentcare_cadastrocoleta', $updatedata);
        } catch (dml_exception $e) {
            debugging('Erro ao atualizar os dados da coleta: ' . $e->getMessage());
            throw new moodle_exception('erro_ao_atualizar_coleta', 'block_studentcare');
        }

        // Atualizar associações de emoções (apenas se a coleta não foi iniciada)
        if (!$coletaniciada) {
            try {
                // Deletar as emoções antigas
                $DB->delete_records('studentcare_associacao_classe_emocao_coleta', ['cadastrocoleta_id' => $this->coleta->id]);

                // Decodificar e validar o campo oculto `emocao_selecionadas`
                $emocaoselecionadas = json_decode($data->emocao_selecionadas, true);

                if (!is_array($emocaoselecionadas)) {
                    debugging('O campo emocao_selecionadas não contém um array válido.');
                    $emocaoselecionadas = [];
                }

                // Adicionar as novas emoções
                foreach ($emocaoselecionadas as $classeaeqid => $emocoes) {
                    if (is_array($emocoes)) {
                        foreach ($emocoes as $emocao) {
                            $assoc = new stdClass();
                            $assoc->cadastrocoleta_id = $this->coleta->id;
                            $assoc->classeaeq_id = clean_param($classeaeqid, PARAM_INT);
                            $assoc->emocao_id = clean_param($emocao['id'], PARAM_INT);

                            $DB->insert_record('studentcare_associacao_classe_emocao_coleta', $assoc);
                        }
                    }
                }
            } catch (dml_exception $e) {
                debugging('Erro ao atualizar as emoções associadas: ' . $e->getMessage());
                throw new moodle_exception('erro_ao_atualizar_emocoes', 'block_studentcare');
            }
        }

        // Redirecionar com sucesso
        $SESSION->mensagem_sucesso = get_string('coleta_atualizada_com_sucesso', 'block_studentcare');
        redirect(new moodle_url('/blocks/studentcare/index.php', ));
    }

}

class CadastroColeta {
    private $nome; // Name
    private $datainicio; // Start date
    private $horainicio; // Start hour
    private $dataFim; // End date
    private $horafim; // End hour
    private $descricao; // Description
    private $receberalerta; // Receive alert
    private $notificaralunos; // Notify students
    private $cursoid; // Course id
    private $professorid; // Professor id
    private $classesaeq; // Class aeq

    public function __construct($nome, $datainicio, $horainicio, $dataFim, $horafim, $descricao, $receberalerta, $notificaralunos,
            $cursoid, $professorid) {
        $this->nome = $nome;
        $this->dataInicio = $datainicio;
        $this->horaInicio = $horainicio;
        $this->dataFim = $dataFim;
        $this->horaFim = $horafim;
        $this->descricao = $descricao;
        $this->receberAlerta = $receberalerta;
        $this->notificarAlunos = $notificaralunos;
        $this->cursoId = $cursoid;
        $this->professorId = $professorid;
        $this->classesAEQ = [];
    }

    public function adicionarclasse($classe, $emoções) {
        $this->classesAEQ[$classe] = $emoções;
    }
}

class ClasseAeq {
    private $nomeclasse;

    public function __construct($nomeclasse) {
        $this->nomeClasse = $nomeclasse;
    }

    public function getNomeClasse() {
        return $this->nomeClasse;
    }

    public function setNomeClasse($nomeclasse) {
        $this->nomeClasse = $nomeclasse;
    }
}

