<h1>Основная информация</h1>
<div class="edit_contacts_block">
	<form id="edit_contacts" class="editing" action="" method="post">
		<input required="required" type="hidden" name="id_user" id="id_user" value="<?=$User['id_user']?>"/>
		<input required="required" type="hidden" name="news" id="news" value="<?=$User['news']?>"/>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label class="mdl-textfield__label" for="email">E-mail:</label>
			<input class="mdl-textfield__input" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" type="text" name="email" id="email" value="<?=$User['email']?>"/>
			<span class="mdl-textfield__error">Введите корректный Email</span>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label for="phone" class="mdl-textfield__label">Контактный телефон:</label>
			<input class="mdl-textfield__input phone" type="tel" required name="phones" id="phones" value="<?=$User['phone']?>" pattern="\+\d{2}\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}\"/>
			<span class="mdl-textfield__error">Введите все цифры Вашего номера телефона</span>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label for="last_name" class="mdl-textfield__label">Фамилия:</label>
			<input class="mdl-textfield__input" pattern="^[\'А-Яа-я-ЇїІіЁё]+|^[\'A-Za-z-]+$" type="text" name="last_name" id="last_name" value="<?=$Customer['last_name']?>"/>
			<span class="mdl-textfield__error">Использованы недопустимые символы</span>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label for="first_name" class="mdl-textfield__label">Имя:</label>
			<input class="mdl-textfield__input" pattern="^[\'А-Яа-яЇїІіЁё]+|^[\'A-Za-z]+$" type="text" name="first_name" id="first_name" value="<?=$Customer['first_name']?>"/>
			<span class="mdl-textfield__error">Использованы недопустимые символы</span>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label for="middle_name" class="mdl-textfield__label">Отчество:</label>
			<input class="mdl-textfield__input" pattern="^[\'А-Яа-я-ЇїІіЁё]+|^[\'A-Za-z-]+$" type="text" type="text" name="middle_name" id="middle_name" value="<?=$Customer['middle_name']?>"/>
			<span class="mdl-textfield__error">Использованы недопустимые символы</span>
		</div>
		<div id="gend_block" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label class="label_for_gender" for="gender">Пол:</label>
			<div id="gender">
				<label class="mdl-radio mdl-js-radio" for="male">
					<input <?=$Customer['sex'] == 'male'?'checked="checked"':null;?> type="radio" name="gender" class="mdl-radio__button" id="male" value="male">Мужской
				</label> &nbsp;&nbsp;
				<label class="mdl-radio mdl-js-radio" for="female">
					<input <?=$Customer['sex'] == 'female'?'checked="checked"':null;?> type="radio" name="gender" class="mdl-radio__button" id="female" value="female">Женский
				</label>
			</div>
		</div>
		<div class="date_container">
			<div class="mdl-textfield mdl-js-textfield bdate_select_block">
				<label for="day" class="mdl-textfield__label">день</label>
				<input id="day" name="day" pattern="^(0?[1-9])$|^([1-2]\d)$|^(3[0-1])$" type="text" placeholder="день" maxlength="2" size="4" class="mdl-textfield__input day_js day" value="<?=isset($Customer['b_day'])?$Customer['b_day']:null;?>">
				<span class="mdl-textfield__error">Укажите день</span>
			</div>
			<input id="customer_month" type="hidden" value="<?=isset($Customer['b_month'])?$Customer['b_month']:null;?>">
			<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label bdate_select_block">
				<select name="month" class="month_js month mdl-selectfield__select">
					<?=!isset($Customer['b_month'])?print_r('<option disabled selected>месяц</option>'):null;?>
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
			<div class="mdl-textfield mdl-js-textfield bdate_select_block">
				<label for="year" class="mdl-textfield__label">год</label>
				<input id="year" name="year" pattern="^(19|20)\d{2}$" type="text" placeholder="год" maxlength="4" size="8" class="mdl-textfield__input year_js year" value="<?=isset($Customer['b_year'])?$Customer['b_year']:null;?>">
				<span class="mdl-textfield__error"></span>
			</div>
		</div>
		<div class="errMsg_js"></div>
		<input type="button" value="Сохранить" name="save_contacts" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
	</form>
</div>