require(["jquery", "core/notification"], function ($, notification) {
  $(function () {
      // Carregar seleções iniciais do campo oculto e salvar no localStorage
      function loadInitialSelections() {
          const storedSelections = JSON.parse($("#emocao_associadas").val() || "{}");
          Object.keys(storedSelections).forEach(function (classeId) {
              window.studentcare.saveToLocalStorage(classeId, storedSelections[classeId]);
          });
          window.studentcare.renderResumo();
      }

      // Atualiza as emoções no select múltiplo e no resumo
      function loadAllSelections() {
          const storedSelections = window.studentcare.getFromLocalStorage();
          window.studentcare.renderResumo();

          // Preenche o campo oculto com as seleções armazenadas
          $("#emocao_associadas").val(JSON.stringify(storedSelections));
      }

      // Inicialização
      loadInitialSelections();

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
                  // Este código só será executado se o usuário confirmar
                  $("#setor").val($("#id_sectionid").val());
                  $("#recurso").val($("#id_resourceid").val());

                  // Limpa o localStorage da coleta atual antes de enviar
                  window.studentcare.clearLocalStorage();

                  // Reenvia o formulário após a confirmação
                  $("form.mform").off("submit").submit();
              },
              function () {
                  // Ação ao cancelar no diálogo de confirmação (nada necessário aqui)
              }
          );
      });

      $("#id_classe_aeq").change(function () {
          const classeAeqId = $(this).val();
          if (classeAeqId) {
              window.studentcare.loadEmotionsEdit(classeAeqId);
          }
      });

      // Carrega as emoções da classe selecionada e o resumo
      const initialCourseid = $("#id_courseid").val();
      if (initialCourseid) {
          window.studentcare.loadEmotionsEdit($("#id_classe_aeq").val());
          loadAllSelections();
      }
  });
});
