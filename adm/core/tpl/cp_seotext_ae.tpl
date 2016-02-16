<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="newsae">
	<form action="<?=$GLOBALS['URL_request']?>" method="post">
		<?if(isset($_POST['id_news']) && $_POST['id_news']){?>
		<span class="fr"><a href="<?=$GLOBALS['URL_base']?>news/<?=$_POST['id_news']?>/<?=isset($_POST['translit'])?$_POST['translit']:null?>">Посмотреть страницу</a></span>
		<?}?>
		<label for="title">Заголовок:</label><?=isset($errm['title'])?"<span class=\"errmsg\">".$errm['title']."</span><br>":null?>
		<input type="text" name="title" id="title" class="input-l" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>"/>
		<div id="translit"><?=isset($_POST['translit'])?$_POST['translit']:null?></div>
		<div class="row seo_block">
			<div class="col-md-12">
				<label for="page_title">Мета-заголовок (title):</label>
				<?=isset($errm['page_title'])?"<span class=\"errmsg\">".$errm['page_title']."</span><br>":null?>
				<input type="text" name="page_title" id="page_title" class="input-l" value="<?=isset($_POST['page_title'])?htmlspecialchars($_POST['page_title']):null?>">
				<label for="page_description">Мета-описание (description):</label>
				<?=isset($errm['page_description'])?"<span class=\"errmsg\">".$errm['page_description']."</span><br>":null?>
				<textarea name="page_description" id="page_description" size="20" cols="223" rows="5" class="input-l"><?=isset($_POST['page_description'])?htmlspecialchars($_POST['page_description']):null?></textarea>
				<label for="keywords">Ключевые слова (keywords):</label>
				<?=isset($errm['page_keywords'])?"<span class=\"errmsg\">".$errm['page_keywords']."</span><br>":null?>
				<textarea class="input-l" name="page_keywords" id="keywords" cols="10" rows="5"><?=isset($_POST['page_keywords'])?htmlspecialchars($_POST['page_keywords']):null?></textarea>
			</div>
		</div>
		<label for="descr_short">Короткое описание:</label><?=isset($errm['descr_short'])?"<span class=\"errmsg\">".$errm['descr_short']."</span><br>":null?>
		<textarea name="descr_short" id="descr_short" class="input-l" rows="18" cols="195"><?=isset($_POST['descr_short'])?htmlspecialchars($_POST['descr_short']):null?></textarea>
		<p><b>Полное описание:</b></p><?=isset($errm['descr_full'])?"<span class=\"errmsg\"><br>".$errm['descr_full']."</span>":null?>
		<textarea name="descr_full" id="descr_full" rows="38" cols="200"><?=isset($_POST['descr_full'])?htmlspecialchars($_POST['descr_full']):null?></textarea>
		<!-- <div id="edit-container">
			<div id="editor" onkeyup="moreStuff();"><?=isset($_POST['descr_full'])?htmlspecialchars($_POST['descr_full']):null?></div>
		</div>
		<script>
			var editor = ace.edit("editor");
			editor.setTheme("ace/theme/dreamweaver");
			//editor.setTheme("ace/theme/clouds_midnight");
			editor.setFontSize(15);
			editor.getSession().setUseWrapMode(true);
			editor.getSession().setMode("ace/mode/html");
			function moreStuff(){
				document.getElementById('descr_full').value = editor.getValue();
			}
		</script> -->
		<label for="date">Дата:</label><?=isset($errm['date'])?"<span class=\"errmsg\">".$errm['date']."</span><br>":null?>
		<input type="text" name="date" id="date" class="input-l wa" value="<?=(isset($_POST['date'])&&!isset($errm['date']))?date("d.m.Y", $_POST['date']):date("d.m.Y", time())?>"/>
		<p><b>Скрыть новость &nbsp;</b><input class="vam" type="checkbox" name="visible" id="visible" <?=isset($_POST['visible'])&&(!$_POST['visible'])?'checked="checked" value="on"':null?>/></p>
		<p>
			<b>Разослать новость &nbsp;</b>
			<input class="vam" type="checkbox" value="1" name="news_distribution" id="news_distribution"/>
			<input class="vam input-l wa" type="text" name="limit_from" placeholder="с какого начать"/>
			<input class="vam input-l wa" type="text" name="limit_howmuch" placeholder="сколько выбрать"/>
		</p>
		<input type="hidden" name="id_news" id="id_news" value="<?=isset($_POST['id_news'])?$_POST['id_news']:0;?>">
		<input name="smb" type="submit" id="form_submit1" class="save-btn btn-l-default" value="Сохранить">
		<input name="test_distribution" type="submit" id="form_subm1it" class="btn-l-blue" value="Тестовая рассылка">
	</form>
</div>
<script>
	//Текстовый редактор
	CKEDITOR.replace( 'descr_short', {
		customConfig: 'custom/ckeditor_config_img.js'
	});
	CKEDITOR.replace( 'descr_full', {
		customConfig: 'custom/ckeditor_config_img.js'
	});
</script>