require(["jquery", "core/notification"], function ($, notification) {
  $(function () {
    $("form.mform").on("submit", function (e) {
      // Verifica se o botão de cancelar foi clicado
      if ($(document.activeElement).attr("name") === "cancel") {
        return true; // Permite que o formulário seja cancelado sem exibir a confirmação
      }
    
      // Previne o envio padrão do formulário para exibir a confirmação
      e.preventDefault();
    
        // Lê os dados da div com o id 'confirmation-data'
        var confirmTitle = document.getElementById('confirmation-data').getAttribute('data-title');
        var confirmMessage = document.getElementById('confirmation-data').getAttribute('data-message');
        var confirmButtonYes = document.getElementById('confirmation-data').getAttribute('data-yes');
        var confirmButtonNo = document.getElementById('confirmation-data').getAttribute('data-no');
        // Código do diálogo de confirmação
        notification.confirm(
            confirmTitle,  // Título da confirmação
            confirmMessage,  // Mensagem de confirmação
            confirmButtonYes,  // Texto do botão "Confirmar"
            confirmButtonNo,  // Texto do botão "Cancelar"
            function () {
                // Este código será executado se o usuário confirmar
                $("#setor").val($("#id_sectionid").val());
                $("#recurso").val($("#id_resourceid").val());
    
                // Limpa o localStorage da coleta atual antes de enviar
                window.studentcare.clearLocalStorage();
    
                // Reenvia o formulário após a confirmação
                $("form.mform").off("submit").submit();
            },
            function () {}
        );

    
    });
    

    $("#id_classe_aeq").change(function () {
      var classeAeqId = $(this).val();
      if (classeAeqId) {
        window.studentcare.loadEmotions(classeAeqId);
      }
    });

    var initialCourseid = $("#id_courseid").val();
    if (initialCourseid) {
      window.studentcare.loadSections(initialCourseid);
      window.studentcare.loadEmotions($("#id_classe_aeq").val());
    }
  });
});
