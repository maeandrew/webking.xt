<div class="page">
	<div class="header">
		<img src="http://xt/themes/default/img/_xt.svg" alt="" class="logo">
		<div class="company-name">Служба снабжения ХарьковТорг</div>
	</div>
	<?if(isset($_REQUEST['orders']) && !empty($dealers)){?>
		<?foreach($dealers as $dealer){?>
			<div class="separator">Накладные дилера</div>
			<?foreach($dealer['orders'] as $id_order => $order){
				$total = array(
					'customer' => 0,
					'dealer' => 0,
					'agent' => 0,
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
							<th class="number wrap">цена дилера</th>
							<th class="number wrap">сумма клиента</th>
							<th class="number wrap">сумма дилера</th>
							<th class="number wrap">доход агента</th>
							<th class="number wrap">доход дилера</th>
						</tr>
					</thead>
					<tbody>
						<?foreach($order['products'] as $product){
							if($product['opt_qty'] > 0){
								$mode = 'opt';
								$qty_mode = 'contragent_qty';
							}else{
								$mode = 'mopt';
								$qty_mode = 'contragent_mqty';
							}
							$qty = $product[$qty_mode]>0?$product[$qty_mode]:0;
							?>
							<tr>
								<?$total['customer'] += $qty*$product['site_price_'.$mode];?>
								<?$total['dealer'] += $qty*$product['dealer_price'];?>
								<?$total['agent'] += $qty*$product['dealer_price'];?>
								<td class="text"><?=$product['art']?></td>
								<td class="text name"><?=$product['name']?></td>
								<td class="number"><?=$qty?> <?=$product['unit']?></td>
								<td class="number"><?=number_format($product['site_price_'.$mode], 2, ".", ",");?> </td>
								<td class="number"><?=number_format($product['dealer_price'], 2, ".", ",");?></td>
								<td class="number"><?=number_format($qty*$product['site_price_'.$mode], 2, ".", ",");?></td>
								<td class="number"><?=number_format($qty*$product['dealer_price'], 2, ".", ",");?></td>
								<td class="number"><?=number_format($product['agent_total']*$order['coeff'], 2, ".", ",");?></td>
								<td class="number"><?=number_format($qty*($product['site_price_'.$mode] - ($product['dealer_price'] > 0?$product['dealer_price']:$product['site_price_'.$mode])), 2, ".", ",");?></td>
							</tr>
						<?}?>
						<tr class="total">
							<td class="number" colspan="5">Итого:</td>
							<td class="number"><?=number_format($total['customer'], 2, ".", ",");?></td>
							<td class="number"><?=number_format($total['dealer'], 2, ".", ",");?></td>
							<td class="number"><?=number_format($order['agent_counted'], 2, ".", ",");?></td>
							<td class="number"><?=number_format($total['dealer'] - $total['agent'], 2, ".", ",");?></td>
						</tr>
					</tbody>
				</table>
			<?}?>
			<?if(isset($_REQUEST['form1'])){?>
				<h2 class="composed">Расходная накладная</h2>
				<table>
					<thead>
						<tr>
							<th>арт.</th>
							<th>название</th>
							<th class="number">кол-во</th>
							<th class="number">цена</th>
							<th class="number">сумма</th>
						</tr>
					</thead>
					<tbody>
						<?foreach($dealer['products'] as $id_product => $product){
							$total = 0;
							if($product['opt_qty'] > 0){
								$mode = 'opt';
								$qty_mode = 'contragent_qty';
							}else{
								$mode = 'mopt';
								$qty_mode = 'contragent_mqty';
							}
							$qty = $product[$qty_mode]>0?$product[$qty_mode]:0;
							?>
							<tr>
								<td class="text"><?=$product['art']?></td>
								<td class="text"><?=$product['name']?></td>
								<td class="number"><?=$qty?> <?=$product['unit']?></td>
								<td class="number"><?=number_format($product['dealer_price'], 2, ".", ",");?> </td>
								<td class="number"><?=number_format($qty*$product['dealer_price'], 2, ".", ",");?></td>
								<?$total += $qty*$product['dealer_price'];?>
							</tr>
						<?}?>
						<tr class="total">
							<td class="number" colspan="4">Итого:</td>
							<td class="number"><?=number_format($total, 2, ".", ",");?></td>
						</tr>
					</tbody>
				</table>
			<?}?>
			<div class="separator">Накладные клиентов</div>
			<?foreach($dealer['orders'] as $id_order => $order){
				$total = 0;?>
				<div class="customer_order">
					<div class="header">
						<img src="http://xt/themes/default/img/_xt.svg" alt="" class="logo">
						<div class="company-name">Служба снабжения ХарьковТорг</div>
					</div>
					<h2>Накладная №<?=$id_order?> от <?=date('d.m.Y');?></h2>
					<div class="details">
						<div class="left">
							<p>Получатель:</p>
							<dl>
								<dt>ФИО</dt>
								<dd><?=$order['customer']['last_name']?> <?=$order['customer']['first_name']?> <?=$order['customer']['middle_name']?></dd>
								<dt>Телефон</dt>
								<dd><?=$order['customer']['phones']?></dd>

								<dt>Адрес доставки</dt>
								<dd><?=$order['address']['region_title']?>, <?=$order['address']['city_title']?>, <?=$order['address']['delivery_type_title']?>, <?=$order['address']['shipping_company_title']?>, <?=$order['address']['delivery_department']?></dd>
							</dl>
						</div>
						<div class="right">
							<p>Отправитель:</p>
							<dl>	<dt>Имя</dt>
								<dd class="lorem"><?=$dealer_info['cont_person']; ?></dd>
								<dt>Телефон</dt>
								<dd><?=$dealer_info['phones']; ?></dd>
								<dt>E-mail</dt>
								<dd class="lorem"><?=$dealer_info['email']; ?></dd>
							</dl>
						</div>
					</div>
					<table>
						<thead>
							<tr>
								<th>арт.</th>
								<th>фото</th>
								<th>название</th>
								<th class="number">кол-во</th>
								<th class="number">цена</th>
								<th class="number">сумма</th>
							</tr>
						</thead>
						<tbody>
							<?foreach($order['products'] as $product){
								if($product['opt_qty'] > 0){
									$mode = 'opt';
									$qty_mode = 'contragent_qty';
								}else{
									$mode = 'mopt';
									$qty_mode = 'contragent_mqty';
								}
								$qty = $product[$qty_mode]>0?$product[$qty_mode]:0;
								?>
								<tr>
									<td class="text"><?=$product['art']?></td>
									<td class="text">
										<?if(!empty($product['images'])){?>
											<img src="<?=G::GetImageUrl($product['images'][0]['src'], 'medium')?>" alt="<?=htmlspecialchars($product['name'])?>">
										<?}else{
											if(!empty($product['img_1'])){?>
												<img src="<?=G::GetImageUrl($product['img_1'], 'medium')?>" alt="<?=htmlspecialchars($product['name'])?>">
											<?}
										}?>
									</td>
									<td class="text"><?=$product['name']?></td>
									<td class="number"><?=$qty?> <?=$product['unit']?></td>
									<td class="number"><?=number_format($product['site_price_'.$mode], 2, ".", ",");?> </td>
									<td class="number"><?=number_format($qty*$product['site_price_'.$mode], 2, ".", ",");?></td>
									<?$total += $qty*$product['site_price_'.$mode];?>
								</tr>
							<?}?>
							<tr class="total">
								<td class="number" colspan="5">Итого:</td>
								<td class="number"><?=number_format($total, 2, ".", ",");?></td>
							</tr>
						</tbody>
					</table>
				</div>
			<?}?>
		<?}?>
	<?}else{?>
		<h1>Произошла ошибка при выборе списка заказов</h1>
	<?}?>
</div>