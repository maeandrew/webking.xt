<h1><?=$h1?></h1>
<?if(isset($errm) && isset($msg)){?>
	<div class="notification error">
		<span class="strong">Ошибка!</span><?=$msg?>
	</div>
<?}elseif(isset($msg)){?>
	<div class="notification success">
		<span class="strong">Сделано!</span><?=$msg?>
	</div>
<?}?>
<div id="seotextformatae" class="grid">
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<label for="format">Формат:</label><?=isset($errm['format'])?"<span class=\"errmsg\">".$errm['format']."</span><br>":null?>
					<input type="text" name="format" id="format" class="input-m" value="<?=isset($_POST['format'])?htmlspecialchars($_POST['format']):null?>">
				</div>
				<div class="col-md-12">
					<label for="quantity">Кол-во:</label><?=isset($errm['quantity'])?"<span class=\"errmsg\">".$errm['quantity']."</span><br>":null?>
					<input type="number" min="1" name="quantity" id="quantity" class="input-m" value="<?=isset($_POST['quantity'])?htmlspecialchars($_POST['quantity']):null?>">
				</div>
				<div class="col-md-12">
					<label for="type">Значение:</label><?=isset($errm['type'])?"<span class=\"errmsg\">".$errm['type']."</span><br>":null?>
					<select class="input-m" name="type" id="type">
						<option disabled value="0" selected>Выберите из списка</option>
						<option <?=isset($_POST['type'])&& $_POST['type'] == 1?'selected':''?> value="1">Города</option>
						<option <?=isset($_POST['type'])&& $_POST['type'] == 2?'selected':''?>  value="2">Предприятия</option>
						<option <?=isset($_POST['type'])&& $_POST['type'] == 3?'selected':''?>  value="3">Магазины</option>
					</select>
					<input hidden type="text" name="id" value="<?=isset($_POST['id'])?htmlspecialchars($_POST['id']):null?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<input name="smb" type="submit" class="btn-m-default save-btn" value="Сохранить">
		</div>
	</form>
</div>