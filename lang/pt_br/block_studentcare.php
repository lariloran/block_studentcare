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
 * Index page
 *
 * @package block_studentcare
 * @copyright  2024 Rafael Rodrigues
 * @author Rafael Rodrigues
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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
$string['add-collection'] = 'Adicionar Nova Coleta';
$string['new_collection'] = 'Nova Coleta';

$string['search_label'] = 'Buscar';
$string['search_placeholder'] = 'Buscar por nome, disciplina, descrição, tipo de recurso...';
$string['order_by_label'] = 'Ordenar por';
$string['order_by_creation_date'] = 'Data de Criação';
$string['order_by_collection_name'] = 'Nome da Coleta';
$string['order_by_start_date'] = 'Data de Início';
$string['order_by_end_date'] = 'Data de Fim';
$string['order_by_course'] = 'Disciplina';
$string['ascending'] = 'Ascendente';
$string['descending'] = 'Descendente';
$string['show_label'] = 'Exibir';
$string['show_5_per_page'] = '5 por página';
$string['show_10_per_page'] = '10 por página';
$string['show_15_per_page'] = '15 por página';
$string['show_20_per_page'] = '20 por página';

$string['selection_summary'] = 'Resumo das Seleções';
$string['preview_coleta'] = 'Preview Coleta';
$string['link_coleta'] = 'Link da Coleta';
$string['disciplina'] = 'Disciplina';
$string['data_inicio'] = 'Data de Início';
$string['data_fim'] = 'Data de Fim';
$string['nome_secao_vinculada'] = 'Nome da Seção Vinculada';
$string['nome_atividade_recurso_vinculado'] = 'Nome da Atividade/Recurso Vinculado';
$string['notificar_aluno'] = 'Notificar Aluno';
$string['receber_alerta'] = 'Receber Alerta';
$string['descricao'] = 'Descrição';
$string['baixar_csv'] = 'Baixar CSV';
$string['baixar_json'] = 'Baixar JSON';
$string['editar'] = 'Editar';
$string['excluir'] = 'Excluir';
$string['graficos'] = 'Gráficos';

$string['course'] = 'Disciplina';
$string['start_date'] = 'Data de Início';
$string['end_date'] = 'Data de Fim';
$string['details'] = 'Detalhes';

$string['select_collection'] = 'Selecione uma Coleta';
$string['choose_option'] = '-- Escolha --';

$string['select_collection_alert'] = 'Por favor, selecione uma coleta antes de visualizar o gráfico.';

$string['strongly_disagree'] = 'Discordo Totalmente';
$string['disagree'] = 'Discordo';
$string['neutral'] = 'Neutro';
$string['agree'] = 'Concordo';
$string['strongly_agree'] = 'Concordo Totalmente';

$string['stacked_bar'] = 'Barras Empilhadas';
$string['stacked_bar_description'] = 'Exibe a distribuição de respostas por escala Likert.';
$string['view_chart'] = 'Visualizar Gráfico';

$string['collection_not_available'] =
        'Desculpe, esta coleta não está mais disponível. Entre em contato com o administrador ou professor para mais informações.';

$string['collection_already_answered'] = 'Coleta já Respondida';
$string['collection_already_answered_message'] = 'Você já respondeu a esta coleta de emoções. Obrigado pela sua participação!';
$string['return_to_course'] = 'Voltar para o curso';

$string['collection_not_started'] = 'A coleta ainda não começou.';
$string['collection_expired'] = 'O prazo para responder a esta coleta expirou em {datetime}.';
$string['date_format'] = '%d/%m/%Y %H:%M';

$string['no_questions_found'] =
        'Nenhuma pergunta foi encontrada para esta coleta. Entre em contato com o professor da disciplina de <strong>{$a}</strong> para mais informações.';

$string['tcle_title'] = 'Termo de Consentimento Livre e Esclarecido (TCLE)';
$string['tcle_description'] =
        'Sua participação nesta coleta de emoções para a disciplina <strong>{$a}</strong> é muito importante para nós. Ao responder, você autoriza o uso das suas respostas, que serão tratadas de forma confidencial e anônima, exclusivamente para fins acadêmicos e pedagógicos. As informações coletadas serão utilizadas em pesquisas que buscam aprimorar o ensino e a aprendizagem, promovendo um ambiente educacional mais acolhedor e eficaz. Somente o professor responsável terá acesso aos dados, resguardando sua privacidade. Agradecemos sua colaboração!';
$string['tcle_accept'] = 'Aceito';
$string['tcle_decline'] = 'Não Aceito';

$string['back'] = 'Voltar';
$string['need_emotional_help'] = 'Precisa de ajuda emocional?';
$string['next'] = 'Avançar';

$string['feedback_title'] = 'O que você achou desta coleta?';
$string['feedback_placeholder'] = 'Escreva seu feedback aqui...';
$string['feedback_submit'] = 'Enviar Feedback';

