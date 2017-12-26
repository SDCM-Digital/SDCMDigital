$(document).ready(function() {
  $(".nav").animate({top: "0px"}, 1250);

  $("#navtoggle").click(function(e) {
    $(".primarynav").stop().slideToggle(1250);
    e.preventDefault();
  });

  $(window).resize(function() {
    if ($(window).width() > 800) {
      if (!($(".menu").is(":visible"))) {
        $(".menu").children("a").children("i").css("transform", "rotate(0deg)");
        $(".menu").stop().slideToggle(1250);
      }
    }
  });

  $(".order").click(function(e) {
    $("#orderItem").stop().fadeIn();
    $("#modalCover").stop().fadeIn();
    e.preventDefault();
  });

  $("#close").click(function(e) {
    $("#orderItem").stop().fadeOut();
    $("#modalCover").stop().fadeOut();
    e.preventDefault();
  });

  var cost = 0.00;

  $('#plan').on('change', function() {
    switch(this.value) {
      case "starter":
        cost = 70.00;
        break;
      case "intermediate":
        cost = 160.00;
        break;
      case "business":
        cost = 230.00;
        break;
      default:
        cost = 0.00;
        break;
    }
    $("#cost").html(cost);
  });
});
