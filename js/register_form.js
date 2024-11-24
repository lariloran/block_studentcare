require(["jquery", "core/notification"], function ($, notification) {
  $(function () {
    $("form.mform").on("submit", function (e) {
      // Verifica se o botão de cancelar foi clicado
      if ($(document.activeElement).attr("name") === "cancel") {
        return true; // Permite que o formulário seja cancelado sem exibir a confirmação
      }
    
      // Previne o envio padrão do formulário para exibir a confirmação
      e.preventDefault();
    
      notification.confirm(
        "Confirmação",
        "Deseja salvar as informações desta coleta de emoções?",
        "Confirmar",
        "Cancelar",
        function () {
          // Este código só será executado se o usuário confirmar
          $("#setor").val($("#id_sectionid").val());
          $("#recurso").val($("#id_resourceid").val());
    
          // Limpa o localStorage da coleta atual antes de enviar
          window.ifcare.clearLocalStorage();
    
          // Reenvia o formulário após a confirmação
          $("form.mform").off("submit").submit();
        },
        function () {
          // Ação ao cancelar no diálogo de confirmação (nada necessário aqui)
        }
      );
    });
    

    $("#id_classe_aeq").change(function () {
      var classeAeqId = $(this).val();
      if (classeAeqId) {
        window.ifcare.loadEmotions(classeAeqId);
      }
    });

    var initialCourseid = $("#id_courseid").val();
    if (initialCourseid) {
      window.ifcare.loadSections(initialCourseid);
      window.ifcare.loadEmotions($("#id_classe_aeq").val());
    }
  });
});
