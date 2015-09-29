<?php
if(!isset($_GET['order_id']) || !isset($_GET['client'])){
	header('Location: '._base_url.'/404/');
}
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$contragent = new Contragents();
$id_contragent = $_GET['id_contragent'];
$contragent->SetFieldsById($id_contragent);
$id = explode(';', $contragent->fields['details']);
$remitters = $contragent->GetRemitterById($id);
$tpl->Assign('remitters', $remitters);
$header = 'Формирование докумета';
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => $_SERVER['REQUEST_URI']
);
$tpl->Assign('header', $header);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'pdf_bill_form.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>