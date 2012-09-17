$(document).ready(function () {


  // find the elements to be eased and hook the hover event
  $('#block-views-columnists_view-block_1 .view-content ul li a').not('#block-views-columnists_view-block_1 .view-content ul li.views-row-last a').hover(function() {
    // if the element is currently being animated (to a easeOut)...
    if ($(this).is(':animated')) {
      $(this).stop().animate({width: "130px"}, {duration: 450, easing:"easeOutQuad"});
    } else {
      // ease in quickly
      $(this).stop().animate({width: "130px"}, {duration: 400, easing:"easeOutQuad"});
    }
  }, function () {
    // on hovering out, ease the element out
    if ($(this).is(':animated')) {
      $(this).stop().animate({width: "30px"}, {duration: 400, easing:"easeInOutQuad"})
    } else {
      // ease out slowly
      $(this).stop('animated:').animate({width: "30px"}, {duration: 450, easing:"easeInOutQuad"});
    }
  });


/*
  // find the elements to be eased and hook the hover event
  $('#block-views-columnists_view-block_1 .view-content ul li a').not('#block-views-columnists_view-block_1 .view-content ul li.views-row-last a').hover(function() {
    // if the element is currently being animated (to a easeOut)...
      $(this).css({width: "130px"});
      $('#block-views-columnists_view-block_1 .view-content ul li.views-row-last a').css({width: "30px"});  
  }, function () {
      $(this).css({width: "30px"});
      $('#block-views-columnists_view-block_1 .view-content ul li.views-row-last a').css({width: "130px"});
  });
*/

});