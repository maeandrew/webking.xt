<?php

	if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
		header('Content-Type: text/javascript; charset=utf-8');
		if(isset($_GET['action']))
		switch($_GET['action']) {
			case "validate":
				if(isset($_GET['email'])){
					$email = trim($_GET['email']);
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
					if(G::IsLogged() && $_GET['type'] != 'success'){
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
						if(isset($_GET['smb'])){
							require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
							$_GET['address_ur'] = "";
							$_GET['descr'] = "";
							list($err, $errm) = Register_form_validate();
							if(!$err){
								if($id = $Customers->RegisterCustomer($_GET)){
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
							if(isset($_GET['email']) && isset($_GET['passwd'])){
								$User = new Users();
								if($User->CheckUser($_GET)){
									if(isset($_GET['contr'])){
										$Customers->updateContragentOnRegistration($_GET['contr'], $User->fields['id_user']);
									}
									$User->LastLoginRemember($User->fields['id_user']);
									G::Login($User->fields);
								}else{
									$tpl->Assign('msg_type', 'error');
									$tpl->Assign('msg', 'Ошибка! Неверный email или пароль.');
									$tpl->Assign('errm', 1);
								}
							}
							$_SESSION['SLGN']['email'] = $_GET['email'];
							$_SESSION['SLGN']['passwd'] = $_GET['passwd'];
							$_SESSION['SLGN']['promo_code'] = $_GET['promo_code'];
							unset($_GET);
							header('Location:'._base_url.'/register/?type=success');
							exit();
						}else{
							unset($_GET);
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

			default:
			;
			break;
		}
	}

?>
