<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="catae" class="grid">
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="row">
		<?if($GLOBALS['CurrentController'] == 'catedit'){ ?>
			<div class="col-md-9 last_edit">
				Последнее редактирование: <b><?=isset($_POST['edit_date'])?$_POST['edit_date']:'-';?></b><br>
				Пользователь: <b><?=isset($_POST['username'])?$_POST['username']:'-'?></b>
			</div>
			<div class="col-md-3">
				<div class="fr">
					<a href="<?=$GLOBALS['URL_base']?>adm/cat_tagedit/<?=$_POST['id_category']?>">Редактирование тегов</a>
					<a href="/<?=isset($_POST['translit'])?$_POST['translit']:null?>" target="_blank">Просмотр категории</a>
				</div>
			</div>
		<?}?>
		<div class="clear"></div>
		<div class="col-md-12">
			<label for="name">Название:</label>
			<?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
			<input type="text" name="name" id="name" class="input-m" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>"/>
		</div>
		<?if(in_array($_SESSION['member']['gid'], array(_ACL_SEO_, _ACL_ADMIN_))){?>
			<?if(isset($_POST['translit'])){ ?>
				<div class="col-md-12 seo_block">
					<div id="translit">
						<a href="#" id="updtrans" class="refresh_btn updtrans_js" title="Нажимать, только при полной замене товара"><i class="icon-font">r</i></a>
						<p><?=$_POST['translit']?></p>
					</div>
				</div>
			<?}?>
			<div class="col-md-12">
				<label for="page_title">Мета-заголовок (title):</label>
				<?=isset($errm['page_title'])?"<span class=\"errmsg\">".$errm['page_title']."</span><br>":null?>
				<input type="text" name="page_title" id="page_title" class="input-m" value="<?=isset($_POST['page_title'])?htmlspecialchars($_POST['page_title']):null?>">
				<label for="page_description">Мета-описание (description):</label>
				<?=isset($errm['page_description'])?"<span class=\"errmsg\">".$errm['page_description']."</span><br>":null?>
				<textarea name="page_description" id="page_description" size="20" cols="223" rows="5" class="input-m"><?=isset($_POST['page_description'])?htmlspecialchars($_POST['page_description']):null?></textarea>
				<label for="page_keywords">Ключевые слова (keywords):</label>
				<?=isset($errm['page_keywords'])?"<span class=\"errmsg\">".$errm['page_keywords']."</span><br>":null?>
				<textarea class="input-m" name="page_keywords" id="page_keywords" cols="10" rows="5"><?=isset($_POST['page_keywords'])?htmlspecialchars($_POST['page_keywords']):null?></textarea>
			</div>
		<?}?>
		<input class="hidden" type="text" name="translit" value="<?=$_POST['translit']?>">
		<div class="col-md-12">
			<p class="category_image_title">Фото категории</p>
			<div class="image_block_new images_block drop_zone animate">
				<div class="dz-default dz-message">Загрузить фото</div>
				<input type="file" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
				<div class="image_block image_block_js exist_photo_js">
					<div class="image">
						<img src="<?=$_POST['category_img']?>">
						<span class="icon-font image_block_delete <?=!empty($_POST['category_img'])?'del_exist_photo_js':'hidden'?>" title="Удалить">t</span>
						<input class="curent_img hidden" type="text" value="<?=$_POST['category_img']?>">
					</div>
				</div>
			</div>
			<div class="image_size_info hidden">
				<p>Настоятельно рекомендуется убедиться, что новое загруженное изображение "квадратное" (все его стороны равны). В ином случае оно может некорректно отображаться на сайте и портить всю его красоту и великолепие. А так же подпортит настроение руководства и как следствие Ваше тоже.</p>
			</div>
		</div>

		<div id="preview-template" class="hidden">
			<div class="image_block image_block_js dz-preview dz-file-preview">
				<div class="image">
					<img data-dz-thumbnail />
					<span class="icon-font del_photo_js" title="Удалить" data-dz-remove>t</span>
				</div>
			</div>
		</div>


		<div class="col-md-12">
			<label for="prom_id">ID категории на prom.ua:</label>
			<?=isset($errm['prom_id'])?"<span class=\"errmsg\">".$errm['prom_id']."</span><br>":null?>
			<input type="text" name="prom_id" id="prom_id" size="20" class="input-m" value="<?=isset($_POST['prom_id'])?htmlspecialchars($_POST['prom_id']):null?>">
		</div>
		<div class="col-md-12">
		<!-- Выбор родительской категории -->
			<label for="pid">Родительская категория:</label>
			<?=isset($errm['pid'])?"<span class=\"errmsg\">".$errm['pid']."</span><br>":null?>
			<select name="pid" id="pid" style="width:285px;" class="input-m">
			 <?foreach ($list as $item){ ?>
				<option <?=(isset($_POST['pid'])&&$_POST['pid']==$item['id_category'])?'selected="true"':null?> value="<?=$item['id_category']?>"><?=str_repeat("&nbsp;&nbsp;&nbsp;", $item['category_level'])?> <?=$item['name']?></option>
			 <?}?>
			</select>
		</div>
		<?if($GLOBALS['CurrentController'] == 'catedit'){ ?>
			<div class="col-md-12">
				<!-- Выбор характеристики -->
				<label>Привязанные характеристики:</label>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
					<colgroup>
						<col width="60%">
						<col width="30%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<td class="left">Описание характеристики</td>
							<td class="left">Единицы измерения</td>
							<td class="left">Управление</td>
						</tr>
					</thead>
					<tbody>
						<?$ids = array();
						if(!empty($cat_spec_list)){
							foreach($cat_spec_list as $i){
								$ids[] = $i['id_spec'];?>
								<tr>
									<td>
										<?=$i['caption']?>
									</td>
									<td>
										<?=$i['units']?>
									</td>
									<td class="left actions">
										<nobr>
											<a href="/adm/catedit/<?=$i['id_cat']?>/?action=delete_spec&id_specification=<?=$i['id_spec']?>" class="btn-m-red-inv" onclick="return confirm('Точно удалить?');">удалить</a>
										</nobr>
									</td>
								</tr>
							<?}
						}?>
					</tbody>
				</table>
			</div>
			<div class="col-md-12">
				<label for="sid">Добавление характеристики:</label>
				<?=isset($errm['sid'])?"<span class=\"errmsg\">".$errm['sid']."</span><br>":null?>
				<select name="sid" id="sid" class="input-m">
					<?$i = 0;
					foreach ($spec_list as $sl){
						if(!in_array($sl['id'], $ids)){
							$i++;?>
							<option value="<?=$sl['id']?>"><?=$sl['caption']?>
							<?if($sl['units'] !== ''){
								echo('('.$sl['units'].')');
							}?>
							</option>
						<?}
					}
					if($i == 0){ ?>
						<option disabled="disabled" selected="selected">Все характеристики добавлены</option>
					<?}?>
				</select>
				<span class="btn-m-default addspec" <?=$i == 0?'disabled="disabled"':null;?>>Добавить</span>
			</div>
		<?}?>
		<div class="col-md-12">
			<label for="visible">Скрытая категория &nbsp;
				<input type="checkbox"  name="visible" id="visible" <?=isset($_POST['visible'])&&(!$_POST['visible'])?'checked="checked" value="on"':null?>>
			</label>
			<label for="indexation"><b>Индексация &nbsp;</b>
				<input type="checkbox" name="indexation" id="indexation" class="input-m" <?=(isset($_POST['indexation']) && $_POST['indexation'] != 1) || !isset($_POST['indexation'])?null:'checked="checked" value="on"'?>>
			</label>
			<input type="hidden" name="id_category" id="id_category" value="<?=isset($_POST['id_category'])?$_POST['id_category']:0?>">
			<div>
				<button name="smb" type="submit" id="form_submit1" class="btn-m-default save-btn">Сохранить</button>
				<!--<button name="delete" type="submit" id="form_submit2" class="btn-m-default ">Удалить категорию</button>-->
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">
	var url = URL_base_global+'ajax/';
	var dropzone = new Dropzone(".drop_zone", {
		method: 'POST',
		url: url+"?target=image&action=upload&path=images/categories/",
		clickable: true,
		uploadMultiple: false,
		maxFiles: 1,
		previewsContainer: '.images_block',
		previewTemplate: document.querySelector('#preview-template').innerHTML
	}).on('success', function(file, path){
			file.previewElement.innerHTML += '<input type="hidden" name="add_image" value="'+path+'">';
	});


	$(function(){
		var id_category = $('[name="id_category"]').val();
		$('.addspec').on('click', function(){
			id_specification = $('#sid').val();
			ajax('cattags', 'setSpecToCat', {id_category: id_category, id_specification: id_specification});
		});

		$('body').on('click', '.dz-message', function(){
			$('.image_size_info').removeClass('hidden');
		});

		$('body').on('click', '.del_photo_js', function(){
			var target = $(this),
				curSrc = target.closest('.image_block_js').find('input').val();
				dropzone.removeAllFiles();
			ajax('image', 'delete', {path: curSrc}).done(function(data){
				dropzone.removeAllFiles();
				// target.closest('.image_block_js').remove();
			});
		});

		$('body').on('click', '.del_exist_photo_js', function(){
			$('.exist_photo_js').addClass('hidden');
			$('.curent_img').attr('name', 'remove_image');
		});

		$('body').on('click', '.updtrans_js', function(){
			$('#updtrans').animate({ borderSpacing: 360 }, {
				step: function(now,fx) {
					$(this).css('-webkit-transform','rotate('+now+'deg)');
					$(this).css('-moz-transform','rotate('+now+'deg)');
					$(this).css('transform','rotate('+now+'deg)');
				},
				duration:'slow'
			},'linear');
			ajax('cattags', 'updateTranslit', {id_category: id_category}).done(function(data){
				$('#translit p').text(data);
			});
		});
	});
	// CKEDITOR.replace('content', {
	//     customConfig: 'custom/ckeditor_config.js'
	// });
	// CKEDITOR.replace('content_xt', {
	//     customConfig: 'custom/ckeditor_config.js'
	// });
</script>