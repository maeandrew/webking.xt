<link rel="stylesheet" href="/adm/css/page_styles/productedit.css">
<?if(isset($_POST['id_supplier']) && $_POST['id_supplier'] != $_SESSION['member']['id_user']){
	header('Location: '._base_url.'/404');
}?>
<div id="supplier_cab" class="cabinet_content">
	<h1>Создать новый товар</h1>
	<?if(isset($_POST['moderation_status']) == true && $_POST['moderation_status'] == 2){?>
		<div class="col-md-12">
			<div class="msg-warning">
				<p>Товар находиться в каталоге. В данном статусе редактирование недоступно.</p>
			</div>
		</div>
	<?}elseif(isset($_POST['moderation_status']) == true && $_POST['moderation_status'] == 1){?>
		<div class="col-md-12">
			<div class="msg-error">
				<p><b>Модерация не пройдена!</b><br/><?=$_POST['comment'];?></p>
			</div>
		</div>
	<?}?>
	<div class="editproduct">
		<!-- <a href="/cabinet/productsonmoderation" class="add_one_more_product back">Перейти к списку товаров на модерации</a> -->
		<div id="editbox" class="row<?=isset($_POST['moderation_status']) == true && $_POST['moderation_status'] == 2?' disabled':null;?>">
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<?if(isset($_POST['id']) == true && $_POST['id'] != ''){?>
					<input type="hidden" name="id" value="<?=$_POST['id']?>">
				<?}?>
				<div class="col-md-12">
					<div class="input_row">
						<span class="num_item">1.</span>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" id="product_name" name="name" type="text" maxlength="255" autocomplete="off" required value="<?=isset($_POST['name'])?htmlspecialchars($_POST['name']):null;?>">
							<label class="mdl-textfield__label" for="product_name">Название:</label>
						</div>
					</div>
				</div>
				<div class="col-md-12 input_row">
					<span class="num_item">2.</span>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<textarea class="mdl-textfield__input" type="text" name="descr" id="descr" required><?=isset($_POST['descr'])?str_replace('<br>', '', $_POST['descr']):null;?></textarea>
						<label class="mdl-textfield__label" for="descr">Описание:</label>
					</div>
				</div>
				<div class="col-md-12 input_row input_col">
					<label class="num_item">3. Фото:</label>
					<div id="photobox" class="ajax_loading">
						<?if(isset($_POST['images']) && $_POST['images'] != ''){
							$arr = explode(';', $_POST['images']);?>
							<input type="hidden" name="images" value="<?=$_POST['images']?>">
						<?}else{?>
							<input type="hidden" name="images">
						<?}?>
						<div class="previews">
							<?if(!empty($arr)){
								foreach($arr AS $photo){?>
									<div class="image_block dz-preview dz-processing dz-success dz-complete dz-image-preview">
										<div class="sort_handle"><i class="material-icons">arrow_drop_down</i></div>
										<div class="image">
											<img data-dz-thumbnail src="<?=$photo?>"/>
										</div>
										<div class="name">
											<span class="dz-filename" data-dz-name><?=str_replace('/files/'.$_SESSION['member']['email'].'/','',$photo)?></span>
											<span class="dz-size" data-dz-size></span>
										</div>
										<div class="controls">
											<a href="#" class="del_photo_js"><i class="material-icons">delete</i></a>
										</div>
										<input type="hidden" class="photo_src" value="<?=$photo?>">
									</div>
								<?}
							}?>
							<!-- <div class="image_block">
								<div class="sort_handle"><span class="icon-font">sort_handle</span></div>
								<div class="image">
									<img src="/images/nofoto.png" alt="Оригинал">
								</div>
								<div class="name"></div>
								<div class="controls">
									<a href="#"><span class="icon-font">download</span></a>
									<a href="#"><span class="icon-font">delete</span></a>
								</div>
							</div> -->
						</div>
						<div class="image_block_new drop_zone animate">
							<div class="dz-default dz-message">Перетащите сюда фото или нажмите для загрузки.</div>
							<input type="file" multiple="multiple" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
						</div>
					</div>
					<!-- <a href="#" class="addonemorephoto"><span class="icon-font">add</span>Добавить еще одно фото</a> -->
				</div>
				<div class="col-md-12 input_row">
					<span class="label_imit">4. Единицы измерения:</span>
					<select class="input-l mdl-textfield mdl-js-textfield" name="id_unit" id="units">
						<?foreach($units as $value){?>
							<option class="mdl-textfield__input" value="<?=$value['id']?>" <?=isset($_POST['id_unit'])&&$_POST['id_unit']==$value['id']?'selected="true"':null?>><?=$value['unit_xt']?></option>
						<?}?>
					</select>
				</div>
				<div class="col-md-12">
					<div class="input_row dynamic_info_units">
						<span class="num_item">5.</span>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
							<input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="min_mopt_qty" name="min_mopt_qty" min="1" required value="<?=isset($_POST['min_mopt_qty'])?$_POST['min_mopt_qty']:null;?>">
							<label class="mdl-textfield__label" for="min_mopt_qty">Минимально отпускаемое количество товара:</label>
						</div>
						<span class="info_units">шт.</span>
					</div>
				</div>
				<div class="col-md-12 input_row">
					<span class="span_for_checkbox">6. Кратность минимального количества:</span>
					<label class="mdl-checkbox mdl-js-checkbox" for="qty_control">
						<input type="checkbox" name="qty_control" id="qty_control" class="mdl-checkbox__input" value="1" <?=(isset($_POST['qty_control']) && $_POST['qty_control'] == 1)?'checked="true"':null;?>>
						<span class="mdl-checkbox__label"></span>
					</label>
				</div>
				<div class="col-md-12">
					<div class="input_row dynamic_info_units">
						<span class="num_item">7.</span>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
							<input class="mdl-textfield__input" type="number" pattern="-?[0-9]*(\.[0-9]+)?" id="inbox_qty" name="inbox_qty" min="1" required value="<?=isset($_POST['inbox_qty'])?$_POST['inbox_qty']:null;?>">
							<label class="mdl-textfield__label" for="inbox_qty">Оптовое количество товара:</label>
						</div>
						<span class="info_units">шт.</span>
					</div>
				</div>
				<div class="col-md-12 input_row">
					<span class="num_item">8.</span>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
						<input class="mdl-textfield__input" pattern="-?[0-9]*(\.[0-9]+)?" type="number" id="price_mopt" name="price_mopt" min="0" required step="0.01" value="<?=isset($_POST['price_mopt'])?$_POST['price_mopt']:null;?>">
						<label class="mdl-textfield__label" for="price_mopt">Цена за единицу товара при минимальном количестве:</label>
					</div>
					<span class="info_units">грн</span>
				</div>
				<div class="col-md-12">
					<div class="input_row">
						<span class="num_item">9.</span>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
							<input class="mdl-textfield__input" pattern="-?[0-9]*(\.[0-9]+)?" type="number" id="price_opt" name="price_opt" min="0" required step="0.01" value="<?=isset($_POST['price_opt'])?$_POST['price_opt']:null;?>">
							<label class="mdl-textfield__label" for="price_opt">Оптовая цена:</label>
						</div>
						<span class="info_units">грн</span>
					</div>
				</div>
				<div class="col-md-12 input_row">
					<span class="num_item">10.</span>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
						<input class="mdl-textfield__input" pattern="-?[0-9]*(\.[0-9]+)?" type="number" name="weight" min="0" id="weight" step="0.01" value="<?=isset($_POST['weight'])?$_POST['weight']:null;?>">
						<label class="mdl-textfield__label" for="weight">Вес:</label>
					</div>
					<p class="info_units">кг</p>
				</div>
				<div class="col-md-12">
					<span>11. Габариты:</span>
					<div class="input_row input_col gabarits">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
							<input class="mdl-textfield__input" pattern="-?[0-9]*(\.[0-9]+)?" type="number" name="height" min="0" id="height" min="0" value="<?=isset($_POST['height'])?htmlspecialchars($_POST['height']):0?>" required>
							<label class="mdl-textfield__label">Высота (cм):</label>
						</div>	
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
							<input class="mdl-textfield__input" pattern="-?[0-9]*(\.[0-9]+)?" type="number" name="width" min="0" id="width" class="input-m" min="0" value="<?=isset($_POST['width'])?htmlspecialchars($_POST['width']):0?>" required>
							<label class="mdl-textfield__label">Ширина (см):</label>
						</div>	
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
							<input class="mdl-textfield__input" pattern="-?[0-9]*(\.[0-9]+)?" type="number" name="length" id="length" class="input-m" min="0" value="<?=isset($_POST['length'])?htmlspecialchars($_POST['length']):0?>" required>
							<label class="mdl-textfield__label">Длина (см):</label>
						</div>
					</div>
				</div>
				<div class="col-md-12 input_row">
					<span class="num_item">12.</span>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
						<input class="mdl-textfield__input" pattern="-?[0-9]*(\.[0-9]+)?" type="number" name="coefficient_volume" id="coefficient_volume" min="0" step="0.01" value="<?=isset($_POST['coefficient_volume'])?$_POST['coefficient_volume']:1;?>">
						<label class="mdl-textfield__label" for="coefficient_volume">Коэффициент реального обьема:</label>
					</div>
				</div>
				<div class="col-md-12">
					<div class="input_row dynamic_info_units">
						<span class="num_item">13.</span>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label input_number">
							<input class="mdl-textfield__input" pattern="-?[0-9]*(\.[0-9]+)?" type="number" name="product_limit" min="0" id="product_limit" required value="<?=isset($_POST['product_limit'])? $_POST['product_limit']:null;?>">
							<label class="mdl-textfield__label">Актуальный остаток:</label>
						</div>
						<span class="info_units">шт.</span>
					</div>
				</div>
				<div class="col-md-12">
					<button type="submit" id="submit" name="editionsubmit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">Сохранить</button>
				</div>
			</form>
		</div>
	</div>
	<div class="help_block">
		<ul id="help">
			<?=$GLOBALS['CONFIG']['supplier_product_add_instructions'];?>
		</ul>
	</div>
	<div id="preview-template" style="display: none;">
		<div class="image_block dz-preview dz-file-preview">
			<div class="sort_handle"><i class="material-icons">arrow_drop_up</i><i class="material-icons">arrow_drop_down</i></div>
			<div class="image">
				<img data-dz-thumbnail />
			</div>
			<div class="name">
				<span class="dz-filename" data-dz-name></span>
				<span class="dz-size" data-dz-size></span>
			</div>
			<div class="controls">
				<!-- <a href="#"><span class="icon-font">download</span></a> -->
				<a href="#" class="del_photo_js"><i class="material-icons">delete</i></a>
			</div>
		</div>
	</div>
