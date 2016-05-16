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
			case 'accessCode';
				$Users = new Users();
				$id_user = $User->CheckPhoneUniqueness($_POST['value']);
				if($id_user === true){
					$res['success'] = false;
					$res['msg'] = 'Пользователя с таким телефоном не найдено.';
				}else{
					$res['success'] = true;
					$res['content'] = '<p class="info_text">На указанный номер телефона [<span class="bold_text">'.$_POST['value'].'</span>] отправлен код подтверждения смены пароля.</p><p class="info_text">Код будет действителен в течение следующих <span class="bold_text">24 часов!</span></p>
								<input class="mdl-textfield__input" type="hidden" id="id_user" value="'.$id_user.'">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" type="number" id="recovery_code" name="code">
									<label class="mdl-textfield__label" for="recovery_code">Введите код</label>
									<span class="mdl-textfield__error"></span>
								</div>
								<button id="restore" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent btn_js">Восстановить</button>';
				}
				break;
				if(!$User->SetVerificationCode($id_user, $_POST['method'], $_POST['value'])){
					$res['success'] = false;
					$res['msg'] = 'Извините. Возникли неполадки. Повторите попытку позже.';
				}
				echo json_encode($res);
				break;

				break;
			case 'changePassword':
				$arr['id_user'] = (isset($_POST['id_user']) && $_POST['id_user'] !='')?$_POST['id_user']:false;
				$arr['passwd'] = (isset($_POST['passwd']) && $_POST['passwd'] !='')?$_POST['passwd']:false;
				$Users = new Users();
				switch ($_POST['method']){
					case 'CheckCurrentPasswd':
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