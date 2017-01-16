<div class="orders_history">
	<h2>История</h2>
	<div class="orders_history_header">
		<div class="header_item date">Дата</div>
		<div class="header_item client">Клиент</div>
		<div class="header_item phone">Телефон</div>
		<div class="header_item order_sum">Сумма заказа</div>
		<div class="header_item profit">Начислено</div>
	</div>
	<?if(isset($history) && !empty($history)){
		foreach($history as $date => $value){?>
			<div class="orders_history_content">
				<div class="agents_client_order opening_tab toggle_btn_js">
					<div class="order_info date">
						<i class="material-icons">&#xE315;</i>
						<?=$date?>
					</div>
					<div class="order_info profit"><span class="agent_mobile_label">Начислено:</span> <?=number_format((isset($value['orders_sum'])?$value['orders_sum']:0), 2, ',', '')?> грн.</div>
				</div>
				<?foreach($value['orders'] as $order){?>
					<div class="agents_client_order
						<?if ($order['id_order_status'] == 1 || $order['id_order_status'] == 6) {
							echo "processing";
						}elseif ($order['id_order_status'] == 2) {
							echo "done";
						}else{
							echo "disabled";
						}?>">
						<div class="order_info client"><?=$order['last_name'] && $order['first_name'] && $order['middle_name'] != ''? $order['last_name'].' '.$order['first_name'].' '.$order['middle_name']:$order['name']?><span><i id="new_client_<?=$order['id_order']?>" class="material-icons <?=isset($order['promo_code'])?null:'hidden'?>">&#xE548;</i></span></div>
						<div class="order_info phone"><span class="agent_mobile_label">Тел.:</span> +<?=$order['phone']?></div>
						<div class="order_info order_sum"><span class="agent_mobile_label">Сумма заказа:</span> <?=number_format($order['agent_total'], 2, ',', '')?> грн.</div>
						<div class="order_info profit"><span class="agent_mobile_label">Начислено:</span> <?=number_format($order['agent_counted'], 2, ',', '')?> грн. <span><i id="processing_order_<?=$order['id_order']?>" class="material-icons <?=$order['id_order_status'] == 1 || $order['id_order_status'] == 6?null:'hidden'?>">&#xE8FD;</i></span></div>
						<div class="mdl-tooltip" for="new_client_<?=$order['id_order']?>">Новый клиент</div>
						<div class="mdl-tooltip" for="processing_order_<?=$order['id_order']?>">Заказ в обработке</div>
					</div>
				<?}?>
			</div>
		<?}
	}else{?>
		<h2>Ваши клиенты еще не сделали ни одного заказа!</h2>
	<?}?>
</div>