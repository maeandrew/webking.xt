<h1><?=$h1?></h1>
<br>
<div id="product_list">
	<ul class="header">
		<li class="name">Название товара</li>
		<li class="fast_view">
			<div>е.и.</div>
			<div>мин.</div>
			<div>кр.</div>
			<div>ящ.</div>
			<div>лим.</div>
			<div>дата</div>
		</li>
		<li class="edit"></li>
	</ul>
	<ul id="sortable">
		<?foreach($list as $k=>$item){?>
			<h3><?=$suppliers[$k]['name'].' - '.$suppliers[$k]['email']?></h3>
			<?foreach($item as $p){
				if($p['moderation_status'] != 2){?>
					<li class="product" id="product-<?=$p['id'];?>">
						<section class="name">
							<span><?=$p['name'];?></span>
						</section>
						<section class="fast_view">
							<div><?=isset($p['units'])? $p['units']:null;?></div>
							<div><?=isset($p['min_mopt_qty'])? $p['min_mopt_qty']:null;?></div>
							<div><?=$p['qty_control'] == 1?'+':'';?></div>
							<div><?=isset($p['inbox_qty'])? $p['inbox_qty']:null;?></div>
							<div><?=isset($p['product_limit'])? $p['product_limit']:null;?></div>
							<div><?=isset($p['creation_date'])? date("d-m-Y", strtotime($p['creation_date'])):null;?></div>
						</section>
						<section class="edit">
							<div class="icon-view animate" title="Просмотреть товар">v</div>
							<?if($p['moderation_status'] == 0){?>
								<div title="Редактировать товар"><a href="/adm/moderation_edit_product/<?=$p['id'];?>" class="icon-edit animate">e</a></div>
							<?}?>
						</section>
						<div class="clear"></div>
						<div id="details" class="details_<?=$p['id'];?>" style="display: none;">
							<input type="hidden" name="id" value="<?=$p['id'];?>">
							<div id="photobox">
								<?if(isset($p['images']) && $p['images'] != ''){
									$images = explode(';', $p['images']);
									foreach($images as $image){?>
										<div class="photo_upload_area">
											<?if(isset($image) && $image != ''){?>
												<a href="<?=$image?>" target="_blank">
													<img class="lazy" data-original="<?=$image?>" alt="">
													<noscript><img src="<?=$image?>" alt=""></noscript>
												</a>
												<?if(file_exists($_SERVER['DOCUMENT_ROOT'].$image)){
													$size = getimagesize($_SERVER['DOCUMENT_ROOT'].$image);
													echo $size[0].'x'.$size[1];
												}
											}?>
										</div>
									<?}
								}else{
									for($i=1; $i < 4; $i++){
										if(!empty($p['img_'.$i])){?>
											<div class="photo_upload_area <?='photo'.$i?>">
												<a href="<?=$p['img_'.$i]?>" target="_blank">
													<img class="lazy" data-original="<?=$p['img_'.$i]?>" alt="">
													<noscript><img src="<?=$p['img_'.$i]?>" alt=""></noscript>
												</a>
												<?if(file_exists($_SERVER['DOCUMENT_ROOT'].$p['img_'.$i])){
													$size = getimagesize($_SERVER['DOCUMENT_ROOT'].$p['img_'.$i]);
													echo $size[0].'x'.$size[1];
												}?>
											</div>
										<?}
									}?>
								<?}?>
							</div>
							<div class="clear">
								<label for="descr" class="descr"><p>Описание:</p></label>
								<textarea name="descr" id="descr" class="bg-white color-sgrey" disabled><?=isset($p['descr'])? $p['descr']:null;?></textarea>
							</div>
							<div class="half clear">
								<label for="price_mopt"><p>Розничная цена:</p></label>
								<input type="text" id="price_mopt" name="price_mopt" class="input-l bg-white color-sgrey" value="<?=isset($p['price_mopt'])? $p['price_mopt']:null;?>" disabled><span>грн</span>
							</div>
							<div class="half clear">
								<label for="weight" class="weight"><p>Вес:</p></label>
								<input type="text" name="weight" id="weight" class="input-l bg-white color-sgrey" value="<?=isset($p['weight'])? $p['weight']:null;?>" disabled><span>кг</span>
							</div>
							<div class="half clear">
								<label for="price_opt"><p>Оптовая цена:</p></label>
								<input type="text" id="price_opt" name="price_opt" class="input-l bg-white color-sgrey" value="<?=isset($p['price_opt'])? $p['price_opt']:null;?>" disabled><span>грн</span>
							</div>
							<div class="half clear">
								<label for="volume" class="volume"><p>Объем:</p></label>
								<input type="text" name="volume" id="volume" class="input-l bg-white color-sgrey" value="<?=isset($p['volume'])? $p['volume']:null;?>" disabled><span>м&#179;</span>
							</div>
							<?if(isset($p['comment']) && $p['comment'] != ''){?>
								<div class="clear">
									<p>Комментарий: </p>
									<p><span class="comment"><?=$p['comment'];?></span></p>
								</div>
							<?}?>
							<div class="clear"></div>
						</div>
						<?if($p['moderation_status'] == 0){?>
							<div class="results">
								<div class="flex">
									<div id="catblock">
										<select class="category input-l" name="categories_ids[]">
											<option value="" selected >Категория не выбрана</option>
											<?foreach($category as $c){
												if($c['id_category'] != 0){?>
													<option value="<?=$c['id_category']?>"><?=str_repeat("&nbsp;&nbsp;", $c['category_level'])?> <?=$c['name']?></option>
												<?}
											}?>
										</select>
										<select class="category input-l" name="categories_ids[]">
											<option value="" selected >Категория не выбрана</option>
											<?foreach($category as $c){
												if($c['id_category'] != 0){?>
												<option value="<?=$c['id_category']?>"><?=str_repeat("&nbsp;&nbsp;", $c['category_level'])?> <?=$c['name']?></option>
												<?}
											}?>
										</select>
										<input type="hidden" class="category" name="categories_ids[]" value="<?=$GLOBALS['CONFIG']['new_catalog_id']?>">
										<input class="btn-m-green" type="submit" id="accept" onclick="AcceptProduct(<?=$p['id']?>);" name="moderationsubmit" value="Принять">
									</div>
									<div id="comentblock">
										<textarea name="moderator_coment" id="moderator_coment" class="input-l" rows="3" placeholder="Причина отклонения..."></textarea>
										<input class="btn-m-red" type="submit" id="decline" onclick="DeclineProduct(<?=$p['id']?>);" name="moderationdecline" value="Отклонить">
									</div>
								</div>
							</div>
						<?}?>
					</li>
				<?}
			}
		}?>
	</ul>
