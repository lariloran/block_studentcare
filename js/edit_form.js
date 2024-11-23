require(["jquery", "core/notification"], function ($, notification) {
  $(function () {
    // Atualiza as emoções no select múltiplo e no resumo
    function loadAllSelections() {
      const storedSelections = window.ifcare.getFromLocalStorage();
      window.ifcare.renderResumo();

      // Preenche o campo oculto com as seleções armazenadas
      $("#emocao_selecionadas").val(JSON.stringify(storedSelections));
    }

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
      const classeAeqId = $(this).val();
      if (classeAeqId) {
        window.ifcare.loadEmotionsEdit(classeAeqId);
      }
    });

    // Carrega as emoções da classe selecionada e o resumo
    const initialCourseid = $("#id_courseid").val();
    if (initialCourseid) {
      window.ifcare.loadEmotionsEdit($("#id_classe_aeq").val());
      loadAllSelections();
    }
  });
});
