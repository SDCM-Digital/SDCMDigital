$(document).ready(function() {
  $("#lr").click(function(e) {
    $(".login").fadeIn();
    $("#modalCover").fadeIn();
    e.preventDefault();
  });

  $("#close").click(function(e) {
    $(".login").fadeOut();
    $("#modalCover").fadeOut();
    e.preventDefault();
  });
});
