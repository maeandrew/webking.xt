<?php
if(!_acl::isAllow('catalog')){
	die("Access denied");
}
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
unset($parsed_res);
$header = 'Каталог';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';

$cat_arr = $dbtree->GetAllCats(array('id_category', 'category_level', 'name', 'translit', 'prom_id', 'pid', 'visible'), 1);
if(!empty($cat_arr)){
	foreach($cat_arr as &$l1){
		$level2 = $dbtree->GetAllSubCats($l1['id_category'], 'id_category', 'category_level', 'name', 'translit', 'prom_id', 'pid', 'visible');
		foreach($level2 as &$l2){
			$level3 = $dbtree->GetAllSubCats($l2['id_category'], 'id_category', 'category_level', 'name', 'translit', 'prom_id', 'pid', 'visible');
			$l2['subcats'] = $level3;
		}
		$l1['subcats'] = $level2;
	}
}
$tpl->Assign('cat_arr', $cat_arr);

$parsed_res = array(
	'issuccess' => TRUE,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cat1.tpl')
);
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>