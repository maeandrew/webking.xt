<div class="row">
	<div class="customer_cab col-md-6">
		<h1>Активация бонусной карты</h1>
		<a class="bonus_detalies" href="<?=Link::Custom('page', 'Skidki_i_bonusy');?>" class="details"><i class="material-icons">help_outline</i> Детали бонусной программы</a>
		<div class="msg-info bonus_info">
			<div class="msg_icon">
				<i class="material-icons hidden">check_circle</i>
				<i class="material-icons">info</i>
				<i class="material-icons hidden">warning</i>
				<i class="material-icons hidden">error</i>
			</div>
		    <p class="msg_title">!</p>
		    <p class="msg_text"></p>
		</div>		
		<div id="bonus">
			<?if(!isset($_GET['t']) || $_GET['t']=='bonus_info'){?>
				<?if(!$Customer['bonus_card']){?>
					<div class="info_text">
						<p>Вы получили бонусную карту?</p>
						<p>Пришло время ее активировать!</p> 
						<span>Для этого заполните, пожалуйста, в <a href="?t=change_bonus">личных данных</a> информацию, которая поможет нам сделать Ваши покупки проще, а работу с нами - приятнее.</span>
						<!-- <hr>
						<a href="<?=Link::Custom('page', 'Skidki_i_bonusy');?>" class="details">Детали бонусной программы</a> -->
					</div>
				<?}else{?>
					<div class="bonus_balance">
						<p>Бонусный баланс:
							<span class="value">
								<?=$Customer['bonus_balance']!=null?number_format($Customer['bonus_balance'],2,",",""):"20,00"?><span class="unit"> грн.</span>
							</span>
						</p>
						<p>Бонусный Процент:
							<span class="value">
								<?=$Customer['bonus_discount']!=null?$Customer['bonus_discount']:1?><span class="unit"> %</span>
							</span>
						</p>
					</div>
					<hr>
					<a href="<?=Link::Custom('page', 'Skidki_i_bonusy');?>" class="details">Условия бонусной программы.</a>
				<?}?>
			<?}elseif($_GET['t'] == 'change_bonus'){?>
						<!-- <div class="msg-info">
							<p><b>Внимание!</b> Для активации бонусной карты, заполните эту форму!</p>
						</div> -->
										
						<!-- <a href="<?=Link::Custom('page', 'Skidki_i_bonusy');?>" class="details">Детали бонусной программы</a> -->
				<form action="" method="POST">
					<?if(!$Customer['bonus_card']){?>
						<div class="bonus_reg_block">							
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<label class="mdl-textfield__label" for="email">№ бонусной карты:</label>
								<input class="mdl-textfield__input" type="text" name="bonus_card" id="bonus_card" class="shortFild" autocomplete="off" value="<?=$Customer['bonus_card']?>"  />
								<span class="mdl-textfield__error">Ошибка</span>
							</div>
							<div id="gend_block" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<label class="label_for_input_blocks" for="gender">Пол:</label>
								<div id="gender">
									<label class="mdl-radio mdl-js-radio" for="sex_male">
										<input <?=$Customer['sex'] == 'male'?'checked="checked"':null;?> type="radio" name="sex" class="mdl-radio__button" id="sex_male" value="male">Мужской
									</label> &nbsp;&nbsp;
									<label class="mdl-radio mdl-js-radio" for="sex_female">
										<input <?=$Customer['sex'] == 'female'?'checked="checked"':null;?> type="radio" name="sex" class="mdl-radio__button" id="sex_female" value="female">Женский
									</label>
								</div>
							</div>
							<div class="date_container">
								<!-- <p>День рождения: <span class="required">*</span></p> -->
								<label class="label_for_input_blocks" for="bdate">День рождения:</label>
								<div id="bdate" class="mdl-textfield mdl-js-textfield bdate_select_block">
									<label for="day" class="mdl-textfield__label">день </label>
									<input id="day" name="bday" pattern="^(0?[1-9])$|^([1-2]\d)$|^(3[0-1])$" type="text" placeholder="день" maxlength="2" size="4" class="mdl-textfield__input day_js day" value="<?=isset($Customer['b_day'])?$Customer['b_day']:null;?>">
									<span class="mdl-textfield__error">Укажите день</span>
								</div>
								<input id="customer_month" type="hidden" value="<?=isset($Customer['b_month'])?$Customer['b_month']:null;?>">
								<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label bdate_select_block">
									<select name="bmonth" class="month_js month mdl-selectfield__select">
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
									<input id="year" name="byear" pattern="^(19|20)\d{2}$" type="text" placeholder="год" maxlength="4" size="8" class="mdl-textfield__input year_js year" value="<?=isset($Customer['b_year'])?$Customer['b_year']:null;?>">
									<span class="mdl-textfield__error"></span>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--12-col discount_select_block">
								<!-- <p>Как впервые узнали о наc? <span class="required">*</span></p> -->
								<label class="label_for_input_blocks" for="learned_from">Как впервые узнали о наc?</label>
								<div id="learned_from" class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label discount_select">
									<select name="learned_from" class="mdl-selectfield__select learned_from_js">
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
								<!-- <p>Цели покупок: <span class="required">*</span></label></p> -->
								<label class="label_for_input_blocks" for="buy_volume">Цели покупок:</label>
								<div id="buy_volume" class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label discount_select">
									<select name="buy_volume" class="mdl-selectfield__select buy_volume_js">
										<option disabled selected>Выбрать</option>
										<option value="Личные нужды">Личные нужды</option>
										<option value="Для реализации">Для реализации</option>
									</select>
								</div>
							</div>							
						</div>
					<?}else{?>
						<div id="bonus_card_line" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<label class="mdl-textfield__label" for="bonus_card">№ бонусной карты:</label>
							<input class="mdl-textfield__input" type="text" name="bonus_card" id="bonus_card" value="<?=$Customer['bonus_card']?>" required />
						</div>
					<?}?>
					<!-- <hr> -->
					<div class="buttons_cab save_btn_js">
						<button type="submit" name="save_bonus" disabled class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored save_btn_js">Сохранить</button>
						<!-- <p class="fright"><span class="required">*</span> - поля обязательные для заполнения</p> -->
					</div>
				</form>
			<?}?>
		</div>
	</div>
</div>
<script>
	$(function(){		
		$('input, select').on('change', function(){			
			var bonus_card = $('#bonus_card').val();
			var day = $('#day').val();
			var month = $('.month_js').val();
			var year = $('#year').val();
			var learned_from = $('.learned_from_js').val();
			var buy_volume = $('.buy_volume_js').val();
			var check_gender = 0;
			$('#gender input').each(function(){
				if ($(this).prop("checked")) {
					check_gender = 1;
				}
			});
			if ((bonus_card && day && month && year && learned_from && buy_volume !== null) &&  check_gender !== 0) {
				$('.save_btn_js').attr('disabled', false);
			}else{
				$('.save_btn_js').attr('disabled', true);
			}
		});
	});
</script>