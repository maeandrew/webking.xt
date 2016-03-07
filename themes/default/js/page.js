$(document).ready(function () {
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

	/** SHOWCASE SLIDER INITIALIZATION */
// function showSlider(src1,src2,src3){
//  $('#showcase_bg, #showcase').fadeIn();
//  // $('#showcase_bg').css("bottom", 0);
//  // $('#showcase').css("top", '50%');
//  var slides = new Array(src1,src2,src3);
//  var thumbs = new Array(src1.replace("/efiles/", "/efiles/_thumb/"),src2.replace("/efiles/", "/efiles/_thumb/"),src3.replace("/efiles/", "/efiles/_thumb/"));
//  var i = 0;
//  jQuery.each(slides, function(){
//      if(slides[i]){
//          $('#showcase').append('<div class="close animate"></div><div class="showcase-slide"><div class="showcase-content"><img style="max-width: 800px; max-height: 550px;" src="'+slides[i]+'"/></div><div class="showcase-thumbnail"><img src="'+thumbs[i]+'"/></div></div>');
//          i++;
//      }
//  });
//  /** НАСТРОЙКИ SHOWCASE СЛАЙДЕРА */
//  $("#showcase").awShowcase({
//      content_width:          900,
//      content_height:         550,
//      fit_to_parent:          false,
//      auto:                   false,
//      interval:               3000,
//      continuous:             false,
//      loading:                false,
//      tooltip_width:          200,
//      tooltip_icon_width:     32,
//      tooltip_icon_height:    32,
//      tooltip_offsetx:        18,
//      tooltip_offsety:        0,
//      arrows:                 true,
//      buttons:                false,
//      btn_numbers:            false,
//      keybord_keys:           true,
//      mousetrace:             false,  Trace x and y coordinates for the mouse
//      pauseonover:            true,
//      stoponclick:            true,
//      transition:             'fade', /* hslide/vslide/fade */
//      transition_delay:       300,
//      transition_speed:       500,
//      show_caption:           'onhover', /* onload/onhover/show */
//      thumbnails:             true,
//      thumbnails_position:    'outside-last', /* outside-last/outside-first/inside-last/inside-first */
//      thumbnails_direction:   'horizontal', /* vertical/horizontal */
//      thumbnails_slidex:      0, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
//      dynamic_height:         false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
//      speed_change:           true, /* Set to true to prevent users from swithing more then one slide at once. */
//      viewline:               false /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
//  });
//  $('#showcase_bg, .showcase .close').click(function(){
//      $('#showcase_bg, #showcase').fadeOut().delay(600).children().remove();
//  });
// }

	// var left = {
	// 	0: '18%',
	// 	1: '48%',
	// 	2: '77%'
	// }
	// var left2 = {
	// 	0: '15%',
	// 	1: '37%',
	// 	2: '58%',
	// 	3: '80%'
	// }
	// $('.info_block').click(function (e) {
	// 	var target = $('.'+$(this).data('target')),
	// 		eq = $(this).index();
	// 	if($(this).hasClass('active')){
	// 		$('.info_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
	// 		$('[id^="info_text_block_"], .blockforline').addClass('hidden');
	// 	}else{
	// 		target.removeClass('hidden');
	// 		$('.blockforline').removeClass('hidden');
	// 		$('[class^="ppp"]').addClass('hidden')
	// 		$('.info_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
	// 		$(this).addClass('active');
	// 		target.removeClass('hidden')
	// 		$(this).find('img').css('-webkit-filter', 'grayscale(0%)');
	// 		$(".block1, .block2").css({"left": left[eq]});
	// 	}
	// });


	// $('.payment_block').click(function (e) {
	// 	var target = $('.'+$(this).data('target')),
	// 		eq = $(this).index();
	// 	if($(this).hasClass('active')){
	// 		$('.payment_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
	// 		$('[id^="info_text_block_"], .blockforline').addClass('hidden');
	// 	}else{
	// 		target.removeClass('hidden');
	// 		$('.blockforline').removeClass('hidden');
	// 		$('[class^="ppp"]').addClass('hidden')
	// 		$('.payment_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
	// 		$(this).addClass('active');
	// 		target.removeClass('hidden')
	// 		$(this).find('img').css('-webkit-filter', 'grayscale(0%)');
	// 		$(".block1, .block2").css({"left": left2[eq]});
	// 	}
	// });


});