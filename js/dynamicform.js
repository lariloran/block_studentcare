$(document).ready(function() {
    function loadSections(courseid) {
        if (courseid) {
            $.ajax({
                url: M.cfg.wwwroot + '/blocks/ifcare/get_sections.php',
                method: 'GET',
                data: { courseid: courseid },
                success: function(response) {
                    console.log("Seções carregadas:", response);
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
                                    console.log("Recursos carregados:", response);
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
                    console.log("Recursos carregados:", response);
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
    }
});
