<?php
class block_ifcare extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_ifcare');
    }

    public function get_content()
    {
        global $OUTPUT, $USER, $COURSE, $DB, $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }

        // Define o contexto: sistema para o painel ou curso para contextos de curso
        $context = ($COURSE->id == SITEID) ? context_system::instance() : context_course::instance($COURSE->id);

        // Verifica a capacidade no contexto determinado
        if (!has_capability('block/ifcare:view', $context)) {
            return null;
        }

        $this->content = new stdClass;
        $this->content->footer = '';

        // URLs para navegação dentro do bloco
        $url_index = new moodle_url('/blocks/ifcare/index.php', ['courseid' => $COURSE->id]);
        $url_manual_aeq = new moodle_url('/blocks/ifcare/manual_aeq.php', ['courseid' => $COURSE->id]);

        // Exibe links somente para professores e administradores
        if (has_capability('block/ifcare:managecollections', $context)) {
            $this->content->text = html_writer::link($url_index, get_string('manage_collections', 'block_ifcare')) . '<br>' .
                html_writer::link($url_index, get_string('view_dashboard', 'block_ifcare')) . '<br>' .
                html_writer::link($url_manual_aeq, get_string('aeq_manual', 'block_ifcare'));
        } else {
            // Mensagem de boas-vindas para usuários sem permissões de gerenciamento
            $this->content->text = get_string('student_message', 'block_ifcare');
        }

        return $this->content;
    }
}
?>
