	<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<?foreach($suppliers as $s){?>
	<?=$s['name']?><br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
			<colgroup>
				<col width="4%">
				<col width="48%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
				<col width="6%">
			</colgroup>
			<thead>
				<tr>
					<td class="left">Код</td>
					<td class="left">Название</td>
					<td class="left">Цена за ед., грн.</td>
					<td class="left">Кол-во <br>в ящике</td>
					<td class="left">Заказано <br>ед.</td>
					<td class="left">Сумма <br>заказано</td>
					<td class="left">Кол-во <br>по контр-<br>агенту</td>
					<td class="left">Сумма <br>по контр-<br>агенту</td>
					<td class="left">Кол-во <br>факт.</td>
					<td class="left">Сумма <br>факт.</td>
				</tr>
			</thead>
			<tbody>
			<?if(isset($products[$s['id_supplier']])){$tigra=false;foreach($products[$s['id_supplier']] as $i){?>
				<?if($i['opt_qty']!=0){// строка по опту?>
					<tr class="animate <?if($tigra == true){?>tigra<?$tigra = false;}else{$tigra = true;}?>">
						<td><?=$i['article']?></td>
						<td class="name_cell">
							<a href="<?=($i['img_1'])?htmlspecialchars($i['img_1']):"/efiles/image/nofoto.jpg"?>" onclick="return hs.expand(this)" style="float: left;"><img alt="" width="70px" src="<?=($i['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):"/efiles/_thumb/image/nofoto.jpg"?>" title="Нажмите для увеличения"></a>
							<a href="/product/<?=$i['id_product']?>/"><?=$i['name']?></a>
						</td>
						<td><?=round($i['site_price_opt'],2)?></td>
						<td><?=$i['inbox_qty']?> шт.</td>
	
						<td><?=$i['opt_qty']?> шт.</td>
						<td><?=round($i['opt_sum'],2)?></td>
	
						<td><?=$i['contragent_qty']>=0?$i['contragent_qty']:0?></td>
						<td><?=$i['contragent_sum']?></td>
						<td><?=$i['fact_qty']>=0?$i['fact_qty']:0?></td>
						<td><?=$i['fact_sum']?></td>
					</tr>
				<?}if($i['mopt_qty']!=0){// строка по мелкому опту?>
					<tr class="animate <?if($tigra == true){?>tigra<?$tigra = false;}else{$tigra = true;}?>">
						<td><?=$i['article_mopt']?></td>
						<td class="name_cell">
							<a href="<?=($i['img_1'])?htmlspecialchars($i['img_1']):"/efiles/image/nofoto.jpg"?>" onclick="return hs.expand(this)" style="float: left;"><img alt="" width="70px" src="<?=($i['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):"/efiles/_thumb/image/nofoto.jpg"?>" title="Нажмите для увеличения"></a>
							<a href="/product/<?=$i['id_product']?>/"><?=$i['name']?></a>
						</td>
						<td><?=round($i['site_price_mopt'],2)?></td>
						<td><?=$i['inbox_qty']?> шт.</td>
	
						<td><?=$i['mopt_qty']?> шт.</td>
						<td><?=round($i['mopt_sum'],2)?></td>
	
						<td><?=$i['contragent_mqty']>=0?$i['contragent_mqty']:0?></td>
						<td><?=$i['contragent_msum']?></td>
						<td><?=$i['fact_mqty']>=0?$i['fact_mqty']:0?></td>
						<td><?=$i['fact_msum']?></td>
						
					</tr>
				
				<?}?>
			<?}}else{?>
				<tr><td>товаров нет</td></tr>
			<?}?>
			</tbody>
		</table>
<?}?>

		<?if ($i['id_pretense_status']!=0 && count($pretarr)){?>
		<b>Претензия</b>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
		    <col width="1%">
			<thead>
	          <tr>
	            <td class="left">Код</td>
				<td class="left">Название</td>
				<td class="left">Цена за 1 шт. <br>от ящика, грн.</td>
				<td class="left">Кол-во <br>в ящике</td>
				
				<td class="left">Заказано <br>штук</td>
				<td class="left">Сумма <br>заказано</td>
				
				<td class="left">Кол-во <br>по контр-<br>агенту</td>
				<td class="left">Сумма <br>по контр-<br>агенту</td>
				
				<td class="left">Кол-во <br>факт.</td>
				<td class="left">Сумма <br>факт.</td>
	          </tr>
	        </thead>
			<tbody>
		<?foreach ($pretarr as $p){?>
			<tr>
				<td class="code_cell" style="padding: 2px 1px 6px;"><?=$p['article']?></td>
				<td><?=$p['name']?></td>
				<td><?=$p['price']?></td>
				<td colspan="5">&nbsp;</td>
				<td><?=$p['qty']?></td>
				<td><?=round($p['price']*$p['qty'],2)?></td>
			</tr>
		<?}}?>
</table>
<br><br>
	
	<br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_customer/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная покупателя</a>
	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_contragent/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная контрагента</a>
	
	
	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_customer_pret/<?=$order['id_order']?>/<?=$order['skey']?>">Отсутствующие позиции</a>
	<?if ($order['id_pretense_status']!=0){?>
<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_contragent_pret/<?=$order['id_order']?>/<?=$order['skey']?>">Претензия на накладную контрагента</a>
	<?}?>
	
	<?if ($order['id_return_status']!=0){?>
	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_customer_ret/<?=$order['id_order']?>/<?=$order['skey']?>">Возврат по накладной покупателя</a>
	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_contragent_ret/<?=$order['id_order']?>/<?=$order['skey']?>">Возврат по накладной контрагента</a>
	<?}?>