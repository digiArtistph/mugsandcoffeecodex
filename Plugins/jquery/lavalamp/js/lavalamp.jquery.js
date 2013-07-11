// JavaScript Document
(function($){
	jQuery.fn.lavalamp = function(options) {
		//alert('Called from nav menu...');
		options = $.extend({
				overlap		: 	20,
				speed		: 	500,
				reset		: 	1500,
				color		: 	'#0b2b61',
				easing		: 	'easeOutExpo',
				menuNode	:	'#nav'
			}, options);
		
		return this.each(function(){
			var nav = $(this),
			currentPageItem = $('#selected', nav),
			blob,
			reset;
			
			$('<li id="blob"></li>').css({
					width: currentPageItem.outerWidth(),
					height: currentPageItem.outerHeight() + options.overlap,
					left: currentPageItem.position().left,
					top: currentPageItem.position().top - (options.overlap / 2),
					backgroundColor : options.color
			}).appendTo(options.menuNode);
			
			blob = $('#blob', nav);
			
			$('li', nav).hover(function(){
				clearTimeout(reset);
				blob.animate({
					left:	$(this).position().left,
					width:	$(this).width()
				},
				{
					duration:	options.speed,
					easing:	options.easing,
					queue:	false
				});
			}, function() {
				// mouseout
				 blob.stop().animate({
						 left: $(this).position().left,
						 width: $(this).width()
					}, options.speed);
			 
				reset = setTimeout(function(){
					blob.animate({
						width:	currentPageItem.outerWidth(),
						left:	currentPageItem.position().left
					}, options.speed);
				}, options.reset);
			});
		});
	};
})(jQuery);