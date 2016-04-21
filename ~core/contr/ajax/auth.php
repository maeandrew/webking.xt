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
									_acl::load($Users->fields['gid']);
									$echo['errm'] = 0;
								}else{
									$echo['msg'] = 'Неверный email или пароль.';
									$echo['errm'] = 1;
								}
							}else{
								if($User->CheckUser($_POST)){
									$User->LastLoginRemember($User->fields['id_user']);
									G::Login($User->fields);
									_acl::load($User->fields['gid']);
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
			case 'GetUserProfile':
				?>

				<div class="userContainer" >
					<div class="UserInfBlock">
						<div id="userPic">
							<div class="avatarWrapp">
								<img src="/themes/default/images/noavatar.jpg"/>
							</div>
						</div>
						<div class="mainUserInf">
							<div id="userNameBlock">
								<div id="userNameInf" class="listItems">
									<span class="user_name"><?=$_SESSION['member']['name']?></span>
								</div>
								<a id="editUserProf" class="material-icons" href="<?=Link::Custom('cabinet', 'personal')?>">create</a>
								<div class="mdl-tooltip" for="editUserProf">Изменить<br>профиль</div>
							</div>
							<div class="listItems">
								<i class="material-icons">mail_outline</i>
								<span class="user_email"><?=isset($_SESSION['member']['email']) && $_SESSION['member']['email'] != ''?$_SESSION['member']['email']:"Регистрация без e-mail"?></span>
							</div>
							<script>GetLocation();</script>
							<div class="listItems">
								<i class="material-icons">location_on</i>
								<span class="userlocation"></span>
							</div>
						</div>
					</div>
					<div class="contacts <?=isset($_SESSION['member']['contragent']) && empty($_SESSION['member']['contragent'])?'hidden':null;?>">
						<div id="manager">Ваш менеджер: <span class="user_contr"><?=$_SESSION['member']['contragent']['name_c']?></span>
						</div>
						<div class="manager_contacts">
							<a href="tel:+380667205488">
								<i class="material-icons .noLink">phone</i>
								<span class="user_contr_phones"><?=$_SESSION['member']['contragent']['phones']?></span>
							</a>
						</div>
						<div class="manager_contacts">
							<a href="mailto:manager@xt.ua" target="blank">
								<i class="material-icons">mail_outline</i>
								<span>manager@xt.ua</span>
							</a>
						</div>
					</div>
					<div class="userChoice">
						<div id="userFavoritesList">
							<a href="#"><div class="favleft"><i class="material-icons">favorite</i></div>
							<div class="favright"><p>Избранные</p><p class="userChoiceFav">(<?=count($_SESSION['member']['favorites'])?>)</p></div></a>
						</div>
						<div id="userWaitingList">
							<a href="#"><div class="favleft"><i class="material-icons">trending_down</i></div>
							<div class="favright"><p>Лист<br> ожидания</p><p class="userChoiceWait">(<?=count($_SESSION['member']['waiting_list'])?>)</p></div></a>
						</div>
					</div>
					<div class="hidden"><span class="user_promo"><?=$_SESSION['member']['promo_code']?></span></div>
					<button class="menuUserInfBtn" id="mycabMenuUserInfBtn"
					onclick="window.location.href='<?=Link::Custom('cabinet')?>'">Мой кабинет</button>
					<button class="menuUserInfBtn" onclick="window.location.href='<?=Link::Custom('logout')?>'">Выйти</button>
				</div>
				<?php
				break;
			default:
				break;
		}
		exit();
	}
}