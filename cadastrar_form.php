<?php
require_once("$CFG->libdir/formslib.php");

class cadastrar_form extends moodleform {
    // Define o formulário
    public function definition() {
        $mform = $this->_form;

//            // These two elements are part of group 1.
//     $mform->addElement('advcheckbox', 'test1', 'Test 1', null, ['group' => 1]);
//     $mform->addElement('advcheckbox', 'test2', 'Test 2', null, ['group' => 1]);

//     // Add a checkbox controller for all checkboxes in `group => 1`:
//     $this->add_checkbox_controller(1);

//     // These two elements are part of group 3.
//     $mform->addElement('advcheckbox', 'test3', 'Test 3', null, ['group' => 3]);
//     $mform->addElement('advcheckbox', 'test4', 'Test 4', null, ['group' => 3]);

//     // Add a checkbox controller for all checkboxes in `group => 3`.
//     // This example uses a different wording isntead of Select all/none by passing the second parameter:
//     $this->add_checkbox_controller(
//         3,
//         get_string("checkall", "plugintype_pluginname")
//     );

//     // Define the options for the dropdown list.
// $options = new core\output\choicelist();
// $options->add_option(
//     'option1',
//     "Text option 1",
//     [
//         'description' => 'Option 1 description',
//         'icon' => new pix_icon('t/hide', 'Eye icon 1'),
//     ]
// );
// $options->add_option(
//     'option2',
//     "Text option 2",
//     [
//         'description' => 'Option 2 description',
//         'icon' => new pix_icon('t/stealth', 'Eye icon 2'),
//     ]
// );
// $options->add_option(
//     'option3',
//     "Text option 3",
//     [
//         'description' => 'Option 3 description',
//         'icon' => new pix_icon('t/show', 'Eye icon 3'),
//     ]
// );

// // Add the choicedropdown field to the form.
// $mform->addElement(
//     'choicedropdown',
//     'FIELDNAME',
//     get_string('FIELDNAME', 'PLUGINNAME'),
//     $options,
// );

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

        // Campo Selecionar Classes do AEQ
        $aeqclasses = array(
            'class1' => get_string('class1', 'block_ifcare'),
            'class2' => get_string('class2', 'block_ifcare'),
            'class3' => get_string('class3', 'block_ifcare')
        );
        $mform->addElement('select', 'aeqclasses', get_string('aeqclasses', 'block_ifcare'), $aeqclasses, array('multiple' => true));
        $mform->setType('aeqclasses', PARAM_RAW);
        $mform->addRule('aeqclasses', null, 'required', null, 'client');

        // Campo Selecionar Emoções
        $emotions = array(
            'alegria' => get_string('alegria', 'block_ifcare'),
            'esperanca' => get_string('esperanca', 'block_ifcare'),
            'orgulho' => get_string('orgulho', 'block_ifcare'),
            'raiva' => get_string('raiva', 'block_ifcare'),
            'ansiedade' => get_string('ansiedade', 'block_ifcare'),
            'vergonha' => get_string('vergonha', 'block_ifcare'),
            'desesperanca' => get_string('desesperanca', 'block_ifcare'),
            'tedio' => get_string('tedio', 'block_ifcare'),
            'alivio' => get_string('alivio', 'block_ifcare')
        );
        $mform->addElement('select', 'emotions', get_string('emotions', 'block_ifcare'), $emotions, array('multiple' => true));
        $mform->setType('emotions', PARAM_RAW);
        $mform->addRule('emotions', null, 'required', null, 'client');

        // Campo Selecionar Bloco de Momento (Antes, Durante, Depois)
        $momentblock = array(
            'before' => get_string('before', 'block_ifcare'),
            'during' => get_string('during', 'block_ifcare'),
            'after' => get_string('after', 'block_ifcare')
        );
        $mform->addElement('select', 'momentblock', get_string('momentblock', 'block_ifcare'), $momentblock,  array('multiple' => true));
        $mform->setType('momentblock', PARAM_RAW);
        $mform->addRule('momentblock', null, 'required', null, 'client');

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
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        // Verifica se a data de fim é posterior à data de início
        if ($data['endtime'] <= $data['starttime']) {
            $errors['endtime'] = get_string('endtimeerror', 'block_ifcare');
        }

        return $errors;
    }
}
