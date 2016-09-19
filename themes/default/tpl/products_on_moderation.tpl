<?if (isset($errm) && isset($msg)){?><div class="msg-error"><p><?=$msg?></p></div>><?}?>
<?=isset($errm['products'])?"<div class=\"msg-error\"><p>".$errm['products']."</p></div>":null;?>
<?if(isset($_SESSION['errm'])){
	foreach($_SESSION['errm'] as $msg){
		if(!is_array($msg)){?>
		<div class="msg-error"><p><?=$msg?></p></div>
		<?}
	}
}
unset($_SESSION['errm'])?>
<div id="supplier_cab" class="supplier_cab">
	<h1>Товары на модерации</h1>
	<div id="second">
		<!-- <table width="100%" cellspacing="0" border="1" class="supplier_assort_table table">
			<colgroup>
				<col width="20%">
				<col width="50%">
				<col width="20%">
				<col width="10%">
			</colgroup>
			<thead>
				<tr>
					<th class="image">Фото</th>
					<th class="name">Название</th>
					<th class="status">Статус</th>
					<th class="controls">Действия</th>
				</tr>
			</thead>
		</table> -->

		<div class="moder_list_title">
			<div class="photo">Фото</div>
			<div class="name">Название</div>
			<div class="status">Статус</div>
			<div class="controls">Действия</div>
		</div>
		<?if(isset($list) && !empty($list)){
				foreach($list as $i){?>
					<div id="tr_mopt_<?=$i['id']?>" class="moder_list_item">
						<div class="photo">
							<?if($i['images'] != ''){
								$images = explode(';', $i['images']);?>
								<a href="<?=file_exists($GLOBALS['PATH_root'].$images[0])?_base_url.htmlspecialchars($images[0]):'/images/nofoto.png'?>">
									<img alt="" height="90" src="<?=G::GetImageUrl($images[0])?>">
								</a>
							<?}else{?>
								<a href="<?=G::GetImageUrl($i['img_1'])?>">
									<img alt="" height="90" src="<?=G::GetImageUrl($i['img_1'], 'thumb')?>">
								</a>
							<?}?>
						</div>
						<div class="name">
							<p><?=G::CropString($i['name'])?></p>
							<?if($i['moderation_status'] == 1){?>
								<div class="msg-error">
									<p><b>Отклонено!</b> <?=$i['comment'];?></p>
								</div>
							<?}?>
						</div>
						<div class="status">
							<p class="status_title">Статус:</p>
							<p><?=$i['status_name'];?></p>
						</div>
						<div class="controls">
							<a class="edit" title="Изменить" href="<?=_base_url?>/cabinet/editproduct/?id=<?=$i['id']?>&type=moderation"><i class="material-icons">mode_edit</i></a>
							<a title="Удалить" onclick="DeleteProductFromModeration(<?=$i['id'];?>); return false;" href="#"><i class="material-icons">delete</i></a>
						</div>
					</div>
				<?}
			}?>


		<!-- <table width="100%" cellspacing="0" border="0" class="moderation table">
			<colgroup>
				<col width="20%">
				<col width="50%">
				<col width="20%">
				<col width="10%">
			</colgroup>
			<tbody>
			<?if(isset($list) && !empty($list)){
				foreach($list as $i){?>
					<tr id="tr_mopt_<?=$i['id']?>">
						<td class="photo_cell">
							<?if($i['images'] != ''){
								$images = explode(';', $i['images']);?>
								<a href="<?=file_exists($GLOBALS['PATH_root'].$images[0])?_base_url.htmlspecialchars($images[0]):'/images/nofoto.png'?>">
									<img alt="" height="90" src="<?=_base_url.G::GetImageUrl($images[0])?>">
								</a>
							<?}else{?>
								<a href="<?=_base_url.G::GetImageUrl($i['img_1'])?>">
									<img alt="" height="90" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'thumb')?>">
								</a>
							<?}?>
						</td>
						<td class="name_cell">
							<?=G::CropString($i['name'])?>
							<?if($i['moderation_status'] == 1){?>
								<div class="msg-error">
									<p><b>Отклонено!</b> <?=$i['comment'];?></p>
								</div>
							<?}?>
						</td>
						<td class="status">
							<?=$i['status_name'];?>
						</td>
						<td class="controls">
							<a class="edit" title="Изменить" href="<?=_base_url?>/cabinet/editproduct/?id=<?=$i['id']?>&type=moderation"><i class="material-icons">mode_edit</i></a>
							<a title="Удалить" onclick="DeleteProductFromModeration(<?=$i['id'];?>); return false;" href="#"><i class="material-icons">delete</i></a>
						</td>
					</tr>
				<?}
			}?>
			</tbody>
		</table> -->
	</div>
</div>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
<script>
	function DeleteProductFromModeration(id){
		var confirmDelete = confirm("Вы действительно хотите удалить товар?");
		if (confirmDelete === true) {
			ajax('cabinet', 'deleteFromModeration', {'id': id}).done(function(){
			$('#tr_mopt_'+id).fadeOut();
			});
		}
	}
	// $(window).scroll(function(){
	// 	if($(this).scrollTop() > 154){
	// 		if(!$('.supplier_assort_table').hasClass('fixed_thead')){
	// 			var width = $('.moderation').width();
	// 			$('.supplier_assort_table').css("width", width).addClass('fixed_thead');
	// 			$('#second').css("margin-top", "26px");
	// 		}
	// 	}else{
	// 		if($('.supplier_assort_table').hasClass('fixed_thead')){
	// 			$('.supplier_assort_table').removeClass('fixed_thead');
	// 			$('#second').css("margin-top", "0");
	// 		}
	// 	}
	// });
</script>
