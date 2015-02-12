jQuery(document).ready(function() {
	
	jQuery(window).scroll(function(){
		if (jQuery(this).scrollTop() > 60) {
			jQuery('.scroll-top').css({bottom:"25px"});
		} else {
			jQuery('.scroll-top').css({bottom:"-100px"});
		}
	});
	jQuery('.scroll-top').click(function(){
		jQuery('html, body').animate({scrollTop: '0px'}, 800);
		return false;
	});
	
}); 