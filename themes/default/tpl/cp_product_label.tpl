<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/themes/default/min/css/fonts.min.css">
	<style>
		* {
			padding: 0;
			margin: 0;
			font-family: Arial, sans-serif;
		}
		.main {
			width: 700px;
			height: 1030px;
			margin: 0 auto;
			position: relative;
		}
		.image_wrap {
			height: 50vh;
			line-height: 50vh;
			text-align: center;
		}
		.prod_img {
			max-width: 100%;
			max-height: 50vh;
			margin-bottom: 20px;
			display: inline-block;
			vertical-align: middle;
			margin: 0;
		}
		.prod_title {
			color: #7b7b7b;
			font-size: 22px;
			margin-bottom: 5px;
			margin-top: 10px;
			text-overflow: ellipsis;
			overflow: hidden;
			position: relative;
			max-height: 2.4em;
		}
		.prod_title::after {
			content: '';
			display: block;
			position: absolute;
			bottom: 0;
			right: 0;
			width: 20%;
			height: 1.2em;
			background-image: -webkit-linear-gradient(left, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1) 50%);
			background-image: -o-linear-gradient(left, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1) 50%);
			background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1) 50%);
		}
		.prod_art {
			font-size: 16px;
			text-align: right;
		}
		.prod_art span {
			font-size: 2em;
			font-weight: bold;
		}
		.price_block {
			padding-top: 25px;
			padding-bottom: 25px;
			text-align: center;
		}
		.price {
			font-size: 90px;
			display: inline-block;
			font-family: 'Oswald', sans-serif;
		}
		.price span {
			font-size: 0.3em;
			font-weight: bold;
		}
		.curent_price {
			color: #FF5722;
		}
		.old_price {
			color: #9e9e9e;
			font-size: 35px;
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
			background: #FF5722;
			-ms-transform: rotate(12deg);
			-webkit-transform: rotate(12deg);
			transform: rotate(-12deg);
		}
		.gift_block {
			height: 140px;
			display: flex;
			border: 2px solid #FF5722;
		}
		.gift_title {
			width: 100%;
			padding-bottom: 10px;
			font-size: 26px;
			color: #FF5722;
		}
		.gift_image_wrap {
			padding: 10px;
			line-height: 120px;
			text-align: center;
		}
		.gift_img {
			width: 120px;
			height: 120px;
			vertical-align: middle;
			display: inline-block;
		}
		.gift_descr {
			padding: 10px;
		}
		.gift_name {
			font-size: 18px;
			max-height: 44px;
			overflow: hidden;
		}
		.gift_art {
			color: #505050;
			font-size: 15px;
			padding-top: 10px;
		}
		.footer {
			position: absolute;
			padding-top: 10px;
			bottom: 0;
			left: 0;
			right: 0;
			border-top: 1px solid #eee;
			display: flex;
		}
		.logo {
			width: 20%;
			margin-top: 10px;
		}
		.logo img {
			width: 100%;
		}
		.logo p {
			font-size: .9em; text-align: center; display: block;
		}
		.contacts {
			width: calc(80% - 100px);
			text-align: center;
			line-height: 30px;
			font-size: 20px;
			padding: 10px 10%;
			box-sizing: border-box;
		}
		.contacts .site {
			float: left;
			line-height: 70px;
			font-size: 3em;
			font-weight: bold;
		}
		.contacts .phones {
			float: right;
			font-size: 0.8em;
			line-height: 1.3em;
		}
		.prod_qr_code img {
			height: 100px;
			width: 100px;
			border: 1px solid #eee;
			margin: 0 auto;
			display: block;
			box-sizing: border-box;
		}
	</style>
</head>
<body>
	<div class="main">
		<div class="content">
			<div class="image_wrap">
				<?if(!empty($product['images'])){?>
					<img class="prod_img" src="<?=G::GetImageUrl($product['images'][0]['src'])?>"/>
				<?}else if(!empty($product['img_1'])){?>
					<img class="prod_img" src="<?=G::GetImageUrl($product['img_1'])?>"/>
				<?}else{?>
					<img class="prod_img" src="<?=G::GetImageUrl('/images/nofoto.png')?>"/>
				<?}?>
			</div>
			<p class="prod_art">Артикул: <span><?=$product['art']?></span></p>
			<p class="prod_title"><?=$product['name']?></p>
			<?$a = explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['opt_correction_set']]);
				if(in_array($product['opt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set']) || in_array($product['mopt_correction_set'], $GLOBALS['CONFIG']['promo_correction_set'])) {
					$product_mark = 'action';}?>
			<div class="price_block">
				<p class="price curent_price"><?=($product['price_mopt'] > 0?number_format($product['price_mopt']*$a[$_COOKIE['sum_range']], 2, ",", ""):'1,00');?><span> грн./<?=$product['units']?></span></p>
				<?if (isset($product_mark) && $product_mark === 'action') {?>
					<p class="price old_price">
						<?if (!isset($_SESSION['cart']['products'][$product['id_product']]['quantity']) || ($_SESSION['cart']['products'][$product['id_product']]['quantity'] >= $product['inbox_qty'])){?>
							<?=number_format($product['base_prices_opt'][$_COOKIE['sum_range']], 2, ",", "")?>
						<?}else{?>
							<?=number_format($product['base_prices_mopt'][$_COOKIE['sum_range']], 2, ",", "")?>
						<?}?>
						<span> грн.</span>
					</p>
				<?}?>
			</div>
			<?if(isset($gift)){?>
				<div class="gift_block">
					<div class="gift_descr">
					<p class="gift_title">+ ПОДАРОК</p>
						<p class="gift_name"><?=$gift['name']?></p>
						<p class="gift_art">Артикул: <?=$gift['art']?></p>
					</div>
					<div class="gift_image_wrap">
						<?if(!empty($gift['images'])){?>
							<img class="gift_img" src="<?=G::GetImageUrl($gift['images'][0]['src'],'medium')?>"/>
						<?}else if(!empty($gift['img_1'])){?>
							<img class="gift_img" src="<?=G::GetImageUrl($gift['img_1'],'medium')?>"/>
						<?}else{?>
							<img class="gift_img" src="<?=G::GetImageUrl('/images/nofoto.png')?>"/>
						<?}?>
					</div>
				</div>
			<?}?>
		</div>
		<div class="footer">
			<div class="logo">
				<img src="/themes/default/img/_xt.svg">
				<p>Служба снабжения ХарьковТОРГ</p>
			</div>
			<div class="contacts">
				<p class="site">xt.ua</p>
				<div class="phones">
					Контакты:
					<p>(050) 309-84-20</p>
					<p>(067) 574-10-13</p>
					<p>(063) 425-91-83</p>
				</div>
			</div>
			<div class="prod_qr_code">
				<img src="http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=<?=Link::Product($product['translit'])?>&chld=H|0">
			</div>
		</div>
	</div>
</body>
</html>