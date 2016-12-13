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
			font-family: "Helvetica", Arial, sans-serif;
		}
		.main {
			width: 700px;
			height: 1030px;
			margin: 0 auto;
			position: relative;
		}
		.flyer {
			border: 1px dashed #dcdcdc;
			padding: 10px;
		}
		.flyer_header {
			text-align: center;
		}
		.flyer_title {
			color: #FF5722;
		}
		.logo {
			margin-top: 10px;
		}
		.logo img {
    		float: left;
    		height: 50px;
    		margin-left: 100px;
		}
		.site {
			font-size: 50px;
    		line-height: 50px;
    		text-align: right;
    		margin-right: 100px;
    		font-weight: bold;
		}
		.company_title {
			clear: both;
		    padding-top: 5px;
		    padding-bottom: 5px;
		    color: #018b06;
		    font-weight: bold;
		    text-align: left;
		    padding-left: 40px;
		    font-size: 16px;
		}
		.flyer_content,
		/* .gift_prod, */
		.promo_info {
			display: flex;
			flex-wrap: wrap;
		}
		.gift_prod {
			width: 60%;
			padding-top: 5px;
		}
		.gift_prod_image {
			width: 50%;
			float: left;
    		margin-right: 10px;
		}
		.gift_prod img {
			height: 150px;
			margin: 0 auto;
    		display: block;
		}
		.gift_prod_name {
			margin-bottom: 10px;
			margin-right: 10px;
			max-height: 90px;
    		overflow: hidden;
		}
		.flyer_info {
			width: 40%;
			font-size: 12px;
		}
		.flyer_info p {
			padding-bottom: 5px;
		}
		.advantages {
			border-bottom: 1px solid #dcdcdc;
			padding-bottom: 10px;
		}
		.promo_info {
			padding-top: 10px;
		}
		.promocode_block,
		.personal_consultant_block {
			width: 100%;
			font-size: 16px;
		}
		.personal_consultant_title {
			font-size: 12px;
		}
		.promocode_title {
			width: 85px;
			float: left;
    		line-height: 28px;
		}
		.personal_consultant_name {
			font-weight: bold;
			float: left;
    		margin-right: 5px;
		}
		.promocode {
			font-weight: bold;
    		font-size: 24px;
		}

	</style>
</head>
<body>
	<div class="main">
		<?for($i = 0; $i < (isset($_REQUEST['share'])?1:3); $i++){?>
			<div class="flyer">
				<div class="flyer_header">
					<h2 class="flyer_title">Подарочный сертификат на первый заказ</h2>
					<div class="logo">
						<img src="/themes/default/img/_xt.svg">
						<p class="site">xt.ua</p>
					</div>
					<p class="company_title">Служба снабжения ХарьковТорг</p>
				</div>
				<div class="flyer_content">
					<div class="gift_prod">
						<!-- <img src="/images/assort.jpg"> -->
						<div class="gift_prod_image">
							<img src="https://xt.ua/product_images/original/2016/01/19/22145-1.jpg">
						</div>
						<div class="gift_prod_name">
							Радиоприёмник аналоговый KIPO KB-308АС (19,8х11х5,9 см, Китай) Радиоприёмник аналоговый KIPO KB-308АС (19,8х11х5,9 см, Китай) Радиоприёмник аналоговый KIPO KB-308АС (19,8х11х5,9 см, Китай)
						</div>
						<div class="gift_prod_art">
							Артикул: <span>22145</span>
						</div>
					</div>
					<div class="flyer_info">
						<div class="advantages">
							<p>Минимальный заказ 100 грн.</p>
							<p>Бесплатная доставка по Украине</p>
							<p>Оптовые скидки до 50% от XT.UA</p>
							<p>Обмен и возврат товара в течении 14 дней</p>
							<p>Вместе дешевле! Совместные покупки (СП)</p>
						</div>
						<div class="promo_info">
							<div class="personal_consultant_block">
								<p class="personal_consultant_title">Ваш личный консультант</p>
								<p class="personal_consultant_name"><?=$customer['first_name']?></p><span>тел. <?=$user['phone']?></span>
							</div>
							<div class="promocode_block">
								<p class="promocode_title">Промокод:</p>
								<p class="promocode">AG<?=$user['id_user']?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?}?>
	</div>
</body>
</html>