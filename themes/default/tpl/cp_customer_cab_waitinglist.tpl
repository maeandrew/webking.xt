<div class="customer_cab">
	<div id="waiting_list">
		<?if(isset($waiting_list) &&  !empty($waiting_list)){?>
			<div id="second">
				<table width="100%" cellspacing="0" border="0" class="table_thead table">
					<colgroup>
						<col width="60%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th>Название</th>
							<th>Старая<br>цена</th>
							<th>Актуальная<br>цена</th>
							<th>Наличие</th>
							<th></th>
						</tr>
					</thead>
				</table>
				<table width="100%" cellspacing="0" border="0" class="table_tbody table">
					<colgroup>
						<col width="10%">
						<col width="50%">
						<col width="10%">
						<col width="10%">
						<col width="10%">
						<col width="5%">
						<col width="5%">
					</colgroup>
					<tbody>
					<?foreach($waiting_list as $p){?>
						<tr class="waiting_list_js" data-idproduct="<?=$p['id_product']?>">
							<td class="image_cell">
								<div class="btn_js" data-name="big_photo">
									<?if(!empty($p['img_1'])){?>
										<img class="toBigPhoto" id="big_photo_<?=$p['id_product']?>" alt="<?=G::CropString($p['name'])?>" src="<?=_base_url?><?=str_replace("/efiles/", "/efiles/_thumb/", $p['img_1'])?>" data-original-photo="<?=_base_url?><?=$p['img_1']?>">
									<?}else if(!empty($p['images'])){?>
										<img class="toBigPhoto" id="big_photo_<?=$p['id_product']?>" alt="<?=G::CropString($p['name'])?>" src="<?=_base_url?><?=str_replace('original', 'thumb', $p['images'][0]['src'])?>" data-original-photo="<?=_base_url?><?=$p['images'][0]['src']?>">
									<?}else{?>
										<img class="toBigPhoto" id="big_photo_<?=$p['id_product']?>" alt="<?=G::CropString($p['name'])?>" src="/images/nofoto.png" data-original-photo="/images/nofoto.png">
									<?}?>
									<div class="mdl-tooltip" for="big_photo_<?=$p['id_product']?>">Нажмите<br>для увеличения</div>
								</div>
							</td>
							<td class="name_cell">
								<a href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/"><?=G::CropString($p['name'])?></a>
								<p class="product_article"><!--noindex-->арт. <!--/noindex--><?=$p['art']?></p>
							</td>
							<td class="old_price">
								<?if($p['price_opt'] > 0){?>
									<p><?=$p['old_price_opt']?><!--noindex--> грн. <!--/noindex--></p>
								<?}else{?>
									<span><!--noindex--> ---- <!--/noindex--></span>
								<?}?>
							</td>
							<td class="active_price">
								<?if($p['price_opt'] > 0){?>
									<p><?=$p['price_opt']?><!--noindex--> грн. <!--/noindex--></p>
								<?}else{?>
									<span><b><!--noindex--> ---- <!--/noindex--></b></span>
								<?}?>
							</td>
							<td>
								<p><?=$p['availability']?></p>
							</td>
							<td>
								<a id="toSee_<?=$p['id_product']?>" href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/" class="material-icons in_page">remove_red_eye</a>
								<div class="mdl-tooltip" for="toSee_<?=$p['id_product']?>">Перейти на<br>страницу товара</div>
							</td>
							<td>
								<span id="remove_<?=$p['id_product']?>" class="icon material-icons remove_waitinglist_js">delete</span>
								<div class="mdl-tooltip" for="remove_<?=$p['id_product']?>">Удалить товар<br>из списка</div>
							</td>
						</tr>
					<?}?>
					</tbody>
				</table>
			</div>
		<?}else{?>
			<h5>Лист ожидания пуст</h5>
		<?}?>
	</div>
</div>
<script>
	//Фиксация Заголовка таблицы
	$(window).scroll(function(){
		if($(this).scrollTop() >= 160){
			if(!$('.table_thead').hasClass('fixed_thead')){
				var width = $('.table_tbody').width();
				$('.table_thead').css("width", width).addClass('fixed_thead');
				$('#second').css("margin-top", "69px");
			}
		}else{
			if($('.table_thead').hasClass('fixed_thead')){
				$('.table_thead').removeClass('fixed_thead');
				$('#second').css("margin-top", "0");
			}
		}
	});
</script>