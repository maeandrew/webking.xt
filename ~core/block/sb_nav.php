<?php
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
if(isset($GLOBALS['Rewrite'])){
	$curcat = $dbtree->CheckParent($GLOBALS['Rewrite'], array('id_category', 'name', 'translit', 'art', 'category_level', 'content', 'pid', 'filial_link'));
	$id_category = $curcat['id_category'];
}else{
	$id_category = 0;
}
$tpl->Assign('curcat', $curcat);
// $navigation = $dbtree->GetCats(array('id_category', 'category_level', 'name', 'translit', 'pid'), 1);
if($GLOBALS['CurrentController'] == 'products'){
	$GLOBALS['CURRENT_ID_CATEGORY'] = $id_category;
	$subcats = $dbtree->GetSubCats($id_category, array('id_category', 'category_level', 'name', 'translit', 'art', 'pid', 'visible'));
	foreach($subcats as &$s){
		$subcats2 = count($dbtree->GetSubCats($s['id_category'], 'all'));
		$s['subcats'] = $subcats2;
	}
	$tpl->Assign('subcats', $subcats);
	if($curcat['pid'] == 0 && $curcat['category_level'] == 1){
		// $subcats = $dbtree->GetSubCats($id_category, array('id_category', 'category_level', 'name', 'translit', 'art', 'pid', 'visible'));
		$GLOBALS['GLOBAL_CURRENT_ID_CATEGORY'] = $id_category;
	}elseif($curcat['pid'] != 0 && $curcat['category_level'] == 2){
		// $subcats = $dbtree->GetSubCats($id_category, array('id_category', 'category_level', 'name', 'translit', 'art', 'pid', 'visible'));
		$GLOBALS['GLOBAL_CURRENT_ID_CATEGORY'] = $curcat['pid'];
	}else{
		$gp = $dbtree->CheckParent($curcat['pid'], array('id_category', 'name', 'translit', 'art', 'category_level', 'content', 'pid', 'filial_link'));
		$GLOBALS['GLOBAL_CURRENT_ID_CATEGORY'] = $gp['pid'];
	}
}
// if(!empty($navigation)){
// 	foreach($navigation as &$l1){
// 		$level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
// 		foreach($level2 as &$l2){
// 			$level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
// 			$l2['subcats'] = $level3;
// 		}
// 		$l1['subcats'] = $level2;
// 	}
// }
$tpl->Assign('sbheader', 'Каталог товаров');
//$tpl->Assign('navigation', $navigation);
// print_r($navigation);

$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_nav.tpl')
);?>