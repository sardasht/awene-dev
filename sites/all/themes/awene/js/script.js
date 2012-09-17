// Set nice menus active trail
Drupal.behaviors.niceMenusActiveTrail = function (context) {
	$('#navbar-inner #nice-menu-1 .active').parent().addClass('active');
};

// Replace Arabic comma's with Latin comma's when entering tags
Drupal.behaviors.replaceArabicComma = function (context) {
  var txt = $("input[name*='taxonomy[tags]']");
  var func = function() {    txt.val(txt.val().replace(/،/gi, ','));  }
  txt.focus(func).keyup(func).blur(func);
};

/**
 * Adding the innerfade to the theme
 */
$(document).ready(function(){
	/**
	
	$('ID or class of the element containing the fading objects').innerfade({
		animationtype: Type of animation 'fade' or 'slide' (Default: 'fade'),
		speed: Fadingspeed in milliseconds or keywords (slow, normal or fast)(Default: 'normal'),
		timeout: Time between the fades in milliseconds (Default: '2000'),
		type: Type of slideshow: 'sequence', 'random' or 'random_start' (Default: 'sequence'),
		containerheight: Height of the containing element in any css-height-value (Default: 'auto')
		runningclass: CSS-Class which the container get’s applied (Default: 'innerfade')
	});

	 */
	$('#headerimages .view-header-image .view-content').innerfade({
		speed: 'slow',
		containerheight: '360px',
		timeout: 3000,
		runningclass: 'views-row'
	});
	$('.pane-node-slideshow .view-node-slideshow .view-content').innerfade({
		speed: 'slow',
		containerheight: '200px',
		timeout: 3000,
		runningclass: 'views-row'
	});
	
});