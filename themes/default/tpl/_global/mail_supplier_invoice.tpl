<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin: 0; padding:0; width:100%; height:100%;">
	<!-- <center> -->
		<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border-collapse:collapse; height:100%; margin:0; padding:0;width:100%; background-color:#f3f3f3;">
			<tr>
				<td align="center" valign="top" style="height:100%; margin:0; padding:0; padding-top: 18px;width:100%; border-top:0;">
					<!-- BEGIN TEMPLATE // -->
					<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
						<tr>
							<td align="center" valign="top">
								<!--[if gte mso 9]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px; border-collapse:collapse;">
								<tr>
								<td align="center" valign="top" width="600" style="width:600px;">
								<![endif]-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; max-width:600px !important; width: 95% !important; background-color: #fff;">
									<tr>
										<td valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; min-width:100%;">
												<tbody>
													<tr>
														<td valign="top" style="padding-top:9px;">
															<!--[if mso]>
															<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse; width:100%;">
															<tr>
															<![endif]-->
															<!--[if mso]>
															<td valign="top" width="600" style="width:600px;">
															<![endif]-->
															<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;max-width:100%; min-width:100%;" width="100%">
																<tbody>
																	<tr>
																		<td valign="top" style="padding: 9px 18px 9px; font-family: Arial, &quot;Helvetica Neue&quot;, Helvetica, sans-serif; font-size: 24px; font-weight: bold; text-align: center;">
																			<a href="https://xt.ua" target="_blank"><img align="none" height="52" src="https://xt.ua/themes/default/img/xt.png" style="width: 175px; height: 52px; margin: 0px;" width="175"></a>
																		</td>
																	</tr>
																</tbody>
															</table>
															<!--[if mso]>
															</td>
															<![endif]-->
															<!--[if mso]>
															</tr>
															</table>
															<![endif]-->
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</table>
								<!--[if gte mso 9]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>
						<tr>
							<td align="center" valign="top">
								<!--[if gte mso 9]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="border-collapse:collapse; width:600px;">
								<tr>
								<td align="center" valign="top" width="600" style="width:600px;">
								<![endif]-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; max-width:600px !important; width: 95% !important; background-color: #fff;">
									<tr>
										<td valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; min-width:100%;">
												<tbody>
													<tr>
														<td valign="top" style="padding-top:9px;">
															<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100%; min-width:100%;" width="100%">
																<tbody>
																	<tr>
																		<td valign="top" style="padding: 0px 18px 9px; font-size: 14px; line-height: 150%; color:#202020;text-align: justify;">
																			<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;">
																				<tbody>
																					<tr>
																						<td valign="top" align="center" style="text-align: center !important; display:block; margin:0; margin-bottom: 10px; padding:0; color:#202020; font-family:Helvetica; font-size:18px; font-style:normal; font-weight:bold; line-height:125%;	letter-spacing:normal;">
																							Уважаемый поставщик!
																						</td>
																					</tr>
																					<tr>
																						<td valign="top"  style="text-align: justify !important; display:block; margin:0; padding:0; color:#202020; font-family:Helvetica; font-size:14px; font-style:normal; letter-spacing:normal;" >
																							На Ваши товары поступили заказы. Вы можете самостоятельно доставить их по адресу нашего склада: <span style="font-weight: bold;">ул. Якира, 130</span>. Со списком заказов и их содержимым Вы можете ознакомиться ниже.
																						</td>
																					</tr>
																				</tbody>
																			</table>
																			<br>
																			<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;max-width:100% !important; width:100% !important;">
																				<tbody>
																					<tr>
																						<td valign="top" style="margin:0;padding:0; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
																							<?foreach($supplier['orders'] as $order_key=>$order){?>
																								<table class="table_main" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
																									<thead>
																										<tr>
																											<th colspan="9" style="border: 0;">
																												<p style="font-size: 15px; font-weight: bold; width: 100%; text-align: center">№ <?=$order_key?><b style="color: #ff5722"><?=$orders[$order_key]['note2']?></b></p>
																											</th>
																										</tr>
																									</thead>
																									<tbody>
																										<?$ii = 1;
																										$sum = 0;
																										$qty = 0;
																										$weight = 0;
																										$volume = 0;
																										$sum_otpusk = 0;
																										foreach($order as &$i){
																											if($i['opt_qty'] > 0 && $i['id_supplier'] == $id_supplier){?>
																												<tr>
																													<td rowspan="3" align="center" style="border: 1px solid #e3e3e3; padding: 5px;"><?=$ii++?></td>
																												</tr>
																												<tr>
																													<td align="center" valign="middle" style="border: 1px solid #e3e3e3; padding: 5px;">
																														<img style="display:block; width:100%; min-width: 55px; max-width: 90px;" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>"/>
																													</td>
																													<td colspan="3" align="left" style="border: 1px solid #e3e3e3; padding: 5px;">
																														<?=$i['note_opt'] != ''?'<span style="color:#ff5722;">'.$i['note_opt'].'</span><br>':null;?>
																														<?=$i['name']?>
																													</td>
																												</tr>
																												<tr>
																													<td align="center" style="border: 1px solid #e3e3e3; padding: 3px;">
																														<span style="white-space: nowrap;">Арт: </span>
																														<span style="white-space: nowrap; font-weight: bold;"><?=$i['art']?></span>
																													</td>
																													<td align="center" style="border: 1px solid #e3e3e3; padding: 3px;">
																														<span style="white-space: nowrap;">Цена: </span>
																														<span style="white-space: nowrap; font-weight: bold;"><?=!$supplier['is_partner']?$i['price_opt_otpusk']:null;?></span>
																													</td>
																													<td align="center" style="border: 1px solid #e3e3e3; padding: 3px;">
																														<span style="white-space: nowrap;">Кол-во: </span>
																														<span style="white-space: nowrap; font-weight: bold;"><?=$i['opt_qty']?></span>
																													</td>
																													<td align="center" style="border: 1px solid #e3e3e3; padding: 3px;">
																														<span style="white-space: nowrap;">Сумма: </span>
																														<span style="white-space: nowrap; font-weight: bold;"><?!$supplier['is_partner']?round($i['price_opt_otpusk']*$i['opt_qty'], 2):null;?></span>
																													</td>
																												</tr>
																												<?$sum_otpusk = round(($sum_otpusk+round($i['price_opt_otpusk']*$i['opt_qty'], 2)),2);
																												$qty += $i['opt_qty'];
																												$volume += $i['volume']*$i['opt_qty'];
																												$weight += $i['weight']*$i['opt_qty'];
																												$sum = round($sum+$i['opt_sum'],2);
																											}

																											if($i['mopt_qty'] > 0 && $i['id_supplier_mopt'] == $id_supplier){?>
																												<tr>
																													<tr>
																														<td rowspan="3" align="center" style="border: 1px solid #e3e3e3; padding: 5px;"><?=$ii++?></td>
																													</tr>
																													<tr>
																														<td align="center" valign="middle" style="border: 1px solid #e3e3e3; padding: 5px;">
																															<img style="display:block; width:100%; min-width: 55px; max-width: 90px;" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>"/>
																														</td>
																														<td colspan="3" align="left" style="border: 1px solid #e3e3e3; padding: 5px;">
																															<?=$i['note_mopt'] != ''?'<span style="color:#ff5722;">'.$i['note_mopt'].'</span><br>':null;?>
																															<?=$i['name']?>
																														</td>
																													</tr>
																													<tr>
																														<td align="center" style="border: 1px solid #e3e3e3; padding: 3px;">
																															<span style="white-space: nowrap;">Арт: </span>
																															<span style="white-space: nowrap; font-weight: bold;"><?=$i['art']?></span>
																														</td>
																														<td align="center" style="border: 1px solid #e3e3e3; padding: 3px;">
																															<span style="white-space: nowrap;">Цена: </span>
																															<span style="white-space: nowrap; font-weight: bold;"><?=!$supplier['is_partner']?$i['price_mopt_otpusk']:null?></span>
																														</td>
																														<td align="center" style="border: 1px solid #e3e3e3; padding: 3px;">
																															<span style="white-space: nowrap;">Кол-во: </span>
																															<span style="white-space: nowrap; font-weight: bold;"><?=$i['mopt_qty']?></span>
																														</td>
																														<td align="center" style="border: 1px solid #e3e3e3; padding: 3px;">
																															<span style="white-space: nowrap;">Сумма: </span>
																															<span style="white-space: nowrap; font-weight: bold;"><?=!$supplier['is_partner']?round($i['price_mopt_otpusk']*$i['mopt_qty'], 2):null;?></span>
																														</td>
																													</tr>
																												</tr>
																												<?$sum_otpusk = round(($sum_otpusk+round($i['price_mopt_otpusk']*$i['mopt_qty'], 2)),2);
																												$qty += $i['mopt_qty'];
																												$volume += $i['volume']*$i['mopt_qty'];
																												$weight += $i['weight']*$i['mopt_qty'];
																												$sum = round($sum+$i['mopt_sum'],2);
																											}
																										}?>
																										<tr style="border-collapse:collapse;">
																											<td colspan="5" align="right" style="padding: 10px; border: 1px solid #e3e3e3;">
																												Общая сумма заказа: <?=!$supplier['is_partner']?'<span style="font-weight: bold; color:#ff5722;">'.$sum_otpusk.'</span>':null;?>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							<?}?>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;" width="100%">
												<tbody>
													<tr>
														<td valign="top" align="center" style="text-align: center !important; display:block; margin:0; margin-top: 10px;	padding:0; color:#202020; font-family:Helvetica; font-size:16px; font-style:normal; font-weight:bold; line-height:125%;	letter-spacing:normal;">
															Спасибо, что Вы с нами!
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</table>
								<!--[if gte mso 9]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>
						<tr>
							<td align="center" valign="top">
								<!--[if gte mso 9]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="border-collapse:collapse; width:600px;">
								<tr>
								<td align="center" valign="top" width="600" style="width:600px;">
								<![endif]-->
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; max-width:600px !important; width: 95% !important; background-color:#f3f3f3;margin-bottom: 18px;">
									<tr>
										<td valign="top">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; min-width:100%; background-color: #ffffff">
												<tbody>
													<tr>
														<td align="center" valign="top" style="padding:9px">
															<hr style="border: 1px solid #e7e7e7;">
															<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;" width="100%">
																<tbody>
																	<tr>
																		<td valign="top" align="center" style=" padding-bottom: 9px; padding-top: 5px; font-size: 14px; line-height: 150%; text-align: center; white-space: nowrap; color:#bbbbbb; font-weight: normal; font-family: Helvetica;">
																			Наши контакты:
																		</td>
																	</tr>
																</tbody>
															</table>
															<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;" width="100%">
																<tbody>
																	<tr align="center">
																		<td valign="top" align="center" style="width: 100px; padding-bottom: 9px; padding-top: 5px; white-space: nowrap; margin-right: 10px; font-size: 12px; display: inline-block; color: #2BAADF !important;font-weight: normal;text-decoration: underline; font-family: Helvetica;">
																			<a href="tel:+380675741013">(067) 574-10-13</a>
																		</td>
																		<td valign="top" align="center" style="width: 100px; padding-bottom: 9px; padding-top: 5px; white-space: nowrap; margin-right: 10px; font-size: 12px; display: inline-block; color: #2BAADF !important;font-weight: normal;text-decoration: underline; font-family: Helvetica;">
																			<a href="tel:+380577803861">(057) 780-38-61</a>
																		</td>
																		<td valign="top" align="center" style="width: 100px; padding-bottom: 9px; padding-top: 5px; white-space: nowrap; margin-right: 10px; font-size: 12px; display: inline-block; color: #2BAADF !important;font-weight: normal;text-decoration: underline; font-family: Helvetica;">
																			<a href="tel:+380995632817">(099) 563-28-17</a>
																		</td>
																		<td valign="top" align="center" style="width: 100px; padding-bottom: 9px; padding-top: 5px; white-space: nowrap; margin-right: 10px; font-size: 12px; display: inline-block; color: #2BAADF !important;font-weight: normal;text-decoration: underline; font-family: Helvetica;">
																			<a href="tel:+380634259183">(063) 425-91-83</a>
																		</td>
																	</tr>
																</tbody>
															</table>
															<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; min-width:100%;">
																<tbody>
																	<tr>
																		<td align="center" >
																			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse; min-width:100%;">
																				<tbody>
																					<tr>
																						<td align="center" valign="top" >
																							<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
																								<tbody>
																									<tr>
																										<td align="center" valign="top">
																											<!--[if mso]>
																											<table align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
																											<tr>
																											<![endif]-->
																											<!--[if mso]>
																											<td align="center" valign="top">
																											<![endif]-->
																											<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; display:inline;">
																												<tbody>
																													<tr>
																														<td valign="top" style="padding-right:10px; padding-bottom:9px;">
																															<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
																																<tbody>
																																	<tr>
																																		<td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
																																			<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
																																				<tbody>
																																					<tr>
																																						<td align="center" valign="middle" width="24">
																																							<a href="https://www.facebook.com/KharkovTorg" target="_blank"><img src="https://xt.ua/images/mail/fb.png" style="display:block;" height="24" width="24"></a>
																																						</td>
																																					</tr>
																																				</tbody>
																																			</table>
																																		</td>
																																	</tr>
																																</tbody>
																															</table>
																														</td>
																													</tr>
																												</tbody>
																											</table>
																											<!--[if mso]>
																											</td>
																											<![endif]-->
																											<!--[if mso]>
																											<td align="center" valign="top">
																											<![endif]-->
																											<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; display:inline;">
																												<tbody>
																													<tr>
																														<td valign="top" style="padding-right:10px; padding-bottom:9px;">
																															<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
																																<tbody>
																																	<tr>
																																		<td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
																																			<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
																																				<tbody>
																																					<tr>
																																						<td align="center" valign="middle" width="24">
																																							<a href="https://twitter.com/we_xt_ua" target="_blank"><img src="https://xt.ua/images/mail/tw.png" style="display:block;" height="24" width="24"></a>
																																						</td>
																																					</tr>
																																				</tbody>
																																			</table>
																																		</td>
																																	</tr>
																																</tbody>
																															</table>
																														</td>
																													</tr>
																												</tbody>
																											</table>
																											<!--[if mso]>
																											</td>
																											<![endif]-->
																											<!--[if mso]>
																											<td align="center" valign="top">
																											<![endif]-->
																											<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; display:inline;">
																												<tbody>
																													<tr>
																														<td valign="top" style="padding-right:10px; padding-bottom:9px;">
																															<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
																																<tbody>
																																	<tr>
																																		<td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
																																			<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
																																				<tbody>
																																					<tr>
																																						<td align="center" valign="middle" width="24">
																																							<a href="https://vk.com/xt_ua" target="_blank"><img src="https://xt.ua/images/mail/vk.png" style="display:block;" height="24" width="24"></a>
																																						</td>
																																					</tr>
																																				</tbody>
																																			</table>
																																		</td>
																																	</tr>
																																</tbody>
																															</table>
																														</td>
																													</tr>
																												</tbody>
																											</table>
																											<!--[if mso]>
																											</td>
																											<![endif]-->
																											<!--[if mso]>
																											<td align="center" valign="top">
																											<![endif]-->
																											<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; display:inline;">
																												<tbody>
																													<tr>
																														<td valign="top" style="padding-right:10px; padding-bottom:9px;">
																															<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
																																<tbody>
																																	<tr>
																																		<td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
																																			<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
																																				<tbody>
																																					<tr>
																																						<td align="center" valign="middle" width="24">
																																							<a href="https://www.youtube.com/channel/UCUSXO-seq23KfMwbn4q9VVw" target="_blank"><img src="https://xt.ua/images/mail/yt.png" style="display:block;" height="24" width="24"></a>
																																						</td>
																																					</tr>
																																				</tbody>
																																			</table>
																																		</td>
																																	</tr>
																																</tbody>
																															</table>
																														</td>
																													</tr>
																												</tbody>
																											</table>
																											<!--[if mso]>
																											</td>
																											<![endif]-->
																											<!--[if mso]>
																											<td align="center" valign="top">
																											<![endif]-->
																											<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; display:inline;">
																												<tbody>
																													<tr>
																														<td valign="top" style="padding-right:0; padding-bottom:9px;">
																															<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
																																<tbody>
																																	<tr>
																																		<td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
																																			<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
																																				<tbody>
																																					<tr>
																																						<td align="center" valign="middle" width="24">
																																							<a href="https://plus.google.com/+X-torg/" target="_blank"><img src="https://xt.ua/images/mail/gp.png" style="display:block;" height="24" width="24"></a>
																																						</td>
																																					</tr>
																																				</tbody>
																																			</table>
																																		</td>
																																	</tr>
																																</tbody>
																															</table>
																														</td>
																													</tr>
																												</tbody>
																											</table>
																											<!--[if mso]>
																											</td>
																											<![endif]-->
																											<!--[if mso]>
																											</tr>
																											</table>
																											<![endif]-->
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</table>
								<!--[if gte mso 9]>
								</td>
								</tr>
								</table>
								<![endif]-->
							</td>
						</tr>
					</table>
					<!-- // END TEMPLATE -->
				</td>
			</tr>
		</table>
	<!-- </center> -->









