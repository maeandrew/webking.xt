<?if(!empty($list)){?>
	<div class="sorting">
		<!--Сортировка по названию !-->
		<?if(!isset($_GET['search_in_cat'])){?>
			<form action="" method="POST">
				<?if(in_array('sorting', $list_controls)){?>
					<label for="sort_prod">Сортировка</label>
					<select id="sort_prod" name="value" data-role="none" onchange="$(this).closest('form').submit();">
						<?foreach($available_sorting_values as $key => $alias){?>
							<option value="<?=$key?>" <?=isset($sorting['value']) && $sorting['value'] == $key?'selected="selected"':null;?>><?=$alias?></option>
						<?}?>
					</select>
					<select name="direction" data-role="none" class="hidden" onchange="$(this).closest('form').submit();">
						<option value="asc" <?=isset($sorting['direction']) && $sorting['direction'] == 'asc'?'selected="selected"':null;?>>по возрастанию</option>
						<option value="desc" <?=isset($sorting['direction']) && $sorting['direction'] == 'desc'?'selected="selected"':null;?>>по убыванию</option>
					</select>
				<?}?>
			</form>
		<?}?>
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
						<?foreach($list as $p){?>
							<tr id="tr_mopt_<?=$p['id_product']?>" <?=isset($_SESSION['Assort']['products'][$p['id_product']])?'style="background-color:#eee;"':"0"?>>
								<td>
									<input type="checkbox" class="chek" id="checkbox_mopt_<?=$p['id_product']?>" <?=isset($_SESSION['Assort']['products'][$p['id_product']])?'checked=checked':null?> onchange="AddDelProductAssortiment(this,<?=$p['id_product']?>)"/>
								</td>
								<td class="image_cell">
									<?if(!empty($p['images'])){?>
										<a href="<?=file_exists($GLOBALS['PATH_root'].$p['images'][0]['src'])?_base_url.htmlspecialchars($p['images'][0]['src']):'/efiles/_thumb/nofoto.jpg'?>">
											<img alt="<?=G::CropString($p['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].str_replace('original', 'thumb', $p['images'][0]['src']))?_base_url.str_replace('original', 'thumb', $p['images'][0]['src']):'/efiles/_thumb/nofoto.jpg';?>" title="Нажмите для увеличения">
										</a>
									<?}else{?>
										<a href="<?=file_exists($GLOBALS['PATH_root'].$p['img_1'])?_base_url.htmlspecialchars($p['img_1']):'/efiles/_thumb/nofoto.jpg'?>">
											<img alt="<?=G::CropString($p['name'])?>" src="<?=file_exists($GLOBALS['PATH_root'].$p['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $p['img_1'])):'/efiles/_thumb/nofoto.jpg'?>" title="Нажмите для увеличения">
										</a>
									<?}?>
								</td>
								<td class="name_cell">
									<a href="<?=_base_url.'/product/'.$p['id_product'].'/'.$p['translit']?>/"><?=G::CropString($p['name'])?></a>
									<p class="product_article"><!--noindex-->арт. <!--/noindex--><?=$p['art']?></p>
								</td>
								<td class="price_cell">
									<p id="price_mopt_<?=$p['id_product']?>">
										<?if($p['price_opt_otpusk'] != 0){
											echo number_format($p['price_opt_otpusk'], 2, ".", "").' грн.';
										}else{
											echo number_format($p['price_mopt_otpusk'], 2, ".", "").' грн.';
										}?>
									</p>
								</td>
								<td class="count_cell">
									<p id="min_mopt_qty_<?=$p['id_product']?>"><?=$p['min_mopt_qty'].' '.$p['units']?><?=$p['qty_control']?" *":null?></p>
								</td>
								<td class="count_cell">
									<p id="inbox_qty_<?=$p['id_product']?>"><?=$p['inbox_qty'].' '.$p['units']?></p>
								</td>
							</tr>
						<?}?>
						</tbody>
					</table>
				</div>
			</div><!--class="tabs"-->
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