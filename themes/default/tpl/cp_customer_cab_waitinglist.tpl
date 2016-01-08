<? require "cp_customer_cab_leftside.tpl";?>
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
								<a href="<?=file_exists($GLOBALS['PATH_root'].$p['img_1'])?_base_url.htmlspecialchars($p['img_1']):'/efiles/_thumb/nofoto.jpg'?>">
									<img alt="<?=G::CropString($p['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].$p['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $p['img_1'])):'/efiles/_thumb/nofoto.jpg'?>" title="Нажмите для увеличения">
								</a>
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
								<a href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/" class="icon-font in_page" title="Перейти на страницу товара">eye</a>
							</td>
							<td>
								<span class="icon-font remove_waitinglist_js" title="Удалить товар из списка">delete</span>
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