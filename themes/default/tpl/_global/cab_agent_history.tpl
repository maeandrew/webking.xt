<div class="orders_history">
	<h2>История</h2>
	<div class="orders_history_header">
		<div class="header_item date">Дата</div>
		<!-- <div class="header_item client">Клиент телефон</div> -->
		<!-- <div class="header_item phone">Заказ</div> -->
		<!-- <div class="header_item order_sum">Сумма заказа</div> -->
		<div class="header_item profit">Баланс дня</div>
	</div>
	<?if(isset($history) && !empty($history)){
		foreach($history as $date => $value){?>
			<div class="orders_history_content">
				<div class="agents_client_order opening_tab toggle_btn_js">
					<div class="order_info date">
						<i class="material-icons">&#xE315;</i>
						<?=date('d.m.Y', $date);?>
					</div>
					<div class="order_info profit <?=isset($value['date_sum']) && $value['date_sum'] < 0?'negative':'positive';?>"><span class="agent_mobile_label">Начислено:</span> <?=number_format((isset($value['date_sum'])?$value['date_sum']:0), 2, ',', '')?> грн.</div>
				</div>
				<?foreach($value['actions'] as $time => $action){?>
					<?if($action['type'] == 'order'){?>
						<div class="agents_client_order
							<?if ($action['id_order_status'] == 1 || $action['id_order_status'] == 6) {
								echo "processing";
							}elseif ($action['id_order_status'] == 2) {
								echo "done";
							}else{
								echo "disabled";
							}?>">
							<div class="order_info time">
								<i class="material-icons">&#xE192;</i>
								<?=date('H:i', $time);?>
							</div>
							<div class="order_info client"><?=$action['last_name'] && $action['first_name'] && $action['middle_name'] != ''? $action['last_name'].' '.$action['first_name'].' '.$action['middle_name']:$action['name']?><span><i id="new_client_<?=$action['id_order']?>" class="material-icons <?=isset($action['promo_code'])?null:'hidden'?>">&#xE548;</i></span></div>
							<div class="order_info phone"><?=$action['phone']?></div>
							<div class="order_info id_order"><?=$action['id_order']?></div>
							<div class="order_info order_sum"><span class="agent_mobile_label">Сумма заказа:</span> <?=number_format($action['amount'], 2, ',', '')?> грн.</div>
							<div class="order_info profit"><span class="agent_mobile_label">Начислено:</span> <?=number_format($action['agent_counted'], 2, ',', '')?> грн. <span><i id="processing_order_<?=$action['id_order']?>" class="material-icons <?=$action['id_order_status'] == 1 || $action['id_order_status'] == 6?null:'hidden'?>">&#xE8FD;</i></span></div>
							<div class="mdl-tooltip" for="new_client_<?=$action['id_order']?>">Новый клиент</div>
							<div class="mdl-tooltip" for="processing_order_<?=$action['id_order']?>">Заказ в обработке</div>
						</div>
					<?}elseif($action['type'] == 'withdrawal'){?>
						<div class="agents_client_order done">
							<div class="order_info time">
								<i class="material-icons">&#xE192;</i>
								<?=date('H:i', strtotime($time));?>
							</div>
							<div class="order_info client"><?=$action['comment'];?></div>
							<!-- <div class="order_info phone">н/д</div>
							<div class="order_info order_sum withdrawal">н/д</div> -->
							<div class="order_info profit withdrawal"><span class="agent_mobile_label">Начислено:</span>-<?=number_format($action['amount'], 2, ',', '')?> грн.</div>
						</div>
					<?}?>
				<?}?>
			</div>
		<?}
	}else{?>
		<h2>Ваши клиенты еще не сделали ни одного заказа!</h2>
	<?}?>
</div>