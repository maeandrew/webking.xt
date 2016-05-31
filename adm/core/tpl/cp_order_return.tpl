	<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<?foreach($suppliers as $s){?>
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
				
				<td class="left">Кол-во на<br>возвр.</td>
				<td class="left">Сумма <br>возвр.</td>
	          </tr>
	        </thead>
			<tbody>
				
			<?if(isset($products[$s['id_supplier']])){$tigra=false;foreach($products[$s['id_supplier']] as $i){?>
				<?if($i['opt_qty']!=0 && $i['return_qty']!=0){// строка по опту?>
					<tr<?if ($tigra==true){?> style="background-color:#f3f3f3;"<?$tigra=false;}else{$tigra=true;}?>>
						<td><?=$i['article']?></td>
						<td class="name_cell">
	                             <a href="<?=($i['img_1'])?htmlspecialchars($i['img_1']):"/images/nofoto.png"?>" onclick="return hs.expand(this)" class="highslide"><img alt="" src="<?=($i['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):"/images/nofoto.png"?>" title="Нажмите для увеличения"></a>
	                             <a href="<?=$GLOBALS['URL_base']?>product/<?=$i['id_product']?>/"><?=$i['name']?></a>
	                         </td>
						<td><?=round($i['site_price_opt'],2)?></td>
						<td><?=$i['inbox_qty']?> шт.</td>
	
						<td><?=$i['opt_qty']?> шт.</td>
						<td><?=round($i['opt_sum'],2)?></td>
	
						<td><?=$i['contragent_qty']?></td>
						<td><?=$i['contragent_sum']?></td>
						
                        <td><?=$i['return_qty']?></td>
                        <td><?=$i['return_sum']?></td>
                        
					</tr>
				<?} if($i['mopt_qty']!=0 && $i['return_mqty']!=0){// строка по мелкому опту?>
				
					<tr<?if ($tigra==true){?> style="background-color:#f3f3f3;"<?$tigra=false;}else{$tigra=true;}?>>
						<td><?=$i['article_mopt']?></td>
						<td class="name_cell">
	                             <a href="<?=($i['img_1'])?htmlspecialchars($i['img_1']):"/images/nofoto.png"?>" onclick="return hs.expand(this)" class="highslide"><img alt="" src="<?=($i['img_1'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):"/images/nofoto.png"?>" title="Нажмите для увеличения"></a>
	                             <a href="<?=$GLOBALS['URL_base']?>product/<?=$i['id_product']?>/"><?=$i['name']?></a>
	                         </td>
						<td><?=round($i['site_price_mopt'],2)?></td>
						<td><?=$i['inbox_qty']?> шт.</td>
	
						<td><?=$i['mopt_qty']?> шт.</td>
						<td><?=round($i['mopt_sum'],2)?></td>
	
						<td><?=$i['contragent_mqty']?></td>
						<td><?=$i['contragent_msum']?></td>
						<td><?=$i['return_mqty']?></td>
                        <td><?=$i['return_msum']?></td>
					</tr>
				
				<?}?>
			<?}}else{?>
				<tr><td>товаров нет</td></tr>
			<?}?>
			</tbody>
		</table>	
	
<?}?>