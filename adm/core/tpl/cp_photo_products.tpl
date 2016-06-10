<h1><?=$header;?></h1>
<a href="#">Начать наполнение поставщика</a>
<div class="create_product">
	<div class="supplier">
		<label for="supplier">Поставщик</label>
		<input type="text" class="input-m" placeholder="Выберите поставщика" name="supplier" id="supplier" list="suppliers">
		<datalist id="suppliers">
			<option value="S100">1</option>
			<option value="A01">1</option>
			<option value="X11">2</option>
			<option value="A45">3</option>
			<option value="T56">4</option>
			<option value="Z05">5</option>
		</datalist>
	</div>
	<div class="prodName">
		<label for="prodName">Название товара</label>
		<input type="text" id="prodName" class="input-m">
	</div>
	<div class="images hidden">
		<label for="images">Изображения</label>
		<div class="fallback">
			<input type="file" name="images" id="images" multiple />
		</div>
	</div>
	<div class="submit">
		<button class="btn-m-default submit_js">Применить</button>
	</div>
	<div class="image_block_new drop_zone animate col-md-12">
		<div class="dz-default dz-message">Перетащите сюда фото или нажмите для загрузки.</div>
		<input type="file" multiple="multiple" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
	</div>
	<div class="images_block"></div>
</div>
<div id="preview-template" class="hidden">
	<div class="image_block image_block_js dz-preview dz-file-preview">
		<div class="image">
			<img data-dz-thumbnail />
			<span class="icon-font hide_photo_js" title="Скрыть/отобразить">v</span>
			<span class="icon-font del_photo_js" title="Удалить" data-dz-remove="">t</span>
		</div>
		<div class="name">
			<span class="dz-filename" data-dz-name></span>
			<span class="dz-size" data-dz-size></span>
		</div>		
	</div>
</div>
<div class="prodList">
	<?foreach ($list as $item) {?>
		<div class="prodListItem">
		<div class="nameProd">
			<a href="<?=Link::Product($item['translit'])?>">Товар:</a>
			<span><?=$item['name']?></span>			
		</div>
		<div class="createData">
			<span>Дата:</span>
			<span><?=$item['create_date']?></span>
		</div>
		<div class="prodImages">
			<?foreach ($item['images'] as $image) {?>
				<img src="<?=$image['src']?>" class="<?=$image['visible'] === 0 ? 'imgopacity' : ''?>">
			<?}?>				
		</div>
	</div>
	<?}?>	
</div>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>

<script>
	var url = URL_base+'productadd/';
	var dropzone = new Dropzone(".drop_zone", {
		method: 'POST',
		url: url+"?upload=true",
		clickable: true,
		previewsContainer: '.images_block',	
		previewTemplate: document.querySelector('#preview-template').innerHTML
	}).on('success', function(file, path){
			file.previewElement.innerHTML += '<input type="hidden" name="images[]" value="'+path+'">';
	});

	$(window).load(function(){
		$('#supplier').val($.cookie('suppler'));
	});

	$(function(){
		$('#supplier').on('change', function(){
			currentSupplier = $('#supplier').val();
			$.cookie('suppler', currentSupplier);
		});

		$('body').on('click', '.hide_photo_js', function(){
			$(this).closest('.image').find('img').toggleClass('imgopacity');
		});

		$('body').on('click', '.del_photo_js', function(){
			var target = $(this),
				curSrc = target.closest('.image_block_js').find('input').val();
			$.ajax({
				url: URL_base+'ajaxproducts',
				type: "POST",
				cache: false,
				dataType: "json",
				data: {
					action: 'DeleteUploadedImage',
					src: curSrc,
				}
			}).done(function(data){
				target.closest('.image_block_js').remove();
			});
		});

		$('.submit_js').on('click', function(){
			var ArtSupplier = $.cookie('suppler');
			var Name = $('#prodName').val();
			var Images = [];

			$('.images_block .image_block_js').each(function(){	
				var visibility = $(this).find('img').hasClass('imgopacity') === false;
				var path = $(this).find('input').val();
				var curData = {src: path, visible: visibility};
				Images.push(curData);
			});

			/*Проверка ввода необходимых данных, отправка аякса и добавление нового товара в список*/
			if ($('#supplier').val() != '') {
				$('#supplier').removeClass('errName');
				if (Name != '') {
					$('#prodName').removeClass('errName');
					if($(".images_block").html() != ''){
						$('.image_block_new').removeClass('errName');
						$.ajax({
							url: URL_base+'ajaxproducts',
							type: "POST",
							cache: false,
							dataType: "html",
							data: {
								action: 'AddPhotoProduct',
								art_supplier: ArtSupplier,
								name: Name,
								images: Images
							}
						}).done(function(data){
							$('.prodList').prepend(data);
							$('.images_block').find('.image_block_js').remove();
							$('#prodName').val('');
						});
					}else{
						$('.image_block_new').addClass('errName');
					}
				}else{
					$('#prodName').addClass('errName');
				}
			}else{
				$('#supplier').addClass('errName');
			}
		});
	});
</script>