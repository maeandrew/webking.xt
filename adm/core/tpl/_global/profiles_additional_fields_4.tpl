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
	<label for="name_c">Отображение в кабинете покупателей:</label>
	<?=isset($errm['name_c'])?"<span class=\"errmsg\">".$errm['name_c']."</span><br>":null?>
	<input type="text" name="name_c" id="name_c" class="input-m" value="<?=isset($_POST['name_c'])?htmlspecialchars($_POST['name_c']):null?>">
</div>
<div class="col-md-12">
	<label for="photo">Фото:</label>
	<?=isset($errm['photo'])?"<span class=\"errmsg\">".$errm['photo']."</span><br>":null?>
	<input type="text" name="photo" id="photo" class="input-m" value="<?=isset($_POST['photo'])?htmlspecialchars($_POST['photo']):null?>">
</div>
<div class="col-md-12">
	<label for="site">Сайт:</label>
	<?=isset($errm['site'])?"<span class=\"errmsg\">".$errm['site']."</span><br>":null?>
	<input type="text" name="site" id="site" class="input-m" value="<?=isset($_POST['site'])?htmlspecialchars($_POST['site']):null?>">
</div>
<div class="col-md-12">
	<label for="phones">Телефоны:</label>
	<?=isset($errm['phones'])?"<span class=\"errmsg\">".$errm['phones']."</span><br>":null?>
	<textarea name="phones" id="phones" class="input-m" rows="2" cols="80"><?=isset($_POST['phones'])?htmlspecialchars($_POST['phones']):null?></textarea>
</div>
<div class="col-md-12">
	<label for="remote">Удаленный контрагент:
		<input type="checkbox" name="remote" id="remote" class="input-m" <?=isset($_POST['remote'])&&($_POST['remote'])?'checked="checked" value="on"':null?>>
	</label>
</div>