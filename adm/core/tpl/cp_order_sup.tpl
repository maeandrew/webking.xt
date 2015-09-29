<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

	<?=$s['name']?><br>


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

			<?if(isset($products[$s['id_supplier']])){$tigra=false;foreach($products[$s['id_supplier']] as $i){?>
				<?if($i['opt_qty']!=0 && $i['id_supplier']==$s['id_supplier']){// строка по опту?>
					<tr<?if ($tigra==true){?> style="background-color:#f3f3f3;"<?$tigra=false;}else{$tigra=true;}?>>
						<td><?=$i['article']?></td>
						<td class="name_cell">
	                             <a href="<?=($i['img_1'])?htmlspecialchars($i['img_1']):"/efiles/image/nofoto.jpg"?>" onclick="return hs.expand(this)" class="highslide"><img alt="" src="<?=($i['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):"/efiles/_thumb/image/nofoto.jpg"?>" title="Нажмите для увеличения"></a>
	                             <a href="<?=$GLOBALS['URL_base']?>product/<?=$i['id_product']?>/"><?=$i['name']?></a>
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
				<?} if($i['mopt_qty']!=0 && $i['id_supplier_mopt']==$s['id_supplier']){// строка по мелкому опту?>

					<tr<?if ($tigra==true){?> style="background-color:#f3f3f3;"<?$tigra=false;}else{$tigra=true;}?>>
						<td><?=$i['article_mopt']?></td>
						<td class="name_cell">
	                             <a href="<?=($i['img_1'])?htmlspecialchars($i['img_1']):"/efiles/image/nofoto.jpg"?>" onclick="return hs.expand(this)" class="highslide"><img alt="" src="<?=($i['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):"/efiles/_thumb/image/nofoto.jpg"?>" title="Нажмите для увеличения"></a>
	                             <a href="<?=$GLOBALS['URL_base']?>product/<?=$i['id_product']?>/"><?=$i['name']?></a>
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

	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_supplier/<?=$order['id_order']?>/<?=$id_supplier?>/<?=$order['skey']?>">Накладная поставщика</a>
	<br><br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_customer/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная покупателя</a>
	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_contragent/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная контрагента</a>

	<?if ($order['id_pretense_status']!=0){?>
	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_customer_pret/<?=$order['id_order']?>/<?=$order['skey']?>">Претензия на накладную покупателя</a>
	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_contragent_pret/<?=$order['id_order']?>/<?=$order['skey']?>">Претензия на накладную контрагента</a>
	<?}?>

	<?if ($order['id_return_status']!=0){?>
	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_customer_ret/<?=$order['id_order']?>/<?=$order['skey']?>">Возврат по накладной покупателя</a>
	<br><br>
	<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_contragent_ret/<?=$order['id_order']?>/<?=$order['skey']?>">Возврат по накладной контрагента</a>
	<?}?>