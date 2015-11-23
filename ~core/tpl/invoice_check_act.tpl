<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Проверочная накладная соответствия</title>
	<style rel="stylesheet">
		* {
			margin: 0;
			padding: 0;
			font-family: "Trebuchet MS", Helvetica, sans-serif;
			font-size: 12px;
			box-sizing: border-box;
		}
		html {
			background: #fff;
		}
		.table_header {
			margin-left: 15px;
			width: 100%;
		}
		.table_header .first_col {
			width: 90px;
		}
		.table_header .second_col {
			width: 325px;
		}
		.table_header .top span.invoice {
			margin-top: 20px;
			font-size: 1.1wm;
			text-decoration: underline;
			line-height: 23px;
		}
		.logo {
			font-size: 3em;
			color: #00F;
			font-weight: bold;
		}
		p.supplier {
			font-size: 1.5em;
			min-height: 100px;
			max-height: 100px;
		}
		.block {
			position: relative;
			background: #fff;
			border: 0;
			border-top: 1px solid #000;
			border-color: #5f5;
			width: 100%;
			max-height: 240px;
			display: block;
			color: #000;
			float: left;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			overflow: hidden;
			page-break-inside: avoid;
			clear: both;
			margin-bottom: auto;
		}
		.block:nth-of-type(n+4) {
			page-break-after: always;
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
		.block .photo {
			clear: both;
			float: left;
			min-width: 460px;
			display: inline-block;
			height: 120px;
		}
		.block .price {
			clear: right;
			float: right;
			height: 120px;
			width: 25%;
			padding-left: 1em;
		}
		.block .price table {
			width: 100%;
			border-collapse: collapse;
		}
		.block .price table td {
			border: 1px solid #ddd;
			height: 25px;
			text-align: center;
		}
		.block .price table tbody tr:last-of-type td {
			height: 70px;
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
		.block .specifications li {
			border-bottom: 1px dashed #ddd;
		}
		.block .description {
			flex-basis: 55%;
		}
		.block .description .text {
			font-size: 9px;
		}
		.block .info {
			font-size: .7em;
			flex-basis: 15%;
			padding-left: 1em;
		}
		.block .info ul {
			list-style: none;
		}
		.block .info li {
			line-height: 1.5em;
			clear: both;
		}
		.block .info li span {
			width: 50%;
			display: block;
			float: right;
			text-align: left;
			border-bottom: 1px dashed #bbb;
		}
	</style>
</head>
<body>
	<?foreach($products as $k=>$i){?>
		<?$wh = 'height="120" width="120"';?>
		<div class="block">
			<div class="title">
				<h4 <?=strlen($i['name']) > 70?' class="small"':null;?>><?=$i['name']?></h4>
				<div style="color: <?=$i['product_limit']>0?'#0e0':'#e00';?>">заказ: <?=$i['id_order']?>; <?=$i['article']?'пост. '.$i['article'].';':'';?> арт. <?=$i['art'];?></div>
			</div>
			<div class="photo">
				<?if(!empty($i['images'])){
					foreach($i['images'] as $key => $image){?>
						<img <?=$wh?> src="<?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'medium', $image['src']))?_base_url.str_replace('original', 'medium', $image['src']):'/efiles/_thumb/nofoto.jpg'?>" alt="<?=$i['name']?>"<?=$key==0?' class="active_img"':null;?>>
					<?}
				}else{
					for($key=1; $key < 4; $key++){
						if(!empty($i['img_'.$key])){?>
							<img <?=$wh?> src="<?=file_exists($GLOBALS['PATH_root'].$i['img_'.$key])?_base_url.str_replace("/efiles/image/", "/efiles/image/500/", $i['img_'.$key]):'/efiles/_thumb/nofoto.jpg'?>" alt="<?=$i['name']?>"<?=$key==1?' class="active_img"':null;?>>
						<?}
					}
				}?>
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
							<td>от <?=$i['inbox_qty'] !== '0'?$i['inbox_qty']:null;?> <?=$i['unit']?> <?=$i['qty_control']==1?'*':null;?><input type="checkbox"></td>
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
					<ul>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</div>
				<div class="description">
					<div class="text"><?=$i['descr']?></div>
				</div>
				<div class="info">
					<ul>
						<li>Ш, см<span><?=$i['width']>0?$i['width']:'&nbsp;';?></span></li>
						<li>В, см:<span><?=$i['height']>0?$i['height']:'&nbsp;';?></span></li>
						<li>Д, см:<span><?=$i['length']>0?$i['length']:'&nbsp;';?></span></li>
						<li>К.О:<span><?=$i['length']>0?$i['length']:'&nbsp;';?></span></li>
						<li>Вес, кг:<span><?=$i['weight']>0?$i['weight']:'&nbsp;';?></span></li>
					</ul>
				</div>
			</div>
		</div>
	<?}?>
</body>
</html>
