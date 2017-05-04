<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title>Накладная факт</title>
	<style>
		body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6,
		pre, form, label, fieldset, img, input, textarea, p,
		blockquote, th, td {
			margin: 0;
			padding: 0;
			border: 0;
			outline: 0;
			font-size: 100%;
			vertical-align: baseline
		}
		.invoice {
			font-family: "Roboto", Helvetica, sans-serif;
			font-size: 12px;
			color: #444;
		}
		.invoice .table {
			margin: 0 auto;
		}
		.invoice .header * {
			line-height: 30px;
		}
		.invoice .header .logo {
			display: inline-block;
			height: 30px;
			width: auto;
			vertical-align: top;
			margin-right: 15px;
		}
		.invoice .header .title {
			font-size: 18px;
			font-weight: bold;
		}
		.invoice .header .site {
			font-size: 36px;
			text-align: right;
			float: right;
			font-weight: bold;
			color: #0070ff;
		}
		.invoice .undln {
			text-decoration: underline;
		}
		.invoice .lb {
			border-left: 1px dashed #000;
			padding-left: 5px;
		}
		.invoice .table_header {
			width: 190mm;
			padding: 10px 0;
		}
		.invoice .table_header .top td {
			padding-top: 15px;
			font-size: 14px;
		}
		.invoice .table_header .first_col {
			width: 90px;
		}
		.invoice .table_header .second_col {
			width: 325px;
		}
		.invoice .bl {
			border-left: 1px solid #000;
		}
		.invoice .bln {
			border-left: 0 !important;
		}
		.invoice .br {
			border-right: 1px solid #000;
		}
		.invoice .brn {
			border-right: 0 !important;
		}
		.invoice .bt {
			border-top: 1px solid #000;
		}
		.invoice .btn {
			border-top: 0 !important;
		}
		.invoice .bb {
			border-bottom: 1px solid #000;
		}
		.invoice .bbn {
			border-bottom: 0 !important;
		}
		.invoice .blf {
			border-left: 1px solid #FFF;
		}
		.invoice .brf {
			border-right: 1px solid #FFF;
		}
		.invoice .bn {
			border: 0 !important;
		}
		.invoice .table_main {
			width: 190mm;
			padding: 10px 0;
			page-break-after: always;
		}
		.invoice .table_main:last-of-type {
			page-break-after: avoid;
		}
		.invoice .table_main td {
			padding: 1px 1px 0;
			font-size: 12px;
			text-align: center;
			border-right: 1px #000 solid;
			border-bottom: 1px #000 solid;
			vertical-align: middle;
		}
		.invoice .table_main td.name {
			padding: 5px;
			font-size: 12px;
			text-align: left;
			border-right: 1px #000 solid;
			border-bottom: 1px #000 solid;
		}
		.invoice .table_main .hdr td {
			font-weight: bold;
			padding: 1px;
		}
		.invoice .table_main .main td {
			height: 50px;
		}
		.invoice .table_main .main td.img {
			width: 56px;
		}
		.invoice .table_sum {
			margin: 10px 0 0 1px;
		}
		.invoice .table_sum td {
			padding: 1px 1px 0;
			font-size: 12px;
			text-align: center;
			vertical-align: middle;
		}
		.invoice .table_sum td.name {
			padding: 1px;
			font-size: 12px;
			text-align: left;
		}
		.invoice tr.min td {
			height: 1px;
			font-size: 1px;
			line-height: 1px;
			margin: 0px;
			padding: 0px;
		}
		.invoice .adate {
			font-size: 11px;
			margin-left: 177px;
		}
		.invoice .note_red {
			color: Red;
			font-size: 11px;
			font-weight: normal;
		}
		.invoice h1.filial {
			text-align: center;
			font-size: 27px;
		}
		@media print {
			.invoice h1.filial {
				display: none;
			}
		}
		.certificate {
			page-break-before: always;
		}
	</style>
