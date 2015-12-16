<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Накладная поставщика</title>
	<style>
		body, div, dl, dt, dd, ul, ol, li,
		h1, h2, h3, h4, h5, h6,	pre, form,
		label, fieldset, img, input, textarea,
		p, blockquote, th, td { margin: 0; padding: 0; border: 0; outline: 0; }
		h1.header { font-size: 20px; font-weight: bold; margin: 10px 0; text-align: center; }
		:focus { outline: 0; }
		html,body { height: 100%; }
		body { font-family: Helvetica, sans-serif; width: 800px; }
		.undln { text-decoration: underline; }
		.lb { border-left: 1px dashed #000; padding-left: 5px; }
		.bl { border-left: 1px solid #000; }
		.br { border-right: 1px solid #000; }
		.bt { border-top: 1px solid #000; }
		.bb { border-bottom: 1px solid #000 !important; }
		.bn { border: none !important; }
		.bnb { border-bottom: none !important; }
		.blf { border-left: 1px solid #FFF; }
		.brf { border-right: 1px solid #FFF; }
		.bbf { border-bottom: 1px solid #FFF; }
		.table_main { width: 100%; }
		.table_main td { text-align: center; vertical-align: middle; box-sizing: border-box; font-size: .9em; }
		.table_main .hdr td { font-weight: bold; }
		.sum_row td {font-weight: bold; }
		.sum_row td.sum { color: red; font-weight: bold; }
		td.count { min-width: 30px; width: 30px; }
		td.image { min-width: 120px; width: 120px; }
		td.name { min-width: 330px; width: 330px; text-align: left; padding: 0 10px; }
		td.qty { min-width: 80px; width: 80px; }
		td.price { min-width: 80px; width: 80px; }
		td.sum { min-width: 80px; width: 80px; }
		td.volume { min-width: 80px; width: 80px; }
		tr.min td { height: 1px; line-height: 1px; margin: 0px; padding: 0px; }
		.note_red { color: red; font-weight: normal; }
		@media print {
			.sum_row td.sum { color: #000; }
		}
	</style>
</head>
<body>
<?$supii = 1;?>
<?foreach($products as $id_supplier=>$parr){?>
	<h1 class="header"> Заказ № <?=$id_order?> от <?=$date?></h1>
	<table border="0" cellpadding="0" cellspacing="0" class="table_main">
		<tbody>
			<tr class="hdr">
				<td class="bl bt count">№</td>
				<td class="bl bt image">Фото</td>
				<td class="bl bt name">Название</td>
				<td class="bl bt qty">Заказано, ед.</td>
				<td class="bl bt price">Цена за ед., грн.</td>
				<td class="bl bt sum">Сумма</td>
				<td class="bl bt br volume">Объем,<br>Вес</td>
			</tr>
			<?$ii=1;$sum=0;$qty=0;$weight=0;$volume=0;$sum_otp=0;?>
			<?foreach($parr as $i){?>
				<?if($i['mopt_qty']>0 && $i['id_supplier_mopt']==$id_supplier){?>
					<tr>
						<td class="bl bt count"><?=$ii++?></td>
						<td class="bl bt image"><img height="90" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/250/", $i['img_1'])):'/efiles/_thumb/nofoto.jpg'?>"></td>
						<td class="bl bt name"><?=$i['name']?><?if($i['note_mopt']!=''){?><span class="note_red"><?=$i['note_mopt']?></span><?}?></td>
						<td class="bl bt qty"><?=$i['mopt_qty']?></td>
						<?$qty+=$i['mopt_qty'];?>
						<td class="bl bt price"><?=number_format($i['price_mopt_otpusk'], 2, ",", "")?></td>
						<td class="bl bt sum"><?=number_format(($i['price_mopt_otpusk']*$i['mopt_qty']), 2, ",", "")?></td>
						<?$sum_otp=round($sum_otp+($i['price_mopt_otpusk']*$i['mopt_qty']),2)?>
						<td class="bl bt br volume"><?=number_format($i['volume']*$i['mopt_qty'], 2, ",", "")?><br><?=number_format($i['weight']*$i['mopt_qty'], 2, ",", "")?></td>
						<?$volume+=round($i['volume']*$i['mopt_qty'],2);?><?$weight+=round($i['weight']*$i['mopt_qty'],2);?>
					</tr>
				<?}?>
			<?}?>
			<tr class="sum_row">
				<td class="bt count"></td>
				<td class="bt image"></td>
				<td class="bt name"></td>
				<td class="bt qty"></td>
				<td class="bt price" style="text-align: right; padding-right: 5px;">Сумма:</td>
				<td class="bl bt bb sum"><?=number_format($sum_otp, 2, ",", "")?></td>
				<td class="bl bt bb br volume"><?=number_format($volume, 2, ",", "")?><br><?=number_format($weight, 2, ",", "")?></td>
			</tr>
		</tbody>
	</table>
<?}?>
</body>
</html>