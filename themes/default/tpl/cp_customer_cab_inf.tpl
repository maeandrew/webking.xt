<style>
.errmsg{
	color: #f00;
	font-size: 12px;
}
</style>
<div class="cabinet">
<ul id="breadcrumbs">
	<li><a href="<?=_base_url?>/">Главная</a>&gt;</li>
	<li><a href="<?=_base_url?>/cabinet">Личный кабинет</a>&gt;</li>
	<li><a href="<?=_base_url?>/cabinet/info/">Редактирование личной информации</a></li>
</ul>
<h2>Редактирование личных данных</h2>
<div id="order" class="order">
	<form id="edit" action="<?=_base_url?>/cabinet/info/" method="post">
		<section class="left">
			<fieldset>
				<legend>Основная информация:</legend>
				<div class="line login">
					<label for="login">Логин</label>
					<input required type="text" name="login" id="login" value="<?=$User['name']?>"/>
					<input required type="hidden" name="id_user" id="id_user" value="<?=$User['id_user']?>"/>
				</div>
				<div class="line email">
					<label for="email">E-mail</label>
					<input required type="text" name="email" id="email" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" value="<?=$User['email']?>"/>
					<label for="news">Подписаться на новостную рассылку</label>
					<input type="checkbox" name="news" id="news" <?if($User['news']==1){?>checked<?}?> />
				</div>
				<div class="line passwd">
					<label for="password">Пароль</label><span class="errmsg"> <?=isset($errm['passwd'])?$errm['passwd']:null;?></span>
					<input type="password" name="passwd" id="passwd" value=""/>
				</div>
				<div class="line passwdconfirm">
					<label for="password">Подтверждение пароля</label><span class="errmsg"><?=isset($errm['passwdconfirm'])?$errm['passwdconfirm']:null;?></span>
					<input type="password" name="passwdconfirm" id="passwdconfirm" value=""/>
				</div>
				<div class="line person">
					<label for="name">Контактное лицо</label>
					<input required type="text" name="cont_person" id="name" value="<?=$Customer['cont_person']?>"/>
					<p class="shadowtext">(Сидоров Иван Петрович) - образец!</p>
				</div>
				<div class="line phone">
					<label for="phone">Контактный телефон</label>
					<div class="phones">
						<input required type="tel" name="phones" id="phone" maxlength="15" value="<?=$Customer['phones']?>"/>
					</div>
					<p class="shadowtext">(099 123-45-67) - образец!</p>
				</div>
			</fieldset>
			<fieldset>
				<legend>Дополнительная информация:</legend>
				<div id="contragent" class="line">
					<label for="id_manager">Менеджер</label>
					<div class="select">
						<select required name="id_manager" id="id_manager">
							<option selected disabled class="cntr_0" value="">--Выберите менеджера--</option>
							<?$ii=1;foreach($manager as $item){
								if($SavedContragent['id_user'] && $item['id_user']==$SavedContragent['id_user']){?>
									<option selected class="cntr_<?=$ii?>" value="<?=$SavedContragent['id_user']?>"><?=$SavedContragent['name_c']?></option>
								<?}else{?>
								<option class="cntr_<?=$ii?>" value="<?=$item['id_user']?>"><?=$item['name_c']?></option>
							<?}$ii++;}?>
						</select>
					</div>
				</div>
			</fieldset>
		</section>
		<section class="right">
			<fieldset>
				<legend>Доставка:</legend>
				<div class="line region">
					<label for="id_region">Область</label>
					<div class="select">
						<select required name="id_region" id="id_region" onBlur="regionSelect(id_region.value);" onChange="regionSelect(id_region.value);">
							<option disabled selected>Выберите область</option>
							<?foreach ($regions as $item){
								if($item['region']==$SavedCity['region']){?>
									<option selected value="<?=$SavedCity['region']?>"><?=$SavedCity['region']?></option>
								<?}else{?>
									<option value="<?=$item['region']?>"><?=$item['region']?></option>
								<?}?>
							<?}?>
						</select>
					</div>
				</div>
				<div class="line city">
					<label for="id_city">Город</label>
					<div class="select">
						<select required name="id_city" id="id_city" onBlur="citySelect(id_city.value);" onChange="citySelect(id_city.value);">
							<?foreach ($citys as $item){
								if($item['region']==$SavedCity['region']){
									if($item['name']==$SavedCity['name']){?>
										<option selected value="<?=$SavedCity['names_regions']?>"><?=$SavedCity['name']?></option>
									<?}else{?>
										<option value="<?=$item['names_regions']?>"><?=$item['name']?></option>
									<?}?>
								<?}?>
							<?}?>
						</select>
					</div>
				</div>
				<div class="line id_delivery">
					<label for="id_delivery">Способ доставки</label>
					<div class="select">
						<select name="id_delivery" id="id_delivery" onBlur="deliverySelect();" onChange="deliverySelect();">
							<?foreach($DeliveryMethod as $item){?>
								<?if($item['id_delivery'] == $Customer['id_delivery']){?>
									<option selected value="<?=$SavedDeliveryMethod['id_delivery']?>"><?=$SavedDeliveryMethod['name']?></option>
								<?}else{?>
									<option value="<?=$item['id_delivery']?>"><?=$item['name']?></option>
								<?}?>
							<?}?>
						</select>
					</div>
				</div>
				<div class="line delivery_service" id="delivery_service" <?if($SavedDeliveryMethod['id_delivery']!=3){?>style="display: none;"<?}?>>
					<label for="id_delivery_service">Служба доставки</label>
					<?//print_r($delivery_services);?>
					<div class="select">
						<select name="id_delivery_service" onBlur="deliveryServiceSelect(id_delivery_service.value);" onChange="deliveryServiceSelect(id_delivery_service.value);" id="id_delivery_service">
							<?foreach($delivery_services as $item){
								if($item['region']==$SavedCity['region'] && $item['name']==$SavedCity['name']){
									if($item['id_city']==$SavedCity['id_city']){?>
										<option selected value="<?=$SavedCity['shipping_comp']?>"><?=$SavedCity['shipping_comp']?></option>
									<?}else{?>
										<option value="<?=$item['shipping_comp']?>"><?=$item['shipping_comp']?></option>
									<?}?>
								<?}?>
							<?}?>
						</select>
					</div>
				</div>
				<div class="line delivery_department" id="delivery_department" <?if($SavedDeliveryMethod['id_delivery']!=3){?>style="display: none;"<?}?>>
					<label for="id_delivery_department">Отделение в Вашем городе</label>
					<div class="select">
						<select name="id_delivery_department" id="id_delivery_department">
							<?foreach ($delivery as $item){
								if($item['id_city']==$SavedCity['id_city']){?>
									<option selected value="<?=$SavedCity['id_city']?>"><?=$SavedCity['address']?></option>
								<?}else{?>
									<option value="<?=$item['id_city']?>"><?=$item['address']?></option>
								<?}?>
							<?}?>
						</select>
					</div>
				</div>
			</fieldset>
		</section>
		<section class="bonus">
			<fieldset>
				<legend>Бонусная программа:</legend>
				<?if(!$Customer['bonus_card']){?>
					<div class="msg inf">
						<span style="font-size: 1em;font-weight: bold;">Внимание!</span><br>Для активации бонусной карты, заполните эту форму!
					</div>
					<div id="bonus_card_line" class="line">
						<label for="bonus_card">№ бонусной карты</label>
						<input type="text" name="bonus_card" id="bonus_card" autocomplete="off" value="<?=$Customer['bonus_card']?>" required />
						<div id="passwdconfirm_error"></div>
					</div>
					<div id="sex_line" class="line">
						<label>Пол</label>
						<label class="sex" for="sex_male">
							<input type="radio" name="sex" id="sex_male" value="male" required /> Мужчина
						</label>
						<label class="sex" for="sex_female">
							<input type="radio" name="sex" id="sex_female" value="female" required /> Женщина
						</label>
					</div>
					<div id="birthday_line" class="line">
						<label>День рождения</label>
						<div class="clear"></div>
						<?
							$days = range(1, 31);
							$years = range(1930, date('Y'));
						?>
						<select name="bday" id="bday" class="birthday" required>
							<option disabled selected></option>
							<?foreach($days AS $day){?>
								<option value="<?=$day?>"><?=$day?></option>
							<?}?>
						</select>
						<select name="bmonth" id="bmonth" class="birthday" required>
							<option disabled selected></option>
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
							<option disabled selected></option>
							<?foreach($years AS $year){?>
								<option value="<?=$year?>"><?=$year?></option>
							<?}?>
						</select>
						<!--<input type="date" name="birthday" id="birthday" required />-->
					</div>
					<div id="learned_from_line" class="line">
						<label for="learned_from">Как впервые узнали о нашем интернет-магазине?</label>
						<div class="clear"></div>
						<select name="learned_from" id="learned_from" required>
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
						<label for="buy_volume">Цели покупок</label>
						<div class="clear"></div>
						<select name="buy_volume" id="buy_volume" required>
							<option value="" disabled selected></option>
							<option value="Личные нужды">Личные нужды</option>
							<option value="Для реализации">Для реализации</option>
						</select>
					</div>
				<?}else{?>
					<div id="bonus_card_line" class="line">
						<label for="bonus_card">№ бонусной карты</label>
						<input type="text" name="bonus_card" id="bonus_card" value="<?=$Customer['bonus_card']?>" required />
					</div>
				<?}?>
			</fieldset>
		</section>
		<div class="clear"></div>
		<div class="buttons_cab">
			<input name="apply" type="submit" class="confirm" value="Готово"/>
			<input name="cancel" type="submit" class="cancel" value="Отменить"/>
		</div>
	</form>
</div>
<div class="clear"></div>
</div>