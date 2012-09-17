Drupal.behaviors.pressnow_feedsblock = function(context) {
	var feedblock = $('.block-pressnow_feedsblock');
	var feedlinks = $('.block-pressnow_feedsblock .feeds-links');
	var newerButton = $('.block-pressnow_feedsblock .feeds-newer');
	var olderButton = $('.block-pressnow_feedsblock .feeds-older');
	
	// social media navigation
	newerButton.css('visibility', 'hidden');
	
	olderButton.click(function() {
		var el = $(this);
		var offset = feedlinks.outerHeight();
		var container = feedlinks.children('ul.links');
		var min = 0 - container.outerHeight();
		var pos = container.position().top - offset;
		if (pos > min) {
			container.animate({
				top: pos
			}, 500, 'swing', function() {
				newerButton.css('visibility', 'visible');
				var nextPos = pos - offset;
				if (nextPos < min) {
					el.css('visibility', 'hidden');
				}
			});
		}
	});
	
	newerButton.live('click', function() {
		var el = $(this);
		var offset = feedlinks.outerHeight();
    var container = feedlinks.children('ul.links');
		var min = 0 + container.outerHeight();
		var pos = container.position().top + offset;
		if (pos > 0) { pos = 0 }
		if (pos <= 0) {
			container.animate({
				top: pos
			}, 500, 'swing', function() {
				olderButton.css('visibility', 'visible');
				if (pos == 0) {
					el.css('visibility', 'hidden');
				}
			});
		}
	});
}
