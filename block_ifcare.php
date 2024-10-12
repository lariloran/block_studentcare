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
 * Block definition class for the block_pluginname plugin.
 *
 * @package   block_pluginname
 * @copyright Year, You Name <your@email.address>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_ifcare extends block_base {

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_ifcare');
    }    

    /**
     * Gets the block contents.
     *
     * @return string The block HTML.
     */
    public function get_content() {
        global $OUTPUT;
        global $USER;
        global $COURSE;
    
        if ($this->content !== null) {
            return $this->content;
        }
    
        $this->content = new stdClass();
        $this->content->footer = '';
    
        // URL para o índice do plugin
        $url = new moodle_url('/blocks/ifcare/index.php', ['courseid' => $COURSE->id]); 
    
        // Texto do link
        $this->content->text = html_writer::link($url, get_string('manage_collections', 'block_ifcare')); 
    
        return $this->content;
    }
    

    /**
     * Defines in which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats() {
        return [
            'course-view' => false, // Permite em páginas de visualização de cursos
            'mod' => false,        // Não permite em módulos
            'site-index' => false, // Não permite no índice do site
            'admin' => false,      // Não permite em páginas de administração
            'my' => true,         // Não permite na página "Meu Moodle"
        ];
    }
    
}