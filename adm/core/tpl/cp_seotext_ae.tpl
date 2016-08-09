<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="seotextae">
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">

		<label>Автор: <?=isset($_POST['username'])?htmlspecialchars($_POST['username']):null?> &nbsp; &nbsp; &nbsp;  Дата создания: <?=isset($_POST['creation_date'])?htmlspecialchars($_POST['creation_date']):null?></label>

		<label for="title">URL страницы:</label><?=isset($errm['url'])?"<span class=\"errmsg\">".$errm['url']."</span><br>":null?>
		<input type="text" name="url" id="seo-url" class="input-m" value="<?=isset($_POST['url'])?htmlspecialchars($_POST['url']):null?>"/>

		<label for="descr_short">Текст:</label><?=isset($errm['text'])?"<span class=\"errmsg\">".$errm['text']."</span><br>":null?>
		<textarea name="text" id="seo-text" class="input-m" rows="18" cols="195"><?=isset($_POST['text'])?htmlspecialchars($_POST['text']):null?></textarea>

		<div id="visible_seo">
			<b>Отобразить на странице &nbsp;</b>
			<input class="vam" type="checkbox" name="visible" id="seo_visible" <?=isset($_POST['visible'])&&($_POST['visible'])?'checked="checked" value="on"':null?>/>
		</div>

		<label for="title">Теги:</label><?=isset($errm['url'])?"<span class=\"errmsg\">".$errm['url']."</span><br>":null?>
		<input type="text" name="keyword"  data-target="get_word" data-cat="<?=$value['word']?>" id="seo-word" class="input-m open_modal" value="<?=isset($_POST['word'])?htmlspecialchars($_POST['word']):null?>"/>

		<input type="hidden" name="id_author" id="author_seotext" value="<?=isset($_SESSION['member']['id_user'])?$_SESSION['member']['id_user']:'noname';?>">
		<input type="hidden" name="id" id="id_seotext" value="<?=isset($_POST['id'])?$_POST['id']:null;?>">

		<input name="smb" type="submit" id="form_submit1" class="save-btn btn-m-default" value="Сохранить">
	</form>
</div>
<script>
	//Текстовый редактор
	CKEDITOR.replace( 'seo-text', {
		customConfig: 'custom/ckeditor_config_seo.js'
	});
</script>
<script>
	$('#seo-word').change(function(){
		var str = $(this).val();
		if (str >= 3 ) {
			$.ajax({
				url: URL_base + 'ajax_seotext',
				type: "POST",
				cache: false,
				dataType: "html",
				data: {
					"action": 'get_word',
					"str": str
				}
			}).done(function (data) {
				$('#list').html(data);
			});
		}
	});
</script>
<div class="modal_hidden" id="get_word">
	<ul id="list">

	</ul>
	<a href="#" class="close_modal icon-del">n</a>
</div>
