<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="seotextae">
	<form action="<?=$GLOBALS['URL_request']?>" method="post">

		<label for="title">URL страницы:</label><?=isset($errm['url'])?"<span class=\"errmsg\">".$errm['url']."</span><br>":null?>
		<input type="text" name="url" id="seo-url" class="input-l" value="<?=isset($_POST['url'])?htmlspecialchars($_POST['url']):null?>"/>

		<label for="descr_short">Текст:</label><?=isset($errm['text'])?"<span class=\"errmsg\">".$errm['text']."</span><br>":null?>
		<textarea name="text" id="seo-text" class="input-l" rows="18" cols="195"><?=isset($_POST['text'])?htmlspecialchars($_POST['text']):null?></textarea>

		<div id="visible_seo">
			<b>Отобразить на странице &nbsp;</b>
			<input class="vam" type="checkbox" name="visible" id="seo_visible" <?=isset($_POST['visible'])&&($_POST['visible'])?'checked="checked" value="on"':null?>/>
		</div>

		<input type="hidden" name="author" id="author_seotext" value="<?=isset($_SESSION['member']['name'])?$_SESSION['member']['name']:'noname';?>">
		<input type="hidden" name="id" id="id_seotext" value="<?=isset($_POST['id'])?$_POST['id']:null;?>">

		<input name="smb" type="submit" id="form_submit1" class="save-btn btn-l-default" value="Сохранить">
	</form>
</div>
<script>
	//Текстовый редактор
	CKEDITOR.replace( 'seo-text', {
		customConfig: 'custom/ckeditor_config_seo.js'
	});
</script>