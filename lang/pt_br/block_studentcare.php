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

$string['class-related-enjoyment-1'] ='Estar na aula dessa disciplina me deixa muito animado.';
$string['class-related-enjoyment-2'] = 'Gosto de estar nesta aula.';
$string['class-related-enjoyment-3'] = 'Depois dessa aula, começo a ansiar pela próxima aula.';
$string['class-related-enjoyment-4'] = 'Estou ansioso(a) para aprender muito nesta aula.';
$string['class-related-enjoyment-5'] = 'Estou feliz por ter entendido o conteúdo da disciplina.';
$string['class-related-enjoyment-6'] = 'Fico contente que valeu a pena ir à aula.';
$string['class-related-enjoyment-7'] = 'Estou motivado(a) para ir a esta aula porque é empolgante.';
$string['class-related-enjoyment-8'] = 'Minha alegria nesta aula me faz querer participar.';
$string['class-related-enjoyment-9'] = 'É tão empolgante a aula que eu poderia ficar por horas ouvindo o professor.';
$string['class-related-enjoyment-10'] = 'Eu Gosto tanto de participar que fico energizado(a).';

$string['class-related-hope-1'] = 'Eu me Estou confiante quando vou à aula.';
$string['class-related-hope-2'] ='Estou cheio(a) de esperança.';
$string['class-related-hope-3'] = 'Estou otimista de que conseguirei acompanhar o conteúdo.';
$string['class-related-hope-4'] = 'Estou esperançoso(a) de que farei boas contribuições na aula.';
$string['class-related-hope-5'] = 'Estou confiante porque entendo o conteúdo.';
$string['class-related-hope-6'] = 'Estar confiante de que entenderei o conteúdo me motiva.';
$string['class-related-hope-7'] ='Minha confiança me motiva a me preparar para a aula.';
$string['class-related-hope-8'] ='Minhas esperanças de que terei sucesso me motivam a investir muito esforço.';

$string['class-related-pride-1'] = 'Tenho orgulho de mim mesmo(a).';
$string['class-related-pride-2'] = 'Tenho orgulho de conseguir acompanhar o conteúdo.';
$string['class-related-pride-3'] = 'Tenho orgulho de fazer melhor do que os outros neste curso.';
$string['class-related-pride-4'] = 'Acho que posso ter orgulho do que sei sobre este assunto.';
$string['class-related-pride-5'] = 'Estou orgulhoso(a) das contribuições que fiz na aula.';
$string['class-related-pride-6'] = 'Quando faço boas contribuições na aula, fico ainda mais motivado(a).';
$string['class-related-pride-7'] = 'Por ser orgulhoso das minhas conquistas neste curso, estou motivado(a) a continuar.';
$string['class-related-pride-8'] = 'Gostaria de contar aos meus amigos sobre como me saí bem neste curso.';
$string['class-related-pride-9'] = 'Quando vou bem na aula, meu coração se enche de orgulho.';

$string['class-related-anger-1'] = 'Sinto-me frustrado(a) na aula.';
$string['class-related-anger-2'] = 'Me sinto com raiva.';
$string['class-related-anger-3'] = 'Pensar na baixa qualidade do curso me deixa irritado(a).';
$string['class-related-anger-4'] = 'Pensar em todas as coisas inúteis que tenho que aprender me irrita.';
$string['class-related-anger-5'] = 'Quando penso no tempo que perco na aula, fico agitado(a).';
$string['class-related-anger-6'] = 'Eu gostaria de não ter que ir à aula porque isso me deixa com raiva.';
$string['class-related-anger-7'] = 'Eu gostaria de poder dizer aos professores o que penso.';
$string['class-related-anger-8'] = 'Sinto a raiva crescendo dentro de mim.';
$string['class-related-anger-9'] = 'Por estar com raiva, fico inquieto(a) na aula.';

