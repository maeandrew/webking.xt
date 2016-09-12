<table name="order" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:95% !important; width:95% !important;">
	<tbody>
		<tr>
			<td valign="top" style="margin:0;padding:0; padding-bottom: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
				<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;">
					<tbody>
						<tr>
							<td valign="top" style="margin:0;padding:0; padding-bottom: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
								№ заказа: <span style="font-weight: bold;">123456<?=$order['number']?></span>
							</td>
						</tr>
						<tr>
							<td valign="top" style="margin:0;padding:0; padding-bottom: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
								Сумма заказа: <span style="font-weight: bold;">100 000 грн.<?=$order['sum']?></span>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<?if(isset($order)){?>
			<tr>
				<td valign="top" style="margin:0;padding:0; padding-bottom: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
					<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;">
						<tbody>
							<tr>
								<td colspan="3" style="margin-bottom: 18px; color:#202020; font-family:Helvetica; font-style:normal; font-weight: bold; line-height:125%;letter-spacing:normal;text-align: center;">
									<p>Список товаров</p>
								</td>
							</tr>
							<?foreach ($order as $item) {?>
								<tr>
									<td colspan="3" valign="top" style="margin:0; border: 1px solid #e3e3e3; border-top: 2px solid #bbbbbb; padding: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: left;">
										Велосипедноватыйкуркуль пастеризованного типа со сложным передаточным числом <?=$item['name']?>
										<br>
										<p style="font-size: 12px; padding: 0px; margin-bottom: 0px; margin-top: 5px;">Арт.: 1526<?=$item['art']?></p>
									</td>
								</tr>
								<tr>
									<td valign="top" style="margin:0; border: 1px solid #e3e3e3; padding: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: center;">
										<span style="white-space: nowrap;">Цена: </span>
										<span style="white-space: nowrap; font-weight: bold;">250,65 грн.<?=$item['price']?></span>
									</td>
									<td valign="top" style="margin:0; border: 1px solid #e3e3e3; padding: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: center;">
										<span style="white-space: nowrap;">Кол-во: </span>
										<span style="white-space: nowrap; font-weight: bold;">5 шт.<?=$item['qty']?></span>
									</td>
									<td valign="top" style="margin:0; border: 1px solid #e3e3e3; padding: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: center;">
										<span style="white-space: nowrap;">Сумма: </span>
										<span style="white-space: nowrap; font-weight: bold;">1253,25 грн.<?=$item['sum']?></span>
									</td>
								</tr>
							<?}?>
						</tbody>
					</table>
				</td>
			</tr>
		<?}?>
		<tr>
			<td valign="top" style="margin:0;padding:0; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;">
					<tbody>
						<tr>
							<td valign="top" style="margin:0;padding:0; padding-top: 9px; padding-bottom: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:200%;letter-spacing:normal;text-align: justify;">
								Вы можете просмотреть детали вашего заказа в <a href="https://<?=$GLOBALS['CONFIG']['invoice_logo_sms']?>/cabinet/settings?t=basic">личном кабинете</a>, а так же оформить <a href="https://xt.ua">новый заказ</a>.
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
