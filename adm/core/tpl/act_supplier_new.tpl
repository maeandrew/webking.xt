<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Новый акт сверки цен поставщика</title>
	<style rel="stylesheet">
		* {
			margin: 0;
			padding: 0;
			font-family: "Trebuchet MS", Helvetica, sans-serif;
			font-size: 13px;
			box-sizing: border-box;
		}
		html {
			background: #fff;
		}
		.table_header {
			margin-left: 15px;
			width: 100%;
			max-height: 100px;
		}
		.table_header .top td {
			font-size: 14px;
		}
		.table_header .first_col {
			width: 90px;
		}
		.table_header .second_col {
			width: 325px;
		}
		.table_header .top span.invoice {
			margin-top: 20px;
			font-size: 18px;
			text-decoration: underline;
			line-height: 23px;
		}
		.logo {
			font-size: 38px;
			color: #00F;
			font-weight: bold;
		}
		p.supplier {
			font-size: 20pt;
			min-height: 200px;
			max-height: 200px;
		}
		.block {
			position: relative;
			background: #fff;
			border: 0;
			border-top: 1px solid #000;
			border-color: #5f5;
			width: 100%;
			display: block;
			color: #000;
			float: left;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			overflow: hidden;
			page-break-inside: avoid;
		}
		.block .title h4 {
			font-size: 1.5em;
			max-width: 90%;
			float: left;
		}
		.block .title h4.small {
			font-size: 1.2em;
		}
		.block .title div {
			font-size: 1.2em;
			min-width: 10%;
			float: right;
			text-align: right;
		}
		.block .title p {
			display: block;
			width: 100%;
			clear: both;
			float: left;
		}
		.block .photo {
			clear: both;
			float: left;
			min-width: 460px;
			display: inline-block;
			height: 100px;
		}
		.block .price {
			clear: right;
			float: right;
			height: 100px;
			width: 25%;
			padding-left: 1em;
		}
		.block .price table {
			width: 100%;
			border-collapse: collapse;
		}
		.block .price table td {
			border: 1px solid #ddd;
			height: 20px;
			text-align: center;
		}
		.block .price table tbody tr:last-of-type td {
			height: 60px;
			vertical-align: top;
		}
		.block .info_section {
			display: flex;
			clear: left;
			float: left;
			width: 100%;
		}
		.block .specifications {
			flex-basis: 30%;
			padding-right: 1em;
		}
		.block .specifications ol {
			margin-left: 30px;
		}
		.block .specifications li {
			border-bottom: 1px dashed #ddd;
		}
		.block .description {
			margin-top: 19px;
			flex-basis: 45%;
			border: 1px solid #ddd;
		}
		.block .description h4 {
			margin-top: -19px;
		}
		.block .info {
			font-size: .7em;
			flex-basis: 25%;
			padding-left: 1em;
			padding-top: 19px;
		}
		.block .info ul {
			list-style: none;
		}
		.block .info li {
			line-height: 1.5em;
		}
		.block .info li span {
			width: 40%;
			float: right;
			text-align: left;
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
	<?foreach($products as $k=>$i){?>
		<?$wh = "height=\"100\" width=\"100\"";?>
		<div class="block">
			<div class="title">
				<h4 <?=strlen($i['name']) > 70?' class="small"':null;?>><?=$i['name']?></h4>
				<div>Арт. <?=$i['art'];?></div>
				<p style="color: <?=$i['product_limit']>0?'#0e0':'#e00';?>"><?=$i['product_limit']>0?'Есть':'Нет';?> в наличии</p>
			</div>
			<div class="photo">
				<img <?=$wh?> src="<?=_base_url.htmlspecialchars(str_replace("/efiles/image/", "efiles/image/500/", $i['img_1']))?>"/>
				<?if(isset($i['img_2']) && $i['img_2'] != ''){?>
					<img <?=$wh?> src="<?=_base_url.htmlspecialchars(str_replace("/efiles/image/", "efiles/image/500/", $i['img_2']))?>"/>
				<?}?>
				<?if(isset($i['img_3']) && $i['img_3'] != ''){?>
					<img <?=$wh?> src="<?=_base_url.htmlspecialchars(str_replace("/efiles/image/", "efiles/image/500/", $i['img_3']))?>"/>
				<?}?>
			</div>
			<div class="price">
				<table cellpadding="0" cellspacing="0" border="0">
					<thead>
						<tr>
							<td>Цена розн.</td>
							<td>Цена опт.</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>от <?=$i['min_mopt_qty'] !== '0'?$i['min_mopt_qty']:null;?> <?=$i['unit']?> <?=$i['qty_control']==1?'*':null;?></td>
							<td>от <?=$i['inbox_qty'] !== '0'?$i['inbox_qty']:null;?> <?=$i['unit']?> <?=$i['qty_control']==1?'*':null;?></td>
						</tr>
						<tr>
							<td>
								<?if($i['inusd'] == 1){?>
									<?=$i['price_mopt_otpusk'] > 0 && isset($_POST['price'])?number_format($i['price_mopt_otpusk_usd'], 2, ",", "").' $':null;?>
								<?}else{?>
									<?=$i['price_mopt_otpusk'] > 0 && isset($_POST['price'])?number_format($i['price_mopt_otpusk'], 2, ",", "").' грн':null;?>
								<?}?>
							</td>
							<td>
								<?if($i['inusd'] == 1){?>
									<?=$i['price_opt_otpusk'] > 0 && isset($_POST['price'])?number_format($i['price_opt_otpusk_usd'], 2, ",", "").' $':null;?>
								<?}else{?>
									<?=$i['price_opt_otpusk'] > 0 && isset($_POST['price'])?number_format($i['price_opt_otpusk'], 2, ",", "").' грн':null;?>
								<?}?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="info_section">
				<div class="specifications">
					<h4>Характеристики:</h4>
					<ol>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ol>
				</div>
				<div class="description">
					<h4>Описание:</h4>
					<div class="text"><?=$i['descr']?></div>
				</div>
				<div class="info">
					<ul>
						<li>Ширина: <span><?=$i['width']>0?$i['width']:'____';?> см.</span></li>
						<li>Высота: <span><?=$i['height']>0?$i['height']:'____';?> см.</span></li>
						<li>Длина: <span><?=$i['length']>0?$i['length']:'____';?> см.</span></li>
						<li>Вес: <span><?=$i['weight']>0?$i['weight']:'____';?> кг.</span></li>
					</ul>
				</div>
			</div>
		</div>
	<?}?>
</body>
</html>
