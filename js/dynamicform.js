$(document).ready(function() {
    // Função para carregar seções com base no curso selecionado
    function loadSections(courseid) {
        if (courseid) {
            $.ajax({
                url: M.cfg.wwwroot + '/blocks/ifcare/get_sections.php',
                method: 'GET',
                data: { courseid: courseid },
                success: function(response) {
                    console.log(response); // Verifica o que está sendo retornado
                    var sections = JSON.parse(response); // Faz o parse do JSON
                    $('#id_sectionid').html(sections.sections).trigger('change'); // Carrega as seções
                    
                    // Carrega as atividades/recursos com base na primeira seção
                    var firstSection = $('#id_sectionid').val();
                    loadResources(courseid, firstSection);
                }
            });
        }
    }

    // Função para carregar recursos com base no curso e seção selecionada
    function loadResources(courseid, sectionid) {
        if (sectionid) {
            $.ajax({
                url: M.cfg.wwwroot + '/blocks/ifcare/get_resources.php',
                method: 'GET',
                data: { courseid: courseid, sectionid: sectionid },
                success: function(response) {
                    console.log(response); // Verifica o que está sendo retornado
                    var resources = JSON.parse(response); // Faz o parse do JSON
                    $('#id_resourceid').html(resources.resources); // Carrega os recursos
                }
            });
        }
    }

    // Quando o curso for selecionado
    $('#id_courseid').change(function() {
        var courseid = $(this).val();
        $('#id_sectionid').empty();
        $('#id_resourceid').empty();
        loadSections(courseid);
    });

    // Quando uma seção for selecionada
    $('#id_sectionid').change(function() {
        var courseid = $('#id_courseid').val();
        var sectionid = $(this).val();
        loadResources(courseid, sectionid);
    });

    // Carrega automaticamente as seções e recursos quando o formulário é carregado
    var initialCourseid = $('#id_courseid').val();
    if (initialCourseid) {
        loadSections(initialCourseid);
    }
});
