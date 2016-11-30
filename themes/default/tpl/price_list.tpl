<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title>Прайс-лист</title>
	<link rel="stylesheet" href="/themes/default/min/css/page_styles/price_list.min.css">
</head>
<body class="<?=$_GET['photo'] != 2?'list':'block'?>_view <?=count($_GET['column']) > 1?'many_prices':'one_price'?>">
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
}elseif ($_GET['photo'] == 3){
	foreach($list as $item){
		foreach($item as $product){
			var_dump($product['name']);
		}
	}

	?>
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
			<p class="prod_title"><?=$product['name']?></p>
			<p class="prod_art">Артикул: <?=$product['art']?></p>
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
		</div>
		<div class="footer">
			<div class="logo">
				<img src="/themes/default/img/_xt.svg">
				<p>Служба снабжения ХарьковТОРГ</p>
			</div>
			<div class="contacts">
				<p class="site">xt.ua</p>
				<div class="phones">
					Связь с нами:
					<p>(050) 309-84-20</p>
					<p>(067) 574-10-13</p>
					<p>(057) 780-38-61</p>
				</div>
			</div>
			<div class="prod_qr_code">
				<img src="http://chart.apis.google.com/chart?cht=qr&chs=100x100&chl=<?=Link::Product($product['translit'])?>&chld=H|0">
			</div>
		</div>
	</div>
<?}else{ // Если не нужно отображать фото товаров или мальенткие
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