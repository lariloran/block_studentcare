<?php
require_once("$CFG->libdir/formslib.php");

class ifcare_form extends moodleform {
    // Adiciona os elementos ao formulário
    public function definition() {
        $mform = $this->_form;

        // Adiciona um campo de texto para o nome
        $mform->addElement('text', 'name', 'Nome');
        $mform->setType('name', PARAM_NOTAGS);
        $mform->addRule('name', null, 'required', null, 'client');

        // Adiciona um campo de texto para o e-mail
        $mform->addElement('text', 'email', get_string('email', 'block_ifcare'));
        $mform->setType('email', PARAM_EMAIL);
        $mform->addRule('email', null, 'required', null, 'client');

        // Adiciona um botão de enviar
        $this->add_action_buttons();
    }

    // Função de validação
    function validation($data, $files) {
        return array();
    }
}
