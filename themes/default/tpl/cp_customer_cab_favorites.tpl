<div class="customer_cab">
	<h1>Избранное</h1>
	<div id="favorites">
		<?if(isset($favorites) &&  !empty($favorites)){?>
			<div id="second">
				<div class="table_tbody table">
					<div class="tableRow tableRowHeader">
						<div class="image_cell"></div>
						<div class="name_cell">Название</div>
						<div class="availability">Наличие</div>
						<div class="goToPageItem"></div>
						<div class="removeItem"></div>
					</div>					
					<?foreach($favorites as $p){?>
						<div class="favorite_js tableRow" data-idproduct="<?=$p['id_product']?>">
							<div class="image_cell">
								<div class="btn_js" data-name="big_photo">
									<?if(!empty($p['img_1'])){?>
										<img class="toBigPhoto" alt="<?=G::CropString($p['name'])?>" src="<?=_base_url?><?=str_replace("/efiles/", "/efiles/_thumb/", $p['img_1'])?>" data-original-photo="<?=_base_url?><?=$p['img_1']?>" title="Нажмите для увеличения">
									<?}else if(!empty($p['images'])){?>
										<img class="toBigPhoto" alt="<?=G::CropString($p['name'])?>" src="<?=_base_url?><?=str_replace('original', 'thumb', $p['images'][0]['src'])?>" data-original-photo="<?=_base_url?><?=$p['images'][0]['src']?>" title="Нажмите для увеличения">
									<?}else{?>
										<img class="toBigPhoto" alt="<?=G::CropString($p['name'])?>" src="/images/nofoto.png" data-original-photo="/images/nofoto.png">
									<?}?>
								</div>
							</div>
							<div class="name_cell">
								<a href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/"><?=G::CropString($p['name'])?></a>
								<p class="product_article"><!--noindex-->арт. <!--/noindex--><?=$p['art']?></p>
							</div>
							<div class="availability changedOrder">
								<div class="titleForTablet">Наличие: </div>
								<p><?=$p['availability']?></p>
							</div>
							<div class="goToPageItem changedOrder">
								<a id="toSee_<?=$p['id_product']?>" href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/" class="material-icons in_page">remove_red_eye</a>
								<div class="mdl-tooltip" for="toSee_<?=$p['id_product']?>">Перейти на<br>страницу товара</div>
							</div>
							<div class="removeItem changedOrder">
								<span id="remove_<?=$p['id_product']?>" class="icon material-icons remove_favor_js btn_js" data-name="confirmDelItem">delete</span>
								<div class="mdl-tooltip" for="remove_<?=$p['id_product']?>">Удалить товар<br>из списка</div>
							</div>
						</div>
					<?}?>
					</tbody>
				</div>
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
				// $('#second').css("margin-top", "69px");
			}
		}else{
			if($('.table_thead').hasClass('fixed_thead')){
				$('.table_thead').removeClass('fixed_thead');
				// $('#second').css("margin-top", "0");
			}
		}
	});
</script>