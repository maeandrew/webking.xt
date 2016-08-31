<h1><?=$Customer['bonus_card']?'Смена бонусной карты':'Активация бонусной карты'?></h1>
<a class="bonus_detalies" href="<?=Link::Custom('page', 'Skidki_i_bonusy');?>" class="details"><i class="material-icons">help_outline</i> Детали бонусной программы</a>
<?if(!$Customer['bonus_card'] && isset($msg)){?>
	<div class="msg-<?=$msg['type']?> bonus_info">
		<div class="msg_icon">
			<i class="material-icons"></i>
		</div>
	    <p class="msg_title">!</p>
	    <p class="msg_text"><?=$msg['text']?></p>
	</div>
<?}?>
<form action="<?=$_SERVER['REQUEST_URI']?>" method="POST" class="bonus_content">
	<?if(!$Customer['bonus_card']){?>
		<div class="bonus_reg_block">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<label class="mdl-textfield__label" for="email">№ бонусной карты:</label>
				<input class="mdl-textfield__input check_val_js" pattern="^\d+$" type="text" name="bonus_card" id="bonus_card" class="shortFild" autocomplete="off" value="<?=$Customer['bonus_card']?>"  />
				<span class="mdl-textfield__error">Ошибка. Введите числа</span>
			</div>
			<?if(!$Customer['sex']){?>
				<div id="gend_block" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<label class="label_for_input_blocks" for="gender">Пол:</label>
					<div id="gender">
						<label class="mdl-radio mdl-js-radio" for="sex_male">
							<input <?=$Customer['sex'] == 'male'?'checked="checked"':null;?>   type="radio" name="sex" class="mdl-radio__button check_val_js" id="sex_male" value="male">Мужской
						</label> &nbsp;&nbsp;
						<label class="mdl-radio mdl-js-radio" for="sex_female">
							<input <?=$Customer['sex'] == 'female'?'checked="checked"':null;?> type="radio" name="sex" class="mdl-radio__button check_val_js" id="sex_female" value="female">Женский
						</label>
					</div>
				</div>
			<?}?>
			<?if(!$Customer['b_day'] || !$Customer['b_month'] || !$Customer['b_year']){?>
				<label class="label_for_input_blocks" for="date_container">День рождения:</label>
				<div id="date_container" class="date_container">
					<div id="bdate" class="mdl-textfield mdl-js-textfield bdate_select_block">
						<label for="day" class="mdl-textfield__label">день </label>
						<input id="day" name="bday" pattern="^(0?[1-9])$|^([1-2]\d)$|^(3[0-1])$" type="text" placeholder="день" maxlength="2" size="4" class="mdl-textfield__input day_js day check_val_js" value="<?=isset($Customer['b_day'])?$Customer['b_day']:null;?>">
						<span class="mdl-textfield__error">Укажите день</span>
					</div>
					<input id="customer_month" type="hidden" value="<?=isset($Customer['b_month'])?$Customer['b_month']:null;?>">
					<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label bdate_select_block">
						<select name="bmonth" class="month_js month mdl-selectfield__select check_val_js">
							<?=!isset($Customer['b_month'])?print_r('<option disabled selected>месяц</option>'):null;?>
							<script>
								var month = ['январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь'],
									customer_month = $('#customer_month').val(),
									temp;
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
						<input id="year" name="byear" pattern="^(19|20)\d{2}$" type="text" placeholder="год" maxlength="4" size="8" class="mdl-textfield__input year_js year check_val_js" value="<?=isset($Customer['b_year'])?$Customer['b_year']:null;?>">
						<span class="mdl-textfield__error"></span>
					</div>
				</div>
			<?}?>
			<div class="mdl-cell mdl-cell--12-col discount_select_block">
				<label class="label_for_input_blocks" for="learned_from">Как впервые узнали о наc?</label>
				<div id="learned_from" class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label discount_select">
					<select name="learned_from" class="mdl-selectfield__select learned_from_js check_val_js">
						<option disabled selected>Выбрать</option>
						<option value="Поисковые системы">Поисковвые системы</option>
						<option value="Рекомендации друзей, коллег, знакомых">Рекомендации друзей, коллег, знакомых</option>
						<option value="Форумы">Форумы</option>
						<option value="Звонок">Звонок менеджера</option>
						<option value="Email">E-mail рассылка</option>
						<option value="Торговый представитель">Рассказал торговый представитель</option>
						<option value="Реклама в транспорте и другая внешняя реклама">Реклама в транспорте и другая внешняя реклама</option>
					</select>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--12-col discount_select_block">
				<label class="label_for_input_blocks" for="buy_volume">Цели покупок:</label>
				<div id="buy_volume" class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label discount_select">
					<select name="buy_volume" class="mdl-selectfield__select buy_volume_js check_val_js">
						<option disabled selected>Выбрать</option>
						<option value="Личные нужды">Личные нужды</option>
						<option value="Для реализации">Для реализации</option>
					</select>
				</div>
			</div>
		</div>
		<div class="buttons_cab save_btn_js">
			<button type="submit" name="save_bonus" disabled class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored save_btn_js">Сохранить</button>
		</div>
	<?}else{?>
		<div id="bonus_card_line" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label class="mdl-textfield__label" for="bonus_card">№ бонусной карты:</label>
			<input class="mdl-textfield__input" pattern="^\d+$" type="text" name="bonus_card" id="bonus_card" value="<?=$Customer['bonus_card']?>" required />
			<span class="mdl-textfield__error">Ошибка. Введите числа</span>
		</div>
		<div class="buttons_cab save_btn_js">
			<button type="submit" name="update_bonus" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored save_btn_js">Изменить</button>
		</div>
	<?}?>
</form>