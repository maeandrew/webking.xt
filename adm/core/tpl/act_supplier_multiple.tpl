<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Новый акт сверки цен поставщика</title>
	<style rel="stylesheet">
		* { margin: 0; padding: 0; font-family: "Trebuchet MS", Helvetica, sans-serif;}
		html { background: #fff; }
		.table_header {margin-left:15px; width: 100%;}
		.table_header .top td {font-size:14px;}
		.table_header .first_col {width: 90px;}
		.table_header .second_col {width: 325px;}
		.table_header .top span.invoice { margin-top:20px;font-size:18px;text-decoration:underline;line-height: 23px;}
		.logo{font-size: 38px; color: #00F; font-weight: bold;}
		p.supplier {
			font-size: 20pt;
			min-height: 300px;
			max-height: 300px;
		}
		body {
			width: 1077px;
			margin: 0 auto;
		}
		.block {
			position: relative;
			background: #fff;
			border: 0;
			border-left: 1px solid #000;
			border-top: 1px solid #000;
			border-color: #5f5;
			width: 50%;
			display: block;
			color: #000;
			float: left;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			overflow: hidden;
			page-break-inside: avoid;
		}
		.block:nth-of-type(even) {
			border: 1px solid #000;
			border-bottom: 0;
			border-color: #5f5;
		}
		.block .photo {
			width: 250px;
			height: 250px;
		}
		.block .photo img {
			position: relative;
			clear: both;
			z-index: 10;
		}
		.block .description {
			position: relative;
			text-shadow: 1px 1px 0 #fff, -1px 1px 0 #fff, 1px -1px 0 #fff, -1px -1px 0 #fff;
			line-height: 20px;
			color: #000;
			font-size: 15pt;
			height: 50px;
			padding: 5px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			z-index: 50;
			font-weight: bold;
		}
		.block table {
			font-size: 15pt;
			position: absolute;
			bottom: -1px;
			right: -1px;
			float: right;
			border-collapse: collapse;
		}
		.block table tr {
			height: 35px;
			border-top: 0;
		}
		.block table tr th,
		.block table tr td {
			border: 1px solid #ccc;
			text-align: center;
			font-weight: normal;
			font-size: 12pt;
		}
		.block table tr td:first-of-type {
			border-left: none;
		}
		.block table tr.art {
			height: 30px;
		}
		.block table tr.min_price td {
			border: 0;
		}
		.block table tr.art td {
			font-size: 25pt;
			text-align: right;
			border: 0;
		}
		.block table tr.art td p {
			line-height: 38px;
			text-align: left;
			float: left;
		}
		.block table tr.header {
			height: 20px;
		}
		.block table tr .date,
		.block table tr .price,
		.block table tr .single_price {
			position: relative;
			width: 90px;
			text-align: left;
			padding: 0 1%;
		}
		.block table tr .date {
			width: 97px;
		}
		.block table tr td.date,
		.block table tr td.price {
			/*font-size: .6em;*/
			font-weight: bold;
		}
		.block table tr .single_price {
			width: 180px;
		}
	</style>
</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" class="table_header">
		<tbody>
			<tr class="top">
				<td width="200px">
					<span class="logo"><?=$GLOBALS['CONFIG']['invoice_logo_text']?></span>
				</td>
				<td align="center">
					<span class="invoice"><p style="font-size: 1.2em;">Ваш менеджер - <?=$Supplier['phones']?></p><br><p style="color: #f00;"><?=$GLOBALS['CONFIG']['Supplier_manager']?></p>
					</span>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="supplier"><?=$Supplier['name']?> - <?=$Supplier['article']?> - <?=$Supplier['place']?>
	<br><?=$Supplier['usd_products'] > 0?'Текущий курс: '.$Supplier['currency_rate']:null;?>
	</p>
	<?foreach($products as $i){?>
		<?$wh = "height=\"250\" width=\"250\"";?>
		<div class="block">
			<div class="description">
				<p><?=$i['name']?></p>
			</div>
			<table cellpadding="0" cellspacing="0">
				<tr class="min_price">
					<td colspan="3">
						<?if((isset($i['min_opt_price'])
							&& $i['price_opt_otpusk'] > 0
							&& $i['price_opt_otpusk'] > $i['min_opt_price'])
						|| (isset($i['min_mopt_price'])
							&& $i['price_mopt_otpusk'] > 0
							&& $i['price_mopt_otpusk'] > $i['min_mopt_price'])){?>
							<p style="color:#f00;">Товар заблокирован для продажи.<br> Рекомендованная цена: <?="<".($i['min_mopt_price']-0.01)." грн.";?></p>
						<?}?>
					</td>
				</tr>
				<tr class="art">
					<td colspan="3">Арт. <?=$i['art'];?><?if($i['product_limit'] > 0){?><p style="color: #0e0">Есть</p><?}else{?><p style="color: #e00">Нет</p><?}?></td>
				</tr>
				<tr class="header">
					<th class="date">Дата</th>
					<?if($Supplier['single_price'] == 1){?>
						<th class="single_price">от <?=$i['min_mopt_qty'] !== '0'?$i['min_mopt_qty']:null;?>, единая цена</th>
					<?}else{?>
						<th class="price">от <?=$i['min_mopt_qty'] !== '0'?$i['min_mopt_qty']:null;?></th>
						<th class="price">от <?=$i['inbox_qty'] !== '0'?$i['inbox_qty']:null;?></th>
					<?}?>
				</tr>
				<?for($a=1; $a < 5; $a++){?>
					<tr>
						<td class="date"><?=$a==1?date('d.m.Y'):null;?></td>
						<?if($Supplier['single_price'] == 1){?>
							<td class="price" colspan="2">
								<?if($a == 1){
									if($i['inusd'] == 1){?>
										<?=$i['price_mopt_otpusk'] !== '0'?number_format($i['price_mopt_otpusk_usd'], 2, ",", "").' $':null;?>
									<?}else{?>
										<?=$i['price_mopt_otpusk'] !== '0'?number_format($i['price_mopt_otpusk'], 2, ",", "").' грн':null;?>
									<?}
								}?>
							</td>
						<?}else{?>
							<td class="price">
								<?if($a == 1){
									if($i['inusd'] == 1){?>
										<?=$i['price_mopt_otpusk'] !== '0'?number_format($i['price_mopt_otpusk_usd'], 2, ",", "").' $':null;?>
									<?}else{?>
										<?=$i['price_mopt_otpusk'] !== '0'?number_format($i['price_mopt_otpusk'], 2, ",", "").' грн':null;?>
									<?}
								}?>
							</td>
							<td class="price">
								<?if($a == 1){
									if($i['inusd'] == 1){?>
										<?=$i['price_opt_otpusk'] !== '0'?number_format($i['price_opt_otpusk_usd'], 2, ",", "").' $':null;?>
									<?}else{?>
										<?=$i['price_opt_otpusk'] !== '0'?number_format($i['price_opt_otpusk'], 2, ",", "").' грн':null;?>
									<?}
								}?>
							</td>
						<?}?>
					</tr>
				<?}?>
			</table>
			<div class="photo">
				<?if(!empty($i['images'])){?>
					<img <?=$wh?> src="<?=_base_url;?><?=str_replace('/original/', '/medium/', $i['images'][0]['src'])?>" alt="<?=$i['name']?>">
				<?}else{?>
					<img <?=$wh?> src="<?=_base_url;?><?=str_replace("image/", "image/500/", $i['img_1'])?>"/>
				<?}?>
			</div>
		</div>
	<?}?>
</body>
</html>
