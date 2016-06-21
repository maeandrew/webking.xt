<div class="row">
	<div class="customer_cab col-md-6">
		<div id="edit_personal">
			<form id="edit_contacts" class="editing" action="" method="post">
				<input required="required" type="hidden" name="id_user" id="id_user" value="<?=$User['id_user']?>"/>
				<input required="required" type="hidden" name="news" id="news" value="<?=$User['news']?>"/>
				<?!isset($_GET['t'])?$var = '': $var = $_GET['t'];?>
				<?switch($var){
					default:?>
					<div id="photobox" class="user_avatar">
						<div class="previews">
							<div class="image_block dz-preview dz-image-preview">
								<?if(isset($_POST['images']) && !empty($_POST['images'])){
									if(isset($_POST['images']['src'])){?>
										<div class="image old_image_js">
											<img data-dz-thumbnail src="<?=$_POST['images']['src']?>"/>
										</div>
										<div class="controls">
											<p id="forDel" class="del_photo_js del_avatar" data-dz-remove><i class="material-icons">delete</i></p>
											<div class="mdl-tooltip" for="forDel">Удалить фото</div>
										</div>
									<?}
								}else{?>
									<div class="image old_image_js">
										<img data-dz-thumbnail src="/images/noavatar.png"/>
									</div>
								<?}?>								
								<!-- <input type="hidden" name="images[]" value="<?=$_POST['images']['src']?>"> -->
							</div>
						</div>
						<div class="image_block_new drop_zone animate avatar_menu">
							<div class="dz-default dz-message load_avatar"><span>Загрузить фото</span></div>
							<input type="file" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
						</div>
					</div>




					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label class="mdl-textfield__label" for="email">E-mail:</label>
						<input class="mdl-textfield__input" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" type="text" name="email" id="email" value="<?=$User['email']?>"/>
						<span class="mdl-textfield__error">Введите корректный Email</span>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="phone" class="mdl-textfield__label">Контактный телефон:</label>
						<input class="mdl-textfield__input phone" type="tel" required name="phones" id="phones" value="<?=$User['phone']?>" pattern="\+\d{2}\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}\"/>
						<span class="mdl-textfield__error">Введите номер телефона</span>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="name" class="mdl-textfield__label">Фамилия:</label>
						<input class="mdl-textfield__input" pattern="^[\'А-Яа-я-ЇїІіЁё]+|^[\'A-Za-z-]+$" type="text" name="first_name" id="first_name" value="<?=$Customer['first_name']?>"/>
						<span class="mdl-textfield__error">Использованы недопустимые символы</span>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="middle_name" class="mdl-textfield__label">Имя:</label>
						<input class="mdl-textfield__input" pattern="^[\'А-Яа-яЇїІіЁё]+|^[\'A-Za-z]+$" type="text" name="middle_name" id="middle_name" value="<?=$Customer['middle_name']?>"/>
						<span class="mdl-textfield__error">Использованы недопустимые символы</span>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="last_name" class="mdl-textfield__label">Отчество:</label>
						<input class="mdl-textfield__input" pattern="^[\'А-Яа-я-ЇїІіЁё]+|^[\'A-Za-z-]+$" type="text" type="text" name="last_name" id="last_name" value="<?=$Customer['last_name']?>"/>
						<span class="mdl-textfield__error">Использованы недопустимые символы</span>
					</div>
					<div id="gend_block" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label class="label_for_gender" for="gender">Пол:</label>
						<div id="gender">
							<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="male">
								<input <?=$Customer['sex'] == 'male'?'checked="checked"':null;?> type="radio" name="gender" class="mdl-radio__button" id="male" value="male">Мужской
							</label> &nbsp;&nbsp;
							<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="female">
								<input <?=$Customer['sex'] == 'female'?'checked="checked"':null;?> type="radio" name="gender" class="mdl-radio__button" id="female" value="female">Женский
							</label>
						</div>
					</div>
					<!-- <div id="forBirthday" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="birthday" class="mdl-textfield__label">Дата рождения:</label>
						<input class="mdl-textfield__input" type="text" name="birthday" id="birthday" value="" placeholder="Выберите дату рождения" disabled="disabled" />
					</div> -->
					<div class="date_container">
						<div class="mdl-textfield mdl-js-textfield">
							<label for="day" class="mdl-textfield__label">день</label>
							<input id="day" name="day" pattern="^(0?[1-9])$|^([1-2]\d)$|^(3[0-1])$" type="text" placeholder="день" maxlength="2" size="4" class="mdl-textfield__input day_js day" value="<?=isset($Customer['b_day'])?$Customer['b_day']:null;?>">
							<span class="mdl-textfield__error">Укажите день</span>
						</div>
						<input id="customer_month" type="hidden" value="<?=isset($Customer['b_month'])?$Customer['b_month']:null;?>">
						<div class="mdl-textfield mdl-js-textfield">
							<select name="month" class="month_js month">
								<?=!isset($Customer['b_month'])?print_r('<option value="месяц">месяц</option>'):null;?>
								<script>
									var month = ['январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь'],
										customer_month = $('#customer_month').val(),
										temp;
										console.log(customer_month);

									for (var i = 0; i < month.length; i++) {
										temp = ((i<9)?'0'+(i+1):(i+1));										
										document.write('<option value="' + temp + '">'+ month[i] +'</option>');
										if (temp == customer_month) {
											$('.month_js').find('option[value="'+temp+'"]').attr('selected', 'selected');
										}
									};
								</script>
							</select>
							<span class="mdl-textfield__error">Выберите месяц</span>
						</div>
						<div class="mdl-textfield mdl-js-textfield">
							<label for="year" class="mdl-textfield__label">год</label>
							<input id="year" name="year" pattern="^(19|20)\d{2}$" type="text" placeholder="год" maxlength="4" size="8" class="mdl-textfield__input year_js year" value="<?=isset($Customer['b_year'])?$Customer['b_year']:null;?>">
							<span class="mdl-textfield__error"></span>
						</div>
					</div>
					<div class="errMsg_js"></div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="address" class="mdl-textfield__label">Адрес:</label>
						<input class="mdl-textfield__input" type="text" name="address" id="address"  value="<?=$Customer['address_ur']?>"/>
					</div>
					<input type="button" value="Сохранить" name="save_contacts" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">					
				<?break;
				case 'delivery':?>
					<div class="line region">
						<label for="id_region">Область</label><br>
						<select required="required" name="id_region" id="id_region" onChange="regionSelect(id_region.value);">
							<option selected="selected" disabled="disabled">Выберите область</option>
							<?foreach($allregions as $region){ ?>
								<option <?=$region['region'] == $savedcity['region']?'selected="selected"':null;?> value="<?=$region['region']?>"><?=$region['region']?></option>
							<?}?>
						</select>
					</div>
					<div class="line city">
						<label for="id_city">Город</label><br>
						<select required="required" name="id_city" id="id_city" onChange="citySelect(id_city.value);">
							<?foreach($availablecities as $city){?>
								<option <?=$city['name'] == $savedcity['name']?'selected="selected"':null;?> value="<?=$city['names_regions']?>"><?=$city['name']?></option>
							<?}?>
						</select>
					</div>
					<div class="line id_delivery">
						<label for="id_delivery">Способ доставки</label><br>
						<select required="required" name="id_delivery" id="id_delivery" onChange="deliverySelect();">
							<?foreach($alldeliverymethods as $dm){?>
								<option <?=$dm['id_delivery'] == $Customer['id_delivery']?'selected="selected"':null;?> value="<?=$dm['id_delivery']?>"><?=$dm['name']?></option>
							<?}?>
						</select>
					</div>
					<div class="line delivery_service" id="delivery_service" <?=$saveddeliverymethod['id_delivery'] != 3?'style="display: none;"':null;?>>
						<label for="id_delivery_service">Служба доставки</label><br>
						<select name="id_delivery_service" onChange="deliveryServiceSelect(id_delivery_service.value);" id="id_delivery_service">
							<?foreach($availabledeliveryservices as $ds){?>
								<option <?=$ds['shipping_comp'] == $savedcity['shipping_comp']?'selected="selected"':null;?> value="<?=$ds['shipping_comp']?>"><?=$ds['shipping_comp']?></option>
							<?}?>
						</select>
					</div>
					<div class="line delivery_department" id="delivery_department" <?=$saveddeliverymethod['id_delivery'] != 3?'style="display: none;"':null;?>>
						<label for="id_delivery_department">Отделение в Вашем городе</label><br>
						<select name="id_delivery_department" id="id_delivery_department">
							<?foreach($availabledeliverydepartment as $dd){?>
								<option <?=$dd['id_city'] == $savedcity['id_city']?'selected="selected"':null;?> value="<?=$dd['id_city']?>"><?=$dd['address']?></option>
							<?}?>
						</select>
					</div>
					<div class="buttons_cab">
						<button name="save_delivery" type="submit" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Сохранить</button>
					</div>
				<?break;
				}?>
			</form>
		</div>
		<!--<?if(isset($_GET['success'])){?>
			<div class="msg-success">
				<p><b>Успех!</b> Изменения успешно сохранены.</p>
			</div>
		<?}elseif(isset($_GET['unsuccess'])){?>
			<div class="msg-error">
				<p><b>Упс!</b> Что-то пошло не так.</p>
			</div>
		<?}?>
	</div> --> <!-- END class="edit_personal" -->
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
		
		$('.day_js').change(function(event) {
			if ($('.day_js').val()!='' && $('.month_js').val() == 'месяц') {
				$('.month_js').closest('.mdl-textfield').addClass('is-invalid');
			}else if($('.day_js').val()=='' && $('.month_js').val() != 'месяц'){
				$('.day_js').closest('.mdl-textfield').addClass('is-invalid');
			}else if($('.day_js').val()!='' && $('.month_js').val() != 'месяц'){
				$('.month_js').closest('.mdl-textfield').removeClass('is-invalid');
			};
		});
		$('.month_js').change(function(event) {
			if ($('.day_js').val() == '') {
				$('.day_js').closest('.mdl-textfield').addClass('is-invalid');
			}else if($('.day_js').val()!='' && $('.month_js').val() != 'месяц'){
				$('.month_js').closest('.mdl-textfield').removeClass('is-invalid');
			}
			$(this).find('option[value="месяц"]').remove();
		});

		$('[name="email"]').keyup(function(event) {
			$(this).closest('.mdl-textfield').find('.mdl-textfield__error').text('Введите корректный Email');
			if($(this).val()!='') $('input.phone').closest('.mdl-textfield').removeClass('is-invalid').find('.mdl-textfield__error').css('visibility', 'hidden');
		});

		// checkPhoneNumber($('input.phone').val());
		$('input.phone').focusout(function(event) {
			// checkPhoneNumber($('input.phone').val());
			if($('input.phone').val().replace(/[^\d]+/g, "").length == 12){
				$('input.phone').data('value', $('input.phone').val().replace(/[^\d]+/g, ""));
				// console.log($('input.phone').data('value'));
				$('input.phone').closest('.mdl-textfield').removeClass('is-invalid').find('.mdl-textfield__error').css('visibility', 'hidden');
				$('[name="email"]').closest('.mdl-textfield').removeClass('is-invalid');
			}else if($('input.phone').val().replace(/[^\d]+/g, "").length == 0 || $('input.phone').val().replace(/[^\d]+/g, "").length == 3){
				$('input.phone').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible');
				$('input.phone').closest('.mdl-textfield').addClass('is-invalid');
				// console.log($('input.phone').val().replace(/[^\d]+/g, "").length);
			} else {
				// console.log("error");
				$('input.phone').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible').text('Введите номер телефона');
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
			}else if(phone_num == ''){
				phone = phone_num;
				console.log('empty string');
			}else{
				console.log('error');
			}

			$('.day_js').val()!=''?day=$('.day_js').val():day='';
			$('.month_js').val()!='месяц'?month=$('.month_js').val():month='';
			$('.year_js').val()!=''?year=$('.year_js').val():year='';

			data = {id_user: id_user, email: email, phone: phone, last_name: last_name, first_name: first_name, middle_name: middle_name, gender: gender, day: day, month: month, year: year, address: address }

			if(email == '' && phone_num == ''){
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
						confirmUpdate = true;
						snackbarMsg = {message: 'Ваши данные успешно сохранены'},
						snackbarContainer.MaterialSnackbar.showSnackbar(snackbarMsg);
						$('.errMsg_js').text('');
						$('.date_container').css('box-shadow', 'none');
					}else{
						console.log(response);
						for (var i in response) {
							switch (i) {
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
								break;
								case 'check_date':
									$('.errMsg_js').text(response[i]);
									$('.date_container').css('box-shadow', '0 0 10px rgba(216, 1, 1, 0.8)');
								break;
								default:
									alert( 'Заполните Ваши данные корректно' );
							}
						}
					};
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
