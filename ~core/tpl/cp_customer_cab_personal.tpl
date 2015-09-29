<div class="row">
	<div class="customer_cab col-md-6">
		<form action=""method="GET">
			<ul id="nav">
				<li>
					<button name="t" value="contacts" <?=(!isset($_GET['t']) || $_GET['t']=='contacts')?'class="active"':null;?>>
						Основная информация
					</button>
				</li>
				<li>
					<button name="t" value="delivery" <?=(isset($_GET['t']) && $_GET['t']=='delivery')?'class="active"':null;?>>
						Адрес доставки
					</button>
				</li>
			</ul>
		</form>
		<div id="edit_personal">
			<form id="edit_contacts" class="editing" action="" method="post">
				<input required="required" type="hidden" name="id_user" id="id_user" value="<?=$User['id_user']?>"/>
				<input required="required" type="hidden" name="news" id="news" value="<?=$User['news']?>"/>
				<?!isset($_GET['t'])?$var = '': $var = $_GET['t'];?>
				<?switch($var){
					default:?>
					<div class="line email">
						<label for="email">E-mail:</label>
						<input required="required" type="text" name="email" id="email" value="<?=$User['email']?>"/>
					</div>
					<div class="line last_name">
						<label for="last_name">Фамилия:</label>
						<input required="required" type="text" name="last_name" id="last_name" value="<?=$Customer['last_name']?>"/>
					</div>
					<div class="line first_name">
						<label for="name">Имя:</label>
						<input required="required" type="text" name="first_name" id="first_name" value="<?=$Customer['first_name']?>"/>
					</div>
					<div class="line middle_name">
						<label for="middle_name">Отчество:</label>
						<input required="required" type="text" name="middle_name" id="middle_name" value="<?=$Customer['middle_name']?>"/>
					</div>
					<div class="line phone">
						<label for="phone">Контактный телефон:</label>
						<input required="required" type="tel" name="phones" id="phone" class="phone" maxlength="15" value="<?=$Customer['phones']?>"/>
					</div>
					<div class="buttons_cab">
						<button name="save_contacts" type="submit" class="btn-m-green">Сохранить изменения</button>
					</div>
				<?break;
				case 'delivery':?>
					<div class="line region">
						<label for="id_region">Область</label>
						<select required="required" name="id_region" id="id_region" onChange="regionSelect(id_region.value);">
							<option selected="selected" disabled="disabled">Выберите область</option>
							<?foreach($allregions as $region){?>
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
						<button name="save_delivery" type="submit" class="btn-m-green">Сохранить изменения</button>
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
	$('div[class^="msg-"]').delay(3000).fadeOut(2000);
</script>