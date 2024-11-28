<?php
/**
 * Upgrade script for the ifcare plugin.
 *
 * @package    block_ifcare
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute block_ifcare upgrade from the given old version.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_block_ifcare_upgrade($oldversion)
{
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2024112703) {
        $DB->execute("UPDATE {ifcare_emocao} SET nome = 'Alegria' WHERE nome = 'Prazer'");

        // Atualizar o savepoint para 2024112703.
        upgrade_block_savepoint(true, 2024112703, 'ifcare');
    }

    return true;
}
