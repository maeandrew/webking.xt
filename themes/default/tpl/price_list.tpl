<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Прайс-лист</title>
	<style type="text/css">
		* {
			border-width: 0;
			border-style: solid;
			border-color: #aaa;
			border-collapse: collapse;
			box-sizing: border-box;
			margin: 0;
			padding: 0;
			font-family: 'Helvetica', 'Arial', sans-serif;
		}
		body {
			width: 800px;
			margin: 0 auto;
			font-size: 16px;
		}
		@media print {
			table { page-break-inside: avoid; }
		}
		h1 {
			width: 100%;
			text-align: center;
			line-height: 50px;
			clear: both;
		}
		th {
			font-weight: normal;
		}
		table {
			width: 100%;
			margin: auto;
			page-break-inside: avoid;
		}
		.header {
			background: #eee;
			text-align: left;
		}
		.header th {
			padding: 5px;
		}
		.price {
			max-height: 20px;
			height: 20px;
		}
		.many_prices .price-0 { background: #afa; }
		.many_prices .price-1 { background: #aef; }
		.many_prices .price-2 { background: #ffa; }
		.many_prices .price-3 { background: #faa; }

		/* List view. Small/without photo */
		.list_view th,
		.list_view td {
			border: 1px solid #aaa;
			border-bottom: 0;
		}
		.list_view .product {
			text-align: center;
		}
		.list_view .product:last-of-type {
			border-bottom: 1px solid #aaa;
		}
		.list_view .header__article,
		.list_view .product__article {
			width: 80px;
		}
		.list_view .header__image ,
		.list_view .product__image {
			width: 90px;
			max-width: 90px;
			overflow: hidden;
		}
		.list_view .header__name ,
		.list_view .product__name {
			width: auto;
		}
		.list_view .header__units ,
		.list_view .product__units {
			width: 60px;
		}
		.list_view .header__price ,
		.list_view .product__price {
			width: 80px;
		}
		.list_view .product__name {
			text-align: left;
		}
		.list_view .product__article,
		.list_view .product__name,
		.list_view .product__units {
			padding: 0 5px;
		}
		.list_view .price_container span {
			display: block;
			line-height: 24px;
		}
		.list_view span.best_price {
			width: 30px;
			height: 30px;
			margin-left: 20%;
		}
		/* Block view. Big photo */
		body.block_view {
			width: 1077px;
		}
		.block_view .header {
			border: 1px solid #aaa;
			border-bottom: 0;
		}
		.block_view .product {
			width: 50%;
			float: left;
			border: 1px solid #aaa;
			border-bottom: 0;
		}
		.block_view .product:nth-of-type(2n+2) {
			border-left: 0;
			float: right;
		}
		.block_view .product__image {
			overflow: hidden;
			width: 250px;
			padding-bottom: 10px;
			line-height: 0;
		}
		.block_view .product__name {
			font-size: 1.2em;
		}
		.block_view .product__article td {
			text-align: right;
			font-size: .8em;
			height: 2em;
			line-height: 1.2em;
			padding: 0 5px;
		}
		.block_view .product__article,
		.block_view .product__name,
		.block_view .product__units {
			padding: 0 5px;
		}
		.block_view .product__details__header td {
			text-align: center;
			font-size: .8em;
			height: 1.2em;
			line-height: 1.2em;
			padding: 0 5px;
			border: 1px solid #aaa;
		}
		.block_view .product__details__body td {
			border-left: 1px solid #aaa;
			text-align: center;
		}
		.block_view .prooduct__details__price {
			height: 4em;
		}
		.block_view .prooduct__details__price span {
			display: block;
		}
		.block_view.one_price .prooduct__details__price {
			height: 3em;
		}
		.block_view.one_price .prooduct__details__price span {
			display: block;
			color: #ff5722;
			font-size: 3em;
			font-weight: bold;
		}
		.block_view span.best_price {
			position: absolute;
			width: 50px;
			height: 50px;
			top: 0;
			right: 0;
		}
		table.information {
			page-break-after: always;
			width: 500px;
			text-align: left;
		}
		table.information th {
			text-align: center;
			font-weight: normal;
			font-size: 18px;
		}
		table.information th,
		table.information td {
			padding: 0 5px;
			border: 1px solid #aaa;
		}
		table.information .price {
			text-align: center;
			width: 100px;
		}
		span.best_price {
			display: block;
			background-image: url('../../images/best_price.png');
			-webkit-background-size: 100%;
			background-size: 100%;
			background-repeat: no-repeat;
		}
		div.article,
		div.photo_inner {
			position: relative;
		}
		div.photo_inner img {
			position: relative;
			max-height: 245px;
			z-index: 0;
		}
		h1.global_cat {
			page-break-before: always;
		}
		h1.global_cat:first-of-type {
			page-break-before: avoid;
		}
	</style>
</head>
<body class="<?=$_GET['photo'] != 2?'list':'block'?>_view <?=count($_GET['column']) > 1?'many_prices':'one_price'?>">
<?=count($_GET['column'])?>

<?$price = array(
	'0'=>"При сумме заказа более ".$GLOBALS['CONFIG']['full_wholesale_order_margin']."грн.",
	'1'=>"При сумме заказа от ".$GLOBALS['CONFIG']['wholesale_order_margin']." до ".$GLOBALS['CONFIG']['full_wholesale_order_margin']."грн.",
	'2'=>"При сумме заказа от ".$GLOBALS['CONFIG']['retail_order_margin']." до ".$GLOBALS['CONFIG']['wholesale_order_margin']."грн.",
	'3'=>"При сумме заказа до ".$GLOBALS['CONFIG']['retail_order_margin']."грн.",
);
if(count($_GET['column']) > 1){?>
	<table class="information">
		<tr>
			<th colspan="2">Цветовые обозначения</th>
		</tr>
		<?foreach($_GET['column'] as $column){?>
			<tr>
				<td><?=$price[$column];?></td>
				<td class="price price-<?=$column?>"><span>#,##</span></td>
			</tr>
		<?}?>
	</table>
<?}
if($_GET['photo'] !== 2){
	$headrow = '<th class="header__article">Арт.</th>'.
		($_GET['photo'] == 1?'<th class="header__image">Фото</th>':null).
		'<th class="header__name">Наименование</th>
		<th class="header__units">Мин.</th>
		<th class="header__price">Цена</th>';
}
if(isset($_GET['savedprices']) == false){
	if($_GET['header']){?>
		<h1><?=$_GET['header']?></h1>
	<?}else{?>
		<h1>Прайс-лист службы снабжения xt.ua</h1>
	<?}
}else{?>
	<h1><?=$name?></h1>
<?}
if($_GET['photo'] == 2){ // Если нужно отобразить большие фото товаров
	if(isset($_GET['savedprices']) == true){ // Сохраненный прайс
		$ii = 0;
		foreach($list as $l1){
			if(isset($l1['subcats'])){?>
				<h1 <?=$ii > 0?'class="global_cat"':null;?>><?=$l1['name']?></h1>
				<?$ii++;
				foreach($l1['subcats'] as $l2){
					$i2 = 1;
					if(!empty($l2['products'])){?>
						<div>
							<?foreach($l2['products'] as $p){?>
								<?if($p['price_mopt'] == 0){
									if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
										$margin = str_replace(",",".",$_GET['margin']);
									}else{
										$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
									}
								}else{
									if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
										$margin = str_replace(",",".",$_GET['margin']);
									}else{
										$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
									}
								}?>
								<table class="product">
									<tr>
										<td class="product__image" rowspan="4">
											<div class="photo_inner">
												<?if($p['image'] != ''){?>
													<img height="250" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
												<?}else{?>
													<img height="250" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" />
												<?}
												if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
													<span class="best_price" title="Лучшая цена"></span>
												<?}?>
											</div>
										</td>
										<td class="product__name" colspan="2"><p><?=$p['name']?></p></td>
									</tr>
									<tr class="product__article">
										<td colspan="2">Арт. <?=$p['art'];?></td>
									</tr>
									<tr class="product__details__header">
										<td>Цена за ед. товара</td>
										<td>Мин. кол-во</td>
									</tr>
									<tr class="product__details__body">
										<td class="prooduct__details__price">
											<?if(isset($_GET['margin']) == true && str_replace(',', '.', $_GET['margin']) > 0){
												echo number_format($p['price_mopt']*$margin, 2, ',', '');
											}else{
												foreach($_GET['column'] as $column){?>
													<span class="price-<?=$column;?>"><?=number_format($p['price_mopt']*$margins[$column], 2, ',', '');?></span>
												<?}
											}?>
										</td>
										<td rowspan="<?=count($_GET['column'])?>"><p><?if($p['min_mopt_qty'] !== '0'){ echo $p['min_mopt_qty']; }?> <?=$p['units']?></p></td>
									</tr>
								</table>
								<?$i2++;
							}?>
						</div>
					<?}elseif(!empty($l2['subcats'])){
						foreach($l2['subcats'] as $l3){
							$i3 = 1;?>
							<table class="header">
								<tr>
									<th colspan="<?=$_GET['photo'] == 0?'4':'5';?>"><?=$l3['name'];?></th>
								</tr>
							</table>
							<div>
								<?if(isset($l3['products'])){
									foreach($l3['products'] as $p){
										if($p['price_mopt'] == 0){
											if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												$margin = str_replace(",",".",$_GET['margin']);
											}else{
												$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
											}
										}else{
											if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												$margin = str_replace(",",".",$_GET['margin']);
											}else{
												$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
											}
										}?>
										<table class="product">
											<tr>
												<td class="product__image" rowspan="4">
													<div class="photo_inner">
														<?if($p['image'] != ''){?>
															<img height="250" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
														<?}else{?>
															<img height="250" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" />
														<?}
														if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
															<span class="best_price" title="Лучшая цена"></span>
														<?}?>
													</div>
												</td>
												<td class="product__name" colspan="2"><p><?=$p['name']?></p></td>
											</tr>
											<tr class="product__article">
												<td colspan="2">Арт. <?=$p['art'];?></td>
											</tr>
											<tr class="product__details__header">
												<td>Цена за ед. товара</td>
												<td>Мин. кол-во</td>
											</tr>
											<tr class="product__details__body">
												<td class="prooduct__details__price">
													<?if(isset($_GET['margin']) == true && str_replace(',', '.', $_GET['margin']) > 0){
														echo number_format($p['price_mopt']*$margin, 2, ',', '');
													}else{
														foreach($_GET['column'] as $column){?>
															<span class="price-<?=$column;?>"><?=number_format($p['price_mopt']*$margins[$column], 2, ',', '');?></span>
														<?}
													}?>
												</td>
												<td rowspan="<?=count($_GET['column'])?>"><p><?if($p['min_mopt_qty'] !== '0'){ echo $p['min_mopt_qty']; }?> <?=$p['units']?></p></td>
											</tr>
										</table>
										<?$i3++;
									}
								}?>
							</div>
						<?}
					}
				}
			}
		}
	}else{ // Сформированый прайс
		foreach($cat as $l){?>
			<table class="header">
				<tr>
					<th colspan="<?=$_GET['photo'] == 0?'4':'5';?>"><?=$l['name'];?></th>
				</tr>
			</table>
			<div>
				<?$ii=1;
				foreach($list as $pi){
					foreach($pi as $p){?>
						<?if($p['price_mopt'] == 0){
							if(isset($_GET['margin']) == true && str_replace(',', '.', $_GET['margin']) > 0){
								$margin = str_replace(',', '.',$_GET['margin']);
							}else{
								$margins = explode(';', $GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
							}
						}else{
							if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
								$margin = str_replace(",",".",$_GET['margin']);
							}else{
								$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
							}
						}?>
						<table class="product">
							<tr>
								<td class="product__image" rowspan="4">
									<div class="photo_inner">
										<?if($p['image'] != ''){?>
											<img height="250" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
										<?}else{?>
											<img height="250" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" />
										<?}
										if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
											<span class="best_price" title="Лучшая цена"></span>
										<?}?>
									</div>
								</td>
								<td class="product__name" colspan="2"><p><?=$p['name']?></p></td>
							</tr>
							<tr class="product__article">
								<td colspan="2">Арт. <?=$p['art'];?></td>
							</tr>
							<tr class="product__details__header">
								<td>Цена за ед. товара</td>
								<td>Мин. кол-во</td>
							</tr>
							<tr class="product__details__body">
								<td class="prooduct__details__price">
									<?if(isset($_GET['margin']) == true && str_replace(',', '.', $_GET['margin']) > 0){
										echo number_format($p['price_mopt']*$margin, 2, ',', '');
									}else{
										foreach($_GET['column'] as $column){?>
											<span class="price-<?=$column;?>"><?=number_format($p['price_mopt']*$margins[$column], 2, ',', '');?></span>
										<?}
									}?>
								</td>
								<td rowspan="<?=count($_GET['column'])?>"><p><?if($p['min_mopt_qty'] !== '0'){ echo $p['min_mopt_qty']; }?> <?=$p['units']?></p></td>
							</tr>
						</table>
						<?$ii++;
					}
				}
				if(($ii%2) == 0){?>
					</table>
				<?}?>
			</div>
		<?}
	}
}else{ // Если не нужно отображать фото товаров или мальенткие
	if(isset($_GET['savedprices']) == true){ // Сохраненный прайс
		$ii = 0;
		foreach($list as $k=>$l1){
			if(isset($l1['subcats'])){?>
				<h1 <?=$ii > 0?'class="global_cat"':null?>><?=$l1['name']?></h1>
				<?foreach($l1['subcats'] as $l2){
					$i2 = 1;
					if(!empty($l2['products'])){?>
						<table class="header">
							<tr>
								<th colspan="<?=$_GET['photo'] == 0?'4':'5';?>"><?=$l2['name'];?></th>
							</tr>
							<?if($ii == 0){?>
								<tr><?=$headrow;?></tr>
							<?}?>
						</table>
						<div>
							<?foreach($l2['products'] as $p){?>
								<?if($p['price_mopt'] == 0){
									if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
										$margin = str_replace(",",".",$_GET['margin']);
									}else{
										$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
									}
								}else{
									if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
										$margin = str_replace(",",".",$_GET['margin']);
									}else{
										$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
									}
								}?>
								<table class="product">
									<tr>
										<?if($p['price_mopt'] == 0){
											if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												$margin = str_replace(",",".",$_GET['margin']);
											}else{
												$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
											}
										}else{
											if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												$margin = str_replace(",",".",$_GET['margin']);
											}else{
												$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
											}
										}?>
										<td class="product__article">
											<div class="article">
												<?=$p['art']?>
												<?if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
												<span class="best_price" title="Лучшая цена"></span>
												<?}?>
											</div>
										</td>
										<?if($_GET['photo'] == 1){?>
											<td class="product__image">
												<?if($p['image'] != ''){?>
													<img height="90" width="90px" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
												<?}else{?>
													<img height="90" width="90px" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" alt="<?=$p['name']?>"/>
												<?}?>
											</td>
										<?}?>
										<td class="product__name"><?=$p['name']?></td>
										<td class="product__units"><?=$p['min_mopt_qty'].' '.$p['units']?></td>
										<td class="product__price price_container">
											<?if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												echo number_format($p['price_mopt']*$margin,2,",","");
											}else{
												foreach($_GET['column'] as $column){?>
													<span class="price-<?=$column;?>"><?=number_format($p['price_mopt']*$margins[$column],2,",","");?></span>
												<?}
											}?>
										</td>
									</tr>
								</table>
								<?$i2++;
							}?>
						</div>
					<?}elseif(!empty($l2['subcats'])){
						foreach($l2['subcats'] as $l3){
							$i3 = 1;
							if(isset($l3['products'])){?>
								<table class="header">
									<tr>
										<th colspan="<?=$_GET['photo'] == 0?'4':'5';?>"><?=$l3['name'];?></th>
									</tr>
									<?if($ii == 0){?>
										<tr><?=$headrow;?></tr>
									<?}?>
								</table>
								<div>
									<?foreach($l3['products'] as $p){
										if($p['price_mopt'] == 0){
											if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												$margin = str_replace(",",".",$_GET['margin']);
											}else{
												$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
											}
										}else{
											if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												$margin = str_replace(",",".",$_GET['margin']);
											}else{
												$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
											}
										}?>
										<table class="product">
											<tr>
												<?if($p['price_mopt'] == 0){
													if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
														$margin = str_replace(",",".",$_GET['margin']);
													}else{
														$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['opt_correction_set']]);
													}
												}else{
													if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
														$margin = str_replace(",",".",$_GET['margin']);
													}else{
														$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$p['mopt_correction_set']]);
													}
												}?>
												<td class="product__article">
													<div class="article">
														<?=$p['art']?>
														<?if($p['opt_correction_set'] == 3 || $p['mopt_correction_set'] == 3){?>
														<span class="best_price" title="Лучшая цена"></span>
														<?}?>
													</div>
												</td>
												<?if($_GET['photo'] == 1){?>
													<td class="product__image">
														<?if($p['image'] != ''){?>
															<img height="90" width="90px" src="<?=G::GetImageUrl($p['image'], 'medium')?>" alt="<?=$p['name']?>">
														<?}else{?>
															<img height="90" width="90px" src="<?=G::GetImageUrl($p['img_1'], 'medium')?>" alt="<?=$p['name']?>"/>
														<?}?>
													</td>
												<?}?>
												<td class="product__name"><?=$p['name']?></td>
												<td class="product__units"><?=$p['min_mopt_qty'].' '.$p['units']?></td>
												<td class="product__price price_container">
													<?if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
														echo number_format($p['price_mopt']*$margin,2,",","");
													}else{
														foreach($_GET['column'] as $column){?>
															<span class="price-<?=$column;?>"><?=number_format($p['price_mopt']*$margins[$column],2,",","");?></span>
														<?}
													}?>
												</td>
											</tr>
										</table>
										<?$i3++;
									}?>
								</div>
							<?}
						}
					}
				}
				$ii++;
			}
		}
	}else{ // Сформированый прайс
		if(isset($cat) == true){
			foreach($cat as $l){
				$n = 0;$i = 0;?>
				<table class="header">
					<tr>
						<th colspan="<?=$_GET['photo'] == 0?'4':'5';?>"><?=$l['name'];?></th>
					</tr>
					<tr><?=$headrow;?></tr>
				</table>
				<?foreach($list as $li){
					if(!empty($li)){
						foreach($li as $l){
							if($l['min_mopt_qty'] > 0){?>
								<table class="product">
									<tr>
										<?if($l['price_mopt'] == 0){
											if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												$margin = str_replace(",",".",$_GET['margin']);
											}else{
												$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$l['opt_correction_set']]);
											}
										}else{
											if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												$margin = str_replace(",",".",$_GET['margin']);
											}else{
												$margins = explode(';',$GLOBALS['CONFIG']['correction_set_'.$l['mopt_correction_set']]);
											}
										}?>
										<td class="product__article">
											<div class="article">
												<?=$l['art']?>
												<?if($l['opt_correction_set'] == 3 || $l['mopt_correction_set'] == 3){?>
												<span class="best_price" title="Лучшая цена"></span>
												<?}?>
											</div>
										</td>
										<?if($_GET['photo'] == 1){?>
											<td class="product__image">
												<?if($l['image'] != ''){?>
													<img height="90" width="90px" src="<?=G::GetImageUrl($l['image'], 'medium')?>" alt="<?=$l['name']?>">
												<?}else{?>
													<img height="90" width="90px" src="<?=G::GetImageUrl($l['img_1'], 'medium')?>" alt="<?=$l['name']?>"/>
												<?}?>
											</td>
										<?}?>
										<td class="product__name"><?=$l['name']?></td>
										<td class="product__units"><?=$l['min_mopt_qty'].' '.$l['units']?></td>
										<td class="product__price price_container">
											<?if(isset($_GET['margin']) == true && str_replace(",",".",$_GET['margin']) > 0){
												echo number_format($l['price_mopt']*$margin,2,",","");
											}else{
												foreach($_GET['column'] as $column){?>
													<span class="price-<?=$column;?>"><?=number_format($l['price_mopt']*$margins[$column],2,",","");?></span>
												<?}
											}?>
										</td>
									</tr>
								</table>
							<?$n++;
							}
						}
					}
				}
			}
		}else{?>
			<h1 style='text-align: center;'>Вы не выбрали категорию.</h1><br>
			<h2 style='text-align: center;'>Для формирования прайс-листа необходимо выбрать хотя бы одну категорию.</h2>
		<?}
	}
}?>
</body>
</html>