<div class="cabinet" id="catalog_postav">
	<!-- SHOWCASE SLIDER -->
	<div id="showcase_bg" class="showcase_bg animate"></div>
	<div id="showcase" class="showcase animate paper_shadow_1"></div>
	<h1>Каталог товаров</h1>
	<?if(count($list) >= 30){?>
		<div class="sort_page">
			<a href="<?=_base_url?>/products/<?=$curcat['id_category']?>/<?=$curcat['translit']?>/limitall/"<?=(isset($_GET['limit']) && $_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
		</div><!--class="sort_page"-->
	<?}?>
	<div class="clear"></div>
	<script type="text/javascript">
		var qtycontrol = new Array();
		var notecontrol = new Array();
		var max_sum_order = <?=$GLOBALS['CONFIG']['max_sum_order']?>;
	</script>
	<form action="<?=$GLOBALS['URL_request']?>" method="POST">
		<button name="sort_name" id="sort_name" style="display: none;"></button>
		<button name="sort_price" id="sort_price_asc" value="asc" style="display: none;"></button>
		<button name="sort_price" id="sort_price_desc" value="desc" style="display: none;"></button>
	</form>
	<?if(count($list)){?>
		<script type="text/javascript">
			$(window).scroll(function(){
				if($('.under_tab #cat_table').css('display') == 'none' && $(this).scrollTop() >= 225){
					$('.under_tab #cat_table').css("display", "table");
					$('.under_tab .cat_sort').css("display", "block");
					$('.search a').css({
						"clear": "both",
						"float": "left"
					});
				}else if($('.under_tab #cat_table').css('display') == 'table' && $(this).scrollTop() < 225){
					$('.under_tab #cat_table').css("display", "none");
					$('.under_tab .cat_sort').css("display", "none");
					$('.search a').css({
						"clear": "none",
						"float": "left"
					});
				}
			});
		</script>
		<table cellspacing="0" id="cat_table" class="promo_table">
			<thead class="cat_table_header">
				<tr class="cat_table_row">
					<td class="name" colspan="2"></td>
					<td class="price">Цена</td>
					<td class="note">Примечание</td>
					<td class="quantity">Заказать</td>
				</tr>
			</thead>
			<tbody>
				<?$i=0;?>
				<?foreach($list as $item){
					$Status = new Status();
					$st = $Status->GetStstusById($item['id_product']);?>
					<?($item['price_mopt'] > 0 && $item['min_mopt_qty'] > 0) ? $mopt_available = TRUE : $mopt_available = FALSE ?>
					<tr class="cat_item_<?=($i%2 === 0)?'odd':'even';?>_<?=($item['price_mopt']>0 && $item['min_mopt_qty']>0)?'active':'disabled';?>" id="mopt_item_<?=$item['id_product']?>">
						<td class="cat_photo p<?=$item['id_product']?>" rowspan="1">
							<div class="photo">
								<a href="<?=file_exists($GLOBALS['PATH_root'].$item['img_1'])?_base_url.htmlspecialchars($item['img_1']):'/efiles/_thumb/nofoto.jpg'?>">
									<div class="<?=$st['class']?>"></div>
									<img alt='<?=G::CropString($item['name'])?>' src="<?=file_exists($GLOBALS['PATH_root'].$item['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $item['img_1'])):'/efiles/_thumb/nofoto.jpg'?>"/>
								</a>
							</div>
						</td>
						<td class="cat_name p<?=$item['id_product']?>" rowspan="1">
							<div class="text_wrapper">
								<a class="cat_<?=$item['id_product']?>"><?=G::CropString($item['name'])?></a>
								<?if(strlen($item['descr'])>1){?>
									<div class="hidden_popup_descr">
										<?=$item['descr']?>
									</div>
								<?}else{?>
									<div class="hidden_popup_descr">
										Описание отсутствует
									</div>
								<?}?>
							</div>
							<div><!--noindex-->Арт.<!--/noindex--><?=$item['art']?></div>
						</td>
						<script type="text/javascript">
							<?if($item['qty_control']){?>
								qtycontrol[<?=$item['id_product']?>] = 1;
							<?}?>
						</script>
						<?if($mopt_available){?>
							<style>
								<?if(isset($st['id']) && $st['id'] == 4){?>
									.mopt_item<?=$item['id_product']?> {
										  color: #FF33CC;
									}
								<?}else{?>
									.mopt_item<?=$item['id_product']?> {
										  color: #444444;
									}
								<?}?>
							</style>
							<!-- Начало строки розницы!-->
							<?$cat_worst_price = explode(',',number_format($item['price_mopt'],2,",",""));?>
							<td class="cat_worst_price sale_price price<?=$item['id_product']?>"><?=($cat_worst_price[0] == 0 && $cat_worst_price[1] == 0) ?'---':$cat_worst_price[0].','.$cat_worst_price[1];?>
							</td>
							<td class="cat_min_order">
								<span id="min_mopt_qty_<?=$item['id_product']?>"><?=$item['min_mopt_qty']?></span><!--noindex--> <?=$item['units']?><?=$item['qty_control']?"*":null?><!--/noindex-->
								<span id="multiplicity_<?=$item['id_product']?>"><?=$item['qty_control']==1?$item['min_mopt_qty']:'1';?></span>
							</td>
							<td class="cat_note">
								<a href="#" title="Примечание по товарной позиции. Здесь можете указать желаемый цвет товара, размер и другие переменные характеристики не влияющие на цену товара" id="ico_mopt_<?=$item['id_product']?>" class="error"></a>
								<!--Скрытая форма примечания ОСТОРОЖНО, если между тегами textarea будут проблеы - примечания перестанут нормально работвть-->
								<form action="">
									<textarea id="mopt_note_<?=$item['id_product']?>" onchange="toCart(<?=$item['id_product']?>, 0)"><?=isset($_SESSION['Cart']['products'][$item['id_product']]['note_mopt'])?$_SESSION['Cart']['products'][$item['id_product']]['note_mopt']:null?></textarea>
								</form>
							</td>
							<td class="cat_make_order">
								<?if($mopt_available){
									if(!isset($_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty']) || $_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty']==0){?>
										<div class="buy_button_container" id="mopt_buy_button_<?=$item['id_product']?>" onclick="ch_qty('plus',<?=$item['id_product']?>);return false;">
											<div class="buy_quantity"><?=$item['min_mopt_qty'].$item['units']?><?=$item['qty_control']?"*":null?></div>
											<input type="button" class="buy_button" onclick="return false;" value="Купить"/>
										</div>
										<div class="buy_buttons" id="mopt_buy_buttons_<?=$item['id_product']?>" style="display: none;">
									<?}else{?>
										<div class="buy_button_container" id="mopt_buy_button_<?=$item['id_product']?>" style="display: none;" onclick="ch_qty('plus',<?=$item['id_product']?>);return false;">
											<div class="buy_quantity"><?=$item['min_mopt_qty'].$item['units']?><?=$item['qty_control']?"*":null?></div>
											<input type="button" class="buy_button" onclick="return false;" value="Купить"/>
										</div>
									<div class="buy_buttons" id="mopt_buy_buttons_<?=$item['id_product']?>">
									<?}?>
										<a href="#" class="cat_count_up_icon buy_button" onclick="ch_qty('plus',<?=$item['id_product']?>);return false;">+</a>
										<input type="text" class="cat_mopt_order_qty" id="order_mopt_qty_<?=$item['id_product']?>" value="<?=isset($_SESSION['Cart']['products'][$item['id_product']]['order_box_qty'])?$_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty']:"0"?>" onchange="toCart(<?=$item['id_product']?>, 0)" size="4" />
										<a href="#" class="cat_count_down_icon buy_button" onclick="ch_qty('minus',<?=$item['id_product']?>);return false;">-</a>
									</div>
								<?}else{?>
									<div class="buy_button sold-out">Нет в наличии</div>
								<?}?>
							</td>
							<!-- Конец строки розницы!-->
						</tr>
					<?}?>
				<?$i++;}?>
			</tbody>
		</table>
		<p style="margin-bottom: 30px;">* Товар отпускается только в количестве, кратном минимально допустимому.</p>
		<?=isset($GLOBALS['paginator_html'])?$GLOBALS['paginator_html']:null?>
		<?if(count($list)>29){?>
			<div class="sort_page sort_page_bottom">
				<a href="<?=_base_url?>/products/<?=$curcat['id_category']?>/<?=$curcat['translit']?>/limitall/" <?=(isset($_GET['limit']) && $_GET['limit']=='all')?'class="active"':null?>>Показать все</a>
			</div><!--class="sort_page"-->
		<?}?>
		<style>
			.sb_popular a img {
				opacity: .4;
			}
			.sb_popular a:hover img {
				opacity: 1;
			}
		</style>
	<?}else{?>
		<!-- Конец строк товаров!-->
		<h5>Товаров нет</h5>
	<?}?>
</div><!--class="cabinet"-->
<script type="text/javascript">FixHeader();</script>