</div>
<script>
// This is an example of completely disabling Dropzone's default behavior.
	// Do *not* use this unless you really know what you are doing.
	<?if(isset($_POST['moderation_status']) == true && $_POST['moderation_status'] == 2){?>
		// $('#editbox input,#editbox select, #editbox textarea').prop('disabled', true);
	<?}?>
	var url = "<?=_base_url?>/cabinet/editproduct/";
	$(function(){
		$('#photobox').removeClass('ajax_loading');
		$('#editbox input, #editbox textarea, #editbox select').on('blur', function(){
			askaboutleave();
		});

		//Удаление фото
		$('body').on('click', '.del_photo_js', function(event) {
			event.preventDefault();
			if(confirm('Изобрежение будет удалено.')){
				askaboutleave();
				var path = $(this).closest('.image_block'),
					removed_file = path.find('.photo_src').val(),
					images = $('#photobox').find('input[name="images"]').val().split(';'),
					index = images.indexOf(removed_file);
				images.splice(index, 1);
				$('#photobox').find('input[name="images"]').val(images.join(';'));
				path.closest('.previews').append('<input type="hidden" name="removed_images[]" value="'+removed_file+'">');
				$(this).closest('.image_block').remove();
			}
		});

		var dropzone = new Dropzone(".drop_zone", {
			method: 'POST',
			//url: url+"?upload=true",
			url: URL_base+'ajax?target=image&action=upload',
			clickable: true,
			previewsContainer: '.previews',
			previewTemplate: document.querySelector('#preview-template').innerHTML
		});
		dropzone.on('addedfile', function(file){
			askaboutleave();
		}).on('success', function(file, path){
			file.previewElement.innerHTML += '<input type="hidden" class="photo_src" value="'+path+'">';
			var images = $('#photobox').find('input[name="images"]').val();
			if(images == ''){
				$('#photobox').find('input[name="images"]').val(path);
			}else{
				$('#photobox').find('input[name="images"]').val(images+';'+path);
			}
		});
		$('.previews').sortable({
			items: ".image_block",
			handle: ".sort_handle",
			connectWith: ".previews",
			containment: ".previews",
			placeholder: "ui-sortable-placeholder",
			axis: "y",
			scroll: false,
			tolerance: "pointer",
			update: function(event, ui){
				askaboutleave();
				var images = '';
				$('.previews img').each(function(){
					if(images == ''){
						images = $(this).closest('.image_block').find('.photo_src').attr('value');
					}else{
						images += ';'+$(this).closest('.image_block').find('.photo_src').attr('value');
					}
				});
				$('#photobox').find('input[name="images"]').val(images);
			}
		});
	});
	
	function askaboutleave(){
		if(!asking){
			var asking = true;
			$(window).bind('beforeunload', function(){
				return 'Все изменнения будут утеряны. Все загруженные фото будут удалены.';
			});
		}
	}
