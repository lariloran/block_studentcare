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

    if ($oldversion < 2024112700) {

        $table = new xmldb_table('ifcare_cadastrocoleta');

        if (!$dbman->table_exists($table)) {
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('nome', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
            $table->add_field('data_inicio', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, null);
            $table->add_field('data_fim', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, null);
            $table->add_field('descricao', XMLDB_TYPE_TEXT, null, null, null, null, null);
            $table->add_field('receber_alerta', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
            $table->add_field('notificar_alunos', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
            $table->add_field('curso_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('usuario_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0');
            $table->add_field('section_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0');
            $table->add_field('resource_id_atrelado', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0');
            $table->add_field('resource_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0');
            $table->add_field('data_criacao', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP');
            $table->add_field('notificacao_enviada', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('notificacao_finalizada', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');

            $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
            $table->add_key('curso_fk', XMLDB_KEY_FOREIGN, ['curso_id'], 'ifcare_curso', ['id']);
            $table->add_key('usuario_fk', XMLDB_KEY_FOREIGN, ['usuario_id'], 'user', ['id']);
            $table->add_key('section_fk', XMLDB_KEY_FOREIGN, ['section_id'], 'course_sections', ['id']);
            $table->add_key('resource_fk', XMLDB_KEY_FOREIGN, ['resource_id'], 'course_modules', ['id']);

            $dbman->create_table($table);
        } else {
            $fields = [
                new xmldb_field('nome', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null),
                new xmldb_field('data_inicio', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, null),
                new xmldb_field('data_fim', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, null),
                new xmldb_field('descricao', XMLDB_TYPE_TEXT, null, null, null, null, null),
                new xmldb_field('receber_alerta', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null),
                new xmldb_field('notificar_alunos', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null),
                new xmldb_field('curso_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('usuario_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0'),
                new xmldb_field('section_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0'),
                new xmldb_field('resource_id_atrelado', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0'),
                new xmldb_field('resource_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '0'),
                new xmldb_field('data_criacao', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP'),
                new xmldb_field('notificacao_enviada', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0'),
                new xmldb_field('notificacao_finalizada', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0'),
            ];

            foreach ($fields as $field) {
                if (!$dbman->field_exists($table, $field)) {
                    $dbman->add_field($table, $field);
                }
            }

            $index_to_remove = new xmldb_index('mdl_ifcacada_pro_ix', XMLDB_INDEX_NOTUNIQUE, ['professor_id']);
            if ($dbman->index_exists($table, $index_to_remove)) {
                $dbman->drop_index($table, $index_to_remove);
            }

            $field_to_remove = new xmldb_field('professor_id');
            if ($dbman->field_exists($table, $field_to_remove)) {
                $dbman->drop_field($table, $field_to_remove);
            }
        }

        $table = new xmldb_table('ifcare_classeaeq');

        if (!$dbman->table_exists($table)) {
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('nome_classe', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);

            $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

            $dbman->create_table($table);
        } else {
            $fields = [
                new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null),
                new xmldb_field('nome_classe', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null),
            ];

            foreach ($fields as $field) {
                if (!$dbman->field_exists($table, $field)) {
                    $dbman->add_field($table, $field);
                }
            }
        }


        $table = new xmldb_table('ifcare_emocao');

        if (!$dbman->table_exists($table)) {
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('classeaeq_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('nome', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
            $table->add_field('txttooltip', XMLDB_TYPE_TEXT, null, null, null, null, null);
            $table->add_field('antes', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
            $table->add_field('durante', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
            $table->add_field('depois', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
            $table->add_field('data_criacao', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP');

            $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
            $table->add_key('classeaeq_fk', XMLDB_KEY_FOREIGN, ['classeaeq_id'], 'ifcare_classeaeq', ['id']);

            $dbman->create_table($table);
        } else {
            $fields = [
                new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null),
                new xmldb_field('classeaeq_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('nome', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null),
                new xmldb_field('txttooltip', XMLDB_TYPE_TEXT, null, null, null, null, null),
                new xmldb_field('antes', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null),
                new xmldb_field('durante', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null),
                new xmldb_field('depois', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null),
                new xmldb_field('data_criacao', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP'),
            ];

            foreach ($fields as $field) {
                if (!$dbman->field_exists($table, $field)) {
                    $dbman->add_field($table, $field);
                }
            }
        }


        $table = new xmldb_table('ifcare_pergunta');

        if (!$dbman->table_exists($table)) {
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('emocao_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('classeaeq_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('pergunta_texto', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
            $table->add_field('data_criacao', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP');

            $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
            $table->add_key('emocao_fk', XMLDB_KEY_FOREIGN, ['emocao_id'], 'ifcare_emocao', ['id']);
            $table->add_key('classeaeq_fk', XMLDB_KEY_FOREIGN, ['classeaeq_id'], 'ifcare_classeaeq', ['id']);

            $dbman->create_table($table);
        } else {
            $fields = [
                new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null),
                new xmldb_field('emocao_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('classeaeq_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('pergunta_texto', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null),
                new xmldb_field('data_criacao', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP'),
            ];

            foreach ($fields as $field) {
                if (!$dbman->field_exists($table, $field)) {
                    $dbman->add_field($table, $field);
                }
            }
        }


        $table = new xmldb_table('ifcare_resposta');

        if (!$dbman->table_exists($table)) {
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('pergunta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('usuario_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('coleta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('resposta', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
            $table->add_field('data_resposta', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, null);

            $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
            $table->add_key('pergunta_fk', XMLDB_KEY_FOREIGN, ['pergunta_id'], 'ifcare_pergunta', ['id']);
            $table->add_key('coleta_fk', XMLDB_KEY_FOREIGN, ['coleta_id'], 'ifcare_cadastrocoleta', ['id']);

            $dbman->create_table($table);
        } else {
            $fields = [
                new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null),
                new xmldb_field('pergunta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('usuario_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('coleta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('resposta', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null),
                new xmldb_field('data_resposta', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, null),
            ];

            foreach ($fields as $field) {
                if (!$dbman->field_exists($table, $field)) {
                    $dbman->add_field($table, $field);
                }
            }
        }


        $table = new xmldb_table('ifcare_associacao_classe_emocao_coleta');

        if (!$dbman->table_exists($table)) {
            // Definir os campos da tabela.
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('cadastrocoleta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('classeaeq_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('emocao_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('data_criacao', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP');

            $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
            $table->add_key('cadastrocoleta_fk', XMLDB_KEY_FOREIGN, ['cadastrocoleta_id'], 'ifcare_cadastrocoleta', ['id']);
            $table->add_key('classeaeq_fk', XMLDB_KEY_FOREIGN, ['classeaeq_id'], 'ifcare_classeaeq', ['id']);
            $table->add_key('emocao_fk', XMLDB_KEY_FOREIGN, ['emocao_id'], 'ifcare_emocao', ['id']);

            $dbman->create_table($table);
        } else {
            $fields = [
                new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null),
                new xmldb_field('cadastrocoleta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('classeaeq_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('emocao_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('data_criacao', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP'),
            ];

            foreach ($fields as $field) {
                if (!$dbman->field_exists($table, $field)) {
                    $dbman->add_field($table, $field);
                }
            }
        }


        $table = new xmldb_table('ifcare_tcle_resposta');

        if (!$dbman->table_exists($table)) {
            // Definir os campos da tabela.
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('usuario_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('coleta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('tcle_aceito', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
            $table->add_field('data_resposta', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP');
            $table->add_field('curso_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);

            $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
            $table->add_key('coleta_fk', XMLDB_KEY_FOREIGN, ['coleta_id'], 'ifcare_cadastrocoleta', ['id']);
            $table->add_key('curso_fk', XMLDB_KEY_FOREIGN, ['curso_id'], 'course', ['id']);

            $dbman->create_table($table);
        } else {
            $fields = [
                new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null),
                new xmldb_field('usuario_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('coleta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('tcle_aceito', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0'),
                new xmldb_field('data_resposta', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP'),
                new xmldb_field('curso_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
            ];

            foreach ($fields as $field) {
                if (!$dbman->field_exists($table, $field)) {
                    $dbman->add_field($table, $field);
                }
            }
        }

        $table = new xmldb_table('ifcare_feedback');

        if (!$dbman->table_exists($table)) {
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('coleta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('usuario_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
            $table->add_field('feedback', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
            $table->add_field('data_feedback', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP');

            $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
            $table->add_key('coleta_fk', XMLDB_KEY_FOREIGN, ['coleta_id'], 'ifcare_cadastrocoleta', ['id']);
            $table->add_key('usuario_fk', XMLDB_KEY_FOREIGN, ['usuario_id'], 'user', ['id']);

            $dbman->create_table($table);
        } else {
            $fields = [
                new xmldb_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null),
                new xmldb_field('coleta_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('usuario_id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null),
                new xmldb_field('feedback', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null),
                new xmldb_field('data_feedback', XMLDB_TYPE_DATETIME, null, null, XMLDB_NOTNULL, null, 'CURRENT_TIMESTAMP'),
            ];

            foreach ($fields as $field) {
                if (!$dbman->field_exists($table, $field)) {
                    $dbman->add_field($table, $field);
                }
            }
        }

        // Atualizar o savepoint.
        upgrade_block_savepoint(true, 2024112700, 'ifcare');
    }

    return true;
}