$string['error_title'] = 'Atenção';
$string['error_message'] = 'Por favor, selecione uma resposta antes de avançar.';
$string['understood'] = 'Entendido';
$string['success_title'] = 'Coleta Concluída';
$string['success_message'] = 'Você completou todas as perguntas da coleta. Obrigado por participar!';
$string['return_to_course'] = 'Voltar para o curso';

$string['faq_search_placeholder'] = 'Pesquise pelo título ou conteúdo...';
$string['faq_title'] = 'Como podemos ajudar?';

// pt_br
$string['faq_topic_title'] = 'O que é o StudentCare?';
$string['faq_modal_header'] = '<i class="fas fa-info-circle"></i> O que é o StudentCare?';
$string['faq_modal_body'] =
        'O <strong>StudentCare</strong> é um plugin de bloco desenvolvido para a plataforma Moodle com o objetivo de <em>monitorar as emoções acadêmicas</em> dos estudantes. Ele utiliza como base o <strong>AEQ (Achievement Emotions Questionnaire)</strong>, um instrumento amplamente reconhecido na avaliação de emoções relacionadas ao desempenho acadêmico.';
$string['faq_functionalities_title'] = '<i class="fas fa-tools"></i> Funcionalidades Principais';
$string['faq_functionalities_list'] = '
    <li>Permite que professores criem <strong>coletas de emoções</strong>, selecionando classes e emoções específicas.</li>
    <li>Oferece aos estudantes uma interface interativa para responder às coletas usando uma escala Likert com emojis.</li>
    <li>Gera gráficos interativos para os professores visualizarem os dados coletados, auxiliando na análise das emoções acadêmicas.</li>
    <li>Facilita a exportação dos dados em formatos como <i>CSV</i> e <i>JSON</i> para análises externas.</li>
';
$string['faq_objective_title'] = '<i class="fas fa-bullseye"></i> Objetivo';
$string['faq_objective_text'] =
        'O principal objetivo do <strong>StudentCare</strong> é auxiliar professores e instituições de ensino a identificar e monitorar as emoções acadêmicas dos estudantes, contribuindo para intervenções pedagógicas mais personalizadas e assertivas, visando melhorar o desempenho acadêmico e reduzir problemas como desmotivação e evasão escolar.';
$string['faq_benefits_title'] = '<i class="fas fa-graduation-cap"></i> Benefícios';
$string['faq_benefits_list'] = '
    <li>Apoio no <strong>planejamento pedagógico</strong> baseado em dados emocionais dos alunos.</li>
    <li>Melhoria no <strong>engajamento e bem-estar</strong> dos estudantes.</li>
    <li>Ferramenta de fácil integração ao Moodle, sendo acessível a professores e administradores.</li>
';

$string['faq_how_to_use_title'] = 'Como utilizar o plugin StudentCare?';
$string['faq_how_to_use_intro'] =
        'O plugin StudentCare é uma ferramenta poderosa integrada ao Moodle, que permite aos professores coletar, monitorar e analisar as emoções acadêmicas de forma interativa e eficiente. Aqui está um guia para utilizá-lo:';

$string['faq_how_to_use_teacher_steps_title'] = '👩‍🏫 Passos para o professor cadastrar uma coleta:';
$string['faq_teacher_step_1'] =
        '📋 Acesse o painel do plugin StudentCare: Localize o plugin diretamente no painel do Moodle para facilitar a gestão centralizada, sem necessidade de instalação em cursos específicos.';
$string['faq_teacher_step_2'] = '📚 Preencha as informações da coleta: Adicione as datas de início e fim e descrição (opcional).';
$string['faq_teacher_step_3'] =
        '📝 Escolha o curso, seção e recurso: Vincule a coleta a um curso e selecione uma seção específica. Caso necessário, associe a coleta a um recurso existente.';
$string['faq_teacher_step_4'] =
        '🎭 Selecione as classes e emoções do AEQ: Utilize o formulário para escolher as classes de emoções acadêmicas (aulas, aprendizado, provas) e emoções específicas. Essas seleções definirão as perguntas que os alunos responderão.';
$string['faq_teacher_step_5'] =
        '🔔 Configure notificações e alertas: Ative notificações automáticas para alunos e receba alertas sobre o andamento da coleta.';

$string['faq_after_registration_title'] = '📊 Após o cadastro da coleta:';
$string['faq_after_registration_export'] =
        '📤 Exportação de dados: Os dados das respostas podem ser exportados em formatos como JSON e CSV para análise mais detalhada.';
$string['faq_after_registration_graphs'] =
        '📈 Visualização de gráficos: O professor pode acessar relatórios interativos com gráficos para interpretar os dados coletados e ajustar estratégias pedagógicas conforme necessário.';
$string['faq_after_registration_delete'] =
        '❌ Exclusão de coletas: Caso a coleta não seja mais necessária, o professor pode excluí-la diretamente pelo painel do plugin.';

$string['faq_for_students_title'] = '👨‍🎓 Para os alunos:';
$string['faq_students_notifications'] =
        '🔔 Receba notificações personalizadas: Os alunos são notificados via e-mail e no Moodle sobre as coletas disponíveis.';
