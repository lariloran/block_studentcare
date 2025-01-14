<?php
/**
 * Upgrade script for the studentcare plugin.
 *
 * @package    block_studentcare
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute block_studentcare upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_block_studentcare_upgrade($oldversion)
{
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion <= 2024112703) {
        $DB->execute("UPDATE {studentcare_emocao} SET nome = 'Alegria' WHERE nome = 'Prazer'");

        // Atualizar o savepoint para 2024112703.
        upgrade_block_savepoint(true, 2024112703, 'studentcare');
    }

    return true;
}