$string['class-related-anxiety-1'] = 'Pensar na aula me deixa inquieto(a).';
$string['class-related-anxiety-2'] = 'Sinto medo.';
$string['class-related-anxiety-3'] = 'Sinto-me nervoso(a) na aula.';
$string['class-related-anxiety-4'] = 'Mesmo antes da aula, me preocupo se conseguirei entender o conteúdo.';
$string['class-related-anxiety-5'] = 'Me preocupo se estou suficientemente preparado(a) para a aula.';
$string['class-related-anxiety-6'] = 'Me preocupo se as exigências podem ser grandes demais.';
$string['class-related-anxiety-7'] = 'Me preocupo que os outros entenderão o conteúdo mais do que eu.';
$string['class-related-anxiety-8'] = 'Por estar nervoso(a), prefiro pular a aula.';
$string['class-related-anxiety-9'] = 'Tenho medo de que possa dizer algo errado, então prefiro não dizer nada.';
$string['class-related-anxiety-10'] = 'Quando penso na aula, fico enjoado(a).';
$string['class-related-anxiety-11'] = 'Fico tenso(a) na aula.';
$string['class-related-anxiety-12'] = 'Quando não entendo algo importante na aula, meu coração acelera.';

$string['class-related-shame-1'] ='Fico envergonhado(a).';
$string['class-related-shame-2'] ='Me sinto envergonhado(a).';
$string['class-related-shame-3'] ='Se os outros soubessem que não entendo o conteúdo, ficaria envergonhado(a).';
$string['class-related-shame-4'] ='Quando falo algo na aula, sinto que estou me colocando em uma posição ridícula.';
$string['class-related-shame-5'] ='Estou envergonhado(a) por não conseguir me expressar bem.';
$string['class-related-shame-6'] ='Estou envergonhado(a) porque os outros entenderam mais da aula do que eu.';
$string['class-related-shame-7'] ='Depois que digo algo na aula, gostaria de poder me esconder.';
$string['class-related-shame-8'] ='Preferiria não contar a ninguém quando não entendo algo na aula.';
$string['class-related-shame-9'] ='Quando digo algo na aula, sinto que fico vermelho(a).';
$string['class-related-shame-10'] ='Porque fico envergonhado(a), fico tenso(a) e inibido(a).';
$string['class-related-shame-11'] ='Quando falo na aula, começo a gaguejar.';

$string['class-related-hopelessness-1'] =  'Só de pensar nessa aula, sinto-me sem esperanças.';
$string['class-related-hopelessness-2'] =  'Sinto-me desamparado(a).';
$string['class-related-hopelessness-3'] =  'Antes mesmo de a aula começar, já me conformo com o fato de que não vou entender o conteúdo.';
$string['class-related-hopelessness-4'] =  'Já perdi qualquer esperança de compreender esta aula';
$string['class-related-hopelessness-5'] =  'Sinto-me desamparado ao continuar neste curso.';
$string['class-related-hopelessness-6'] =  'Porque desisti, não tenho energia para ir à aula.';
$string['class-related-hopelessness-7'] =  'Preferiria não ir à aula, pois não há esperança de entender o material de qualquer forma.';
$string['class-related-hopelessness-8'] =  'É inútil me preparar para a aula, já que não entendo o material de qualquer forma.';
$string['class-related-hopelessness-9'] =  'Porque não entendo o material, pareço desconectado(a) e resignado(a).';
$string['class-related-hopelessness-10'] =  'Sinto-me tão desamparado(a) que toda a minha energia se esgota.';

$string['class-related-boredom-1'] = 'Fico entediado(a).';
$string['class-related-boredom-2'] = 'Acho esta aula bastante maçante.';
$string['class-related-boredom-3'] = 'A palestra me entedia.';
$string['class-related-boredom-4'] = 'Porque fico entediado(a), minha mente começa a vagar.';
$string['class-related-boredom-5'] = 'Estou tentado(a) a sair da palestra porque é tão chata.';
$string['class-related-boredom-6'] = 'Penso em outras coisas que poderia estar fazendo em vez de estar sentado(a) nesta aula chata.';
$string['class-related-boredom-7'] = 'Como o tempo se arrasta, olho frequentemente para o meu relógio.';
$string['class-related-boredom-8'] = 'Fico tão entediado(a) que tenho problemas para ficar alerta.';
$string['class-related-boredom-9'] = 'Fico inquieto(a) porque não posso esperar para que a aula termine.';
$string['class-related-boredom-10'] = 'Durante a aula, sinto que poderia afundar na minha cadeira.';
$string['class-related-boredom-11'] = 'Começo a bocejar na aula porque estou tão entediado(a).';

