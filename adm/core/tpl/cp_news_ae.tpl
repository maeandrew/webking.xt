<link rel="stylesheet" href="/adm/css/page_styles/productedit.css">
<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="newsae">
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<?if(isset($_POST['id_news']) && $_POST['id_news']){ ?>
			<span class="fr"><a href="<?=$_POST['sid']==0?'http://x-torg.com/news/'.$_POST['id_news'].'/'.$_POST['translit']:$GLOBALS['URL_base'].'news/'.$_POST['translit'];?>">Посмотреть страницу</a></span>
		<?}?>
		<label for="title">Заголовок:</label><?=isset($errm['title'])?"<span class=\"errmsg\">".$errm['title']."</span><br>":null?>
		<input type="text" name="title" id="title" class="input-m" value="<?=isset($_POST['title'])?htmlspecialchars($_POST['title']):null?>"/>
		<div id="translit"><?=isset($_POST['translit'])?$_POST['translit']:null?></div>
		<div class="row seo_block">
			<div class="col-md-12 meta_tags">
				<h2 class="blue-line">Мета теги</h2>
				<label for="news_meta_title">Мета-заголовок</label>
				<input class="input-m" id="news_meta_title" type="text" name="page_title" value="<?=isset($_POST['page_title']) && !empty($_POST['page_title'])?htmlspecialchars($_POST['page_title']):null?>"/>
				<label for="news_meta_description">Мета-описание</label>
				<textarea class="input-m" name="page_description" id="news_meta_description" cols="10" rows="3"><?=isset($_POST['page_description']) && !empty($_POST['page_description'])?htmlspecialchars($_POST['page_description']):null?></textarea>
				<label for="news_meta_keywords">Ключевые слова</label>
				<textarea class="input-m" name="page_keywords" id="news_meta_keywords" cols="10" rows="3"><?=isset($_POST['page_keywords'])?htmlspecialchars($_POST['page_keywords']):null?></textarea>
			</div>
			<div class="col-md-12 hidden">
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
			<div class="col-md-12">
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
			</div>
			<div class="col-md-12">
				<label for="descr_short">Короткое описание:</label>
				<?=isset($errm['descr_short'])?"<span class=\"errmsg\">".$errm['descr_short']."</span><br>":null?>
				<textarea name="descr_short" id="descr_short" class="input-m" rows="18" cols="195"><?=isset($_POST['descr_short'])?htmlspecialchars($_POST['descr_short']):null?></textarea>
			</div>
			<div class="col-md-12">
				<label for="descr_full">Полное описание:</label>
				<?=isset($errm['descr_full'])?"<span class=\"errmsg\"><br>".$errm['descr_full']."</span>":null?>
				<textarea name="descr_full" id="descr_full" rows="38" cols="200"><?=isset($_POST['descr_full'])?htmlspecialchars($_POST['descr_full']):null?></textarea>
			</div>
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

			<div class="col-md-12">
				<div id="photobox">
					<div class="previews">
						<?$id_news = $GLOBALS['REQAR'][1];?> <!-- получить ид новости -->
						<?if(isset($id_news)) {
							if(isset($_POST['Img']) && !empty($_POST['Img'])){ // определить, есть ли у этой новости массив картинок
								foreach($_POST['Img'] as $photo){
									if(isset($photo['src'])){?>
										<div class="image_block dz-preview dz-image-preview">
											<div class="sort_handle"><span class="icon-font">s</span></div>
											<div class="image">
												<img data-dz-thumbnail src="<?=$photo['src']?>"/>
												<!--src="<?=$photo['src'];?>"/>-->
											</div>
											<div class="name">
												<span class="dz-filename" data-dz-name><?=_base_url?><?=$photo['src']?></span>
												<span class="dz-size" data-dz-size></span>
											</div>
											<div class="controls">
												<p><span class="icon-font del_photo_js" data-img-src="<?=$photo['src']?>" data-dz-remove>t</span></p>
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
						<input type="file" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<label for="date">Дата:</label><?=isset($errm['date'])?"<span class=\"errmsg\">".$errm['date']."</span><br>":null?>
				<input type="text" name="date" id="date" class="input-m wa" value="<?=(isset($_POST['date'])&&!isset($errm['date']))?date("d.m.Y", $_POST['date']):date("d.m.Y", time())?>"/>
				<label>Дата редактирования: <span><?=(isset($_POST['date_update'])&&!isset($errm['date_update']))?htmlspecialchars($_POST['date_update']): ''?></span></label>
				<label>Редактор: <span><?=(isset($_POST['user'])&&!isset($errm['user']))?htmlspecialchars($_POST['user']): ''?></span></label>
			</div>
			<div class="col-md-12" id="nav_visible">
				<h2 class="blue-line">Видимость и индексация</h2>
				<label>Скрыть новость
					<input class="input-m" type="checkbox" name="visible" id="visible" <?=isset($_POST['visible'])&&(!$_POST['visible'])?'checked="checked" value="on"':null?>/></label>
				<label>Индексация
					<input class="input-m" type="checkbox" name="indexation" id="indexation" <?=(isset($_POST['indexation']) && $_POST['indexation'] != 1) || !isset($_POST['indexation'])?null:'checked="checked" value="on"'?>>
				</label>
			</div>
			<div class="col-md-12">
				<b>Разослать новость</b>
				<input class="vam" type="checkbox" value="1" name="news_distribution" id="news_distribution"/>
				<input class="vam input-m wa" type="text" name="limit_from" placeholder="с какого начать"/>
				<input class="vam input-m wa" type="text" name="limit_howmuch" placeholder="сколько выбрать"/>
			</div>
			<div class="col-md-12">
				<label for="sid">Сайт:</label>
				<select class="input-m" name="sid" id="sid">
					<option <?=isset($_POST['sid']) && $_POST['sid'] == 0?'selected':null;?> value="0">x-torg.com</option>
					<option <?=isset($_POST['sid']) && $_POST['sid'] == 1?'selected':null;?> value="1">xt.ua</option>
				</select>
			</div>
			<div class="col-md-12">
				<input type="hidden" name="id_news" id="id_news" value="<?=isset($_POST['id_news'])?$_POST['id_news']:0;?>">
				<input name="smb" type="submit" id="form_submit1" class="save-btn btn-l-default" value="Сохранить">
				<input name="test_distribution" type="submit" id="form_subm1it" class="btn-l-blue" value="Тестовая рассылка">
			</div>
		</div>
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
		//Удаление видео
		$('body').on('click', '.remove_video', function() {
			if(confirm('Вы точно хотите удалить видео?')){
				$(this).parent().remove();
			}
		});

		//Загрузка миниатюры на сайт
		var singledropzone = new Dropzone(".drop_zone_thumb", {
			method: 'POST',
			url: URL_base_global+'ajax?target=image&action=upload',
			uploadMultiple: false,
			clickable: true,
			maxFiles: 1,
			previewsContainer: '.thumbpreviews',
			previewTemplate: document.querySelector('#preview-thumbtemplate').innerHTML
		}).on('success', function(file, value){
			file.previewElement.innerHTML += '<input type="hidden" name="thumb" value="'+value+'">';
		}).on('addedfile', function(file){
			$('.thumbpreviews .image_block.preloaded').remove();
			$('.thumb_block').addClass('hidden');
		}).on('removedfile', function(file){
			removed_file = file.name;
			$('.thumb_block').removeClass('hidden');
			$('.thumbpreviews').append('<input type="hidden" name="removed_images[]" value="'+removed_file+'">');
		});

		//Загрузка Фото на сайт
		var dropzone = new Dropzone(".drop_zone", {
			method: 'POST',
			url: URL_base_global+'ajax?target=image&action=upload',
			clickable: true,
			previewsContainer: '.previews',
			previewTemplate: document.querySelector('#preview-template').innerHTML
		});
		dropzone.on('success', function(file, value){
			file.previewElement.innerHTML += '<input type="hidden" name="images[]" value="'+value+'">';
		}).on('removedfile', function(file){
			removed_file = file.name; // физический путь картинки
			$('.previews').append('<input type="hidden" name="removed_images[]" value="'+removed_file+'">');
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
		$('body').on('click', '.del_photo_js', function(e) {
			//e.stopPropagation();
			if(confirm('Изобрежение будет удалено.')){
				var parent = $(this).closest('.image_block'),
					removed_file = parent.find('input[name="images[]"]').val(); //  /news_images/482/cat.jpg
				RemovedFile(parent, removed_file);
			}
		});
		$('body').on('click', '.del_miniphoto_js', function(e) {
			//e.stopPropagation();
			if(confirm('Изобрежение будет удалено.')){
				var parent = $(this).closest('.image_block'),
					removed_file = parent.find('input[name="thumb"]').val(); //  /news_images/482/cat.jpg
				parent.closest('.thumbpreviews').append('<input type="hidden" name="removed_images[]" value="'+removed_file+'">');
				parent.remove();
			}
		});

		//Удаление только что загруженных фото
		$('body').on('click', '.del_u_photo_js', function(e) {
			e.stopPropagation();
			if(confirm('Изобрежение будет удалено.')){
				var parent = $(this).closest('.image_block'),
					removed_file = parent.find('input[name="images[]"]').val().replace('/../','/');
				RemovedFile(parent, removed_file);
			}
		});
		$('body').on('click', '.del_t_photo_js', function(e) {
			e.stopPropagation();
			if(confirm('Изобрежение будет удалено.')){
				var parent = $(this).closest('.image_block'),
					removed_file = parent.find('input[name="thumb"]').val();
					singledropzone.removeAllFiles();
			}
		});
	});

	function RemovedFile(parent, removed_file){
		parent.closest('.previews').append('<input type="hidden" name="removed_images[]" value="'+removed_file+'">');
		parent.remove();
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