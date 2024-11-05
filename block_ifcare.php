<?php
class block_ifcare extends block_base {

public function init() {
    $this->title = get_string('pluginname', 'block_ifcare');
}

public function get_content() {
    global $OUTPUT, $USER, $COURSE, $DB, $PAGE;

    if ($this->content !== null) {
        return $this->content;
    }

    $this->content = new stdClass();
    $this->content->footer = '';

    // URL para o índice do plugin (para gerenciamento das coletas pelo professor)
    $url_index = new moodle_url('/blocks/ifcare/index.php', ['courseid' => $COURSE->id]);

    // URL para o manual AEQ
    $url_manual_aeq = new moodle_url('/blocks/ifcare/manual_aeq.php', ['courseid' => $COURSE->id]);

    // Exibe os links para gerenciar as coletas e para visualizar o manual AEQ
    $this->content->text = html_writer::link($url_index, get_string('manage_collections', 'block_ifcare')) . '<br>' .
                           html_writer::link($url_index, get_string('view_dashboard', 'block_ifcare')) . '<br>' .
                           html_writer::link($url_manual_aeq, get_string('aeq_manual', 'block_ifcare'));

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
