
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="http://xt/themes/default/css/fonts.css" rel="stylesheet">
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
			font-size: 22px;
			margin-bottom: 5px;
		}
		.prod_art {
			color: #9e9e9e;
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
			<!-- <img class="prod_img" src="http://xt.ua/product_images/original/2016/01/19/22145-1.jpg"> -->

			<?if(!empty($item['images'])){?>
				<img class="prod_img" src="<?=G::GetImageUrl($item['images'][0]['src'])?>"/>
			<?}else if(!empty($item['img_1'])){?>
				<img class="prod_img" src="<?=G::GetImageUrl($item['img_1'])?>"/>
			<?}else{?>
				<img class="prod_img" src="<?=G::GetImageUrl('/images/nofoto.png')?>"/>
			<?}?>

			<p class="prod_title"><?=$item['name']?> Радиоприёмник аналоговый KIPO KB-308АС (19,8х11х5,9 см, Китай)</p>
			<p class="prod_art">Артикул: <?=$item['art']?></p>

			<!-- <div class="price_wrap">
				<div class="price_cont price_flex <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null?>">
					<div class="price" itemprop="price" content="<?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ".", "");?>">
						<?=$in_cart?number_format($_SESSION['cart']['products'][$item['id_product']]['actual_prices'][$_COOKIE['sum_range']], 2, ",", ""):($item['price_opt'] > 0?number_format($item['price_opt']*$a[$_COOKIE['sum_range']], 2, ",", ""):'1,00');?>
					</div>
					<span class="bold_text"> грн.</span><span> / </span><span class="bold_text"><?=$item['units']?></span>
				</div>
				<?if (isset($product_mark) && $product_mark === 'action') {?>
					<div class="base_price_cont price_flex <?=isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] === _ACL_SUPPLIER_?'hidden':null;?>">
						<div class="base_price">
							<?if (!isset($_SESSION['cart']['products'][$item['id_product']]['quantity']) || ($_SESSION['cart']['products'][$item['id_product']]['quantity'] >= $item['inbox_qty'])){?>
								<?=number_format($item['base_prices_opt'][$_COOKIE['sum_range']], 2, ",", "")?>
							<?}else{?>
								<?=number_format($item['base_prices_mopt'][$_COOKIE['sum_range']], 2, ",", "")?>
							<?}?>
						</div>
						<span class="bold_text"> грн.</span><span> / </span><span class="bold_text"><?=$item['units']?></span>
					</div>
				<?}?>
			</div>
			 -->




			<div class="price_block">
				<p class="price curent_price">30.50<span> грн./шт.</span></p>
				<p class="price old_price">40.80<span> грн./шт.</span></p>
			</div>

			<div class="prod_qr_code">
				<img src="http://xt/themes/default/img/_xt.svg">
			</div>
		</div>
		<div class="footer">
			<div class="logo">
				<img src="http://xt/themes/default/img/_xt.svg">
			</div>
			<div class="contacts">
				<p>Служба снабжения Харьков Торг</p>
				<p>тел.: 0505953494, 0673211121</p>
				<p>www.xt.ua</p>
			</div>
		</div>
	</div>
</body>
</html>