<?php
if(!_acl::isAllow('parser')){
	die('Access denied');
}
unset($parsed_res);

$Suppliers = new Suppliers();
$Products = new Products();
$Parser = new Parser();
$header = 'Добавление сайта для парсинга';
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Сайты для парсинга';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/parser_sites/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$tpl->Assign('h1', $header);
$tpl->Assign('categories',  $Products->generateCategory());
$Suppliers->SuppliersList(0, false, '', 'article ASC');
$tpl->Assign('suppliers', $Suppliers->list);


if(isset($_POST['submit'])) {
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Parser_site_form_validate();
	if(!$err){
		if($id = $Parser->Add($_POST)){
			$Parser->SetFieldsById($id);
			foreach($Parser->fields as $k=>$v){
				$_POST[$k] = $v;
			}
			$tpl->Assign('msg', 'Сайт добавлен.');
			echo '<script>setTimeout("document.location=\''.$GLOBALS['URL_base'].'adm/parser_sitesedit/'.$id.'\'", 2000);</script>';
			unset($_POST);
		}else{
			// показываем все заново но с сообщениями об ошибках
			$tpl->Assign('msg', 'Сайт не добавлен.');
			$tpl->Assign('errm', $errm);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Сайт не добавлен.');
		$tpl->Assign('errm', $errm);
	}
}

$tpl_center = $tpl->Parse($GLOBALS['PATH_tpl'].'cp_parser_site_ae.tpl');
