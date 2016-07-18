<div class="row">
	<div class="customer_cab col-md-6">
		<div id="edit_personal">
			<?=$content;?>
		</div>
	</div>
</div>
<div id="preview-template" style="display: none;">
	<div class="image_block dz-preview dz-file-preview">
		<div class="image">
			<img data-dz-thumbnail />
		</div>
		<div class="controls">
			<p id="forDelU" class="del_u_photo_js del_avatar" data-dz-remove><i class="material-icons">delete</i></p>
			<div class="mdl-tooltip" for="forDelU">Удалить фото</div>
		</div>
		<input type="hidden" name="images_visible[]" value="0">
	</div>
</div>
<script>
	$(document).ready(function() {
		var confirmUpdate = false;
		// if (!confirmUpdate) {
		// 	window.onbeforeunload = function(){ 
		// 		return 'У Вас есть несохраненные данные.';
		// 	}
		// }

		$('div[class^="msg-"]').delay(3000).fadeOut(2000);
		
		$('.day_js').change(function(event){
			if($('.day_js').val() !== '' && $('.month_js').val() == 'месяц'){
				$('.month_js').closest('.mdl-textfield').addClass('is-invalid');
			}else if($('.day_js').val() === '' && $('.month_js').val() != 'месяц'){
				$('.day_js').closest('.mdl-textfield').addClass('is-invalid');
			}else if($('.day_js').val() !== '' && $('.month_js').val() != 'месяц'){
				$('.month_js').closest('.mdl-textfield').removeClass('is-invalid');
			}
		});
		$('.month_js').change(function(event){
			if($('.day_js').val() === ''){
				$('.day_js').closest('.mdl-textfield').addClass('is-invalid');
			}else if($('.day_js').val() !== '' && $('.month_js').val() != 'месяц'){
				$('.month_js').closest('.mdl-textfield').removeClass('is-invalid');
			}
			$(this).find('option[value="месяц"]').remove();
		});

		$('[name="email"]').keyup(function(event) {
			$(this).closest('.mdl-textfield').find('.mdl-textfield__error').text('Введите корректный Email');
			if($(this).val() !== ''){
				$('input.phone').closest('.mdl-textfield').removeClass('is-invalid').find('.mdl-textfield__error').css('visibility', 'hidden');
			}
		});

		// checkPhoneNumber($('input.phone').val());
		$('input.phone').focusout(function(event){
			// checkPhoneNumber($('input.phone').val());
			if($('input.phone').val().replace(/[^\d]+/g, "").length == 12){
				$('input.phone').data('value', $('input.phone').val().replace(/[^\d]+/g, ""));
				// console.log($('input.phone').data('value'));
				$('input.phone').closest('.mdl-textfield').removeClass('is-invalid').find('.mdl-textfield__error').css('visibility', 'hidden');
				$('[name="email"]').closest('.mdl-textfield').removeClass('is-invalid');
			}else if($('input.phone').val().replace(/[^\d]+/g, "").length === 0 || $('input.phone').val().replace(/[^\d]+/g, "").length == 3){
				$('input.phone').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible');
				$('input.phone').closest('.mdl-textfield').addClass('is-invalid');
				// console.log($('input.phone').val().replace(/[^\d]+/g, "").length);
			}else{
				// console.log("error");
				$('input.phone').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible').text('Введите номер телефона');
			}
		});

		$('input[name="save_contacts"]').click(function(event) {
			addLoadAnimation('#edit_contacts');
			var parent = $(this).closest('form'),
				id_user = parent.find('[name="id_user"]').val(),
				email = parent.find('[name="email"]').val(),
				phone_num = parent.find('[name="phones"]').val().replace(/[^\d]+/g, ""),
				phone,
				last_name = parent.find('[name="last_name"]').val(),
				first_name = parent.find('[name="first_name"]').val(),
				middle_name = parent.find('[name="middle_name"]').val(),
				gender = parent.find('[name="gender"]:checked').val(),
				day, month, year,
				address = parent.find('[name="address"]').val(),
				snackbarMsg,
				snackbarContainer = document.querySelector('#snackbar');

			if(phone_num.length == 12){
				phone = phone_num;
			}else if(phone_num === ''){
				phone = phone_num;
				console.log('empty string');
			}else{
				console.log('error');
			}

			day = $('.day_js').val() !== ''?$('.day_js').val():'';
			month = $('.month_js').val() !== 'месяц'?$('.month_js').val():'';
			year = $('.year_js').val() !== ''?$('.year_js').val():'';

			data = {id_user: id_user, email: email, phone: phone, last_name: last_name, first_name: first_name, middle_name: middle_name, gender: gender, day: day, month: month, year: year, address: address };

			if(email === '' && phone_num === ''){
				snackbarMsg = {message: 'Введите Email или Ваш номер телефона'},
				snackbarContainer.MaterialSnackbar.showSnackbar(snackbarMsg);
				$('[name="email"], [name="phones"]').closest('.mdl-textfield').addClass('is-invalid');
				$('[name="email"]').closest('.mdl-textfield').find('.mdl-textfield__error').text('Укажите Email');
				$('[name="phones"]').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible').text('Укажите контактный номер телефона');
			}
			else if(parent.find('.mdl-textfield').hasClass('is-invalid')){
				snackbarMsg = {message: 'Заполните поля корректно'},
				snackbarContainer.MaterialSnackbar.showSnackbar(snackbarMsg);
			}else{
				ajax('cabinet', 'ChangeInfoUser', data).done(function(response){
					removeLoadAnimation('#edit_contacts');
					if (response == 'true') {
						confirmUpdate = true;
						snackbarMsg = {message: 'Ваши данные успешно сохранены'},
						snackbarContainer.MaterialSnackbar.showSnackbar(snackbarMsg);
						$('.errMsg_js').text('');
						$('.date_container').css('box-shadow', 'none');
					}else{
						console.log(response);
						for(var i in response){
							switch(i){
								case 'email':
									$('[name="email"]').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible').text(response[i]);
									break;
								case 'phone':
									$('[name="phones"]').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible').text(response[i]);
									break;
								case 'first_name':
									$('[name="first_name"]').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible').text(response[i]);
									break;
								case 'middle_name':
									$('[name="middle_name"]').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible').text(response[i]);
									break;
								case 'last_name':
									$('[name="last_name"]').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible').text(response[i]);
									break;
								case 'check_date':
									$('.errMsg_js').text(response[i]);
									$('.date_container').css('box-shadow', '0 0 10px rgba(216, 1, 1, 0.8)');
									break;
								default:
									alert( 'Заполните Ваши данные корректно' );
							}
						}
					}
				});
			}
		});

		//Загрузка Фото на сайт
		var	url = URL_base+'userPic/';
		var dropzone = new Dropzone(".drop_zone", {
			method: 'POST',
			url: url+"?upload=true",
			clickable: true,
			maxFiles: 1,
			// acceptedFiles: 'image/jpeg,image/png',
			previewsContainer: '.previews',
			previewTemplate: document.querySelector('#preview-template').innerHTML
		});
		dropzone.on('addedfile', function(file){
			$('#photobox .old_image_js img').remove();
			// $('.previews .dz-file-preview').addClass('forUpload');
			componentHandler.upgradeDom();
		}).on('maxfilesexceeded', function(file) {
			this.removeAllFiles();
			this.addFile(file);
			componentHandler.upgradeDom();
		}).on('success', function(file, path){
			// file.previewElement.innerHTML += '<input type="hidden" name="images[]" value="'+path+'">';
			componentHandler.upgradeDom();
		}).on('removedfile', function(file){
			$('#photobox .old_image_js').append('<img data-dz-thumbnail src="/images/noavatar.png"/>');
			// removed_file2 = '/product_images/original/'+year+'/'+(month+1)+'/'+day+'/'+file.name;
			// $('.previews').append('<input type="hidden" name="removed_images[]" value="'+removed_file2+'">');
			componentHandler.upgradeDom();
		});

		//Удаление ранее загруженного фото
		$("body").on('click', '.del_photo_js', function(e) {
			alert('Изобрежение будет удалено.');
			if(confirm('Изобрежение будет удалено.')){
				// var path = $(this).closest('.image_block'),
				// 	removed_file = path.find('input[name="images[]"]').val(); //  /news_images/482/cat.jpg
				// RemovedFile(path, removed_file);
			}
		});
	});
</script>
