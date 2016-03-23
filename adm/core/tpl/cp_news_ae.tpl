<link rel="stylesheet" href="/adm/css/page_styles/productedit.css">

<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="newsae">
	<form action="<?=$GLOBALS['URL_request']?>" method="post">
		<?if(isset($_POST['id_news']) && $_POST['id_news']){?>
			<span class="fr"><a href="<?=$GLOBALS['URL_base']?>news/<?=isset($_POST['translit'])?$_POST['translit']:null?>">Посмотреть страницу</a></span>
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

		<div id="photobox">
			<div class="previews">
				<?$id_news = $GLOBALS['REQAR'][1];?> <!-- получить ид новости -->
				<?if(isset($id_news)) { 
					if(isset($_POST['Img']) && !empty($_POST['Img'])){ // определить, есть ли у этой новости массив картинок
						foreach($_POST['Img'] as $photo){
							if(isset($photo['src'])){?>
								<? $imgTitle = basename($photo['src']); 
									$imgSrc = '/news_images/'.$id_news.'/'.$imgTitle;?>
								<div class="image_block dz-preview dz-image-preview">
									<div class="sort_handle"><span class="icon-font">s</span></div>
									<div class="image">
										<img data-dz-thumbnail src="<?=$imgSrc?>"/>
										<!--src="<?=$imgSrc?htmlspecialchars($photo['src']):'/efiles/_thumb/nofoto.jpg'?>"/>-->
									</div>
									<div class="name">
										<span class="dz-filename" data-dz-name><?=$photo['src']?></span>
										<span class="dz-size" data-dz-size></span>
									</div>
									<div class="controls">
										<p><span class="icon-font del_photo_js" data-img-src="<?=$imgSrc?>" data-dz-remove>t</span></p>
									</div>
									<input type="hidden" name="images[]" value="<?=$photo['src']?>">
								</div>
							<?}
						}
					}
				}?>
			</div>
			<div class="image_block_new drop_zone animate">
				<div class="dz-default dz-message">Перетащите сюда фото или нажмите для загрузки.</div>
				<input type="file" multiple="multiple" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
			</div>
		</div>
		

		<label for="date">Дата:</label><?=isset($errm['date'])?"<span class=\"errmsg\">".$errm['date']."</span><br>":null?>
		<input type="text" name="date" id="date" class="input-l wa" value="<?=(isset($_POST['date'])&&!isset($errm['date']))?date("d.m.Y", $_POST['date']):date("d.m.Y", time())?>"/>
		<div id="nav_visible">
			<h2 class="blue-line">Видимость и индексация</h2>
			<p><b>Скрыть новость &nbsp;</b><input class="vam" type="checkbox" name="visible" id="visible" <?=isset($_POST['visible'])&&(!$_POST['visible'])?'checked="checked" value="on"':null?>/></p>
			<label for="indexation"><b>Индексация &nbsp;</b>
				<input type="checkbox" name="indexation" id="indexation" class="input-m" <?=(isset($_POST['indexation']) && $_POST['indexation'] != 1) || !isset($_POST['indexation'])?null:'checked="checked" value="on"'?>>
			</label>
		</div>
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

<div id="preview-template" style="display: none;">
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
			<p><span class="icon-font del_u_photo_js">t</span></p>
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
		//Удаление видео
		$("body").on('click', '.remove_video', function() {
			if(confirm('Вы точно хотите удалить видео?')){
				$(this).parent().remove();
			}
		});

		//Загрузка Фото на сайт
		var dropzone = new Dropzone(".drop_zone", {
			method: 'POST',
			url: url+"?upload=true",
			clickable: true,
			previewsContainer: '.previews', // куда загружает
			previewTemplate: document.querySelector('#preview-template').innerHTML //шаблон загрузки
		});
		var return_arr = new Array();
		dropzone.on('addedfile', function(file){
			//askaboutleave();
		}).on('success', function(file, path){
			file.previewElement.innerHTML += '<input type="hidden" name="images[]" value="'+path+'">';
			//console.log(file);
		}).on('removedfile', function(file){
			removed_file2 = '/news_images/'+ <?=$id_news?> +'/'+file.name; // физический путь картинки			
			$('.previews').append('<input type="hidden" name="removed_images[]" value="'+removed_file2+'">');
		});

		//Сортировка фото
		$('.previews').sortable({
			items: ".image_block",
			handle: ".sort_handle",
			connectWith: ".previews",
			containment: ".previews",
			placeholder: "ui-sortable-placeholder",
			axis: "y",
			scroll: false,
			tolerance: "pointer",
			out: function(){
				var main_photo = $('.previews .image_block:first-of-type').find('input[name="images[]"]').val();
				$('.main_photo img').attr('src', main_photo);
			}
		});

		//Удаление ранее загруженных фото
		$("body").on('click', '.del_photo_js', function(e) {
			//e.stopPropagation();
			if(confirm('Изобрежение будет удалено.')){
				var path = $(this).closest('.image_block'),
					removed_file = path.find('input[name="images[]"]').val(); //  /news_images/482/cat.jpg
				RemovedFile(path, removed_file);
			}
		});

		//Удаление только что загруженных фото
		$("body").on('click', '.del_u_photo_js', function(e) {
			e.stopPropagation();
			if(confirm('Изобрежение будет удалено.')){
				var path = $(this).closest('.image_block'),
					removed_file = path.find('input[name="images[]"]').val().replace('/../','/');
				RemovedFile(path, removed_file);
			}
		});
	});

	function RemovedFile (path, removed_file){		
		path.closest('.previews').append('<input type="hidden" name="removed_images[]" value="'+removed_file+'">');		
		path.remove();
	}
</script>


<script>
	//Текстовый редактор
	CKEDITOR.replace( 'descr_short', {
		customConfig: 'custom/ckeditor_config_img.js'
	});
	CKEDITOR.replace( 'descr_full', {
		customConfig: 'custom/ckeditor_config_img.js'
	});
</script>