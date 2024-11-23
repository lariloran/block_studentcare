require(["jquery"], function ($) {
  $(function () {
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
