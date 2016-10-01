<div class="prices_table_title">
	<h4>Система скидок товара</h4>
</div>
<table class="prices_table">
	<tr>
		<th colspan="3">Покупка от <?=$product['inbox_qty']?> <?=$product['units']?></th>
	</tr>
	<tr>
		<th class="title_column">Сумма заказа</th>
		<th>Цена, грн</th>
		<th>Скидка, %</th>
	</tr>
	<tr>
		<td class="title_column">Партнер <span class="hidden">(более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?> грн.)</span></td>
		<td><?=number_format($product['prices_opt'][0], 2, ",", "")?></td>
		<td><?=(100-round($product['prices_opt'][0]/$product['prices_mopt'][3], 2)*100)?></td>
		<!-- <td><?=(100-$corrections['opt'][0]*100)?></td> -->
	</tr>
	<tr>
		<td class="title_column">Диллер <span class="hidden">(от <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> до <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?> грн.)</span></td>
		<td><?=number_format($product['prices_opt'][1], 2, ",", "")?></td>
		<td><?=(100-round($product['prices_opt'][1]/$product['prices_mopt'][3], 2)*100)?></td>
		<!-- <td><?=(100-$corrections['opt'][1]*100)?></td> -->
	</tr>
	<tr>
		<td class="title_column">Опт <span class="hidden">(от <?=$GLOBALS['CONFIG']['retail_order_margin']?> до <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> грн.)</span></td>
		<td><?=number_format($product['prices_opt'][2], 2, ",", "")?></td>
		<td><?=(100-round($product['prices_opt'][2]/$product['prices_mopt'][3], 2)*100)?></td>
		<!-- <td><?=(100-$corrections['opt'][2]*100)?></td> -->
	</tr>
	<tr>
		<td class="title_column">Розница <span class="hidden">(до <?=$GLOBALS['CONFIG']['retail_order_margin']?> грн.)</span></td>
		<td><?=number_format($product['prices_opt'][3], 2, ",", "")?></td>
		<td><?=(100-round($product['prices_opt'][3]/$product['prices_mopt'][3], 2)*100)?></td>
		<!-- <td><?=(100-$corrections['opt'][3]*100)?></td> -->
	</tr>
</table>
<table class="prices_table">
	<tr>
		<th colspan="3">Покупка от <?=$product['min_mopt_qty']?> <?=$product['units']?></th>
	</tr>
	<tr>
		<th class="title_column">Сумма заказа</th>
		<th>Цена, грн</th>
		<th>Скидка, %</th>
	</tr>
	<tr>
		<td class="title_column">Партнер <span class="hidden">(более <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?> грн.)</span></td>
		<td><?=number_format($product['prices_mopt'][0], 2, ",", "")?></td>
		<td><?=(100-round($product['prices_mopt'][0]/$product['prices_mopt'][3], 2)*100)?></td>
		<!-- <td><?=(100-$corrections['mopt'][0]*100)?></td> -->
	</tr>
	<tr>
		<td class="title_column">Диллер <span class="hidden">(от <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> до <?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?> грн.)</span></td>
		<td><?=number_format($product['prices_mopt'][1], 2, ",", "")?></td>
		<td><?=(100-round($product['prices_mopt'][1]/$product['prices_mopt'][3], 2)*100)?></td>
		<!-- <td><?=(100-$corrections['mopt'][1]*100)?></td> -->
	</tr>
	<tr>
		<td class="title_column">Опт <span class="hidden">(от <?=$GLOBALS['CONFIG']['retail_order_margin']?> до <?=$GLOBALS['CONFIG']['wholesale_order_margin']?> грн.)</span></td>
		<td><?=number_format($product['prices_mopt'][2], 2, ",", "")?></td>
		<td><?=(100-round($product['prices_mopt'][2]/$product['prices_mopt'][3], 2)*100)?></td>
		<!-- <td><?=(100-$corrections['mopt'][2]*100)?></td> -->
	</tr>
	<tr>
		<td class="title_column">Розница (базовая) <span class="hidden">(до <?=$GLOBALS['CONFIG']['retail_order_margin']?> грн.)</span></td>
		<td><?=number_format($product['prices_mopt'][3], 2, ",", "")?></td>
		<td>0</td>
	</tr>
</table>
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