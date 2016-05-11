<div class="row">
	<div class="customer_cab col-md-6">
		<div id="edit_personal">
			<form id="edit_contacts" class="editing" action="" method="post">
				<input required="required" type="hidden" name="id_user" id="id_user" value="<?=$User['id_user']?>"/>
				<input required="required" type="hidden" name="news" id="news" value="<?=$User['news']?>"/>
				<?!isset($_GET['t'])?$var = '': $var = $_GET['t'];?>
				<?switch($var){
					default:?>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label class="mdl-textfield__label" for="email">E-mail:</label>
						<input class="mdl-textfield__input" required="required" type="text" name="email" id="email" value="<?=$User['email']?>"/>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="phone" class="mdl-textfield__label">Контактный телефон:</label>
						<input class="mdl-textfield__input phone" required="required" type="tel" name="phones" id="phones" maxlength="15" value="<?=$Customer['phones']?>"/>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="last_name" class="mdl-textfield__label">Фамилия:</label>
						<input class="mdl-textfield__input" type="text" required="required" type="text" name="last_name" id="last_name" value="<?=$Customer['last_name']?>"/>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="name" class="mdl-textfield__label">Имя:</label>
						<input class="mdl-textfield__input" required="required" type="text" name="first_name" id="first_name" value="<?=$Customer['first_name']?>"/>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="middle_name" class="mdl-textfield__label">Отчество:</label>
						<input class="mdl-textfield__input" required="required" type="text" name="middle_name" id="middle_name" value="<?=$Customer['middle_name']?>"/>
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
					<div id="date_container">
						<div class="mdl-textfield mdl-js-textfield">
							<label for="day" class="mdl-textfield__label">день</label>
							<input id="day" name="day" pattern="^(0?[1-9])$|^([1-2]\d)$|^(3[0-1])$" type="text" placeholder="день" maxlength="2" size="4" class="mdl-textfield__input">
							<span class="mdl-textfield__error"></span>
						</div>
						<select name="month" id="month" class="mdl-textfield mdl-js-textfield">
							<option value="месяц" class="mdl-textfield__input">месяц</option>
							<script>
								var month = ['январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь'];
								for (var i = 0; i < month.length; i++) {
									document.write('<option value="' + (i+1) + '" class="mdl-textfield__input">'+ month[i] +'</option>');
								};
							</script>
						</select>
						<div class="mdl-textfield mdl-js-textfield">
							<label for="year" class="mdl-textfield__label">год</label>
							<input id="year" name="year" pattern="^(19|20)\d{2}$" type="text" placeholder="год" maxlength="4" size="8" class="mdl-textfield__input">
							<span class="mdl-textfield__error"></span>
						</div>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="address" class="mdl-textfield__label">Адрес:</label>
						<input class="mdl-textfield__input" type="text" name="address" id="address"  value="<?=$Customer['address_ur']?>"/>
					</div>
					
					<button name="save_contacts" type="submit" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Сохранить</button>
					
				<?break;
				case 'delivery':?>
					<div class="line region">
						<label for="id_region">Область</label>
						<select required="required" name="id_region" id="id_region" onChange="regionSelect(id_region.value);">
							<option selected="selected" disabled="disabled">Выберите область</option>
							<?foreach($allregions as $region){ ?>
								<option <?=$region['region'] == $savedcity['region']?'selected="selected"':null;?> value="<?=$region['region']?>"><?=$region['region']?></option>
							<?}?>
						</select>
					</div>
					<div class="line city">
						<label for="id_city">Город</label>
						<select required="required" name="id_city" id="id_city" onChange="citySelect(id_city.value);">
							<?foreach($availablecities as $city){?>
								<option <?=$city['name'] == $savedcity['name']?'selected="selected"':null;?> value="<?=$city['names_regions']?>"><?=$city['name']?></option>
							<?}?>
						</select>
					</div>
					<div class="line id_delivery">
						<label for="id_delivery">Способ доставки</label>
						<select required="required" name="id_delivery" id="id_delivery" onChange="deliverySelect();">
							<?foreach($alldeliverymethods as $dm){?>
								<option <?=$dm['id_delivery'] == $Customer['id_delivery']?'selected="selected"':null;?> value="<?=$dm['id_delivery']?>"><?=$dm['name']?></option>
							<?}?>
						</select>
					</div>
					<div class="line delivery_service" id="delivery_service" <?=$saveddeliverymethod['id_delivery'] != 3?'style="display: none;"':null;?>>
						<label for="id_delivery_service">Служба доставки</label>
						<select name="id_delivery_service" onChange="deliveryServiceSelect(id_delivery_service.value);" id="id_delivery_service">
							<?foreach($availabledeliveryservices as $ds){?>
								<option <?=$ds['shipping_comp'] == $savedcity['shipping_comp']?'selected="selected"':null;?> value="<?=$ds['shipping_comp']?>"><?=$ds['shipping_comp']?></option>
							<?}?>
						</select>
					</div>
					<div class="line delivery_department" id="delivery_department" <?=$saveddeliverymethod['id_delivery'] != 3?'style="display: none;"':null;?>>
						<label for="id_delivery_department">Отделение в Вашем городе</label>
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
		<?if(isset($_GET['success'])){?>
			<div class="msg-success">
				<p><b>Успех!</b> Изменения успешно сохранены.</p>
			</div>
		<?}elseif(isset($_GET['unsuccess'])){?>
			<div class="msg-error">
				<p><b>Упс!</b> Что-то пошло не так.</p>
			</div>
		<?}?>
	</div> <!-- END class="edit_personal" -->
</div>
<script>
	$(document).ready(function() {
		$('div[class^="msg-"]').delay(3000).fadeOut(2000);
		
		$('#day').change(function(event) {
			if ($('#month').val() == 'месяц') {
				$('#month').css('border-color', 'red');
				console.log($(this));
				$(this).closest('.mdl-textfield').find('.mdl-textfield__error').html('Выберите месяц');
			};
		});

		$('#edit_contacts button[name="save_contacts"]').click(function(event) {
			var parent = $(this).closest('form'),
				email = parent.find('[name="email"]').val(),
				phone = parent.find('[name="phones"]').val(),
				last_name = parent.find('[name="last_name"]').val(),
				first_name = parent.find('[name="first_name"]').val(),
				middle_name = parent.find('[name="middle_name"]').val(),
				gender = parent.find('[name="gender"]').val(),
				birthday,
				address = parent.find('[name="address"]').val();

				if ($('#day').val()=='' && $('#month').val()=='месяц' && $('#year').val()=='') {
					console.log('ДА.');
				}else{console.log('NO.');}

				data = { email: email, phone: phone, last_name: last_name, first_name: first_name, middle_name: middle_name, gender: gender, address: address }

				ajax('cabinet', 'ChangeInfoUser', data).done(function(response){
				
					componentHandler.upgradeDom();
				});

		});
	});
</script>
