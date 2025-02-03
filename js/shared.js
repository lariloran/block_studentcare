require(["jquery", "core/notification"], function ($, notification) {
  $(function () {
    $("head").append(`
    <style>
        .emotion-tag {
            display: flex;
            align-items: center;
            padding: 5px 10px;
            background-color: #f2f2f2;
            border-radius: 20px;
            border: 1px solid #ccc;
            font-size: 14px;
            cursor: pointer;
        }
        .emotion-tag .close-btn {
            margin-left: 10px;
            color: #888;
            font-weight: bold;
            cursor: pointer;
        }
            
        .selected-emotions-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .fitem {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .fitem .fitemtitle {
            width: 25%;
            margin-right: 20px;
        }

        .fitem .felement {
            flex: 1;
            margin-left: 0;
            padding-left: 0;
        }
    </style>
`);
    window.studentcare = window.studentcare || {};
    var selecoes = {};
    // Função para salvar seleções no localStorage, vinculando ao ID da coleta atual
    window.studentcare.saveToLocalStorage = function saveToLocalStorage(classeId, emotions) {
      const storedSelections = JSON.parse(localStorage.getItem("studentcareSelections")) || {};
      storedSelections[classeId] = emotions;
  
      localStorage.setItem("studentcareSelections", JSON.stringify(storedSelections));
  };
  

  window.studentcare.getFromLocalStorage = function getFromLocalStorage() {
    return JSON.parse(localStorage.getItem("studentcareSelections")) || {};
};


window.studentcare.clearLocalStorage = function clearLocalStorage() {
  localStorage.removeItem("studentcareSelections");
};

    // Atualiza o campo oculto com o JSON das seleções
    window.studentcare.updateHiddenField = function updateHiddenField() {
      const storedSelections = window.studentcare.getFromLocalStorage();
      $("#emocao_selecionadas").val(JSON.stringify(storedSelections));
    };

    // Atualiza o resumo visual das seleções
    window.studentcare.renderResumo = function renderResumo() {
      const storedSelections = window.studentcare.getFromLocalStorage();
      const emotionContainer = $("#emocoes-selecionadas");
      emotionContainer.empty();
  
      // Mapeamento entre IDs das classes AEQ e seus nomes
      const classeAeqMap = {
          1: "AULA",
          2: "APREND",
          3: "AVAL"
      };
  
      // Itera por todas as classes e emoções armazenadas
      Object.keys(storedSelections).forEach(function (classeId) {
          storedSelections[classeId].forEach(function (emocao) {
              // Evita duplicatas no DOM
              if (
                  !emotionContainer.find(
                      `.emotion-tag[data-id="${emocao.id}"][data-classe="${classeId}"]`
                  ).length
              ) {
                  // Nome do balão: Nome da emoção + Nome da classe
                  const classeName = classeAeqMap[classeId] || `Classe ${classeId}`;
                  const tagText = `${emocao.name} - ${classeName}`;
  
                  const tag = $("<div>")
                      .addClass("emotion-tag")
                      .attr("data-id", emocao.id)
                      .attr("data-classe", classeId)
                      .text(tagText);
  
                  const closeButton = $("<span>")
                      .addClass("close-btn")
                      .text("×")
                      .on("click", function () {
                          // Remove a emoção do localStorage
                          const updatedSelections = window.studentcare.getFromLocalStorage();
                          updatedSelections[classeId] = updatedSelections[classeId].filter(
                              (e) => e.id !== emocao.id
                          );
  
                          // Desmarca a emoção no select múltiplo
                          $(`#id_emocoes option[value="${emocao.id}"]`).prop(
                              "selected",
                              false
                          );
  
                          // Atualiza o localStorage e o campo oculto
                          localStorage.setItem(
                              "studentcareSelections",
                              JSON.stringify(updatedSelections)
                          );
                          window.studentcare.updateHiddenField();
  
                          // Remove o balão visual
                          tag.remove();
                      });
  
                  tag.append(closeButton);
                  emotionContainer.append(tag);
              }
          });
      });
  };
  

    // Atualiza o objeto de seleções e o resumo ao mudar o select múltiplo
    $("#id_emocoes").on("change", function () {
      const classeId = $("#id_classe_aeq").val();
      if (!classeId) return;

      // Atualiza as seleções com ID e nome da emoção
      const selectedEmotions = $(this)
        .val()
        .map(function (id) {
          const name = $(`#id_emocoes option[value="${id}"]`).text();
          return { id: id, name: name };
        });

      // Salva no localStorage
      window.studentcare.saveToLocalStorage(classeId, selectedEmotions);

      // Atualiza o resumo e o campo oculto
      window.studentcare.updateHiddenField();
      window.studentcare.renderResumo();
    });

    window.studentcare.loadEmotions = function loadEmotions(classeAeqId) {
      if (classeAeqId) {
        $.ajax({
          url: M.cfg.wwwroot + "/blocks/studentcare/get_emotions.php",
          method: "GET",
          data: { classeaeqid: classeAeqId },
          success: function (response) {
            var emotions = JSON.parse(response).emotions;

            $("#id_emocoes").empty();

            if (Array.isArray(emotions) && emotions.length > 0) {
              emotions.forEach(function (emotion) {
                $("#id_emocoes").append(
                  $("<option>", {
                    value: emotion.value,
                    text: emotion.name,
                  })
                );
              });

              if (classeAeqId in selecoes) {
                $("#id_emocoes").val(selecoes[classeAeqId]);
              }
            } else {
              $("#id_emocoes").append(
                $("<option>", {
                  value: "",
                  text: "Nenhuma emoção disponível",
                })
              );
            }
          },
          error: function () {
            console.error("Erro ao carregar as emoções.");
            $("#id_emocoes")
              .empty()
              .append(
                $("<option>", {
                  value: "",
                  text: "Erro ao carregar emoções",
                })
              );
          },
        });
      }
    };
    window.studentcare.loadEmotionsEdit = function loadEmotionsEdit(classeAeqId) {
      if (classeAeqId) {
          $.ajax({
              url: M.cfg.wwwroot + "/blocks/studentcare/get_emotions.php",
              method: "GET",
              data: { classeaeqid: classeAeqId },
              success: function (response) {
                  var emotions = JSON.parse(response).emotions;
  
                  // Limpa as opções do select
                  $("#id_emocoes").empty();
  
                  // Obtém as emoções associadas do campo oculto (agora agrupadas por classe)
                  var associatedEmotions = JSON.parse(
                      $("#emocao_associadas").val() || "{}"
                  );
  
                  // Garante que é um objeto válido
                  if (typeof associatedEmotions !== "object") {
                      associatedEmotions = {};
                  }
  
                  // Converte as emoções associadas da classe atual em um array de IDs
                  var associatedEmotionIds = (associatedEmotions[classeAeqId] || []).map(
                      function (emotion) {
                          return parseInt(emotion.id);
                      }
                  );
  
                  if (Array.isArray(emotions) && emotions.length > 0) {
                      emotions.forEach(function (emotion) {
                          var option = $("<option>", {
                              value: emotion.value,
                              text: emotion.name,
                          });
  
                          // Marca como selecionado se o ID estiver nos associados
                          if (associatedEmotionIds.includes(parseInt(emotion.value))) {
                              option.prop("selected", true);
                          }
  
                          $("#id_emocoes").append(option);
                      });
  
                      // Garante que as seleções marcadas sejam refletidas no campo visual
                      $("#id_emocoes").trigger("change");
                  } else {
                      $("#id_emocoes").append(
                          $("<option>", {
                              value: "",
                              text: "Nenhuma emoção disponível",
                          })
                      );
                  }
              },
              error: function () {
                  console.error("Erro ao carregar as emoções.");
                  $("#id_emocoes")
                      .empty()
                      .append(
                          $("<option>", {
                              value: "",
                              text: "Erro ao carregar emoções",
                          })
                      );
              },
          });
      }
  };
  
    window.studentcare.loadSections = function loadSections(courseid) {
      if (courseid) {
        $.ajax({
          url: M.cfg.wwwroot + "/blocks/studentcare/get_sections.php",
          method: "GET",
          data: { courseid: courseid },
          success: function (response) {
            var sections = JSON.parse(response);

            if (
              Array.isArray(sections.sections) &&
              sections.sections.length > 0
            ) {
              $("#id_sectionid").empty();

              sections.sections.forEach(function (section) {
                $("#id_sectionid").append(
                  $("<option>", {
                    value: section.value,
                    text: section.name,
                  })
                );
              });

              var firstSectionId = sections.sections[0].value;
              var sectionid = sections.sections[0].value;
              $("#id_sectionid").val(firstSectionId);
              $.ajax({
                url: M.cfg.wwwroot + "/blocks/studentcare/get_resources.php",
                method: "GET",
                data: { courseid: courseid, sectionid: sectionid },
                success: function (response) {
                  var resources = JSON.parse(response);

                  $("#id_resourceid").empty();

                  if (
                    Array.isArray(resources.resources) &&
                    resources.resources.length > 0
                  ) {
                    resources.resources.forEach(function (resource) {
                      $("#id_resourceid").append(
                        $("<option>", {
                          value: resource.value,
                          text: resource.name,
                        })
                      );
                    });

                    var firstResourceId = resources.resources[0].value;
                    $("#id_resourceid").val(firstResourceId);
                    if (typeof callback === "function") {
                      callback();
                    }
                  } else {
                    $("#id_resourceid").append(
                      $("<option>", {
                        value: "",
                        text: "Nenhum recurso disponível",
                      })
                    );
                  }
                },
                error: function () {
                  console.error("Erro ao carregar os recursos.");
                  $("#id_resourceid")
                    .empty()
                    .append(
                      $("<option>", {
                        value: "",
                        text: "Erro ao carregar recursos",
                      })
                    );
                },
              });
            } else {
              $("#id_sectionid")
                .empty()
                .append(
                  $("<option>", {
                    value: "",
                    text: "Nenhuma seção disponível",
                  })
                );
              $("#id_resourceid")
                .empty()
                .append(
                  $("<option>", {
                    value: "",
                    text: "Nenhum recurso disponível",
                  })
                );
            }
          },
          error: function () {
            console.error("Erro ao carregar as seções.");
            $("#id_sectionid")
              .empty()
              .append(
                $("<option>", {
                  value: "",
                  text: "Erro ao carregar seções",
                })
              );
            $("#id_resourceid")
              .empty()
              .append(
                $("<option>", {
                  value: "",
                  text: "Erro ao carregar recursos",
                })
              );
          },
        });
      }
    };

    window.studentcare.loadResources = function loadResources(courseid, sectionid) {
      if (courseid && sectionid) {
        $.ajax({
          url: M.cfg.wwwroot + "/blocks/studentcare/get_resources.php",
          method: "GET",
          data: { courseid: courseid, sectionid: sectionid },
          success: function (response) {
            var resources = JSON.parse(response);

            $("#id_resourceid").empty();

            if (
              Array.isArray(resources.resources) &&
              resources.resources.length > 0
            ) {
              resources.resources.forEach(function (resource) {
                $("#id_resourceid").append(
                  $("<option>", {
                    value: resource.value,
                    text: resource.name,
                  })
                );
              });

              var firstResourceId = resources.resources[0].value;
              $("#id_resourceid").val(firstResourceId);

              if (typeof callback === "function") {
                callback();
              }
            } else {
              $("#id_resourceid").append(
                $("<option>", {
                  value: "",
                  text: "Nenhum recurso disponível",
                })
              );
            }
          },
          error: function () {
            console.error("Erro ao carregar os recursos.");
            $("#id_resourceid")
              .empty()
              .append(
                $("<option>", {
                  value: "",
                  text: "Erro ao carregar recursos",
                })
              );
          },
        });
      } else {
        $("#id_resourceid")
          .empty()
          .append(
            $("<option>", {
              value: "",
              text: "Nenhum recurso disponível",
            })
          );
      }
    };

    window.studentcare.getTimestampFromSelector = function getTimestampFromSelector(
      selectorId
    ) {
      var year = parseInt($(`#${selectorId}_year`).val());
      var month = parseInt($(`#${selectorId}_month`).val()) - 1;
      var day = parseInt($(`#${selectorId}_day`).val());
      var hour = parseInt($(`#${selectorId}_hour`).val());
      var minute = parseInt($(`#${selectorId}_minute`).val());

      if (
        isNaN(year) ||
        isNaN(month) ||
        isNaN(day) ||
        isNaN(hour) ||
        isNaN(minute)
      ) {
        return null;
      }

      return new Date(year, month, day, hour, minute).getTime() / 1000;
    };

    window.studentcare.validateDates = function validateDates() {
      var startTimestamp = getTimestampFromSelector("id_starttime");
      var endTimestamp = getTimestampFromSelector("id_endtime");
      var currentTimestamp = Math.floor(Date.now() / 1000);

      if (startTimestamp === null || endTimestamp === null) {
        return true;
      }

      if (startTimestamp < currentTimestamp) {
        alert("A data de início não pode estar no passado.");
        return false;
      }

      if (endTimestamp <= startTimestamp) {
        alert("A data de fim deve ser posterior à data de início.");
        return false;
      }

      return true;
    };

    window.studentcare.updateTimestamps = function updateTimestamps() {
      var startTimestamp = getTimestampFromSelector("id_starttime");
      var endTimestamp = getTimestampFromSelector("id_endtime");

      $("#start_timestamp_hidden").val(startTimestamp);
      $("#end_timestamp_hidden").val(endTimestamp);
    };

    window.studentcare.excluirColeta = function excluirColeta(coletaId) {
      return fetch(M.cfg.wwwroot + "/blocks/studentcare/delete_collection.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `coleta_id=${coletaId}`,
      }).then((response) => {
        if (response.ok) {
          // Remove o card da listagem
          const modal = document.getElementById("coletaModal");
          const card = document.querySelector(`[data-id='${coletaId}']`);
          if (modal) {
            modal.style.display = "none";
          }
          if (card) {
            card.style.display = "none"; // Oculta o card
            card.remove(); // Remove o card do DOM
          }
          window.location.href = M.cfg.wwwroot + "/blocks/studentcare/index.php";

          return true; // Indica sucesso
        } else {
          throw new Error("Falha ao excluir a coleta.");
        }
      });
    };

    window.studentcare.confirmarExclusaoModal = function confirmarExclusaoModal(
      button
    ) {
      const coletaId = button.getAttribute("data-id");
      var confirmTitle = document.getElementById('confirmation-delete').getAttribute('data-title');
      var confirmMessage = document.getElementById('confirmation-delete').getAttribute('data-message-delete');
      var confirmButtonYes = document.getElementById('confirmation-delete').getAttribute('data-yes');
      var confirmButtonNo = document.getElementById('confirmation-delete').getAttribute('data-no');

      // Código do diálogo de confirmação
      notification.confirm(
          confirmTitle,  // Título da confirmação
          confirmMessage,  // Mensagem de confirmação
          confirmButtonYes,  // Texto do botão "Confirmar"
          confirmButtonNo,  // Texto do botão "Cancelar"
        function () {
          // Chama a função de exclusão e exibe mensagem de sucesso
          window.studentcare
            .excluirColeta(coletaId)
            .then(() => {})
            .catch((error) => {
              // Exibe mensagem de erro
              notification.alert(
                "Erro",
                error.message ||
                  "Ocorreu um erro ao tentar excluir a coleta. Por favor, tente novamente.",
                "Ok"
              );
            });
        },
        function () {}
      );
    };

    $("#id_courseid").change(function () {
      var courseid = $(this).val();
      if (courseid) {
        window.studentcare.loadSections(courseid);
      }
    });

    $("#id_sectionid").change(function () {
      var courseid = $("#id_courseid").val();
      var sectionid = $(this).val();
      window.studentcare.loadResources(courseid, sectionid);
    });
  });
});
