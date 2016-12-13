<div class="agents_clients_list">
	<h2>Список привлеченных клиентов</h2>
	<div class="agents_client_header">
		<div class="header_item order_number">№</div>
		<div class="header_item client">Ф.И.О.</div>
		<div class="header_item phone">Телефон</div>
		<div class="header_item activation_date">Активация</div>
		<div class="header_item status">Статус</div>
		<div class="header_item profit">Доход</div>
	</div>
	<? $i=1; foreach ($agent_users as $client) {?>
		<div class="agents_client <?=$client['countable'] == 1?null:'disabled'?>">
			<div class="client_info order_number"><?=$i++?></div>
			<div class="client_info client"><?=$client['last_name']?> <?=$client['first_name']?> <?=$client['middle_name']?></div>
			<div class="client_info phone "><?=$client['countable'] == 1?'+'.$client['phone']:null?></div>
			<div class="client_info activation_date"><?=Date('m.d.Y',strtotime($client['activation_date']))?></div>
			<div class="client_info status"><?=$client['countable'] == 1?'Активен':'Утерян'?> <span <?=$client['countable'] == 1?'hidden':null?>><i id="processing_order_<?=$client['id_user']?>" class="material-icons">&#xE8FD;</i></span></div>
			<div class="mdl-tooltip" for="processing_order_<?=$client['id_user']?>">Не выполнены условия договора</div>
			<div class="client_info profit">Н/Д</div>
		</div>
	<?}?>
</div>