<h1>Адрес доставки</h1>
<div class="saved_addresses">
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
</div>
<div class="add_new_address">
	<form id="edit_contacts" class="editing" action="" method="post">
		<input required="required" type="hidden" name="id_user" id="id_user" value="<?=$User['id_user']?>"/>
		<input required="required" type="hidden" name="news" id="news" value="<?=$User['news']?>"/>
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
	</form>
</div>