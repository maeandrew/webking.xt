<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="regionae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<label for="region_name"></label><p><b>Название:</b></p><?=isset($errm['title'])?"<span class=\"errmsg\">".$errm['title']."</span><br>":null?>
		<input type="text" name="title" id="region_name" class="input-m" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>">

		<input type="hidden" name="id" id="id_region" value="<?=isset($_POST['id'])?$_POST['id']:0?>">
		<button name="smb" type="submit" id="form_submit" class="btn-m-default save-btn">Сохранить</button>
    </form>
</div>