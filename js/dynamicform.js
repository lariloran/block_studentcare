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
  var selecoes = {};

  function toggleSaveButton() {
    var selectedEmotions = $("#id_emocoes").val() || [];
    $("#id_save").prop("disabled", selectedEmotions.length === 0);
  }
  function loadEmotions(classeAeqId) {
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

          updateSelectedEmotions();
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

  function updateSelectedEmotions() {
    var classeAeqId = $("#id_classe_aeq").val();
    if (classeAeqId) {
      var selectedEmotions = $("#id_emocoes").val() || [];
      selecoes[classeAeqId] = selectedEmotions;

      $("#emocao_selecionadas").val(JSON.stringify(selecoes));

      renderSelectedEmotions();
      toggleSaveButton();
    }
  }

  function renderSelectedEmotions() {
    var emotionContainer = $("#emocoes-selecionadas");
    emotionContainer.empty();

    Object.keys(selecoes).forEach(function (classeId) {
      var emocoes = selecoes[classeId];
      emocoes.forEach(function (emocaoId) {
        var emotionName = $(
          '#id_emocoes option[value="' + emocaoId + '"]'
        ).text();

        if (emotionName) {
          var tag = $("<div>").addClass("emotion-tag").text(emotionName);
          var closeButton = $("<span>").addClass("close-btn").text("×");

          closeButton.on("click", function () {
            selecoes[classeId] = selecoes[classeId].filter(function (e) {
              return e !== emocaoId;
            });

            $("#id_emocoes").val(selecoes[classeId]);
            $("#emocao_selecionadas").val(JSON.stringify(selecoes));
            renderSelectedEmotions();
          });

          tag.append(closeButton);
          emotionContainer.append(tag);
        }
      });
    });
  }

  require(["core/notification"], function (notification) {
    $("form.mform").on("submit", function (e) {
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

  $("#id_emocoes").change(updateSelectedEmotions);

  $("#id_classe_aeq").change(function () {
    var classeAeqId = $(this).val();
    if (classeAeqId) {
      loadEmotions(classeAeqId);
    }
  });

  toggleSaveButton();

  function loadSections(courseid) {
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

  function loadResources(courseid, sectionid) {
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

  $("#id_courseid").change(function () {
    var courseid = $(this).val();
    if (courseid) {
      loadSections(courseid);
    }
  });

  $("#id_sectionid").change(function () {
    var courseid = $("#id_courseid").val();
    var sectionid = $(this).val();
    loadResources(courseid, sectionid);
  });

  var initialCourseid = $("#id_courseid").val();
  if (initialCourseid) {
    loadSections(initialCourseid);
    loadEmotions($("#id_classe_aeq").val());
  }
});
