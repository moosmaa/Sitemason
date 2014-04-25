jQuery.noConflict();
(function($) {

	$('span.view-large').hide();
	myOp = 1;
	
	$(window).load(function(){
		$('#da-thumbs').masonry({ 
			columnWidth: 320,
			animate: true,
			itemSelector: '.box'
		}, 
		function() { $(this).css({
			margin: '1px'
			});
		});
	});
	
	// MouseOver Events
	$('.box').hover(function(){
		$('img', this).fadeTo("fast", 0.75).addClass('box-hover');
		$('span.view-large', this).fadeTo("fast", 1)},
	function(){
			$('img', this).fadeTo("fast", myOp).removeClass('box-hover');
			$('span.view-large', this).fadeTo("fast", 0)
	});
	

	
})(jQuery);