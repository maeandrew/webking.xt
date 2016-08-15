<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"><span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"><span class="strong">Сделано!</span><?=$msg?></div><?}?>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<form action="<?=$_SERVER['REQUEST_URI']?>/" method="get" class="orders">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list paper_shadow_1">
		<col width="5%"/>
		<col width="8%"/>
		<col width="12%"/>
		<col width="15%"/>
		<col width="20%"/>
		<col width="15%"/>
		<col width="10%"/>
		<col width="10%"/>
		<!-- <col width="50%"/>
		<col width="50%"/>
		<col width="50%"/>
		<col width="50%"/> -->
		<col width="5%"/>
		<thead>
			<tr class="filter">
				<td>Фильтры:</td>
				<td>
					<input type="text" class="input-m" name="filter_id_order" value="<?=isset($_GET['filter_id_order'])?htmlspecialchars($_GET['filter_id_order']):null?>" placeholder="№ заказа">
				</td>
				<td>
					<select name="id_order_status" class="input-m" placeholder="Статус заказа">
						<option <?=$_GET['id_order_status'] == 0?'selected="true"':null?> value="0">-- Все --</option>
						<?foreach($order_statuses as $k=>$item){?>
							<option <?=$item['id_order_status'] == $_GET['id_order_status']?'selected="true"':null?> value="<?=$item['id_order_status'];?>"><?=$item['name'];?>
							</option>
						<?}?>
					</select>
				</td>
				<td>
					<input type="text" class="input-m" value="<?=isset($_GET['filter_contragent_name'])?htmlspecialchars($_GET['filter_contragent_name']):null?>" placeholder="Менеджер" name="filter_contragent_name">
				</td>
				<td>
					<input type="text" class="input-m" value="<?=isset($_GET['filter_customer_name'])?htmlspecialchars($_GET['filter_customer_name']):null?>" placeholder="Покупатель" name="filter_customer_name">
				</td>
				<td class="left">
					<input type="text" class="input-m" value="<?=isset($_GET['filter_email'])?htmlspecialchars($_GET['filter_email']):null?>" placeholder="E-mail" name="filter_email">
				</td>
				<td class="left">
					<button type="submit" name="smb" class="btn-m-default">Применить</button>
				</td>
				<td class="left">
					<button type="submit" name="clear_filters" class="btn-m-default-inv">Сбросить</button>
				</td>
				<td class="left">&nbsp;</td>
			</tr>
			<tr>
				<td class="left"><a href="<?=$sort_links['creation_date']?>">Дата</a></td>
				<td class="left"><a href="<?=$sort_links['id_order']?>">Заказ</a></td>
				<td class="left">Статус</td>
				<td class="left">Менеджер</td>
				<td class="left">Покупатель</td>
				<td class="left">E-mail</td>
				<td class="left">Сумма</td>
				<td class="left">Сумма отпуска</td>
				<td class="left">Восстановить</td>
			</tr>
		</thead>
		<tbody>
			<?if(isset($list)){
				foreach($list as $i){?>
					<tr class="animate">
						<td><?=date("d.m.Y", $i['creation_date'])?></td>
						<td>
							<a href="/adm/order/<?=$i['id_order']?>"><?=$i['id_order']?></a>
						</td>
						<td id="status"><?=$order_statuses[$i['id_order_status']]['name']?></td>
						<td><?=htmlspecialchars($i['contragent_name'])?></td>
						<td><?=htmlspecialchars($i['customer_name'])?></td>
						<td><?=$i['customer_email']?></td>
						<td>
							<a target="_blank" href="/invoice_customer/<?=$i['id_order']?>/<?=$i['skey']?>"><?=$i['sum_discount']?></a>
						</td>
						<td>
							<a target="_blank" href="/invoice_contragent/<?=$i['id_order']?>/<?=$i['skey']?>"><?=$i['otpusk_prices_sum']?></a>
						</td>
						<td class="left">
							<?if($i['id_order_status'] == 2 || $i['id_order_status'] == 4 || $i['id_order_status'] == 5 || $i['id_order_status'] == 7){?>
								<input name="restore" type="button" title="Восстановить удаленный или отмененный заказ" class="btn-m-default-inv" value="<?=$i['id_order']?>">
							<?}?>
						</td>
					</tr>
				<?}
			}?>
		</tbody>
	</table>
</form>
<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null;?>
<script>
var restore = 0;
$('[name="restore"]').click(function(){
	var restore = 1;
	var button = $(this);
	var id_order = $(this).val();
	ajax('order', 'restoreDeleted', {id_order: id_order, restore: restore}).done(function(){
		console.log('tcnm');
		button.fadeOut(300);
	});
});
</script>