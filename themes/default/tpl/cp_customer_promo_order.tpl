<style>
.errmsg{
	color: #f00;
	font-size: 12px;
}
</style>
<div class="cabinet customer_order">
	<a href="<?=$_SERVER['HTTP_REFERER'];?>" style="line-height: 20px;">Назад</a>
	<div class="clear"></div>
	<form action="<?=$GLOBALS['URL_request']?>" method="post" id="orderForm">
		<script>p_ids = new Array();ii=0;</script>
		<table border="0" cellpadding="0" cellspacing="0" class="returns_table" width="100%">
			<thead>
				<tr>
					<th class="image_cell">Фото</th>
					<th class="name_cell">Название</th>
					<th class="price_cell">Цена за ед., грн.</th>
					<th class="count_cell">Заказано, <br>ед.</th>
					<th class="price_cell">Сумма <br>заказано</th>
				</tr>
			</thead>
			<tbody>
				<?
				$t['opt_sum']=0;
				$t['contragent_qty']=0;
				$t['contragent_sum']=0;
				$t['fact_qty']=0;
				$t['fact_sum']=0;
				$t['mopt_sum']=0;
				$t['contragent_mqty']=0;
				$t['contragent_msum']=0;
				?>
				<?$articles_arr = array();
				foreach($data as $i){?>
					<?if(($i['opt_qty']!=0 && $show_pretense===false) || ($i['opt_qty']!=0 && $show_pretense===true && $i['contragent_qty']!=$i['fact_qty'])){// строка по опту?>
						<?$articles_arr[] = $i['article'];?>
						<tr>
							<td class="image_cell">
								<a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/images/nofoto.png'?>" onClick="return hs.expand(this)" class="highslide"><img alt="<?=$i['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/images/nofoto.png'?>" title="Нажмите для увеличения" /></a>
							</td>
							<td class="name_cell"><?=$i['name']?></td>
							<td class="price_cell">
								<p id="pprice_opt_<?=$i['id_product']?>"><?=number_format($i['site_price_opt'], 2, ",", "")?></p>
							</td>
							<td class="count_cell"><?=$i['opt_qty']?> <?=$i['units']?></td>
							<td class="price_cell"><?=number_format($i['opt_sum'], 2, ",", "")?></td>
							<?$t['opt_sum']+=round($i['opt_sum'],2);?>
							<?$i['contragent_qty'] = ($i['contragent_qty']>=0)?$i['contragent_qty']:$i['opt_qty'];?>
						</tr>
					<?}
					if(($i['mopt_qty']!=0 && $show_pretense===false) || ($i['mopt_qty']!=0 && $show_pretense===true && $i['contragent_mqty']!=$i['fact_mqty'])){// строка по мелкому опту?>
					<?$articles_arr[] = $i['article_mopt'];?>
						<tr>
							<td class="image_cell">
								<a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/images/nofoto.png'?>" onClick="return hs.expand(this)" class="highslide"><img alt="<?=$i['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/images/nofoto.png'?>" title="Нажмите для увеличения" /></a>
							</td>
							<td class="name_cell">
								<?if(!isset($_SESSION['member']['promo_code']) || $_SESSION['member']['promo_code'] == ''){?>
									<a href="<?=_base_url?>/product/<?=$i['id_product']?>/"><?=$i['name']?></a>
									<div style="padding: 0px">Арт.<?=$i['art']?></div>
								<?}else{?>
									<?=$i['name']?>
								<?}?>
							</td>
							<td class="price_cell">
								<p id="pprice_mopt_<?=$i['id_product']?>"><?=number_format($i['site_price_mopt'], 2, ",", "")?></p>
							</td>
							<td class="price_cell"><?=$i['mopt_qty']?> <?=$i['units']?></td>
							<td class="price_cell"><?=number_format($i['mopt_sum'], 2, ",", "")?></td>
							<?$t['mopt_sum']+=round($i['mopt_sum'],2);?>
							<?$i['contragent_mqty'] = ($i['contragent_mqty']>=0)?$i['contragent_mqty']:$i['mopt_qty'];?>
						</tr>
					<?}?>
					<script>p_ids[ii++] = <?=$i['id_product']?>;</script>
				<?}?>
				<tr class="itogo">
					<td colspan="3" class="spacer"></td>
					<td>Итого:</td>
					<td class="count_cell"><?=number_format($i['sum_discount'], 2, ",", "");?></td>
				</tr>
			</tbody>
		</table>
	</form>
	<table style="display: none">
		<tr id="row_tpl" style="display: none">
			<td class="code_cell">
				<select name="pretense_article[]" style="width: 60px;">
					<?foreach ($articles_arr as $art){?>
					<option value="<?=$art?>"><?=$art?></option>
					<?}?>
				</select>
			</td>
			<td class="name_cell">
				<div class="unit4">
					<input type="text" value="" name="pretense_name[]" class="input_table" />
				</div>
			</td>
			<td class="price_cell">
				<div class="unit2">
					<input type="text" name="pretense_price[]" value="" class="input_table" />
				</div>
			</td>
			<td colspan="5" class="count_cell">&nbsp;</td>
			<td class="count_cell">
				<div class="unit">
					<input type="text" name="pretense_qty[]" value="" class="input_table" />
				</div>
			</td>
			<td class="price_cell"><p></p></td>
		</tr>
		</table>
		<?if($gid == _ACL_CONTRAGENT_){?>
			<div class="customer">Покупатель: <?=$order['cont_person']?>, тел. <?=$order['phones']?></div>
			<div class="price-order">
			<p>Чтобы сформировать прайс-лист на основании данного заказа, нажмите одну из этих кнопок:</p>
				<a class="price-order-photo" href="<?=_base_url?>/pricelist-order/<?=$order['id_order']?>/?photo=0">без фото</a>
				<a class="price-order-photo" href="<?=_base_url?>/pricelist-order/<?=$order['id_order']?>/?photo=1">с фото</a>
			</div>
			<div class="buttons_order">
			<?if($i['id_order_status']==1){?>
				<form action="<?=$GLOBALS['URL_request']?>" method="post">
					<input type="submit" name="smb_cancel" class="cancel_order cancel" value="Отменить заказ">
				</form>
			<?}?>
			<form action="<?=_base_url?>/cart/<?=$order['id_order']?>" method="post">
				<input type="submit" class="create_zakaz confirm" value="Сформировать заказ на основании данного">
			</form>
			</div>
		<?}?>
