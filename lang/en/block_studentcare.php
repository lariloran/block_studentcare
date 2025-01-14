<?php

$string['pluginname'] = 'StudentCare';
$string['header'] = 'Gerenciar Coletas';
$string['report'] = 'Dashboard de Coletas';

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

$string['coleta_limitada_aviso'] = 'A coleta foi iniciada em {$a->datainicio}. Algumas alterações estão limitadas. Para mais detalhes desta coleta, retorne à <a href="{$a->listagemurl}">listagem</a>.';
$string['coleta_atualizada_com_sucesso'] = 'A coleta foi atualizada com sucesso.';
$string['returntolist'] = 'Voltar para a listagem';


// Strings de gerenciamento e navegação
$string['manage_collections'] = 'Gerenciar Coletas';
$string['view_dashboard'] = 'Dashboard de Coletas';
$string['manual_aeq'] = 'Manual do AEQ';
$string['faq'] = 'Perguntas Frequentes (FAQ)';
$string['process_collection'] = 'Processar Coleta';

$string['messageprovider:created_collection'] = 'Notificação enviada aos alunos quando uma nova coleta é criada.';
$string['studentcare:addinstance'] = 'Adicionar uma nova instância do bloco StudentCare';
$string['studentcare:myaddinstance'] = 'Adicionar uma nova instância do bloco StudentCare ao painel';
$string['studentcare:receivenotifications'] = 'Receber notificações sobre coletas criadas no StudentCare';
$string['studentcare:managecollections'] = 'Gerenciar o bloco StudentCare';

// Mensagem de boas-vindas
$string['welcome'] = 'Bem-vindos ao StudentCare!';

///Tooltips
$string['select_section_help'] = 'Escolha a seção onde deseja realizar a coleta de emoções. Cada seção representa um módulo ou semana do curso. Ao selecionar uma seção, será criado automaticamente um recurso do tipo <strong>URL</strong> na seção escolhida.';
$string['select_resource_help'] = 'Escolha o recurso ao qual deseja atrelar a coleta de emoções. Cada recurso representa uma atividade ou material dentro do curso. Ao selecionar o recurso, ele será vinculado automaticamente à coleta de emoções na seção correspondente.';
$string['aeqclasses_help'] = 'Escolha as classes AEQ que deseja utilizar na coleta de emoções. As classes AEQ representam diferentes categorias de emoções acadêmicas. Para entender mais sobre as classes do AEQ, consulte a seção <strong>Manual do AEQ</strong> no painel do bloco.';
$string['emotions_help'] = 'Escolha as emoções que deseja incluir na coleta. Cada emoção selecionada exibirá um conjunto diferente de perguntas relacionadas durante a coleta, permitindo uma análise detalhada das emoções acadêmicas. As emoções estão associadas às classes AEQ, que representam diferentes categorias de emoções acadêmicas. Para entender mais sobre as emoções e suas classificações, consulte as informações no <strong>Manual do AEQ</strong> disponível no painel do bloco.';
$string['alertprogress_help'] = 'Ative esta opção para enviar uma notificação quando a coleta for finalizada. Quando ativado, uma notificação por e-mail e um pop-up no Moodle serão enviadas informando que a coleta de emoções foi concluída.';
$string['notify_students_help'] = 'Ative esta opção para enviar uma notificação aos alunos quando uma nova coleta for criada. Quando ativado, os alunos receberão uma notificação por e-mail e um pop-up no Moodle informando sobre a criação da coleta de emoções.';
?>
