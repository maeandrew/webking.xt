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
			ajax('cattags', 'dropLevel', {id_category: cat, tag_level: tag_level}).done(function(){
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
			ajax('cattags', 'updateLevel', {id_category: cat, tag_level: tag_level, tag_level_name: tag_level_name}).done(function(){
				location.reload();
			});
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
			ajax('cattags', 'drop', {ID: rowid}).done(function(){
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
			ajax('cattags', 'update', {id_category: cat, tag_name: tag_name, tag_keys: tag_keys, tag_level: tag_level, tag_level_name: tag_level_name, }).done(function(){
				location.reload();
			});
		}
	});

	// Подтвердить добавление
	$('.tagrow a.addapply').click(function(event){
		event.preventDefault();
		var rowid = $(this).attr('class').replace( /^\D+/g, '');
		if(Validate(rowid)){
			var cat = $('input#id_category').val();
			var tag_name = $('.tagrow.row'+rowid+' input#tag_name').val();
			var tag_keys = $('.tagrow.row'+rowid+' textarea#tag_keys').val();
			var tag_level = $('.tagrow.row'+rowid+' input#tag_level').val();
			var tag_level_name = $('.levelinforow'+tag_level+' .tag_level_name p').text();
			ajax('cattags', 'add', {id_category: cat, tag_name: tag_name, tag_keys: tag_keys, tag_level: tag_level, tag_level_name: tag_level_name, }).done(function(){
				location.reload();
			});
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

	$('.moderations input').on('click', function() {
		var id = $(this).val(),
			mode = 'mopt',
			moderation = 0;
		if($(this).hasClass('opt')){
			mode = 'opt';
		}
		if ($(this).is(':checked')) {
			moderation = 1;
		}
		ajax('products', 'updateDemandChart', {moderation: moderation, id_chart: id, mode: mode});
	});
	$('.permissions .controller').on('click', 'input.all', function(){
		$(this).closest('.controller').find('input').prop('checked', $(this).is(':checked'));
	});

	$('body').on('click', '.batchListItem_js', function(event) {
		event.preventDefault();
		var parent = $(this),
			create_date = parent.attr('data-createDate'),
			id_supplier = parent.attr('data-idSupplier'),
			id_author = parent.attr('data-idAuthor');
		var data = {create_date: create_date, id_supplier: id_supplier, id_author: id_author};
		if(parent.hasClass('info_loaded')){
			parent.closest('thead').next().toggle('slow');
			if(parent.hasClass('opened')){
				parent.removeClass('opened').text('Показать');
			}else{
				parent.addClass('opened').text('Скрыть');
			}
		}else{
			ajax('products', 'getProductBatch', data, 'html').done(function(data){
				parent.text('Скрыть').addClass('opened info_loaded').closest('thead').next().html(data);
			}).fail(function(data){
				console.log('fail');
				console.log(data);
			});
		}
	});

	// adm_feedback_comment_reply_js
	$('body').on('click', '.adm_comment_reply_js', function(event){
		event.preventDefault();
		$(this).addClass('hidden').closest('.btn_wrap').find('.adm_comment_reply_cancel_js').removeClass('hidden');
		$(this).closest('thead').next().append('<tr class="new_comment"><td colspan="2"><div class="reply_wrap"><form action="/adm/coment/" method="post" onsubmit="onCommentSubmit()"><input type="hidden" name="pid_comment" value="'+$(this).attr('data-idComment')+'"><input type="hidden" name="url_coment" value="'+$(this).attr('data-idproduct')+'"><textarea name="feedback_text" id="feedback_comment_reply" cols="30" required></textarea><button type="submit" name="sub_com" class="btn-m-green">Ответить</button></form></div></td></tr>');
	});
	$('body').on('click', '.adm_comment_reply_cancel_js', function(event){
		event.preventDefault();
		$(this).closest('thead').next().find('.new_comment').remove();
		$(this).addClass('hidden').closest('.btn_wrap').find('.adm_comment_reply_js').removeClass('hidden');
	});

	// Перенос выбранных товаров в категорию
	$('body').on('click', '.btn_move_to_js', function(event){
		var parent = $(this).closest('.move_to'),
			is_empty = parent.attr('data-isempty'),
			data = {};
			data.id_category = parent.find('[name="category"]').val();
			parent.find('[name="move_product"]').prop("checked") ? data.main = 0 : data.main = 1;
		if(data.id_category != null){
			$('select[name="category"]').removeClass('err_border');
			if($('.checked_products').children().length != 0){
				$('.no_checked_products_js').removeClass('err_border');
				ajax('products', 'fillCategory', data, 'text').done(function(data){
					console.log(data);
					$('.checked_products').empty();
					$('.no_checked_products_js').removeClass('hidden');
					location.reload();
				}).fail(function(data){
					console.log('fail');
					console.log(data);
				});
			}else{
				$('.no_checked_products_js').addClass('err_border');
			}
		}else{
			$('select[name="category"]').addClass('err_border');
		}
	});

	// Удаление товара из списка для переноса в категорию
	$('body').on('click', '.del_checked_product_js', function(event){
		if(confirm('Товар будет удален из списка. Продолжить?')){
			var checked_product = $(this),
				data = {};
			data.id_product = $(this).attr('data-idproduct');
			data.checked = 0;
			ajax('products', 'sessionFillCategory', data, 'text').done(function(data){
				console.log(data);
				checked_product.closest('.checked_product').remove();
				if($('.checked_products').children().length == 0){
					$('.no_checked_products_js').removeClass('hidden');
				}
			}).fail(function(data){
				console.log('fail');
				console.log(data);
			});
		}
	});
});