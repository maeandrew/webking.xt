<?php
$Specification = new Specification();
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
if(!$Specification->SetFieldsById($id)) die('Ошибка при выборе характеристики.');
$header = 'Список значений';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Характеристики';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/specifications/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $Specification->fields['caption'];
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/specificationedit/'.$id;
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$tpl->Assign('id_specification', $id);
$tpl->Assign('h1', $header.' - "'.$Specification->fields['caption'].'"');
$tpl->Assign('list', $Specification->GetValuesList($id));
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_specification_values_list.tpl');
