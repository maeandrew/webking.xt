<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'sign_in':
				if(isset($_COOKIE['PHPSESSID'])){
					if(G::IsLogged() && ($_SESSION['member']['gid'] != _ACL_SUPPLIER_MANAGER_ && !isset($_COOKIE['sm_login']))){
						$echo['msg'] = 'Вы уже авторизованы.';
						$echo['err'] = 1;
					}else{
						if(isset($_POST['email']) && isset($_POST['passwd'])){
							$User = new Users();
							if((isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] == _ACL_SUPPLIER_MANAGER_) || isset($_COOKIE['sm_login'])){
								if($User->CheckUserNoPass($_POST)){
									if(isset($_COOKIE['sm_login'])){
										setcookie('sm_login', '', time() - 30, "/");
									}else{
										setcookie('sm_login', true, time() + (86400 * 30), "/");
									}
									$User->LastLoginRemember($User->fields['id_user']);
									G::Login($User->fields);
									_acl::load($User->fields['gid']);
									$echo['err'] = 0;
								}else{
									$echo['msg'] = 'Неверный email или пароль.';
									$echo['err'] = 1;
								}
							}else{
								if($User->CheckUser($_POST)){
									$User->LastLoginRemember($User->fields['id_user']);
									G::Login($User->fields);
									_acl::load($User->fields['gid']);
									$echo['member'] = $_SESSION['member'];
									$echo['err'] = 0;

								}else{
									$echo['msg'] = 'Неверный email или пароль.';
									$echo['err'] = 1;
								}
							}
						}else{
							$echo['msg'] = 'Неверный email или пароль.';
							$echo['err'] = 1;
						}
					}
				}else{
					$echo['msg'] = "В Вашем браузере отключены cookie или их прием заблокирован антивирусом. Без настройки этой функции авторизация на сайте невозможна.";
					$echo['err'] = 1;
				}
				unset($_POST);
				echo json_encode($echo);
				break;
			case 'register':
				require_once($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
				list($err, $echo['errm']) = Register_form_validate();
				// Если все ок с валидацией
				if(!$err){
					$User = new Users();
					// проверяем уникальность введенного e-mail
					if($User->ValidateEmail($_POST['email'])){
						$_POST['address_ur'] = "";
						$_POST['descr'] = "";
						$Customers = new Customers();
						// Пытаемся зарегистрировать нового клиента
						if($id = $Customers->RegisterCustomer($_POST)){
							// Авторизуем нового пользователя минуя проверку пароля
							if($User->CheckUserNoPass($_POST['email'])){
								$echo['err'] = 0;
								$echo['msg'] = 'Спасибо за регистрацию';
								$User->LastLoginRemember($User->fields['id_user']);
								G::Login($User->fields);
								_acl::load($User->fields['gid']);
							}
						}else{
							$echo['err'] = 1;
							$echo['msg'] = 'Ой, что-то пошло не так';
						}
						
						// if($User->CheckUser($_POST)){
						// 	if(isset($_POST['contr'])){
						// 		$Customers->updateContragentOnRegistration($_POST['contr'], $User->fields['id_user']);
						// 	}
						// 	$User->LastLoginRemember($User->fields['id_user']);
						// 	G::Login($User->fields);
						// }else{
						// 	$tpl->Assign('msg_type', 'error');
						// 	$tpl->Assign('msg', 'Ошибка! Неверный email или пароль.');
						// 	$tpl->Assign('errm', 1);
						// }
					}else{
						$echo['errm']['email'] = 'Введен некорректный email';
						$echo['err'] = 1;
					}
				}else{
					$echo['err'] = 1;
				}
				echo json_encode($echo);
				break;
			case 'sign_out':
				break;
			case 'GetUserProfile':
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'user_profile.tpl');
				break;
			default:
				break;
		}
		exit();
	}
}