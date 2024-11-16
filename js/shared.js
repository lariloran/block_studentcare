require(["jquery"], function ($) {
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
    window.ifcare = window.ifcare || {};
    var selecoes = {};

    window.ifcare.toggleSaveButton = function toggleSaveButton() {
      var selectedEmotions = $("#id_emocoes").val() || [];
      $("#id_save").prop("disabled", selectedEmotions.length === 0);
    }
    window.ifcare.loadEmotions = function loadEmotions(classeAeqId) {
      if (classeAeqId) {
        $.ajax({
          url: M.cfg.wwwroot + "/blocks/ifcare/get_emotions.php",
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
  
            window.ifcare.updateSelectedEmotions();
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
    }
  
    window.ifcare.updateSelectedEmotions = function updateSelectedEmotions() {
      var classeAeqId = $("#id_classe_aeq").val();
      if (classeAeqId) {
        var selectedEmotions = $("#id_emocoes").val() || [];
        selecoes[classeAeqId] = selectedEmotions;
  
        $("#emocao_selecionadas").val(JSON.stringify(selecoes));
  
        window.ifcare.renderSelectedEmotions();
        window.ifcare.toggleSaveButton();
      }
    }
  
    window.ifcare.renderSelectedEmotions = function renderSelectedEmotions() {
      var emotionContainer = $("#emocoes-selecionadas");
  
      // Itera sobre todas as classes e emoções selecionadas para exibir o resumo completo
      Object.keys(selecoes).forEach(function (classeId) {
        var emocoes = selecoes[classeId];
        emocoes.forEach(function (emocaoId) {
          // Verifica se a emoção já foi adicionada ao resumo
          if (
            !emotionContainer.find('.emotion-tag[data-id="' + emocaoId + '"]')
              .length
          ) {
            // Obtém o nome da emoção atual de acordo com seu ID
            var emotionName = $(
              '#id_emocoes option[value="' + emocaoId + '"]'
            ).text();
  
            if (emotionName) {
              var tag = $("<div>")
                .addClass("emotion-tag")
                .attr("data-id", emocaoId)
                .text(emotionName);
              var closeButton = $("<span>").addClass("close-btn").text("×");
  
              // Permite remover uma emoção específica do resumo ao clicar no botão de fechar
              closeButton.on("click", function () {
                // Remove a emoção do objeto selecoes
                selecoes[classeId] = selecoes[classeId].filter(function (e) {
                  return e !== emocaoId;
                });
  
                // Remove a tag visual
                tag.remove();
  
                // Atualiza o campo oculto com as emoções restantes
                $("#emocao_selecionadas").val(JSON.stringify(selecoes));
  
                // Desmarca a emoção no campo select
                $('#id_emocoes option[value="' + emocaoId + '"]').prop(
                  "selected",
                  false
                );
              });
  
              tag.append(closeButton);
              emotionContainer.append(tag);
            }
          }
        });
      });
    } 
  
    window.ifcare.loadSections = function loadSections(courseid) {
      if (courseid) {
        $.ajax({
          url: M.cfg.wwwroot + "/blocks/ifcare/get_sections.php",
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
                url: M.cfg.wwwroot + "/blocks/ifcare/get_resources.php",
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
    }
  
    window.ifcare.loadResources = function loadResources(courseid, sectionid) {
      if (courseid && sectionid) {
        $.ajax({
          url: M.cfg.wwwroot + "/blocks/ifcare/get_resources.php",
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
    }
  
    window.ifcare.getTimestampFromSelector = function getTimestampFromSelector(selectorId) {
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
    }
  
    window.ifcare.validateDates = function validateDates() {
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
    }
  
    window.ifcare.updateTimestamps = function updateTimestamps() {
      var startTimestamp = getTimestampFromSelector("id_starttime");
      var endTimestamp = getTimestampFromSelector("id_endtime");
  
      $("#start_timestamp_hidden").val(startTimestamp);
      $("#end_timestamp_hidden").val(endTimestamp);
    }


    require(["core/notification"], function (notification) {
      $("form.mform").on("submit", function (e) {
        if (!validateDates()) {
          e.preventDefault();
          return;
        }
  
        e.preventDefault();
        notification.confirm(
          "Confirmação",
          "Está pronto para salvar esta coleta de emoções?",
          "Confirmar",
          "Cancelar",
          function () {
            $("#setor").val($("#id_sectionid").val());
            $("#recurso").val($("#id_resourceid").val());
            $("form.mform").off("submit").submit();
          },
          function () {}
        );
      });
    });
  
    $("#id_emocoes").change(window.ifcare.updateSelectedEmotions);
  
    $("#id_classe_aeq").change(function () {
      var classeAeqId = $(this).val();
      if (classeAeqId) {
        window.ifcare.loadEmotions(classeAeqId);
      }
    });
    
    $("#id_starttime_day, #id_starttime_month, #id_starttime_year, #id_starttime_hour, #id_starttime_minute, #id_endtime_day, #id_endtime_month, #id_endtime_year, #id_endtime_hour, #id_endtime_minute"
    ).change(function () {
      setTimeout(window.ifcare.updateTimestamps, 100);
    });
  
    $("#id_courseid").change(function () {
      var courseid = $(this).val();
      if (courseid) {
        window.ifcare.loadSections(courseid);
      }
    });
  
    $("#id_sectionid").change(function () {
      var courseid = $("#id_courseid").val();
      var sectionid = $(this).val();
      window.ifcare.loadResources(courseid, sectionid);
    });
  
    window.ifcare.toggleSaveButton();

    window.ifcare.loadEmotions($("#id_classe_aeq").val());

  });
  