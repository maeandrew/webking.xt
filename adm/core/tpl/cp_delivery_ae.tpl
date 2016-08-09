<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="deliveryae" class="grid">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
		<div class="col-md-4">
			<label for="name">Название:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
			<input type="text" name="name" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>" class="input-l">
			<input type="hidden" name="id_delivery" id="id_delivery" value="<?=isset($_POST['id_delivery'])?$_POST['id_delivery']:0?>">
			<button name="smb" type="submit" id="form_submit" class="btn-l-default save-btn">Сохранить</button>
		</div>
    </form>
</div>