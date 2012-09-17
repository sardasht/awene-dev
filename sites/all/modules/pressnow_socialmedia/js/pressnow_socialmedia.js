Drupal.behaviors.pressnow_socialmedia = function(context) {
	var socialmedia_blocks = $('.block-pressnow_socialmedia');
	var socialmedia_refresh = $('.block-pressnow_socialmedia').find('div#socialmedia_refresh');
	var newerButton = $('.block-pressnow_socialmedia .social-media-newer');
	var olderButton = $('.block-pressnow_socialmedia .social-media-older');
	
	socialmedia_refresh.live('click', function(e) {
		if (e.preventDefault) { e.preventDefault() }
		var type = $(this).attr('class');
		var url = Drupal.settings.basePath + 'pressnow_socialmedia/AJAX/' + type;
		$.ajax({
			url: url,
			success: function(data){
				if (data) {
					var el;
					switch(type) {
						case 'twitter':
							el = $('#block-pressnow_socialmedia-twitter .content');
							break;
						case 'facebook':
							el = $('#block-pressnow_socialmedia-facebook .content');
							break;
						case 'mobypic':
							el = $('#block-pressnow_socialmedia-mobypicture .content');
							break;
					}
					if (el) {
						el.fadeOut(500, function() {
							el.empty().append(data).fadeIn(500);
							el.find('.social-media-newer').css('visibility', 'hidden');
						});
					}
				}
			}
		});
	});
	
	// social media navigation
	newerButton.css('visibility', 'hidden');
	
	olderButton.live('click', function() {
		var thisNewer = $(this).siblings('.social-media-newer');
		var el = $(this);
		var offset = $(this).siblings('.social-media-content').height();
		var container = $(this).siblings('.social-media-content').find('.social-media-content-inner');
		var min = 0 - container.height();
		var pos = container.position().top - offset 
		if (pos > min) {
			container.animate({
				top: pos
			}, 500, function() {
				thisNewer.css('visibility', 'visible');
				var nextPos = pos - offset;
				if (nextPos < min) {
					el.css('visibility', 'hidden');
				}
			});
		}
	});
	
	newerButton.live('click', function() {
		var thisOlder = $(this).siblings('.social-media-older');
		var el = $(this);
		var offset = $(this).siblings('.social-media-content').height();
		var container = $(this).siblings('.social-media-content').find('.social-media-content-inner');
		var min = 0 + container.height();
		var pos = container.position().top + offset;
		if (pos <= 0) {
			container.animate({
				top: pos
			}, 500, function() {
				thisOlder.css('visibility', 'visible');
				if (pos == 0) {
					el.css('visibility', 'hidden');
				}
			});
		}
	});
}
