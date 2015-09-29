<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<div id="manufacturerae" class="grid">
    <form action="<?=$GLOBALS['URL_request']?>" method="post" class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<label for="name">Название:</label><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
					<input type="text" name="name" id="name" class="input-l" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>">
					<div id="translit"><?=isset($_POST['translit'])?$_POST['translit']:null?></div>
				</div>
				<div class="col-md-12">
					<label>Логотип:</label>
					<img class="pic_block" src="<?=isset($_POST['m_image'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $_POST['m_image'])):"/efiles/_thumb/image/nofoto.jpg"?>">
					<input type="text" name="m_image" id="m_image" class="input-l wa" value="<?=isset($_POST['m_image'])?htmlspecialchars($_POST['m_image']):null?>"/>
					<button type="button" id="form_submit" onclick="AjexFileManager.open({returnTo: 'insertValue'});" class="btn-l-default">Выбрать...</button>
				</div>
				<div class="col-md-12">
					<input type="hidden" name="manufacturer_id" id="manufacturer_id" value="<?=isset($_POST['manufacturer_id'])?$_POST['manufacturer_id']:0?>">
					<button name="smb" type="submit" id="form_submit" class="btn-l-default save-btn">Сохранить</button>
				</div>
			</div>
		</div>
    </form>
</div>

<script type="text/javascript">
	AjexFileManager.init({
		returnTo: 'function'
	});

	function insertValue(filePath) {
		document.getElementById('m_image').value = filePath;
		var re = /(\/efiles\/)(.*?)/;
		filePath = filePath.replace(re, "$1_thumb/$2");
		document.getElementById('m_image').src = filePath;
		return;
	}
</script>
