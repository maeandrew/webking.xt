<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<div id="parkingae" class="grid">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
    	<div class="col-md-4">
    		<label for="name">Название:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
			<input type="text" class="input-l" name="name" id="name" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>">
	
			<input type="hidden" name="id_parking" id="id_parking" value="<?=isset($_POST['id_parking'])?$_POST['id_parking']:0?>">
			<button name="smb" type="submit" id="form_submit" class="save-btn btn-l-default">Сохранить</button>
    	</div>
    </form>
</div>