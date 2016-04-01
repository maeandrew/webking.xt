<link rel="stylesheet" href="/adm/css/page_styles/productedit.css">
<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="postae">
    <form action="<?=$GLOBALS['URL_request']?>" method="post">
		<?if(isset($_POST['id']) && $_POST['id']){?>
			<span class="fr"><a href="<?=$GLOBALS['URL_base']?>post/<?=isset($_POST['translit'])?$_POST['translit']:null?>">Посмотреть страницу</a></span>
		<?}?>
		<label for="title">Заголовок:</label><?=isset($errm['title'])?"<span class=\"errmsg\">".$errm['title']."</span><br>":null?>
		<input type="text" name="title" id="title" class="input-m" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>"/>
        <div id="translit"><?=isset($_POST['translit'])?$_POST['translit']:null?></div>
        <div class="row seo_block hidden">
			<div class="col-md-12">
				<label for="page_title">Мета-заголовок (title):</label>
				<?=isset($errm['page_title'])?"<span class=\"errmsg\">".$errm['page_title']."</span><br>":null?>
				<input type="text" name="page_title" id="page_title" class="input-m" value="<?=isset($_POST['page_title'])?htmlspecialchars($_POST['page_title']):null?>">
				<label for="page_description">Мета-описание (description):</label>
				<?=isset($errm['page_description'])?"<span class=\"errmsg\">".$errm['page_description']."</span><br>":null?>
				<textarea name="page_description" id="page_description" size="20" cols="223" rows="5" class="input-m"><?=isset($_POST['page_description'])?htmlspecialchars($_POST['page_description']):null?></textarea>
				<label for="keywords">Ключевые слова (keywords):</label>
				<?=isset($errm['page_keywords'])?"<span class=\"errmsg\">".$errm['page_keywords']."</span><br>":null?>
				<textarea class="input-m" name="page_keywords" id="keywords" cols="10" rows="5"><?=isset($_POST['page_keywords'])?htmlspecialchars($_POST['page_keywords']):null?></textarea>
			</div>
		</div>
		<label for="photobox">Миниатюра:</label>
		<div id="photobox">
			<div class="thumbpreviews">
				<?$id_news = $GLOBALS['REQAR'][1];?>
				<?if(isset($id_news)) {
					if(isset($_POST['thumbnail']) && !empty($_POST['thumbnail'])) {?>
						<div class="image_block preloaded dz-preview dz-image-preview">
							<div class="sort_handle"><span class="icon-font">s</span></div>
							<div class="image">
								<img data-dz-thumbnail src="<?=$_POST['thumbnail']?>"/>
							</div>
							<div class="name">
								<span class="dz-filename" data-dz-name><?=$_POST['thumbnail']?></span>
								<span class="dz-size" data-dz-size></span>
							</div>
							<div class="controls">
								<p><span class="icon-font del_miniphoto_js" data-img-src="<?=$_POST['thumbnail']?>" data-dz-remove>t</span></p>
							</div>
							<input type="hidden" name="thumb" value="<?=$_POST['thumbnail']?>">
						</div>
					<?}?>
				<?}?>
			</div>
			<div class="image_block_new thumb_block drop_zone_thumb animate">
				<div class="dz-default dz-message">Перетащите сюда фото или нажмите для загрузки.</div>
				<input type="file" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
			</div>
		</div>
        <label for="content_preview">Короткое описание:</label><?=isset($errm['content_preview'])?"<span class=\"errmsg\">".$errm['content_preview']."</span><br>":null?>
		<textarea name="content_preview" id="content_preview" class="input-m" rows="18" cols="195"><?=isset($_POST['content_preview'])?htmlspecialchars($_POST['content_preview']):null?></textarea>
		<p><b>Полное описание:</b></p><?=isset($errm['content'])?"<span class=\"errmsg\"><br>".$errm['content']."</span>":null?>
		<textarea name="content" id="content" rows="38" cols="200"><?=isset($_POST['content'])?htmlspecialchars($_POST['content']):null?></textarea>
		<!-- <div id="edit-container">
			<div id="editor" onkeyup="moreStuff();"><?=isset($_POST['content'])?htmlspecialchars($_POST['content']):null?></div>
		</div>
		<script>
			var editor = ace.edit("editor");
			editor.setTheme("ace/theme/dreamweaver");
			//editor.setTheme("ace/theme/clouds_midnight");
			editor.setFontSize(15);
			editor.getSession().setUseWrapMode(true);
			editor.getSession().setMode("ace/mode/html");
			function moreStuff(){
				document.getElementById('content').value = editor.getValue();
			}
		</script> -->
		<label for="date">Дата:</label><?=isset($errm['date'])?"<span class=\"errmsg\">".$errm['date']."</span><br>":null?>
		<input type="text" name="date" id="date" class="input-l wa" value="<?=(isset($_POST['date'])&&!isset($errm['date']))?date("d.m.Y", $_POST['date']):date("d.m.Y", time())?>"/>
		<div id="nav_visible">
			<h2 class="blue-line">Видимость и индексация</h2>
			<p><b>Скрыть новость &nbsp;</b><input class="vam" type="checkbox" name="visible" id="visible" <?=isset($_POST['visible'])&&(!$_POST['visible'])?'checked="checked" value="on"':null?>/></p>
			<label for="indexation"><b>Индексация &nbsp;</b>
				<input type="checkbox" name="indexation" id="indexation" class="input-m" <?=(isset($_POST['indexation']) && $_POST['indexation'] != 1) || !isset($_POST['indexation'])?null:'checked="checked" value="on"'?>>
			</label>
		</div>
		<input type="hidden" name="id" id="id" value="<?=isset($_POST['id'])?$_POST['id']:0;?>"/>
		<button name="smb" type="submit" id="form_submit1" class="save-btn btn-l-default">Сохранить</button>
    </form>