/*
	// $('#supplier_cab form .photo_upload_area.photo2, #supplier_cab form .photo_upload_area.photo3');
	var file = [];
	var i = 1;
	initiateUploader(i);
*/
	var errors = new Array();
	var errorCounter = 0;
	function count(obj) {
		var count = 0;
		for(var prs in obj){
			if(obj.hasOwnProperty(prs)) count++;
		}
		return count;
	}
/*
<?if(isset($_POST['img_1']) == true && $_POST['img_1'] <> ''){?>
	file.name = '<?=str_replace('/files/'.$_SESSION['member']['email'].'/', "", $_POST['img_1'])?>';
	photoDone(1, file);
<?}?>
<?if(isset($_POST['img_2']) == true && $_POST['img_2'] <> ''){?>
	oneMorePhoto();
	file.name = '<?=str_replace('/files/'.$_SESSION['member']['email'].'/', "", $_POST['img_2'])?>';
	photoDone(2, file);
<?}?>
<?if(isset($_POST['img_3']) == true && $_POST['img_3'] <> ''){?>
	oneMorePhoto();
	file.name = '<?=str_replace('/files/'.$_SESSION['member']['email'].'/', "", $_POST['img_3'])?>';
	photoDone(3, file);
<?}?>
showUnits();
//	$('#name').val('Какое-то название моего нового товара');
//	$('#descr').text('Какое-то описание моего нового товара');
//	$('#units').val('шт.');
//	showUnits();
//	$('#min_mopt_qty').val('2');
//	$('#inbox_qty').val('12');
//	$('#price_mopt').val('154');
//	$('#price_opt').val('250');
//	validateOptPrice();
//	$('#product_limit').val('15');
//	validateProductLimit();
*/
	$('#editbox input,#editbox select, #editbox textarea').focus(function(){
		$('li.'+$(this).prop('id')).addClass('active_hint')
		$(this).blur(function(){
			$('li.'+$(this).prop('id')).removeClass('active_hint')
		});
	});
	$('[id^="img_"]').on('change', function(){
		validatePhoto();
	});
	$('#product_name').blur(function(){
		validateName();
	});
	$('#units').change(function(){
		showUnits();
	});
	$('#min_mopt_qty, #inbox_qty').blur(function(){
		validateMinMoptQty();
		validateInboxQty();
	});
	$('#price_mopt, #price_opt').blur(function(){
		validateOptPrice();
	});
	$('#product_limit').blur(function(){
		validateProductLimit();
	});
	function validateName(){
		if($('#product_name').val() == ''){
			registerError('product_name','+','Имя не указано');
		}else{
			registerError('product_name','-');
		}
	}
	function validatePhoto(){
		var photos = ['img_1', 'img_2', 'img_3'];
		var uploaded = photo1 = photo2 = 0;
		$.each(photos, function(i, value){
			if($('[name="'+value+'"]').val().length <= 0 && i == 0){
				photo1 = 1;
			}else if($('[name="'+value+'"]').val().length <= 0 && i == 1){
				photo2 = 1;
			}else{
				if($('[name="'+value+'"]').val().length > 0){
					uploaded++;
				}
			}
		});
		if(uploaded == 0){
			registerError('photobox','+','Фото не загружены');
		}else if(photo1 == 1 && uploaded > 0){
			registerError('photobox','+','Основное фото не загружено');
		}else if(photo2 == 1 && uploaded > 1){
			registerError('photobox','+','Фото не упорядоченно.<br>Нельзя установить фото №3 без установки фото №2.');
		}else{
			registerError('photobox','-');
		}
	}
	function validateUnits(){
		if($('#units').val().match('[0-9]')){
			registerError('units','+','Это значение не может содержать числа');
		}else if($('#units').val() == ''){
			registerError('units','+','Не указаны еденицы измерения');
		}else{
			registerError('units','-');
		}
	}
	function validateMinMoptQty(){
		if(parseInt($('#min_mopt_qty').val()) <= 0 || $('#min_mopt_qty').val() == ''){
			registerError('min_mopt_qty','+','Не указано минимальное количество');
		}else{
			registerError('min_mopt_qty','-');
		}
		if(parseInt($('#min_mopt_qty').val()) == 1){
			$('#qty_control').prop('disabled', true).prop('checked', false);
		}else{
			$('#qty_control').prop('disabled', false);
		}
	}
	function validateInboxQty(){
		if(parseInt($('#inbox_qty').val()) <= 0 || $('#inbox_qty').val() == ''){
			registerError('inbox_qty','+','Не указано количество в ящике');
		}else if(parseInt($('#inbox_qty').val()) <= parseInt($('#min_mopt_qty').val())){
			registerError('inbox_qty','+','Количество в ящике должно быть больше минимального количества');
		}else{
			registerError('inbox_qty','-');
		}
	}
	function validateMoptPrice(){
		if(parseFloat($('#price_mopt').val()) <= 0 || $('#price_mopt').val() == ''){
			registerError('price_mopt','+','Не указана розничная цена');
		}else{
			registerError('price_mopt','-');
		}
	}
	function validateOptPrice(){
		if(parseFloat($('#price_opt').val()) <= 0 || $('#price_opt').val() == ''){
			registerError('price_opt','+','Не указана оптовая цена');
		}else if(parseFloat($('#price_opt').val()) > parseFloat($('#price_mopt').val()) && parseFloat($('#price_mopt').val()) > 0){
			registerError('price_opt','+','Оптовая цена не может превышать розничную');
		}else{
			registerError('price_opt','-');
		}
	}
	function validateProductLimit(){
		if(parseInt($('#product_limit').val()) <= 0 || $('#product_limit').val() == ''){
			registerError('product_limit','+','Товар должен быть в наличии');
		}else{
			registerError('product_limit','-');
		}
	}
	function showUnits(){
		$('.dynamic_info_units .info_units').hide().text($('#units option:selected').text()).fadeIn();		
	}
	function registerError(key, direction, content){
		if(direction == "+"){
			errors[key] = content;
			$('#'+key).css('color', '#f33').closest('.col-md-12').find('p.error').remove();
			$('#'+key).closest('.col-md-12').append('<p class="error">'+content+'</p>');
		}else if(direction == "-"){
			delete errors[key];
			$('#'+key).css('color', '#000').closest('.col-md-12').find('p.error').remove();
		}
		if(count(errors) > 0){
			$('#submit').prop('disabled', true);
		}else{
			$('#submit').prop('disabled', false);
			$(window).unbind('beforeunload');
		}
	}
	$('#submit').on('click', function(){
		// $('.photo_upload_area').each(function(){
		// 	if($(this).find('#photo_preview').html() == '' && $(this).find('[id^="img_"]').val().length > 0){
		// 		deletePhoto($(this).prop('class').replace(/\D+/g,""), $(this).find('[id^="img_"]').val());
		// 		$(this).find('[id^="img_"]').val('');
		// 	}
		// });
		if(validateForm() == true){
			$(this).closest('form').submit();
		}else{
			return false;
		}		
	});
	
	function validateForm(){
		validateName();
		validatePhoto();
		validateUnits();
		validateMinMoptQty();
		validateInboxQty();
		validateMoptPrice();
		validateOptPrice();
		validateProductLimit();
		if($('#submit').prop('disabled') == true){
			return false;
		}else{
			return true;
		}
	}

