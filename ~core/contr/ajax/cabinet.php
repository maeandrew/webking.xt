<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'GetProdList':
				$Order = new Orders();
				$products = new Products();
				$list = $Order->GetOrderForCustomer(array("o.id_order" => $_POST['id_order']));
				foreach($list as &$p){
					$p['images'] = $products->GetPhotoById($p['id_product']);
				}
				$tpl->Assign('list', $list);
				echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_orders_prod_list.tpl');
				break;
			case 'GetProdListForCart':
				$Cart = new Cart();
				$list = $Cart->GetProductsForCart($_POST['id_cart']);
				$tpl->Assign('list', $list);
				echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_orders_prod_list.tpl');
				break;
			case 'GetRating':
				$C = new Contragents();
				$res = $C->GetRating($_POST);
				echo json_encode($res);
				break;
			case 'ChangeInfoUser':
				$Users = new Users();
				require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
				list($err, $errm) = Change_Info_validate();
				$unique_phone = $Users->CheckPhoneUniqueness($_POST['phone'], $_POST['id_user']);
				if((isset($_POST['email']) && $_POST['email'] !='')) {
					$unique_email = $Users->CheckEmailUniqueness($_POST['email'], $_POST['id_user']);
					if($unique_email !== true) {
						$err = 1;
						$errm['email'] = 'Пользователь с таким email уже зарегистрирован!';
					}
				}
				if($unique_phone !== true) {
					$err = 1;
					$errm['phone'] = 'Пользователь с таким номером телефона уже зарегистрирован!';
				}
				if(!$err){
					$Customers = new Customers();
					$_POST['cont_person'] = (isset($_POST['first_name'])?trim($_POST['first_name']):null) . ' ' . (isset($_POST['middle_name'])?trim($_POST['middle_name']):null) . ' ' . (isset($_POST['last_name'])?trim($_POST['last_name']):null);
					if($Customers->updateCustomer($_POST)) echo json_encode('true');
				}else{
					echo json_encode($errm);
				}

				break;
			case 'AccessCode';
				$Users = new Users();
				$id_user = $User->CheckPhoneUniqueness($_POST['phone'], $_POST['id_user']);
				if($id_user === true){
					$res['success'] = false;
					$res['msg'] = 'Пользователя с таким телефоном не найдено.';
				}else{
					$res['success'] = true;
				}
				if(!$User->SetVerificationCode($_POST['id_user'], $_POST['method'], $_POST['phone'])){
					$res['success'] = false;
					$res['msg'] = 'Извините. Возникли неполадки. Повторите попытку позже.';
				}
				echo json_encode($res);
				break;

			case 'ChangePassword':
				$arr['id_user'] = (isset($_POST['id_user']) && $_POST['id_user'] !='')?$_POST['id_user']:false;
				$arr['passwd'] = (isset($_POST['passwd']) && $_POST['passwd'] !='')?$_POST['passwd']:false;
				$Users = new Users();
				switch ($_POST['method']){
					case 'сheckCurrentPasswd':
						$Users->CheckCurrentPassword($_POST['method'], $_POST['id_user']);
						break;
					case 'verification_code';

						break;
				}




				$res = $Users->UpdateUser($arr);
				print_r(1);
				//echo json_encode($res);
				break;
		}
	}
}
exit();