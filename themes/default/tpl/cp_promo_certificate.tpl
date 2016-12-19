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
			font-family: "Roboto", Arial, sans-serif;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			color: #444;
			line-height: 1;
		}
		.main {
			width: 190mm;
			height: 277mm;
			margin: 0 auto;
			position: relative;
		}
		.flyer {
			border: 3mm solid #e7e7e7;
			display: flex;
			margin-bottom: 20mm;
			height: 79mm;
		}
		.flyer:last-of-type {
			margin-bottom: 0;
		}
		.flyer_header {
			text-align: center;
			width: 100%;
		}
		.flyer_title {
			color: #FF5722;
			text-transform: uppercase;
			font-size: 8mm;
		}
		.logo {
			max-width: 100%;
    		height: 12mm;
		}
		.company_title {
		    color: #018b06;
		}
		.site {
		    text-align: center;
		    margin-top: 3mm;
		    font-size: 1.2em;
		}
		.flyer_content,
		.promo_info {
			display: flex;
			flex-wrap: wrap;
		}
		.flyer_content {
			width: 30%;
			border-left: 1px solid #e7e7e7;
    		padding: 3mm;
		}
		.gift_prod {
			width: 70%;
			position: relative;
		}
		.gift_prod_descr {
			padding: 3mm;
		}
		.gift_prod_image {
			width: 35mm;
			float: left;
    		margin-right: 3mm;
		}
		.gift_prod img {
			margin: 0 auto;
    		display: block;
    		max-width: 100%;
		}
		.all_products_img {
			height: 40mm;
		}
		.gift_prod_name {
			margin-bottom: 3mm;
			margin-right: 3mm;
		}
		.gift_prod_name,
		.gift_prod_art {
			font-size: 4mm;
		}
		.promocode_block,
		.personal_consultant_block {
			width: 100%;
			display: flex;
			flex-wrap: wrap;
		}
		.personal_consultant_block {
			margin-bottom: 3mm;
		}
		.promocode_title,
		.personal_consultant_title,
		.personal_consultant_name,
		.personal_consultant_phone,
		.promocode {
			width: 100%;
			text-align: center;
		}
		.personal_consultant_name  {
			font-size: 1.3em;
		}
		.promocode {
    		font-size: 1.2em;
		    background: #018b06;
		    color: #fff;
		    letter-spacing: 0.1em;
		    font-weight: 500;
		    padding: 2mm;
		}
		.promocode_title {
			font-size: 1.2em;
		}
		.explanation {
    		position: absolute;
    		bottom: 0;
    		font-size: 2mm;
    		border-top: 1px solid #e7e7e7;
    		padding: 3mm;
		}
		.green {
			color: #018b06;
		}
		.gift_title {
			text-transform: uppercase;
    		font-size: 5mm;
    		margin-top: 3mm;
    		margin-bottom: 3mm;
		}
		.star {
			font-size: 0.8em;
		}
	</style>
</head>
<body>
	<div class="main">
		<?for($i = 0; $i < (isset($_REQUEST['share'])?1:3); $i++){?>
			<div class="flyer">
<<<<<<< HEAD
				<div class="gift_prod">
					<div class="gift_prod_descr">
						<p class="flyer_title">Подарочный сертификат</p>
						<p class="gift_title">При заказе на <span class="green">XT.UA получай подарок</span><sup class="star">*</sup></p>
						<img class="all_products_img" src="/images/assort.jpg">
						<!-- <div class="gift_prod_image">
							<img src="https://xt.ua/product_images/original/2016/01/19/22145-1.jpg">
						</div>
						<div class="gift_prod_name">
							Радиоприёмник аналоговый KIPO KB-308АС (19,8х11х5,9 см, Китай)
						</div>
						<div class="gift_prod_art">
							Артикул: <span>22145</span>
						</div> -->
					</div>
					<div class="explanation">
						* Под подарком подразумевается покупка товара за 0,01 грн. Для получения подарка необходимо применить промо-код в корзине сайта при оформлении заказа. Подарок доступен только при первом заказе.
					</div>
				</div>
				<div class="flyer_content">
					<div class="flyer_header">
						<img class="logo" src="/themes/default/img/_xt.svg">
						<p class="company_title">Служба снабжения ХарьковТорг</p>
						<p class="site">www.xt.ua</p>
					</div>
					<div class="promo_info">
						<div class="personal_consultant_block">
							<p class="personal_consultant_title">Ваш консультант:</p>
							<p class="personal_consultant_name"><?=$customer['first_name']?></p>
							<p class="personal_consultant_phone">+<?=$user['phone']?></p>
						</div>
						<div class="promocode_block">
							<p class="promocode_title">промо-код:</p>
							<p class="promocode">AG<?=$user['id_user']?></p>
						</div>
					</div>
				</div>
			</div>
		<?}?>
	</div>
</body>
</html>