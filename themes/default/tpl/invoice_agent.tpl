<div class="page">
	<div class="header">
<!-- 		<img src="http://xt/themes/default/img/_xt.svg" alt="" class="logo">
		<div class="company-name">Служба снабжения ХарьковТорг</div> -->
		  <style type="text/css">
   TABLE {
    width: 100%; /* Ширина таблицы */
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
   }
   TD, TH {
    padding: 10px; /* Поля вокруг содержимого таблицы */
    border: 1px solid black; /* Параметры рамки */
   }
   TH {
    background: #b2b7b7; /* Цвет фона */
   }
  </style>
	</div>
	<?if(isset($_REQUEST['orders']) && !empty($dealers)){?>
		<?foreach($dealers as $dealer){?>
			<div class="separator">Накладная агента</div>
			<?foreach($dealer['orders'] as $id_order => $order){
				$total = array(
					'client_sum' => 0,
					'agent_profit' => 0					
				)?>
				<h2>Заказ №<?=$id_order?></h2>
				<dl class="hidden">
					<dt>Область</dt>
					<dd><?=$order['address']['region_title']?></dd>

					<dt>Город</dt>
					<dd><?=$order['address']['city_title']?></dd>

					<dt>Способ доставки</dt>
					<dd><?=$order['address']['delivery_type_title']?></dd>

					<dt>Служба</dt>
					<dd><?=$order['address']['shipping_company_title']?></dd>

					<dt>Отделение</dt>
					<dd><?=$order['address']['delivery_department']?></dd>
				</dl>
				<table>
					<thead>
						<tr>
							<th>арт.</th>
							<th>название</th>
							<th class="number">кол-во</th>
							<th class="number wrap">цена клиента</th>
							<th class="number wrap">сумма клиента</th>
							<th class="number wrap">бонус агента</th>
							<th class="number wrap">сумма агента</th>
						</tr>
					</thead>
					<tbody>
						<?foreach($order['products'] as $product){?>
							<tr>
								<td class="text"><?=$product['art']?></td>
								<td class="text name"><?=$product['name']?></td>
								<td class="number"><?=$product['qty'];?> </td>
								<td class="number"><?=$product['price_prod'];?> </td>
								<td class="number"><?=$product['sum_prod'];?></td>
								<td class="number"><?=$product['agent_bonus'];?></td>
								<td class="number"><?=$product['agent_prod'];?></td>
							</tr>
						<?}?>
						<tr class="total">
							<td class="number" colspan="4">Итого:</td>
							<td class="number"><?=$dealers[0]['orders'][$id_order]['sum_total'];?></td>
							<td class="number"></td>
							<td class="number"><?=$dealers[0]['orders'][$id_order]['agent_total'];?></td>
						</tr>
					</tbody>
				</table>
			<?}?>
		<?}?>
	<?}else{?>
		<h1>Произошла ошибка при выборе списка заказов</h1>
	<?}?>
</div>