$string['learning-related-enjoyment-1'] = 'Estou ansioso para estudar.';
$string['learning-related-enjoyment-2'] = 'Eu gosto do desafio de aprender o material.';
$string['learning-related-enjoyment-3'] = 'Eu gosto de adquirir novos conhecimentos.';
$string['learning-related-enjoyment-4'] = 'Eu gosto de lidar com o material do curso.';
$string['learning-related-enjoyment-5'] = 'Refletir sobre meu progresso nos estudos me deixa feliz.';
$string['learning-related-enjoyment-6'] = 'Eu estudo mais do que o necessário porque gosto muito.';
$string['learning-related-enjoyment-7'] = 'Estou tão feliz com o progresso que fiz que estou motivado a continuar estudando.';
$string['learning-related-enjoyment-8'] = 'Certas matérias são tão agradáveis que estou motivado a fazer leituras adicionais sobre elas.';
$string['learning-related-enjoyment-9'] = 'Quando meus estudos vão bem, isso me dá uma empolgação.';
$string['learning-related-enjoyment-10'] = 'Fico fisicamente animado quando meus estudos vão bem.';

$string['learning-related-hope-1'] = 'Eu tenho uma visão otimista em relação ao estudo.';
$string['learning-related-hope-2'] = 'Eu me sinto confiante ao estudar.';
$string['learning-related-hope-3'] = 'Eu me sinto confiante de que serei capaz de dominar o material.';
$string['learning-related-hope-4'] = 'Sinto-me otimista de que farei bons progressos nos estudos.';
$string['learning-related-hope-5'] = 'O pensamento de alcançar meus objetivos de aprendizado me inspira.';
$string['learning-related-hope-6'] = 'Meu senso de confiança me motiva.';

$string['learning-related-pride-1'] = 'Estou orgulhoso de mim mesmo.';
$string['learning-related-pride-2'] = 'Estou orgulhoso da minha capacidade.';
$string['learning-related-pride-3'] = 'Acho que posso me orgulhar das minhas conquistas nos estudos.';
$string['learning-related-pride-4'] = 'Porque quero me orgulhar das minhas conquistas, estou muito motivado.';
$string['learning-related-pride-5'] = 'Quando resolvo um problema difícil nos meus estudos, meu coração bate de orgulho.';
$string['learning-related-pride-6'] = 'Quando me destaco no meu trabalho, fico cheio de orgulho.';

$string['learning-related-anger-1'] = 'Fico com raiva quando tenho que estudar.';
$string['learning-related-anger-2'] = 'Estudar me irrita.';
$string['learning-related-anger-3'] = 'Fico com raiva enquanto estudo.';
$string['learning-related-anger-4'] = 'Estou irritado por ter que estudar tanto.';
$string['learning-related-anger-5'] = 'Fico incomodado por ter que estudar.';
$string['learning-related-anger-6'] = 'Porque fico tão chateado com a quantidade de material, não quero nem começar a estudar.';
$string['learning-related-anger-7'] = 'Fico tão bravo que sinto vontade de jogar o livro didático pela janela.';
$string['learning-related-anger-8'] = 'Quando fico muito tempo sentado na minha mesa, minha irritação me deixa inquieto.';
$string['learning-related-anger-9'] = 'Depois de estudar por um longo período, fico tão irritado que fico tenso.';


