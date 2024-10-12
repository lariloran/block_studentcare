<?php
// // Verifique se a tag de abertura PHP está presente.

// defined('MOODLE_INTERNAL') || die(); // Certifique-se de que esta linha está presente no início do arquivo.

// function block_ifcare_extend_navigation_course($navigation, $course, $context)
// {
//     if ($context->contextlevel == CONTEXT_COURSE) {
//         $node = $navigation->add(
//             get_string('pluginname', 'block_ifcare'),
//             new moodle_url('/blocks/ifcare/index.php', array('courseid' => $course->id)),
//             navigation_node::TYPE_CUSTOM,
//             null,
//             null,
//             new pix_icon('i/gear', '')
//         );
//     }
// }
defined('MOODLE_INTERNAL') || die();

function block_ifcare_extend_navigation(global_navigation $nav) {
    global $COURSE; // Carregar a variável global do curso atual
    $url = new moodle_url('/blocks/ifcare/index.php', array('courseid' => $COURSE->id)); // Adicionar o courseid à URL

    // Adiciona ao menu se o usuário estiver logado e não for um convidado
    if (isloggedin() && !isguestuser()) {
        $nav->add('Ifcare', $url, navigation_node::TYPE_BRANCH);
    }
}
