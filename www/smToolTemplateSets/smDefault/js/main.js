$(document).ready(function() {	
	$('<a class="mobile-nav-icon">&#9776</a>').appendTo('header nav');
	
	$('.mobile-nav-icon').click(function(){
		$(this).toggleClass('mobile-nav-visible');
		return false;
	});
	
	$('<nav class="mobile-nav">').appendTo('header nav');

	$('.site-header .nav-link').each(function() {
		var el = $(this);
		$('<a />', {
			'href'		: el.attr('href'),
			'text'		: el.text()
		}).appendTo('.mobile-nav');
	});
	
	// Gallery support
	$('.gallery-image-link').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			titleSrc: function(item) {
				var title = item.el.attr('title');
				if (item.el.attr('copyright')) {
					title += '<small>' + item.el.attr('copyright')  + '</small>';
				}
				
				return title;
			}
		}
	});

	
	$('video,audio').mediaelementplayer();
});