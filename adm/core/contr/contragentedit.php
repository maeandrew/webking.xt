<?php
if(!_acl::isAllow('users'))
	die('Access denied');
$Contragent = new Contragents();
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_user = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
$tpl->Assign('h1', 'Добавление контрагента');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Пользователи';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/users/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Редактирование контрагента';
if (!$Contragent->SetFieldsById($id_user, 1)) die('Ошибка при выборе пользователя.');
$tpl->Assign('h1', 'Редактирование контрагента');
if($Contragent->SetRemittersList()){
	$tpl->Assign('remitters', $Contragent->list);
}
if(isset($_POST['smb'])){
	$_POST['details'] = '';
	foreach($Contragent->list as $detail){
		if(isset($_POST['details'.$detail['id']])){
			if($_POST['details'] != ''){
				$_POST['details'] .= ';';
			}
			$_POST['details'] .= $_POST['details'.$detail['id']];
		}
	}
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Contragents_form_validate(array('passwd'));
	if(!$err){
		if($id = $Contragent->UpdateContragent($_POST)){
			$tpl->Assign('msg', 'Информация обновлена.');
			unset($_POST);
			if(!$Contragent->SetFieldsById($id_user, 1)) die('Ошибка при выборе контрагента.');
		}else{
			$tpl->Assign('msg', 'Информация не обновлена.');
			if ($Contragent->db->errno == 1062){
				$errm['email'] = 'Такой email уже есть в базе.';
				$tpl->Assign('errm', $errm);
			}
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Ошибка! Информация не обновлена.');
		$tpl->Assign('errm', $errm);
	}
}
$Parking = new Parkings();
if($Parking->SetList()){
	$tpl->Assign('parkings', $Parking->list);
}
$Cities = new Cities();
if($Cities->SetList()){
	$tpl->Assign('cities', $Cities->list);
}
$DeliveryService = new DeliveryService();
if($DeliveryService->SetList()){
	$tpl->Assign('delivery_services', $DeliveryService->list);
}
if(!isset($_POST['smb'])){
	foreach($Contragent->fields as $k=>$v){
		$_POST[$k] = $v;
	}
	if(empty($_POST['parkings_ids'])){
		$_POST['parkings_ids'][] = 0;
	}
	if(empty($_POST['cities_ids'])){
		$_POST['cities_ids'][] = 0;
	}
	if(empty($_POST['delivery_services_ids'])){
		$_POST['delivery_services_ids'][] = 0;
	}
}
$Contragent->SetFieldsById($id_user);
$tpl->Assign('contragent', $Contragent->fields);
$contrdates = $Contragent->SetCurrentWeek();
$DaysOfWeek = array('Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб');
$ts = time();
for ($ii=0; $ii<=($GLOBALS['CONFIG']['order_day_end']+7); $ii++){
	$ts_tmp = $ts+86400*$ii;
	$arr = getdate($ts_tmp);
	$dates[date('d.m.Y', $ts_tmp)] = array('d_word' => $DaysOfWeek[$arr['wday']],
											'd' => date('Y_m_d', $ts_tmp));
	if ($arr['wday'] == 0 || $arr['wday'] == 6)
		$dates[date('d.m.Y', $ts_tmp)]['red'] = true;

	if (isset($contrdates[date('Y-m-d', $ts_tmp)])){
		$dates[date('d.m.Y', $ts_tmp)]['work_day'] = $contrdates[date('Y-m-d', $ts_tmp)]['work_day']!=0?1:0;
		$dates[date('d.m.Y', $ts_tmp)]['work_night'] = $contrdates[date('Y-m-d', $ts_tmp)]['work_night']!=0?1:0;
		$dates[date('d.m.Y', $ts_tmp)]['limit_sum_day'] = $contrdates[date('Y-m-d', $ts_tmp)]['limit_sum_day']!=0?$contrdates[date('Y-m-d', $ts_tmp)]['limit_sum_day']:'0';
		$dates[date('d.m.Y', $ts_tmp)]['limit_sum_night'] = $contrdates[date('Y-m-d', $ts_tmp)]['limit_sum_night']!=0?$contrdates[date('Y-m-d', $ts_tmp)]['limit_sum_night']:'0';
	}else{
		$dates[date('d.m.Y', $ts_tmp)]['work_day'] = 0;
		$dates[date('d.m.Y', $ts_tmp)]['work_night'] = 0;
		$dates[date('d.m.Y', $ts_tmp)]['limit_sum_day'] = 0;
		$dates[date('d.m.Y', $ts_tmp)]['limit_sum_night'] = 0;
	}
}
$tpl->Assign('dates', $dates);

$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_contragent_ae.tpl'));

if (TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}

// ---- right ----