$string['faq_students_answer'] =
        '📝 Responda às coletas: As perguntas são exibidas de forma interativa em uma escala Likert de 1 a 5, com base nas classes e emoções selecionadas pelo professor.';
$string['faq_students_tcle'] =
        '📜 Aceite ou recuse o TCLE: Antes de responder às perguntas, os alunos devem aceitar ou recusar o Termo de Consentimento Livre e Esclarecido (TCLE).';

$string['faq_additional_resources_title'] = '📘 Recursos adicionais:';
$string['faq_resources_manual'] =
        '📖 Manual do AEQ: O plugin disponibiliza o <a href=\'/blocks/studentcare/manual_aeq.php\'>Manual AEQ</a>, que fornece detalhes sobre as classes, emoções e perguntas do AEQ.';
$string['faq_resources_auto_creation'] =
        '🌐 Criação automática de recursos: Após o cadastro, o plugin cria automaticamente um recurso do tipo URL vinculado à seção escolhida pelo professor, facilitando o acesso dos alunos.';
$string['faq_resources_graphs'] =
        '📊 Gráficos e relatórios: Dados das respostas são exibidos em gráficos interativos para facilitar a análise.';

$string['faq_how_to_use_conclusion'] =
        'O plugin StudentCare foi projetado para ser intuitivo e eficiente, otimizando o processo de coleta e análise de emoções acadêmicas. Ele auxilia na criação de estratégias pedagógicas baseadas em dados reais, promovendo um ambiente de aprendizado mais saudável e adaptado às necessidades dos alunos.';

$string['faq_topic_functionalities_title'] = 'Principais funcionalidades do plugin StudentCare';
$string['faq_topic_functionalities_description'] =
        'O <strong>StudentCare</strong> é um plugin desenvolvido para facilitar o monitoramento das emoções acadêmicas no Moodle, trazendo diversas funcionalidades pensadas para professores e administradores. Confira algumas das principais:';
$string['faq_topic_functionalities_list'] = '<ul>
    <li><strong>📘 Manual AEQ:</strong> O plugin inclui acesso ao <a href="/blocks/studentcare/manual_aeq.php" target="_blank">Manual AEQ</a>, que explica detalhadamente o embasamento teórico e a estrutura do <em>Achievement Emotions Questionnaire (AEQ)</em>.</li>
    <li><strong>✍️ Cadastro e edição de coletas:</strong> Os professores podem criar novas coletas específicas para suas disciplinas, editar configurações de coletas já existentes e escolher quais classes e emoções do AEQ serão trabalhadas.</li>
    <li><strong>🗑️ Exclusão de coletas:</strong> Caso necessário, coletas podem ser facilmente removidas pelo professor.</li>
    <li><strong>🔗 Vinculação de recursos:</strong> Durante o cadastro, é possível associar um recurso específico de uma seção da disciplina à coleta, integrando ainda mais o conteúdo da aula com a coleta.</li>
    <li><strong>🌐 Criação automática de recurso URL:</strong> Para cada coleta criada, o plugin adiciona automaticamente um recurso do tipo URL na seção escolhida pelo professor.</li>
    <li><strong>📬 Notificações e e-mails personalizados:</strong> Após o cadastro de uma coleta, notificações e e-mails customizados para a disciplina são enviados automaticamente aos alunos.</li>
    <li><strong>📝 TCLE interativo:</strong> Antes de responder à coleta, o aluno visualiza um Termo de Consentimento Livre e Esclarecido (TCLE) e pode aceitá-lo ou recusá-lo.</li>
    <li><strong>🤖 Respostas interativas:</strong> As questões do AEQ são apresentadas de forma interativa e baseadas nas classes e emoções escolhidas pelo professor.</li>
    <li><strong>📊 Monitoramento e alertas:</strong> O professor pode acompanhar o progresso da coleta em tempo real e receber alertas sobre o andamento.</li>
    <li><strong>📈 Visualização de resultados:</strong> Os dados coletados são exibidos em gráficos interativos e relatórios, permitindo uma análise prática e visual das emoções dos alunos.</li>
    <li><strong>📂 Exportação de dados:</strong> Respostas dos alunos podem ser exportadas em formatos como JSON e CSV, facilitando análises externas ou arquivamento.</li>
    <li><strong>📋 Gerenciamento centralizado:</strong> Instalado no painel do Moodle, o plugin oferece um gerenciamento simplificado e integrado, sem a necessidade de instalá-lo separadamente em cada curso.</li>
</ul>';
$string['faq_topic_functionalities_closing'] =
        'Essas funcionalidades tornam o <strong>StudentCare</strong> uma ferramenta poderosa e prática para compreender as emoções acadêmicas dos alunos e melhorar o processo de ensino e aprendizagem.';

