<?php
if(!_acl::isAllow('parser')){
	die('Access denied');
}
unset($parsed_res);

if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id = $GLOBALS['REQAR'][1];
}
$Suppliers = new Suppliers();
$Products = new Products();
$Parser = new Parser();
$Parser->SetFieldsById($id);
$header = 'Редактирование сайта для парсинга';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Сайты для парсинга';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/parser_sites/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$tpl->Assign('h1', $header);
$tpl->Assign('categories',  $Products->generateCategory());
$Suppliers->SuppliersList(0, false, '', 'article ASC');
$tpl->Assign('suppliers', $Suppliers->list);

if(isset($_POST['submit'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Parser_site_form_validate();
	if(!$err){
		if($Parser->Update($_POST)){
			$Parser->SetFieldsById($id);
			$tpl->Assign('msg', 'Сайт обновлен.');
		}else{
			// показываем все заново но с сообщениями об ошибках
			$tpl->Assign('msg', 'Сайт не обновлен.');
			$tpl->Assign('errm', $errm);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Сайт не обновлен.');
		$tpl->Assign('errm', $errm);
	}
}
foreach($Parser->fields as $k=>$v){
	$_POST[$k] = $v;
}
$tpl_center = $tpl->Parse($GLOBALS['PATH_tpl'].'cp_parser_site_ae.tpl');
