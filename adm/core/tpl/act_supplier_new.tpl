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
		.block.odd {
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
			height: 60px;
			border-top: 0;
		}
		.block table tr th,
		.block table tr td {
			border: 1px solid #ccc;
			text-align: center;
			font-weight: normal;
			font-size: 12pt;
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
		.block table tr .info {
			width: 50px;
		}
		.block table tr .quantity {
			position: relative;
			width: 84px;
		}
		.block table tr .price {
			position: relative;
			width: 150px;
		}
		.block table tr .quantity p,
		.block table tr .price p {
			color: #e00;
			position: relative;
			margin-top: 40px;
			width: 100%;
			font-size: 12pt;
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


	<?$ii=1;
	$price = false;
	if(isset($_GET['show_prod_price']) && $_GET['show_prod_price'] == 'true'){
		$price = true;
	}?>
	<?foreach ($products as $i){?>
		<?$wh = "height=\"250\" width=\"250\"";?>
		<div class="block <?if(($ii%2) == 0){?>odd<?}?>">
			<div class="description">
				<p><?=$i['name']?></p>
			</div>
			<table cellpadding="0" cellspacing="0">
				<?if($price === true){?>
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
				<?}?>
				<tr class="art">
					<td colspan="3">Арт. <?=$i['art'];?><?if($i['active'] == 1){?><p style="color: #0e0">Есть</p><?}else{?><p style="color: #e00">Нет</p><?}?></td>
				</tr>
				<tr class="header">
					<td class="info"></td>
					<td class="quantity">кол-во</td>
					<td class="price">цена</td>
				</tr>
				<tr>
					<td class="info">мин.</td>
					<td class="quantity"><p><?=$i['min_mopt_qty'] != 0?$i['min_mopt_qty']:null;?></p></td>
					<td class="price">
						<p>
							<?if($price === true){
								if($i['inusd'] == 1){?>
									<?=$i['price_mopt_otpusk'] != 0?number_format($i['price_mopt_otpusk_usd'], 2, ",", "").' $':null;?>
								<?}else{?>
									<?=$i['price_mopt_otpusk'] != 0?number_format($i['price_mopt_otpusk'], 2, ",", "").' грн':null;?>
								<?}
							}?>
						</p>
					</td>
				</tr>
				<tr>
					<td class="info">ящ.</td>
					<td class="quantity"><p><?=$i['inbox_qty'] != 0?$i['inbox_qty']:null;?></p></td>
					<td class="price">
						<p>
							<?if($price === true){
								if($i['inusd'] == 1){?>
									<?=$i['price_opt_otpusk'] != 0?number_format($i['price_opt_otpusk_usd'], 2, ",", "").' $':null;?>
								<?}else{?>
									<?=$i['price_opt_otpusk'] != 0?number_format($i['price_opt_otpusk'], 2, ",", "").' грн':null;?>
								<?}
							}?>
						</p>
					</td>
				</tr>
			</table>
			<div class="photo">
				<?if(!empty($i['images'])){?>
					<img <?=$wh?> src="<?=G::GetImageUrl($i['images'][0]['src'], 'medium')?>" alt="<?=$i['name']?>">
				<?}else{?>
					<img <?=$wh?> src="<?=G::GetImageUrl($i['img_1'], 'medium')?>"/>
				<?}?>
			</div>
		</div>
	<?$ii++;}?>
</body>
</html>