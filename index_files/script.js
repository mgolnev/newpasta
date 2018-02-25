

$(document).ready(function() {
	$(window).scroll(function(){
		    if ($(window).scrollTop() > "100")
		    {
			$('.top_block').fadeIn("slow");
			
		    }
			else
			{
				$('.top_block').fadeOut("slow");
				$(".top_angle").css('left', $('.top_block').offset().left+410+'px');
				$('.top_angle').fadeOut("slow");
				$('.angle_all').html('');
				}
		});
	/* This is basic - uses default settings */
	$(".open_dish").fancybox({
        'autoDimensions': false,
	'height'	: 420,
        'widht'	: 880,
        'margin': 0,
        'padding':0
        });
	$(".phone_phone").fancybox({
        'autoDimensions': false,
	'height'	: 400,
        'widht'	: 680,
        'margin': 0,
        'padding':0
        });
	/* Using custom settings */
	/* Apply fancybox to multiple items */
        /* ---  ---*/
        /* ---  ---*/
	$('#inner_dish_menu li a').each(function(i){
		if($(this).attr('href')==window.location.pathname)
			$(this).parent().addClass('active');
	});
    });