$string['learning-related-anxiety-1'] = 'Quando olho para os livros que ainda tenho que ler, fico ansioso.';
$string['learning-related-anxiety-2'] = 'Fico tenso e nervoso enquanto estudo.';
$string['learning-related-anxiety-3'] = 'Quando não consigo acompanhar meus estudos, isso me deixa com medo.';
$string['learning-related-anxiety-4'] = 'Eu me preocupo se serei capaz de lidar com todo o meu trabalho.';
$string['learning-related-anxiety-5'] = 'O assunto me assusta, pois não o compreendo completamente.';
$string['learning-related-anxiety-6'] = 'Eu me preocupo se entendi o material corretamente.';
$string['learning-related-anxiety-7'] = 'Fico tão nervoso que nem quero começar a estudar.';
$string['learning-related-anxiety-8'] = 'Enquanto estudo, sinto vontade de me distrair para reduzir minha ansiedade.';
$string['learning-related-anxiety-9'] = 'Quando tenho que estudar, começo a me sentir enjoado.';
$string['learning-related-anxiety-10'] = 'À medida que o tempo acaba, meu coração começa a acelerar.';
$string['learning-related-anxiety-11'] = 'A preocupação em não completar o material me faz suar.';

$string['learning-related-shame-1'] = 'Eu me sinto envergonhado.';
$string['learning-related-shame-2'] = 'Eu me sinto envergonhado pela minha constante procrastinação.';
$string['learning-related-shame-3'] = 'Eu me sinto envergonhado por não conseguir absorver os detalhes mais simples.';
$string['learning-related-shame-4'] = 'Eu me sinto envergonhado porque não sou tão bom quanto os outros em estudar.';
$string['learning-related-shame-5'] = 'Eu me sinto envergonhado por não conseguir explicar completamente o material para os outros.';
$string['learning-related-shame-6'] = 'Eu me sinto envergonhado quando percebo que não tenho capacidade.';
$string['learning-related-shame-7'] = 'Minhas lacunas de memória me envergonham.';
$string['learning-related-shame-8'] = 'Porque tive tantas dificuldades com o material do curso, evito discutir sobre ele.';
$string['learning-related-shame-9'] = 'Eu não quero que ninguém saiba quando não consegui entender algo.';
$string['learning-related-shame-10'] = 'Quando alguém percebe o quanto eu pouco entendo, evito contato visual.';
$string['learning-related-shame-11'] = 'Eu fico vermelho quando não sei a resposta a uma pergunta relacionada ao material do curso.';

$string['learning-related-hopelessness-1'] = 'Eu me sinto sem esperança quando penso em estudar.';
$string['learning-related-hopelessness-2'] = 'Eu me sinto impotente.';
$string['learning-related-hopelessness-3'] = 'Eu me sinto resignado.';
$string['learning-related-hopelessness-4'] = 'Estou resignado ao fato de que não tenho capacidade para dominar este material.';
$string['learning-related-hopelessness-5'] = 'Depois de estudar, estou resignado ao fato de que não tenho habilidade.';
$string['learning-related-hopelessness-6'] = 'Estou desencorajado pela ideia de que nunca aprenderei o material.';
$string['learning-related-hopelessness-7'] = 'Eu me preocupo porque minhas habilidades não são suficientes para meu curso de estudos.';
$string['learning-related-hopelessness-8'] = 'Eu me sinto tão impotente que não consigo dar o meu máximo nos estudos.';
$string['learning-related-hopelessness-9'] = 'Eu gostaria de poder desistir porque não consigo lidar com isso.';
$string['learning-related-hopelessness-10'] = 'Minha falta de confiança me deixa exausto antes mesmo de começar.';
$string['learning-related-hopelessness-11'] = 'Minha desesperança minou toda a minha energia.';

$string['learning-related-boredom-1'] = 'O material me entedia até a morte.';
$string['learning-related-boredom-2'] = 'Estudar para meus cursos me entedia.';
$string['learning-related-boredom-3'] = 'Estudar é chato e monótono.';
$string['learning-related-boredom-4'] = 'Enquanto estudo este material chato, passo o tempo pensando em como o tempo não passa.';
$string['learning-related-boredom-5'] = 'O material é tão chato que me pego sonhando acordado.';
$string['learning-related-boredom-6'] = 'Eu percebo que minha mente divaga enquanto estudo.';
$string['learning-related-boredom-7'] = 'Porque estou entediado, não tenho desejo de aprender.';
$string['learning-related-boredom-8'] = 'Eu preferiria deixar este trabalho chato para amanhã.';
$string['learning-related-boredom-9'] = 'Porque estou entediado, fico cansado sentado na minha mesa.';
$string['learning-related-boredom-10'] = 'O material me entedia tanto que me sinto exausto.';
$string['learning-related-boredom-11'] = 'Enquanto estudo, pareço me distrair porque é tão chato.';

