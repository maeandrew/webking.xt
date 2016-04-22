<div class="customer_cab">
	<div id="favorites">
		<?if(isset($favorites) &&  !empty($favorites)){?>
			<div id="second">
				<table width="100%" cellspacing="0" border="0" class="table_thead table">
					<colgroup>
						<col width="80%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th>Название</th>
							<th>Наличие</th>
							<th></th>
						</tr>
					</thead>
				</table>
				<table width="100%" cellspacing="0" border="0" class="table_tbody table">
					<colgroup>
						<col width="10%">
						<col width="70%">
						<col width="10%">
						<col width="5%">
						<col width="5%">
					</colgroup>
					<tbody>
					<?foreach($favorites as $p){?>
						<tr class="favorite_js" data-idproduct="<?=$p['id_product']?>">
							<td class="image_cell">
								<div class="btn_js" data-name="big_photo">
									<?if(!empty($p['img_1'])){?>
										<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url?><?=str_replace("/efiles/", "/efiles/_thumb/", $p['img_1'])?>" data-original-photo="<?=_base_url?><?=$p['img_1']?>" title="Нажмите для увеличения">
									<?}else if(!empty($p['images'])){?>
										<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url?>/<?=str_replace('original', 'thumb', $p['images'][0]['src'])?>" data-original-photo="<?=_base_url?><?=$p['images'][0]['src']?>" title="Нажмите для увеличения">
									<?}else{?>
										<img alt="<?=G::CropString($p['name'])?>" src="<?=_base_url?>/images/nofoto.jpg" data-original-photo="<?=_base_url?>/images/nofoto.jpg">
									<?}?>
								</div>
							</td>
							<td class="name_cell">
								<a href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/"><?=G::CropString($p['name'])?></a>
								<p class="product_article"><!--noindex-->арт. <!--/noindex--><?=$p['art']?></p>
							</td>
							<td>
								<p><?=$p['availability']?></p>
							</td>
							<td>
								<a id="toSee_<?=$p['id_product']?>" href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/" class="material-icons in_page">remove_red_eye</a>
								<div class="mdl-tooltip" for="toSee_<?=$p['id_product']?>">Перейти на<br>страницу товара</div>
							</td>
							<td>
								<span id="remove_<?=$p['id_product']?>" class="icon material-icons remove_favor_js">delete</span>
								<div class="mdl-tooltip" for="remove_<?=$p['id_product']?>">Удалить товар<br>из списка</div>
							</td>
						</tr>
					<?}?>
					</tbody>
				</table>
			</div>
		<?}else{?>
			<h5>У Вас нет избранных товаров</h5>
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