<?php
require_once('../../config.php');
require_login();

$courseid = required_param('courseid', PARAM_INT);
$sectionnum = required_param('sectionid', PARAM_INT);

$response = ['resources' => ''];

try {
    // Obtém as informações do curso
    $modinfo = get_fast_modinfo($courseid);

    // Verifica se a seção existe
    if (!isset($modinfo->get_sections()[$sectionnum])) {
        throw new Exception("Seção não encontrada.");
    }

    $section_modules = $modinfo->get_sections()[$sectionnum];

    // Itera pelos módulos da seção
    foreach ($section_modules as $cmid) {
        $mod = $modinfo->cms[$cmid];
        
        // Verifica se o módulo está visível
        if ($mod->uservisible) {
            $response['resources'] .= "<option value='{$cmid}'>{$mod->name}</option>";
        }
    }
} catch (Exception $e) {
    // Se ocorrer um erro, retorna a mensagem no console (para fins de debug)
    $response['resources'] = "<option value=''>{$e->getMessage()}</option>";
}

// Retorna a resposta como JSON
echo json_encode($response);
