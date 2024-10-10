<?php
require_once("$CFG->libdir/formslib.php");

class CadastrarForm extends moodleform
{
    // Construtor da classe
    public function __construct() {
        parent::__construct(); // Chama o construtor da classe pai
    }

    // Define o formulário
    public function definition()
    {
        global $PAGE;

        $mform = $this->_form;

        // Campo Nome
        $mform->addElement('text', 'name', get_string('name', 'block_ifcare'), array('size' => '50'));
        $mform->setType('name', PARAM_NOTAGS);
        $mform->addRule('name', null, 'required', null, 'client');

        // Campo Data e Hora de Início da coleta
        $mform->addElement('date_time_selector', 'starttime', get_string('starttime', 'block_ifcare'), array('optional' => false));
        $mform->addRule('starttime', null, 'required', null, 'client');

        // Campo Data e Hora de Fim da coleta
        $mform->addElement('date_time_selector', 'endtime', get_string('endtime', 'block_ifcare'), array('optional' => false));
        $mform->addRule('endtime', null, 'required', null, 'client');

        // Campo Descrição
        $mform->addElement('textarea', 'description', get_string('description', 'block_ifcare'), 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('description', PARAM_TEXT);

        global $DB;

          // Consulta à tabela mdl_ifcare_classeaeq.
    $classes = $DB->get_records('ifcare_classeaeq');

    // Definir as opções para o select com os dados da tabela.
    $options = array();
    foreach ($classes as $class) {
        // Criar uma instância da ClasseAeq para cada registro.
        $classeAeq = new ClasseAeq($class->nome_classe);
        $options[$class->id] = $classeAeq->getNomeClasse(); // Usa o método getNomeClasse para obter o nome.
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

    // Inclui o JavaScript
    $PAGE->requires->js('/blocks/ifcare/js/tabela_dinamica.js');

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
        $this->add_action_buttons(true, get_string('submit', 'block_ifcare'));
    }

    // Função de validação personalizada (opcional)
    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);

        // Verifica se a data de fim é posterior à data de início
        if ($data['endtime'] <= $data['starttime']) {
            $errors['endtime'] = get_string('endtimeerror', 'block_ifcare');
        }

        return $errors;
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