/*
	function preDeletePhoto(id){
		$('.photo'+id).find('a').hide();
		$('.photo'+id+' #photo_preview').css({
			"width": '100px'
		}).html('');
		$('#photo'+id).show();
		validatePhoto();
	}
	
	function oneMorePhoto(){
		i++;
		$('.photo'+i).slideDown().css('display','none').slideDown().focus();
		if(i == 3){
			$('.addonemorephoto').hide();
		}
		initiateUploader(i);
	}
	// When the server is ready...
	function initiateUploader(id){
		'use strict';
		// Define the url to send the image data to
		var url = '/cabinet/editproduct/?upload=true';
		// Call the fileupload widget and set some parameters
		$(document).on('change drop', 'input#photo'+id, function(){
			$('#photo'+id).hide();
			$('.photo'+id+' #photo_preview').html('<img src="http://www.dlib.si/images/loading.gif">');
		});
		$('#photo'+id).fileupload({
			url: url,
			dataType: 'json',
			done: function(e, data){
				// Add each uploaded file name to the #files list
				$.each(data.result.files, function (index, file){
					if(file.error == null){
						photoDone(id, file);
					}else{
						$('.photo'+id).append('<span class="error">'+file.error+'</span>');
						$('.photo'+id+' #photo_preview').html('');
						$('#photo'+id).show();
					}
					validatePhoto();
				});
			}
		});
	}

	function photoDone(id, file){
		$('.photo'+id+' span').remove();
		var imageLink = "<?=$GLOBALS['URL_base']?>/files/<?=$_SESSION['member']['email'];?>/"+file.name;
		var downloadLink = "<a class=\"photoname icon-font\" download=\""+file.name+"\" href=\""+imageLink+"\" title=\"Сохранить фотографию на компьютер\">download</a>";
		<?if(isset($_POST['moderation_status']) && $_POST['moderation_status'] == 2){?>
			var deleteLink = '';
		<?}else{?>
			var deleteLink = "<a class=\"icon-font\" style=\"text-decoration: none;\" onclick=\"preDeletePhoto("+id+", '"+file.name+"');\" title=\"Удалить\">delete</a>";
		<?}?>
		var oldphoto = $('#img_'+id).val();
		if(oldphoto != '' && oldphoto != imageLink){
			deletePhoto(id, oldphoto);
		}
		$('.photo'+id).append('<span><a href="'+imageLink+'" target="_blank" title=\"Посмотреть полный размер\">'+file.name+'</a>'+downloadLink+deleteLink+'</span>');
		$('.photo'+id+' #photo_preview').html("<img src=\""+imageLink+"\"/>");
		$('.photo'+id+' #photo_preview').css({"width": 'auto'});
		$('#photo'+id).hide();
		$('#img_'+id).val(imageLink);
		$('.photo'+id+' span').css({
			"max-width": ($('.photo'+id).width()-$('.photo'+id+' #photo_preview').width()-20) + 'px'
		});
	}
*/
</script>