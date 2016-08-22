<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(!G::IsLogged()){
    	exit();
	}
	header('Content-Type: text/javascript; charset=utf-8');
	if(isset($_POST['date'])){
		$arr['date'] = $_POST["date"];
		$Supplier = new Suppliers();
		list($arr['switcher'], $arr['next_update_date']) = $Supplier->SwitchSupplierDate($arr['date']);
		$tmp = explode("-", $arr['next_update_date']);
		$arr['next_update_date'] = $tmp[2].".".$tmp[1].".".$tmp[0];
		$txt = json_encode($arr);
		echo $txt;
	}
}
exit(0);
