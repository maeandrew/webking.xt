<?php
$Users->SetFieldsById(isset($_REQUEST['agent'])?$_REQUEST['agent']:$_SESSION['member']['id_user']);
$tpl->Assign('user', $Users->fields);
$tpl->Assign('customer', $Customers->SetFieldsById($Users->fields['id_user']));
$gifts = $Products->GetGiftsList('AG'.$Users->fields['id_user']);
echo '<link rel="stylesheet" href="/themes/default/min/css/fonts.min.css">';
echo '<link rel="stylesheet" href="/themes/default/min/css/page_styles/promo_certificate.min.css">';
echo '<div class="main">';
if(isset($gifts) && !empty($gifts)){
	foreach($gifts as $gift){
		$gift['images'] = $Products->GetPhotoById($gift['id_product']);
		$tpl->Assign('gift', $gift);
		echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_promo_certificate.tpl');
	}
}else{
	echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_promo_certificate.tpl');
}
echo '</div>';
exit(0);
