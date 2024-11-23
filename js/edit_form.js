require(["jquery"], function ($) {
  $(function () {
    window.ifcare.toggleSaveButton();

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