</div>
<script>
var url = "<?=$GLOBALS['URL_base']?>adm/ajaxmoderation/";
function DeclineProduct(id){
	if($('#product-'+id+' #moderator_coment').val().length == 0){
		$('#product-'+id+' #moderator_coment').focus().animate({
			"background-color": "#fcc"
		},200).animate({
			"background-color": "#fff"
		},1500);
	}else{
		$.ajax({
			url: url,
			type: 'post',
			data: {
				action: 'decline',
				id: id,
				comment: $('#product-'+id+' #moderator_coment').val(),
				status: '1'
			}
		}).done(function(){
			$('#product-'+id+' .results').slideUp();
		});
	}
}

function AcceptProduct(id){
	var categories = new Array();
	$('#product-'+id+' .category').each(function(){
		if($(this).val() != ''){
			categories.push($(this).val());
		};
	});
	if(categories.length <= 1){
		alert('Выберите категорию для данного товара!');
	}else{
		$.ajax({
			url: url,
			type: 'post',
			data: {
				action: 'accept',
				id: id,
				category: categories,
				status: '2'
			}
		}).done(function(){
			$('#product-'+id).slideUp();
		});
	}
}

$(function(){
	$(".lazy").lazyload({
		effect : "fadeIn",
		event: "mouseover"
	});
	/* Добавление */
	$('div#product_list').on('click', '.edit .icon-view', function(){
		$("img.lazy").show();
		var id = $(this).closest('.product').prop('id').replace(/\D+/g,"");
		$('.details_'+id).stop(true, true).slideToggle();
	});
});
</script>