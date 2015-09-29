<?php
if(!_acl::isAllow('catalog')){
	die("Access denied");
}
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
unset($parsed_res);
$tpl->Assign('h1', 'Каталог');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
if(isset($GLOBALS['REQAR'][3]) && ($GLOBALS['REQAR'][3]=='after' || $GLOBALS['REQAR'][3]=='before') && isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][2]) && isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][2])){
	$id_category1 = $GLOBALS['REQAR'][1];
	$id_category2 = $GLOBALS['REQAR'][2];
	$position = $GLOBALS['REQAR'][3];
	$dbtree->ChangePositionAll($id_category1, $id_category2, $position);
	$tpl->Assign('msg', 'Сортировка выполнена успешно.');
}
$list = $dbtree->Full(array('id_category', 'category_level', 'name', 'translit', 'prom_id', 'art', 'pid', 'visible', 'page_title', 'page_description', 'page_keywords'));
foreach($list as $k=>$i){
	$list[$k]['next'] = NextOneLevelId($list, $i['id_category']);
	$list[$k]['prev'] = PrevOneLevelId($list, $i['id_category']);
	$list[$k]['childrens'] = false;
	if(isset($list[$k+1]) && $list[$k+1]['pid']==$list[$k]['id_category']){
		$list[$k]['childrens'] = true;
	}
}
$tpl->Assign('list', $list);
$parsed_res = array(
	'issuccess' => TRUE,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cat.tpl')
);
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
function PrevOneLevelId(&$arr, $id_category){
	for($ii = 0; isset($arr[$ii]); $ii++){
		if($arr[$ii]['id_category'] == $id_category){
			for($jj=$ii-1; isset($arr[$jj]); $jj--){
				if($arr[$jj]['pid'] == $arr[$ii]['pid'] && $arr[$jj]['category_level'] == $arr[$ii]['category_level']){
					return $arr[$jj]['id_category'];
					break;
				}
			}
		}
	}
	return false;
}
function NextOneLevelId(&$arr, $id_category){
	for($ii = 0; isset($arr[$ii]); $ii++){
		if($arr[$ii]['id_category'] == $id_category){
			for($jj=$ii+1; isset($arr[$jj]); $jj++){
				if($arr[$jj]['pid'] == $arr[$ii]['pid'] && $arr[$jj]['category_level'] == $arr[$ii]['category_level']){
					return $arr[$jj]['id_category'];
					break;
				}
			}
		}
	}
	return false;
}?>