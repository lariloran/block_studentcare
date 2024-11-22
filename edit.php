<?php

require_once('../../config.php');
require_once("$CFG->libdir/formslib.php");
require_once(__DIR__ . '/edit_form.php');

require_login();

// Obtém o ID da coleta a ser editada
$coletaid = required_param('coletaid', PARAM_INT);

// Verifica se o ID da coleta é válido
if (!$coletaid || !is_numeric($coletaid)) {
    print_error('invalidcoletaid', 'block_ifcare');
}

// Carrega o registro da coleta para validação e contexto
$coleta = $DB->get_record('ifcare_cadastrocoleta', ['id' => $coletaid], '*', MUST_EXIST);

// Configuração de contexto (ajusta para o curso da coleta, se aplicável)
$context = context_system::instance(); // Contexto padrão
if (!empty($coleta->curso_id)) {
    $context = context_course::instance($coleta->curso_id);
}
$PAGE->set_context($context);

// Configuração da página
$PAGE->set_url(new moodle_url('/blocks/ifcare/edit.php', ['coletaid' => $coletaid]));
$PAGE->set_title(get_string('editcoleta', 'block_ifcare'));
$PAGE->set_heading(get_string('editcoleta', 'block_ifcare'));

// Cabeçalho da página
echo $OUTPUT->header();

// Renderiza o formulário de edição
try {
    $mform = new edit_form($coletaid);

    if ($mform->is_cancelled()) {
        // Redireciona ao cancelar
        redirect(new moodle_url('/blocks/ifcare/index.php'));
    } else if ($data = $mform->get_data()) {
        // Processa o formulário
        $mform->process_form($data);

        // Define mensagem de sucesso
        $SESSION->mensagem_sucesso = get_string('coleta_atualizada_com_sucesso', 'block_ifcare');
        redirect(new moodle_url('/blocks/ifcare/index.php'));
    }

    // Exibe o formulário
    $mform->display();
} catch (Exception $e) {
    // Exibe mensagem de erro no caso de exceção
    echo $OUTPUT->notification($e->getMessage(), 'error');
    echo $OUTPUT->continue_button(new moodle_url('/blocks/ifcare/index.php'));
}

// Rodapé da página
echo $OUTPUT->footer();

?>
