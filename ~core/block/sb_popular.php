<?php
$id_category = isset($GLOBALS['CURRENT_ID_CATEGORY'])?$GLOBALS['CURRENT_ID_CATEGORY']:0;
$products = new Products();
if($GLOBALS['CurrentController'] == 'product'){
	$tpl->Assign('title', 'Похожие товары');
	if(!$products->SetFieldsById($GLOBALS['REQAR'][1], 1)){
		header('Location: /404/');
		exit();
	}
	$id_category = $products->fields['id_category'];
	$pops = $products->GetRelatedProducts($GLOBALS['REQAR'][1], $id_category);
	if(empty($pops)){
		$tpl->Assign('title', 'Популярные товары');
		$pops = $products->GetPopularsOfCategory($id_category, true);
	}
}else{
	$tpl->Assign('title', 'Популярные товары');
	$pops = $products->GetPopularsOfCategory($id_category, true);
}
foreach($pops as $k=>&$v){
	$v['name'] = preg_replace("#<.*?(>|$)#is", " ", $v['name']);
	if(strlen($v['name']) > 70){
		$v['name'] = substr($v['name'],0,strpos($v['name'],' ', 50));
		$v['name'].= ' ...';
	}
}
$tpl->Assign('pops', $pops);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_popular.tpl')
);
?>