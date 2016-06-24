<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$products = new Products();
	$Customer = new Customers();
	$User = new Users();
	$User->SetUser(isset($_SESSION['member'])?$_SESSION['member']:null);
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "UpdateAssort":
				if(isset($_POST['id_product'])){
					$res = $products->UpdateAssort2($_POST);
					echo json_encode($res);
				}
				exit();
				break;
			case "DelFromAssort":
				if(isset($_POST['id'])){
					$products->DelFromAssort($_POST['id'], $_POST['id_supplier']);
					$arr['id_product'] = $_POST['id'];
					echo json_encode($arr);
				}
				break;
			case "GetPreview":
				$id_product = $_POST['id_product'];
				$products->SetFieldsById($id_product);
				unset($parsed_res);
				if(isset($_SESSION['member'])){
					$User->SetUser($_SESSION['member']);
				}
				$tpl->Assign('User', $User->fields['name']);

				$product = $products->fields;
				$product['specifications'] = $products->GetSpecificationList($id_product);
				$product['images'] = $products->GetPhotoById($id_product);
				$product['videos'] = $products->GetVideoById($id_product);
				$tpl->Assign('product', $product);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'preview.tpl');
				break;
			case "add_favorite":
				// Добавление Избранного товара
				if(!G::isLogged()){
					$data['answer'] = 'login';
				}elseif(isset($_SESSION['member']['favorites']) && in_array($_POST['id_product'], $_SESSION['member']['favorites'])){
					$data['answer'] = 'already';
				}else{
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_){
						$Customer->AddFavorite($User->fields['id_user'], $_POST['id_product']);
						$_SESSION['member']['favorites'][] = $_POST['id_product'];
						$data['fav_count'] = count($_SESSION['member']['favorites']);
						$data['answer'] = 'ok';
					}else{
						$data['answer'] = 'wrong user group';
					}
				}
				echo json_encode($data);
				break;
			case "del_favorite":
				// Удаление Избранного товара (Старая версия)
					// if(isset($_POST['id_product'])){
					// 	$Customer->DelFavorite($User->fields['id_user'], $_POST['id_product']);
					// 	foreach($_SESSION['member']['favorites'] as $key => $value){
					// 		if($value == $_POST['id_product']){
					// 			unset($_SESSION['member']['favorites'][$key]);
					// 		}
					// 	}
					// 	$txt = json_encode('ok');
					// 	echo $txt;
					// }
				if(!G::isLogged()){
					$data['answer'] = 'login';
				}else{
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_){
						$Customer->DelFavorite($User->fields['id_user'], $_POST['id_product']);
						foreach($_SESSION['member']['favorites'] as $key => $value){
							if($value == $_POST['id_product']){
								unset($_SESSION['member']['favorites'][$key]);
							}
						}
						$data['fav_count'] = count($_SESSION['member']['favorites']);
						$data['answer'] = 'ok';
					}else{
						$data['answer'] = 'wrong user group';
					}
				}
				echo json_encode($data);
				break;
			case "add_in_waitinglist":
				// Добавление в список ожидания
					// if($_POST['id_user'] != '' && $_POST['email'] == '' && $_SESSION['member']['gid'] == _ACL_CUSTOMER_){
					// 	$data['answer'] = 'ok';
					// }elseif($_POST['email'] != '' && $_POST['id_user'] == ''){;
					// 	$arr['name'] = $_POST['email'];
					// 	$arr['email'] = $_POST['email'];
					// 	$arr['passwd'] = substr(md5(time()), 0, 6);
					// 	$arr['promo_code'] = '';
					// 	$arr['descr'] = '';
					// 	$data['answer'] = 'register_ok';
					// 	if(!$Customer->RegisterCustomer($arr)){
					// 		$data['answer'] = 'registered';
					// 	}
					// 	$User->CheckUserNoPass($arr);
					// 	$_POST['id_user'] = $User->fields['id_user'];
					// }else{
					// 	$data['answer'] = _ACL_CUSTOMER_;
					// 	//$data['answer'] = 'error';
					// }

				if(!G::isLogged()){
					$data['answer'] = 'login';
				}elseif(isset($_SESSION['member']['waiting_list']) && in_array($_POST['id_product'], $_SESSION['member']['waiting_list'])){
					$data['answer'] = 'already';
				} else {
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_ || $User->fields['gid'] == _ACL_CUSTOMER_){
						if($Customer->AddInWaitingList($_POST['id_user'], $_POST['id_product']))
						{
							if (isset($_SESSION['member'])) {
								$_SESSION['member']['waiting_list'][] = $_POST['id_product'];
							}
							$data['fav_count'] = count($_SESSION['member']['waiting_list']);
							$data['answer'] = 'ok';
						}else{
							$data['answer'] = 'insert_error';
						}
					}
				}
				echo json_encode($data);
				break;
			case "del_from_waitinglist":
				// Удаление Из списка ожидания (старая версия)
					// if(isset($_POST['id_product'])){
					// 	$Customer->DelFromWaitingList($User->fields['id_user'], $_POST['id_product']);
					// 	if (isset($_SESSION['member'])) {
					// 		foreach($_SESSION['member']['waiting_list'] as $key => $value){
					// 			if($value == $_POST['id_product']){
					// 				unset($_SESSION['member']['waiting_list'][$key]);
					// 			}
					// 		}
					// 	}
					// 	$txt = json_encode('ok');
					// 	echo $txt;
					// }

				if(!G::isLogged()){
					$data['answer'] = 'login';
				}else {
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_ || $User->fields['gid'] == _ACL_CUSTOMER_){
						if($Customer->DelFromWaitingList($User->fields['id_user'], $_POST['id_product']))
						{
							if (isset($_SESSION['member'])) {
								foreach($_SESSION['member']['waiting_list'] as $key => $value){
									if($value == $_POST['id_product']){
										unset($_SESSION['member']['waiting_list'][$key]);
										$data['fav_count'] = count($_SESSION['member']['waiting_list']);
										$data['answer'] = 'ok';
									}
								}								
							}							
						}else{
							$data['answer'] = 'error';
						}
					}
				}
				echo json_encode($data);
				break;
			case "SaveGraph":
				echo json_encode($products->AddInsertTwoGraph($_POST));
				break;
			case "SearchGraph":
				$values = $products->SearchGraph($_POST['id_graphics']);
				$tpl->Assign('values', $values);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'graph_modal.tpl');
				//echo json_encode($products->SearchGraph($_POST['id_graphics']));
				break;
			case "OpenModalGraph":
				echo json_encode($tpl->Parse($GLOBALS['PATH_tpl_global'].'graph_modal.tpl'));
				break;
			case "UpdateGraph":
				if(isset($_POST['moderation'])){
					$mode = true;
					echo json_encode($products->UpdatetGraph($_POST, $mode));
				}else{
					echo json_encode($products->UpdatetGraph($_POST));
				}
				break;
			case "AddAstimate":
				if(!G::IsLogged()){
					$Users = new Users();
					require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
					list($err, $errm) = Change_Info_validate();
					$unique_phone = $Users->CheckPhoneUniqueness($_POST['phone']);
					if($unique_phone !== true) {
						$err = 1;
						$errm['phone'] = 'Пользователь с таким номером телефона уже зарегистрирован! Авторизуйтесь!';
					}
					$unique_email = $Users->CheckEmailUniqueness($_POST['email']);
					if((isset($_POST['email']) && $_POST['email'] !='')) {
						if($unique_email !== true) {
							$err = 1;
							$errm['email'] = 'Пользователь с таким email уже зарегистрирован!';
						}
					}
					if(!$err){
						$Customers = new Customers();
						//Перезаписываем данные в сессии
						$_SESSION['member']['name'] = (isset( $_POST['name']))?$_POST['name']:null;
						$_SESSION['member']['email'] = (isset( $_POST['email']))?$_POST['email']:null;
						$_SESSION['member']['phone'] = (isset( $_POST['phone']))?$_POST['phone']:null;

						if($Customers->AddCustomer($_POST)) echo json_encode('true');
					}else{
						print_r($errm);
						//echo json_encode($errm);
					}





					print_r($unique_phone); die();
				} else{
					print_r('зарегистрирован'); die();
				}


				print_r($_POST); die();

				break;
			default:
				break;
		}
		exit();
	}
}
