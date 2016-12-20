<?php
$Users->SetFieldsById(isset($_REQUEST['agent'])?$_REQUEST['agent']:$_SESSION['member']['id_user']);
$tpl->Assign('user', $Users->fields);
$tpl->Assign('customer', $Customers->SetFieldsById($Users->fields['id_user']));
$gifts = $Products->GetGiftsList('AG'.$Users->fields['id_user']);
if(isset($gifts) && !empty($gifts)){
	foreach($gifts as $gift){
		$tpl->Assign('gift', $gift);
		echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_promo_certificate.tpl');
	}
}else{
	echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_promo_certificate.tpl');
}
exit(0);
