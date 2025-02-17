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
							if((isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] == _ACL_SUPPLIER_MANAGER_) || isset($_COOKIE['sm_login'])){
								if($Users->CheckUserNoPass($_POST)){
									if(isset($_COOKIE['sm_login'])){
										setcookie('sm_login', '', time() - 30, "/");
									}else{
										setcookie('sm_login', true, time() + (86400 * 30), "/");
									}
									$Users->LastLoginRemember($Users->fields['id_user']);
									G::Login($Users->fields);
									_acl::load($Users->fields['gid']);
									$echo['err'] = 0;
								}else{
									$echo['msg'] = 'Неверный email или пароль.';
									$echo['err'] = 1;
								}
							}else{
								if($Users->CheckUser($_POST)){
									$Users->LastLoginRemember($Users->fields['id_user']);
									G::Login($Users->fields);
									_acl::load($Users->fields['gid']);
									$echo['member'] = $_SESSION['member'];
									$echo['err'] = 0;

									if($_SESSION['member']['gid'] == _ACL_CUSTOMER_){
										$customer = new Customers();
										$customer->SetSessionCustomerBonusCart($Users->fields['id_user']);
									}
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
					// проверяем уникальность введенного e-mail и телефона
					$unique_email = true;
					if(isset($_POST['email'])){
						if(!$Users->CheckEmailUniqueness($_POST['email'])){
							$err = 1;
							$echo['errm']['email'] = 'Пользователь с таким email уже зарегистрирован!';
						}
					}
					if(!$Users->CheckPhoneUniqueness($_POST['phone'])){
						$err = 1;
						$echo['errm']['phone'] = 'Пользователь с таким номером телефона уже зарегистрирован!';
					}
					if(!$err){
						$_POST['address_ur'] = "";
						$_POST['descr'] = "";
						$Customers = new Customers();
						// Пытаемся зарегистрировать нового клиента
						if($id_user = $Customers->RegisterCustomer($_POST)){
							$auth_data = array(
								'id_user' => $id_user,
								'passwd' => $_POST['passwd']
							);
							// Авторизуем нового пользователя минуя проверку пароля
							if($Users->CheckUser($auth_data)){
								$echo['err'] = 0;
								$echo['msg'] = 'Спасибо за регистрацию';
								$Users->LastLoginRemember($Users->fields['id_user']);
								G::Login($Users->fields);
								_acl::load($Users->fields['gid']);
							}
						}else{
							$echo['err'] = 1;
							$echo['msg'] = 'Ой, что-то пошло не так';
						}
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
			case 'accessRecovery':
				switch($_POST['method']){
					case 'email':
						if(!$id_user = $Users->GetUserIDByEmail($_POST['value'])){
							$res['success'] = false;
							$res['msg'] = 'Пользователя с таким email не найдено.';
						}else{
							$res['success'] = true;
							$res['content'] = '<p class="info_text tac">На указанный email<br>[<span class="bold_text">'.$_POST['value'].'</span>]<br>отправлено письмо с кодом для восстановления доступа к вашему профилю.</p><p class="info_text tac">Проверьте Вашу почту.</p>
								<input class="mdl-textfield__input" type="hidden" id="id_user" value="'.$id_user.'">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="number" id="recovery_code" name="code">
									<label class="mdl-textfield__label" for="recovery_code">Введите код</label>
									<span class="mdl-textfield__error"></span>
								</div>
								<button id="restore" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent btn_js">Восстановить</button>';
						}
						break;
					case 'sms':
						if(!$id_user = $Users->GetUserIDByPhone($_POST['value'])){
							$res['success'] = false;
							$res['msg'] = 'Пользователя с таким телефоном не найдено.';
						}else{
							$res['success'] = true;
							$res['content'] = '<p class="info_text">На указанный номер телефона [<span class="bold_text">'.$_POST['value'].'</span>] отправлен код для восстановления доступа к вашему профилю.</p><p class="info_text">Код будет действителен в течение следующих <span class="bold_text">24 часов!</span></p>
								<input class="mdl-textfield__input" type="hidden" id="id_user" value="'.$id_user.'">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="number" id="recovery_code" name="code">
									<label class="mdl-textfield__label" for="recovery_code">Введите код</label>
									<span class="mdl-textfield__error"></span>
								</div>
								<button id="restore" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent btn_js">Восстановить</button>';
						}
						break;
				}
				if($res['success']) {
					if(!$Users->SetVerificationCode($id_user, $_POST['method'], $_POST['value'])){
						$res['success'] = false;
						$res['msg'] = 'Извините. Возникли неполадки. Повторите попытку позже.';
					}
				}
				echo json_encode($res);
				break;
			case 'checkСode':
				if(!$Users->GetVerificationCode($_POST['id_user'],$_POST['code'])){
					$res['success'] = false;
					$res['msg'] = 'Введен неверный код.';
				}else{
					$res['success'] = true;
					$res['content'] = '<div id="sub_password_recovery" class="forPassStrengthContainer_js"><div><input class="mdl-textfield__input" type="hidden" id="id_user" value="'.$_POST['id_user'].'"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="password" name="new_passwd" id="passwd" required><label class="mdl-textfield__label" for="new_pass">Новый пароль:</label><span class="mdl-textfield__error"></span></div></div><div class="passStrengthContainer_js"><p class="ps_title">надежность пароля</p><div class="ps"><div class="ps_lvl ps_lvl_js"></div></div></div><div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input class="mdl-textfield__input" type="password" name="passwdconfirm" id="passwdconfirm"><label class="mdl-textfield__label" for="new_pass_one_more">Подтверждение нового пароля:</label><span class="mdl-textfield__error"></span></div></div><button id="confirm_btn" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent">Подтвердить</button></div>';
				}
				echo json_encode($res);
				break;
			case 'accessConfirm':
				if(isset($_POST['id_user']) && isset($_POST['passwd'])){
					$arr['id_user'] = $_POST['id_user'];
					$arr['passwd'] = $_POST['passwd'];
					if($Users->UpdateUser($arr)){
						if($Users->CheckUser($arr)) {
							$Users->LastLoginRemember($Users->fields['id_user']);
							G::Login($Users->fields);
							_acl::load($Users->fields['gid']);
							$res['success'] = true;
							$res['content'] = '<div class="auth_ok tac"><i class="material-icons">check_circle</i></div><p class="info_text" style="min-width: 300px; text-align: center;">Пароль успешно изменен!</p>';
						}
					}
				}
				echo json_encode($res);
				break;
			case 'recoverPhone':
				if(!$Users->SetVerificationCode($_SESSION['member']['id_user'], 'sms', $_POST['phone'])){
					$res['success'] = false;
					$res['msg'] = 'Извините. Возникли неполадки. Повторите попытку позже.';
					exit();
				}
				$res['success'] = true;
				$res['msg'] = 'Ура!!! Код отправлен.';
				echo json_encode($res);
				break;
			case 'checkСodePhone':
				if(!$Users->GetVerificationCode($_SESSION['member']['id_user'],$_POST['code'])){
					$res['success'] = false;
					$res['msg'] = 'Введен неверный код.';
				}else{
					if($Users->delDoublePhone($_POST['phone'])){
						$Users->UpdateUser(array('id_user'=>$_SESSION['member']['id_user'], 'phone'=>$_POST['phone']));
						$res['success'] = true;
						$res['content'] = 'ok';
					}
				}
				echo json_encode($res);
				break;
			default:
				break;
		}
		exit();
	}
}
