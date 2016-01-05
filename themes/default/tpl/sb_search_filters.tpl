<script>
	/** Фильтр по цене */
	$(function() {
		$("#slider_price").slider({
			range: true,
			min: <?=$min_price?>,
			max: <?=$max_price?>,
			values: [<?=isset($GLOBALS['Price_range'][0]) ? $GLOBALS['Price_range'][0] : $min_price?>,
					 <?=isset($GLOBALS['Price_range'][1]) ? $GLOBALS['Price_range'][1] : $max_price?>],
			step: <?=floor(($max_price - $min_price) * 0.01)?>,
			slide: function(event, ui) {
				$( "#amount" ).val( ui.values[ 0 ] + " грн  -  " + Math.round(ui.values[ 1 ]) + " грн" );
			},
			stop: function(event, ui) {
				var price_range = ui.values[0] + ',' + ui.values[1];
				$.cookie('price_range', price_range, {
					expires: 2,
					path: '/'
				});
			window.location.href = '<?=Link::Category($GLOBALS['Rewrite'], array('price_range' => "' + price_range + '"))?>';
			}
		});
		$( "#amount" ).val($( "#slider_price" ).slider( "values", 0 ) + " грн  -  " + $( "#slider_price" ).slider( "values", 1 ) + " грн");

		//Очистить фтльтры
		$("#clear_filter").click(function() {
//			$.cookie('price_range', null);
			window.location.href = '<?=Link::Category($GLOBALS['Rewrite'], array('clear'=>true))?>';
		});

	});
</script>
<div class="filters">
	<div class="filter_block">
		<p>Сбросить все фильтры:</p>
		<ul>
			<li id="clear_filter" >
				<input type="submit" value="Сбросить">
			</li>
		</ul>
	</div>

	<div class="filter_block">
		<p>Ценовой диапазон</p>
		<ul>
			<li>
				<input  type="text" id="amount" readonly>
				<div class="mdl-slider mdl-js-slider" id="slider_price"></div>
			</li>
		</ul>
	</div>

	<? if(isset($filter_cat) && is_array($filter_cat)) {
		foreach($filter_cat as $spec){ ?>
			<div class="filter_block">
				<p><?=$spec['caption']?></p>
				<ul>
					<? foreach($spec['values'] as $value){ ?>
							<li>
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect <?=$value['checked']?>">
									<a href="<?=Link::Category($GLOBALS['Rewrite'], array('filter' => $value['id']))?>">
										<input type="checkbox" class="mdl-checkbox__input" <?=$value['checked']?>>
										<span>
											<span class="mdl-checkbox__label"><?=$value['value']?></span>
											<span class="qnt_products fright"><?=$value['count']?></span>
										</span>
									</a>
								</label>
							</li>
					<? } ?>
				</ul>
			</div>
	<? } } ?>
</div>
<!--
<?if(!empty($list) && (!isset($_SESSION['member']) || $_SESSION['member']['gid'] != _ACL_TERMINAL_)){?>
	<div class="sb_block">
		<h4>Фильтры</h4>
		<div class="sb_container">
			<form action="<?=_base_url."/".preg_replace("#^(.*?)/(p[0-9]+)(.*?)$#is", "\$1\$3/", preg_replace("#^/(.*?)$#i", "\$1", $_SERVER['REQUEST_URI']));?>" method="post" name="search_form" id="filters">
				<input type="hidden" name="query" value="<?=isset($_SESSION['search']['query'])?$_SESSION['search']['query']:null;?>"/>
				<?if(isset($_POST['category2search'])){?>
					<input type="hidden" name="category2search" value="<?=$_SESSION['search']['category2search']?>">
				<?}else{?>
					<input type="hidden" name="searchincat" value="<?=$curcat['id_category']?>">
				<?}?>
				<input type="hidden" name="minprice" id="minprice" value="<?=isset($_SESSION['filters']['minprice'])?$_SESSION['filters']['minprice']:null;?>"/>
				<input type="hidden" name="maxprice" id="maxprice" value="<?=isset($_SESSION['filters']['maxprice'])?$_SESSION['filters']['maxprice']:null;?>"/>
				<?if(isset($_SESSION['filters']['minprice']) && isset($_SESSION['filters']['maxprice']) && $_SESSION['filters']['minprice'] != $_SESSION['filters']['maxprice']){?>
					<div class="price_filter">
						<p>Цена,грн</p>
						<label for="price_from">от
							<input type="number" name="pricefrom" id="price_from" min="<?=$_SESSION['filters']['minprice'];?>" max="<?=$_SESSION['filters']['maxprice'];?>" value="<?=isset($_SESSION['filters']['pricefrom']) && $_SESSION['filters']['pricefrom'] != ''?$_SESSION['filters']['pricefrom']:0?>" required>
						</label>
						<label for="price_to">до
							<input type="number" name="priceto" id="price_to" min="<?=$_SESSION['filters']['minprice']+1;?>" max="<?=$_SESSION['filters']['maxprice']+1;?>" value="<?=isset($_SESSION['filters']['priceto']) && $_SESSION['filters']['pricefrom'] != ''?$_SESSION['filters']['priceto']:0?>" required>
						</label>
					</div>
				<?}?>
				<div class="manufacturer_filter hidden">
					<p class="filter_title">Производители<span class="icon-font">arrow_down</span></p>
					<ul class="filter_block">
						<li>
							<label for="manuf_atlant">
								<input id="manuf_atlant" type="checkbox">Atlant
							</label>
						</li>
						<li>
							<label for="manuf_bosh">
								<input id="manuf_bosh" type="checkbox">Bosh
							</label>
						</li>
						<li>
							<label for="manuf_intertool">
								<input id="manuf_intertool" type="checkbox">Intertool
							</label>
						</li>
					</ul>
				</div>
				<div class="color_filter hidden">
					<p class="filter_title">Цвет<span class="icon-font">arrow_down</span></p>
					<ul class="filter_block">
						<li>
							<label class="color_yellow selected">
								<input id="yellow" type="checkbox">
							</label>
						</li>
						<li>
							<label class="color_red">
								<input id="red" type="checkbox">
							</label>
						</li>
						<li>
							<label class="color_blue">
								<input id="blue" type="checkbox">
							</label>
						</li>
					</ul>
				</div>
				<a href="#" class="reset fright">Сбросить фильтр</a>
				<button type="submit" class="btn-m-green fleft">Применить</button>
			</form>
		</div>
	</div>
<?}?>
-->