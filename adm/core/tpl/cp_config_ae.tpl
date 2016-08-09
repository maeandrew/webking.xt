<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="configae" class="grid">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<label for="name">Name:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
					<input type="text" name="name" class="input-l"value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>">
				</div>
				<div class="col-md-12">
					<label for="caption">Описание:</label><?=isset($errm['caption'])?"<span class=\"errmsg\">".$errm['caption']."</span><br>":null?>
					<input type="text" name="caption" id="caption" class="input-l" value="<?=isset($_POST['caption'])?htmlspecialchars($_POST['caption']):null?>">
				</div>
				<div class="col-md-12">
					<label for="value">Значение:</label><?=isset($errm['value'])?"<span class=\"errmsg\">".$errm['value']."</span><br>":null?>
					<input type="text" name="value" id="value" class="input-l" value="<?=isset($_POST['value'])?htmlspecialchars($_POST['value']):null?>">
					<input type="hidden" name="id_config" id="id_config" value="<?=isset($_POST['id_config'])?$_POST['id_config']:0?>">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<button name="smb" type="submit" class="btn-l-default save-btn">Сохранить</button>
		</div>
    </form>
</div>