$string['faq_topic_developers_title'] = 'Quem desenvolveu o StudentCare?';
$string['faq_topic_developers_description'] =
        'O <strong>StudentCare</strong> é um projeto desenvolvido como Trabalho de Conclusão de Curso (TCC) pelo aluno <strong>Rafael Lariloran Costa Rodrigues</strong> (<a href="http://lattes.cnpq.br/1281350600184120" target="_blank">Lattes</a>), estudante do curso superior em <em>Sistemas para Internet</em> do <strong>Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Sul (IFRS) – Campus Porto Alegre</strong>.';
$string['faq_topic_developers_guidance'] = 'Orientação';
$string['faq_topic_developers_guidance_description'] =
        'O projeto foi orientado pela <strong>Profa. Dra. Márcia Häfele Islabão Franco</strong> (<a href="http://lattes.cnpq.br/2551214616925074" target="_blank">Lattes</a>) e coorientado pelo <strong>Prof. Dr. Marcelo Augusto Rauh Schmitt</strong> (<a href="http://lattes.cnpq.br/1958021878056697" target="_blank">Lattes</a>), ambos docentes do IFRS Porto Alegre.';
$string['faq_topic_developers_contact'] = 'Contato';
$string['faq_topic_developers_contact_description'] =
        'Se você encontrou algum <strong>bug, problema ou possui dúvidas</strong>, envie um e-mail para:';

$string['start_here_title'] = 'Comece por aqui';
$string['start_here_description'] =
        'O <strong>Achievement Emotions Questionnaire (AEQ)</strong> é um instrumento de avaliação psicológica desenvolvido para medir as emoções acadêmicas dos estudantes em contextos educacionais. Criado por <strong>Reinhard Pekrun</strong> e seus colaboradores, o AEQ é fundamentado na teoria de Controle-Valorização, que analisa como as emoções influenciam o desempenho e a motivação acadêmica.';
$string['how_it_works'] = 'Como funciona?';
$string['start_here_questionnaire_description'] =
        'O AEQ utiliza um questionário estruturado com perguntas baseadas em uma escala <em>Likert</em>, onde os estudantes avaliam suas emoções relacionadas a três situações principais:';
$string['emotion_classrooms'] = 'Emoções relacionadas às aulas';
$string['emotion_classrooms_description'] =
        'Sentimentos como alegria, tédio e raiva vivenciados antes, durante e depois de frequentar aulas.';
$string['emotion_study'] = 'Emoções relacionadas ao estudo';
$string['emotion_study_description'] =
        'Sentimentos como orgulho, frustração e ansiedade experimentados durante o processo de aprendizagem.';
$string['emotion_exams'] = 'Emoções relacionadas às provas';
$string['emotion_exams_description'] = 'Sentimentos como alívio, esperança e vergonha antes, durante e após avaliações.';
$string['how_to_use'] = 'Formas de uso';
$string['start_here_usage'] = 'O AEQ é amplamente utilizado em contextos educacionais e de pesquisa para:';
$string['evaluate_impact'] = 'Avaliar o impacto das emoções acadêmicas no desempenho dos estudantes.';
$string['identify_patterns'] = 'Identificar padrões emocionais que possam levar à desmotivação ou evasão escolar.';
$string['assist_educators'] =
        'Auxiliar educadores e administradores a desenvolver estratégias pedagógicas que promovam um ambiente emocionalmente saudável.';
$string['purpose'] = 'Propósito';
$string['main_objective'] =
        'O principal objetivo do AEQ é fornecer uma ferramenta para compreender as emoções acadêmicas e seu papel no aprendizado, ajudando a melhorar a experiência educacional e reduzir barreiras emocionais ao sucesso acadêmico.';
$string['classes_aeq'] = 'Classes AEQ';
$string['what_are_aeq_classes'] = 'O que são as Classes do AEQ?';
$string['aeq_classes_description'] =
        'As classes do AEQ são categorias que agrupam as emoções acadêmicas com base no contexto em que elas ocorrem. Cada classe foi projetada para avaliar as emoções experimentadas antes, durante e depois de atividades acadêmicas específicas, como assistir aulas, estudar ou realizar testes/provas. Esses momentos são críticos, pois representam as situações de maior impacto emocional na trajetória acadêmica de um estudante.';
$string['classroom_related_emotions'] = 'Emoções Relacionadas às Aulas';
$string['classroom_emotions_description'] =
        'Esta classe avalia as emoções experimentadas ao participar de aulas (<i>Class-Related Emotions</i>). Ela engloba sentimentos vivenciados antes de entrar na sala de aula (por exemplo, expectativa ou nervosismo), durante a aula (como interesse ou frustração) e depois da aula (como alívio ou orgulho).';
$string['learning_related_emotions'] = 'Emoções Relacionadas ao Aprendizado';
$string['learning_emotions_description'] =
        'Focada nas emoções associadas ao processo de estudo ou aprendizagem (<i>Learning-Related Emotions</i>), esta classe aborda os sentimentos que surgem antes de iniciar uma sessão de estudo (como motivação ou desânimo), durante o estudo (como concentração ou irritação) e depois de estudar (como satisfação ou frustração).';
