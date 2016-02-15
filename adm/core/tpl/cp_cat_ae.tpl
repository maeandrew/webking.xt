<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
<div id="catae" class="grid">
	<form action="<?=$GLOBALS['URL_request']?>" method="post" class="row">
		<?if($GLOBALS['CurrentController'] == 'catedit'){?>
			<div class="col-md-9 last_edit">
				Последнее редактирование: <b><?=isset($_POST['edit_date'])?$_POST['edit_date']:'-';?></b><br>
				Пользователь: <b><?=isset($_POST['username'])?$_POST['username']:'-'?></b>
			</div>
			<div class="col-md-3">
				<div class="fr">
					<a href="<?=$GLOBALS['URL_base']?>adm/cat_tagedit/<?=$_POST['id_category']?>">Редактирование тегов</a>
					<a href="<?=$GLOBALS['URL_base']?>cat/<?=$_POST['id_category']?>/<?=isset($_POST['translit'])?$_POST['translit']:null?>">Просмотр категории</a>
				</div>
			</div>
		<?}?>
		<div class="clear"></div>
		<div class="col-md-12">
		<!-- /efiles/katalog/Torgovoe-oborudovanie.jpg -->
			<label>Основное фото:</label>
			<img class="pic_block" id="category_img" src="<?=(isset($_POST['category_img'])&&$_POST['category_img']!='')?$_POST['category_img']:"/efiles/_thumb/image/nofoto.jpg"?>">
			<input type="file" name="img" id="cat_img_upload" class="input-l"/>
			<input type="hidden" name="category_img_url" class="input-s" value="<?=isset($_POST['category_img'])?htmlspecialchars($_POST['category_img']):null?>"/>
		</div>
		<div class="col-md-2">
			<label for="art">Артикул:</label>
			<?=isset($errm['art'])?"<span class=\"errmsg\">".$errm['art']."</span><br>":null?>
			<input type="text" name="art" id="art" size="20" class="input-l" value="<?=isset($_POST['art'])?htmlspecialchars($_POST['art']):null?>">
		</div>
		<div class="col-md-10">
			<label for="name">Название:</label>
			<?=isset($errm['name'])?"<span class=\"errmsg\">".$errm['name']."</span><br>":null?>
			<input type="text" name="name" id="name" class="input-l" value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null?>"/>
		</div>
		<?if(in_array($_SESSION['member']['gid'], array(_ACL_SEO_, _ACL_ADMIN_))){?>
			<?if(isset($_POST['translit'])){?>
				<div class="col-md-12 seo_block">
					<div id="translit">
						<a href="#" id="updtrans" class="refresh_btn" title="Нажимать, только при полной замене товара" onclick="updateTranslit();"></a>
						<p><?=$_POST['translit']?></p>
					</div>
				</div>
			<?}?>
			<div class="col-md-12 seo_block">
				<label for="page_title">Мета-заголовок (title):</label>
				<?=isset($errm['page_title'])?"<span class=\"errmsg\">".$errm['page_title']."</span><br>":null?>
				<input type="text" name="page_title" id="page_title" class="input-l" value="<?=isset($_POST['page_title'])?htmlspecialchars($_POST['page_title']):null?>">
				<label for="page_description">Мета-описание (description):</label>
				<?=isset($errm['page_description'])?"<span class=\"errmsg\">".$errm['page_description']."</span><br>":null?>
				<textarea name="page_description" id="page_description" size="20" cols="223" rows="5" class="input-l"><?=isset($_POST['page_description'])?htmlspecialchars($_POST['page_description']):null?></textarea>
				<label for="keywords">Ключевые слова (keywords):</label>
				<?=isset($errm['page_keywords'])?"<span class=\"errmsg\">".$errm['page_keywords']."</span><br>":null?>
				<textarea class="input-l" name="page_keywords" id="keywords" cols="10" rows="5"><?=isset($_POST['page_keywords'])?htmlspecialchars($_POST['page_keywords']):null?></textarea>
				<label for="content">Контент(поисковый текст):</label>
				<?=isset($errm['content'])?"<span class=\"errmsg\">".$errm['content']."</span><br>":null?>
				<textarea name="content" id="content" size="20" cols="223" rows="5" class="input-l"><?=isset($_POST['content'])?htmlspecialchars($_POST['content']):null?></textarea>
				<label for="content_xt">Контент на xt.ua(поисковый текст):</label>
				<?=isset($errm['content_xt'])?"<span class=\"errmsg\">".$errm['content_xt']."</span><br>":null?>
				<textarea name="content_xt" id="content_xt" size="20" cols="223" rows="5" class="input-l"><?=isset($_POST['content_xt'])?htmlspecialchars($_POST['content_xt']):null?></textarea>
			</div>
		<?}?>
		<?if(isset($_POST['category_level']) && $_POST['category_level'] == 1 || !isset($_POST['category_level'])){?>
			<div class="col-md-3">
				<label>Картинка баннера:</label>
				<img class="pic_block" id="category_banner" src="<?=(isset($_POST['category_banner'])&&$_POST['category_banner']!='')?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $_POST['category_banner'])):"/efiles/_thumb/image/nofoto.jpg"?>">
				<input type="file" name="img" id="ban_img_upload" class="input-m"/>
				<input type="hidden" name="category_banner_url" class="input-s" value="<?=isset($_POST['category_banner'])?htmlspecialchars($_POST['category_banner']):null?>"/>
			</div>
			<div class="col-md-4">
				<label for="banner_href">Ссылка баннера:</label>
				<input type="text" id="banner_href" name="banner_href" class="input-m" value="<?=isset($_POST['banner_href'])?htmlspecialchars($_POST['banner_href']):null?>">
			</div>
		<?}?>
		<div class="col-md-12">
			<label for="filial_link">Аналог на <?=$GLOBALS['CONFIG']['invoice_logo_text'] == 'x-torg.com'?'o-torg.com':'x-torg.com';?>:</label></p>
			<?=isset($errm['filial_link'])?"<span class=\"errmsg\">".$errm['filial_link']."</span><br>":null?>
			<input type="text" name="filial_link" id="filial_link" size="20" class="input-l" value="<?=isset($_POST['filial_link'])?htmlspecialchars($_POST['filial_link']):null?>">
		</div>
		<div class="col-md-12">
			<label for="prom_id">ID категории на prom.ua:</label>
			<?=isset($errm['prom_id'])?"<span class=\"errmsg\">".$errm['prom_id']."</span><br>":null?>
			<input type="text" name="prom_id" id="prom_id" size="20" class="input-l" value="<?=isset($_POST['prom_id'])?htmlspecialchars($_POST['prom_id']):null?>">
		</div>
		<div class="col-md-12">
		<!-- Выбор родительской категории -->
			<label for="pid">Родительская категория:</label>
			<?=isset($errm['pid'])?"<span class=\"errmsg\">".$errm['pid']."</span><br>":null?>
			<select name="pid" id="pid" style="width:285px;" class="input-l">
			 <?foreach ($list as $item){?>
				<option <?=(isset($_POST['pid'])&&$_POST['pid']==$item['id_category'])?'selected="true"':null?> value="<?=$item['id_category']?>"><?=str_repeat("&nbsp;&nbsp;&nbsp;", $item['category_level'])?> <?=$item['name']?></option>
			 <?}?>
			</select>
		</div>
		<?if($GLOBALS['CurrentController'] == 'catedit'){?>
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
											<a href="/adm/catedit/<?=$i['id_cat']?>/?action=delete_spec&id_spec_cat=<?=$i['id']?>" class="btn-l-red-inv" onclick="return confirm('Точно удалить?');">удалить</a>
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
				<select name="sid" id="sid" style="width:285px;" class="input-l">
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
					if($i == 0){?>
						<option disabled="disabled" selected="selected">Все характеристики добавлены</option>
					<?}?>
				</select>
				<button class="btn-l-default addspec" <?=$i == 0?'disabled="disabled"':null;?> onclick="">Добавить</button>
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
			<button name="smb" type="submit" id="form_submit1" class="btn-l-default save-btn">Сохранить</button>
		</div>
	</form>
</div>
<script src="../../blueimp/js/vendor/jquery.ui.widget.js"></script>
<script src="../../blueimp/js/load-image.all.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="../../blueimp/js/jquery.iframe-transport.js"></script>
<script src="../../blueimp/js/jquery.fileupload.js"></script>
<script src="../../blueimp/js/jquery.fileupload-process.js"></script>
<script src="../../blueimp/js/jquery.fileupload-image.js"></script>
<script type="text/javascript">
	$(function(){
		var onclick='SetSpecToCat(<?=$_POST['id_category']?>, $(\'#sid\').val())';
		$('button.addspec').attr('onclick', onclick);

		'use strict';
		var url = '/adm/catedit/?upload=true';
		$('#ban_img_upload').fileupload({
			url: url,
			dataType: 'json',
			done: function(e, data){
				$('#category_banner').attr('src','/images/category_banner/'+data.result.img[0]['name']);
				$('[name="category_banner_url"]').val('/images/category_banner/'+data.result.img[0]['name']);
			}
		});
		$('#cat_img_upload').fileupload({
			url: url+'&category_img_urls=1',
			dataType: 'json',
			done: function(e, data){
				$('#category_img').attr('src','/efiles/katalog/'+data.result.img[0]['name']);
				$('[name="category_img_url"]').val('/efiles/katalog/'+data.result.img[0]['name']);
			}
		});
	});
	function SetSpecToCat(id_cat, id_spec){
		$.ajax({
			url: URL_base+'ajaxcattags',
			type: "POST",
			cache: false,
			dataType: "json",
			data: {
				"action": "setspectocat",
				"id_category": id_cat,
				"id_specification": id_spec
			}
		}).done(function(a){
			console.log(a);
		});
		// alert(a);
		// alert(b);
	}

	//Обновление транслита категории
	function updateTranslit(){
		$.ajax({
			url: URL_base+'ajaxcattags',
			type: "POST",
			cache: false,
			dataType: "json",
			data: {
				"action":'update_translit',
				"id_category": <?=$_POST['id_category']?>
			}
		}).done(function(data){
			$('#translit p').text(data);
			$('#updtrans').animate({  borderSpacing: 360 }, {
				step: function(now,fx) {
					$(this).css('-webkit-transform','rotate('+now+'deg)');
					$(this).css('-moz-transform','rotate('+now+'deg)');
					$(this).css('transform','rotate('+now+'deg)');
				},
				duration:'slow'
			},'linear');
		});
	}
	CKEDITOR.replace('content', {
	    customConfig: 'custom/ckeditor_config.js'
	});
	CKEDITOR.replace('content_xt', {
	    customConfig: 'custom/ckeditor_config.js'
	});
</script>