<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * the first page to view the studentcare
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_studentcare extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_studentcare');
    }

    public function get_content() {
        global $USER, $DB, $COURSE;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->footer = '';

        $user_courses = enrol_get_users_courses($USER->id);

        $has_teacher_or_admin_role = false;

        foreach ($user_courses as $course) {
            $course_context = context_course::instance($course->id);
            if (has_capability('moodle/course:update', $course_context, $USER->id)) {
                $has_teacher_or_admin_role = true;
                break;
            }
        }

        if ($has_teacher_or_admin_role) {
            $this->content->text = html_writer::link(new moodle_url('/blocks/studentcare/index.php'), get_string('manage_collections', 'block_studentcare')) . '<br>' .
                html_writer::link(new moodle_url('/blocks/studentcare/report.php'), get_string('view_dashboard', 'block_studentcare')) . '<br>' .
                html_writer::link(new moodle_url('/blocks/studentcare/manual_aeq.php'), get_string('manual_aeq', 'block_studentcare')) . '<br>' .
                html_writer::link(new moodle_url('/blocks/studentcare/faq.php'), get_string('faq', 'block_studentcare'));
        } else {
            $this->content->text = get_string('welcome', 'block_studentcare');
        }

        return $this->content;
    }

    public function applicable_formats() {
        return [
            'my' => true,
            'site-index' => false,
            'course-view' => true,
            'mod' => false,
            'admin' => false,
        ];
    }
}
?>