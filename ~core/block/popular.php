<?php
$id_category = isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:0;
$products = new Products();
if($GLOBALS['CurrentController'] == 'product'){
	if(!$products->SetFieldsById($GLOBALS['REQAR'][1], 1)){
		header('Location: '. _base_url.'/404/');
		exit();
	}
	if(!isset($id_category)) $id_category = $products->fields['id_category'];
	$related = $products->GetRelatedProducts($GLOBALS['REQAR'][1], $id_category);
	$tpl->Assign('pops', $related);
	$tpl->Assign('title', 'Похожие товары');
}else{
	$pops = $products->GetPopularsOfCategory($id_category, true);
	foreach ($pops as $k=>&$v){
		$v['name'] = preg_replace("#<.*?(>|$)#is"," ",$v['name']);
	}
	$tpl->Assign('pops', $pops);
	$tpl->Assign('title', 'Популярные товары');
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'popular.tpl')
);
?>