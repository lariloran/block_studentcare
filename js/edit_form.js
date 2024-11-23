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
        "Deseja alterar as informações desta coleta de emoções?",
        "Confirmar",
        "Cancelar",
        function () {
          $("#setor").val($("#id_sectionid").val());
          $("#recurso").val($("#id_resourceid").val());
          $("form.mform").off("submit").submit(); // Reenvia o formulário após a confirmação
        },
        function () {
          // Ação ao cancelar no diálogo de confirmação (nada necessário aqui)
        }
      );
    });

    $("#id_classe_aeq").change(function () {
      var classeAeqId = $(this).val();
      if (classeAeqId) {
        window.ifcare.loadEmotionsEdit(classeAeqId);
      }
    });

    var initialCourseid = $("#id_courseid").val();
    if (initialCourseid) {
      window.ifcare.loadEmotionsEdit($("#id_classe_aeq").val());
    }
  });
});
