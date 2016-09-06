	<rh1><?=$h1?></rh1>
	<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
	<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>
	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
			<col width="75px" /><col width="75px" /><col width="1%" />
			<thead>
				<tr>
					<td class="left"><a href="<?=$sort_links['target_date']?>">Дата</a></td>
					<td class="left"><a href="<?=$sort_links['id_order']?>">Заказ</a></td>
					<td class="left">Статус</td>
					<td class="left">Контрагент</td>
					<td class="left">Покупатель</td>
					<td class="left">Сумма</td>
					<td class="left">Сумма по отпускным ценам</td>

					<td class="left">Претензия</td>
					<td class="left">Статус</td>
					<td class="left">Возврат</td>
					<td class="left">Статус</td>
					<td class="left">е-майл</td>
				</tr>
			</thead>
			<tbody>
				<tr class="filter">
					<td><input type="text" style="width: 56px;" value="<?=isset($_POST['filter_target_date'])?htmlspecialchars($_POST['filter_target_date']):null?>" name="filter_target_date" /></td>
					<td><input type="text" style="width: 56px;" value="<?=isset($_POST['filter_id_order'])?htmlspecialchars($_POST['filter_id_order']):null?>" name="filter_id_order" /></td>
					<td><select name="id_order_status" style="width:60px;" onchange="this.form.submit();">
						<option <?=(0==$_POST['id_order_status'])?'selected="true"':null?> value="0">-- Все --</option>
							<?foreach($order_statuses as $k=>$item){?>
								<option <?=($item['id_order_status']==$_POST['id_order_status'])?'selected="true"':null?> value="<?=$item['id_order_status']?>"><?=$item['name']?></option>
							<?}?>
						</select>
					</td>
					<td>
						<input type="text" style="width: 120px;" value="<?=isset($_POST['filter_contragent_name'])?htmlspecialchars($_POST['filter_contragent_name']):null?>" name="filter_contragent_name" />
					</td>
					<td>
						<input type="text" style="width: 120px;" value="<?=isset($_POST['filter_customer_name'])?htmlspecialchars($_POST['filter_customer_name']):null?>" name="filter_customer_name" />
					</td>
					<td class="left">&nbsp;</td>
					<td class="left">&nbsp;</td>
					<td class="left">&nbsp;</td>
					<td class="left">&nbsp;</td>
					<td class="left">&nbsp;</td>
					<td class="left">&nbsp;<input style="width: 1px; height: 1px; background-color:#E7EFEF;border:0px;" type="submit" name="smb" value="" /></td>
					<td class="left">&nbsp;</td>
				</tr>
				<?if(isset($list)){
					$tigra=false;
					foreach($list as $i){?>
						<tr <?if($tigra==true){?>style="background-color:#f3f3f3;"<?$tigra=false;}else{$tigra=true;}?>>
							<td><?=date("d.m.Y",$i['target_date'])?></td>
							<td>
								<a href="<?=_base_url.'/adm/order/'.$i['id_order']?>"><?=$i['id_order']?>-заказ</a>
							</td>
							<td><?=$order_statuses[$i['id_order_status']]['name']?></td>
							<td><?=htmlspecialchars($i['contragent_name'])?></td>
							<td><?=htmlspecialchars($i['customer_name'])?></td>
							<td>
								<a target="_blank" href="<?=_base_url?>/invoice_customer/<?=$i['id_order']?>/<?=$i['skey']?>"><?=$i['sum_discount']?></a>
							</td>
							<td>
								<a target="_blank" href="<?=_base_url?>/invoice_contragent/<?=$i['id_order']?>/<?=$i['skey']?>"><center><?=$i['otpusk_prices_sum']?></center></a>
							</td>
							<td class="center np">
								<?if($i['id_pretense_status'] == 0){?>
									<p>&mdash;</p>
								<?}else{?>
									<p><a href="<?=_base_url?>/adm/order/<?=$i['id_order']?>"/><?=$i['id_order']?>-прет</p>
								<?}?>
							</td>
							<td class="center np">
								<?if($i['id_pretense_status'] == 0){?>
									<p>&mdash;</p>
								<?}else{?>
									<p <?=($i['id_pretense_status']==2)?'class="status_done"':null?>><?=$order_statuses[$i['id_pretense_status']]['name']?></p>
								<?}?>
							</td>
							<td class="center np">
								<?if($i['id_return_status'] == 0){?>
									<p>&mdash;</p>
								<?}else{?>
									<p><a href="<?=_base_url?>/adm/order_return/<?=$i['id_order']?>"/><?=$i['id_order']?>-возв</p>
								<?}?>
							</td>
							<td class="center np">
								<?if($i['id_return_status'] == 0){?>
									<p>&mdash;</p>
								<?}else{?>
									<p <?=($i['id_return_status']==2)?'class="status_done"':null?>><?=$order_statuses[$i['id_return_status']]['name']?></p>
								<?}?>
							</td>
							<td><?=$i['customer_email']?></td>
						</tr>
					<?}
				}?>
			</tbody>
		</table>
	</form>