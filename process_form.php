<?php
require_once('../../config.php'); // Caminho para o arquivo config.php do Moodle


// Recupera os dados do formulário
global $DB;

$userid = optional_param('userid', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);
$grade = optional_param('grade', 0, PARAM_INT);
$description = optional_param('description', '', PARAM_TEXT);

// Validação dos dados (adicione suas próprias regras de validação aqui)

// Cria um objeto com os dados para serem inseridos no banco
$data = new stdClass();
$data->userid = $userid;
$data->grade = $grade;
$data->description = $description;

// Chama a função para inserir no banco
$DB->insert_record('ifcare', $data);

redirect(new moodle_url("/course/view.php?id=$courseid")); // Substitua pelo caminho real da página que você deseja redirecionar