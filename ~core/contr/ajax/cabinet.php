<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	$Cart = new Cart();
	$Orders = new Orders();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'GetProdList':
				$Order = new Orders();
				$Products = new Products();
				$list = $Order->GetOrderForCustomer(array("o.id_order" => $_POST['id_order']));
				foreach($list as &$p){
					$p['images'] = $Products->GetPhotoById($p['id_product']);
				}
				$tpl->Assign('list', $list);
				$tpl->Assign('rewrite', $_POST['rewrite']);
				// echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_orders_prod_list.tpl');
				$tpl->Assign('prod_list', $tpl->Parse($GLOBALS['PATH_tpl_global'].'order_products_list.tpl'));
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'order_products_list.tpl');
				break;
			case 'GetProdListForCart':
				$Cart = new Cart();
				$list = $Cart->GetProductsForCart($_POST['id_cart']);

				$tpl->Assign('list', $list);
				// echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_orders_prod_list.tpl');
				$tpl->Assign('prod_list', $tpl->Parse($GLOBALS['PATH_tpl_global'].'order_products_list.tpl'));
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'order_products_list.tpl');
				break;
			case 'GetProdListForJO':
				$Cart = new Cart();
				$list = $Cart->GetProductsForCart($_POST['id_cart']);
				$tpl->Assign('list', $list);
				$tpl->Assign('rewrite', $_POST['rewrite']);
				$tpl->Assign('prod_list', $tpl->Parse($GLOBALS['PATH_tpl_global'].'order_products_list.tpl'));
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'order_products_list.tpl');
				// $test = $tpl->Parse($GLOBALS['PATH_tpl_global'].'test.tpl');
				// echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_customer_cab_joint_orders_prod_list.tpl');
				// echo json_encode($list);
				//print_r($list); die();
				break;
			case 'DelCartFromJO':
				if(isset($_POST['id_cart'])) {
					if (!$list = $Cart->UpdateCart(null, 0, 1, 0, $_POST['id_cart'])) {
						echo json_encode(false);
					};
					echo json_encode(true);
				} else {
					echo json_encode(false);
				}
				break;
			case 'MakeOrderJO';
				$result = $Cart->CheckCartReady($_POST['promo']);
				if ($result === false){
					$res['success'] = false;
					$res['msg'] = 'Ой! Что-то пошло не так. Повторите попытку позже';
				}else{
					if($result > 0){
						$res['success'] = false;
						$res['msg'] = 'Есть пользователи с неподтвержденным заказ';
					}else{
						if($id_order = $Orders->Add($_POST['promo'])){
							$Cart->UpdateStatusCart($_POST['promo'], 12);
							$res['success'] = true;
							$res['msg'] = 'Заказ сформирован!';
						}else{
							$res['success'] = false;
							$res['msg'] = 'Ошибка формирования заказа!';
						}
					}
				}

				echo json_encode($res);
				break;
			case 'GetRating':
				$Contragents = new Contragents();
				echo json_encode($Contragents->GetRating($_POST));
				break;
			case 'ChangeInfoUser':
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
					//Перезаписываем данные в сессии
					$_SESSION['member']['name'] = $_POST['cont_person'];
					$_SESSION['member']['email'] = $_POST['email'];
					$_SESSION['member']['phone'] = $_POST['phone'];
					if($Customers->updateCustomer($_POST) && $Users->UpdateUser($_POST)){
						echo json_encode('true');
					}
					if(isset($_POST['avatar'])){
						$old_path = $GLOBALS['PATH_global_root'].$_POST['avatar'];
						$new_path = $GLOBALS['PATH_global_root'].'images/avatars/'.$_SESSION['member']['id_user'].'.jpeg';
						if(copy($old_path, $new_path)){
							unlink($old_path);
						}
					}
				}else{
					echo json_encode($errm);
				}

				break;
			case 'AccessCode';
				if(!$Users->SetVerificationCode($_POST['id_user'], $_POST['method'], $_POST['phone'])){
					$res['success'] = false;
					$res['msg'] = 'Извините. Возникли временные неполадки. Повторите попытку позже.';
				}else{
					$res['success'] = true;
				}
				echo json_encode($res);
				break;

			case 'ChangePassword':
				if((isset($_POST['id_user']) && $_POST['id_user'] !='') && (isset($_POST['new_passwd']) && $_POST['new_passwd'] !='')){
					$pas['id_user'] = $_POST['id_user'];
					$pas['passwd'] = $_POST['new_passwd'];
					switch ($_POST['method']){
						case 'current_pass':
							if(!$Users->CheckCurrentPasswd($_POST['curr_pass'], $_POST['id_user'])){
								$res['success'] = false;
								$res['msg'] = 'Неверный пароль';
							} else{
								if($update = $Users->UpdateUser($pas)) {
									$res['success'] = true;
									$res['msg'] = 'Ура! У нас получилось';
								} else {
									$res['success'] = false;
									$res['msg'] = 'Извините. Возникли временные неполадки. Повторите попытку позже.';
								}
							}
							break;
						case 'verification_code';
							if(!$Users->GetVerificationCode($_POST['id_user'], $_POST['code'])){
								$res['success'] = false;
								$res['msg'] = 'Вы ввели неверное значение';
							} else{
								if($update = $Users->UpdateUser($pas)) {
									$res['success'] = true;
									$res['msg'] = 'Ура! У нас получилось';
								} else {
									$res['success'] = false;
									$res['msg'] = 'Извините. Возникли временные неполадки. Повторите попытку позже.';
								}
							}
							break;
					}
				} else {
					$res['success'] = false;
					$res['msg'] = 'Извините. Возникли временные неполадки. Повторите попытку позже.';
				}
				echo json_encode($res);
				break;
			case 'deleteFromModeration':
				$Products = new Products();
				$Products->DeleteProductFromModeration($_POST['id']);
				echo json_encode(true);
				break;
			case 'updateUserNewsletter':
				$Newsletter = new Newsletter();
				switch($_POST['update']){
					case 'add':
						if($newsletter = $Newsletter->addUserNewsletter($_POST['id_newsletter']?$_POST['id_newsletter']:false)){
							echo 'ok';
						}else{
							echo 'something wrong';
						}
						break;
					case 'delete':
						if($newsletter = $Newsletter->delUserNewsletter($_POST['id_newsletter']?$_POST['id_newsletter']:false)){
							echo 'ok';
						}else{
							echo 'something wrong';
						}
						break;
				}
				break;
		}
	}
}
exit();