$string['test_related_emotions'] = 'Emoções Relacionadas a Atividades Avaliativas (testes/provas)';
$string['test_emotions_description'] =
        'Esta classe examina as emoções vivenciadas em momentos de avaliação, como testes e provas (<i>Test-Related Emotions</i>). Considera os sentimentos experimentados antes de uma prova (como ansiedade ou confiança), durante a realização (como nervosismo ou foco) e após o término (como alívio ou vergonha).';

$string['aeq_questions'] = 'Perguntas do AEQ';
$string['aeq_description'] =
        'As perguntas do <strong>Achievement Emotions Questionnaire (AEQ)</strong> foram desenvolvidas para medir as emoções acadêmicas de forma estruturada, em três contextos principais: aulas, estudo e testes/provas. Elas avaliam as emoções vivenciadas antes, durante e depois de cada uma dessas situações.';
$string['how_it_works'] = 'Como Funcionam?';
$string['how_it_works_description'] =
        'Cada pergunta apresenta uma afirmação que descreve um estado emocional. Os estudantes avaliam como essa afirmação reflete suas experiências pessoais, utilizando uma escala do tipo <em>Likert</em>, que varia de 1 (discordo totalmente) a 5 (concordo totalmente).';
$string['example_questions'] = 'Exemplos de Perguntas';
$string['classroom_related'] = 'Relacionadas às Aulas';
$string['example_classroom_question'] = 'Eu fico animado em ir para a aula.';
$string['study_related'] = 'Relacionadas ao Estudo';
$string['example_study_question'] = 'Eu me sinto otimista sobre o meu progresso nos estudos.';
$string['test_related'] = 'Relacionadas a Testes/Provas';
$string['example_test_question'] = 'Eu fico ansioso antes de uma prova.';
$string['question_organization'] = 'Organização das Perguntas';
$string['question_organization_description'] =
        'As perguntas estão organizadas em blocos que ajudam os participantes a acessar memórias específicas, tornando as respostas mais representativas. Essa estrutura permite compreender melhor como as emoções afetam o desempenho acadêmico.';
$string['manual_aeq_title'] = 'Guia para Utilização do AEQ';

$string['academic_emotions'] = 'Emoções Acadêmicas';
$string['aeq_description'] =
        'O <strong>Achievement Emotions Questionnaire (AEQ)</strong> trabalha com uma ampla gama de emoções acadêmicas (<i>Achievement Emotions</i>), organizadas em três contextos principais: aulas, estudo e provas. Aqui estão as emoções avaliadas em cada contexto e o que elas representam:';
$string['classroom_related_emotions'] = 'Emoções Relacionadas às Aulas';
$string['classroom_joy_description'] = 'Sentimento de prazer e entusiasmo ao participar das aulas.';
$string['classroom_hope_description'] = 'Confiança de que será possível acompanhar o conteúdo e participar ativamente.';
$string['classroom_pride_description'] = 'Satisfação por compreender o conteúdo ou contribuir positivamente.';
$string['classroom_anger_description'] = 'Frustração ou irritação causada pela dinâmica ou qualidade da aula.';
$string['classroom_anxiety_description'] = 'Inquietação ou nervosismo relacionado ao ambiente ou ao conteúdo da aula.';
$string['classroom_shame_description'] = 'Embaraço por dificuldades de expressão ou compreensão do conteúdo.';
$string['classroom_hopelessness_description'] = 'Sentimento de desistência ou falta de perspectiva em relação ao aprendizado.';
$string['classroom_boredom_description'] = 'Sensação de monotonia ou falta de interesse na aula.';
$string['learning_related_emotions'] = 'Emoções Relacionadas ao Aprendizado';
$string['learning_joy_description'] = 'Prazer em aprender e explorar novos conhecimentos.';
$string['learning_hope_description'] = 'Otimismo sobre a capacidade de dominar o material estudado.';
$string['learning_pride_description'] = 'Satisfação pelos resultados alcançados durante o processo de estudo.';
$string['learning_anger_description'] = 'Irritação com a quantidade de material ou dificuldades no estudo.';
$string['learning_anxiety_description'] = 'Medo ou tensão diante de dificuldades no aprendizado.';
$string['learning_shame_description'] = 'Embaraço por não conseguir absorver ou aplicar o conteúdo adequadamente.';
$string['learning_hopelessness_description'] = 'Desmotivação por acreditar que não conseguirá entender ou avançar no estudo.';
$string['learning_boredom_description'] = 'Sensação de desinteresse ao lidar com material monótono ou pouco estimulante.';
$string['test_related_emotions'] = 'Emoções Relacionadas às Atividades Avaliativas (testes/provas)';
$string['test_joy_description'] = 'Satisfação ao demonstrar conhecimento ou enfrentar desafios em provas.';
$string['test_hope_description'] = 'Confiança em um bom desempenho e sucesso na avaliação.';
$string['test_pride_description'] = 'Satisfação pelos esforços de preparação e desempenho na prova.';
$string['test_relief_description'] = 'Sensação de tranquilidade ao concluir uma avaliação.';
$string['test_anger_description'] = 'Frustração com o tempo, dificuldade ou injustiça percebida na prova.';
$string['test_anxiety_description'] = 'Preocupação intensa antes ou durante a avaliação.';
$string['test_shame_description'] = 'Embaraço por desempenho insatisfatório ou erros cometidos.';
$string['test_hopelessness_description'] = 'Sentimento de desistência ou falta de confiança no sucesso da prova.';

