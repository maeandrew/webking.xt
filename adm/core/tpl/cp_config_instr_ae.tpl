<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="formae">
    <form action="<?=$GLOBALS['URL_request']?>" method="post">
		<!-- <p><b>Name:</b></p><?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?> -->
		<input type="hidden" name="name" class="input-l" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>">
		<label for="caption">Описание:</label><?=isset($errm['caption'])?"<span class=\"errmsg\">".$errm['caption']."</span><br>":null?>
		<input type="text" name="caption" id="caption" class="input-l" value="<?=isset($_POST['caption'])?htmlspecialchars($_POST['caption']):null?>">
		<label for="pcontent">Значение:</label><?=isset($errm['value'])?"<span class=\"errmsg\">".$errm['value']."</span><br>":null?>
		<textarea name="value" id="pcontent" rows="38" cols="200"><?=isset($_POST['value'])?htmlspecialchars($_POST['value']):null?></textarea>
		<!-- <div id="edit-container">
			<div id="editor" onkeyup="moreStuff();"><?=isset($_POST['value'])?htmlspecialchars($_POST['value']):null?></div>
		</div> -->
		<br>
		<input type="hidden" name="id_config" id="id_config" value="<?=isset($_POST['id_config'])?$_POST['id_config']:0?>">
		<button name="smb" type="submit" class="save-btn btn-l-default">Сохранить</button>
    </form>
</div>
<script>
	//Текстовый редактор
	CKEDITOR.replace( 'pcontent', {
	    customConfig: 'custom/ckeditor_config.js'
	});

	// var editor = ace.edit('editor');
	// editor.setTheme('ace/theme/dreamviewer');
	// //editor.setTheme('ace/theme/clouds_midnight');
	// editor.setFontSize(15);
	// editor.getSession().setUseWrapMode(true);
	// editor.getSession().setMode('ace/mode/html');
	// function moreStuff(){
	// 	document.getElementById('pcontent').value = editor.getValue();
	// }
</script>