<!-- <div style="display: block;">
	<p style="margin: 1px 0 0 10px; font-size: 14px; font-weight: bold;">
		<div style="float:left">
			<span class="logo"><?=$_SERVER['SERVER_NAME']?></span>
		</div>
	</p>
	</div>
	<div style="clear: both; float:left; margin: 10px; font-size: 14px; font-weight: bold; width: 383px; padding-left: 10px;">
		<b><?=$supplier['name'].', '.$supplier['phone'].', '.$supplier['place']?></b>
	</div>
	<div style="float:left; margin: 10px; white-space: normal; width: 383px; padding-left: 10px;" class="bl">
		<p><?=$contragent['descr']?></p>
	</div>
	<div style="clear: both;"></div>
	<table border="0" cellpadding="0" cellspacing="0" style="width: 827px; clear: both; float: left; margin-top: 10px" class="table_main">
		<thead>
			<tr class="hdr">
				<th class="br bl bt bb">№ заказа</th>
				<th class="br bt bb">Сумма по отп. ценам</th>
				<th class="br bt bb">Сумма факт</th>
			</tr>
		</thead>
		<tbody>
	<?$otpusk = 0;
	$kotpusk  = 0;
	foreach($sorders[$id_supplier] as $k=>$o){?>
		<tr class="hdr">
			<td class="bl bb"><?=$k?></td>
			<td class="note_red bb"><?=$o['order_otpusk']?></td>
			<td class="bb br">&nbsp;</td>
		</tr>
		<?$otpusk += $o['order_otpusk'];
		$kotpusk += isset($o['site_sum'])?$o['site_sum']:0;
	}?>
	<tr class="hdr">
			<td class="bnb" style="text-align:right">Сумма</td>
			<td class="note_red"><?=$otpusk?></td>
			<td class="bb br">&nbsp;</td>
		</tr>
		<tr class="hdr">
			<td class="bnb note_red" style="text-align: right; font-size: 13pt;">Скидка</td>
			<td class="bb bt br">&nbsp;</td>
			<td class="bb bt br">&nbsp;</td>
		</tr>
		<tr class="hdr">
			<td class="bnb note_red" style="text-align: right; font-size: 13pt;">Сумма к оплате</td>
			<td class="bb br">&nbsp;</td>
			<td class="bb br">&nbsp;</td>
		</tr>
	</tbody>
	</table>

