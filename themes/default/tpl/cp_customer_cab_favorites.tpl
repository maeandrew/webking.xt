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
								<a href="<?=file_exists($GLOBALS['PATH_root'].$p['img_1'])?_base_url.htmlspecialchars($p['img_1']):'/efiles/_thumb/nofoto.jpg'?>">
									<img alt="<?=G::CropString($p['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].$p['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $p['img_1'])):'/efiles/_thumb/nofoto.jpg'?>" title="Нажмите для увеличения">
								</a>
							</td>
							<td class="name_cell">
								<a href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/"><?=G::CropString($p['name'])?></a>
								<p class="product_article"><!--noindex-->арт. <!--/noindex--><?=$p['art']?></p>
							</td>
							<td>
								<p><?=$p['availability']?></p>
							</td>
							<td>
								<a href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/" class="icon-font in_page" title="Перейти на страницу товара">eye</a>
							</td>
							<td>
								<span class="icon-font remove_favor_js" title="Удалить товар из списка">delete</span>
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