$string['start_here'] = 'Comece por aqui';

$string['confirmation_delete_title'] = 'Confirmação de Exclusão';
$string['confirmation_delete_message'] =
        'Tem certeza de que deseja excluir a coleta "<strong>{coletaNome}</strong>"? Esta ação não pode ser desfeita e todos os dados relacionados serão removidos.';
$string['delete_button'] = 'Excluir';
$string['cancel_button'] = 'Cancelar';
$string['error_title'] = 'Erro';
$string['error_message'] = 'Ocorreu um erro ao tentar excluir a coleta. Por favor, tente novamente.';

$string['coleta_limitada_aviso'] =
        'A coleta foi iniciada em {$a->datainicio}. Algumas alterações estão limitadas. Para mais detalhes desta coleta, retorne à <a href="{$a->listagemurl}">listagem</a>.';
$string['coleta_atualizada_com_sucesso'] = 'A coleta foi atualizada com sucesso.';
$string['returntolist'] = 'Voltar para a listagem';

$string['collection_title'] = 'StudentCare - Como você está se sentindo hoje?';
$string['collection_intro'] =
        'Responda esta coleta <strong>até</strong> {date}. Participe e nos ajude a compreender melhor suas emoções!';

$string['event_subject'] = 'StudentCare - Compartilhe suas emoções sobre a disciplina de {disciplina}';
$string['event_fullmessage'] =
        'Olá! Uma coleta de emoções para a disciplina {disciplina} foi criada e está disponível até {datafim} para você responder. Sua opinião é muito importante. Por favor, participe!';
$string['event_fullmessagehtml'] = '<p>Olá!</p>
<p>Uma coleta de emoções para a disciplina <strong>{disciplina}</strong> foi criada e está disponível até <strong>{datafim}</strong> para você responder.</p>
<p>Sua opinião é muito importante para nós. <a href="{url}">Clique aqui</a> para compartilhar suas emoções e nos ajudar a melhorar sua experiência de aprendizado.</p>';
$string['event_smallmessage'] =
        'Uma coleta de emoções para a disciplina {disciplina} foi criada e está disponível até {datafim}. <a href="{url}">Clique aqui</a> para participar.';

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
$string['manual_aeq_search_placeholder'] = 'Pesquise pelo título ou conteúdo...';
$string['chart_title'] = 'Distribuição de Respostas por Escala Likert';

$string['yes'] = 'Sim';
$string['no'] = 'Não';

$string['dontlink'] = 'Não vincular a nenhuma atividade/recurso';
$string['noemotion'] = 'Nenhuma emoção cadastrada para esta coleta.';

$string['confirm_title'] = 'Confirmação';
$string['confirm_message'] = 'Deseja salvar as informações desta coleta de emoções?';
$string['confirm_message_update'] = 'Deseja alterar as informações desta coleta de emoções?';
$string['confirm_message_delete'] =
        'Tem certeza de que deseja excluir essa coleta? Esta ação não pode ser desfeita e todos os dados relacionados serão removidos.';
$string['confirm_button_yes'] = 'Confirmar';
$string['confirm_button_no'] = 'Cancelar';

$string['questions_referring'] = 'As perguntas a seguir referem-se';
$string['plural_emotions'] = 'às emoções';
$string['singular_emotion'] = 'à emoção';
$string['that_you_can_feel'] = 'que você pode sentir';
$string['before'] = 'antes';
$string['during'] = 'durante';
$string['after'] = 'depois';
$string['in_course'] = 'da disciplina de';
$string['from_course'] = 'da disciplina de';
$string['from_class'] = 'das aulas da disciplina de';
$string['from_study'] = 'do estudo';
$string['from_assessment'] = 'da atividade avaliativa';

$string['please_read_each_item'] = 'Por favor, leia cada item com atenção e responda utilizando a escala fornecida.';

$string['emotion-colect'] = 'Coleta de Emoções';

// Mensagem de boas-vindas
$string['welcome'] = 'Bem-vindos ao StudentCare!';

// Classes
$string['class-related'] = 'Emoções Relacionadas às aulas';
$string['learning-related'] = 'Emoções Relacionadas ao aprendizado';
$string['test-related'] = 'Emoções Relacionadas às atividades avaliativas';

// Emotions
$string['anger'] = 'Raiva';
$string['joy'] = 'Alegria';
$string['anxiety'] = 'Ansiedade';
$string['shame'] = 'Vergonha';
$string['hopelessness'] = 'Desesperança';
$string['boredom'] = 'Tédio';
$string['hope'] = 'Esperança';
$string['pride'] = 'Orgulho';
$string['relief'] = 'Alívio';
$string['enjoyment'] = 'Alegria';

