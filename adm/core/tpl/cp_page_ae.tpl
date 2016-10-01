<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="pageae">
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<?if(isset($_POST['id_page']) && $_POST['id_page']){?>
			<p class="look_page"><a href="/page/<?=isset($_POST['translit'])?$_POST['translit']:null?>">Посмотреть страницу</a></p>
		<?}?>
		<div class="row">
			<div class="col-md-12">
				<label for="title">Заголовок:</label><?=isset($errm['title'])?'<span class="errmsg">'.$errm['title']."</span><br>":null?>
				<input type="text" name="title" id="title" class="input-l" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>">
			</div>
		</div>
        <div id="translit"><?=isset($_POST['translit'])?$_POST['translit']:null?></div>
		<div class="row meta_tags">
			<div class="col-md-12">
				<label for="meta_title">Мета-заголовок</label>
				<input class="input-m" id="meta_title" type="text" name="page_title" value="<?=isset($_POST['page_title']) && !empty($_POST['page_title'])?htmlspecialchars($_POST['page_title']):null?>"/>
				<label for="meta_description">Мета-описание</label>
				<textarea class="input-m" name="page_description" id="meta_description" cols="10" rows="3"><?=isset($_POST['page_description']) && !empty($_POST['page_description'])?htmlspecialchars($_POST['page_description']):null?></textarea>
				<label for="meta_keywords">Ключевые слова</label>
				<textarea class="input-m" name="page_keywords" id="meta_keywords" cols="10" rows="3"><?=isset($_POST['page_keywords'])?htmlspecialchars($_POST['page_keywords']):null?></textarea>
			</div>
		</div>
		<label for="ptype">Тип страницы:</label><?=isset($errm['ptype'])?'<span class="errmsg">'.$errm['ptype']."</span><br>":null?>
		<select name="ptype" id="ptype" class="input-l">
			 <?foreach($ptypes as $pt){?>
			 	<option <?=(isset($_POST['ptype'])&&$_POST['ptype']==$pt['name'])?'selected="true"':null?> value="<?=$pt['name']?>"><?=$pt['caption']?></option>
			 <?}?>
		</select>
		<div class="row">
			<div class="col-md-12">
				<label for="edit-container">Текст:</label><?=isset($errm['pcontent'])?"<span class=\"errmsg\">".$errm['pcontent']."</span><br>":null?>
				<!--<textarea name="pcontent" id="pcontent" rows="38" cols="200"><?=isset($_POST['new_content'])?htmlspecialchars($_POST['new_content']):null?></textarea>-->
				<div id="edit-container">
					<div id="editor" onkeyup="moreStuff();"><?=isset($_POST['new_content'])?htmlspecialchars($_POST['new_content']):null?></div>
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
	//Текстовый редактор
//	CKEDITOR.replace( 'pcontent', {
//		customConfig: 'custom/ckeditor_config_img.js'
//	});
</script>