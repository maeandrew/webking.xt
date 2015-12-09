<?if(isset($_SESSION['errm'])){?>
	<?foreach($_SESSION['errm'] as $msg){
		if(!is_array($msg)){?>
			<div class="msg-error">
				<p><?=$msg?></p>
			</div>
		<?}?>
		<script type="text/javascript">
			$('html, body').animate({
				scrollTop: 0
			}, 500, "easeInOutCubic");
		</script>
	<?}
}?>
<div class="cabinet">
	<h3>Личный кабинет поставщика (админ)</h3>
	<div class="sort_page">
		<ul>
			<li><a href="#" class="active">30</a></li>
			<li><a href="#">60</a></li>
			<li><a href="#">100</a></li>
			<li class="lastBord"><a href="#">Все</a></li>
		</ul>
		<p>Показывать на странице:</p>
	</div><!--class="sort_page"-->
	<div class="tabs">
		<h6 class="tabNavigation_fixed">
		<ul class="tabNavigation">
			<li class="large_wholesale"><a class="" href="#first"></a></li>
			<li class="small_wholesale"><a class="" href="#second"></a></li>
		</ul>
		</h6><!--class="tabNavigation_fixed"-->
		<div id="first">
			<div class="fixed_box">
				<div class="fixed_item">
					<table width="100%" cellspacing="0" border="0" class="korzina_table table_fix incabinet">
						<tr>
							<th class="name_cell"><a href="#" class="up_down">Название</a></th>
							<th class="price_cell">Лимит товара<br>на период</th>
							<th class="price_cell">Кол-во в ящике</th>
							<th class="price_cell">Цена от ящика отпускная</th>
							<th class="price_cell">Цена от ящика среднерыноч.</th>
							<th class="price_cell">Цена от ящика<br>отпускная, у.е.</th>
						</tr>
					</table>
				</div><!--class="fixed_item"-->
			</div><!--class="fixed_box"-->
			<table width="100%" cellspacing="0" border="0" class="korzina_table incabinet">
			<?if(count($list)){?>
				<?foreach ($list as $i){?>
				<tr id="tr_opt_<?=$i['id_product']?>" <?=isset($_SESSION['Assort']['products'][$i['id_product']]['active'])&&$_SESSION['Assort']['products'][$i['id_product']]['active']?'style="background-color:#eee;"':"0"?>>
					<td>
						<input type="checkbox" class="chek" id="checkbox_opt_<?=$i['id_product']?>" <?=isset($exclusiv_list[$i['id_product']])?'checked=checked':null?> onchange="SwitchExclusiveProduct(this,<?=$id_supplier?>,<?=$i['id_product']?>)"/>
						<div class="fix_img">
							<a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/efiles/_thumb/nofoto.jpg'?>" onclick="return hs.expand(this)" class="highslide"><img alt="<?=$i['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/efiles/_thumb/nofoto.jpg'?>" title="Нажмите для увеличения"></a>
						</div>
						<a href="<?=_base_url.'/product/'.$i['id_product'].'/'.$i['translit']?>/"><?=$i['name']?></a>
					</td>
					<td class="price_cell">
						<div class="unit">
							<input type="text" id="product_limit_opt_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['product_limit'])?$_SESSION['Assort']['products'][$i['id_product']]['product_limit']:"0"?>" class="input_table" onchange="toAssort(<?=$i['id_product']?>, 1)" />
						</div>
					</td>
					<td class="green_color price_cell">
						<p id="inbox_qty_<?=$i['id_product']?>"><?=$i['inbox_qty']?> шт.</p>
					</td>
					<td class="green_color price_cell">
						<div class="unit">
							<input type="text" id="price_opt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'])?$_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk']:"0"?>" class="input_table" onchange="toAssort(<?=$i['id_product']?>, 1)" />
						</div>
					</td>
					<td class="green_color price_cell">
						<div class="unit">
							<input type="text" id="price_opt_recommend_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_opt_recommend'])?$_SESSION['Assort']['products'][$i['id_product']]['price_opt_recommend']:"0"?>" class="input_table" onchange="toAssort(<?=$i['id_product']?>, 1)" />
						</div>
					</td>
					<td class="green_color price_cell">
						<p id="price_opt_ye_<?=$i['id_product']?>"><?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_opt_otpusk']/$supplier['currency_rate'], 2):"0"?></p>
					</td>
				</tr>
				<?}?>
				<?}else{?>
				<tr><td colspan="7">Товаров нет</td></tr>
			<?}?>
			</table>
		</div>
		<div id="second">
			<div class="fixed_box">
				<div class="fixed_item">
					<table width="100%" cellspacing="0" border="0" class="korzina_table table_fix">
						<tr>
							<th class="name_cell"><a href="#">Название</a></th>
							<th class="price_cell">Лимит товара на период</th>
							<th class="count_cell">Минимальное<br>количество</th>
							<th class="count_cell">Цена<br>отпускная</th>
							<th class="count_cell">Цена<br>среднерыноч.</th>
							<th class="price_cell">Цена<br>отпускная, у.е.</th>
						</tr>
					</table>
				</div><!--class="fixed_item"-->
			</div><!--class="fixed_box"-->
			<table width="100%" cellspacing="0" border="0" class="korzina_table">
			<?if(count($list)){?>
				<?foreach ($list as $i){?>
                <tr id="tr_mopt_<?=$i['id_product']?>" <?=isset($_SESSION['Assort']['products'][$i['id_product']]['active'])&&$_SESSION['Assort']['products'][$i['id_product']]['active']?'style="background-color:#eee;"':"0"?>>
					<td>
						<input type="checkbox" class="chek" id="checkbox_mopt_<?=$i['id_product']?>" <?=isset($exclusiv_list[$i['id_product']])?'checked=checked':null?> onchange="SwitchExclusiveProduct(this,<?=$id_supplier?>,<?=$i['id_product']?>)"/>
						<div class="fix_img">
							<a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/efiles/_thumb/nofoto.jpg'?>" onclick="return hs.expand(this)" class="highslide">
								<img alt="<?=$i['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/efiles/_thumb/nofoto.jpg'?>" title="Нажмите для увеличения">
							</a>
						</div>
						<a href="<?=_base_url.'/product/'.$i['id_product'].'/'.$i['translit']?>/"><?=$i['name']?></a>
					</td>
					<td class="price_cell">
						<div class="unit">
							<input type="text" id="product_limit_mopt_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['product_limit'])?$_SESSION['Assort']['products'][$i['id_product']]['product_limit']:"0"?>" class="input_table" onchange="toAssort(<?=$i['id_product']?>, 1)" />
						</div>
					</td>
					<td class="green_color count_cell">
						<p id="min_mopt_qty_<?=$i['id_product']?>"><?=$i['min_mopt_qty']?> шт.<?=$i['qty_control']?" *":null?></p>
					</td>
					<td class="green_color count_cell">
						<div class="unit">
							<input type="text" id="price_mopt_otpusk_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'])?$_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk']:"0"?>" class="input_table" onchange="toAssort(<?=$i['id_product']?>, 0)" />
						</div>
					</td>
					<td class="green_color count_cell">
						<div class="unit">
							<input type="text" id="price_mopt_recommend_<?=$i['id_product']?>" value="<?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_recommend'])?$_SESSION['Assort']['products'][$i['id_product']]['price_mopt_recommend']:"0"?>" class="input_table" onchange="toAssort(<?=$i['id_product']?>, 0)" />
						</div>
					</td>
					<td class="green_color price_cell">
						<p id="price_mopt_ye_<?=$i['id_product']?>"><?=isset($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk'])?round($_SESSION['Assort']['products'][$i['id_product']]['price_mopt_otpusk']/$supplier['currency_rate'], 2):"0"?></p>
					</td>
				</tr>
				<?}?>
			<?}?>
			</table>
		</div>
	</div><!--class="tabs"-->

</div>
<script>
function SwitchExclusiveProduct(obj, id_supplier, id){
	active = 1;
	if (!obj.checked){
		active = 0;
	}
	$.ajax({
		url: URL_base+'ajaxassort',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {	"action":"exclusive_product",
				"active":active,
				"id_supplier":id_supplier,
				"id_product":id
		}
	});
}
</script>