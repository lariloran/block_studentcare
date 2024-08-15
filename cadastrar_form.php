<?php

require_once("$CFG->libdir/formslib.php");

class cadastrar_form extends moodleform
{
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

        // Define as opções para o select.
        $options = array(
            'class1' => get_string('class1', 'block_ifcare'),
            'class2' => get_string('class2', 'block_ifcare'),
            'class3' => get_string('class3', 'block_ifcare'),
        );

        // Adiciona o campo select ao formulário.
        $mform->addElement('select', 'FIELDNAME', get_string('aeqclasses', 'block_ifcare'), $options);
        $mform->setType('FIELDNAME', PARAM_TEXT);

        // Adicione o contêiner para a tabela dinâmica utilizando as classes de layout padrão do Moodle
        $mform->addElement('html', '<div class="fitem">
                                        <div class="fitemtitle">Selecione as emoções</div> <!-- Espaço vazio à esquerda -->
                                        <div class="felement">
                                            <table id="container-tabela" class="generaltable"></table>
                                        </div>
                                    </div>');

        // Inclua o JavaScript
        $PAGE->requires->js('/blocks/ifcare/tabela_dinamica.js');

        $mform->addElement('html', '<div class="fitem">
    <div class="fitemtitle">Resumo das Seleções</div>
    <div class="felement" id="resumo-selecoes">
        <ul id="resumo-lista">
            <!-- Itens do resumo serão inseridos aqui pelo JavaScript -->
        </ul>
    </div>
</div>
');

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
?>