<div class="customer_order">
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
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="orderForm">
		<script>p_ids = new Array();ii=0;</script>
		<table border="0" cellpadding="0" cellspacing="0" class="returns_table table" width="100%">
			<thead>
				<tr>
					<th class="image_cell">Фото</th>
					<th class="name_cell">Название</th>
					<th class="price_cell">Цена за ед., грн.</th>
					<th class="count_cell">Заказано, <br>ед.</th>
					<th class="price_cell">Сумма <br>заказано</th>
					<th class="count_cell">Отгружено, <br>ед.</th>
					<th class="price_cell">Сумма <br>отгружено</th>
				</tr>
			</thead>
			<tbody>
				<?
				$t['opt_sum'] = 0;
				$t['contragent_qty'] = 0;
				$t['contragent_sum'] = 0;
				$t['fact_qty'] = 0;
				$t['fact_sum'] = 0;
				$t['mopt_sum'] = 0;
				$t['contragent_mqty'] = 0;
				$t['contragent_msum'] = 0;
				?>
				<?$articles_arr = array();
				foreach($data as $i){?>
					<?if(($i['opt_qty'] != 0 && $show_pretense === false) || ($i['opt_qty'] != 0 && $show_pretense === true && $i['contragent_qty'] != $i['fact_qty'])){ // строка по опту?>
						<?$articles_arr[] = $i['article'];?>
						<tr>
							<td class="image_cell">
								<!-- <?if($i['images'] != ''){?>
									<a href="<?=file_exists($GLOBALS['PATH_root'].str_replace('/original/', '/medium/', $i['image']))?_base_url.htmlspecialchars(str_replace('/original/', '/medium/', $i['image'])):'/images/nofoto.png'?>">
										<img src="<?=file_exists($GLOBALS['PATH_root'].str_replace('/original/', '/medium/', $i['image']))?_base_url.htmlspecialchars(str_replace('/original/', '/medium/', $i['image'])):'/images/nofoto.png'?>" alt="<?=htmlspecialchars($i['name'])?>" title="Нажмите для увеличения">
									</a>
								<?}else{?>
									<a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/images/nofoto.png'?>" onClick="return hs.expand(this)" class="highslide">
										<img alt="<?=htmlspecialchars($i['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace('/efiles/', '/efiles/_thumb/', $i['img_1'])):'/images/nofoto.png'?>" title="Нажмите для увеличения" />
									</a>
								<?}?> -->
								<?if(!empty($item['images'])){?>
									<img alt="<?=htmlspecialchars(G::CropString($i['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('/original/', '/medium/', $i['images'][0]['src']))?str_replace('/original/', '/medium/', $i['images'][0]['src']):'/images/nofoto.png'?>"/>
									<noscript><img alt="<?=htmlspecialchars(G::CropString($i['id_product']))?>" src="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('/original/', '/medium/', $i['images'][0]['src']))?str_replace('/original/', '/medium/', $i['images'][0]['src']):'/images/nofoto.png'?>"/></noscript>
								<?}else{?>
									<img alt="<?=htmlspecialchars(G::CropString($i['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url?><?=$i['img_1']?htmlspecialchars(str_replace('/image/', '/image/500/', $i['img_1'])):'/images/nofoto.png'?>"/>
									<noscript><img alt="<?=htmlspecialchars(G::CropString($i['id_product']))?>" src="<?=_base_url?><?=$i['img_1']?htmlspecialchars(str_replace('/image/', '/image/500/', $i['img_1'])):'/images/nofoto.png'?>"/></noscript>
								<?}?>

							</td>
							<td class="name_cell">
								<a href="<?=Link::Product($i['translit']);?>"><?=$i['name']?></a>
								<div>Арт.<?=$i['art']?></div>
							</td>
							<td class="price_cell">
								<p id="pprice_opt_<?=$i['id_product']?>"><?=number_format($i['site_price_opt'], 2, ",", "")?></p>
							</td>
							<td class="count_cell">
								<p><?=$i['opt_qty']?> шт.</p>
							</td>
							<td class="price_cell">
								<p><?=number_format($i['opt_sum'], 2, ",", "")?></p>
							</td>
							<?$t['opt_sum']+=round($i['opt_sum'],2);?>
							<?$i['contragent_qty'] = ($i['contragent_qty']>=0)?$i['contragent_qty']:$i['opt_qty'];?>
							<td class="count_cell">
								<p><?=$i['contragent_qty']?></p>
							</td>
							<?$t['contragent_qty']+=$i['contragent_qty'];?>
							<?$i['contragent_sum'] = ($i['contragent_sum']!=0 || $i['contragent_qty']>=0)?$i['contragent_sum']:round($i['site_price_opt']*$i['opt_qty'],2);?>
							<td class="price_cell">
								<p><?=$i['contragent_sum'] == 0?'-':$i['contragent_sum'];?></p>
							</td>
							<?$t['contragent_sum']+=$i['contragent_sum'];?>
						</tr>
					<?}
					if(($i['mopt_qty'] != 0 && $show_pretense === false) || ($i['mopt_qty'] != 0 && $show_pretense === true && $i['contragent_mqty'] != $i['fact_mqty'])){ // строка по мелкому опту?>
					<?$articles_arr[] = $i['article_mopt'];?>
						<tr>
							<td class="image_cell">
								<!-- <?if($i['image'] != ''){?>
									<a href="<?=file_exists($GLOBALS['PATH_root'].str_replace('/original/', '/medium/', $i['image']))?_base_url.htmlspecialchars(str_replace('/original/', '/medium/', $i['image'])):'/images/nofoto.png'?>">
										<img src="<?=file_exists($GLOBALS['PATH_root'].str_replace('/original/', '/medium/', $i['image']))?_base_url.htmlspecialchars(str_replace('/original/', '/medium/', $i['image'])):'/images/nofoto.png'?>" alt="<?=htmlspecialchars($i['name'])?>" title="Нажмите для увеличения">
									</a>
								<?}else{?>
									<a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/images/nofoto.png'?>" onClick="return hs.expand(this)" class="highslide">
										<img alt="<?=htmlspecialchars($i['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace('/efiles/', '/efiles/_thumb/', $i['img_1'])):'/images/nofoto.png'?>" title="Нажмите для увеличения" />
									</a>
								<?}?> -->
								<?if(!empty($item['images'])){?>
									<img alt="<?=htmlspecialchars(G::CropString($i['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('/original/', '/medium/', $i['images'][0]['src']))?str_replace('/original/', '/medium/', $i['images'][0]['src']):'/images/nofoto.png'?>"/>
									<noscript><img alt="<?=htmlspecialchars(G::CropString($i['id_product']))?>" src="<?=_base_url?><?=file_exists($GLOBALS['PATH_root'].str_replace('/original/', '/medium/', $i['images'][0]['src']))?str_replace('/original/', '/medium/', $i['images'][0]['src']):'/images/nofoto.png'?>"/></noscript>
								<?}else{?>
									<img alt="<?=htmlspecialchars(G::CropString($i['id_product']))?>" class="lazy" src="/images/nofoto.png" data-original="<?=_base_url?><?=$i['img_1']?htmlspecialchars(str_replace('/image/', '/image/500/', $i['img_1'])):'/images/nofoto.png'?>"/>
									<noscript><img alt="<?=htmlspecialchars(G::CropString($i['id_product']))?>" src="<?=_base_url?><?=$i['img_1']?htmlspecialchars(str_replace('/image/', '/image/500/', $i['img_1'])):'/images/nofoto.png'?>"/></noscript>
								<?}?>
							</td>
							<td class="name_cell">
								<a href="<?=Link::Product($i['translit']);?>"><?=$i['name']?></a>
								<div>Арт.<?=$i['art']?></div>
							</td>
							<td class="price_cell">
								<p id="pprice_mopt_<?=$i['id_product']?>"><?=number_format($i['site_price_mopt'], 2, ',', '')?></p>
							</td>
							<td class="price_cell">
								<p><?=$i['mopt_qty']?> шт.</p>
							</td>
							<td class="price_cell">
								<p><?=number_format($i['mopt_sum'], 2, ',', '')?></p>
							</td>
							<?$t['mopt_sum'] += round($i['mopt_sum'], 2);?>
							<?$i['contragent_mqty'] = ($i['contragent_mqty'] >= 0)?$i['contragent_mqty']:$i['mopt_qty'];?>
							<td class="count_cell">
								<p><?=$i['contragent_mqty']?></p>
							</td>
							<?$t['contragent_mqty'] += $i['contragent_mqty'];?>
							<?$i['contragent_msum'] = ($i['contragent_msum'] != 0 || $i['contragent_mqty'] >= 0)?$i['contragent_msum']:round($i['site_price_mopt']*$i['mopt_qty'], 2);?>
							<td class="price_cell">
								<p><?=$i['contragent_msum'] == 0? '-':$i['contragent_msum'];?></p>
							</td>
							<?$t['contragent_msum'] += $i['contragent_msum'];?>
						</tr>
					<?}?>
					<script>p_ids[ii++] = <?=$i['id_product']?>;</script>
				<?}?>
				<tr class="itogo">
					<td colspan="3" class="spacer"></td>
					<td ><p>Итого:</p></td>
					<td class="count_cell"><p><?=$i['sum_discount']?></p></td>
					<td class="price_cell"><p><?=$t['contragent_qty']+$t['contragent_mqty']?></p></td>
					<td class="price_cell"><p><?=$t['contragent_sum']+$t['contragent_msum'] == 0?'-':$t['contragent_sum']+$t['contragent_msum'];?></p></td>
				</tr>
				<?if($i['id_pretense_status'] == 0){
					$articles_arr = array_unique($articles_arr);?>
					<?if($data[0]['id_order_status'] == 2 && $data[0]['id_pretense_status'] == 0){
						if($active_pretense_btn){?>
							<tr id="pretense_row">
								<td class="code_cell">
									<select name="pretense_article[]">
										<?foreach ($articles_arr as $art){?>
											<option value="<?=$art?>"><?=$art?></option>
										<?}?>
									</select>
								</td>
								<td class="name_cell">
									<div class="unit4">
										<input type="text" value="" name="pretense_name[]" class="input_table"/>
									</div>
								</td>
								<td class="price_cell">
										<div class="unit2">
										<input type="text" name="pretense_price[]" value="" class="input_table"/>
									</div>
								</td>
								<td colspan="5" class="count_cell">
									<a href="#" onClick="AddPretenseRow(this);return false;">Добавить позицию</a>
								</td>
								<td class="count_cell">
									<div class="unit">
										<input type="text" name="pretense_qty[]" value="" class="input_table"/>
									</div>
								</td>
								<td class="price_cell"><p></p></td>
							</tr>
						<?}
					}
				}else{
					if(!empty($pretarr)){
						foreach($pretarr as $p){?>
							<tr>
								<td class="code_cell">
									<div class="unit">
										<input type="text" disabled="disabled" value="<?=$p['article']?>" class="input_table"/>
									</div>
								</td>
								<td class="name_cell">
									<div class="unit4">
										<input type="text" disabled="disabled" value="<?=$p['name']?>" class="input_table"/>
									</div>
								</td>
								<td class="price_cell">
									<div class="unit2">
										<input type="text" disabled="disabled" value="<?=$p['price']?>" class="input_table"/>
									</div>
								</td>
								<td colspan="5" class="count_cell">&nbsp;</td>
								<td class="count_cell">
									<div class="unit">
										<input type="text" disabled="disabled" value="<?=$p['qty']?>" class="input_table"/>
									</div>
								</td>
								<td class="price_cell"><p></p></td>
							</tr>
						<?}
					}
				}?>
			</tbody>
		</table>
	</form>
	<table class="pretense">
		<tr id="row_tpl">
			<td class="code_cell">
				<select name="pretense_article[]">
					<?foreach($articles_arr as $art){?>
						<option value="<?=$art?>"><?=$art?></option>
					<?}?>
				</select>
			</td>
			<td class="name_cell">
				<div class="unit4">
					<input type="text" value="" name="pretense_name[]" class="input_table"/>
				</div>
			</td>
			<td class="price_cell">
				<div class="unit2">
					<input type="text" name="pretense_price[]" value="" class="input_table"/>
				</div>
			</td>
			<td colspan="5" class="count_cell">&nbsp;</td>
			<td class="count_cell">
				<div class="unit">
					<input type="text" name="pretense_qty[]" value="" class="input_table"/>
				</div>
			</td>
			<td class="price_cell"><p></p></td>
		</tr>
		</table>
		<?if($gid == _ACL_CONTRAGENT_){?>
			<div class="customerOrderFooter">
				<div class="customer">
					<span>Покупатель</span>
					<span>Имя: <?=$order['cont_person']?></span>
					<span>тел.: <?=$order['phones']?></span>
				</div>
				<div class="price-order">
					<p>Cформировать прайс-лист:</p>
						<form action="/pricelist-order/<?=$order['id_order']?>/" method="get" target="_blank">
							<input type="text" name="margin" placeholder="Наценка"/>
							<button class="price-order-photo mdl-button mdl-js-button mdl-button--raised" name="photo" value="0">без фото</button>
							<button class="price-order-photo mdl-button mdl-js-button mdl-button--raised" name="photo" value="1">с фото</button>
						</form>
				</div>
				<div class="buttons_order">
					<div class="current_id_order" data-value="<?=$order['id_order']?>"></div>

					<button class="mdl-button mdl-js-button mdl-button--raised btn_js" data-name="cloneOrder">Сформировать заказ на основании данного</button>

					<?if($i['id_order_status'] == 1){?>
						<button class="mdl-button mdl-js-button mdl-button--raised btn_js cnslOrderBtn" data-name="confirmCnclOrder">Отменить заказ</button>
					<?}?>

					<form action="<?=_base_url?>/cart/<?=$i['id_order']?>" method="post" class="fleft">
						<!-- <button type="submit" class="remake_order btn-m-green open_modal mdl-button mdl-js-button" data-target="order_remake_js">Сформировать заказ на основании данного</button> -->
					</form>

					<!-- <?if($i['id_order_status'] == 1){?>
						<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
							<button type="submit" name="smb_cancel" class="cancel_order mdl-button mdl-js-button mdl-button--raised">Отменить заказ</button>
						</form>
					<?}?> -->

					<!-- ORDER REMAKE MODAL FORM -->
					<!-- <div id="order_remake_js" class="modal_hidden">
					<form action="<?=_base_url?>/cart/" method="post"  class="order_remake">
						<p><b>Добавить</b> товары из данного заказа к товарам из текущей корзины или <b>заменить</b> содержимое корзины содержимым данного заказа?</p>
						<input type="hidden" name="id_city" value="<?=$order['id_city']?>"/>
						<input type="hidden" name="id_delivery" value="<?=$order['id_delivery']?>"/>
						<input type="hidden" name="cont_person" value="<?=$order['cont_person']?>"/>
						<input type="hidden" name="phones" value="<?=$order['phones']?>"/>
						<input type="hidden" name="bonus_card" value="<?=$order['bonus_card']?>"/>
						<button type="submit" name="add_order" class="btn-m-green fleft mdl-button mdl-js-button">Добавить к корзине</button>
						<button type="submit" name="remake_order" class="btn-m-green fright mdl-button mdl-js-button">Заменить корзину</button>
					</form>
					</div> -->
				</div>

			</div>
		<?}?>
