<?php

function xmldb_block_ifcare_install() {
    // A instalação pode configurar outras coisas, mas a configuração de notificações
    // será feita pela tarefa agendada.
    return true;
}
