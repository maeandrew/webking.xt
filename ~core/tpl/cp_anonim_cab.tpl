<div class="anonim_cab">
	<div class="msg-attention">
		<p>Заказы, сделанные без регистрации, находятся в свободном доступе (без отображения персональных данных).<br>
		Отгружаются заказы в статусе "Выполняется". Этот статус заказ получает после подтверждения полной или частичной предоплаты по заказу (условия в разделе "Оплата и доставка").<br>
		Пожалуйста, после выполнения предоплаты сообщите сумму проплаты по заказу менеджеру.</p>
	</div>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table">
		<thead>
			<tr>
				<th>Дата</th>
				<th>Заказ №</th>
				<th>Статус</th>
				<th>Сумма</th>
				<th>Менеджер</th>
				<th>Накладная заказа</th>
			</tr>
		</thead>
		<tbody>
			<?foreach($orders as $i){?>
				<tr>
					<td>
						<p><?=date("d.m.Y",$i['creation_date'])?></p>
					</td>
					<td>
						<p><?=$i['id_order']?></p>
					</td>
					<td>
						<p <?=($i['id_order_status']==2)?' class="status_done"':null?>>
							<?=$order_statuses[$i['id_order_status']]['name']?>
						</p>
					</td>
					<td>
						<p><?=round($i['sum_discount'],2)?></p>
					</td>
					<td>
						<p><?=$i['contragent']?></p>
					</td>
					<td>
						<p>
							<a target="_blank" href="<?=_base_url?>/invoice_anonim/<?=$i['id_order']?>">Открыть накладную</a>
						</p>
					</td>
				</tr>
			<?}?>
		</tbody>
	</table>
</div><!--class="cabinet"-->