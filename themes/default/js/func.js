function openObject(id){
	var object = $('#'+id),
		type = object.data('type');
	if($('body').hasClass('active_bg')){
		$('.opened:not([id="'+object.attr('id')+'"])').each(function(index, el) {
			closeObject($(this).attr('id'));
		});
	}

	if(object.hasClass('opened') && type != "search"){
		closeObject(object.attr('id'));
		DeactivateBG();
	}else{
		object.addClass('opened');
		ActivateBG();
	}
			// console.log();

}

function closeObject(id){
	if(id == undefined){
		$('.opened').each(function(index, el) {
			closeObject($(this).attr('id'));
		});
	}else{
		console.log(id);
		$('#'+id).removeClass('opened');
		if(id == 'phone_menu'){
			$('[data-name="phone_menu"]').html('menu');
		};
	}
	DeactivateBG();
}

//Активация подложки
function ActivateBG(){
	$('body').addClass('active_bg');
}
//Деактивация подложки
function DeactivateBG(){
	$('body').removeClass('active_bg');
}

//Закрытие Панели мобильного меню
function closePanel(){
	$('.menu').html('menu');
	$('.panel').slideUp();
}

// /*MODAL WINDOW*/

// // Вызов модального окна
// function openModal(target){
// 	$('body').addClass('active_modal');
// 	$('#'+target+'.modal_hidden').removeClass('modal_hidden').addClass('modal_opened');
// }
// // Закрытие модального окна
// function closeModal(){
// 	$('.modal_opened').removeClass('modal_opened').addClass('modal_hidden');
// 	$('body').removeClass('active_modal');
// }

//Установка выбранного рейтинга
function changestars(rating){
	$('.set_rating').each(function(){
		var star = $(this).next('i');
		if(parseInt($(this).val()) <= parseInt(rating)){
			star.text('star');
		}else{
			star.text('star_border');
		}
	});
}