<?foreach($supplier['orders'] as $order_key=>$order){?>
	<table class="table_main" border="0" cellpadding="0" cellspacing="0">
		<col style="width: <?=$c1?>;"/>
		<col style="width: <?=$c2?>;"/>
		<col style="width: <?=$c3?>;"/>
		<col style="width: <?=$c4?>;"/>
		<col style="width: <?=$c5?>;"/>
		<col style="width: <?=$c6?>;"/>
		<col style="width: <?=$c7?>;"/>
		<col style="width: <?=$c8?>;"/>
		<thead>
			<tr>
				<th colspan="9" style="border: 0;">
					<p style="font-size: 20px; font-weight: bold; width: 827px; text-align: center">№ &nbsp;<?=$order_key?> - <b style="font-size:16px; color: red"><?=$orders[$order_key]['note2']?></b></p>
				</th>
			</tr>
			<tr class="hdr">
				<th class="bt br bl bb">№</th>
				<th class="bt br bb">Арт</th>
				<th class="bt br bb">Фото</th>
				<th class="bt br bb">Название</th>
				<th class="bt br bb">Цена 1шт.</th>
				<th class="bt br bb">Заказано, шт</th>
				<th class="bt br bb">факт</th>
				<th class="bt br bb">Сумма</th>
			</tr>
		</thead>
		<tbody>
			<?$ii = 1;
			$sum = 0;
			$qty = 0;
			$weight = 0;
			$volume = 0;
			$sum_otpusk = 0;
			foreach($order as &$i){
				if($i['opt_qty'] > 0 && $i['id_supplier'] == $id_supplier){?>
					<tr class="main">
						<td class="bl bb"><?=$ii++?></td>
						<td class="bb"><?=$i['art']?></td>
						<td class="bb">
							<img height="96" width="96" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>"/>
						</td>
						<td class="name bb">
							<?=$i['note_opt'] != ''?'<span class="note_red">'.$i['note_opt'].'</span><br>':null;?>
							<?=$i['name']?>
						</td>
						<td class="bb"><?=!$supplier['is_partner']?$i['price_opt_otpusk']:null;?></td>
						<td class="bb"><?=$i['opt_qty']?></td>
						<td class="bb">&nbsp;</td>
						<td class="bb"><?!$supplier['is_partner']?round($i['price_opt_otpusk']*$i['opt_qty'], 2):null;?></td>
					</tr>
					<?$sum_otpusk = round(($sum_otpusk+round($i['price_opt_otpusk']*$i['opt_qty'], 2)),2);
					$qty += $i['opt_qty'];
					$volume += $i['volume']*$i['opt_qty'];
					$weight += $i['weight']*$i['opt_qty'];
					$sum = round($sum+$i['opt_sum'],2);
				}
				if($i['mopt_qty'] > 0 && $i['id_supplier_mopt'] == $id_supplier){?>
					<tr class="main">
						<td class="bl bb"><?=$ii++?></td>
						<td class="bb"><?=$i['art']?></td>
						<td class="bb">
							<img height="96" width="96" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>"/>
						</td>
						<td class="name bb">
							<?=$i['note_mopt'] != ''?'<span class="note_red">'.$i['note_mopt'].'</span><br>':null;?>
							<?=$i['name']?>
						</td>
						<td class="bb"><?=!$supplier['is_partner']?$i['price_mopt_otpusk']:null?></td>
						<td class="bb"><?=$i['mopt_qty']?></td>
						<td class="bb">&nbsp;</td>
						<td class="bb"><?=!$supplier['is_partner']?round($i['price_mopt_otpusk']*$i['mopt_qty'], 2):null;?></td>
					</tr>
					<?$sum_otpusk = round(($sum_otpusk+round($i['price_mopt_otpusk']*$i['mopt_qty'], 2)),2);
					$qty += $i['mopt_qty'];
					$volume += $i['volume']*$i['mopt_qty'];
					$weight += $i['weight']*$i['mopt_qty'];
					$sum = round($sum+$i['mopt_sum'],2);
				}
			}?>
			<tr class="table_sum">
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn">&nbsp;</td>
				<td class="bn" style="text-align: right">Сумма:</td>
				<td class="br bb bl"><?=!$supplier['is_partner']?'<div class="note_red">'.$sum_otpusk.'</div>':null;?></td>
			</tr>
		</tbody>
	</table>
<?}?> -->

</body>
</html>