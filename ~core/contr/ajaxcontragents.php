<?php

if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
{

	header('Content-Type: text/javascript; charset=utf-8');
	
	if (isset($_POST['id_delivery']) && isset($_POST['id']) && isset($_POST['date'])){
		$id_delivery = intval($_POST['id_delivery']);
		$id = intval($_POST['id']);
		
		if (!preg_match("#[0-3][0-9]\.[0-1][0-9]\.[0-9]{4}#is", $_POST['date'])){
			$_POST['date'] = "99.99.9999";
		}
		
		list($d,$m,$y) = explode(".", $_POST['date']);
		$date = "$y-$m-$d";
		
		$sum = mysql_real_escape_string($_POST['sum']);

		$Contragent = new Contragents();
		switch ($id_delivery) {
			case '1':
					$Contragent->SetParkingList($id, $date, $sum);
			break;
			
			case '2':
					$Contragent->SetCityList($id, $date, $sum);
			break;

			case '3':
					$Contragent->SetDeliveryServiceList($id, $date, $sum);
			break;
			
			default:
				;
			break;
		}
	  	
		$txt = '

<style type="text/css">
   .shadowtext {
        color: #B5B5B5; /* Белый цвет текста */
    font-size: 16px; /* Размер надписи */
   }
  </style>

 
  <p class="shadowtext">Выберите пожалуйста менеджера, который будет обслуживать Ваш заказ</p> 
	<div id="contragentblock" class="clear">
		<label>Менеджер*</label>
		<select name="id_contragent" id="id_contragent" onChange="ShowCALink();">
		<option value="" disabled selected >--Менеджер не выбран--</option>';
		shuffle($Contragent->list);
		 foreach ($Contragent->list as $item){
			$txt .= "<option value=\"{$item['id_user']}\">{$item['name']}</option>\r\n";
		 }
$txt .= '</select>
	</div>
	<script>var contrurls = Array();</script>';

		foreach ($Contragent->list as $item){
			$txt .= "<script>contrurls[{$item['id_user']}] = \"{$item['site']}\";</script>";
		 }

		echo $txt;
		exit();

	}
	
	
	
	
	if (!G::IsLogged())
    	exit();
	
	$User = new Users();
	$User->SetUser($_SESSION['member']);

	if ($User->fields['gid'] != _ACL_CONTRAGENT_) {
		exit();
	}

	if (isset($_POST['date']) && isset($_POST['dn']) && ($_POST['dn'] == 'day' || $_POST['dn'] = 'night') && isset($_POST['sum'])){
	
			$arr['date'] = mysql_real_escape_string($_POST["date"]);
			$arr['sum'] = mysql_real_escape_string($_POST["sum"]);
			$arr['dn'] = $_POST['dn'];
			
			$Contragent = new Contragents();
			$Contragent->SwitchContragentDate($arr['date'], $arr['dn'], $arr['sum']);

			$txt = json_encode("ok");

			echo $txt;
	}

	exit();
}

?>