$string['test-related-enjoyment-1'] = 'Eu me sinto ansioso quando vou à aula.';
$string['test-related-enjoyment-2'] = 'Eu gosto de fazer a prova.';
$string['test-related-enjoyment-3'] = 'Estou ansioso para demonstrar meu conhecimento.';
$string['test-related-enjoyment-4'] = 'Fico feliz por conseguir lidar com o teste.';
$string['test-related-enjoyment-5'] = 'Para mim, o teste é um desafio que é agradável.';
$string['test-related-enjoyment-6'] = 'Porque gosto de me preparar para o teste, estou motivado a fazer mais do que é necessário.';
$string['test-related-enjoyment-7'] = 'Porque estou ansioso para ter sucesso, estudo muito.';
$string['test-related-enjoyment-8'] = 'Antes de fazer a prova, sinto uma sensação de expectativa.';
$string['test-related-enjoyment-9'] = 'Meu coração bate mais rápido de alegria.';
$string['test-related-enjoyment-10'] = 'Eu brilho de felicidade.';

$string['test-related-hope-1'] = 'Estou otimista de que tudo vai dar certo.';
$string['test-related-hope-2'] = 'Estou muito confiante.';
$string['test-related-hope-3'] = 'Tenho grande esperança de que minhas habilidades serão suficientes.';
$string['test-related-hope-4'] = 'Estou bastante confiante de que minha preparação é suficiente.';
$string['test-related-hope-5'] = 'Penso na minha prova de forma otimista.';
$string['test-related-hope-6'] = 'Começo a estudar para a prova com grande esperança e expectativa.';
$string['test-related-hope-7'] = 'Minha confiança me motiva a me preparar bem.';
$string['test-related-hope-8'] = 'Esperando ter sucesso, estou motivado a investir muito esforço.';

$string['test-related-pride-1'] ='Estou muito satisfeito comigo mesmo.';
$string['test-related-pride-2'] = 'Estou orgulhoso de mim mesmo.';
$string['test-related-pride-3'] = 'Acho que posso me orgulhar do meu conhecimento.';
$string['test-related-pride-4'] = 'Pensar sobre meu sucesso me faz sentir orgulho.';
$string['test-related-pride-5'] = 'Estou orgulhoso de quão bem eu lidei com a prova.';
$string['test-related-pride-6'] = 'Estou tão orgulhoso da minha preparação que quero começar a prova agora.';
$string['test-related-pride-7'] = 'O orgulho pelo meu conhecimento alimenta meus esforços em fazer a prova.';
$string['test-related-pride-8'] = 'Quando recebo os resultados do teste, meu coração bate com orgulho.';
$string['test-related-pride-9'] = 'Depois da prova, me sinto como se estivesse mais alto porque estou tão orgulhoso.';
$string['test-related-pride-10'] = 'Saio da prova com a aparência de um vencedor no meu rosto.';

$string['test-related-relief-1'] = 'Eu me sinto aliviado.';
$string['test-related-relief-2'] = 'Eu me sinto livre.';
$string['test-related-relief-3'] = 'Eu me sinto muito aliviado.';
$string['test-related-relief-4'] = 'A tensão no meu estômago está se dissipando.';
$string['test-related-relief-5'] = 'Finalmente posso respirar aliviado novamente.';
$string['test-related-relief-6'] = 'Posso finalmente rir novamente.';

