<?php
unset($parsed_res);
$Products = new Products();
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
if(isset($_GET['savedprices']) && $_GET['savedprices']){
	$header = 'Готовые прайс-листы';
	$url = _base_url.'/price/';
}else{
	$header = 'Формирование прайс-листа';
	$url = _base_url.'/price/?savedprices=true';
}
$header .= ' оптового торгового центра XT.UA';
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][0]['title'] = "Главная";
$GLOBALS['IERA_LINKS'][0]['url'] = _base_url;
$GLOBALS['IERA_LINKS'][1]['title'] = $header;
$GLOBALS['IERA_LINKS'][1]['url'] = $url;
$tpl->Assign('header', $header);
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
unset($parsed_res);
if(isset($_GET['savedprices']) == false){
	$categories = $Products->PriceListProductCount();
	foreach($categories as $k=>$l){
		if($l['category_level'] == 1 && $l['visible'] == 1){
			$list[$l['id_category']] = $l;
		}elseif($l['category_level'] == 2 && $l['visible'] == 1){
			if(isset($list[$l['pid']]) == true){
				$level2[$l['id_category']] = $l;
				$list[$l['pid']]['products'] += $l['products'];
			}
		}elseif($l['category_level'] == 3 && $l['visible'] == 1){
			if(isset($level2[$l['pid']]) == true){
				$level3[$l['id_category']] = $l;
				$level2[$l['pid']]['products'] += $l['products'];
			}
		}
	}
	ksort($level3);
	ksort($level2);
	foreach($level3 as $l3){
		$level2[$l3['pid']]['subcats'][$l3['id_category']] = $l3;
	}
	foreach($level2 as $l2){
		$list[$l2['pid']]['subcats'][$l2['id_category']] = $l2;
	}
	ksort($list);
	$tpl->Assign('list', $list);
}else{
	$prices = $Products->GetPricelistFullList();
	$tpl->Assign('prices', $prices);
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_price.tpl')
);
if(TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}
?>