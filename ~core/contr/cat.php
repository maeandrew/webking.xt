<?php
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][0]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][0]['url'] =  _base_url.'/cat/';
$GLOBALS['IERA_LINKS'] = array();
$GLOBALS['IERA_LINKS'][1]['title'] = "Карта каталога ХарьковТорг";
$GLOBALS['IERA_LINKS'][1]['url'] =  _base_url.'/cat/';
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
unset($parsed_res);
$list = $dbtree->Full(array('id_category', 'category_level', 'name', 'translit', 'pid', 'visible'), array('and'=>array('visible=1')));
$tpl->Assign('list', $list);
$parsed_res = array('issuccess' => TRUE,
					'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cat1.tpl'));
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>