<?if(!empty($list)){?>
	<link href="<?=$GLOBALS['URL_css_theme'];?>page_styles/products.css" rel="stylesheet" type="text/css">
	<div class="content_header clearfix">
		<div class="sort imit_select">
			<span>Сортировать:</span>
			<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
				<select id="sorting" name="sorting" class="mdl-selectfield__select sorting_js" onChange="SortProductsList();">
					<?foreach($available_sorting_values as $key => $alias){ ?>
						<option <?=isset($GLOBALS['Sort']) && $GLOBALS['Sort'] == $key?'selected':null;?> value="<?=!isset($GLOBALS['Rewrite'])?Link::Custom($GLOBALS['CurrentController'], null, array('sort' => $key)):Link::Category($GLOBALS['Rewrite'], array('sort' => $key));?>"><?=$alias?></option>
					<?}?>
				</select>
			</div>

			<!-- <a href="#" class="graph_up hidden"><i class="material-icons">timeline</i></a> -->
			<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 0){?>
				<a href="#" class="xgraph_up one"><i class="material-icons">timeline</i></a>
			<?}elseif(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1){?>
				<a href="#" class="xgraph_up two"><i class="material-icons">timeline</i></a>
			<?}?>
		</div>
		<div class="productsListView">
			<i id="changeToList" class="material-icons changeView_js <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'list' ? 'activeView' : NULL?>" data-view="list">view_list</i>
			<span class="mdl-tooltip" for="changeToList">Вид списком</span>
			<i id="changeToBlock" class="material-icons changeView_js <?=!isset($_COOKIE['product_view']) || $_COOKIE['product_view'] == 'block' ? 'activeView' : NULL?>" data-view="block">view_module</i>
			<span class="mdl-tooltip" for="changeToBlock">Вид блоками</span>
			<i id="changeToColumn" class="material-icons changeView_js hidden <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'column' ? 'activeView' : NULL?>" data-view="column">view_column</i>
			<span class="mdl-tooltip" for="changeToColumn">Вид колонками</span>
		</div>
		<div class="catalog_btn btn_js mdl-cell--hide-desktop" data-name="catalog">Каталог</div>
	</div>
