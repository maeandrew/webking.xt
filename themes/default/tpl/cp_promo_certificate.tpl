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
		.cagories,
		.flyer_footer {
			display: flex;
			flex-wrap: wrap;
		}
		.flyer_content {
			/*border-bottom: 1px solid #dcdcdc;*/
		}
		.cagories {
			width: 60%;
		}
		.cagories img {
			height: 150px;
			/*margin-left: -80px;*/
		}
		.flyer_info {
			width: 40%;
			font-size: 12px;
		}
		.flyer_info p {
			padding-bottom: 5px;
		}
		.cagories p {
			/* width: calc(50% - 10px);
			padding: 5px;
			text-align: center; */
			width: 50%;
		}
		.flyer_footer {
			/*margin-top: 10px;*/
			/*padding-bottom: 10px;*/
			padding-top: 5px;
    		/*border-top: 1px solid #dcdcdc;*/
		}
		.promocode_block {
			width: 40%;
		}
		.personal_consultant_block {
			width: 60%;
		}
		.personal_consultant_title {
			font-size: 12px;
		}
		.promocode_block p {
			margin-left: 5px;
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
				<div class="cagories">
					<img src="/images/assort.jpg">
				</div>
				<div class="flyer_info">
					<p>Минимальный заказ 100 грн.</p>
					<p>Бесплатная доставка по Украине</p>
					<p>Оптовые скидки до 50% от XT.UA</p>
					<p>Обмен и возврат товара в течении 14 дней</p>
					<p>Вместе дешевле! Совместные покупки (СП)</p>
				</div>
			</div>
			<div class="flyer_footer">
				<div class="personal_consultant_block">
					<p class="personal_consultant_name">Александр</p><span>+38 (063) 2545655</span>
					<p class="personal_consultant_title">Ваш личный консультант:</p>
				</div>
				<div class="promocode_block">
					<p class="promocode_title">Промокод:</p>
					<p class="promocode">AG123456</p>
				</div>
			</div>
		</div>
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
				<div class="cagories">
					<img src="/images/assort.jpg">
				</div>
				<div class="flyer_info">
					<p>Минимальный заказ 100 грн.</p>
					<p>Бесплатная доставка по Украине</p>
					<p>Оптовые скидки до 50% от XT.UA</p>
					<p>Обмен и возврат товара в течении 14 дней</p>
					<p>Вместе дешевле! Совместные покупки (СП)</p>
				</div>
			</div>
			<div class="flyer_footer">
				<div class="personal_consultant_block">
					<p class="personal_consultant_name">Александр</p><span>+38 (063) 2545655</span>
					<p class="personal_consultant_title">Ваш личный консультант:</p>
				</div>
				<div class="promocode_block">
					<p class="promocode_title">Промокод:</p>
					<p class="promocode">AG123456</p>
				</div>
			</div>
		</div>
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
				<div class="cagories">
					<img src="/images/assort.jpg">
				</div>
				<div class="flyer_info">
					<p>Минимальный заказ 100 грн.</p>
					<p>Бесплатная доставка по Украине</p>
					<p>Оптовые скидки до 50% от XT.UA</p>
					<p>Обмен и возврат товара в течении 14 дней</p>
					<p>Вместе дешевле! Совместные покупки (СП)</p>
				</div>
			</div>
			<div class="flyer_footer">
				<div class="personal_consultant_block">
					<p class="personal_consultant_name">Александр</p><span>+38 (063) 2545655</span>
					<p class="personal_consultant_title">Ваш личный консультант:</p>
				</div>
				<div class="promocode_block">
					<p class="promocode_title">Промокод:</p>
					<p class="promocode">AG123456</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>