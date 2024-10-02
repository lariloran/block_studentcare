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
INSERT INTO mdl_ifcare_emocao (classeaeq_id, nome, antes, durante, depois) VALUES
    (1, 'Prazer', 1, 1, 1),
    (1, 'Esperança', 1, 1, 1),
    (1, 'Orgulho', 1, 1, 1),
    (1, 'Raiva', 1, 1, 1),
    (1, 'Ansiedade', 1, 1, 1),
    (1, 'Vergonha', 1, 1, 1),
    (1, 'Desespero', 1, 1, 1),
    (1, 'Tédio', 1, 1, 1),

    (2, 'Prazer', 1, 1, 1),
    (2, 'Esperança', 1, 1, 1),
    (2, 'Orgulho', 1, 1, 1),
    (2, 'Raiva', 1, 1, 1),
    (2, 'Ansiedade', 1, 1, 1),
    (2, 'Vergonha', 1, 1, 1),
    (2, 'Desespero', 1, 1, 1),
    (2, 'Tédio', 1, 1, 1),

    (3, 'Prazer', 1, 1, 1),
    (3, 'Esperança', 1, 1, 1),
    (3, 'Orgulho', 1, 1, 1),
    (3, 'Alívio', 1, 1, 1),
    (3, 'Raiva', 1, 1, 1),
    (3, 'Ansiedade', 1, 1, 1),
    (3, 'Vergonha', 1, 1, 1),
    (3, 'Desespero', 1, 1, 1),
    (3, 'Tédio', 1, 1, 1);