<script type="text/javascript">
function AddPretenseRow(obj){
	$("#row_tpl").clone(false).insertAfter('#pretense_row').css("display", "").attr("id","row");
}
function FactRecalcSum(obj, id, opt){
	if(opt){
		$("#pfact_sum_"+id).text((obj.value * $("#pprice_opt_"+id).text()).toFixed(2) );
	}else{
		$("#pfact_msum_"+id).text((obj.value * $("#pprice_mopt_"+id).text()).toFixed(2) );
	}
	fact_qty = 0;
	for(jj=0;jj<ii;jj++){
		if($("#fact_qty_"+p_ids[jj]).length)
			fact_qty += parseFloat($("#fact_qty_"+p_ids[jj]).val());
		if($("#fact_mqty_"+p_ids[jj]).length)
			fact_qty += parseFloat($("#fact_mqty_"+p_ids[jj]).val());
	}
	$("#pfact_qty").text(fact_qty);
	fact_sum = 0;
	for(jj=0;jj<ii;jj++){
		if($("#fact_qty_"+p_ids[jj]).length){
			fact_sum += parseFloat($("#pfact_sum_"+p_ids[jj]).text());
		}
		if($("#fact_mqty_"+p_ids[jj]).length){
			fact_sum += parseFloat($("#pfact_msum_"+p_ids[jj]).text());
		}
	}
	$("#pfact_sum").text(fact_sum.toFixed(2));
}
</script>
</div><!--class="cabinet"-->