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
	if(isset($_POST['action'])){
		switch ($_POST['action']) {
			case 'RecalcCurrency':
				if (isset($_POST['cur']) && isset($_POST['cur_old'])) {
					$Supplier = new Suppliers();
					$Supplier->RecalcSupplierCurrency($_POST['cur'], $_POST['cur_old'], $_POST['id_supplier']);
					$txt = json_encode(array("ok" => true));
					echo $txt;
					exit();
				}
				break;
		}
	}
}