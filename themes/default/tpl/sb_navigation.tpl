<h3>Каталог</h3>
<script type="text/javascript">
<!--
var expandedCat = <?=isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:0;?>;
//-->
</script>
<?$ii = 0;
$prev_level = 0;
foreach($list as $i){
	if($i['category_level'] != 0){
		if($i['category_level'] > $prev_level){
			if($ii++ == 0){?>
				<ul class="left_menu">
			<?}else{?>
				</div><ul>
			<?}?>
			<li><div>
		<?}elseif($i['category_level'] == $prev_level){?>
			</div></li><li><div>
		<?}elseif($i['category_level'] < $prev_level){
			$amount = $prev_level-$i['category_level'];?>
			</div></li>
			<?for($jj = 0; $jj < $amount; $jj++){?>
				</ul></li>
			<?}
			if($ii+1 < count($list)){?>
				<li><div>
			<?}
		}?>
		<?if($GLOBALS['CurrentController'] == 'products' && $GLOBALS['REQAR'][1] == $i['id_category']){?>
			<a id="cat_<?=$i['id_category']?>" href="<?=Link::Category($i['translit']);?>"  onclick="return expandCat(<?=$i['id_category']?>)" class="active"><h5><?=$i['name']?></h5></a>
		<?}else{?>
			<a<?if(isset($GLOBALS['CURRENT_ID_CATEGORY']) && $GLOBALS['CURRENT_ID_CATEGORY'] == $i['id_category']){?> class="active"<?}?> id="cat_<?=$i['id_category']?>" href="<?=Link::Category($i['translit']);?>" onclick="return expandCat(<?=$i['id_category']?>)"><h5><?=$i['name']?></h5></a>
		<?}
		$prev_level = $i['category_level'];
	}
}?>
</div></li>
</ul>
<p class="catalog_map"><a href="/cat/">Карта каталога</a></p>
<p class="catalog_map"><a href="/demo_order/">У НАС ЗАКАЗЫВАЮТ</a></p>

