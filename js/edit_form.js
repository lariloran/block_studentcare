require(["jquery"], function ($) {
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
