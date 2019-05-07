<div class="prices_table_title">
	<h4>Система скидок товара</h4>
</div>
<?$percents = explode(';', $GLOBALS['CONFIG']['agent_bonus_percent']);?>
<?if ($GLOBALS['CONFIG']['retail_order_margin']<$product['prices_mopt'][3]) {
		$percents[3]=$percents[2];
	}
	if ($GLOBALS['CONFIG']['wholesale_order_margin']<$product['prices_mopt'][3]) {
		$percents[3]=$percents[2]=$percents[1];
	}
	if ($GLOBALS['CONFIG']['full_wholesale_order_margin']<$product['prices_mopt'][3]) {
		$percents[3]=$percents[2]=$percents[1]=$percents[0];
	}
?>
<?$base_price = $product['prices_mopt'][3] > 0?$product['prices_mopt'][3]:$product['prices_opt'][3];
$base_price = $product['price_mopt'];
if($product['prices_opt'][3] > 0){?>
	<table class="prices_table">
		<tr>
			<th colspan="4">Покупка от <?=$product['inbox_qty']?> <?=$product['units']?></th>
		</tr>
		<tr>
			<th class="title_column">Общая сумма заказа</th>
			<th>Цена, грн</th>
			<th>Скидка, грн</th>
			<th>Бонус, грн</th>
		</tr>
		<tr>
			<td class="title_column">Партнер (от <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?> грн.)</td>
			<td><?=number_format($product['prices_opt'][0], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt'][3]-$product['prices_opt'][0], 2, ",", "")?></td>
			<td><?=number_format($product['prices_opt_margin'][0]*$percents[0], 2, ",", "")?></td>
			<!-- <td><?=(100-round($product['prices_opt'][0]/$base_price, 2)*100)?></td> -->
			<!-- <td><?=(100-$corrections['opt'][0]*100)?></td> -->
		</tr>
		<tr>
			<td class="title_column">Диллер (от <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> грн.)</td>
			<td><?=number_format($product['prices_opt'][1], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt'][3]-$product['prices_opt'][1], 2, ",", "")?></td>
			<td><?=number_format($product['prices_opt_margin'][1]*$percents[1], 2, ",", "")?></td>
			<!-- <td><?=(100-round($product['prices_opt'][1]/$base_price, 2)*100)?></td> -->
			<!-- <td><?=(100-$corrections['opt'][1]*100)?></td> -->
		</tr>
		<tr>
			<td class="title_column">Опт (от <?=$GLOBALS['CONFIG']['retail_order_margin']?> грн.)</td>
			<td><?=number_format($product['prices_opt'][2], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt'][3]-$product['prices_opt'][2], 2, ",", "")?></td>
			<td><?=number_format($product['prices_opt_margin'][2]*$percents[2], 2, ",", "")?></td>
			<!-- <td><?=(100-round($product['prices_opt'][2]/$base_price, 2)*100)?></td> -->
			<!-- <td><?=(100-$corrections['opt'][2]*100)?></td> -->
		</tr>
		<tr>
			<td class="title_column">Розница (до <?=$GLOBALS['CONFIG']['retail_order_margin']?> грн.)</td>
			<td><?=number_format($product['prices_opt'][3], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt'][3]-$product['prices_opt'][3], 2, ",", "")?></td>
			<td><?=number_format($product['prices_opt_margin'][3]*$percents[3], 2, ",", "")?></td>
			<!-- <td><?=(100-round($product['prices_opt'][3]/$base_price, 2)*100)?></td> -->
			<!-- <td><?=(100-$corrections['opt'][3]*100)?></td> -->
		</tr>
	</table>
<?}?>
<?if($product['prices_mopt'][3] > 0){?>
	<table class="prices_table">
		<tr>
			<th colspan="4">Покупка от <?=$product['min_mopt_qty']?> <?=$product['units']?></th>
		</tr>
		<tr>
			<th class="title_column">Общая сумма заказа</th>
			<th>Цена, грн</th>
			<th>Скидка, грн</th>
			<th>Бонус, грн</th>
		</tr>
		<tr>
			<td class="title_column">Партнер (от 10000грн) <span class="hidden">(от <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?> грн.) грн.)</td>
			<td><?=number_format($product['prices_mopt'][0], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt'][3]-$product['prices_mopt'][0], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt_margin'][0]*$percents[0], 2, ",", "")?></td>
			<!-- <td><?=(100-round($product['prices_mopt'][0]/$base_price, 2)*100)?></td> -->
			<!-- <td><?=(100-$corrections['mopt'][0]*100)?></td> -->
		</tr>
		<tr>
			<td class="title_column">Диллер (от <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> грн.)</td>
			<td><?=number_format($product['prices_mopt'][1], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt'][3]-$product['prices_mopt'][1], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt_margin'][1]*$percents[1], 2, ",", "")?></td>
			<!-- <td><?=(100-round($product['prices_mopt'][1]/$base_price, 2)*100)?></td> -->
			<!-- <td><?=(100-$corrections['mopt'][1]*100)?></td> -->
		</tr>
		<tr>
			<td class="title_column">Опт (от <?=$GLOBALS['CONFIG']['retail_order_margin']?> грн.)</td>
			<td><?=number_format($product['prices_mopt'][2], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt'][3]-$product['prices_mopt'][2], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt_margin'][2]*$percents[2], 2, ",", "")?></td>
			<!-- <td><?=(100-round($product['prices_mopt'][2]/$base_price, 2)*100)?></td> -->
			<!-- <td><?=(100-$corrections['mopt'][2]*100)?></td> -->
		</tr>
		<tr>
			<td class="title_column">Розница (до <?=$GLOBALS['CONFIG']['retail_order_margin']?> грн.)</td>
			<td><?=number_format($product['prices_mopt'][3], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt'][3]-$product['prices_mopt'][3], 2, ",", "")?></td>
			<td><?=number_format($product['prices_mopt_margin'][3]*$percents[3], 2, ",", "")?></td>
			<!-- <td><?=(100-round($product['prices_mopt'][3]/$base_price, 2)*100)?></td> -->
		</tr>
	</table>
<?}?>
<b>Средняя розничная цена по Украине - <?=number_format($product['prices_mopt'][3], 2, ",", "")?>грн.</b>
<!-- <b>Средняя розничная цена по Украине - <?=number_format($base_price, 2, ",", "")?>грн.</b> -->
<table class="bonus_table hidden">
	<tr>
		<th colspan="3">Бонусная программа</th>
	</tr>
	<tr>
		<td>Активируйте бонусную программу и получите 20 грн. на покупки в нашем магазине.</td>
	</tr>
	<tr>
		<td>При каждой покупке на Ваш бонусный счет будет накапливаться:</td>
	</tr>
	<tr>
		<td>1% от суммы заказа - постоянно</td>
	</tr>
	<tr>
		<td>2% от суммы заказа при втором заказе в течении 30 дней от последней покупки</td>
	</tr>
	<tr>
		<td>3% от суммы заказа доступна при третьем и более заказах в течении 30 дней от последней покупки</td>
	</tr>
</table>