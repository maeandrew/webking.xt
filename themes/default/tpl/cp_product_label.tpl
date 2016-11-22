
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="/themes/default/css/fonts.css" rel="stylesheet">
	<style>
		* {
			padding: 0px;
			margin: 0px;
			font-family: Arial, sans-serif;
		}
		.main {
			width: 700px;
			height: 1030px;
			margin: 0px auto;
			position: relative;
		}
		.prod_img {
			width: 100%;
			margin-bottom: 20px;
		}
		.prod_title {
			font-size: 26px;
			margin-bottom: 5px;
		}
		.prod_art {
			color: #9e9e9e;
			font-size: 18px;
		}
		.price_block {
			padding-top: 50px;
			padding-bottom: 50px;
			text-align: center;
		}
		.price {
			font-size: 60px;
			display: inline-block;
			font-family: 'Oswald', sans-serif;
		}
		.price span {
			font-size: 0.7em;
			font-weight: bold;
		}
		.curent_price {
			color: #018b06;
		}
		.old_price {
			color: #9e9e9e;
			font-size: 30px;
			position: relative;
			margin-left: 20px;
		}
		.old_price:before {
			content: '';
		    display: block;
		    position: absolute;
		    top: 18px;
		    left: -6px;
		    width: 110%;
		    height: 2px;
		    background: #018b06;
		    -ms-transform: rotate(12deg);
		    -webkit-transform: rotate(12deg);
		    transform: rotate(-12deg);
		}
		.prod_qr_code img {
			height: 100px;
			width: 100px;
			border: 1px solid #eee;
			float: right;
			clear: both;
		}
		.footer {
			position: absolute;
			padding-top: 20px;
			bottom: 0;
			left: 0;
			right: 0;
			border-top: 1px solid #eee;
		}
		.logo {
			width: 20%;
			float: left;
		}
		.logo img {
			width: 100%;
		}
		.contacts {
			width: 100%;
			text-align: right;
		}
	</style>
</head>
<body>
	<div class="main">
		<div class="content">
			<?if(!empty($product['images'])){?>
				<img class="prod_img" src="<?=G::GetImageUrl($product['images'][0]['src'])?>"/>
			<?}else if(!empty($product['img_1'])){?>
				<img class="prod_img" src="<?=G::GetImageUrl($product['img_1'])?>"/>
			<?}else{?>
				<img class="prod_img" src="<?=G::GetImageUrl('/images/nofoto.png')?>"/>
			<?}?>
			<p class="prod_title"><?=$product['name']?></p>
			<p class="prod_art">Артикул: <?=$product['art']?></p>
			<?$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['opt_correction_set']]);
				if(in_array($product['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($product['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
					$product_mark = 'action';}?>
			<div class="price_block">
				<p class="price curent_price"><?=($product['price_opt'] > 0?number_format($product['price_opt']*$a[$_COOKIE['sum_range']], 2, ",", ""):'1,00');?><span> грн./<?=$product['units']?></span></p>
				<?if (isset($product_mark) && $product_mark === 'action') {?>
					<p class="price old_price">
						<?if (!isset($_SESSION['cart']['products'][$product['id_product']]['quantity']) || ($_SESSION['cart']['products'][$product['id_product']]['quantity'] >= $product['inbox_qty'])){?>
							<?=number_format($product['base_prices_opt'][$_COOKIE['sum_range']], 2, ",", "")?>
						<?}else{?>
							<?=number_format($product['base_prices_mopt'][$_COOKIE['sum_range']], 2, ",", "")?>
						<?}?>
						<span> грн./<?=$product['units']?></span>
					</p>
				<?}?>
			</div>
			<div class="prod_qr_code">
				<img src="http://chart.apis.google.com/chart?cht=qr&chs=100x100&chl=<?=Link::Product($product['translit'])?>&chld=H|0">
			</div>
		</div>
		<div class="footer">
			<div class="logo">
				<img src="http://xt/themes/default/img/_xt.svg">
			</div>
			<div class="contacts">
				<p>Служба снабжения Харьков Торг</p>
				<p>тел.: 0505953494, 0673211121</p>
				<p>сайт: xt.ua</p>
			</div>
		</div>
	</div>
</body>
</html>