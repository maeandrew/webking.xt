<div class="cabinet customer_cabinet">
<?date_default_timezone_set('Europe/Kiev');?>
	<h2>История заказов</h2>
	<div class="history">
		<div class="clear"></div>
		<?if(!empty($orders)){?>
			<table border="0" cellpadding="0" cellspacing="0" class="returns_table" width="100%" style="margin: 0 0 10px 0;">
				<thead>
					<tr>
						<th class="details">Детали</th>
						<th class="date">Дата</th>
						<th class="qty">Товаров</th>
						<th class="sum">Сумма</th>
						<th class="descr">Дополнительная информация</th>
						<th class="delete">Удалить</th>
					</tr>
				</thead>
				<tbody>
					<?$i = 0;
					foreach($orders as $o){?>
						<tr style="<?=$i%2 == 1?'background: #eee;':null;?>">
							<td class="details"><a href="<?=_base_url?>/customer_order/<?=$o['id_order'];?>">Детали</a></td>
							<td class="date">
								<?if(date("d.m.Y", $o['creation_date']) == date("d.m.Y")){
									echo "Сегодня в ".date("H:i", $o['creation_date']);
								}elseif(date("d.m.Y", strtotime('-1 day', time())) == date("d.m.Y", $o['creation_date'])) {
									echo "Вчера в ".date("H:i", $o['creation_date']);
								}else{
									echo date("d.m.Y H:i", $o['creation_date']);
								}?>
							</td>
							<td class="qty"><?=$o['qty'];?></td>
							<td class="sum"><?=number_format($o['sum_discount'], 2, ",", "");?> грн.</td>
							<td class="descr"><?=isset($o['descr'])?$o['descr']:null;?></td>
							<td class="delete">
								<?if($o['id_order_status'] == 6){?>
									&mdash;
								<?}else{?>
									<form action="" method="post">
										<input type="submit" name="smb_off" class="run_order_off cancel" value="X">
										<input type="hidden" name="id_order" value="<?=$o['id_order'];?>">
									</form>
								<?}?>
							</td>
						</tr>
					<?$i++;
					}?>
				</tbody>
			</table>
		<?}else{?>
			<p>У Вас нету ни одного заказа</p>
		<?}?>
	</div><!--class="history"-->
</div><!--class="cabinet"-->