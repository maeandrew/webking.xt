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