</div><!--class="cabinet"-->
<script type="text/javascript">
	/*Создать новый заказ на основе текущего*/
	$(function(){
		var id_order = $('.current_id_order').data('value');
		/*Отмена заказа*/
		$('#cnclOrderBtnMod').on('click', function(e){
			ajax('order', 'CancelOrder', {id_order: id_order}).done(function(data){
				if(data === true){
					closeObject('confirmCnclOrder');
					$('.cnslOrderBtn').addClass('hidden');
				}
			});
		});
		$('#replaceCartMod').on('click', function(e){
			ajax('cart', 'duplicate', {id_order: id_order}).done(function(data){
				ajax('cart', 'GetCart').done(function(data){ // получить массив корзины и изменить отображение кол-ва товаров на иконке корзины
					$('header .cart_item a.cart i').attr('data-badge', countOfObject(data.products));
				});
			});
		});
		$('#addtoCartMod').on('click', function(e){
			ajax('cart', 'duplicate', {id_order: id_order, add: 1}).done(function(data){
				ajax('cart', 'GetCart').done(function(data){ // получить массив корзины и изменить отображение кол-ва товаров на иконке корзины
					$('header .cart_item a.cart i').attr('data-badge', countOfObject(data.products));
				});
			});
		});
	});
	function AddPretenseRow(obj){
		$('#row_tpl').clone(false).insertAfter('#pretense_row').css('display', '').attr('id', 'row');
	}
	function FactRecalcSum(obj, id, opt){
		if(opt){
			$('#pfact_sum_'+id).text((obj.value * $('#pprice_opt_'+id).text()).toFixed(2) );
		}else{
			$('#pfact_msum_'+id).text((obj.value * $('#pprice_mopt_'+id).text()).toFixed(2) );
		}
		fact_qty = 0;
		for(jj = 0; jj < ii; jj++){
			if($('#fact_qty_'+p_ids[jj]).length)
				fact_qty += parseFloat($('#fact_qty_'+p_ids[jj]).val());
			if($('#fact_mqty_'+p_ids[jj]).length)
				fact_qty += parseFloat($('#fact_mqty_'+p_ids[jj]).val());
		}
		$('#pfact_qty').text(fact_qty);
		fact_sum = 0;
		for(jj = 0; jj < ii; jj++){
			if($('#fact_qty_'+p_ids[jj]).length){
				fact_sum += parseFloat($('#pfact_sum_'+p_ids[jj]).text());
			}
			if($('#fact_mqty_'+p_ids[jj]).length){
				fact_sum += parseFloat($('#pfact_msum_'+p_ids[jj]).text());
			}
		}
		$('#pfact_sum').text(fact_sum.toFixed(2));
	}
</script>
