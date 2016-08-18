
<?if($GLOBALS['CurrentController'] != 'product'){?>
	<a href="<?=_base_url?>/price/" style="display: block; border-bottom: 2px solid #3A9A11;padding-bottom: 10px;" title="Скачать прайс-лист интернет-магазина ХарьковТОРГ">
		<img style="display: block;margin: 0 auto;" alt="Скачать прайс-лист интернет-магазина ХарьковТОРГ" src="<?=file_exists($GLOBALS['PATH_root'].'/images/price_icon.png')?_base_url.'/images/price_icon.png':'/images/nofoto.png'?>"/>
	</a>
	<br>
	<!-- <p class="catalog_map">
		<a href="<?=_base_url?>/demo_order/">У нас заказывают...</a>
	</p>
	<br>-->
<?}?>
<div class="sb_block sb_popular">
	<h6><?=$title?></h6>
	<ul id="mycarousel" class="jcarousel-skin-tango">
		<?$n=1;
		foreach ($pops as $i){?>
			<li>
				<a href="<?=_base_url."/product/".$i['id_product']."/".$i['translit']."/";?>">
					<img height="180" alt="<?=str_replace('"', '', $i['name'])?>" src="<?=_base_url.G::GetImageUrl($i['img_1'], 'medium')?>"/>
					<span><?=$i['name']?></span>
					<div class="ca-more"><?=number_format($i['price_mopt']*$GLOBALS['CONFIG']['full_wholesale_discount'],2,",","")?> грн.</div>
				</a>
			</li>
		<?$n++;}?>
	</ul>
</div>
<script type="text/javascript">
	// $(window).bind("load", function() {
	// 	$('#mycarousel').jcarousel({
	// 		vertical: true,
	// 		scroll: 4,
	// 		wrap: "circular"
	// 		// Configuration goes here
	// 	});
	// });
</script>