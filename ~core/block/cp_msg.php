<?php
$msg_type = 'error';
$msg = 'Такой страницы не предусмотрено.';
$ra = $GLOBALS['REQAR'];
if(isset($ra[1]) && is_numeric($ra[1])){
	$mid = $ra[1];
	switch($mid){
		case '1':
			$msg_type = 'error';
			$msg = 'Запрошенная Вами страница доступна только для зарегистрированных пользователей.';
		break;
		case '2':
			$msg_type = 'error';
			$msg = 'У Вас недостаточно прав для выполнения запрошенного действия либо запись отсутствует.';
		break;
		case '4':
			$msg_type = 'error';
			$msg = 'Такой страницы не существует.';
		break;
		case '5':
			$msg_type = 'error';
			$msg = 'Нет данных.';
		break;
	}
}else{
	header('Location: '. _base_url.'/404');
	exit();
}
$tpl->Assign('msg_type', $msg_type);
$tpl->Assign('msg', $msg);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
);
?>