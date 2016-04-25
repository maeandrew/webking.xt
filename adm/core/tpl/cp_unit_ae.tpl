<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="unitae">
    <form action="<?=$GLOBALS['URL_request']?>" method="post">
    	<label for="unit_xt">xt.ua</label><?=isset($errm['unit_xt'])?"<span class=\"errmsg\">".$errm['unit_xt']."</span><br>":null?>
		<input type="text" name="unit_xt" id="unit_xt" class="input-l" value="<?=isset($_POST['unit_xt'])?htmlspecialchars($_POST['unit_xt']):null?>">
		<label for="unit_prom">prom.ua</label><?=isset($errm['unit_prom'])?"<span class=\"errmsg\">".$errm['unit_prom']."</span><br>":null?>
		<input type="text" name="unit_prom" id="unit_prom" class="input-l" value="<?=isset($_POST['unit_prom'])?htmlspecialchars($_POST['unit_prom']):null?>">
		<br>
		<input type="hidden" name="id" id="id" value="<?=isset($_POST['id'])?$_POST['id']:0?>">
		<button name="smb" type="submit" class="btn-l-default save-btn">Сохранить</button>
    </form>
</div>