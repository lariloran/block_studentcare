<?php
require_once('../../config.php');
require_login();

$courseid = required_param('courseid', PARAM_INT);
$sectionnum = required_param('sectionid', PARAM_INT);

$response = ['resources' => []]; // Inicialize como um array para armazenar os recursos

try {
    // Obtém as informações do curso
    $modinfo = get_fast_modinfo($courseid);

    // Verifica se a seção existe
    if (!isset($modinfo->get_sections()[$sectionnum])) {
        throw new Exception("Não há atividade/recurso nesta seção.");
    }

    $section_modules = $modinfo->get_sections()[$sectionnum];

    // Adiciona a primeira opção vazia para "Não vincular a nenhuma atividade/recurso"
    $response['resources'][] = [
        'value' => '',
        'name' => 'Não vincular a nenhuma atividade/recurso'
    ];

    // Itera pelos módulos da seção
    foreach ($section_modules as $cmid) {
        $mod = $modinfo->cms[$cmid];
        
        // Verifica se o módulo está visível
        if ($mod->uservisible) {
            $response['resources'][] = [
                'value' => $cmid,
                'name' => $mod->name
            ];
        }
    }
} catch (Exception $e) {
    // Se ocorrer um erro, adiciona a mensagem como um recurso
    $response['resources'][] = [
        'value' => '',
        'name' => $e->getMessage()
    ];
}

// Retorna a resposta como JSON
echo json_encode($response);
exit;
