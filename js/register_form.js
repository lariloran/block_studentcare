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
      loadEmotions(classeAeqId);
    }
  });

  window.ifcare.toggleSaveButton();

  $(
    "#id_starttime_day, #id_starttime_month, #id_starttime_year, #id_starttime_hour, #id_starttime_minute, #id_endtime_day, #id_endtime_month, #id_endtime_year, #id_endtime_hour, #id_endtime_minute"
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

  var initialCourseid = $("#id_courseid").val();
  if (initialCourseid) {
    window.ifcare.loadSections(initialCourseid);
    window.ifcare.loadEmotions($("#id_classe_aeq").val());
  }
});
