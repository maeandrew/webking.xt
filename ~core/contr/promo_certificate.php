<?php
$tpl->Assign('customer', $Customers->SetFieldsById($_SESSION['member']['id_user']));
echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_promo_certificate.tpl');
exit(0);
