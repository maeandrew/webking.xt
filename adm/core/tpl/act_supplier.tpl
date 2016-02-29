<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Акт сверки цен поставщика</title>
<style>
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,
pre,form,label,fieldset,img,input,textarea,p,
blockquote,th,td {
	margin: 0;
	padding: 0;
	border: 0;
	outline: 0;
	font-size: 100%;
	vertical-align: baseline;
}
:focus {
	outline: 0;
}
html,
body {
	height: 100%;
}
body {
	font-family: Helvetica, sans-serif;
	font-size: 12px; color: #333;
}


.undln {
	text-decoration: underline;
}
.table_header {
	margin-left: 3px;
	width: 800px;
}
.table_header .top td {
	font-size: 14px;
}
.table_header .first_col {
	width: 180px;
}
.table_header .second_col {
	width: 325px;
}
.table_header .top span.invoice {
	padding: 0;
	margin-left: 20px;
	font-size: 15px;
	text-decoration: underline;
}
.logo {
	font-size: 38px;
	color: #00F;
	font-weight: bold;
}
.bl { border-left: 1px solid #000; }
.br { border-right: 1px solid #000; }
.bt { border-top: 1px solid #000; }
.bb { border-bottom: 1px solid #000 !important; }
.bn { border: none !important; }

.bnb { border-bottom: none !important; }

.blf { border-left: 1px solid #FFF; }
.brf { border-right: 1px solid #FFF; }
.bbf { border-bottom: 1px solid #FFF; }

.table_main {
	margin: 10px 0 0 1px;
}
.table_main td {
	padding: 1px 1px 0;
	font-size: 12px;
	text-align: center;
	border-right: 1px #000 solid;
	border-bottom: 1px #000 solid;
	vertical-align: middle;
}
.table_main td.name {
	padding: 1px;
	font-size: 12px;
	text-align: left;
	border-right: 1px #000 solid;
	border-bottom: 1px #000 solid;
}
.table_main .hdr td {
	font-weight: bold;
	padding: 1px;
}
.table_main .main td {
	height: 50px;
}
.table_main .main td.img {
	width: 56px;
}
.table_sum {
	margin: 10px 0 0 1px;
}
.table_sum td {
	padding: 1px 1px 0;
	font-size: 12px;
	text-align: center;
	vertical-align: middle;
}
.table_sum td.name {
	padding: 1px;
	font-size: 12px;
	text-align: left;
}
tr.min td {
	height: 1px;
	font-size: 1px;
	line-height: 1px;
	margin: 0px;
	padding: 0px;
}
.aright {
	text-align: right;
}
.red {
	color: #ff0000;
}
.green {
	color: #008000;
}
.blue {
	color: #0000ff;
}
td.c5,
td.c8 {
	font-size: 1.2em !important;
}
</style>
</head>
<body>
	<table border="0" cellpadding="0" cellspacing="0" class="table_header">
		<tr class="top">
			<td width="200px">
				<span class="logo"><?=$GLOBALS['CONFIG']['invoice_logo_text']?></span>
			</td>
			<td class="invoice_info" align="center">
				<span class="invoice">Ваш менеджер - <?=$Supplier['phones']?><br><p class="color-red"><?=$GLOBALS['CONFIG']['Supplier_manager']?></span>
			</td>
		</tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" class="table_header">
		<tbody>
			<col width="50%">
			<col width="50%">
			<tr class="top">
				<td>Поставщик: <?=$Supplier['name']?> - <?=$Supplier['article']?>
					<br><?=$Supplier['place']?>
					<br><?=$Supplier['usd_products'] > 0?'Текущий курс: '.$Supplier['currency_rate']:null;?>
				</td>
			</tr>
			<tr>
				<td colspan=2 class="aright">Рабочие дни - <?for($ii=1;$ii<32;$ii++){echo "{$ii} ";}?></td>
			</tr>

		</tbody>
	</table>
	<?
	$c1 = 60;
	$c2 = 260;
	$c3 = 70;
	$c4 = 50;
	$c5 = 75;
	$c6 = 70;
	$c7 = 50;
	$c8 = 75;
	$c9 = 70;
	?>
	<table border="0" cellpadding="0" cellspacing="0" class="table_main">
		<col width="<?=$c1?>">
		<col width="<?=$c2?>">
		<col width="<?=$c3?>">
		<col width="<?=$c4?>">
		<col width="<?=$c5?>">
		<col width="<?=$c6?>">
		<col width="<?=$c7?>">
		<col width="<?=$c8?>">
		<col width="<?=$c9?>">
		<tbody>
			<tr class="hdr">
				<td rowspan="2" class="bl bt">Фото</td>
				<td rowspan="2" class="bt">Название</td>
				<td rowspan="2" class="bt">Остатки<br>товара</td>
				<td colspan="3" class="bt">Крупный опт, от ящика</td>
				<td colspan="3" class="bt">Мелкий опт, от мин. к-ва</td>
			</tr>
			<tr class="hdr">
				<td>Кол-во<br>в ящике</td>
				<td>Цена отпускная,<br><span class="red">грн.</span> / <span class="green">$</span></td>
				<td>грн</td>
				<td>Мин <br>кол-во</td>
				<td>Цена отпускная,<br><span class="red">грн.</span> / <span class="green">$</span></td>
				<td>грн</td>
			</tr>
		</tbody>
	</table>
	<?$ii=1;
	foreach ($products as $i){
	$wh = "height=\"48\" width=\"48\"";?>
		<table border="0" cellpadding="0" cellspacing="0" class="table_main" style="margin-top: 0px;">
			<col width="<?=$c1?>">
			<col width="<?=$c2?>">
			<col width="<?=$c3?>">
			<col width="<?=$c4?>">
			<col width="<?=$c5?>">
			<col width="<?=$c6?>">
			<col width="<?=$c7?>">
			<col width="<?=$c8?>">
			<col width="<?=$c9?>">
			<tbody>
				<tr class="main">
					<td class="bl c1">
						<?if(!empty($i['images'])){?>
							<img <?=$wh?> src="<?=_base_url?><?=htmlspecialchars(str_replace("/original/", "/medium/", $i['images'][0]['src']))?>">
							<!-- <img <?=$wh?> src="<?=file_exists($GLOBALS['PATH_root'].str_replace("/original/", "/medium/", $i['images'][0]['src']))?_base_url.htmlspecialchars(str_replace("/original/", "/medium/", $i['images'][0]['src'])):'/efiles/_thumb/nofoto.jpg'?>"> -->
						<?}else{?>
							<img <?=$wh?> src="<?=_base_url?><?=htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/250/", $i['img_1']))?>"/>
							<!-- <img <?=$wh?> src="<?=$GLOBALS['URL_base'].htmlspecialchars(str_replace("/efiles/image/", "/efiles/image/250/", $i['img_1']))?>"/> -->
						<?}?>
					</td>
					<td class="name c2">
						<?=$i['name']?>
						<p>Арт.<?=$i['art']?></p>
						<?if((isset($i['min_opt_price']) == true && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'] > $i['min_opt_price']) || (isset($i['min_mopt_price']) == true && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > 0 && $_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'] > $i['min_mopt_price'])){?>
							<p class="color-red">Товар заблокирован для продажи.<br> Рекомендованная цена: <?="<".($i['min_mopt_price']-0.01)." грн.";?></p>
						<?}?>
					</td>
					<td class="blue"><?=$i['product_limit'] > 0?round($i['product_limit'], 2):null;?></td>
					<td class="c4"><?=$i['inbox_qty']?></td>
					<?if($i['inusd'] == 1){?>
						<td class="green c5"><?=$i['price_opt_otpusk'] > 0?number_format($i['price_opt_otpusk'], 2, ",", "").' $':null;?></td>
					<?}else{?>
						<td class="red c5"><?=$i['price_opt_otpusk'] > 0?number_format($i['price_opt_otpusk'], 2, ",", ""):null;?></td>
					<?}?>
					<td class="c6" style="padding-top: 30px;"></td>
					<td class="c7"><?=$i['min_mopt_qty']?></td>
					<?if($i['inusd'] == 1){?>
						<td class="green c8"><?=$i['price_mopt_otpusk'] > 0?number_format($i['price_mopt_otpusk'], 2, ",", "").' $':null;?></td>
					<?}else{?>
						<td class="red c8"><?=$i['price_mopt_otpusk'] > 0?number_format($i['price_mopt_otpusk'], 2, ",", ""):null;?></td>
					<?}?>
					<td style="padding-top: 30px;"></td>
				</tr>
			</tbody>
		</table>
	<?}?>
</body>
</html>