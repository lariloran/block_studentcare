require(["jquery"], function ($) {
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
        function () { }
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

  window.ifcare.loadEmotions($("#id_classe_aeq").val());

  var isEditing = $("#id_is_editing").val() || "0";
  if (isEditing === "1") {
    var initialCourseid = $("#id_courseid").val();

    if (initialCourseid) {
      window.ifcare.loadSections(initialCourseid, function () {
        var initialSectionId = $("#id_sectionid").val();
        $("#id_sectionid").val(initialSectionId).trigger("change");

        window.ifcare.loadResources(initialCourseid, initialSectionId, function () {
          var initialResourceId = $("#id_resourceid").val();
          $("#id_resourceid").val(initialResourceId);
        });
      });
    }
  }
});
