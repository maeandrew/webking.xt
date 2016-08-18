<style>
.errmsg{
	color: #f00;
	font-size: 12px;
}
</style>
<div class="cabinet">
<?if(isset($errm) && isset($msg)){?><br><span class="errmsg">Ошибка! <?=$msg?></span><br><?}?>
<?=isset($errm['products'])?"<span class=\"errmsg\">".$errm['products']."</span>":null?>
<?if(isset($_SESSION['errm'])){
	foreach ($_SESSION['errm'] as $msg){if (!is_array($msg)){?>
		<span class="errmsg"><?=$msg?></span><br>
		<?}}}unset($_SESSION['errm'])?>
	<h3>Заказ №<?=$data[0]['id_order']?>
		<span><?=date("d.m.Y",$data[0]['target_date'])?></span><span><?=$Customer['name']?></span><span>Тел. <?=str_replace("\r\n", ", ", $Customer['phones'])?></span></h3>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="returnForm">
		<script>p_ids = new Array();ii=0;</script>
		<table border="0" cellpadding="0" cellspacing="0" class="returns_table" width="100%">
			<tr>
				<th class="code_cell">Код</th>
				<th class="name_cell">Название</th>
				<th class="price_cell">Цена за 1 шт. <br>от ящика, грн.</th>
				<th class="count_cell">Кол-во <br>в ящике</th>
				<th class="count_cell">Заказано <br>штук</th>
				<th class="count_cell">Сумма <br>заказано</th>
				<th class="price_cell">Кол-во <br>по контр-<br>агенту</th>
				<th class="price_cell">Сумма <br>по контр-<br>агенту</th>
				<th class="price_cell">Кол-во на<br>возвр.</th>
				<th class="price_cell">Сумма <br>возвр.</th>
			</tr>
			<?
			$t['opt_sum'] = 0;
			$t['contragent_qty'] = 0;
			$t['contragent_sum'] = 0;
			$t['return_qty'] = 0;
			$t['return_sum'] = 0;
			$t['mopt_sum'] = 0;
			$t['contragent_mqty'] = 0;
			$t['contragent_msum'] = 0;
			$t['return_mqty'] = 0;
			$t['return_msum'] = 0;
			?>
			<?foreach($data as $i){?>
				<?if($i['opt_qty']!=0){// строка по опту?>
					<tr>
						<td class="code_cell" style="padding: 2px 1px 6px;"><p><?=$i['article']?></p></td>
						<td class="name_cell">
							<a href="<?=_base_url.G::GetImageUrl($i['img_1'])?>" onclick="return hs.expand(this)" class="highslide"><img alt="<?=htmlspecialchars($i['name'])?>" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'thumb')?>" title="Нажмите для увеличения"></a>
							<a href="<?=_base_url?>/product/<?=$i['id_product']?>/"><?=$i['name']?></a>
						</td>
						<td class="price_cell"><p id="pprice_opt_<?=$i['id_product']?>"><?=round($i['site_price_opt'],2)?></p></td>
						<td class="count_cell"><p><?=$i['inbox_qty']?> шт.</p></td>
						<td class="price_cell"><p><?=$i['opt_qty']?> шт.</p></td>
						<td class="price_cell"><p><?=round($i['opt_sum'],2)?></p></td>
						<?$t['opt_sum']+=round($i['opt_sum'],2);?>
						<?$i['contragent_qty'] = ($i['contragent_qty']>=0)?$i['contragent_qty']:$i['opt_qty'];?>
						<td class="count_cell"><p><?=$i['contragent_qty']?></p></td>
						<?$t['contragent_qty']+=$i['contragent_qty'];?>
						<?$i['contragent_sum'] = ($i['contragent_sum']!=0)?$i['contragent_sum']:round($i['site_price_opt']*$i['opt_qty'],2);?>
						<td class="price_cell"><p><?=$i['contragent_sum']?></p></td>
						<?$t['contragent_sum']+=$i['contragent_sum'];?>
						<?$i['return_qty'] = $i['return_qty'];?>
						<td class="count_cell"><div class="unit"><input <?if($i['id_return_status']!=0){?>disabled="disabled"<?}?> name="return_qty[<?=$i['id_product']?>]" id="return_qty_<?=$i['id_product']?>" type="text" value="<?=$i['return_qty']?>" onchange="FactRecalcSum(this,<?=$i['id_product']?>,true)" class="input_table" /></div></td>
						<?$t['return_qty']+=$i['return_qty'];?>
						<?$i['return_sum'] = $i['return_sum'];?>
						<td class="price_cell"><p id="preturn_sum_<?=$i['id_product']?>"><?=$i['return_sum']?></p></td>
						<?$t['return_sum']+=$i['return_sum'];?>
					</tr>
				<?}
				if($i['mopt_qty']!=0){// строка по мелкому опту?>
					<tr>
						<td class="code_cell" style="padding: 2px 1px 6px;"><p><?=$i['article_mopt']?></p></td>
						<td class="name_cell">
							<a href="<?=_base_url.G::GetImageUrl($i['img_1'])?>" onclick="return hs.expand(this)" class="highslide"><img alt="<?=htmlspecialchars($i['name'])?>" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'thumb')?>" title="Нажмите для увеличения"></a>
							<a href="<?=_base_url?>/product/<?=$i['id_product']?>/"><?=$i['name']?></a>
						</td>
						<td class="price_cell"><p id="pprice_mopt_<?=$i['id_product']?>"><?=round($i['site_price_mopt'],2)?></p></td>
						<td class="count_cell"><p><?=$i['inbox_qty']?> шт.</p></td>
						<td class="price_cell"><p><?=$i['mopt_qty']?> шт.</p></td>
						<td class="price_cell"><p><?=round($i['mopt_sum'],2)?></p></td>
						<?$t['mopt_sum']+=round($i['mopt_sum'],2);?>
						<?$i['contragent_mqty'] = ($i['contragent_mqty']>=0)?$i['contragent_mqty']:$i['mopt_qty'];?>
						<td class="count_cell"><p><?=$i['contragent_mqty']?></p></td>
						<?$t['contragent_mqty']+=$i['contragent_mqty'];?>
						<?$i['contragent_msum'] = ($i['contragent_msum']!=0)?$i['contragent_msum']:round($i['site_price_mopt']*$i['mopt_qty'],2);?>
						<td class="price_cell"><p><?=$i['contragent_msum']?></p></td>
						<?$t['contragent_msum']+=$i['contragent_msum'];?>
						<?$i['return_mqty'] = $i['return_mqty'];?>
						<td class="count_cell"><div class="unit"><input <?if($i['id_return_status']!=0){?>disabled="disabled"<?}?> name="return_mqty[<?=$i['id_product']?>]" id="return_mqty_<?=$i['id_product']?>" type="text" value="<?=$i['return_mqty']?>" onchange="FactRecalcSum(this,<?=$i['id_product']?>,false)" class="input_table" /></div></td>
						<?$t['return_mqty']+=$i['return_mqty'];?>
						<?$i['return_msum'] = $i['return_msum'];?>
						<td class="price_cell"><p id="preturn_msum_<?=$i['id_product']?>"><?=$i['return_msum']?></p></td>
						<?$t['return_msum']+=$i['return_msum'];?>
					</tr>
				<?}?>
				<script>p_ids[ii++] = <?=$i['id_product']?>;</script>
			<?}?>
			<tr class="itogo">
				<td colspan="5"><p>Итого:</p></td>
				<td class="count_cell"><p><?=$t['opt_sum']+$t['mopt_sum']?></p></td>
				<td class="price_cell"><p><?=$t['contragent_qty']+$t['contragent_mqty']?></p></td>
				<td class="price_cell"><p><?=$t['contragent_sum']+$t['contragent_msum']?></p></td>
				<td class="price_cell"><p id="preturn_qty"><?=$t['return_qty']+$t['return_mqty']?></p></td>
				<td class="price_cell"><p id="preturn_sum"><?=$t['return_sum']+$t['return_msum']?></p></td>
			</tr>
		</table>
		<input type="hidden" name="smb_return" value="">
	</form>
