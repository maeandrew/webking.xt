$(document).ready(function () {
	var posBasic = 0;
	// Для кнопки "btn_plus"
	if ($(document).width() > 900) {
		$('.btn_plus--beta').addClass('hidden');
		$('.btn_plus').click(function(e) {
			e.preventDefault();
			var target = $(this).closest('.blockline').next(),
				  contentCenter = posBasic;			
			if($(this).hasClass('active')){
				target.slideUp();
				$(this).removeClass('active');
			}else{
				if($(this).hasClass('pos-right')){
					posBasic = $(this).css('right');
				}else if($(this).hasClass('pos-right--beta')) {
			posBasic = $(this).css('right');
		  }else{
		  	posBasic = $(this).css('left');
				}
				target.slideDown();
				$(this).addClass('active');
		  		$('html, body').stop().animate({
					'scrollTop': target.offset().top - 
				($('header').outerHeight() + $('.blockline').innerHeight() - 130)
				}, 900); 			
			contentCenter = $(".blockline").width()/2
			- $(this).width()/2;
		}
		// центрирует btn_plus по середине blockline
			if($(this).hasClass('pos-right')){
				$(this).css({'right': contentCenter});
			}else if($(this).hasClass('pos-right--beta')){
				$(this).css({'right': contentCenter});
			}else {
				$(this).css({'left': contentCenter});
			}
		});
	}else{
		$('.btn_plus').addClass('hidden');
		$('.btn_plus--beta').removeClass('hidden');

		$('.btn_plus--beta').click(function(e) {
			e.preventDefault();
			var target = $(this).closest('.blockline').next();
			
			if($(this).hasClass('active')){
				target.slideUp();
				$(this).removeClass('active');
			}else{				
				target.slideDown();
				$(this).addClass('active');
				$('html, body').stop().animate({
					'scrollTop': target.offset().top - 
				($('header').outerHeight() + $(this).find('.btn_plus_sign').outerHeight()*2.5)
				}, 900);
			}
		});
	}

	$('.page_about_us button').click(function(event) {
		openObject('auth')
		removeLoadAnimation('#auth');
	}); 

	$('.a_estimateLoad').click(function(event) {
		openObject('estimateLoad');
		removeLoadAnimation('#estimateLoad');
	});

	$('.a_question').click(function(event) {
		openObject('question');
		removeLoadAnimation('#question');
	});

	$('.delivery2').click(function(event) {
		openObject('delivery2');
		removeLoadAnimation('#delivery2');
	});

	$('#page_contacts .greenBtn').click(function(event) {
		openObject('offers');
		removeLoadAnimation('#offers');
	});
	$('#page_contacts .orangeBtn').click(function(event) {
		openObject('lament');
		removeLoadAnimation('#lament');
	});
});