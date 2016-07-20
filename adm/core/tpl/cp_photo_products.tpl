<h1><?=$header;?>
	<?if($_SESSION['member']['gid'] != _ACL_PHOTOGRAPHER_){?>
		<form action="" method="post" class="photographer_select">
			<select name="user" class="input-m" id="user">
				<?foreach($users_list as $user){?>
					<option <?=isset($id_photographer) && $id_photographer == $user['id_user']?'selected':null;?> value="<?=$user['id_user']?>"><?=$user['name'].' - '.$user['email']?></option>
				<?}?>
			</select>
			<input type="submit" class="btn-m-blue" name="change_user" value="Выбрать">
		</form>
	<?}?>
</h1>
<!-- <a href="#">Начать наполнение поставщика</a> -->
<?if($_SESSION['member']['gid'] == _ACL_PHOTOGRAPHER_){?>
	<div class="create_product row">
		<div class="upload_message hidden">Подождите идет загрузка метриалов...</div>
		<div class="col-md-12">
			<h3>Добавить новый товар</h3>
		</div>
		<div class="supplier col-md-4">
			<label for="supplier">Поставщик:</label>
			<input type="text" class="input-m" placeholder="Выберите поставщика" name="supplier" id="supplier" list="suppliers">
			<datalist id="suppliers">			
				<?foreach($suppliers_list as $supplier){?>				
					<option value="<?=$supplier['article']?>"><?=$supplier['name']?></option>
				<?}?>			
			</datalist>
		</div>
		<div class="prodName col-md-4">
			<label for="prodName">Название:</label>
			<input type="text" id="prodName" class="input-m">
		</div>
		<div class="submit col-md-4">
			<button class="btn-m-default submit_js">Применить</button>
		</div>
		<div class="col-md-12">
			<div class="image_block_new drop_zone animate">
				<div class="dz-default dz-message">Перетащите сюда фото или нажмите для загрузки.</div>
				<input type="file" multiple="multiple" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
			</div>
		</div>
		<div class="col-md-12">
			<div class="images_block"></div>
		</div>
		<div class="video_upload col-md-12">
			<a class="add_video add_video_js btn-m-blue-inv">Добавить видео</a>
			<ul class="video_list video_list_js"></ul>
		</div>
	</div>
<?}?>
<div id="preview-template" class="hidden">
	<div class="image_block image_block_js dz-preview dz-file-preview">
		<div class="image">
			<img data-dz-thumbnail class="imgopacity"/>
			<span class="icon-font hide_photo_js" title="Скрыть/отобразить">v</span>
			<span class="icon-font del_photo_js" title="Удалить" data-dz-remove="">t</span>
		</div>
		<div class="name">
			<span class="dz-filename" data-dz-name></span>
		</div>		
	</div>
</div>
<div class="prodList">
	<?if(isset($list) && is_array($list)){
		foreach($list as $item){?>
			<div class="prodListItem">
				<div class="prodInfo">
					<div class="nameProd">
						<label>Название:</label>
						<span><?=$item['name']?></span>
					</div>
					<div class="createData">
						<label>Добавлен:</label>
						<span><?=$item['create_date']?></span>
					</div>
				</div>
				<div class="actions">
					<a href="/adm/productedit/<?=$item['id_product']?>" class="icon-font btn-m-blue" target="_blank" title="Редактировать">e</a>
					<a href="<?=_base_url.'/'.$item['translit']?>.html" class="icon-font btn-m-green" target="_blank" title="Посмотреть на сайте">v</a>
				</div>
				<?if(is_array($item['images'])){?>
					<div class="prodImages">
						<?foreach($item['images'] as $image){?>
							<img src="<?=str_replace('/original/', '/thumb/', $image['src'])?>"<?=$image['visible'] == 0?' class="imgopacity"':null?>>
						<?}?>
					</div>
				<?}
				if(is_array($item['videos'])){?>
					<div class="prodVideos">
						<?foreach($item['videos'] as $video){?>
							<a href="<?=$video?>" target="blank">
								<img src="/images/video_play.png">
								<span class="name"><?=$video?></span>
							</a>
						<?}?>
					</div>
				<?}?>
			</div>
		<?}
	}else{
		echo isset($id_photographer)?'Выберите фотографа, для просмотра его добавлений':'Нечего показывать, товары не добавлялись!';
	}?>
</div>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
<script>
	window.onbeforeunload = function(event) {
		var check_video = false;
		$('.video_list_js li').each(function(){
			var intut_val = $(this).find('input').val();
			if (intut_val !== ''){
				check_video = true;
			}			
		});
		if ($('.images_block').html() !== '' || check_video === true) {
			event.returnValue = "Write something clever here..";
		}
	};

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
		// $('#user').on('change', function(){
		// 	window.location.assign($(this).val()+'/');
		// });
		$('#supplier').on('change', function(){
			currentSupplier = $('#supplier').val();
			$.cookie('suppler', currentSupplier);
		});

		//Добавление видео
		$(".add_video_js").on('click', function() {
			$(".video_list_js").append('<li><input type="text" name="video[]" class="input-m"></li>');
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
		
		$(".image_block_new").on('click', function(){
			$('.image_block_new').removeClass('errName');
		});

		$('.submit_js').on('click', function(){
			var ArtSupplier = $.cookie('suppler');
			var Name = $('#prodName').val();
			var Images = [];
			var Videos = [];

			$('.images_block .image_block_js').each(function(){	
				var visibility = $(this).find('img').hasClass('imgopacity') === false;
				var path = $(this).find('input').val();
				var curData = {src: path, visible: visibility};
				Images.push(curData);
			});
			$('.video_list_js li').each(function(){
				var path = $(this).find('input').val();
				Videos.push(path);
			});			
			/*Проверка ввода необходимых данных, отправка аякса и добавление нового товара в список*/
			if ($('#supplier').val() !== '') {
				$('#supplier').removeClass('errName');
				if($(".images_block").html() !== ''){
					console.log(Name);
					console.log(Images);
					console.log(Videos);
					$('.upload_message').removeClass('hidden');
					$.ajax({
						url: URL_base+'ajaxproducts',
						type: "POST",
						cache: false,
						dataType: "html",
						data: {
							action: 'AddPhotoProduct',
							art_supplier: ArtSupplier,
							name: Name,
							images: Images,
							video: Videos
						}
					}).done(function(data){
						$('.upload_message').addClass('hidden');
						$('.prodList').prepend(data);
						$('.images_block').find('.image_block_js').remove();
						$('.video_list_js').html('');
						$('#prodName').val('');
					});
				}else{
					$('.image_block_new').addClass('errName');
				}
			}else{
				$('#supplier').addClass('errName');
			}
		});
	});
</script>