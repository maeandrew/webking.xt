<h1><?=$h1?></h1>

<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><?}?>

<p class="notification info">Раздел временно закрыт</p>
<form action="<?=$GLOBALS['URL_request']?>" method="post" class='hidden'>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list" style="overflow: scroll;font-size:12px;">
			<thead>
	          <tr>
	            <td class="left"><a href="<?=$sort_links['target_date']?>">Дата</a></td>
	            <td class="left">Статус</td>
	            <td class="left"><a href="<?=$sort_links['id_order']?>">Заказ</a></td>
	            <td class="left">Код части заказа</td>

	            <td class="left">Покупатель</td>
	            <td class="left">Контрагент</td>
	            <td class="left">Поставщик</td>
	            <td class="left">Група</td>

	            <td class="left">Сумма по заказу, грн</td>
	            <td class="left">Сумма по отпуск ценам, грн</td>

	            <td class="left">Претензия</td>
	            <td class="left">Статус</td>
	            <td class="left">Возврат</td>
	            <td class="left">Статус</td>
	          </tr>
	        </thead>
			<tbody>
			<tr class="filter">
					<td style="font-size: 11px;"><input type="text" style="width: 56px;" value="<?=isset($_POST['filter_target_date_start'])?htmlspecialchars($_POST['filter_target_date_start']):null?>" name="filter_target_date_start">
						<input type="text" style="width: 56px;" value="<?=isset($_POST['filter_target_date_end'])?htmlspecialchars($_POST['filter_target_date_end']):null?>" name="filter_target_date_end"></td>
					<td><select name="id_order_status" style="width:90px;" onchange="this.form.submit();">
						<option <?=(0==$_POST['id_order_status'])?'selected="true"':null?> value="0">-- Все --</option>
						<?foreach($order_statuses as $k=>$item){?>
							<option <?=($item['id_order_status']==$_POST['id_order_status'])?'selected="true"':null?> value="<?=$item['id_order_status']?>"><?=$item['name']?></option>
				 		<?}?>
						</select>
					</td>
					<td><input type="text" style="width: 50px;" value="<?=isset($_POST['filter_id_order'])?htmlspecialchars($_POST['filter_id_order']):null?>" name="filter_id_order"></td>
					<td class="left">&nbsp;</td>

					<td><input type="text" style="width: 120px;" value="<?=isset($_POST['filter_customer_name'])?htmlspecialchars($_POST['filter_customer_name']):null?>" name="filter_customer_name"></td>
					<td><input type="text" style="width: 90px;" value="<?=isset($_POST['filter_contragent_name'])?htmlspecialchars($_POST['filter_contragent_name']):null?>" name="filter_contragent_name"></td>
					<td class="left">&nbsp;</td>
					<td class="left">&nbsp;</td>

					<td class="left">&nbsp;</td>
					<td class="left">&nbsp;</td>

					<td class="left">&nbsp;</td>
					<td class="left">&nbsp;</td>
		            <td class="left">&nbsp;</td>
		            <td class="left">&nbsp;<input style="width: 1px; height: 1px; background-color:#E7EFEF;border:0px;" type="submit" name="smb" value=""></td>

			</tr>

			<?if(isset($list)){$tigra=false;foreach ($rows as $i){?>
				<tr<?if ($tigra==true){?> style="background-color:#f3f3f3;"<?$tigra=false;}else{$tigra=true;}?>>
					<td><?=$i['target_date']?></td>
					<td><?=$i['status_name']?></td>
					<td><?=$i['id_order']?></td>
					<td><nobr><?=$i['id_order_supart']?></nobr></td>
					<td><?=$i['customer_name']?></td>
					<td><?=$i['contragent_name']?></td>
					<td><?=$i['supplier_name']?></td>
					<td><?=$i['partner']?></td>
					<td><?=$i['order_sum']?></td>
					<td><?=$i['otpusk_prices_sum']?></td>
					<td class="center np"><?=$i['pretense']?></td>
					<td class="center np"><?=$i['pretense_status']?></td>
					<td class="center np"><?=$i['return']?></td>
					<td class="center np" style="padding: 3px 0;"><?=$i['return_status']?></td>
				</tr>
			<?}}?>
			</tbody>
		</table>
</form>
<a href="<?=$GLOBALS['URL_request']?>export" class='hidden'>Экспорт в excel</a>