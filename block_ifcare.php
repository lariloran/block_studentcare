<?php
class block_ifcare extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_ifcare');
    }

    public function get_content() {
        global $OUTPUT, $USER, $COURSE, $DB, $PAGE;

        $PAGE->requires->js_call_amd('block_ifcare/block_ifcare', 'init');

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        // URL para o índice do plugin (para gerenciamento das coletas pelo professor)
        $url = new moodle_url('/blocks/ifcare/index.php', ['courseid' => $COURSE->id]);

        // Exibe o link para gerenciar as coletas (disponível para professores e administradores)
       // if (has_capability('moodle/course:manageactivities', context_course::instance($COURSE->id))) {
            $this->content->text = html_writer::link($url, get_string('manage_collections', 'block_ifcare')) . '<br>' .
            html_writer::link($url, get_string('view_dashboard', 'block_ifcare')) . '<br>' .
            html_writer::link($url, get_string('aeq_manual', 'block_ifcare'));
        //}

        // Carregar o arquivo JavaScript AMD para exibir o modal, se necessário
        // Isso vai carregar o arquivo block_ifcare.js quando o bloco for exibido

        return $this->content;
    }

    public function applicable_formats() {
        return [
            'course-view' => false,
            'mod' => false,
            'site-index' => false,
            'admin' => false,
            'my' => true,
        ];
    }
}
