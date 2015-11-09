<?php
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
if($GLOBALS['CurrentController'] == 'products'){
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$id_category = $GLOBALS['REQAR'][1];
	}else{
		$id_category = 0;
	}
	$curcat = $dbtree->CheckParent($id_category, array('id_category', 'name', 'translit', 'art', 'category_level', 'content', 'pid', 'filial_link'));
	if(!$curcat || empty($curcat)){
		header('Location: /404/');
		exit();
	}
	$tpl->Assign('curcat', $curcat);
}
// $testtimestart = microtime(true);
// if($_SESSION['client']['user_agent'] == 'mobile'){
// 	if($GLOBALS['CurrentController'] == 'products'){
// 		$GLOBALS['CURRENT_ID_CATEGORY'] = $id_category;
// 		// $navigation = $mc->get("productsNavigation".$id_category);
// 		if(!isset($navigation)){
// 			$navigation = $dbtree->GetSubCats($id_category, 'all');
// 			$mc->set("productsNavigation".$id_category, $navigation, 0, 7200);
// 			print_r('<script>console.log(\'productsNavigation taken from SQL\');</script>');
// 		}
// 	}else{
// 		// $navigation = $mc->get("mainNavigation");
// 		if(!isset($navigation)){
// 			$navigation = $dbtree->GetCats(array('id_category', 'category_level', 'name', 'translit', 'pid'), 1);
// 			$mc->set("mainNavigation", $navigation, 0, 7200);
// 			// print_r('<script>console.log(\'mainNavigation taken from SQL\');</script>');
// 		}
// 	}
// }else{
	$navigation = $dbtree->GetCats(array('id_category', 'category_level', 'name', 'translit', 'pid'), 1);
	if($GLOBALS['CurrentController'] == 'products'){
		$GLOBALS['CURRENT_ID_CATEGORY'] = $id_category;
		$subcats = $dbtree->GetSubCats($id_category, array('id_category', 'category_level', 'category_img', 'name', 'translit', 'art', 'pid', 'visible'));
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
// }
if(!empty($navigation)){
	foreach($navigation as &$l1){
		$level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
		foreach($level2 as &$l2){
			$level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
			$l2['subcats'] = $level3;
		}
		$l1['subcats'] = $level2;
	}
}
$tpl->Assign('navigation', $navigation);
unset($curcat, $navigation, $subcats, $level2, $level3);
// $time = microtime(true) - $testtimestart;
// printf('Скрипт 2 выполнялся %.4F сек.', $time);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'main_navigation.tpl')
);
function rutime($ru, $rus, $index) {
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
}
?>