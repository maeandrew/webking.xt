$(function(){

	// Инициализация lazy load
	$("img.lazy").lazyload({
		effect : "fadeIn"
	});
	
	/**------------------ Страница редактирования тегов категории --------------------*/

	// Слушатель клавиш
	$('.tagrow textarea').keydown(function(e){
		var code = e.keyCode || e.which;
		if (code == '9') {
			e.preventDefault();
			if($(this).val().substr($(this).val().length-3) === ' @ '){
				return false;
			}else{
				$(this).val($(this).val()+' | ');
			}
		}else if(code == '27'){
			e.preventDefault();
			$('.tagrow p').show();
			$('.tagrow input, .tagrow textarea').hide();
			$('.tagrow a.edit, .tagrow a.delete').removeClass('hidden');
			$('.tagrow a.apply, .tagrow a.discard').addClass('hidden');
		}
	});

	/** Действия с группами тегов */

	// Удалить
	$('.levelrow a.delete').click(function(event){
		event.preventDefault();
		var tag_level = $(this).attr('class').replace( /^\D+/g, '');
		var answer = confirm("Удалить группу и все, входящие в нее, фильтры?");
		if (answer == true){
			var cat = $('input#id_category').val();
			$.ajax({
				url: URL_base+'ajaxcattags',
				type: "POST",
				data: {
					"id_category": cat,
					"tag_level": tag_level,
					"action": 'droplevel'
				}
			}).done(function(){
				location.reload();
			});
		}
	});

	// Изменить
	$('.levelrow a.edit').click(function(event){
		event.preventDefault();
		var rowid = $(this).attr('class').replace( /^\D+/g, '');
		$('.levelrow.row'+rowid+' p').hide();
		$('.levelrow.row'+rowid+' input#tag_level_name').show();
		$('.levelrow.row'+rowid+' a.apply, .levelrow.row'+rowid+' a.discard').removeClass('hidden');
		$('.levelrow.row'+rowid+' a.edit, .levelrow.row'+rowid+' a.delete').addClass('hidden');
	});

	// Применить изменения
	$('.levelrow a.apply').click(function(event){
		event.preventDefault();
		var tag_level = $(this).attr('class').replace( /^\D+/g, '');
		if(tag_level !== ''){
			var cat = $('input#id_category').val();
			var tag_level_name = $('.levelrow.row'+tag_level+' .tag_level_name input').val();
			console.log(tag_level_name);
			$.ajax({
				url: URL_base+'ajaxcattags',
				type: "POST",
				data: {
					"id_category": cat,
					"tag_level": tag_level,
					"tag_level_name": tag_level_name,
					"action": 'updatelevel'
				}
			}).done(function(){
				location.reload();
			});
		}else{
			console.log('error!!!');
		}
	});

	// Отменить изменение или добавление
	$('.levelrow a.discard').click(function(event){
		event.preventDefault();
		var rowid = $(this).attr('class').replace( /^\D+/g, '');
		$('.levelrow.row'+rowid+' p').show();
		$('.levelrow.row'+rowid+' input#tag_level_name').hide();
		$('.levelrow.row'+rowid+' a.edit, .levelrow.row'+rowid+' a.delete').removeClass('hidden');
		$('.levelrow.row'+rowid+' a.apply, .levelrow.row'+rowid+' a.discard').addClass('hidden');
	});


	/** Действия со строками тегов */

	// Добавить
	$('a.add').click(function(event){
		event.preventDefault();
		$('.tagrow.addrow').show();

	});

	// Удалить
	$('.tagrow a.delete').click(function(event){
		event.preventDefault();
		var rowid = $(this).attr('class').replace( /^\D+/g, '');
		var answer = confirm("Удалить выбраный фильтр?");
		if (answer == true){
			$.ajax({
				url: URL_base+'ajaxcattags',
				type: "POST",
				data: {
					"ID": rowid,
					"action": 'drop'
				}
			}).done(function(){
				$('.tagrow.row'+rowid).slideUp('slow');
			});
		}
	});

	// Изменить
	$('.tagrow a.edit').click(function(event){
		event.preventDefault();
		var rowid = $(this).attr('class').replace( /^\D+/g, '');
		$('.tagrow.row'+rowid+' p').hide();
		$('.tagrow.row'+rowid+' input#tag_name, .tagrow.row'+rowid+' textarea#tag_keys, .tagrow.row'+rowid+' input#tag_level').show();
		$('.tagrow.row'+rowid+' a.apply, .tagrow.row'+rowid+' a.discard').removeClass('hidden');
		$('.tagrow.row'+rowid+' a.edit, .tagrow.row'+rowid+' a.delete').addClass('hidden');
	});

	// Применить изменения
	$('.tagrow a.apply').click(function(event){
		event.preventDefault();
		var rowid = $(this).attr('class').replace( /^\D+/g, '');
		if(Validate(rowid)){
			var cat = $('input#id_category').val();
			var tag_name = $('.tagrow.row'+rowid+' input#tag_name').val();
			var tag_keys = $('.tagrow.row'+rowid+' textarea#tag_keys').val();
			var tag_level = $('.tagrow.row'+rowid+' input#tag_level').val();
			var tag_level_name = $('.levelinforow'+tag_level+' .tag_level_name p').text();
			$.ajax({
				url: URL_base+'ajaxcattags',
				type: "POST",
				data: {
					"ID": rowid,
					"id_category": cat,
					"tag_name": tag_name,
					"tag_keys": tag_keys,
					"tag_level": tag_level,
					"tag_level_name": tag_level_name,
					"action": 'update'
				}
			}).done(function(){
				location.reload();
			});
		}else{
			console.log('error!!!');
		}
	});

	// Подтвердить добавление
	$('.tagrow a.addapply').click(function(event){
		event.preventDefault();
		var rowid = $(this).attr('class').replace( /^\D+/g, '');
		console.log(rowid);
		if(Validate(rowid)){
			var cat = $('input#id_category').val();
			var tag_name = $('.tagrow.row'+rowid+' input#tag_name').val();
			var tag_keys = $('.tagrow.row'+rowid+' textarea#tag_keys').val();
			var tag_level = $('.tagrow.row'+rowid+' input#tag_level').val();
			var tag_level_name = $('.levelinforow'+tag_level+' .tag_level_name p').text();
			$.ajax({
				url: URL_base+'ajaxcattags',
				type: "POST",
				data: ({
					"id_category": cat,
					"tag_name": tag_name,
					"tag_keys": tag_keys,
					"tag_level": tag_level,
					"tag_level_name": tag_level_name,
					"action": 'add'
				}),
			}).done(function(){
				location.reload();
			});
		}else{
			console.log('error!!!');
		}
	});

	// Отменить изменение или добавление
	$('.tagrow a.discard').click(function(event){
		event.preventDefault();
		var rowid = $(this).attr('class').replace( /^\D+/g, '');
		$('.tagrow.row'+rowid+' p').show();
		$('.tagrow.row'+rowid+' input#tag_name, .tagrow.row'+rowid+' textarea, .tagrow.row'+rowid+' input#tag_level').hide();
		$('.tagrow.row'+rowid+' a.edit, .tagrow.row'+rowid+' a.delete').removeClass('hidden');
		$('.tagrow.row'+rowid+' a.apply, .tagrow.row'+rowid+' a.discard').addClass('hidden');
	});

	function Validate(rowid){
		var tag_name = $('.tagrow.row'+rowid+' input#tag_name').val();
		var tag_keys = $('.tagrow.row'+rowid+' textarea#tag_keys').val();
		var tag_level = $('.tagrow.row'+rowid+' input#tag_level').val();
		if(tag_name != '' && tag_keys != '' && tag_level != ''){
			return true;
		}else{
			return false;
		}
	}

	$('#toTop').click(function () {
		$('html, body').animate({
			scrollTop: 0
		}, 1000, "easeInOutCubic");
	});

	// Добавление кнопки Закрыть всем модальным окнам
	$('[class^="modal_"]').append('<a href="#" class="close_modal icon-del">n</a>');

	// Открытие модального окна
	$('.open_modal').on('click', function(event){
		var target = $(this).data('target');
		event.preventDefault();
		openModal(target);
		$('body').keydown(function(e){
			if(e.keyCode == 27){
				closeModal();
				return false;
			}
		});
	});

	// Закрытие модального окна
	$('#back_modal, .close_modal').on('click', function(event) {
		event.preventDefault();
		closeModal();
	});

	// Переключатель видимости пожеланий
	$('.visible').on('click', function() {
		var id_wishes = $(this).closest('.feedback_container').attr('data-wishes'),
			obj = $(this);
		SwitchVisibleWishes(obj, id_wishes);
	});

	// Удаление пожеланий
	$('.del_wishes_js').on('click', function() {
		var id_wishes = $(this).closest('.feedback_container').attr('data-wishes');
		if(confirm('Вы точно хотите удалить?')){
			delWishes(id_wishes);
		}
	});

	//Ответ на комментарий в предложениях
	$('.reply').on('click', function() {
		var id = $(this).closest('.feedback_container').attr('data-wishes');
		$('#feedback_text').focus();
		$('input[name="id_reply"]').val(id);
	});

	$('.moderations input').on('click',function() {
		var id = $(this).val(),
			mode = 'mopt',
			moderation = 0;
		if($(this).hasClass('opt')){
			mode = 'opt';
		}
		if ($(this).is(':checked')) {
			moderation = 1;
			//console.log($(this).is(':checked'));
		}
		//console.log(id);
		$.ajax({
			url: URL_base+'ajaxproducts',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				'action': 'UpdateDemandChart',
				'moderation': moderation, 'id_chart': id, 'mode': mode
			}
		}).done(function(data){
			console.log(data);
		});
	});
	$('.permissions .controller').on('click', 'input.all', function(){
		console.log($(this).is(':checked'));
		$(this).closest('.controller').find('input').prop('checked', $(this).is(':checked'));
	});
});