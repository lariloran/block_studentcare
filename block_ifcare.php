<?php
class block_ifcare extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_ifcare');
    }

    public function get_content()
    {
        global $USER, $DB, $COURSE;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->footer = '';

        $url_index = new moodle_url('/blocks/ifcare/index.php', ['courseid' => $COURSE->id]);
        $url_manual_aeq = new moodle_url('/blocks/ifcare/manual_aeq.php', ['courseid' => $COURSE->id]);

        // Obtém todos os cursos em que o usuário está inscrito
        $user_courses = enrol_get_users_courses($USER->id);

        $has_teacher_or_admin_role = false;

        // Verifica se o usuário tem capacidade de gerenciamento em algum curso
        foreach ($user_courses as $course) {
            $course_context = context_course::instance($course->id);
            if (has_capability('moodle/course:update', $course_context, $USER->id)) {
                $has_teacher_or_admin_role = true;
                break;
            }
        }

        if ($has_teacher_or_admin_role) {
            // O usuário tem permissão de gerenciar cursos (portanto, é professor/admin em algum curso)
            $this->content->text = html_writer::link($url_index, get_string('manage_collections', 'block_ifcare')) . '<br>' .
                html_writer::link($url_index, get_string('view_dashboard', 'block_ifcare')) . '<br>' .
                html_writer::link($url_manual_aeq, get_string('aeq_manual', 'block_ifcare'));
        } else {
            $this->content->text = get_string('student_message', 'block_ifcare');
        }

        return $this->content;
    }

    public function applicable_formats()
    {
        return [
            'my' => true,            // Disponível no painel do usuário
            'site-index' => false,   // Não disponível na página inicial do site
            'course-view' => true,  // Não disponível na visualização de cursos
            'mod' => false,          // Não disponível em módulos individuais
            'admin' => false,        // Não disponível na administração do site
        ];
    }
}
?>