--CLASS RELATED
INSERT INTO mdl_ifcare_pergunta (emocao_id, classeaeq_id, pergunta_texto) VALUES  
    (2, 1, 'Estou confiante quando vou à aula.'),                     
    (2, 1, 'Estou cheio(a) de esperança.'),                           
    (2, 1, 'Estou otimista de que conseguirei acompanhar o material.'),  
    (2, 1, 'Estou esperançoso(a) de que farei boas contribuições na aula.'),  
    (2, 1, 'Estou confiante porque entendo o material.'),              
    (2, 1, 'Estar confiante de que entenderei o material me motiva.'), 
    (2, 1, 'Minha confiança me motiva a me preparar para a aula.'),   
    (2, 1, 'Minhas esperanças de que terei sucesso me motivam a investir muito esforço.'),  
    
    
    (3, 1, 'Tenho orgulho de mim mesmo(a).'),                          
    (3, 1, 'Tenho orgulho de conseguir acompanhar o material.'),       
    (3, 1, 'Tenho orgulho de fazer melhor do que os outros neste curso.'),  
    (3, 1, 'Acho que posso ter orgulho do que sei sobre este assunto.'),  
    (3, 1, 'Estou orgulhoso(a) das contribuições que fiz na aula.'),   
    (3, 1, 'Quando faço boas contribuições na aula, fico ainda mais motivado(a).'),  
    (3, 1, 'Porque tenho orgulho das minhas conquistas neste curso, estou motivado(a) a continuar.'),  
    (3, 1, 'Gostaria de contar aos meus amigos sobre como me saí bem neste curso.'),  
    (3, 1, 'Quando me saio bem na aula, meu coração se enche de orgulho.'),  
    
    
    (4, 1, 'Sinto-me frustrado(a) na aula.'),                          
    (4, 1, 'Estou com raiva.'),                                        
    (4, 1, 'Pensar na baixa qualidade do curso me deixa irritado(a).'),  
    (4, 1, 'Pensar em todas as coisas inúteis que tenho que aprender me irrita.'),  
    (4, 1, 'Quando penso no tempo que perco na aula, fico agitado(a).'),  
    (4, 1, 'Eu gostaria de não ter que ir à aula porque isso me deixa com raiva.'),  
    (4, 1, 'Eu gostaria de poder dizer aos professores o que penso.'),   
    (4, 1, 'Sinto a raiva crescendo dentro de mim.'),                   
    (4, 1, 'Porque estou com raiva, fico inquieto(a) na aula.'),        
    
    
    (5, 1, 'Pensar na aula me deixa inquieto(a).'),                     
    (5, 1, 'Sinto medo.'),                                             
    (5, 1, 'Sinto-me nervoso(a) na aula.'),                             
    (5, 1, 'Mesmo antes da aula, me preocupo se conseguirei entender o material.'),  
    (5, 1, 'Me preocupo se estou suficientemente preparado(a) para a lição.'),  
    (5, 1, 'Me preocupo se as exigências podem ser grandes demais.'),   
    (5, 1, 'Me preocupo que os outros entenderão mais do que eu.'),    
    (5, 1, 'Porque estou tão nervoso(a), prefiro pular a aula.'),       
    (5, 1, 'Tenho medo de que possa dizer algo errado, então prefiro não dizer nada.'),  
    (5, 1, 'Quando penso na aula, fico enjoado(a).'),                   
    (5, 1, 'Fico tenso(a) na aula.'),                                   
    (5, 1, 'Quando não entendo algo importante na aula, meu coração acelera.'),  
    
    
    
    (6, 1, 'Fico envergonhado(a).'),                                   
    (6, 1, 'Estou envergonhado(a).'),                                  
    (6, 1, 'Se os outros soubessem que não entendo o material, ficaria envergonhado(a).'),  
    (6, 1, 'Quando digo algo na aula, sinto que estou me fazendo de tolo(a).'),  
    (6, 1, 'Estou envergonhado(a) por não conseguir me expressar bem.'),  
    (6, 1, 'Estou envergonhado(a) porque os outros entenderam mais da palestra do que eu.'),  
    (6, 1, 'Depois que digo algo na aula, gostaria de poder me esconder.'),  
    (6, 1, 'Preferiria não contar a ninguém quando não entendo algo na aula.'),  
    (6, 1, 'Quando digo algo na aula, sinto que fico vermelho(a).'),     
    (6, 1, 'Porque fico envergonhado(a), fico tenso(a) e inibido(a).'),  
    (6, 1, 'Quando falo na aula, começo a gaguejar.'),                  
    
    
    (7, 1, 'O pensamento desta aula me faz sentir desamparado(a).'),   
    (7, 1, 'Sinto-me desamparado(a).'),                                 
    (7, 1, 'Mesmo antes da aula, estou resignado(a) à ideia de que não conseguirei entender o material.'),  
    (7, 1, 'Perdi toda a esperança de entender esta aula.'),            
    (7, 1, 'Sinto-me desamparado(a) para continuar neste programa de estudos.'),  
    (7, 1, 'Porque desisti, não tenho energia para ir à aula.'),        
    (7, 1, 'Preferiria não ir à aula, pois não há esperança de entender o material de qualquer forma.'),  
    (7, 1, 'É inútil me preparar para a aula, já que não entendo o material de qualquer forma.'),  
    (7, 1, 'Porque não entendo o material, pareço desconectado(a) e resignado(a).'),  
    (7, 1, 'Sinto-me tão desamparado(a) que toda a minha energia se esgota.'),  
    
    
    (8, 1, 'Fico entediado(a).'),                                      
    (8, 1, 'Acho esta aula bastante maçante.'),                         
    (8, 1, 'A palestra me entedia.'),                                   
    (8, 1, 'Porque fico entediado(a), minha mente começa a vagar.'),   
    (8, 1, 'Estou tentado(a) a sair da palestra porque é tão chata.'),  
    (8, 1, 'Penso em outras coisas que poderia estar fazendo em vez de estar sentado(a) nesta aula chata.'),  
    (8, 1, 'Como o tempo se arrasta, olho frequentemente para o meu relógio.'),  
    (8, 1, 'Fico tão entediado(a) que tenho problemas para ficar alerta.'),  
    (8, 1, 'Fico inquieto(a) porque não posso esperar para que a aula termine.'),  
    (8, 1, 'Durante a aula, sinto que poderia afundar na minha cadeira.'),  
    (8, 1, 'Começo a bocejar na aula porque estou tão entediado(a).');  

    --LEARNING RELATED
    INSERT INTO mdl_ifcare_pergunta (emocao_id, classeaeq_id, pergunta_texto) VALUES
    (9, 2, 'Estou ansioso para estudar.'),
    (9, 2, 'Eu gosto do desafio de aprender o material.'),
    (9, 2, 'Eu gosto de adquirir novos conhecimentos.'),
    (9, 2, 'Eu gosto de lidar com o material do curso.'),
    (9, 2, 'Refletir sobre meu progresso nos estudos me deixa feliz.'),
    (9, 2, 'Eu estudo mais do que o necessário porque gosto muito.'),
    (9, 2, 'Estou tão feliz com o progresso que fiz que estou motivado a continuar estudando.'),
    (9, 2, 'Certas matérias são tão agradáveis que estou motivado a fazer leituras adicionais sobre elas.'),
    (9, 2, 'Quando meus estudos vão bem, isso me dá uma empolgação.'),
    (9, 2, 'Fico fisicamente animado quando meus estudos vão bem.'),
    (10, 2, 'Eu tenho uma visão otimista em relação ao estudo.'),
    (10, 2, 'Eu me sinto confiante ao estudar.'),
    (10, 2, 'Eu me sinto confiante de que serei capaz de dominar o material.'),
    (10, 2, 'Sinto-me otimista de que farei bons progressos nos estudos.'),
    (10, 2, 'O pensamento de alcançar meus objetivos de aprendizado me inspira.'),
    (10, 2, 'Meu senso de confiança me motiva.'),
    (10, 2, 'Estou orgulhoso de mim mesmo.'),
    (11, 2, 'Estou orgulhoso da minha capacidade.'),
    (11, 2, 'Acho que posso me orgulhar das minhas conquistas nos estudos.'),
    (11, 2, 'Porque quero me orgulhar das minhas conquistas, estou muito motivado.'),
    (11, 2, 'Quando resolvo um problema difícil nos meus estudos, meu coração bate de orgulho.'),
    (11, 2, 'Quando me destaco no meu trabalho, fico cheio de orgulho.'),
    (12, 2, 'Fico com raiva quando tenho que estudar.'),
    (12, 2, 'Estudar me irrita.'),
    (12, 2, 'Fico com raiva enquanto estudo.'),
    (12, 2, 'Estou irritado por ter que estudar tanto.'),
    (12, 2, 'Fico incomodado por ter que estudar.'),
    (12, 2, 'Porque fico tão chateado com a quantidade de material, não quero nem começar a estudar.'),
    (12, 2, 'Fico tão bravo que sinto vontade de jogar o livro didático pela janela.'),
    (12, 2, 'Quando fico muito tempo sentado na minha mesa, minha irritação me deixa inquieto.'),
    (12, 2, 'Depois de estudar por um longo período, fico tão irritado que fico tenso.'),
    (13, 2, 'Quando olho para os livros que ainda tenho que ler, fico ansioso.'),
    (13, 2, 'Fico tenso e nervoso enquanto estudo.'),
    (13, 2, 'Quando não consigo acompanhar meus estudos, isso me deixa com medo.'),
    (13, 2, 'Eu me preocupo se serei capaz de lidar com todo o meu trabalho.'),
    (13, 2, 'O assunto me assusta, pois não o compreendo completamente.'),
    (13, 2, 'Eu me preocupo se entendi o material corretamente.'),
    (13, 2, 'Fico tão nervoso que nem quero começar a estudar.'),
    (13, 2, 'Enquanto estudo, sinto vontade de me distrair para reduzir minha ansiedade.'),
    (13, 2, 'Quando tenho que estudar, começo a me sentir enjoado.'),
    (13, 2, 'À medida que o tempo acaba, meu coração começa a acelerar.'),
    (13, 2, 'A preocupação em não completar o material me faz suar.'),
    (14, 2, 'Eu me sinto envergonhado.'),
    (14, 2, 'Eu me sinto envergonhado pela minha constante procrastinação.'),
    (14, 2, 'Eu me sinto envergonhado por não conseguir absorver os detalhes mais simples.'),
    (14, 2, 'Eu me sinto envergonhado porque não sou tão bom quanto os outros em estudar.'),
    (14, 2, 'Eu me sinto envergonhado por não conseguir explicar completamente o material para os outros.'),
    (14, 2, 'Eu me sinto envergonhado quando percebo que não tenho capacidade.'),
    (14, 2, 'Minhas lacunas de memória me envergonham.'),
    (14, 2, 'Porque tive tantas dificuldades com o material do curso, evito discutir sobre ele.'),
    (14, 2, 'Eu não quero que ninguém saiba quando não consegui entender algo.'),
    (14, 2, 'Quando alguém percebe o quanto eu pouco entendo, evito contato visual.'),
    (14, 2, 'Eu fico vermelho quando não sei a resposta a uma pergunta relacionada ao material do curso.'),
    (15, 2, 'Eu me sinto sem esperança quando penso em estudar.'),
    (15, 2, 'Eu me sinto impotente.'),
    (15, 2, 'Eu me sinto resignado.'),
    (15, 2, 'Estou resignado ao fato de que não tenho capacidade para dominar este material.'),
    (15, 2, 'Depois de estudar, estou resignado ao fato de que não tenho habilidade.'),
    (15, 2, 'Estou desencorajado pela ideia de que nunca aprenderei o material.'),
    (15, 2, 'Eu me preocupo porque minhas habilidades não são suficientes para meu curso de estudos.'),
    (15, 2, 'Eu me sinto tão impotente que não consigo dar o meu máximo nos estudos.'),
    (15, 2, 'Eu gostaria de poder desistir porque não consigo lidar com isso.'),
    (15, 2, 'Minha falta de confiança me deixa exausto antes mesmo de começar.'),
    (15, 2, 'Minha desesperança minou toda a minha energia.'),
    (16, 2, 'O material me entedia até a morte.'),
    (16, 2, 'Estudar para meus cursos me entedia.'),
    (16, 2, 'Estudar é chato e monótono.'),
    (16, 2, 'Enquanto estudo este material chato, passo o tempo pensando em como o tempo não passa.'),
    (16, 2, 'O material é tão chato que me pego sonhando acordado.'),
    (16, 2, 'Eu percebo que minha mente divaga enquanto estudo.'),
    (16, 2, 'Porque estou entediado, não tenho desejo de aprender.'),
    (16, 2, 'Eu preferiria deixar este trabalho chato para amanhã.'),
    (16, 2, 'Porque estou entediado, fico cansado sentado na minha mesa.'),
    (16, 2, 'O material me entedia tanto que me sinto exausto.'),
    (16, 2, 'Enquanto estudo, pareço me distrair porque é tão chato.');


    --TEST RELATED

    INSERT INTO mdl_ifcare_pergunta (emocao_id, classeaeq_id, pergunta_texto) VALUES
    (17, 3, 'Eu me sinto ansioso quando vou à aula.'),                    
    (17, 3, 'Eu gosto de fazer a prova.'),                                
    (17, 3, 'Estou ansioso para demonstrar meu conhecimento.'),           
    (17, 3, 'Fico feliz por conseguir lidar com o teste.'),               
    (17, 3, 'Para mim, o teste é um desafio que é agradável.'),           
    (17, 3, 'Porque gosto de me preparar para o teste, estou motivado a fazer mais do que é necessário.'), 
    (17, 3, 'Porque estou ansioso para ter sucesso, estudo muito.'),      
    (17, 3, 'Antes de fazer a prova, sinto uma sensação de expectativa.'),
    (17, 3, 'Meu coração bate mais rápido de alegria.'),                  
    (17, 3, 'Eu brilho de felicidade.'),                                  
    (18, 3, 'Estou otimista de que tudo vai dar certo.'),                 
    (18, 3, 'Estou muito confiante.'),                                   
    (18, 3, 'Tenho grande esperança de que minhas habilidades serão suficientes.'), 
    (18, 3, 'Estou bastante confiante de que minha preparação é suficiente.'), 
    (18, 3, 'Penso na minha prova de forma otimista.'),                   
    (18, 3, 'Começo a estudar para a prova com grande esperança e expectativa.'), 
    (18, 3, 'Minha confiança me motiva a me preparar bem.'),              
    (18, 3, 'Esperando ter sucesso, estou motivado a investir muito esforço.'), 
    (19, 3, 'Estou muito satisfeito comigo mesmo.'),                      
    (19, 3, 'Estou orgulhoso de mim mesmo.'),                             
    (19, 3, 'Acho que posso me orgulhar do meu conhecimento.'),           
    (19, 3, 'Pensar sobre meu sucesso me faz sentir orgulho.'),           
    (19, 3, 'Estou orgulhoso de quão bem eu lidei com a prova.'),         
    (19, 3, 'Estou tão orgulhoso da minha preparação que quero começar a prova agora.'), 
    (19, 3, 'O orgulho pelo meu conhecimento alimenta meus esforços em fazer a prova.'), 
    (19, 3, 'Quando recebo os resultados do teste, meu coração bate com orgulho.'), 
    (19, 3, 'Depois da prova, me sinto como se estivesse mais alto porque estou tão orgulhoso.'), 
    (19, 3, 'Saio da prova com a aparência de um vencedor no meu rosto.'), 
    (20, 3, 'Eu me sinto aliviado.'),                                     
    (20, 3, 'Eu me sinto livre.'),                                        
    (20, 3, 'Eu me sinto muito aliviado.'),                               
    (20, 3, 'A tensão no meu estômago está se dissipando.'),              
    (20, 3, 'Finalmente posso respirar aliviado novamente.'),             
    (20, 3, 'Posso finalmente rir novamente.'),                           
    (21, 3, 'Eu fico bravo.'),                                            
    (21, 3, 'Eu estou bastante irritado.'),                               
    (21, 3, 'Eu fico bravo com a pressão de tempo que não deixa tempo suficiente para me preparar.'), 
    (21, 3, 'Eu fico bravo com a quantidade de material que preciso saber.'), 
    (21, 3, 'Eu acho as perguntas injustas.'),                            
    (21, 3, 'Fico bravo com os critérios de avaliação do professor.'),    
    (21, 3, 'Eu gostaria de poder dizer isso ao professor.'),             
    (21, 3, 'Eu gostaria de poder expressar minha raiva livremente.'),    
    (21, 3, 'Minha raiva faz meu sangue ferver.'),                        
    (21, 3, 'Eu fico tão bravo que começo a sentir calor e ruborizar.'),  
    (22, 3, 'Antes da prova, me sinto nervoso e inquieto.'),              
    (22, 3, 'Estou muito nervoso.'),                                      
    (22, 3, 'Eu me sinto em pânico ao escrever a prova.'),                
    (22, 3, 'Eu me preocupo se estudei o suficiente.'),                   
    (22, 3, 'Eu me preocupo se a prova será muito difícil.'),             
    (22, 3, 'Eu me preocupo se vou passar na prova.'),                    
    (22, 3, 'Fico tão nervoso que gostaria de poder pular a prova.'),     
    (22, 3, 'Fico tão nervoso que não consigo esperar que a prova acabe.'), 
    (22, 3, 'Estou tão ansioso que preferiria estar em qualquer outro lugar.'), 
    (22, 3, 'Eu me sinto enjoado.'),                                      
    (22, 3, 'No início do teste, meu coração começa a disparar.'),        
    (22, 3, 'Minhas mãos ficam trêmulas.'),                               
    (23, 3, 'Eu me sinto humilhado.'),                                    
    (23, 3, 'Eu me sinto envergonhado.'),                                 
    (23, 3, 'Não consigo nem pensar em como seria embaraçoso falhar na prova.'), 
    (23, 3, 'Eu me envergonho da minha má preparação.'),                  
    (23, 3, 'Fico envergonhado porque não consigo responder corretamente às perguntas.'), 
    (23, 3, 'Minhas notas me envergonham.'),                              
    (23, 3, 'Fico tão envergonhado que quero correr e me esconder.'),     
    (23, 3, 'Quando recebo uma nota ruim, prefiro não enfrentar meu professor novamente.'), 
    (23, 3, 'Porque estou envergonhado, meu pulso acelera.'),             
    (23, 3, 'Quando os outros descobrem sobre minhas notas ruins, começo a corar.'), 
    (24, 3, 'Eu fico deprimido porque sinto que não tenho muita esperança para a prova.'), 
    (24, 3, 'Eu me sinto sem esperança.'),                                
    (24, 3, 'Eu perdi toda a esperança de que tenho a habilidade de me sair bem na prova.'), 
    (24, 3, 'Desisti de acreditar que posso responder as perguntas corretamente.'), 
    (24, 3, 'Começo a pensar que, não importa o quanto eu tente, não terei sucesso no teste.'), 
    (24, 3, 'Começo a perceber que as perguntas são muito difíceis para mim.'), 
    (24, 3, 'Sinto-me tão resignado quanto à prova que não consigo começar a fazer nada.'), 
    (24, 3, 'Preferiria não fazer a prova porque perdi toda a esperança.'), 
    (24, 3, 'Sinto que quero desistir.'),                                 
    (24, 3, 'Minha desesperança me rouba toda a minha energia.'),         
    (24, 3, 'Eu me sinto tão resignado que não tenho energia.');         

