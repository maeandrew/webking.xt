<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_GET['action'])){
		switch($_GET['action']){
			case "login":
				if(isset($_COOKIE['PHPSESSID'])){
					$to = "cabinet/";
					if(isset($_GET['to'])){
						$to = $_GET['to'];
					}
					if(isset($_SESSION['from']) && $_SESSION['from'] != 'login'){
						$to = $_SESSION['from'].'/';
					}
					if(G::IsLogged() && ($_SESSION['member']['gid'] != _ACL_SUPPLIER_MANAGER_ && !isset($_COOKIE['sm_login']))){
						header('Location: '._base_url.'/'.$to);
						exit();
					}
					$Customers = new Customers();
					unset($parsed_res);
					if(isset($_SESSION['SLGN']['email']) && $_SESSION['SLGN']['passwd']){
						$_GET['email'] = $_SESSION['SLGN']['email'];
						$_GET['passwd'] = $_SESSION['SLGN']['passwd'];
						$_GET['contr'] = $_SESSION['SLGN']['contr'];
						unset($_SESSION['SLGN']);
					}
					if(isset($_GET['email']) && isset($_GET['passwd'])){
						$User = new Users();
						if((isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] == _ACL_SUPPLIER_MANAGER_) || isset($_COOKIE['sm_login'])){
							if($User->CheckUserNoPass($_GET)){
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
							unset($_GET);
						}else{
							if($User->CheckUser($_GET)){
								$User->LastLoginRemember($User->fields['id_user']);
								G::Login($User->fields);
								$echo['errm'] = 0;
							}else{
								$echo['msg'] = 'Неверный email или пароль.';
								$echo['errm'] = 1;
							}
						}
						unset($_GET);
					}
				}else{
					$echo['msg'] = "В Вашем браузере отключены cookie или их прием заблокирован антивирусом. Без настройки этой функции авторизация на сайте невозможна.";
					$echo['errm'] = 1;
				}
				$txt = json_encode($echo);
				echo $txt;
				exit();
			;
			break;
			case "getproductscount":
				$cnt = $Products->GetProductsCnt($where_arr, 0, $params);
				echo $cnt;
			;
			default:
			;
			break;
		}
		exit();
	}
}
?>