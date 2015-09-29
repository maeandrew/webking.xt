<h1><?=$h1?></h1>
<br>
<div id="slides_list">
	<ul class="header">
		<li class="id">№</li>
		<li class="image">Изображение</li>
		<li class="title">Название слайда</li>
		<li class="cont">Контент</li>
		<li class="slider">Слайдер</li>
		<li class="visibility">Видимость</li>
		<li class="execute">Действия</li>
	</ul>
	<ul id="sortable">
		<?if(!empty($list)){
			foreach($list as $item){?>
				<li class="slide" id="slide-<?=$item['id'];?>">
					<section class="id icon-dragplace">m</section>
					<section class="image">
						<span><img src="/images/slides/<?=$item['image'] == null?'-':$item['image'];?>" alt=""></span>
						<!-- <span><img src="/images/slides/<?=$item['image'] == null?'-':$item['image'];?>" alt=""></span> -->
						<input type="file" id="img_upload_<?=$item['id'];?>" name="img" class="input-s hidden"/>
						<input type="hidden" name="image" value="<?=$item['image'];?>"/>
					</section>
					<section class="title">
						<span><?=$item['title'];?></span>
						<input type="hidden" name="title" value="<?=$item['title'];?>" class="input-s"/>
					</section>
					<section class="cont">
						<span><?=$item['content'] == null?'-':$item['content'];?></span>
						<input type="hidden" name="content" value="<?=$item['content'];?>" class="input-s"/>
					</section>
					<section class="slider">
						<span><?=$item['slider'] == null?'-':$item['slider'];?></span>
						<input type="hidden" name="slider" value="<?=$item['slider'];?>" class="input-s"/>
					</section>
					<section class="visibility">
						<?if($item['visibility'] == 1){?>
							<span>
								<img src="../images/eye.svg"alt="Видимый"/>
							</span>
							<input type="hidden" name="visibility" checked="true" />
						<?}else{?>
							<span>
								<img src="../images/eye-blocked.svg" alt="Скрытый"/>
							</span>
							<input type="hidden" name="visibility"/>
						<?}?>
					</section>
					<section class="execute" class="input-s">
						<div class="icon-delete" title="Удалить">t</div>
						<div class="icon-edit" title="Редактировать">e</div>
					</section>
					<section class="edit hidden input-s">
						<div class="icon-cancel" title="Отменить">n</div>
						<div class="icon-save" title="Сохранить">y</div>
					</section>
					<div class="clear"></div>
				</li>
			<?}
		}?>
	</ul>
	<div class="slide" id="newslide">
		<section class="id">
			-
		</section>
		<section class="image">
			<input type="file" id="img_upload_new" name="img" class="input-s"/>
			<input type="hidden" name="image" class="input-s"/>
		</section>
		<section class="title">
			<input type="text" name="title" class="input-s">
		</section>
		<section class="cont">
			<input type="text" name="content" class="input-s">
		</section>
		<section class="slider">
			<input type="text" name="slider" class="input-s">
		</section>
		<section class="visibility">
			<input type="checkbox" name="visibility" class="input-s"/>
		</section>
		<section class="create">
			<div class="icon-cancel" title="Отменить">n</div>
			<div class="icon-save" title="Сохранить">y</div>
		</section>
		<div class="clear"></div>
	</div>
	<div class="controls">
		<section class="addonemore">+</section>
	</div>