$string['test-related-anger-1'] = 'Eu fico bravo.';
$string['test-related-anger-2'] = 'Eu estou bastante irritado.';
$string['test-related-anger-3'] = 'Eu fico bravo com a pressão de tempo que não deixa tempo suficiente para me preparar.';
$string['test-related-anger-4'] = 'Eu fico bravo com a quantidade de material que preciso saber.';
$string['test-related-anger-5'] = 'Eu acho as perguntas injustas.';
$string['test-related-anger-6'] = 'Fico bravo com os critérios de avaliação do professor.';
$string['test-related-anger-7'] = 'Eu gostaria de poder dizer isso ao professor.';
$string['test-related-anger-8'] = 'Eu gostaria de poder expressar minha raiva livremente.';
$string['test-related-anger-9'] = 'Minha raiva faz meu sangue ferver.';
$string['test-related-anger-10'] = 'Eu fico tão bravo que começo a sentir calor e ruborizar.';

$string['test-related-anxiety-1'] = 'Antes da prova, me sinto nervoso e inquieto.';
$string['test-related-anxiety-2'] = 'Estou muito nervoso.';
$string['test-related-anxiety-3'] = 'Eu me sinto em pânico ao escrever a prova.';
$string['test-related-anxiety-4'] = 'Eu me preocupo se estudei o suficiente.';
$string['test-related-anxiety-5'] = 'Eu me preocupo se a prova será muito difícil.';
$string['test-related-anxiety-6'] = 'Eu me preocupo se vou passar na prova.';
$string['test-related-anxiety-7'] = 'Fico tão nervoso que gostaria de poder pular a prova.';
$string['test-related-anxiety-8'] = 'Fico tão nervoso que não consigo esperar que a prova acabe.';
$string['test-related-anxiety-9'] = 'Estou tão ansioso que preferiria estar em qualquer outro lugar.';
$string['test-related-anxiety-10'] = 'Eu me sinto enjoado.';
$string['test-related-anxiety-11'] = 'No início do teste, meu coração começa a disparar.';
$string['test-related-anxiety-12'] = 'Minhas mãos ficam trêmulas.';

$string['test-related-shame-1'] =  'Eu me sinto humilhado.';
$string['test-related-shame-2'] =  'Eu me sinto envergonhado.';
$string['test-related-shame-3'] =  'Não consigo nem pensar em como seria embaraçoso falhar na prova.';
$string['test-related-shame-4'] =  'Eu me envergonho da minha má preparação.';
$string['test-related-shame-5'] =  'Fico envergonhado porque não consigo responder corretamente às perguntas.';
$string['test-related-shame-6'] =  'Minhas notas me envergonham.';
$string['test-related-shame-7'] =  'Fico tão envergonhado que quero correr e me esconder.';
$string['test-related-shame-8'] =  'Quando recebo uma nota ruim, prefiro não enfrentar meu professor novamente.';
$string['test-related-shame-9'] =  'Porque estou envergonhado, meu pulso acelera.';
$string['test-related-shame-10'] =  'Quando os outros descobrem sobre minhas notas ruins, começo a corar.';

$string['test-related-hopelessness-1'] = 'Eu fico deprimido porque sinto que não tenho muita esperança para a prova.';
$string['test-related-hopelessness-2'] = 'Eu me sinto sem esperança.';
$string['test-related-hopelessness-3'] = 'Eu perdi toda a esperança de que tenho a habilidade de me sair bem na prova.';
$string['test-related-hopelessness-4'] = 'Desisti de acreditar que posso responder as perguntas corretamente.';
$string['test-related-hopelessness-5'] = 'Começo a pensar que, não importa o quanto eu tente, não terei sucesso no teste.';
$string['test-related-hopelessness-6'] = 'Começo a perceber que as perguntas são muito difíceis para mim.';
$string['test-related-hopelessness-7'] = 'Sinto-me tão resignado quanto à prova que não consigo começar a fazer nada.';
$string['test-related-hopelessness-8'] = 'Preferiria não fazer a prova porque perdi toda a esperança.';
$string['test-related-hopelessness-9'] = 'Sinto que quero desistir.';
$string['test-related-hopelessness-10'] = 'Minha desesperança me rouba toda a minha energia.';
$string['test-related-hopelessness-11'] = 'Eu me sinto tão resignado que não tenho energia.';    

?>
