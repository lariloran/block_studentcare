<?php
require_once('../../config.php');
require_login();

$courseid = required_param('courseid', PARAM_INT);

$modinfo = get_fast_modinfo($courseid);
$sections = $modinfo->get_section_info_all(); // Obter todas as seções
$response = ['sections' => []]; // Inicialize como array para armazenar as seções

foreach ($sections as $section) {
    if ($section->uservisible) {
        $sectionname = get_section_name($courseid, $section->section);
        // Adicione cada seção como um objeto no array de resposta
        $response['sections'][] = [
            'value' => $section->section,
            'name' => $sectionname
        ];
    }
}

echo json_encode($response);
exit;
