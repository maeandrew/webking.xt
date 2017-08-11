<div class="col-md-12">
	<label for="last_name">Фамилия:</label>
	<?=isset($errm['last_name'])?"<span class=\"errmsg\">".$errm['last_name']."</span><br>":null?>
	<input type="text" name="last_name" id="last_name" class="input-m" value="<?=isset($_POST['last_name'])?htmlspecialchars($_POST['last_name']):null?>">
</div>
<div class="col-md-12">
	<label for="first_name">Имя:</label>
	<?=isset($errm['first_name'])?"<span class=\"errmsg\">".$errm['first_name']."</span><br>":null?>
	<input type="text" name="first_name" id="first_name" class="input-m" value="<?=isset($_POST['first_name'])?htmlspecialchars($_POST['first_name']):null?>">
</div>
<div class="col-md-12">
	<label for="middle_name">Отчество:</label>
	<?=isset($errm['middle_name'])?"<span class=\"errmsg\">".$errm['middle_name']."</span><br>":null?>
	<input type="text" name="middle_name" id="middle_name" class="input-m" value="<?=isset($_POST['middle_name'])?htmlspecialchars($_POST['middle_name']):null?>">
</div>
<div class="col-md-12">
	<label for="id_contragent">Личный менеджер:</label>
	<?=isset($errm['id_contragent'])?"<span class=\"errmsg\">".$errm['id_contragent']."</span><br>":null?>
	<select name="id_contragent" id="id_contragent" class="input-m">
		<?foreach($managers_list as $manager){?>
			<option value="<?=$manager['id_user']?>"<?=isset($_POST['id_contragent']) && $_POST['id_contragent'] == $manager['id_user']?' selected':null?>><?=$manager['name_c']?></option>
		<?}?>
	</select>
</div>
<div class="col-md-12">
	<label for="discount">Скидка:</label>
	<?=isset($errm['discount'])?"<span class=\"errmsg\">".$errm['discount']."</span><br>":null?>
	<input type="number" step="0.01" name="discount" id="discount" class="input-m" value="<?=isset($_POST['discount'])?htmlspecialchars($_POST['discount']):null?>">
</div>
