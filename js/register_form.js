require(["jquery"], function ($) {
  
  var initialCourseid = $("#id_courseid").val();
  if (initialCourseid) {
    window.ifcare.loadSections(initialCourseid);
  }
});
