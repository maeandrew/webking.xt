<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'sign_in':
				if(isset($_COOKIE['PHPSESSID'])){
					if(G::IsLogged() && ($_SESSION['member']['gid'] != _ACL_SUPPLIER_MANAGER_ && !isset($_COOKIE['sm_login']))){
						$echo['msg'] = 'Вы уже авторизованы.';
						$echo['errm'] = 1;
					}else{
						// $to = "cabinet/";
						// if(isset($_POST['to'])){
						// 	$to = $_POST['to'];
						// }
						// if(isset($_SESSION['from']) && $_SESSION['from'] != 'login'){
						// 	$to = $_SESSION['from'].'/';
						// }
						// if(G::IsLogged() && ($_SESSION['member']['gid'] != _ACL_SUPPLIER_MANAGER_ && !isset($_COOKIE['sm_login']))){
						// 	header('Location: '._base_url.'/'.$to);
						// 	exit();
						// }
						$Customers = new Customers();
						unset($parsed_res);
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
									$echo['errm'] = 0;
								}else{
									$echo['msg'] = 'Неверный email или пароль.';
									$echo['errm'] = 1;
								}
							}else{
								if($User->CheckUser($_POST)){
									$User->LastLoginRemember($User->fields['id_user']);
									G::Login($User->fields);
									$echo['member'] = $_SESSION['member'];
									$echo['errm'] = 0;

								}else{
									$echo['msg'] = 'Неверный email или пароль.';
									$echo['errm'] = 1;
								}
							}
						}else{
							$echo['msg'] = 'Неверный email или пароль.';
							$echo['errm'] = 1;
						}
					}
				}else{
					$echo['msg'] = "В Вашем браузере отключены cookie или их прием заблокирован антивирусом. Без настройки этой функции авторизация на сайте невозможна.";
					$echo['errm'] = 1;
				}
				unset($_POST);
				echo json_encode($echo);
				exit();
				break;
			case 'register':
				if(isset($_POST['email'])){
					$email = trim($_POST['email']);
				}else{
					$email = '';
				}
				$Users = new Users();
				if($Users->ValidateEmail($email)){
					$Customers = new Customers();
					unset($parsed_res);
					$Page = new Page();
					$Page->PagesList();
					$tpl->Assign('list_menu', $Page->list);
					$header = 'Регистрация';
					$tpl->Assign('header', $header);
					$GLOBALS['IERA_LINKS'][] = array(
						'title' => $header,
						'url' => _base_url.'/register/'
					);
					if(G::IsLogged() && $_POST['type'] != 'success'){
						$tpl->Assign('msg_type', 'info');
						$tpl->Assign('msg', 'Вы уже зарегистрированы.');
						$parsed_res = array(
							'issuccess'	=> true,
							'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
						);
					}else{
						if(!strpos($_SERVER['HTTP_REFERER'], '/register/')){
							$_SESSION['backlink'] = $_SERVER['HTTP_REFERER'];
						}elseif(strpos($_SERVER['HTTP_REFERER'], '/register/') && !$_SESSION['backlink']){
							$_SESSION['backlink'] = $_SERVER['HTTP_HOST'];
						}
						$success = false;
						if(isset($_POST['smb'])){
							require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
							$_POST['address_ur'] = "";
							$_POST['descr'] = "";
							list($err, $errm) = Register_form_validate();
							if(!$err){
								if($id = $Customers->RegisterCustomer($_POST)){
									$tpl->Assign('msg', 'Пользователь добавлен.');
									$success = true;

								}else{
									$tpl->Assign('msg', 'Пользователь не добавлен.');
									$errm['email'] = "Такой email уже есть в базе.";
									$tpl->Assign('errm', $errm);
								}
							}else{
								$tpl->Assign('msg', 'Пользователь не добавлен.');
								$tpl->Assign('errm', $errm);
							}
						}
						if($success){
							// $_SESSION['SLGN']['contr'] = $contr[array_rand($contr)]['id_user'];
							if(isset($_POST['email']) && isset($_POST['passwd'])){
								$User = new Users();
								if($User->CheckUser($_POST)){
									if(isset($_POST['contr'])){
										$Customers->updateContragentOnRegistration($_POST['contr'], $User->fields['id_user']);
									}
									$User->LastLoginRemember($User->fields['id_user']);
									G::Login($User->fields);
								}else{
									$tpl->Assign('msg_type', 'error');
									$tpl->Assign('msg', 'Ошибка! Неверный email или пароль.');
									$tpl->Assign('errm', 1);
								}
							}
							$_SESSION['SLGN']['email'] = $_POST['email'];
							$_SESSION['SLGN']['passwd'] = $_POST['passwd'];
							$_SESSION['SLGN']['promo_code'] = $_POST['promo_code'];
							unset($_POST);
							header('Location:'._base_url.'/register/?type=success');
							exit();
						}else{
							unset($_POST);
							$parsed_res = array(
								'issuccess'	=> true,
								'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_register.tpl')
							);
						}
					}
					if(TRUE == $parsed_res['issuccess']){
						$tpl_center .= $parsed_res['html'];
					}
				}else{
					echo 'true';
				}
				break;
			case 'sign_out':
				break;
			default:
				break;
		}
		exit();
	}
}
?>