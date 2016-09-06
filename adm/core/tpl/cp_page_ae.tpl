<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="pageae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<?if(isset($_POST['id_page']) && $_POST['id_page']){?>
			<p class="look_page"><a href="/page/<?=isset($_POST['translit'])?$_POST['translit']:null?>">Посмотреть страницу</a></p>
		<?}?>
		<div class="row">
			<div class="col-md-6">
				<div class="ru_loc"><span></span> RU</div>
				<label for="title">Заголовок:</label><?=isset($errm['title'])?'<span class="errmsg">'.$errm['title']."</span><br>":null?>
				<input type="text" name="title" id="title" class="input-l" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>">
			</div>
			<div class="col-md-6">
				<div class="ua_loc"><span></span> UA</div>
				<label for="title_ua">Заголовок:</label><?=isset($errm['title_ua'])?'<span class="errmsg">'.$errm['title_ua']."</span><br>":null?>
				<input type="text" name="title_ua" id="title_ua" class="input-l" value="<?=isset($_POST['title_ua'])?htmlspecialchars($_POST['title_ua']):null?>">
			</div>
		</div>
        <div id="translit"><?=isset($_POST['translit'])?$_POST['translit']:null?></div>
        <div class="row seo_block hidden">
			<div class="col-md-6">
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
			<div class="col-md-6">
				<label for="page_title_ua">Мета-заголовок (title):</label>
				<?=isset($errm['page_title_ua'])?"<span class=\"errmsg\">".$errm['page_title_ua']."</span><br>":null?>
				<input type="text" name="page_title_ua" id="page_title_ua" class="input-l" value="<?=isset($_POST['page_title_ua'])?htmlspecialchars($_POST['page_title_ua']):null?>">
				<label for="page_description_ua">Мета-опис (description):</label>
				<?=isset($errm['page_description_ua'])?"<span class=\"errmsg\">".$errm['page_description_ua']."</span><br>":null?>
				<textarea name="page_description_ua" id="page_description_ua" size="20" cols="223" rows="5" class="input-l"><?=isset($_POST['page_description_ua'])?htmlspecialchars($_POST['page_description_ua']):null?></textarea>
				<label for="keywords_ua">Ключові слова (keywords):</label>
				<?=isset($errm['page_keywords_ua'])?"<span class=\"errmsg\">".$errm['page_keywords_ua']."</span><br>":null?>
				<textarea class="input-l" name="page_keywords_ua" id="keywords_ua" cols="10" rows="5"><?=isset($_POST['page_keywords_ua'])?htmlspecialchars($_POST['page_keywords_ua']):null?></textarea>
			</div>
		</div>
		<label for="ptype">Тип страницы:</label><?=isset($errm['ptype'])?'<span class="errmsg">'.$errm['ptype']."</span><br>":null?>
		<select name="ptype" id="ptype" class="input-l">
			 <?foreach($ptypes as $pt){?>
			 	<option <?=(isset($_POST['ptype'])&&$_POST['ptype']==$pt['name'])?'selected="true"':null?> value="<?=$pt['name']?>"><?=$pt['caption']?></option>
			 <?}?>
		</select>
		<div class="row">
			<div class="col-md-6">
				<label for="edit-container">Текст:</label><?=isset($errm['pcontent'])?"<span class=\"errmsg\">".$errm['pcontent']."</span><br>":null?>
				<!--<textarea name="pcontent" id="pcontent" rows="38" cols="200"><?=isset($_POST['new_content'])?htmlspecialchars($_POST['new_content']):null?></textarea>-->
				<div id="edit-container">
					<div id="editor" onkeyup="moreStuff();"><?=isset($_POST['new_content'])?htmlspecialchars($_POST['new_content']):null?></div>
				</div>
			</div>
			<div class="col-md-6">
				<label for="edit-container_ua">Текст:</label><?=isset($errm['pcontent_ua'])?"<span class=\"errmsg\">".$errm['pcontent_ua']."</span><br>":null?>
				<!--<textarea name="pcontent_ua" id="pcontent_ua" rows="38" cols="200">cvbhhrt<?=isset($_POST['content_ua'])?htmlspecialchars($_POST['content_ua']):null?></textarea>-->
				<div id="edit-container_ua">
					<div id="editor_ua" onkeyup="moreStuff2();"><?=isset($_POST['content_ua'])?htmlspecialchars($_POST['content_ua']):null?></div>
				</div>
			</div>
		</div>
		<div id="nav_visible">
			<h2 class="blue-line">Видимость и индексация</h2>
			<p>	<b>Страница скрытая &nbsp;</b>	<input class="vam" type="checkbox" name="visible" id="visible" <?=isset($_POST['visible'])&&(!$_POST['visible'])?'checked="checked" value="on"':null?>>	</p>
			<label for="indexation"><b>Индексация &nbsp;</b>
				<input type="checkbox" name="indexation" id="indexation" class="input-m" <?=(isset($_POST['indexation']) && $_POST['indexation'] != 1) || !isset($_POST['indexation'])?null:'checked="checked" value="on"'?>>
			</label>
		</div>
		<input type="hidden" name="id_page" id="id_page" value="<?=isset($_POST['id_page'])?$_POST['id_page']:0?>">
		<input type="hidden" name="editor" id="post_editor" value="<?=isset($_POST['new_content'])?htmlspecialchars($_POST['new_content']):null?>">
		<input type="hidden" name="editor_ua" id="post_editor_ua" value="<?=isset($_POST['content_ua'])?htmlspecialchars($_POST['content_ua']):null?>">
		<button name="smb" type="submit" class="save-btn btn-l-default">Сохранить</button>
    </form>
</div>
<script>
	 var editor = ace.edit('editor');
	 editor.setTheme('ace/theme/dreamviewer');
	 //editor.setTheme('ace/theme/clouds_midnight');
	 editor.setFontSize(15);
	 editor.getSession().setUseWrapMode(true);
	 editor.getSession().setMode('ace/mode/html');
	 function moreStuff(){
		 document.getElementById('post_editor').value = editor.getValue();
	 }
	 var editor_ua = ace.edit("editor_ua");
	 editor_ua.setTheme("ace/theme/dreamweaver");
	 //editor.setTheme("ace/theme/clouds_midnight");
	 editor_ua.setFontSize(15);
	 editor_ua.getSession().setUseWrapMode(true);
	 editor_ua.getSession().setMode("ace/mode/html");
	 function moreStuff2(){
	 	document.getElementById('post_editor_ua').value = editor_ua.getValue();
	 }
	//Текстовый редактор
//	CKEDITOR.replace( 'pcontent', {
//		customConfig: 'custom/ckeditor_config_img.js'
//	});
//	CKEDITOR.replace( 'pcontent_ua', {
//		customConfig: 'custom/ckeditor_config_img.js'
//	});
</script>