<h1><?=$h1?></h1>

<div id="profiles_ae" class="grid">
    <form action="<?=$GLOBALS['URL_request']?>" method="post" class="row">
		<div class="col-md-4">
			<label for="name">Системное название:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
			<input type="text" name="name" id="name" class="input-m" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" autofocus>
		</div>
		<div class="clear"></div>
		<div class="col-md-4">
			<label for="caption">Отображаемое имя:</label><?=isset($errm['caption'])?"<span class=\"errmsg\">".$errm['caption']."</span><br>":null?>
			<input type="text" name="caption" id="caption" class="input-m" value="<?=isset($_POST['caption'])?htmlspecialchars($_POST['caption']):null?>">
		</div>
		<div class="col-md-12">
			<input type="hidden" name="id_profile" value="<?=isset($_POST['id_profile'])?$_POST['id_profile']:0?>">
			<button name="smb" type="submit" class="btn-m-blue save-btn">Сохранить</button>
		</div>
    </form>
</div>