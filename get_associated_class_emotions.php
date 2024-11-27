<?php
require_once('../../config.php');
require_once('collection_manager.php'); 

require_login();

$coleta_id = required_param('coleta_id', PARAM_INT);

try {
    $manager = new collection_manager();
    $emocoes_classes = $manager->obter_emocoes_e_classes($coleta_id);

    if (empty($emocoes_classes)) {
        echo '<p>Nenhuma emoção cadastrada para esta coleta.</p>';
        exit;
    }

    $output = '';
    foreach ($emocoes_classes as $item) {
        $output .= '<p><strong>' . s($item->nome_classe) . ':</strong> ' . s($item->emocoes) . '</p>';
    }

    echo $output;
} catch (Exception $e) {
    echo '<p>Erro ao carregar emoções e classes AEQ: ' . s($e->getMessage()) . '</p>';
}

exit;
