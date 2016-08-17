<div class="customer_cab">
	<h1>Лист ожидания</h1>
	<div id="waiting_list">
		<?if(isset($waiting_list) &&  !empty($waiting_list)){?>
			<div id="second">
				<div class="table_tbody table">
					<div class="tableRow tableRowHeader">
						<div class="image_cell"></div>
						<div class="name_cell">Название</div>
						<div class="old_price">Старая цена</div>
						<div class="active_price">Актуальная цена</div>
						<div class="availability">Наличие</div>
						<div class="goToPageItem"></div>
						<div class="removeItem"></div>
					</div>
					<?foreach($waiting_list as $p){?>
						<div class="waiting_list_js tableRow" data-idproduct="<?=$p['id_product']?>">
							<div class="image_cell">
								<div class="btn_js" data-name="big_photo">
									<?if(!empty($p['img_1'])){?>
										<img class="toBigPhoto" id="big_photo_<?=$p['id_product']?>" alt="<?=G::CropString($p['name'])?>" src="<?=_base_url?><?=G::GetImageUrl($p['img_1'], 'thumb')?>" data-original-photo="<?=_base_url?><?=$p['img_1']?>">
									<?}else if(!empty($p['images'])){?>
										<img class="toBigPhoto" id="big_photo_<?=$p['id_product']?>" alt="<?=G::CropString($p['name'])?>" src="<?=_base_url?><?=G::GetImageUrl($p['images'][0]['src'], 'thumb')?>" data-original-photo="<?=_base_url?><?=$p['images'][0]['src']?>">
									<?}else{?>
										<img class="toBigPhoto" id="big_photo_<?=$p['id_product']?>" alt="<?=G::CropString($p['name'])?>" src="/images/nofoto.png" data-original-photo="/images/nofoto.png">
									<?}?>
									<div class="mdl-tooltip" for="big_photo_<?=$p['id_product']?>">Нажмите<br>для увеличения</div>
								</div>
							</div>
							<div class="name_cell">
								<a href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/"><?=G::CropString($p['name'])?></a>
								<p class="product_article"><!--noindex-->арт. <!--/noindex--><?=$p['art']?></p>
							</div>
							<div class="old_price subTableRow">
								<div class="titleForTablet">Старая цена: </div>
								<?if($p['price_opt'] > 0){?>
									<p><?=$p['old_price_opt']?><!--noindex--> грн. <!--/noindex--></p>
								<?}else{?>
									<span><!--noindex--> ---- <!--/noindex--></span>
								<?}?>
							</div>
							<div class="active_price subTableRow">
								<div class="titleForTablet">Актуальная цена: </div>
								<?if($p['price_opt'] > 0){?>
									<p><?=$p['price_opt']?><!--noindex--> грн. <!--/noindex--></p>
								<?}else{?>
									<span><b><!--noindex--> ---- <!--/noindex--></b></span>
								<?}?>
							</div>
							<div class="availability subTableRow">
								<div class="titleForTablet">Наличие: </div>
								<p><?=$p['availability']?></p>
							</div>
							<div class="goToPageItem">
								<a id="toSee_<?=$p['id_product']?>" href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/" class="material-icons in_page">remove_red_eye</a>
								<div class="mdl-tooltip" for="toSee_<?=$p['id_product']?>">Перейти на<br>страницу товара</div>
							</div>
							<div class="removeItem">
								<span id="remove_<?=$p['id_product']?>" class="icon material-icons remove_waitinglist_js btn_js" data-name="confirmDelItem">delete</span>
								<div class="mdl-tooltip" for="remove_<?=$p['id_product']?>">Удалить товар<br>из списка</div>
							</div>
						</div>
					<?}?>
				</div>
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