<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="regionae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<label for="region_name"></label><p><b>Название:</b></p><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
		<input type="text" name="name" id="region_name" class="input-l" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>">

		<input type="hidden" name="id_region" id="id_region" value="<?=isset($_POST['id_region'])?$_POST['id_region']:0?>">
		<button name="smb" type="submit" id="form_submit" class="btn-l-default save-btn">Сохранить</button>
    </form>
</div>