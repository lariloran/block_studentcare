<?php
require_once("$CFG->libdir/formslib.php");

class cadastrar_form extends moodleform {
    // Define o formulário
    public function definition() {
        $mform = $this->_form;

        // Campo Nome
        $mform->addElement('text', 'name', get_string('name', 'block_ifcare'), array('size' => '50'));
        $mform->setType('name', PARAM_NOTAGS);
        $mform->addRule('name', null, 'required', null, 'client');

        // Campo E-mail
        $mform->addElement('text', 'email', get_string('email', 'block_ifcare'), array('size' => '50'));
        $mform->setType('email', PARAM_EMAIL);
        $mform->addRule('email', null, 'required', null, 'client');
        $mform->addRule('email', null, 'email', null, 'client');

        // Botão de Enviar
        $this->add_action_buttons(true, get_string('submit', 'block_ifcare'));
    }
}
?>
