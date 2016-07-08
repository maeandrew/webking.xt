<h1>Адрес доставки</h1>
<?if(isset($addresses) && !empty($addresses)){?>
	<div class="saved_addresses">
		<?foreach($addresses as $address){?>
			<div class="address">
				<h4><?=$address['title']?><div class="actions"><i class="material-icons">edit</i><i class="material-icons">delete</i></div></h4>
				<ul>
					<li><span>Область:</span><?=$address['region']?></li>
					<li><span>Город:</span><?=$address['city']?></li>
					<li><span>Способ доставки:</span><?=$address['id_delivery']?></li>
					<li><span>Транспортная компания:</span><?=$address['id_delivery_service']?></li>
					<li><span>Отделение:</span><?=$address['department']?></li>
				</ul>
			</div>
		<?}?>
	</div>
<?}?>
<!-- <div class="saved_addresses">
	<div class="address">
		<h4>Дом<div class="actions"><i class="material-icons">edit</i><i class="material-icons">delete</i></div></h4>
		<ul>
			<li><span>Область:</span>Харьковская область</li>
			<li><span>Город:</span>Харьков</li>
			<li><span>Способ доставки:</span>Транспортная компания</li>
			<li><span>Транспортная компания:</span>Новая почта</li>
			<li><span>Отделение:</span>№ 5: пгт. Песочин, пл. Ю. Кононенко, 1а</li>
		</ul>
	</div>
	<div class="address">
		<h4>Работа<div class="actions"><i class="material-icons">edit</i><i class="material-icons">delete</i></div></h4>
		<ul>
			<li><span>Область:</span>Харьковская область</li>
			<li><span>Город:</span>Харьков</li>
			<li><span>Способ доставки:</span>Транспортная компания</li>
			<li><span>Транспортная компания:</span>Новая почта</li>
			<li><span>Отделение:</span>№ 5: пгт. Песочин, пл. Ю. Кононенко, 1а</li>
		</ul>
	</div>
</div> -->
<div class="add_new_address mdl-grid">
	<form id="edit_contacts" class="editing" action="" method="post">
		<input required="required" type="hidden" name="id_user" id="id_user" value="<?=$User['id_user']?>"/>
		<!-- <input required="required" type="hidden" name="news" id="news" value="<?=$User['news']?>"/> -->
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" name="title" id="title" required>
				<label class="mdl-textfield__label" for="title">Название</label>
			</div>
			<p class="explanation">например - Дом, Работа</p>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label region">
				<select id="region" name="region" class="mdl-selectfield__select" onChange="regionSelect($(this));">
					<option disabled selected>Выберите область</option>
					<?foreach($allregions as $region){ ?>
						<option value="<?=$region['title']?>"><?=$region['title']?></option>
					<?}?>
				</select>
				<label class="mdl-selectfield__label" for="region">Область</label>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label city">
				<select id="city" name="city" class="mdl-selectfield__select" disabled onChange="citySelect($(this));">
					<?foreach($availablecities as $city){?>
						<option value="<?=$city['names_regions']?>"><?=$city['name']?></option>
					<?}?>
				</select>
				<label class="mdl-selectfield__label" for="city">Город</label>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label delivery">
				<select id="id_delivery" name="id_delivery" class="mdl-selectfield__select" disabled onChange="deliverySelect($(this));">
					<!-- <?foreach($alldeliverymethods as $dm){?>
						<option value="<?=$dm['id_delivery']?>"><?=$dm['name']?></option>
					<?}?> -->
				</select>
				<label class="mdl-selectfield__label" for="id_delivery">Способ доставки</label>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label delivery_service ">
				<select id="id_delivery_service" name="id_delivery_service" class="mdl-selectfield__select" onChange="deliveryServiceSelect($(this));">
					<?foreach($availabledeliveryservices as $ds){?>
						<option value="<?=$ds['shipping_comp']?>"><?=$ds['shipping_comp']?></option>
					<?}?>
				</select>
				<label class="mdl-selectfield__label" for="id_delivery_service">Служба доставки</label>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label delivery_department ">
				<select id="id_delivery_department" name="id_delivery_department" class="mdl-selectfield__select">
					<?foreach($availabledeliverydepartment as $dd){?>
						<option value="<?=$dd['id_city']?>"><?=$dd['address']?></option>
					<?}?>
				</select>
				<label class="mdl-selectfield__label" for="id_delivery_department">Отделение</label>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-textfield mdl-js-textfield address ">
				<textarea class="mdl-textfield__input" type="text" rows="3" id="address" ></textarea>
				<label class="mdl-textfield__label" for="address">Адрес доставки</label>
			</div>
				<span class="">Формат адреса: ул./пер., дом, кв.</span>
		</div>
		<div class="buttons_cab">
			<button name="save_delivery" type="submit" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Сохранить</button>
		</div>
	</form>
</div>