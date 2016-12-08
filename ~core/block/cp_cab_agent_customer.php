<?php
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/cabinet/agent/'
);

if(isset($_SERVER['HTTP_REFERER'])){
	$referer = explode('/',str_replace('http://', '', $_SERVER['HTTP_REFERER']));
	$tpl->Assign('referer', $referer);
}
if(isset($_REQUEST['confirm_agent']) && !G::isAgent() && $Users->ConfirmAgent()){
	header('Location: '.Link::Custom('cabinet', 'agent', array('clear' => true)));
}

$tpl->Assign('msg', array('type' => 'info', 'text' => 'Бонус начисляется только при условии успешного выполнения и рассчитывается с фактической суммы заказа.'));

$Users->SetUser($_SESSION['member']);
$tpl->Assign('User', $Users->fields);

$parsed_res = array(
	'issuccess' => TRUE,
	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_agent.tpl')
);