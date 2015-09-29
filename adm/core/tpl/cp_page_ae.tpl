<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="pageae">
    <form action="<?=$GLOBALS['URL_request']?>" method="post">
		<?if(isset($_POST['id_page']) && $_POST['id_page']){?>
			<span class="fr"><a href="/page/<?=isset($_POST['translit'])?$_POST['translit']:null?>">Посмотреть страницу</a></span>
		<?}?>
		<label for="title">Заголовок:</label><?=isset($errm['title'])?'<span class="errmsg">'.$errm['title']."</span><br>":null?>
		<input type="text" name="title" id="title" class="input-l" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>">
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
		<label for="ptype">Тип страницы:</label><?=isset($errm['ptype'])?'<span class="errmsg">'.$errm['ptype']."</span><br>":null?>
		<select name="ptype" id="ptype" class="input-l">
			 <?foreach($ptypes as $pt){?>
			 	<option <?=(isset($_POST['ptype'])&&$_POST['ptype']==$pt['name'])?'selected="true"':null?> value="<?=$pt['name']?>"><?=$pt['caption']?></option>
			 <?}?>
		</select>
		<label for="pcontent">Текст:</label><?=isset($errm['pcontent'])?"<span class=\"errmsg\">".$errm['pcontent']."</span><br>":null?>
		<textarea name="pcontent" id="pcontent" rows="38" cols="200" class="hidden"><?=isset($_POST['content'])?htmlspecialchars($_POST['content']):null?></textarea>
		<div id="edit-container">
			<div id="editor" onkeyup="moreStuff();"><?=isset($_POST['content'])?htmlspecialchars($_POST['content']):null?></div>
		</div>
		<p>
			<b>Страница скрытая &nbsp;</b>
			<input class="vam" type="checkbox" name="visible" id="visible" <?=isset($_POST['visible'])&&(!$_POST['visible'])?'checked="checked" value="on"':null?>>
		</p>
		<input type="hidden" name="id_page" id="id_page" value="<?=isset($_POST['id_page'])?$_POST['id_page']:0?>">
		<button name="smb" type="submit" class="save-btn btn-l-default">Сохранить</button>
    </form>
</div>
<?='<script>
var editor = ace.edit(\'editor\');
editor.setTheme(\'ace/theme/dreamviewer\');
//editor.setTheme(\'ace/theme/clouds_midnight\');
editor.setFontSize(15);
editor.getSession().setUseWrapMode(true);
editor.getSession().setMode(\'ace/mode/html\');
function moreStuff(){
	document.getElementById(\'pcontent\').value = editor.getValue();
}
</script>';?>