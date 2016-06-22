<div class="row">
	<div class="customer_cab col-md-6">
		<div id="edit_personal">
			<?=$content;?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
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
				$('input.phone').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible').text('Введите все цифры Вашего номера телефона');
			}
		});

		$('input[name="save_contacts"]').click(function(event) {			
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
					if (response == 'true') {
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
	});
</script>
