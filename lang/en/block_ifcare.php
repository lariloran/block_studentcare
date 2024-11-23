<?php

$string['pluginname'] = 'IFCare';
$string['header'] = 'IFCare 🤖📚🎭';

// Strings para o formulário de coleta
$string['create_new_collection'] = 'Cadastrar Nova Coleta';
$string['name'] = 'Nome da coleta';
$string['description'] = 'Descrição';
$string['starttime'] = 'Data e Hora de Início da coleta';
$string['endtime'] = 'Data e Hora de Fim da coleta';
$string['aeqclasses'] = 'Selecione uma classe do AEQ';
$string['emotions'] = 'Selecione uma ou mais emoções';
$string['select_course'] = 'Selecione o curso';
$string['select_section'] = 'Selecione uma seção';
$string['select_resource'] = 'Selecione um recurso ou atividade';
$string['alertprogress'] = 'Receber alerta do andamento da coleta';
$string['notify_students'] = 'Notificar os alunos';
$string['submit'] = 'Salvar';
$string['update'] = 'Atualizar';

// Mensagens de validação e erro
$string['endtimeerror'] = 'A hora de término deve ser posterior à hora de início.';
$string['mensagem_sucesso'] = 'Cadastro realizado com sucesso!';
$string['mensagem_erro'] = 'Erro ao realizar o cadastro. Tente novamente.';
$string['starttime_past_error'] = 'A data de início não pode estar no passado.';
$string['endtime_before_start_error'] = 'A data de fim deve ser posterior à data de início.';
$string['coleta_atualizada_com_sucesso'] = 'A coleta foi atualizada com sucesso.';
$string['erro_ao_atualizar_coleta'] = 'Erro ao atualizar os dados da coleta.';
$string['erro_ao_atualizar_emocoes'] = 'Erro ao atualizar as emoções associadas.';
$string['coleta_atualizada_com_sucesso'] = 'A coleta foi atualizada com sucesso.';

$string['editcoleta'] = 'Editar Coleta';
$string['editcoleta_subtitle'] = 'Edição da coleta: {$a}';

$string['coleta_limitada_aviso'] = 'A coleta foi iniciada em {$a->datainicio}. Algumas alterações estão limitadas. Para mais detalhes, retorne à <a href="{$a->listagemurl}">listagem de coletas</a>.';
$string['coleta_atualizada_com_sucesso'] = 'A coleta foi atualizada com sucesso.';
$string['returntolist'] = 'Voltar para a listagem';


// Strings de gerenciamento e navegação
$string['manage_collections'] = 'Gerenciar Coletas';
$string['view_dashboard'] = 'Visualizar Dashboard das Coletas';
$string['aeq_manual'] = 'Conheça o AEQ e o IFCare';
$string['aeq_manual_title'] = 'Achievement Emotions Questionnaire (AEQ) Manual';
$string['process_collection'] = 'Processar Coleta';

$string['messageprovider:created_collection'] = 'Notificação enviada aos alunos quando uma nova coleta é criada.';
$string['ifcare:addinstance'] = 'Adicionar uma nova instância do bloco IFCare';
$string['ifcare:myaddinstance'] = 'Adicionar uma nova instância do bloco IFCare ao painel';
$string['ifcare:receivenotifications'] = 'Receber notificações sobre coletas criadas no IFCare';
$string['ifcare:managecollections'] = 'Gerenciar o bloco IFCare';

// Mensagem de boas-vindas
$string['welcome'] = 'Bem-vindos ao IFCare!';

?>