$string['anger-txttooltip'] =
        'Uma emoção intensa, muitas vezes resultante de frustração ou injustiça, que pode levar a ações impulsivas.';
$string['anxiety-txttooltip'] = 'Um sentimento de preocupação, nervosismo ou medo sobre eventos futuros ou situações incertas.';
$string['shame-txttooltip'] =
        'Um sentimento desconfortável ou doloroso causado pela percepção de que algo que você fez ou disse foi errado ou embaraçoso.';
$string['hopelessness-txttooltip'] =
        'Um sentimento de completa falta de esperança, onde parece que não há soluções ou saídas para uma situação difícil.';
$string['boredom-txttooltip'] =
        'Um estado de falta de interesse ou estímulo, muitas vezes associado à repetição ou à ausência de desafios.';
$string['hope-txttooltip'] = 'Um sentimento otimista sobre o futuro, acreditando que algo bom vai acontecer.';
$string['pride-txttooltip'] = 'Um sentimento de satisfação consigo mesmo ou com os outros por realizações, sucesso ou habilidades.';
$string['relief-txttooltip'] =
        'Um sentimento de tranquilidade e conforto que surge quando uma situação estressante, difícil ou dolorosa chega ao fim ou é resolvida.';
$string['enjoyment-txttooltip'] =
        'Uma sensação de satisfação e bem-estar, normalmente associada a experiências agradáveis e positivas.';

// Tooltips
$string['select_section_help'] =
        'Escolha a seção onde deseja realizar a coleta de emoções. Cada seção representa um módulo ou semana do curso. Ao selecionar uma seção, será criado automaticamente um recurso do tipo <strong>URL</strong> na seção escolhida.';
$string['select_resource_help'] =
        'Escolha o recurso ao qual deseja atrelar a coleta de emoções. Cada recurso representa uma atividade ou material dentro do curso. Ao selecionar o recurso, ele será vinculado automaticamente à coleta de emoções na seção correspondente.';
$string['aeqclasses_help'] =
        'Escolha as classes AEQ que deseja utilizar na coleta de emoções. As classes AEQ representam diferentes categorias de emoções acadêmicas. Para entender mais sobre as classes do AEQ, consulte a seção <strong>Manual do AEQ</strong> no painel do bloco.';
$string['emotions_help'] =
        'Escolha as emoções que deseja incluir na coleta. Cada emoção selecionada exibirá um conjunto diferente de perguntas relacionadas durante a coleta, permitindo uma análise detalhada das emoções acadêmicas. As emoções estão associadas às classes AEQ, que representam diferentes categorias de emoções acadêmicas. Para entender mais sobre as emoções e suas classificações, consulte as informações no <strong>Manual do AEQ</strong> disponível no painel do bloco.';
$string['alertprogress_help'] =
        'Ative esta opção para enviar uma notificação quando a coleta for finalizada. Quando ativado, uma notificação por e-mail e um pop-up no Moodle serão enviadas informando que a coleta de emoções foi concluída.';
$string['notify_students_help'] =
        'Ative esta opção para enviar uma notificação aos alunos quando uma nova coleta for criada. Quando ativado, os alunos receberão uma notificação por e-mail e um pop-up no Moodle informando sobre a criação da coleta de emoções.';

$string['class-related-enjoyment-1'] = 'Estar na aula dessa disciplina me deixa muito animado.';
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
$string['class-related-hope-2'] = 'Estou cheio(a) de esperança.';
$string['class-related-hope-3'] = 'Estou otimista de que conseguirei acompanhar o conteúdo.';
$string['class-related-hope-4'] = 'Estou esperançoso(a) de que farei boas contribuições na aula.';
$string['class-related-hope-5'] = 'Estou confiante porque entendo o conteúdo.';
$string['class-related-hope-6'] = 'Estar confiante de que entenderei o conteúdo me motiva.';
$string['class-related-hope-7'] = 'Minha confiança me motiva a me preparar para a aula.';
$string['class-related-hope-8'] = 'Minhas esperanças de que terei sucesso me motivam a investir muito esforço.';

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

$string['class-related-shame-1'] = 'Fico envergonhado(a).';
$string['class-related-shame-2'] = 'Me sinto envergonhado(a).';
$string['class-related-shame-3'] = 'Se os outros soubessem que não entendo o conteúdo, ficaria envergonhado(a).';
$string['class-related-shame-4'] = 'Quando falo algo na aula, sinto que estou me colocando em uma posição ridícula.';
$string['class-related-shame-5'] = 'Estou envergonhado(a) por não conseguir me expressar bem.';
$string['class-related-shame-6'] = 'Estou envergonhado(a) porque os outros entenderam mais da aula do que eu.';
$string['class-related-shame-7'] = 'Depois que digo algo na aula, gostaria de poder me esconder.';
$string['class-related-shame-8'] = 'Preferiria não contar a ninguém quando não entendo algo na aula.';
$string['class-related-shame-9'] = 'Quando digo algo na aula, sinto que fico vermelho(a).';
$string['class-related-shame-10'] = 'Porque fico envergonhado(a), fico tenso(a) e inibido(a).';
$string['class-related-shame-11'] = 'Quando falo na aula, começo a gaguejar.';