</div>

<div id="preview-thumbtemplate" style="display: none;">
	<div class="image_block dz-preview dz-file-preview">
		<div class="sort_handle"><span class="icon-font">s</span></div>
		<div class="image">
			<img data-dz-thumbnail />
		</div>
		<div class="name">
			<span class="dz-filename" data-dz-name></span>
			<span class="dz-size" data-dz-size></span>
		</div>
		<div class="controls">
			<p><span class="icon-font del_t_photo_js">t</span></p>
		</div>
	</div>
</div>

<script src="/plugins/dropzone.js"></script>

<script type="text/javascript">
	// AjexFileManager.init({
	// 	returnTo: 'function'
	// });
	var url = URL_base+"newsadd/";
	$(function(){
		//Загрузка миниатюры на сайт
		var singledropzone = new Dropzone(".drop_zone_thumb", {
			method: 'POST',
			url: url+"?upload=true",
			uploadMultiple: false,
			clickable: true,
			// acceptedFiles: '.jpeg,.png',
			maxFiles: 1,
			previewsContainer: '.thumbpreviews',
			previewTemplate: document.querySelector('#preview-thumbtemplate').innerHTML,
			
		}).on('removedfile', function(file){			
			removed_file2 = '/news_images/'+ <?=$id_news?> +'/'+file.name;
			$('.thumb_block').removeClass('hidden');
			$('.thumbpreviews').append('<input type="hidden" name="removed_images[]" value="'+removed_file2+'">');
		}).on('addedfile', function(file){
			$('.thumbpreviews .image_block.preloaded').remove();
			$('.thumb_block').addClass('hidden');
		}).on('success', function(file, path){
			file.previewElement.innerHTML += '<input type="hidden" name="thumb" value="'+path+'">';			
		});

		//Удаление ранее загруженных фото
		$("body").on('click', '.del_miniphoto_js', function(e) {
			//e.stopPropagation();
			if(confirm('Изобрежение trhrty будет удалено.')){
				var path = $(this).closest('.image_block'),
					removed_file = path.find('input[name="thumb"]').val(); //  /news_images/482/cat.jpg
					path.closest('.thumbpreviews').append('<input type="hidden" name="removed_images[]" value="'+removed_file+'">');
					path.remove();
			}
		});

		//Удаление только что загруженных фото
		$("body").on('click', '.del_t_photo_js', function(e) {
			e.stopPropagation();
			if(confirm('Изобрежение будет удалено.')){
				var path = $(this).closest('.image_block'),
					removed_file = path.find('input[name="thumb"]').val();
					singledropzone.removeAllFiles();
			}
		});
	});
</script>
<script>
	//Текстовый редактор
	CKEDITOR.replace( 'content_preview', {
	    customConfig: 'custom/ckeditor_config_img.js'
	});
	CKEDITOR.replace( 'content', {
	    customConfig: 'custom/ckeditor_config_img.js'
	});
</script>