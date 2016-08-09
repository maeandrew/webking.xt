<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="contagentae" class="grid">
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<label for="name">Имя:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
						<input type="text" name="name" id="name" class="input-l" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" autofocus>
					</div>
					<div class="col-md-12">
						<label for="email">E-mail:</label><?=isset($errm['email'])?"<span class=\"errmsg\">".$errm['email']."</span><br>":null?>
						<input type="text" name="email" id="email" class="input-l" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):null?>">
					</div>
					<div class="col-md-12">
						<label for="passwd">Пароль:</label><?=isset($errm['passwd'])?"<span class=\"errmsg\">".$errm['passwd']."</span><br>":null?>
						<input type="password" name="passwd" id="passwd" class="input-l" value="<?=isset($_POST['passwd'])?htmlspecialchars($_POST['passwd']):null?>">
					</div>
					<div class="col-md-12">
						<label for="phone">Телефоны:</label><?=isset($errm['phone'])?"<span class=\"errmsg\">".$errm['phone']."</span><br>":null?>
						<textarea name="phone" id="phone" class="input-l" rows="2" cols="80"><?=isset($_POST['phone'])?htmlspecialchars($_POST['phone']):null?></textarea>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						<label for="photo">Фото:</label><?=isset($errm['photo'])?"<span class=\"errmsg\">".$errm['photo']."</span><br>":null?>
						<input type="text" name="photo" id="photo" class="input-l" value="<?=isset($_POST['photo'])?htmlspecialchars($_POST['photo']):null?>">
					</div>
					<div class="col-md-12">
						<label for="site">Сайт:</label><?=isset($errm['site'])?"<span class=\"errmsg\">".$errm['site']."</span><br>":null?>
						<input type="text" name="site" id="site" class="input-l" value="<?=isset($_POST['site'])?htmlspecialchars($_POST['site']):null?>">
					</div>
					<div class="col-md-12">
						<label for="name_c">Отображение в кабинете покупателей:</label><?=isset($errm['name_c'])?"<span class=\"errmsg\">".$errm['name_c']."</span><br>":null?>
						<input type="text" name="name_c" id="name_c" class="input-l" value="<?=isset($_POST['name_c'])?htmlspecialchars($_POST['name_c']):null?>">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<label for="descr">Комментарий:</label><?=isset($errm['descr'])?"<span class=\"errmsg\">".$errm['descr']."</span><br>":null?>
				<textarea name="descr" id="descr" class="input-l" rows="4" cols="80"><?=isset($_POST['descr'])?htmlspecialchars($_POST['descr']):null?></textarea>
			</div>
			<div class="col-md-12">
				<label>Данные отправителя:</label><?=isset($errm['details'])?"<span class=\"errmsg\">".$errm['details']."</span><br>":null?>
				<!--<textarea name="details" id="details" rows="1" cols="80"><?=isset($_POST['details'])?htmlspecialchars($_POST['details']):null?></textarea>-->
			</div>
			<div class="col-md-6">
				<table border="0" cellpadding="0" cellspacing="0" class="list paper_shadow_1">
					<colgroup>
						<col width="5%"/>
						<col width="95%"/>
					</colgroup>
					<thead>
						<tr>
							<td>Связать</td>
							<td>Имя</td>
						</tr>
					</thead>
					<tbody>
						<?if(!empty($remitters)){
							foreach($remitters as $rem){?>
								<tr>
									<td>
										<input type="checkbox" name="details<?=$rem['id']?>" <?=(isset($_POST['details']) && in_array($rem['id'], explode(";",$_POST['details'])))?"checked":null?> value="<?=$rem['id']?>">
									</td>
									<td><?=$rem['name']?></td>
								</tr>
							<?}
						}?>
					</tbody>
				</table>
			</div>
		<!-- <div class="hidden">
			<div style="margin-top: 20px;"></div>
				<?foreach($_POST['parkings_ids'] as $pid){?>
					<div id="parkingblock">
						<p>Стоянка:</p><?=isset($errm['parkings_ids'])?"<span class=\"errmsg\">".$errm['parkings_ids']."</span><br>":null?>
						<select name="parkings_ids[]">
								<option value="0">нет</option>
							<?foreach ($parkings as $item){?>
								<option <?=($item['id_parking']==$pid)?'selected="true"':null?> value="<?=$item['id_parking']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</div>
				<?}?>
			<div id="addlinkparking" style="margin-top:10px"><a class="dashed" href="javascript://" onclick="AddParking(this)">Добавить стоянку</a></div>
			<div style="margin-top: 20px;"></div>
				<?foreach ($_POST['citys_ids'] as $cid){?>
					<div id="cityblock">
						<p>Город:</p><?=isset($errm['citys_ids'])?"<span class=\"errmsg\">".$errm['citys_ids']."</span><br>":null?>
						<select name="citys_ids[]">
								<option value="0">нет</option>
							<?foreach ($citys as $item){?>
								<option <?=($item['id_city']==$cid)?'selected="true"':null?> value="<?=$item['id_city']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</div>
				<?}?>
			<div id="addlinkcity" style="margin-top:10px"><a class="dashed" href="javascript://" onclick="AddCity(this)">Добавить город</a></div>
			<div style="margin-top: 20px;"></div>
				<?foreach ($_POST['delivery_services_ids'] as $did){?>
					<div id="delivery_serviceblock">
						<p>Служба доставки:</p><?=isset($errm['delivery_services_ids'])?"<span class=\"errmsg\">".$errm['delivery_services_ids']."</span><br>":null?>
						<select name="delivery_services_ids[]">
							<option value="0">нет</option>
							<?foreach ($delivery_services as $item){?>
								<option <?=($item['id_delivery_service']==$did)?'selected="true"':null?> value="<?=$item['id_delivery_service']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</div>
				<?}?>
			<div id="addlinkdelivery_service" style="margin-top:10px"><a class="dashed" href="javascript://" onclick="AddDeliveryService(this)">Добавить службу доставки</a></div>
		</div> -->
		<div class="col-md-12">
			<label for="active">Отключить контрагента
				<input style="vertical-align:middle;margin: 0;" type="checkbox" name="active" id="active" <?=isset($_POST['active'])&&(!$_POST['active'])?'checked="checked" value="on"':null?>>
			</label>
			<label for="remote">Удаленный контрагент
				<input style="vertical-align:middle;margin: 0;" type="checkbox" name="remote" id="remote" <? if(isset($_POST['remote']) && $_POST['remote'] != 0){ echo  'value="on" checked="checked"';}?>>
			</label>
			<input type="hidden" name="gid" id="gid" value="<?=isset($_POST['gid'])?$_POST['gid']:0?>">
			<input type="hidden" name="id_user" id="id_user" value="<?=isset($_POST['id_user'])?$_POST['id_user']:0?>">
			<button name="smb" type="submit" id="form_submit" class="btn-l-default save-btn">Сохранить</button>
		</div>
	</form>
</div>
<!-- <div id="templates" class="hidden">
	<div id="parkingblock">
		<p>Стоянка:</p>
		<select name="parkings_ids[]">
		<option value="0">нет</option>
			<?foreach ($parkings as $item){?>
				<option  value="<?=$item['id_parking']?>"><?=$item['name']?></option>
			<?}?>
		</select>
	</div>
	<div id="cityblock">
		<p>Город:</p>
		<select name="citys_ids[]">
		<option value="0">нет</option>
			 <?foreach ($citys as $item){?>
				<option  value="<?=$item['id_city']?>"><?=$item['name']?></option>
			 <?}?>
		</select>
	</div>
	<div id="delivery_serviceblock">
		<p>Служба доставки:</p>
		<select name="delivery_services_ids[]">
		<option value="0">нет</option>
			<?foreach ($delivery_services as $item){?>
				<option  value="<?=$item['id_delivery_service']?>"><?=$item['name']?></option>
			<?}?>
		</select>
	</div>
</div> -->
<?if(isset($dates)){?>
	<h2>Календарь контрагента</h2>
	<div class="row">
		<div class="col-md-4">
			<table border="0" cellpadding="0" cellspacing="0" class="list paper_shadow_1 bg-white">
				<thead>
					<tr>
						<td class="left">Дата</td>
						<td class="left">Сумма</td>
						<td class="left">Рабочий</td>
					</tr>
				</thead>
				<?foreach($dates as $d=>$a){?>
					 <tr>
						<td><span <?=isset($a['red'])?'style="color: Red"':null;?>><?=$a['d_word']?></span>, <?=$d?></td>
						<td>
							<p><?=isset($a['limit_sum_day'])&&$a['limit_sum_day']?$a['limit_sum_day']:'-'?></p>
						</td>
						<td>
							<p><?=isset($a['work_day'])&&$a['work_day']?'+':'-'?></p>
						</td>
					 </tr>
				<?}?>
			</table>
		</div>
	</div>
	<div class="clear"></div>
<?}?>
<script>
	function AddParking(){
		$('#templates #parkingblock').clone().insertBefore('#addlinkparking');
	}
	function AddCity(){
		$('#templates #cityblock').clone().insertBefore('#addlinkcity');
	}
	function AddDeliveryService(){
		$('#templates #delivery_serviceblock').clone().insertBefore('#addlinkdelivery_service');
	}
</script>