$string['class-related-hopelessness-1'] = 'Só de pensar nessa aula, sinto-me sem esperanças.';
$string['class-related-hopelessness-2'] = 'Sinto-me desamparado(a).';
$string['class-related-hopelessness-3'] =
        'Antes mesmo de a aula começar, já me conformo com o fato de que não vou entender o conteúdo.';
$string['class-related-hopelessness-4'] = 'Já perdi qualquer esperança de compreender esta aula';
$string['class-related-hopelessness-5'] = 'Sinto-me desamparado ao continuar neste curso.';
$string['class-related-hopelessness-6'] = 'Porque desisti, não tenho energia para ir à aula.';
$string['class-related-hopelessness-7'] =
        'Preferiria não ir à aula, pois não há esperança de entender o material de qualquer forma.';
$string['class-related-hopelessness-8'] = 'É inútil me preparar para a aula, já que não entendo o material de qualquer forma.';
$string['class-related-hopelessness-9'] = 'Porque não entendo o material, pareço desconectado(a) e resignado(a).';
$string['class-related-hopelessness-10'] = 'Sinto-me tão desamparado(a) que toda a minha energia se esgota.';

$string['class-related-boredom-1'] = 'Fico entediado(a).';
$string['class-related-boredom-2'] = 'Acho esta aula bastante maçante.';
$string['class-related-boredom-3'] = 'A palestra me entedia.';
$string['class-related-boredom-4'] = 'Porque fico entediado(a), minha mente começa a vagar.';
$string['class-related-boredom-5'] = 'Estou tentado(a) a sair da palestra porque é tão chata.';
$string['class-related-boredom-6'] =
        'Penso em outras coisas que poderia estar fazendo em vez de estar sentado(a) nesta aula chata.';
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
$string['learning-related-enjoyment-8'] =
        'Certas matérias são tão agradáveis que estou motivado a fazer leituras adicionais sobre elas.';
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
$string['learning-related-shame-5'] =
        'Eu me sinto envergonhado por não conseguir explicar completamente o material para os outros.';
$string['learning-related-shame-6'] = 'Eu me sinto envergonhado quando percebo que não tenho capacidade.';
$string['learning-related-shame-7'] = 'Minhas lacunas de memória me envergonham.';
$string['learning-related-shame-8'] = 'Porque tive tantas dificuldades com o material do curso, evito discutir sobre ele.';
$string['learning-related-shame-9'] = 'Eu não quero que ninguém saiba quando não consegui entender algo.';
$string['learning-related-shame-10'] = 'Quando alguém percebe o quanto eu pouco entendo, evito contato visual.';
$string['learning-related-shame-11'] =
        'Eu fico vermelho quando não sei a resposta a uma pergunta relacionada ao material do curso.';

$string['learning-related-hopelessness-1'] = 'Eu me sinto sem esperança quando penso em estudar.';
$string['learning-related-hopelessness-2'] = 'Eu me sinto impotente.';
$string['learning-related-hopelessness-3'] = 'Eu me sinto resignado.';
$string['learning-related-hopelessness-4'] = 'Estou resignado ao fato de que não tenho capacidade para dominar este material.';
$string['learning-related-hopelessness-5'] = 'Depois de estudar, estou resignado ao fato de que não tenho habilidade.';
$string['learning-related-hopelessness-6'] = 'Estou desencorajado pela ideia de que nunca aprenderei o material.';
$string['learning-related-hopelessness-7'] =
        'Eu me preocupo porque minhas habilidades não são suficientes para meu curso de estudos.';
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

$string['test-related-pride-1'] = 'Estou muito satisfeito comigo mesmo.';
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

$string['test-related-shame-1'] = 'Eu me sinto humilhado.';
$string['test-related-shame-2'] = 'Eu me sinto envergonhado.';
$string['test-related-shame-3'] = 'Não consigo nem pensar em como seria embaraçoso falhar na prova.';
$string['test-related-shame-4'] = 'Eu me envergonho da minha má preparação.';
$string['test-related-shame-5'] = 'Fico envergonhado porque não consigo responder corretamente às perguntas.';
$string['test-related-shame-6'] = 'Minhas notas me envergonham.';
$string['test-related-shame-7'] = 'Fico tão envergonhado que quero correr e me esconder.';
$string['test-related-shame-8'] = 'Quando recebo uma nota ruim, prefiro não enfrentar meu professor novamente.';
$string['test-related-shame-9'] = 'Porque estou envergonhado, meu pulso acelera.';
$string['test-related-shame-10'] = 'Quando os outros descobrem sobre minhas notas ruins, começo a corar.';

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
