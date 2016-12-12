<?php
$Users->SetFieldsById(isset($_REQUEST['agent'])?$_REQUEST['agent']:$_SESSION['member']['id_user']);
$tpl->Assign('user', $Users->fields);
$tpl->Assign('customer', $Customers->SetFieldsById(isset($_REQUEST['agent'])?$_REQUEST['agent']:$_SESSION['member']['id_user']));
echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_promo_certificate.tpl');
exit(0);