</head>
<body class="invoice">
	<table align="center" width="800" border="0" cellpadding="0" cellspacing="0" class="table_header">
		<colgroup>
			<col width="50%" />
			<col width="50%" />
		</colgroup>
		<tbody>
			<tr>
				<td colspan="2" class="header">
					<img src="https://xt.ua/themes/default/img/xt.png" class="logo">
					<span class="title">Расходная накладная № <?=$id_order?> от <?=date("d.m.Y",$order['creation_date'])?></span>
					<span class="site">xt.ua</span>
				</td>
			</tr>
			<tr class="top">
				<td>
					<span class="subtitle"><b>Отправитель:</b></span>
					<p><?=!isset($remitter)?'Не указан':$remitter['name'].'<br>, '.$remitter['address'].', '.($remitter['rs']==''?null:'Р/с '.$remitter['rs'].', ').'МФО '.$remitter['mfo'].', '.$remitter['bank'].', ЕГРПОУ '.$remitter['egrpou'];?></p>
					<br>
					<span class="subtitle"><b>Агент:</b></span>
					<p><?=$contragent['name'].', '.$contragent['phone']?></p>
				</td>
				<td>
					<span class="subtitle"><b>Получатель:</b></span>
					<p><?=(($customer['last_name'] && $customer['first_name'] && $customer['middle_name']) != false)? ($customer['last_name'].' '.$customer['first_name'].' '.$customer['middle_name'].' , тел. '.@$user['phone']):$customer['cont_person'].' , тел. '.@$user['phone'];?>
						<br>
						<?=empty($address)?'Адрес доставки не указан':$address['region_title'].', '.$address['city_title'].', '.$address['delivery_type_title'].', '.$address['shipping_company_title'].', '.($address['id_delivery'] == 1?$address['delivery_department']:$address['address']);?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
	<?
	$c1 = 25;
	$c2 = 40;
	$c3 = 45;
	$c4 = 60;
	$c5 = 250;
	$c6 = 45;
	$c7 = 70;
	$c8 = 60;
	$c9 = 60;
	$c10 = 60;
	$c11 = 65;
	?>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="table_main">
		<col width="<?=$c1?>"/>
		<col width="<?=$c2?>"/>
		<col width="<?=$c3?>"/>
		<col width="<?=$c4?>"/>
		<col width="<?=$c5?>"/>
		<col width="<?=$c6?>"/>
		<col width="<?=$c7?>"/>
		<col width="<?=$c8?>"/>
		<col width="<?=$c9?>"/>
		<col width="<?=$c10?>"/>
		<col width="<?=$c11?>"/>
		<tbody>
			<tr class="hdr">
				<td rowspan="2" class="bl bt">№</td>
				<td rowspan="2" class="bt">Скл.</td>
				<td rowspan="2" class="bt">Арт.</td>
				<td rowspan="2" class="bt">Фото</td>
				<td rowspan="2" class="bt">Название</td>
				<td rowspan="2" class="bt">Отпущено, шт</td>
				<td colspan="2" class="bt">Поля клиента</td>
				<td rowspan="2" class="bt">Цена за шт.</td>
				<td rowspan="2" class="bt">Сумма факт</td>
				<td rowspan="2" class="bt">Вес,<br/>Объем</td>
			</tr>
			<tr class="hdr">
				<td>Цена розница</td>
				<td>Сумма розница</td>
			</tr>
			<?$ii=1;$qty=0;$weight=0;$volume=0;$sum=0;
			if(empty($arr) === false){
				foreach($arr as &$a){
					foreach($a as &$i){
						if($i['opt_qty'] > 0){?>
							<tr class="main">
								<td class="bl c1"><?=$ii++?></td>
								<td class="c2"><?=$i['article']?></td>
								<td class="c3"><?=$i['art']?></td>
								<td class="c4">
									<?if($i['image'] != ''){?>
										<img height="48" src="<?=G::GetImageUrl($i['image'], 'medium')?>" alt="<?=htmlspecialchars($i['name'])?>">
									<?}else{?>
										<img height="48" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>" />
									<?}?>
								</td>
								<td class="name c5">
									<?=$i['name']?>
									<?if($i['note_opt']!=''){?>
										<span class="note_red"><?=preg_replace('/\<i\>.*\<\/\i\>/', '', $i['note_opt'])?></span>
									<?}?>
								</td>
								<td class="c7"><?=$i['contragent_qty'] < 0?0:$i['contragent_qty'];?></td>
								<td class="c9">&nbsp;</td>
								<td class="c10">&nbsp;</td>
								<td class="c6"><?=number_format($i['site_price_opt'], 2, ",", "");?></td>
								<?$qty += $i['contragent_qty'];?>
								<td class="c8"><?=number_format($i['contragent_sum'], 2, ",", "");?></td>
								<?$sum += $i['contragent_sum'];?>
								<td class="c11">
									<?=number_format($i['volume']*($i['contragent_qty'] < 0?0:$i['contragent_qty']), 2, ",", "")?><br/>
									<?=number_format($i['weight']*($i['contragent_qty'] < 0?0:$i['contragent_qty']), 2, ",", "")?>
								</td>
								<?$weight += round($i['weight']*($i['contragent_qty'] < 0?0:$i['contragent_qty']), 2);
								$volume += round($i['volume']*($i['contragent_qty'] < 0?0:$i['contragent_qty']), 2);?>
							</tr>
						<?}
						if($i['mopt_qty'] > 0){?>
							<tr>
								<td class="bl c1"><?=$ii++?></td>
								<td class="c2"><?=$i['article_mopt']?></td>
								<td class="c3"><?=$i['art']?></td>
								<td class="c4">
									<?if($i['image'] != ''){?>
										<img height="48" src="<?=G::GetImageUrl($i['image'], 'medium')?>" alt="<?=htmlspecialchars($i['name'])?>">
									<?}else{?>
										<img height="48" src="<?=G::GetImageUrl($i['img_1'], 'medium')?>" />
									<?}?>
								</td>
								<td class="name c5">
									<?=$i['name']?>
									<?if($i['note_mopt']!=''){?>
										<span class="note_red"><?=preg_replace('/\<i\>.*\<\/\i\>/', '', $i['note_mopt'])?></span>
									<?}?>
								</td>
								<td class="c7"> <?=$i['contragent_mqty'] < 0?0:$i['contragent_mqty'];?> </td>
								<td class="c9">&nbsp;</td>
								<td class="c10">&nbsp;</td>
								<td class="c6"><?=number_format($i['site_price_mopt'], 2, ",", "");?></td>
								<?$qty+=$i['contragent_mqty'];?>
								<td class="c8"><?=number_format($i['contragent_msum'], 2, ",", "");?></td>
								<?$sum+=$i['contragent_msum'];?>
								<td class="c11">
									<?=number_format($i['volume']*($i['contragent_mqty'] < 0?0:$i['contragent_mqty']), 2, ",", "");?><br/>
									<?=number_format($i['weight']*($i['contragent_mqty'] < 0?0:$i['contragent_mqty']), 2, ",", "");?>
								</td>
								<?$weight += round($i['weight']*($i['contragent_mqty'] < 0?0:$i['contragent_mqty']), 2);
								$volume += round($i['volume']*($i['contragent_mqty'] < 0?0:$i['contragent_mqty']), 2);?>
							</tr>
						<?}
					}
				}
			}?>
			<?if($order['freight'] != 0){?>
				<tr>
					<td colspan="9" class="br bbn" style="text-align: right; line-height: 30px; padding-right: 5px;">Итого:</td>
					<td class="br bb"><?=number_format($sum, 2, ",", "");?></td>
					<td class="bn">&nbsp;</td>
			</tr>
				<tr style="margin-top: 0px;">
					<td colspan="9" class="br bbn" style="text-align: right; line-height: 30px; padding-right: 5px;">Услуги:</td>
					<td class="br bb"><?=number_format($order['freight'], 2, ",", "");?></td>
					<?$sum += $order['freight'];?>
					<td class="bn">&nbsp;</td>
				</tr>
			<?}
			if($order['order_discount'] != 0){?>
				<tr>
					<td colspan="9" class="br bbn" style="text-align: right; line-height: 30px; padding-right: 5px;">Скидка:</td>
					<td class="br bb"><?="-".number_format($order['order_discount'], 2, ",", "");?></td>
					<?$sum -= $order['order_discount'];?>
					<td class="bn">&nbsp;</td>
				</tr>
			<?}?>
			<tr>
				<td colspan="9" class="br bbn" style="text-align: right; line-height: 30px; padding-right: 5px;"><b>Всего к оплате:</b></td>
				<td class="br bb"><b><?=number_format($sum, 2, ",", "");?></b></td>
				<td class="bn">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="8" class="bn" style="text-align: right;"></td>
				<td colspan="3" class="bn">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="11" class="bn" style="text-align: left; font-size: 14px;"><?=$GLOBALS['CONFIG']['invoice_customer_phrase']?></td>
			</tr>
			<tr><td colspan="11" class="bn">&nbsp;<br/>&nbsp;</td></tr>
			<tr>
				<td colspan="5" class="bn">отпустил___________________</td>
				<td colspan="5" class="bn">принял___________________</td>
				<td class="bn">&nbsp;</td>
			</tr>
			<tr><td colspan="11" class="bn">&nbsp;<br/>&nbsp;</td></tr>
			<tr>
				<td colspan="11" class="bn" style="text-align: left; font-size: 14px;"><?=$GLOBALS['CONFIG']['invoice_customer_certificate_phrase']?></td>
			</tr>
		</tbody>
	</table>
	<?if(isset($Sertificates)){?>
		<?foreach($Sertificates as $s){?>
			<br/><br/>
			<img src="<?=file_exists($GLOBALS['PATH_root'].'/phpthumb/phpThumb.php?src='.$s.'&w=800')?_base_url.'/phpthumb/phpThumb.php?src='.$s.'&w=800':'/images/nofoto.png'?>" />
		<?}?>
	<?}?>
</body>
</html>