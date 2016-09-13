<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(!isset($_SESSION['Cart'])){
		$_SESSION['Cart']['products'] = array();
		$_SESSION['Cart']['sum'] = (float) 0;
	}
	$Users = new Users();
	$Cart = new Cart();
	$Customers = new Customers();
	$Products = new Products();
	$Orders = new Orders();
	if(G::IsLogged()){
		$Users->SetUser(G::GetLoggedData());
		$Customers->SetFieldsById($Users->fields['id_user']);
		$personal_discount = $Customers->fields['discount'];
	}
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'duplicate':
				$Cart->FillByOrderId($_POST['id_order'], (isset($_POST['add'])?1:''));
				$Cart->DBCart();
				echo json_encode(true);
				break;
			case 'GetCartPage':
				unset($parsed_res);
				if(G::IsLogged()){
					$Users->SetUser(G::GetLoggedData());
					$tpl->Assign('User', $Users->fields);
				}
				// Устанавливаем базовый ценовой режим если пользователь не является менеджером
				if($Users->fields['gid'] != _ACL_MANAGER_){
					$_SESSION['price_mode'] = 3;
				}
				// Подключаем необходимые классы
				$Cities = new Citys();
				$Contragents = new Contragents();
				$Delivery = new Delivery();
				$Deliveryservice = new DeliveryService();
				$Regions = new Regions();
				// Все классы подключены

				// выборка базовых данных

				// о покупателе
				$Customers->SetFieldsById($Users->fields['id_user']);
				$customer = $Customers->fields;
				$cont_person = explode(' ', $customer['cont_person']);
				$customer['last_name'] = $cont_person[0];
				$customer['first_name'] = isset($cont_person[1])?$cont_person[1]:'';
				$customer['middle_name'] = isset($cont_person[2])?$cont_person[2]:'';
				$customer['phone'] = isset($phones)?$phones:'';

				// список всех менеджеров
				$Contragents->SetList(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_CONTRAGENT_?true:false, isset($_SESSION['member'])&& $_SESSION['member']['gid'] == _ACL_CONTRAGENT_ && $_SESSION['member']['contragent']['remote'] == 1?true:false);
				$managers_list = $Contragents->list;

				// список всех областей
				$Regions->SetList();
				$regions_list = $Regions->list;

				// список всех способов доставки
				$Delivery->SetDeliveryList();
				$deliverymethods_list = $Delivery->list;

				// выборка сохраненной информации

				// сохраненный город
				if(isset($customer['id_city']) && $customer['id_city'] > 0){
					$Cities->GetSavedFields($customer['id_city']);
					$saved['city'] = $Cities->fields;
				}else{
					$saved['city'] = false;
				}

				// способы доставки
				if(isset($customer['id_delivery']) && $customer['id_delivery'] > 0){
					$Delivery->GetSavedFields($customer['id_delivery']);
					$saved['deliverymethod'] = $Delivery->fields;
				}else{
					$saved['deliverymethod'] = false;
				}

				// сохраненный менеджер
				if(isset($customer['id_contragent']) && $customer['id_contragent'] > 0){
					$Contragents->GetSavedFields($customer['id_contragent']);
					$saved['manager'] = $Contragents->fields;
				}else{
					$saved['manager'] = false;
				}

				// временнный менеджер
				$tempmanager = false;
				$_POST['tempmanager'] = 1;
				if($managers_list){
					foreach($managers_list as $am){
						if(!$saved['manager'] || $saved['manager']['id_user'] == $am['id_user']){
							$_POST['tempmanager'] = 0;
						}
					}
					if($_POST['tempmanager'] == 1){
						$tempmanager = $managers_list[array_rand($managers_list)];
					}
				}

				// Выбор доступных городов, если у пользователя была сохранена область
				if(isset($saved['city'])){
					$cities_list = $Cities->SetFieldsByInput($saved['city']['region']);
					if(!$Deliveryservice->SetFieldsByInput($saved['city']['name'], $saved['city']['region'])){
						unset($deliverymethods_list[3]);
					}
					$Deliveryservice->SetListByRegion($saved['city']['names_regions']);
					$deliveryservices_list = $Deliveryservice->list;
					$Delivery->SetFieldsByInput($saved['city']['shipping_comp'], $saved['city']['name'], $saved['city']['region']);
					$deliverydepartments_list = $Delivery->list;
				}

				/* output data */
				$tpl->Assign('customer', $customer);
				$tpl->Assign('regions_list', $regions_list);
				$tpl->Assign('deliverymethods_list', $deliverymethods_list);
				$tpl->Assign('cities_list', $cities_list);
				$tpl->Assign('deliveryservices_list', $deliveryservices_list);
				$tpl->Assign('deliverydepartments_list', $deliverydepartments_list);
				$tpl->Assign('managers_list', $managers_list);
				$tpl->Assign('saved', $saved);
				$tpl->Assign('personal_discount', isset($_SESSION['cart']) && isset($_SESSION['cart']['personal_discount'])?$_SESSION['cart']['personal_discount']:1);

				/* Действия */
				if(isset($GLOBALS['Rewrite']) && is_numeric($GLOBALS['Rewrite'])){
					if(isset($_POST['add_order'])){
						// Добавить к корзине товары из заказа
						$Cart->FillByOrderId($GLOBALS['Rewrite'], true);
					}else{
						// заменить корзину товарами из заказа
						$Cart->FillByOrderId($GLOBALS['Rewrite']);
					}
					if($Users->fields['gid'] == _ACL_CONTRAGENT_){
						$Customers->updateContPerson($_POST['cont_person']);
						$Customers->updatePhones($_POST['phones']);
						$Customers->updateCity($_POST['id_city']);
						$Customers->updateDelivery($_POST['id_delivery']);
						if($_POST['bonus_card'] != '') {
							$_SESSION['member']['bonus_card'] = $_POST['bonus_card'];
						}else{
							unset($_SESSION['member']['bonus_card']);
						}
					}
					unset($_POST);
					header('Location: '._base_url.'/cart/');
					exit();
				}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'success'){
					foreach($_SESSION['cart']['products'] as $id=>$p){
						$Products->SetFieldsById($id);
						$product = $Products->fields;
						$_SESSION['cart']['products'][$id]['name'] = $product['name'];
						$_SESSION['cart']['products'][$id]['art'] = $product['art'];
						$_SESSION['cart']['products'][$id]['id_category'] = $product['id_category'];
					}
					$tpl->Assign('cart', $_SESSION['cart']);
					$Cart->ClearCart();
				}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'clear'){
					$Cart->ClearCart();
					header('Location: '._base_url.'/cart/');
					exit();
				}

				/* проверка на ошибки */
				$errm = $warnings = array();
				$err = $warn = 0;
				// $Cart->IsActualPrices($err, $warn, $errm, $warnings);
				if($err){
					if(isset($_SESSION['errm'])){
						$_SESSION['errm'] = array_merge($_SESSION['errm'], $errm);
					}else{
						$_SESSION['errm'] = $errm;
					}
				}
				unset($_SESSION['warnings']);
				if($warn){
					$_SESSION['warnings'] = $warnings;
				}

				if(!empty($_SESSION['cart']['unvisible_products'])){
					foreach($_SESSION['cart']['unvisible_products'] as $k=>&$v){
						$Cart->UpdateCartQty(array('id_product' => $k, 'quantity' => $v['quantity']));
					}
					unset($_SESSION['cart']['unvisible_products']);
				}
				/* collect cart information */
				$Cart->RecalcCart();
				/* fill product list */
				if(!empty($_SESSION['cart']['products'])){
					$arr_id = array();
					foreach($_SESSION['cart']['products'] as $id=>$p){
						$arr_id[] = $id;
					}
					$Products->SetProductsListFromArr($arr_id, '');
					$list = $Products->list;
					foreach($list as $key => &$value){
						if($value['visible'] == 0){
							$_SESSION['cart']['unvisible_products'][$value['id_product']]['quantity'] = $_SESSION['cart']['products'][$value['id_product']]['quantity'];
							$unlist[] = $value;
							unset($list[$key], $_SESSION['cart']['products'][$value['id_product']]);
						}
						if(isset($_SESSION['errm']['products'][$value['id_product']])){
							$value['err'] = 1;
							$value['errm'] = $_SESSION['errm']['products'][$value['id_product']];
						}else{
							$value['err'] = 0;
						}
						$errflag[$key] = $value['err'];
						$value['images'] = $Products->GetPhotoById($value['id_product']);
					}
					//array_multisort($list, SORT_DESC, $errflag);

					$tpl->Assign('unlist', isset($unlist)?$unlist:false);
					$tpl->Assign('list', $list);
				}else{
					$tpl->Assign('list', false);
				}
				$Cart->RecalcCart();
				if(isset($_SESSION['cart']['id_customer'])){
					$customer_order = $Customers->SetFieldsById($_SESSION['cart']['id_customer'], 1, true);
					$customer_order['last_order'] = $Orders->GetLastOrder($_SESSION['cart']['id_customer']);
					$tpl->Assign('customer_order', $customer_order);
				}
				$tpl->Assign('promo_info', 'Информация о введенном промокоде'); //Временный текст
				$tpl->Assign('msg', array('type' => 'info', 'text' => 'Если у Вас уже есть аккаунт на нашем сайте, воспользуйтесь <a href="#" class="btn_js" data-name="auth">формой входа</a>'));
				if(isset($success)){
					// $tpl->Assign('msg', "Заказ успешно сформирован.");
					$_SESSION['cart']['draft'] = $draft;
					$_SESSION['cart']['id_order'] = $id_order;
					$tpl->Assign('cart', $_SESSION['cart']);
					if($draft == 1){
						header('Location: '._base_url.'/cart/success/?type=draft');
					}else{
						header('Location: '._base_url.'/cart/success/?type=order');
					}
				}else{
					if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'makeorder' && $_SESSION['client']['user_agent'] == 'mobile'){
						$tpl->Assign('header', 'Оформление заказа');
						echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cart_makeorder.tpl');
					}else{
						// Настройка панели действий ===============================
						$list_controls = array('layout');
						$tpl->Assign('list_controls', $list_controls);
						echo $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cart.tpl');
					}
				}
				break;
			case 'remove_from_cart':
				if(isset($_POST['id_prod_for_remove'])){
					$res = $Cart->DBCart();
					if(count($_SESSION['cart']['products']) == 0){
						$Cart->ClearCart(isset($_SESSION['cart']['id'])?$_SESSION['cart']['id']:null);
					}
				}else{
					$res = null;
				}
				echo json_encode($res);
				break;
			case 'updateCartQty':
				if(isset($_POST['note'])){
					$_SESSION['cart']['products'][$_POST['id_product']]['note'] = $_POST['note'];
					$res = 'ok';
				}
				if(isset($_POST['quantity'])){
					$res = $Cart->UpdateCartQty($_POST);
				}
				$Cart->DBCart();
				echo json_encode($res);
				break;
			case 'GetCart':
				echo json_encode($_SESSION['cart']);
				break;
			case 'update_note':
				if(isset($_SESSION['cart']['products'][$_POST['id_product']]) && !empty($_SESSION['cart']['products'][$_POST['id_product']])){
					$_SESSION['cart']['products'][$_POST['id_product']]['note'] = $_POST['note'];
					$txt = 'ok';
				}else{
					$txt = 'not';
				}
				echo json_encode($txt);
				exit();
				break;
			case 'clearCart':
				// print_r($_SESSION['cart']['id']);
				$res = $Cart->ClearCart(isset($_SESSION['cart']['id'])?$_SESSION['cart']['id']:null);
				echo json_encode($res);
				break;
			case 'getCustomerInfo':
				if(isset($_POST['phone'])){
					$phone = preg_replace('/[^\d]+/', '', $_POST['phone']);
					$id_user = $Users->CheckPhoneUniqueness($phone, false);
					if($id_user === true){
						$res = '<div class="no_results_info">
									<p>По данному номеру телефона '.$phone.' не найдено пользователей.</p>
									<p>Вы можете создать нового пользователя с таким номером.</p>
							   </div>';
					}else{
						$customer_data = $Customers->SetFieldsById($id_user, 1, true);
						$customer_data['last_order'] = $Orders->GetLastOrder($id_user);
						$res = '<div class="customer_main_info">
									<input type="hidden" value="' .$id_user. '">
									<p><span>ФИО:</span> ' .(!empty($customer_data['first_name']) || !empty($customer_data['last_name']) || !empty($customer_data['middle_name']) ?$customer_data['last_name'].' '.$customer_data['first_name'].' '.$customer_data['middle_name']:(!empty($customer_data['name'])?$customer_data['name']:null)). '</p>
									<p><span>email:</span> ' .($customer_data['email']?$customer_data['email']:' --'). '</p>
									<p><span>Баланс:</span> ' .($customer_data['balance']?$customer_data['balance']:' 0,00'). ' грн.</p>
									<p><span>Последний заказ:</span> ' .($customer_data['last_order']?$customer_data['last_order']:' --'). '</p>
									<p><span>Активность:</span> ' .($customer_data['active'] ==1?'Да':'Нет'). '</p>
								</div>
								<div class="bonus_block">';
						if(!empty($customer_data['bonus_card'])){
							$res .= '<p><span>Бонусная карта:</span> №'.(!empty($customer_data['bonus_card'])?$customer_data['bonus_card']:' --').'</p>
									<p><span>Бонусный баланс:</span> '.(!empty($customer_data['bonus_balance'])?$customer_data['bonus_balance'].' грн.':' --').'</p>
									<p><span>Бонусный процент:</span> '.(!empty($customer_data['bonus_discount'])?$customer_data['bonus_discount'].' %':' --').'</p>';
						}else{
							$res .= 'Бонусная карта не активирована.';
						}
						$res .=	'</div>';
					}
				}else {
					$res = 'Номер телефона не введен.';
				}
				echo $res;
				break;
			case 'createCustomer':
				// создаем нового пользователя
				$data = array(
					'last_name' => isset($_POST['last_name'])?$_POST['last_name']:null,
					'first_name' => isset($_POST['first_name'])?$_POST['first_name']:null,
					'middle_name' => isset($_POST['middle_name'])?$_POST['middle_name']:null,
					'name' => (!empty($_POST['last_name']))?$_POST['last_name'].' '.$_POST['first_name'].' '.$_POST['middle_name']:'user_'.rand(),
					'passwd' => $pass = G::GenerateVerificationCode(6),
					'descr' => 'Пользователь создан менеджером при оформлении корзины',
					'phone' => $_POST['phone'],
					'id_contragent' => $_SESSION['member']['id_user']
				);
				// регистрируем нового пользователя
				if($id_customer = $Customers->RegisterCustomer($data)){
					$Users->SendPassword($data['passwd'], $data['phone']);
					$_SESSION['cart']['id_customer'] = $id_customer;
					$res['message'] = 'успех';
					$res['status'] = 1;
				}else {
					$res['message'] = 'Произошла ошибка, повторите попытку.';
					$res['status'] = 2;
				}
				echo json_encode($res);
				break;
			case 'bindingCustomerOrder':
				$_SESSION['cart']['id_customer'] = $_POST['id_customer'];
				if($Customers->SetSessionCustomerBonusCart($_POST['id_customer'])){
					$res['message'] = 'успех';
					$res['status'] = 1;
				}else{
					$res['message'] = 'Произошла ошибка, повторите попытку.';
					$res['status'] = 2;
				}
				echo json_encode($res);
				break;
			case 'settCustomerForOrder':
				if(isset($_POST['step']) && isset($_POST['date'])){
					switch($_POST['step']){
						case 'add_and_set':
							// создаем нового пользователя
							$data = array(
								'name' => 'user_'.rand(),
								'passwd' => $pass = G::GenerateVerificationCode(6),
								'descr' => 'Пользователь создан автоматически при оформлении корзины',
								'phone' => $_POST['date']
							);
							// регистрируем нового пользователя
							$id_customer = $Customers->RegisterCustomer($data);
							if(isset($id_customer)){
								$Users->SendPassword($data['passwd'], $data['phone']);
								$_SESSION['cart']['id_customer'] = $id_customer;
								$res['message'] = 'успех';
								$res['status'] = 1;
							}else {
								$res['message'] = 'Произошла ошибка, повторите попытку.';
								$res['status'] = 2;
							}
							break;
						case 'set':
							$_SESSION['cart']['id_customer'] = $_POST['date'];
							$res['message'] = 'успех';
							$res['status'] = 1;
							break;
					}
				}else{
					$res['message'] = 'Что-то не так. Данные отсутствуют.';
					$res['status'] = 3;
				}
				echo json_encode($res);
				break;
			case 'makeOrder':
				$_SESSION['cart']['id_contragent'] = isset($_POST['id_contragent']) && !empty($_POST['id_contragent'])?$_POST['id_contragent']:null;
				if(!G::IsLogged()){
					// Если покупатель не авторизован, получаем введенный номер телефона
					$phone = preg_replace('/[^\d]+/', '', $_POST['phone']);
					// проверяем уникальность введенного номера телефона
					$unique_phone = $Users->CheckPhoneUniqueness($phone);
					if($unique_phone === true){
						$data = array(
							'name' => 'user_'.rand(),
							//'passwd' => $pass = substr(md5(time()), 0, 8),
							'passwd' => $pass = G::GenerateVerificationCode(6),
							'descr' => 'Пользователь создан автоматически при оформлении корзины',
							'phone' => $phone,
							'id_contragent' => isset($_POST['id_contragent']) && !empty($_POST['id_contragent'])?$_POST['id_contragent']:null
						);

						// регистрируем нового пользователя
						if($Customers->RegisterCustomer($data)){
							$Users->SendPassword($data['passwd'], $data['phone']);
						}
						$data = array(
							'email' => $phone,
							'passwd' => $pass
						);
						// авторизуем покупателя в его новый аккаунт
						if($Users->CheckUser($data)){
							G::Login($Users->fields);
							_acl::load($Users->fields['gid']);
							$res['new_user'] = true;
							unset($_POST['phone']);
						}
					}else{
						$res['message'] = 'Пользователь с таким номером телефона уже зарегистрирован!';
						$res['status'] = 501;
					}
				}
				if(G::IsLogged()){
					if(isset($_POST['phone'])){
						$unique_phone = $Users->CheckPhoneUniqueness($_POST['phone']);
						if($unique_phone === true){
							$date = array(
								'id_user' => $_SESSION['member']['id_user'],
								'phone' => $_POST['phone']
							);
							if(!$Users->UpdateUser($date)){
								$res['message'] = 'Возникла ошибка при сохранении телефона!';
								$res['status'] = 500;
								echo json_encode($res);
								exit();
							}
						}else{
							$res['message'] = 'Пользователь с таким номером телефона уже зарегистрирован!';
							$res['status'] = 501;
							echo json_encode($res);
							exit();
						}
					}
					// оформляем заказ
					if($id_order = $Orders->Add()){
						$Cart->clearCart(isset($_SESSION['cart']['id'])?$_SESSION['cart']['id']:null);
						$res['message'] = 'Заказ сформирован!';
						$res['status'] = 200;
						$_SESSION['member']['last_order'] = $id_order;
						// $Customers->updatePhones($phone);
					}else{
						$res['message'] = 'Ошибка формирования заказа!';
						$res['status'] = 500;
						// $Customers->updatePhones($phone);
					}
				}
				echo json_encode($res);
				break;
			case 'update_info':
				$Customers->updateInfoPerson($_POST);

				return json_encode(true);
				break;
			case 'CreateJointOrder':
				if(!$res['promo'] = $Cart->CreatePromo('JO')){
					$res['promo'] = 'Ошибка формирования совместного заказа.';
				};
				echo json_encode($res['promo']);
				break;
			case 'CheckPromo':
				if(!$Cart->CheckPromo($_POST['promo'])){
					$res['promo'] = false;
					$res['msg'] = 'Ошибка! Такого промокода не существует. Проверьте правильность ввода.';
				} else{
					$res['promo'] = true;
				}
				echo json_encode($res);
				break;
			case 'ReadyUserJO':
				if(!$Cart->UpdateCart(false, false, false, 1, $_POST['id_cart'])){
					echo json_encode('no');
				};
				echo json_encode('ok');
				break;
			case 'DeletePromo':
				$echo = true;
				if(!$Cart->UpdateCart(null, 0, 1, 0, $_POST['id_cart'])){
					$echo = false;
				}
				echo json_encode($echo);
				break;
			case 'SaveOrderNote':  print_r(1); die();
				$echo = true;
				if(!$Cart->UpdateCartNote($_POST['note'])){
					$echo = false;
				}
				echo json_encode($echo);
				break;
			case 'updateDiscount':
				if(is_numeric($_POST['manual_price_change']) && $_POST['manual_price_change_note']) {
					$_SESSION['cart']['manual_price_change'] = $_POST['manual_price_change'];
					$_SESSION['cart']['manual_price_change_note'] = $_POST['manual_price_change_note'];
					$echo = true;
				}else{
					$echo = false;
				}
				echo json_encode($echo);
				break;
			default:
				break;
		}
	}
}
exit();