<script type="text/javascript">
function AddPretenseRow(obj){
	$("#row_tpl").clone(false).insertAfter('#pretense_row').css("display", "").attr("id","row");
}
function FactRecalcSum(obj, id, opt){
	if(opt){
		$("#preturn_sum_"+id).text((obj.value * $("#pprice_opt_"+id).text()).toFixed(2) );
	}else{
		$("#preturn_msum_"+id).text((obj.value * $("#pprice_mopt_"+id).text()).toFixed(2) );
	}
	return_qty = 0;
	for(jj=0;jj<ii;jj++){
		if ($("#return_qty_"+p_ids[jj]).length)
			return_qty += parseFloat($("#return_qty_"+p_ids[jj]).val());
		if ($("#return_mqty_"+p_ids[jj]).length)
			return_qty += parseFloat($("#return_mqty_"+p_ids[jj]).val());
	}
	$("#preturn_qty").text(return_qty);
	return_sum = 0;
	for(jj=0;jj<ii;jj++){
		if($("#return_qty_"+p_ids[jj]).length){
			return_sum += parseFloat($("#preturn_sum_"+p_ids[jj]).text());
		}
		if($("#return_mqty_"+p_ids[jj]).length){
			return_sum += parseFloat($("#preturn_msum_"+p_ids[jj]).text());
		}
	}
	$("#preturn_sum").text(return_sum.toFixed(2));
}
</script>
	<div class="create_buttons">
		<?if ($data[0]['id_return_status']==0){?><a href="<?=_base_url?>/customer_order_return/<?=$i['id_order']?>" class="create_return" onclick="$('#returnForm').submit();return false;"></a><?}?>
	</div><!--class="submit_buttons"-->
</div><!--class="cabinet"-->