<?}?>
<div id="catalog_supplier" class="products">
	<?if(isset($subcats) && !empty($subcats)){?>
		<ul class="subcats row">
			<?foreach($subcats as $sub){
				$url = _base_url.'/products/'.$sub['id_category'].'/'.$sub['translit'].'/';
				if($sub['subcats'] !== 0){
					$url .= 'limitall/';
				}?>
				<li class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<a href="<?=$url;?>" class="animate">
						<div class="subcats_block">
							<div>
								<img class="lazy" data-original="<?=_base_url?>/efiles/katalog/<?=$sub['translit']?>.jpg" alt="<?=$sub['name']?>"/>
								<noscript>
									<img src="<?=_base_url?>/efiles/katalog/<?=$sub['translit']?>.jpg" alt="<?=$sub['name']?>"/>
								</noscript>
							</div>
							<div>
								<span class="color-grey"><?=$sub['name']?></span>
							</div>
						</div>
					</a>
				</li>
			<?}?>
		</ul>
		<?if(isset($curcat['content']) && $curcat['content'] != ''){?>
			<div class="content_wrapp">
				<input type="checkbox" id="read_more" class="hidden">
				<section class="content_text animate">
					<?=$curcat['content']?>
				</section>
				<?if (strlen($curcat['content']) >= 500) {?>
					<label for="read_more">Читать полностью</label>
				<?}?>
			</div>
		<?}?>
	<?}else{?>
		<?if(!empty($list)){?>
			<div class="tabs">
				<div id="second">
					<table width="100%" cellspacing="0" border="0" class="table_thead table">
						<colgroup>
							<col width="70%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
						</colgroup>
						<thead>
							<tr>
								<th>Название</th>
								<th>Цена за еденицу товара</th>
								<th>Минимальное<br>количество</th>
								<th>Кол-во<br>в ящике</th>
							</tr>
						</thead>
					</table>
					<table width="100%" cellspacing="0" border="0" class="table_tbody table">
						<colgroup>
							<col width="5%">
							<col width="10%">
							<col width="55%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
						</colgroup>
						<tbody>
						<?foreach($list as $item){?>
							<tr id="tr_mopt_<?=$item['id_product']?>" <?=isset($_SESSION['Assort']['products'][$item['id_product']])?'style="background-color:#eee;"':"0"?>>
								<td>
									<input type="checkbox" class="chek" id="checkbox_mopt_<?=$item['id_product']?>" <?=isset($_SESSION['Assort']['products'][$item['id_product']])?'checked=checked':null?> onchange="AddDelProductAssortiment(this,<?=$item['id_product']?>)"/>
								</td>
								<td class="image_cell">
									<?if(!empty($item['images'])){?>
										<img alt="<?=G::CropString($item['id_product'])?>" class="lazy" data-original="<?=_base_url?><?=str_replace('original', 'thumb', $item['images'][0]['src']);?>"/>
										<noscript>
											<img alt="<?=G::CropString($item['id_product'])?>" src="<?=_base_url?><?=str_replace('original', 'thumb', $item['images'][0]['src']);?>"/>
										</noscript>
									<?}else{?>
										<img alt="<?=G::CropString($item['id_product'])?>" class="lazy" data-original="<?=_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/_thumb/image/", $item['img_1'])):"/images/nofoto.png"?>"/>
										<noscript>
											<img alt="<?=G::CropString($item['id_product'])?>" src="<?=_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/_thumb/image/", $item['img_1'])):"/images/nofoto.png"?>"/>
										</noscript>
									<?}?>
								</td>
								<td class="name_cell">
									<a href="<?=_base_url.'/product/'.$item['id_product'].'/'.$item['translit']?>/"><?=G::CropString($item['name'])?></a>
									<p class="product_article"><!--noindexарт. <!--/noindex--><?=$item['art']?></p>
								</td>
								<td class="price_cell">
									<p id="price_mopt_<?=$item['id_product']?>">
										<?if($item['price_opt_otpusk'] != 0){
											echo number_format($item['price_opt_otpusk'], 2, ".", "").' грн.';
										}else{
											echo number_format($item['price_mopt_otpusk'], 2, ".", "").' грн.';
										}?>
									</p>
								</td>
								<td class="count_cell">
									<p id="min_mopt_qty_<?=$item['id_product']?>"><?=$item['min_mopt_qty'].' '.$item['units']?><?=$item['qty_control']?" *":null?></p>
								</td>
								<td class="count_cell">
									<p id="inbox_qty_<?=$item['id_product']?>"><?=$item['inbox_qty'].' '.$item['units']?></p>
								</td>
							</tr>
						<?}?>
						</tbody>
					</table>
				</div>
			</div> --><!--class="tabs"-->
			<div class="products">
				<?foreach($list as $p){?>
					<div class="card clearfix">
						<div class="product_photo">
							<a href="<?=Link::Product($p['translit']);?>">
								<?if(!empty($item['images'])){?>
									<img alt="<?=G::CropString($item['id_product'])?>" class="lazy" data-original="<?=_base_url?><?=str_replace('original', 'thumb', $item['images'][0]['src']);?>"/>
									<noscript>
										<img alt="<?=G::CropString($item['id_product'])?>" src="<?=_base_url?><?=str_replace('original', 'thumb', $item['images'][0]['src']);?>"/>
									</noscript>
								<?}else{?>
									<img alt="<?=G::CropString($item['id_product'])?>" class="lazy" data-original="<?=_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/_thumb/image/", $item['img_1'])):"/images/nofoto.png"?>"/>
									<noscript>
										<img alt="<?=G::CropString($item['id_product'])?>" src="<?=_base_url?><?=$item['img_1']?htmlspecialchars(str_replace("/image/", "/_thumb/image/", $item['img_1'])):"/images/nofoto.png"?>"/>
									</noscript>
								<?}?>
							</a>
						</div>
						<p class="product_name"><a href="<?=Link::Product($p['translit']);?>"><?=G::CropString($p['name'])?></a> <span class="product_article">Арт: <?=$p['art'];?></span></p>
						<div class="product_buy" data-idproduct="<?=$p['id_product']?>">
							<p class="price"><?=number_format($p['price_mopt'], 2, ',', '')?></p>
							<div class="buy_block">
								<div class="btn_remove">
									<button class="mdl-button material-icons icon-font" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 0);return false;">
										remove
									</button>
								</div>
								<input type="text" class="qty_js" value="0" onchange="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), null);return false;">
								<div class="btn_buy">
									<button class="mdl-button mdl-js-button buy_btn_js" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;">
										<?=isset($_SESSION['cart']['products'][$p['id_product']])?'+':'Купить'?>
									</button>
								</div>

								<!-- <input type="text" class="qty_js" value="<?=$_SESSION['cart']['products'][$item['id_product']]['quantity']?>">
								<div class="btn_buy">
									<button class="mdl-button mdl-js-button" type="button" onClick="ChangeCartQty($(this).closest('.product_buy').data('idproduct'), 1);return false;"><i class="material-icons">add</i></button>
								</div> -->

							</div>
						</div>
						<div class="product_info clearfix hidden">
							<div class="note clearfix">
								<textarea placeholder="Примечание: "></textarea>
								<label class="info_key">?</label>
								<div class="info_description">
									<p>Поле для ввода примечания к товару.</p>
								</div>
							</div>
						</div>
					</div>
				<?}?>
			</div>
			<?if(isset($cnt) && $cnt >= 30){?>
				<div class="sort_page">
					<a href="<?=_base_url?>/products/<?=$curcat['id_category']?>/<?=$curcat['translit']?>/limitall/"<?=(isset($_GET['limit'])&&$_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
				</div><!--class="sort_page"-->
			<?}?>
			<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
		<?}else{?>
			<!-- Конец строк товаров!-->
			<h5>Товаров нет</h5>
		<?}?>
	<?}?>
	</div><!--class="cabinet"-->
<script>
//Фиксация Заголовка таблицы
	$(window).scroll(function(){
		if($(this).scrollTop() >= 160){
			if(!$('.table_thead').hasClass('fixed_thead')){
				var width = $('.table_tbody').width();
				$('.table_thead').css("width", width).addClass('fixed_thead');
				$('#second').css("margin-top", "69px");
			}
		}else{
			if($('.table_thead').hasClass('fixed_thead')){
				$('.table_thead').removeClass('fixed_thead');
				$('#second').css("margin-top", "0");
			}
		}
	});
</script>