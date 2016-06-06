<div class="row">
	<div class="customer_cab col-md-6">
		<div id="bonus">

			<?if(!isset($_GET['t']) || $_GET['t']=='bonus_info'){?>
				<?if(!$Customer['bonus_card']){?>
					<div class="info_text">
						<p>Вы получили бонусную карту? Пришло время ее активировать! <br>
						Для этого заполните, пожалуйста, в <a href="?t=change_bonus">личных данных</a> информацию, которая поможет нам сделать Ваши покупки проще, а работу с нами - приятнее.</p>
						<hr>
						<a href="<?=_base_url?>/page/Skidki/" class="details">Детали бонусной программы</a>
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
					<a href="<?=_base_url?>/page/Skidki/" class="details">Условия бонусной программы.</a>
				<?}?>
			<?}elseif($_GET['t'] == 'change_bonus'){?>
				<form action="" method="POST">
					<?if(!$Customer['bonus_card']){?>
						<div class="msg-info">
							<p><b>Внимание!</b> Для активации бонусной карты, заполните эту форму!</p>
							<a href="<?=_base_url?>/page/Skidki/" class="details">Детали бонусной программы</a>
						</div>
						<div class="bonus_reg_block">
							<div id="bonus_card_line" class="line">
								<label for="bonus_card">№ бонусной карты: <span class="required">*</span></label><br>
								<input type="text" name="bonus_card" id="bonus_card" class="shortFild" autocomplete="off" value="<?=$Customer['bonus_card']?>" required />
								<div id="passwdconfirm_error"></div>
							</div>
							<div id="sex_line" class="line">
								<label>Пол: <span class="required">*</span></label>
								<p>
									<!-- <label class="sex" for="sex_male">
										<input type="radio" name="sex" id="sex_male" value="male" required /> Мужчина
									</label>
									<label class="sex" for="sex_female">
										<input type="radio" name="sex" id="sex_female" value="female" required /> Женщина
									</label> -->
									<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect sex" for="sex_male">
										<input type="radio" id="sex_male" class="mdl-radio__button" name="sex" value="male" required>
										<span class="mdl-radio__label">Мужчина</span>
									</label>

									<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="sex_female">
										<input type="radio" class="mdl-radio__button" name="sex" id="sex_female" value="female" required>
										<span class="mdl-radio__label">Женщина</span>
									</label>
								</p>
							</div>
							<div id="birthday_line" class="line">
								<label>День рождения: <span class="required">*</span></label>
								<?
									$days = range(1, 31);
									$years = range(1930, date('Y'));
								?>
								<div class="select">
									<select name="bday" id="bday" class="birthday" required>
										<option disabled selected>День</option>
										<?foreach($days AS $day){?>
											<option value="<?=$day?>"><?=$day?></option>
										<?}?>
									</select>
									<select name="bmonth" id="bmonth" class="birthday" required>
										<option disabled selected>Месяц</option>
										<option value="1">Январь</option>
										<option value="2">Февраль</option>
										<option value="3">Март</option>
										<option value="4">Апрель</option>
										<option value="5">Май</option>
										<option value="6">Июнь</option>
										<option value="7">Июль</option>
										<option value="8">Август</option>
										<option value="9">Сентябрь</option>
										<option value="10">Октябрь</option>
										<option value="11">Ноябрь</option>
										<option value="12">Декабрь</option>
									</select>
									<select name="byear" id="byear" class="birthday" required>
										<option disabled selected>Год</option>
										<?foreach($years AS $year){?>
											<option value="<?=$year?>"><?=$year?></option>
										<?}?>
									</select>
								</div>
								<!--<input type="date" name="birthday" id="birthday" required />-->
							</div>
							<div id="learned_from_line" class="line">
								<label for="learned_from">Как впервые узнали<br>о нашем интернет-магазине? <span class="required">*</span></label><br>
								<select name="learned_from" id="learned_from" required class="shortFild">
									<option value="" disabled selected></option>
									<option value="Поисковые системы">Поисковвые системы</option>
									<option value="Рекомендации друзей, коллег, знакомых">Рекомендации друзей, коллег, знакомых</option>
									<option value="Форумы">Форумы</option>
									<option value="Звонок">Звонок менеджера</option>
									<option value="Email">E-mail рассылка</option>
									<option value="Торговый представитель">Рассказал торговый представитель</option>
									<option value="Реклама в транспорте и другая внешняя реклама">Реклама в транспорте и другая внешняя реклама</option>
								</select>
							</div>
							<div id="buy_volume_line" class="line">
								<label for="buy_volume">Цели покупок: <span class="required">*</span></label><br>
								<select name="buy_volume" id="buy_volume" required class="shortFild">
									<option value="" disabled selected></option>
									<option value="Личные нужды">Личные нужды</option>
									<option value="Для реализации">Для реализации</option>
								</select>
							</div>
						</div>
					<?}else{?>
						<div id="bonus_card_line" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<label class="mdl-textfield__label" for="bonus_card">№ бонусной карты: <span class="required">*</span></label>
							<input class="mdl-textfield__input" type="text" name="bonus_card" id="bonus_card" value="<?=$Customer['bonus_card']?>" required />
						</div>
					<?}?>
					<hr>
					<div class="buttons_cab">
						<button type="submit" name="save_bonus" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Сохранить</button>
						<p class="fright"><span class="required">*</span> - поля обязательные для заполнения</p>
					</div>
				</form>
			<?}?>
		</div>
	</div>
</div>