$(document).ready(function () {
	var left = {
		0: '18%',
		1: '48%',
		2: '77%'
	}
	var left2 = {
		0: '15%',
		1: '37%',
		2: '58%',
		3: '80%'
	}
	$('.info_block').click(function (e) {
		var target = $('.'+$(this).data('target')),
			eq = $(this).index();
		if($(this).hasClass('active')){
			$('.info_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
			$('[id^="info_text_block_"], .blockforline').addClass('hidden');
		}else{
			target.removeClass('hidden');
			$('.blockforline').removeClass('hidden');
			$('[class^="ppp"]').addClass('hidden')
			$('.info_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
			$(this).addClass('active');
			target.removeClass('hidden')
			$(this).find('img').css('-webkit-filter', 'grayscale(0%)');
			$(".block1, .block2").css({"left": left[eq]});				
		}
	});

	$('.a_question').click(function(event) {
		openObject('question');		
	});
	$('#page_contacts .greenBtn').click(function(event) {
		openObject('offers');
	});

	$('.payment_block').click(function (e) {
		var target = $('.'+$(this).data('target')),
			eq = $(this).index();
		if($(this).hasClass('active')){
			$('.payment_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
			$('[id^="info_text_block_"], .blockforline').addClass('hidden');
		}else{
			target.removeClass('hidden');
			$('.blockforline').removeClass('hidden');
			$('[class^="ppp"]').addClass('hidden')
			$('.payment_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
			$(this).addClass('active');
			target.removeClass('hidden')
			$(this).find('img').css('-webkit-filter', 'grayscale(0%)');
			$(".block1, .block2").css({"left": left2[eq]});
		}
	});

	var posBasic = 0;
	// Для кнопки "btn_plus"
	$('.btn_plus').click(function (e){
		e.preventDefault();
		var target = $(this).closest('.blockline').next(),
			contentCenter = posBasic;
		if($(this).hasClass('active')){
			target.slideUp();
			$(this).removeClass('active');
		}else{
			if($(this).hasClass('pos-right')){
				posBasic = $(this).css('right');
			}else{
				posBasic = $(this).css('left');
			}
			target.slideDown();
			$(this).addClass('active');
			$('html, body').stop().animate({
				'scrollTop': target.offset().top - ($('header').outerHeight()*1.5 + $(this).find('span').outerHeight())
			}, 900);
			contentCenter = $("#content").width()/2 - $(this).find('span').width()/2;
		}
		console.log(posBasic);
		if($(this).hasClass('pos-right')){
			$(this).css({
				'right': contentCenter
			});
		}else{
			$(this).css({
				'left': contentCenter
			});
		}
	});
});