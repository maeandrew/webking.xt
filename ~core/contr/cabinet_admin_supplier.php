<?php
if(!G::IsLogged()){
	header('Location: /login/');
	exit();
}
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
unset($parsed_res);
$User = new Users();
$User->SetUser($_SESSION['member']);
if($User->fields['gid'] != _ACL_ADMIN_){
	echo "Доступ запрещен.";
	exit(0);
}
if(!isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1])){
	header('Location: /404/');
	exit(0);
}
$id_supplier = $GLOBALS['REQAR'][1];
$Supplier = new Suppliers();
$Supplier->SetFieldsById($id_supplier);
$tpl->Assign("supplier", $Supplier->fields);
if(!count($Supplier->fields)){
	header('Location: /404/');
	exit(0);
}
$Products = new Products();
$Products->SetProductsList(array('a.id_supplier' => $Supplier->fields['id_user'], 'p.visible' => 1), '', array('GROUP_BY' => 'p.id_product'));
$Products->FillAssort($id_supplier);
$tpl->Assign('list', $Products->list);
$Products->SetExclusivList($id_supplier);
$tpl->Assign('exclusiv_list', $Products->list);
$tpl->Assign('id_supplier', $id_supplier);
if(!isset($_POST['smb'])){
	foreach($Supplier->fields as $k=>$v){
		$_POST[$k] = $v;
	}
}
$parsed_res = array(
	'issuccess' => true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_supplier_cab_admin.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>