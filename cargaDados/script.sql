-- AEQ CLASS
INSERT INTO mysql.mdl_ifcare_classeaeq
(id, nome_classe)
VALUES(1, 'EMOÇÕES RELACIONADAS ÀS AULAS');
INSERT INTO mysql.mdl_ifcare_classeaeq
(id, nome_classe)
VALUES(2, 'EMOÇÕES RELACIONADAS AO APRENDIZADO');
INSERT INTO mysql.mdl_ifcare_classeaeq
(id, nome_classe)
VALUES(3, 'EMOÇÕES RELACIONADAS ÀS ATIVIDADES AVALIATIVAS');

-- EMOTIONS-CLASS
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(1, 1, 'Prazer', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(2, 1, 'Esperança', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(3, 1, 'Orgulho', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(4, 1, 'Raiva', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(5, 1, 'Ansiedade', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(6, 1, 'Vergonha', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(7, 1, 'Desespero', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(8, 1, 'Tédio', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(9, 2, 'Prazer', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(10, 2, 'Esperança', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(11, 2, 'Orgulho', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(12, 2, 'Raiva', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(13, 2, 'Ansiedade', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(14, 2, 'Vergonha', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(15, 2, 'Desespero', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(16, 2, 'Tédio', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(17, 3, 'Prazer', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(18, 3, 'Esperança', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(19, 3, 'Orgulho', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(20, 3, 'Alívio', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(21, 3, 'Raiva', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(22, 3, 'Ansiedade', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(23, 3, 'Vergonha', 1, 1, 1);
INSERT INTO mysql.mdl_ifcare_emocao
(id, classeaeq_id, nome, antes, durante, depois)
VALUES(24, 3, 'Desespero', 1, 1, 1);


--CLASS RELATED
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(1, 1, 1, 'Fico animado(a) para ir à aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(2, 1, 1, 'Gosto de estar na aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(3, 1, 1, 'Depois da aula, começo a ansiar pela próxima aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(4, 1, 1, 'Estou ansioso(a) para aprender muito nesta aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(5, 1, 1, 'Estou feliz por ter entendido o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(6, 1, 1, 'Fico contente que valeu a pena ir à aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(7, 1, 1, 'Estou motivado(a) para ir a esta aula porque é empolgante.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(8, 1, 1, 'Meu prazer nesta aula me faz querer participar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(9, 1, 1, 'É tão empolgante que eu poderia ficar na aula por horas ouvindo o professor.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(10, 1, 1, 'Gosto tanto de participar que fico energizado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(11, 2, 1, 'Estou confiante quando vou à aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(12, 2, 1, 'Estou cheio(a) de esperança.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(13, 2, 1, 'Estou otimista de que conseguirei acompanhar o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(14, 2, 1, 'Estou esperançoso(a) de que farei boas contribuições na aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(15, 2, 1, 'Estou confiante porque entendo o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(16, 2, 1, 'Estar confiante de que entenderei o material me motiva.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(17, 2, 1, 'Minha confiança me motiva a me preparar para a aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(18, 2, 1, 'Minhas esperanças de que terei sucesso me motivam a investir muito esforço.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(19, 3, 1, 'Tenho orgulho de mim mesmo(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(20, 3, 1, 'Tenho orgulho de conseguir acompanhar o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(21, 3, 1, 'Tenho orgulho de fazer melhor do que os outros neste curso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(22, 3, 1, 'Acho que posso ter orgulho do que sei sobre este assunto.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(23, 3, 1, 'Estou orgulhoso(a) das contribuições que fiz na aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(24, 3, 1, 'Quando faço boas contribuições na aula, fico ainda mais motivado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(25, 3, 1, 'Porque tenho orgulho das minhas conquistas neste curso, estou motivado(a) a continuar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(26, 3, 1, 'Gostaria de contar aos meus amigos sobre como me saí bem neste curso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(27, 3, 1, 'Quando me saio bem na aula, meu coração se enche de orgulho.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(28, 4, 1, 'Sinto-me frustrado(a) na aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(29, 4, 1, 'Estou com raiva.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(30, 4, 1, 'Pensar na baixa qualidade do curso me deixa irritado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(31, 4, 1, 'Pensar em todas as coisas inúteis que tenho que aprender me irrita.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(32, 4, 1, 'Quando penso no tempo que perco na aula, fico agitado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(33, 4, 1, 'Eu gostaria de não ter que ir à aula porque isso me deixa com raiva.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(34, 4, 1, 'Eu gostaria de poder dizer aos professores o que penso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(35, 4, 1, 'Sinto a raiva crescendo dentro de mim.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(36, 4, 1, 'Porque estou com raiva, fico inquieto(a) na aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(37, 5, 1, 'Pensar na aula me deixa inquieto(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(38, 5, 1, 'Sinto medo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(39, 5, 1, 'Sinto-me nervoso(a) na aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(40, 5, 1, 'Mesmo antes da aula, me preocupo se conseguirei entender o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(41, 5, 1, 'Me preocupo se estou suficientemente preparado(a) para a lição.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(42, 5, 1, 'Me preocupo se as exigências podem ser grandes demais.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(43, 5, 1, 'Me preocupo que os outros entenderão mais do que eu.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(44, 5, 1, 'Porque estou tão nervoso(a), prefiro pular a aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(45, 5, 1, 'Tenho medo de que possa dizer algo errado, então prefiro não dizer nada.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(46, 5, 1, 'Quando penso na aula, fico enjoado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(47, 5, 1, 'Fico tenso(a) na aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(48, 5, 1, 'Quando não entendo algo importante na aula, meu coração acelera.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(49, 6, 1, 'Fico envergonhado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(50, 6, 1, 'Estou envergonhado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(51, 6, 1, 'Se os outros soubessem que não entendo o material, ficaria envergonhado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(52, 6, 1, 'Quando digo algo na aula, sinto que estou me fazendo de tolo(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(53, 6, 1, 'Estou envergonhado(a) por não conseguir me expressar bem.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(54, 6, 1, 'Estou envergonhado(a) porque os outros entenderam mais da palestra do que eu.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(55, 6, 1, 'Depois que digo algo na aula, gostaria de poder me esconder.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(56, 6, 1, 'Preferiria não contar a ninguém quando não entendo algo na aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(57, 6, 1, 'Quando digo algo na aula, sinto que fico vermelho(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(58, 6, 1, 'Porque fico envergonhado(a), fico tenso(a) e inibido(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(59, 6, 1, 'Quando falo na aula, começo a gaguejar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(60, 7, 1, 'O pensamento desta aula me faz sentir desamparado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(61, 7, 1, 'Sinto-me desamparado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(62, 7, 1, 'Mesmo antes da aula, estou resignado(a) à ideia de que não conseguirei entender o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(63, 7, 1, 'Perdi toda a esperança de entender esta aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(64, 7, 1, 'Sinto-me desamparado(a) para continuar neste programa de estudos.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(65, 7, 1, 'Porque desisti, não tenho energia para ir à aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(66, 7, 1, 'Preferiria não ir à aula, pois não há esperança de entender o material de qualquer forma.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(67, 7, 1, 'É inútil me preparar para a aula, já que não entendo o material de qualquer forma.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(68, 7, 1, 'Porque não entendo o material, pareço desconectado(a) e resignado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(69, 7, 1, 'Sinto-me tão desamparado(a) que toda a minha energia se esgota.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(70, 8, 1, 'Fico entediado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(71, 8, 1, 'Acho esta aula bastante maçante.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(72, 8, 1, 'A palestra me entedia.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(73, 8, 1, 'Porque fico entediado(a), minha mente começa a vagar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(74, 8, 1, 'Estou tentado(a) a sair da palestra porque é tão chata.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(75, 8, 1, 'Penso em outras coisas que poderia estar fazendo em vez de estar sentado(a) nesta aula chata.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(76, 8, 1, 'Como o tempo se arrasta, olho frequentemente para o meu relógio.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(77, 8, 1, 'Fico tão entediado(a) que tenho problemas para ficar alerta.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(78, 8, 1, 'Fico inquieto(a) porque não posso esperar para que a aula termine.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(79, 8, 1, 'Durante a aula, sinto que poderia afundar na minha cadeira.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(80, 8, 1, 'Começo a bocejar na aula porque estou tão entediado(a).');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(233, 1, 1, 'Fico animado(a) para ir à aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(234, 1, 1, 'Gosto de estar na aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(235, 1, 1, 'Depois da aula, começo a ansiar pela próxima aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(236, 1, 1, 'Estou ansioso(a) para aprender muito nesta aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(237, 1, 1, 'Estou feliz por ter entendido o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(238, 1, 1, 'Fico contente que valeu a pena ir à aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(239, 1, 1, 'Estou motivado(a) para ir a esta aula porque é empolgante.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(240, 1, 1, 'Meu prazer nesta aula me faz querer participar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(241, 1, 1, 'É tão empolgante que eu poderia ficar na aula por horas ouvindo o professor.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(242, 1, 1, 'Gosto tanto de participar que fico energizado(a).');


--LEARNING RELATED
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(158, 9, 2, 'Estou ansioso para estudar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(159, 9, 2, 'Eu gosto do desafio de aprender o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(160, 9, 2, 'Eu gosto de adquirir novos conhecimentos.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(161, 9, 2, 'Eu gosto de lidar com o material do curso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(162, 9, 2, 'Refletir sobre meu progresso nos estudos me deixa feliz.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(163, 9, 2, 'Eu estudo mais do que o necessário porque gosto muito.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(164, 9, 2, 'Estou tão feliz com o progresso que fiz que estou motivado a continuar estudando.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(165, 9, 2, 'Certas matérias são tão agradáveis que estou motivado a fazer leituras adicionais sobre elas.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(166, 9, 2, 'Quando meus estudos vão bem, isso me dá uma empolgação.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(167, 9, 2, 'Fico fisicamente animado quando meus estudos vão bem.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(168, 10, 2, 'Eu tenho uma visão otimista em relação ao estudo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(169, 10, 2, 'Eu me sinto confiante ao estudar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(170, 10, 2, 'Eu me sinto confiante de que serei capaz de dominar o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(171, 10, 2, 'Sinto-me otimista de que farei bons progressos nos estudos.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(172, 10, 2, 'O pensamento de alcançar meus objetivos de aprendizado me inspira.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(173, 10, 2, 'Meu senso de confiança me motiva.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(174, 10, 2, 'Estou orgulhoso de mim mesmo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(175, 11, 2, 'Estou orgulhoso da minha capacidade.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(176, 11, 2, 'Acho que posso me orgulhar das minhas conquistas nos estudos.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(177, 11, 2, 'Porque quero me orgulhar das minhas conquistas, estou muito motivado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(178, 11, 2, 'Quando resolvo um problema difícil nos meus estudos, meu coração bate de orgulho.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(179, 11, 2, 'Quando me destaco no meu trabalho, fico cheio de orgulho.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(180, 12, 2, 'Fico com raiva quando tenho que estudar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(181, 12, 2, 'Estudar me irrita.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(182, 12, 2, 'Fico com raiva enquanto estudo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(183, 12, 2, 'Estou irritado por ter que estudar tanto.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(184, 12, 2, 'Fico incomodado por ter que estudar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(185, 12, 2, 'Porque fico tão chateado com a quantidade de material, não quero nem começar a estudar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(186, 12, 2, 'Fico tão bravo que sinto vontade de jogar o livro didático pela janela.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(187, 12, 2, 'Quando fico muito tempo sentado na minha mesa, minha irritação me deixa inquieto.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(188, 12, 2, 'Depois de estudar por um longo período, fico tão irritado que fico tenso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(189, 13, 2, 'Quando olho para os livros que ainda tenho que ler, fico ansioso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(190, 13, 2, 'Fico tenso e nervoso enquanto estudo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(191, 13, 2, 'Quando não consigo acompanhar meus estudos, isso me deixa com medo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(192, 13, 2, 'Eu me preocupo se serei capaz de lidar com todo o meu trabalho.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(193, 13, 2, 'O assunto me assusta, pois não o compreendo completamente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(194, 13, 2, 'Eu me preocupo se entendi o material corretamente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(195, 13, 2, 'Fico tão nervoso que nem quero começar a estudar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(196, 13, 2, 'Enquanto estudo, sinto vontade de me distrair para reduzir minha ansiedade.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(197, 13, 2, 'Quando tenho que estudar, começo a me sentir enjoado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(198, 13, 2, 'À medida que o tempo acaba, meu coração começa a acelerar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(199, 13, 2, 'A preocupação em não completar o material me faz suar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(200, 14, 2, 'Eu me sinto envergonhado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(201, 14, 2, 'Eu me sinto envergonhado pela minha constante procrastinação.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(202, 14, 2, 'Eu me sinto envergonhado por não conseguir absorver os detalhes mais simples.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(203, 14, 2, 'Eu me sinto envergonhado porque não sou tão bom quanto os outros em estudar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(204, 14, 2, 'Eu me sinto envergonhado por não conseguir explicar completamente o material para os outros.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(205, 14, 2, 'Eu me sinto envergonhado quando percebo que não tenho capacidade.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(206, 14, 2, 'Minhas lacunas de memória me envergonham.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(207, 14, 2, 'Porque tive tantas dificuldades com o material do curso, evito discutir sobre ele.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(208, 14, 2, 'Eu não quero que ninguém saiba quando não consegui entender algo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(209, 14, 2, 'Quando alguém percebe o quanto eu pouco entendo, evito contato visual.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(210, 14, 2, 'Eu fico vermelho quando não sei a resposta a uma pergunta relacionada ao material do curso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(211, 15, 2, 'Eu me sinto sem esperança quando penso em estudar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(212, 15, 2, 'Eu me sinto impotente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(213, 15, 2, 'Eu me sinto resignado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(214, 15, 2, 'Estou resignado ao fato de que não tenho capacidade para dominar este material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(215, 15, 2, 'Depois de estudar, estou resignado ao fato de que não tenho habilidade.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(216, 15, 2, 'Estou desencorajado pela ideia de que nunca aprenderei o material.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(217, 15, 2, 'Eu me preocupo porque minhas habilidades não são suficientes para meu curso de estudos.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(218, 15, 2, 'Eu me sinto tão impotente que não consigo dar o meu máximo nos estudos.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(219, 15, 2, 'Eu gostaria de poder desistir porque não consigo lidar com isso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(220, 15, 2, 'Minha falta de confiança me deixa exausto antes mesmo de começar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(221, 15, 2, 'Minha desesperança minou toda a minha energia.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(222, 16, 2, 'O material me entedia até a morte.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(223, 16, 2, 'Estudar para meus cursos me entedia.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(224, 16, 2, 'Estudar é chato e monótono.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(225, 16, 2, 'Enquanto estudo este material chato, passo o tempo pensando em como o tempo não passa.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(226, 16, 2, 'O material é tão chato que me pego sonhando acordado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(227, 16, 2, 'Eu percebo que minha mente divaga enquanto estudo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(228, 16, 2, 'Porque estou entediado, não tenho desejo de aprender.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(229, 16, 2, 'Eu preferiria deixar este trabalho chato para amanhã.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(230, 16, 2, 'Porque estou entediado, fico cansado sentado na minha mesa.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(231, 16, 2, 'O material me entedia tanto que me sinto exausto.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(232, 16, 2, 'Enquanto estudo, pareço me distrair porque é tão chato.');

--TEST RELATED
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(81, 17, 3, 'Eu me sinto ansioso quando vou à aula.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(82, 17, 3, 'Eu gosto de fazer a prova.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(83, 17, 3, 'Estou ansioso para demonstrar meu conhecimento.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(84, 17, 3, 'Fico feliz por conseguir lidar com o teste.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(85, 17, 3, 'Para mim, o teste é um desafio que é agradável.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(86, 17, 3, 'Porque gosto de me preparar para o teste, estou motivado a fazer mais do que é necessário.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(87, 17, 3, 'Porque estou ansioso para ter sucesso, estudo muito.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(88, 17, 3, 'Antes de fazer a prova, sinto uma sensação de expectativa.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(89, 17, 3, 'Meu coração bate mais rápido de alegria.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(90, 17, 3, 'Eu brilho de felicidade.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(91, 18, 3, 'Estou otimista de que tudo vai dar certo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(92, 18, 3, 'Estou muito confiante.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(93, 18, 3, 'Tenho grande esperança de que minhas habilidades serão suficientes.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(94, 18, 3, 'Estou bastante confiante de que minha preparação é suficiente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(95, 18, 3, 'Penso na minha prova de forma otimista.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(96, 18, 3, 'Começo a estudar para a prova com grande esperança e expectativa.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(97, 18, 3, 'Minha confiança me motiva a me preparar bem.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(98, 18, 3, 'Esperando ter sucesso, estou motivado a investir muito esforço.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(99, 19, 3, 'Estou muito satisfeito comigo mesmo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(100, 19, 3, 'Estou orgulhoso de mim mesmo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(101, 19, 3, 'Acho que posso me orgulhar do meu conhecimento.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(102, 19, 3, 'Pensar sobre meu sucesso me faz sentir orgulho.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(103, 19, 3, 'Estou orgulhoso de quão bem eu lidei com a prova.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(104, 19, 3, 'Estou tão orgulhoso da minha preparação que quero começar a prova agora.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(105, 19, 3, 'O orgulho pelo meu conhecimento alimenta meus esforços em fazer a prova.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(106, 19, 3, 'Quando recebo os resultados do teste, meu coração bate com orgulho.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(107, 19, 3, 'Depois da prova, me sinto como se estivesse mais alto porque estou tão orgulhoso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(108, 19, 3, 'Saio da prova com a aparência de um vencedor no meu rosto.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(109, 20, 3, 'Eu me sinto aliviado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(110, 20, 3, 'Eu me sinto livre.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(111, 20, 3, 'Eu me sinto muito aliviado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(112, 20, 3, 'A tensão no meu estômago está se dissipando.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(113, 20, 3, 'Finalmente posso respirar aliviado novamente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(114, 20, 3, 'Posso finalmente rir novamente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(115, 21, 3, 'Eu fico bravo.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(116, 21, 3, 'Eu estou bastante irritado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(117, 21, 3, 'Eu fico bravo com a pressão de tempo que não deixa tempo suficiente para me preparar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(118, 21, 3, 'Eu fico bravo com a quantidade de material que preciso saber.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(119, 21, 3, 'Eu acho as perguntas injustas.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(120, 21, 3, 'Fico bravo com os critérios de avaliação do professor.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(121, 21, 3, 'Eu gostaria de poder dizer isso ao professor.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(122, 21, 3, 'Eu gostaria de poder expressar minha raiva livremente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(123, 21, 3, 'Minha raiva faz meu sangue ferver.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(124, 21, 3, 'Eu fico tão bravo que começo a sentir calor e ruborizar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(125, 22, 3, 'Antes da prova, me sinto nervoso e inquieto.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(126, 22, 3, 'Estou muito nervoso.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(127, 22, 3, 'Eu me sinto em pânico ao escrever a prova.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(128, 22, 3, 'Eu me preocupo se estudei o suficiente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(129, 22, 3, 'Eu me preocupo se a prova será muito difícil.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(130, 22, 3, 'Eu me preocupo se vou passar na prova.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(131, 22, 3, 'Fico tão nervoso que gostaria de poder pular a prova.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(132, 22, 3, 'Fico tão nervoso que não consigo esperar que a prova acabe.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(133, 22, 3, 'Estou tão ansioso que preferiria estar em qualquer outro lugar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(134, 22, 3, 'Eu me sinto enjoado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(135, 22, 3, 'No início do teste, meu coração começa a disparar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(136, 22, 3, 'Minhas mãos ficam trêmulas.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(137, 23, 3, 'Eu me sinto humilhado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(138, 23, 3, 'Eu me sinto envergonhado.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(139, 23, 3, 'Não consigo nem pensar em como seria embaraçoso falhar na prova.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(140, 23, 3, 'Eu me envergonho da minha má preparação.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(141, 23, 3, 'Fico envergonhado porque não consigo responder corretamente às perguntas.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(142, 23, 3, 'Minhas notas me envergonham.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(143, 23, 3, 'Fico tão envergonhado que quero correr e me esconder.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(144, 23, 3, 'Quando recebo uma nota ruim, prefiro não enfrentar meu professor novamente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(145, 23, 3, 'Porque estou envergonhado, meu pulso acelera.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(146, 23, 3, 'Quando os outros descobrem sobre minhas notas ruins, começo a corar.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(147, 24, 3, 'Eu fico deprimido porque sinto que não tenho muita esperança para a prova.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(148, 24, 3, 'Eu me sinto sem esperança.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(149, 24, 3, 'Eu perdi toda a esperança de que tenho a habilidade de me sair bem na prova.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(150, 24, 3, 'Desisti de acreditar que posso responder as perguntas corretamente.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(151, 24, 3, 'Começo a pensar que, não importa o quanto eu tente, não terei sucesso no teste.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(152, 24, 3, 'Começo a perceber que as perguntas são muito difíceis para mim.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(153, 24, 3, 'Sinto-me tão resignado quanto à prova que não consigo começar a fazer nada.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(154, 24, 3, 'Preferiria não fazer a prova porque perdi toda a esperança.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(155, 24, 3, 'Sinto que quero desistir.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(156, 24, 3, 'Minha desesperança me rouba toda a minha energia.');
INSERT INTO mysql.mdl_ifcare_pergunta
(id, emocao_id, classeaeq_id, pergunta_texto)
VALUES(157, 24, 3, 'Eu me sinto tão resignado que não tenho energia.');

--Executar o cron manualmente
--php C:\moodle441\server\moodle\admin\cli\scheduled_task.php --execute=block_ifcare\task\process_coleta
