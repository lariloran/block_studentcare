require(['jquery'], function($) {
    var isFormSubmitted = false;
    var selecoes = {}; // Objeto para armazenar seleções de todas as classes AEQ

    // Função para habilitar ou desabilitar o botão de salvar
    function toggleSaveButton() {
        var selectedEmotions = $('#id_emocoes').val() || [];
        $('#id_save').prop('disabled', selectedEmotions.length === 0); // Habilita se houver emoções selecionadas
    }

    // Função para carregar emoções com base na classe AEQ selecionada
    function loadEmotions(classeAeqId) {
        if (classeAeqId) {
            $.ajax({
                url: M.cfg.wwwroot + '/blocks/ifcare/get_emotions.php',
                method: 'GET',
                data: { classeaeqid: classeAeqId },
                success: function(response) {
                    var emotions = JSON.parse(response).emotions;

                    $('#id_emocoes').empty();

                    if (Array.isArray(emotions) && emotions.length > 0) {
                        emotions.forEach(function(emotion) {
                            $('#id_emocoes').append($('<option>', {
                                value: emotion.value,
                                text: emotion.name
                            }));
                        });

                        // Carregar emoções previamente selecionadas para a classe AEQ atual
                        if (classeAeqId in selecoes) {
                            $('#id_emocoes').val(selecoes[classeAeqId]);
                        }
                    } else {
                        $('#id_emocoes').append($('<option>', {
                            value: '',
                            text: 'Nenhuma emoção disponível'
                        }));
                    }

                    updateSelectedEmotions();
                },
                error: function() {
                    console.error('Erro ao carregar as emoções.');
                    $('#id_emocoes').empty().append($('<option>', {
                        value: '',
                        text: 'Erro ao carregar emoções'
                    }));
                }
            });
        }
    }

    // Atualiza o campo de emoções selecionadas para a classe AEQ atual e exibe o resumo em balões
    function updateSelectedEmotions() {
        var classeAeqId = $('#id_classe_aeq').val();
        if (classeAeqId) {
            var selectedEmotions = $('#id_emocoes').val() || [];
            selecoes[classeAeqId] = selectedEmotions;

            $('#emocao_selecionadas').val(JSON.stringify(selecoes));

            renderSelectedEmotions();
            toggleSaveButton(); // Atualiza o botão de salvar
        }
    }

    // Função para renderizar as emoções selecionadas como balões
    function renderSelectedEmotions() {
        var emotionContainer = $('#emocoes-selecionadas');
        emotionContainer.empty(); // Limpa os balões existentes

        Object.keys(selecoes).forEach(function(classeId) {
            var emocoes = selecoes[classeId];
            emocoes.forEach(function(emocaoId) {
                var emotionName = $('#id_emocoes option[value="' + emocaoId + '"]').text(); // Pega o texto do select correto

                if (emotionName) {
                    // Cria um novo balão
                    var tag = $('<div>').addClass('emotion-tag').text(emotionName);
                    var closeButton = $('<span>').addClass('close-btn').text('×');

                    // Adiciona o botão de fechar ao balão
                    closeButton.on('click', function() {
                        // Remove a emoção da seleção
                        selecoes[classeId] = selecoes[classeId].filter(function(e) {
                            return e !== emocaoId;
                        });

                        // Atualiza a seleção no campo oculto e no UI
                        $('#id_emocoes').val(selecoes[classeId]);
                        $('#emocao_selecionadas').val(JSON.stringify(selecoes));
                        renderSelectedEmotions();
                    });

                    tag.append(closeButton);
                    emotionContainer.append(tag);
                }
            });
        });
    }

    require(['core/notification'], function(notification) {
        // Quando o usuário clicar no botão de salvar
        $('form.mform').on('submit', function(e) {
            e.preventDefault(); // Previne o envio imediato do formulário

            // Mostra o diálogo de confirmação
            notification.confirm(
                'Confirmação', // Título do diálogo
                'Está pronto para salvar esta coleta de emoções?', // Mensagem de confirmação
                'Confirmar', // Texto do botão de confirmação
                'Cancelar', // Texto do botão de cancelamento
                function() { // Função a ser executada se o usuário confirmar
                    $('#setor').val($('#id_sectionid').val());
                    $('#recurso').val($('#id_resourceid').val());
                    $('form.mform').off('submit').submit(); // Envia o formulário
                },
                function() { // Função a ser executada se o usuário cancelar
                    // Pode deixar vazio ou realizar alguma ação adicional
                }
            );
        });
    });


    // Eventos para atualizar campos
    $('#id_emocoes').change(updateSelectedEmotions);

    $('#id_classe_aeq').change(function() {
        var classeAeqId = $(this).val();
        if (classeAeqId) {
            loadEmotions(classeAeqId);
        }
    });

    toggleSaveButton();

    function loadSections(courseid) {
        if (courseid) {
            $.ajax({
                url: M.cfg.wwwroot + '/blocks/ifcare/get_sections.php',
                method: 'GET',
                data: { courseid: courseid },
                success: function(response) {
                    var sections = JSON.parse(response);
                    
                    if (Array.isArray(sections.sections) && sections.sections.length > 0) {
                        $('#id_sectionid').empty();

                        // Adiciona as seções ao select
                        sections.sections.forEach(function(section) {
                            $('#id_sectionid').append($('<option>', {
                                value: section.value,
                                text: section.name
                            }));
                        });

                        // Define o valor da primeira seção
                        var firstSectionId = sections.sections[0].value;
                        var sectionid = sections.sections[0].value;
                        $('#id_sectionid').val(firstSectionId);
                            $.ajax({
                                url: M.cfg.wwwroot + '/blocks/ifcare/get_resources.php',
                                method: 'GET',
                                data: { courseid: courseid, sectionid: sectionid },
                                success: function(response) {
                                    var resources = JSON.parse(response);
                
                                    // Limpa o campo e adiciona as novas opções
                                    $('#id_resourceid').empty();
                
                                    // Verifica se resources.resources é um array antes de tentar usar forEach
                                    if (Array.isArray(resources.resources) && resources.resources.length > 0) {
                                        // Adiciona as opções de recursos
                                        resources.resources.forEach(function(resource) {
                                            $('#id_resourceid').append($('<option>', {
                                                value: resource.value,
                                                text: resource.name
                                            }));
                                        });
                
                                        // Define o valor do primeiro recurso
                                        var firstResourceId = resources.resources[0].value;
                                        $('#id_resourceid').val(firstResourceId);
                                    } else {
                                        // Caso não haja recursos, adiciona uma opção vazia
                                        $('#id_resourceid').append($('<option>', {
                                            value: '',
                                            text: 'Nenhum recurso disponível'
                                        }));
                                    }
                                },
                                error: function() {
                                    console.error("Erro ao carregar os recursos.");
                                    $('#id_resourceid').empty().append($('<option>', {
                                        value: '',
                                        text: 'Erro ao carregar recursos'
                                    }));
                                }
                            });
    
                    } else {
                        $('#id_sectionid').empty().append($('<option>', {
                            value: '',
                            text: 'Nenhuma seção disponível'
                        }));
                        $('#id_resourceid').empty().append($('<option>', {
                            value: '',
                            text: 'Nenhum recurso disponível'
                        }));
                    }
                },
                error: function() {
                    console.error("Erro ao carregar as seções.");
                    $('#id_sectionid').empty().append($('<option>', {
                        value: '',
                        text: 'Erro ao carregar seções'
                    }));
                    $('#id_resourceid').empty().append($('<option>', {
                        value: '',
                        text: 'Erro ao carregar recursos'
                    }));
                }
            });
        }
    }

    function loadResources(courseid, sectionid) {
        if (courseid && sectionid) {
            $.ajax({
                url: M.cfg.wwwroot + '/blocks/ifcare/get_resources.php',
                method: 'GET',
                data: { courseid: courseid, sectionid: sectionid },
                success: function(response) {
                    var resources = JSON.parse(response);

                    // Limpa o campo e adiciona as novas opções
                    $('#id_resourceid').empty();

                    // Verifica se resources.resources é um array antes de tentar usar forEach
                    if (Array.isArray(resources.resources) && resources.resources.length > 0) {
                        // Adiciona as opções de recursos
                        resources.resources.forEach(function(resource) {
                            $('#id_resourceid').append($('<option>', {
                                value: resource.value,
                                text: resource.name
                            }));
                        });

                        // Define o valor do primeiro recurso
                        var firstResourceId = resources.resources[0].value;
                        $('#id_resourceid').val(firstResourceId);
                    } else {
                        // Caso não haja recursos, adiciona uma opção vazia
                        $('#id_resourceid').append($('<option>', {
                            value: '',
                            text: 'Nenhum recurso disponível'
                        }));
                    }
                },
                error: function() {
                    console.error("Erro ao carregar os recursos.");
                    $('#id_resourceid').empty().append($('<option>', {
                        value: '',
                        text: 'Erro ao carregar recursos'
                    }));
                }
            });
        } else {
            // Limpa o select de recursos se não houver seção válida
            $('#id_resourceid').empty().append($('<option>', {
                value: '',
                text: 'Nenhum recurso disponível'
            }));
        }
    }

    // Ao mudar o curso, carrega as seções e depois carrega os recursos da primeira seção automaticamente
    $('#id_courseid').change(function() {
        var courseid = $(this).val();
        if (courseid) {
            loadSections(courseid);
        }
    });

    // Ao mudar a seção, carrega os recursos correspondentes automaticamente
    $('#id_sectionid').change(function() {
        var courseid = $('#id_courseid').val();
        var sectionid = $(this).val();
        loadResources(courseid, sectionid);
    });

    // Carrega as seções e recursos automaticamente quando o formulário é carregado com um curso inicial
    var initialCourseid = $('#id_courseid').val();
    if (initialCourseid) {
        loadSections(initialCourseid);
        loadEmotions($('#id_classe_aeq').val());

    }
});
