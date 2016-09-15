<?php
if(!_acl::isAllow('users')){
	die("Access denied");
}
$User = new Users();
$Supplier = new Suppliers();
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_user = $GLOBALS['REQAR'][1];
}else{
	header('Location: /404/');
	exit();
}
$tpl->Assign('h1', 'Редактирование поставщика');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Пользователи";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/users/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование поставщика";
if(!$Supplier->SetFieldsById($id_user, 1)){
	die('Ошибка при выборе пользователя.');
}
if(isset($_POST['clear-assort'])){
	if($Supplier->DelSupplierAssort($id_user)){
		echo '<script>alert("Все прошло успешно!");</script>';
	}else{
		echo '<script>alert("Произошла ошибка. Обратитесь к администратору");</script>';
	}
}
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Supplier_form_validate(array('passwd'));
    if(!$err){
    	if($id = $Supplier->UpdateSupplier($_POST)){
			$tpl->Assign('msg', 'Информация обновлена.');
			unset($_POST);
			if(!$Supplier->SetFieldsById($id_user, 1)) die('Ошибка при выборе поставщика.');
		}else{
			$tpl->Assign('msg', 'Информация не обновлена.');
			if($Supplier->db->errno == 1062){
				$errm['email'] = "Такой email уже есть в базе.";
				$tpl->Assign('errm', $errm);
			}
		}
    }else{
    	// показываем все заново но с сообщениями об ошибках
    	$tpl->Assign('msg', 'Ошибка! Информация не обновлена.');
        $tpl->Assign('errm', $errm);
    }
}
if(!isset($_POST['smb'])){
	foreach($Supplier->fields as $k=>$v){
		$_POST[$k] = $v;
	}
}
$tpl->Assign('id_supplier', $id_user);
$tpl->Assign('filials', $Supplier->GetFilialList());
$sup_cal = $Supplier->GetCalendar();
$cal = array();
$DaysOfWeek = array("Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб");
$date_block = time()+(3600*24*$GLOBALS['CONFIG']['order_day_end']); // дата, до которой дни не доступны для редактирования
$days_qty = 30+$GLOBALS['CONFIG']['order_day_end']; // количество отображаемых дней
for($ii=0; $ii<$days_qty; $ii++){
	$ts = (time()+$ii*3600*24);
	$date = date("Y-m-d", $ts);
	list($cal[$date]['y'], $cal[$date]['m'], $cal[$date]['d']) = explode("-", $date);
	$cal[$date]['date_dot'] = $cal[$date]['d'].'.'.$cal[$date]['m'].'.'.$cal[$date]['y']; 
	$cal[$date]['date_'] = $cal[$date]['d'].'_'.$cal[$date]['m'].'_'.$cal[$date]['y'];
	$arr = getdate($ts);
	if($ts>$date_block){
		$cal[$date]['active'] = 1;
	}else{
		$cal[$date]['active'] = 0;
	}
	$cal[$date]['day'] = 0;
	if(isset($sup_cal[$date])){
		$cal[$date]['day'] = $sup_cal[$date]['work_day'];
	}
	$cal[$date]['d_word'] = $DaysOfWeek[$arr['wday']];
	if($arr['wday'] == 1){
		unset($cal[$date]['day']);
	}
	if($arr['wday'] == 0 || $arr['wday'] == 6){
		$cal[$date]['red'] = true;
	}
}
$tpl->Assign('cal', $cal);
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_supplier_ae.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>