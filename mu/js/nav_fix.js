jQuery(document).on('scroll',function () {
	if ($(window).width() >  1200 ) {
		if($(window).scrollTop() > 400) {
			$('.smanone').css('position', 'fixed');
			$('.smanone').css('top', '0px');
			$('.smanone').css('z-index', '999');
			$('.smanone').css('width', '100%');
			$('.smanone').addClass('fixed');
		}else{
			$('.smanone').css('position', 'relative');
			$('.smanone').removeClass('fixed');
		}
	}
});