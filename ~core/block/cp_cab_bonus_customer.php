<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/bonus/'
);
if(isset($_POST['id_order']) && !empty($_POST['id_order'])) $id_order = intval($_POST['id_order']);
$Customer = new Customers();
$Customer->SetFieldsById($User->fields['id_user']);
if(isset($_POST['save_bonus'])){
	if(!$Customer->fields['bonus_card']){
		// if($Customer->registerBonus($_POST['bonus_card'], $_POST['sex'], $_POST['learned_from'], date("Y-m-d",strtotime($_POST['bday'].'.'.$_POST['bmonth'].'.'.$_POST['byear'])), $_POST['buy_volume'])){
		if($Customer->registerBonus($_POST)){
			header("Location: ". _base_url."/cabinet/bonus/?t=bonus_info&success");
		}else{
			header("Location: ". _base_url."/cabinet/bonus/?t=bonus_info&unsuccess");
		}
	}else{
		if($Customer->updateBonus($_POST['bonus_card'])){
			header("Location: ". _base_url."/cabinet/bonus/?t=bonus_info&success");
		}else{
			header("Location: ". _base_url."/cabinet/bonus/?t=bonus_info&unsuccess");
		}
	}
}
$ii = count($GLOBALS['IERA_LINKS'])-1;
$User->SetUser($_SESSION['member']);
$tpl->Assign('User', $User->fields);
$tpl->Assign('Customer', $Customer->fields);
$parsed_res = array('issuccess' => TRUE,
					'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_bonus.tpl'));