</div>
<script src="../../blueimp/js/vendor/jquery.ui.widget.js"></script>
<script src="../../blueimp/js/load-image.all.min.js"></script>
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="../../blueimp/js/jquery.iframe-transport.js"></script>
<script src="../../blueimp/js/jquery.fileupload.js"></script>
<script src="../../blueimp/js/jquery.fileupload-process.js"></script>
<script src="../../blueimp/js/jquery.fileupload-image.js"></script>
<script>
	$(function(){
		'use strict';
		// Define the url to send the image data to
		var url = '/adm/slides/?upload=true';
		$('[id^="img_upload"]').fileupload({
			url: url,
			dataType: 'json',
			done: function(e, data){
				// Add each uploaded file name to the #files list
				$.each(data.result.img, function (index, file){
					// $('#'+data.fileInput.context.id).val(file.name);
					$('#'+data.fileInput.context.id).addClass('hidden');
					$('#'+data.fileInput.context.id).closest('.slide').find('[name="image"]').val(file.name).attr('type', 'text');
					// if(file.error == null){
					// 	photoDone(id, file);
					// }else{
					// 	$('.photo'+id).append('<span class="error">'+file.error+'</span>');
					// 	$('.photo'+id+' #photo_preview').html('');
					// 	$('#photo'+id).show();
					// }
					// validatePhoto();
				});
			}
		});
		$('#sortable').sortable({
			cursor: 'move',
			axis: 'y',
			update: function(event, ui){
				var data = $(this).sortable('toArray');
				$.ajax({
					type: 'POST',
					url: URL_base+'ajaxslides',
					data: {
						data: data,
						action: 'sort'
					}
				});
			}
		});
		$('#sortable').disableSelection();

		/* Добавление */
		$('div#slides_list').on('click', '.addonemore', function(){
			$(this).slideUp('fast');
			// $('#newslide .image').append("<input type=\"file\" id=\"img_upload\" name=\"img\" class=\"input-s\"/>");
			$('#newslide').slideDown();
		}).on('click', '.create .icon-cancel', function(){
			$('#newslide input').val('');
			$('#newslide select').val(0);
			$('#newslide').slideUp('fast');
			$('.addonemore').slideDown();
		}).on('click', '.execute .icon-delete', function(){
			var parent = $(this).closest('.slide').attr('id');
			var id = parseInt(parent.replace(/\D+/g,""));
			if(confirm('Удалить слайд "'+$('#'+parent+' .title').text().trim()+'"?') == true){
				$.ajax({
					type: 'POST',
					url: URL_base+'ajaxslides',
					cache: false,
					dataType : "json",
					data: {
						id: id,
						action: 'delete'
					}
				});
				$('#slide-'+id).slideUp();
			}
		}).on('click', '.create .icon-save', function(){
			var parent = $(this).closest('.slide').attr('id');
			var image = $('#'+parent+' input[name="image"]').val();
			var title = $('#'+parent+' input[name="title"]').val();
			var content = $('#'+parent+' input[name="content"]').val();
			var slider = $('#'+parent+' input[name="slider"]').val();
			var visi = $('#'+parent+' input[name="visibility"]').prop('checked');
			var visitext = '<span><img src="../images/eye.svg"alt="Видимый"/></span><input type="hidden" name="visibility" checked="true" class="input-s">';
			var visibility = 1;
			var buttons = '<div class="icon-delete" title="Удалить">t</div><div class="icon-edit" title="Редактировать">e</div>';
			if(visi == false){
				visitext = '<span><img src="../images/eye-blocked.svg" alt="Скрытый"/></span><input type="hidden" name="visibility" class="input-s">';
				visibility = 0
			}
			if(image != '' && title != ''){
				$.ajax({
					type: 'POST',
					url: URL_base+'ajaxslides',
					cache: false,
					dataType : "json",
					data: {
						action: 'add',
						image: image,
						title: title,
						content: content,
						slider: slider,
						visibility: visibility
					}
				}).done(function(id){
					$('#sortable').append('<li class="slide" id="slide-'+id+'"><section class="id icon-dragplace">m</section><section class="image"><span><img src="/images/slides/'+image+'" alt=""></span><input type="hidden" name="image" value="'+image+'"/></section><section class="title"><span>'+title+'</span><input type="hidden" name="title" value="'+title+'"/></section><section class="cont"><span>'+content+'</span><input type="hidden" name="content" value="'+content+'"/></section><section class="slider"><span>'+slider+'</span><input type="hidden" name="slider" value="'+slider+'"/></section><section class="visibility">'+visitext+'</section><section class="execute">'+buttons+'</section><section class="edit hidden"><div class="icon-cancel" title="Отменить">n</div><div class="icon-save" title="Сохранить">y</div></section><div class="clear"></div></li>');
					$('#slide-'+id+' span').removeClass('hidden');
					$('#slide-'+id+' .execute').removeClass('hidden');
					$('#slide-'+id+' .edit').addClass('hidden');
					$('#newslide input').val('');
					$('#newslide select').val(0);
					$('#newslide').hide('fast');
					$('#newslide .image input[type="file"').addClass('hidden');
					$('.addonemore').slideDown();
				});
				location.reload();
			}
		}).on('click', '.execute .icon-edit', function(){
			var parent = $(this).closest('.slide').attr('id');
			$('#'+parent+' span').addClass('hidden');
			$('#'+parent+' .execute, #'+parent+' .edit').toggleClass('hidden');
			$('#'+parent+' .title input, #'+parent+' .cont input, #'+parent+' .slider input').prop('type', 'text');
			$('#'+parent+' input[name="img"]').removeClass('hidden');
			$('#'+parent+' .visibility input').prop('type', 'checkbox');
			var image = $('#'+parent+' input[name="image"]').val();
			var title = $('#'+parent+' input[name="title"]').val();
			var content = $('#'+parent+' input[name="content"]').val();
			var slider = $('#'+parent+' input[name="slider"]').val();
			var visi = $('#'+parent+' input[name="visibility"]').prop('checked');
			var visitext = '<img src="../images/eye.svg"alt="Видимый"/>';
			var visibility = 1;
		}).on('click', '.edit .icon-cancel', function(){
			var parent = $(this).closest('.slide').attr('id');
			$('#'+parent+' span').removeClass('hidden');
			$('#'+parent+' .execute, #'+parent+' .edit').toggleClass('hidden');
			$('#'+parent+' .title input, #'+parent+' .cont input, #'+parent+' .slider input').prop('type', 'hidden');
			$('#'+parent+' input[name="img"]').addClass('hidden');
			$('#'+parent+' .visibility input').prop('type', 'hidden');
		}).on('click', '.edit .icon-save', function(){
			var parent = $(this).closest('.slide').attr('id');
			var id = parseInt(parent.replace(/\D+/g,""));
			var image = $('#'+parent+' input[name="image"]').val();
			var title = $('#'+parent+' input[name="title"]').val();
			var content = $('#'+parent+' input[name="content"]').val();
			var slider = $('#'+parent+' input[name="slider"]').val();
			var visi = $('#'+parent+' input[name="visibility"]').prop('checked');
			var visitext = '<span><img src="../images/eye.svg"alt="Видимый"/></span><input type="hidden" name="visibility" checked="true" class="input-s">';
			var visibility = 1;
			var buttons = '<div class="icon-delete" title="Удалить">t</div><div class="icon-edit" title="Редактировать">e</div>';
			if(visi == false){
				visitext = '<span><img src="../images/eye-blocked.svg" alt="Скрытый"/></span><input type="hidden" name="visibility" class="input-s">';
				visibility = 0
			}
			if(image != '' && title != ''){
				$.ajax({
					type: 'POST',
					url: URL_base+'ajaxslides',
					cache: false,
					dataType : "json",
					data: {
						action: 'update',
						id: id,
						image: image,
						title: title,
						content: content,
						slider: slider,
						visibility: visibility
					}
				});
				$('#slide-'+id).html('<section class="id icon-dragplace">m</section><section class="image"><span><img src="/images/slides/'+image+'" alt=""></span><input type="file" id="img_upload_'+id+'" name="img" class="input-s hidden"/><input type="hidden" name="image" value="'+image+'" class="input-s"/></section><section class="title"><span>'+title+'</span><input type="hidden" name="title" value="'+title+'" class="input-s"/></section><section class="cont"><span>'+content+'</span><input type="hidden" name="content" value="'+content+'" class="input-s"/></section><section class="slider"><span>'+slider+'</span><input type="hidden" name="slider" value="'+slider+'" class="input-s"/></section><section class="visibility">'+visitext+'</section><section class="execute">'+buttons+'</section><section class="edit hidden"><div class="icon-cancel" title="Отменить">n</div><div class="icon-save" title="Сохранить">y</div></section><div class="clear"></div>');
				$('#'+parent+' span').removeClass('hidden');
				$('#'+parent+' .execute').removeClass('hidden');
				$('#'+parent+' .edit').addClass('hidden');
				$('#'+parent+' .title input, #'+parent+' .cont input, #'+parent+' .slider input').prop('type', 'hidden');
				$('#'+parent+' .visibility input').prop('type', 'hidden');
				location.reload();
			}
		});
	});
</script>