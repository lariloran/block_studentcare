<?php
require_once('../../config.php');
require_login();

$courseid = required_param('courseid', PARAM_INT);
$sectionnum = required_param('sectionid', PARAM_INT);

$response = ['resources' => []]; 

try {
    $modinfo = get_fast_modinfo($courseid);

    if (!isset($modinfo->get_sections()[$sectionnum])) {
        throw new Exception("Não há atividade/recurso nesta seção.");
    }

    $section_modules = $modinfo->get_sections()[$sectionnum];

    $default_option = [
        'value' => '',
        'name' => get_string('dontlink', 'block_studentcare')
    ];
    $response['resources'][] = $default_option;

    $resources = []; 
    foreach ($section_modules as $cmid) {
        $mod = $modinfo->cms[$cmid];
        
        if ($mod->uservisible) {
            $resources[] = [
                'value' => $cmid,
                'name' => $mod->name
            ];
        }
    }

    usort($resources, function ($a, $b) {
        return strcmp($a['name'], $b['name']);
    });

    $response['resources'] = array_merge([$default_option], $resources);
} catch (Exception $e) {
    $response['resources'][] = [
        'value' => '',
        'name' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;
