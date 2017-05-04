<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/bonus/'
);
if(isset($_POST['id_order']) && !empty($_POST['id_order'])) $id_order = intval($_POST['id_order']);
$Customer = new Customers();
$Customer->SetFieldsById($Users->fields['id_user']);
if(isset($_POST['save_bonus'])){
	if($Customer->registerBonus($_POST)){
		header("Location: ".Link::Custom('cabinet', 'bonus', array('clear'=>true))."?t=bonus_info&success");
		exit();
	}
	header("Location: ".Link::Custom('cabinet', 'bonus', array('clear'=>true))."?t=change_bonus&error");
	exit();
}elseif(isset($_POST['update_bonus'])){
	if($Customer->updateBonus($_POST)){
		header("Location: ".Link::Custom('cabinet', 'bonus', array('clear'=>true))."?t=bonus_info&success");
		exit();
	}
	header("Location: ".Link::Custom('cabinet', 'bonus', array('clear'=>true))."?t=change_bonus&error");
	exit();
}
$ii = count($GLOBALS['IERA_LINKS'])-1;
$tpl->Assign('Customer', $Customer->fields);
if(!$Customer->fields['bonus_card'] && isset($_GET['t']) && $_GET['t'] == 'change_bonus'){
	$tpl->Assign('msg', array('type' => 'info', 'text' => 'Вы получили бонусную карту? Пришло время ее активировать!<br>Для этого заполните форму ниже, что поможет нам сделать Ваши покупки проще, а работу с нами - приятнее.'));
}
if(isset($_GET['success'])){
	$tpl->Assign('msg', array('type' => 'success', 'text' => 'Бонусная карта сохранена'));
}elseif(isset($_GET['error'])){
	$tpl->Assign('msg', array('type' => 'error', 'text' => 'Что-то пошло не так'));
}
$tpl->Assign('content', $tpl->Parse($GLOBALS['PATH_tpl_global'].'cab_'.(isset($_GET['t'])?$_GET['t']:'bonus_info').'.tpl'));
$parsed_res = array(
	'issuccess' => true,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_cab_bonus.tpl')
);
