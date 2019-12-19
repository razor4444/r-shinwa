
jQuery(function(){
	if ($(window).width() < 769 ) {
		$('.section-6 .tt1').on('click', function() {
			$(this).next().toggle();
			return false;
		});

		$('.section-6 .tt2').on('click', function() {
			$(this).next().toggle();
			return false;
		});
	}
});
