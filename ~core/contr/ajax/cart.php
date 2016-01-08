<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'GetCart':
				unset($parsed_res);
				$header = 'Корзина';
				$tpl->Assign('header', $header);

				// Подключаем необходимые классы
				$cart = new Cart();
				$order = new Orders();
				$customers = new Customers();
				$cities = new Citys();
				$contragents = new Contragents();
				$delivery = new Delivery();
				$deliveryservice = new DeliveryService();
				$regions = new Regions();
				if(G::IsLogged()){
					// о покупателе
					$customers->SetFieldsById($User->fields['id_user']);
					$customer = $customers->fields;
					$cont_person = explode(' ', $customer['cont_person']);
					$customer['last_name'] = $cont_person[0];
					$customer['first_name'] = isset($cont_person[1])?$cont_person[1]:'';
					$customer['middle_name'] = isset($cont_person[2])?$cont_person[2]:'';
				}
				$parsed_res = array(
					'issuccess'	=> true,
					'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cart.tpl')
				);
				if(true == $parsed_res['issuccess']){
					echo $parsed_res['html'];
				}
				break;
			
			default:
				# code...
				break;
		}
	}
	exit();
	if(!G::IsLogged()){
		$_SESSION['from'] = 'cart';
		header('Location: '._base_url.'/login/');
		exit();
	}else{
		$User = new Users();
		$User->SetUser($_SESSION['member']);
		$tpl->Assign('User', $User->fields);
	}

	if($User->fields['gid'] == _ACL_CUSTOMER_
		|| $User->fields['gid'] == _ACL_ANONYMOUS_
		|| $User->fields['gid'] == _ACL_DILER_
		|| $User->fields['gid'] == _ACL_MANAGER_
		|| $User->fields['gid'] == _ACL_TERMINAL_){
		// if($_SESSION['client']['user_agent'] == 'mobile'){

		// Устанавливаем базовый ценовой режим если пользователь не является менеджером
		if($User->fields['gid'] != _ACL_MANAGER_){
			$_SESSION['price_mode'] = 3;
		}
		// Подключаем необходимые классы
		$cart = new Cart();
		$order = new Orders();
		$customers = new Customers();
		$cities = new Citys();
		$contragents = new Contragents();
		$delivery = new Delivery();
		$deliveryservice = new DeliveryService();
		$regions = new Regions();
		// Все классы подключены


		// выборка базовых данных

		// о покупателе
		$customers->SetFieldsById($User->fields['id_user']);
		$customer = $customers->fields;
		$cont_person = explode(' ', $customer['cont_person']);
		$customer['last_name'] = $cont_person[0];
		$customer['first_name'] = isset($cont_person[1])?$cont_person[1]:'';
		$customer['middle_name'] = isset($cont_person[2])?$cont_person[2]:'';

		// список всех менеджеров
		if(substr($User->fields['email'], -11) == "@x-torg.com"){
			// внутренний
			// пользователи в служебных аккаунтах видят удаленных менеджеров
			$contragents->SetList(true, false);
		}else{
			// внешний
			// обычные пользователи не видят удаленных менеджеров
			$contragents->SetList(false, false);
		}
		$managers_list = $contragents->list;

		// список всех областей
		$regions->SetList();
		$regions_list = $regions->list;

		// список всех способов доставки
		$delivery->SetDeliveryList();
		$deliverymethods_list = $delivery->list;

		// выборка сохраненной информации

		// сохраненный город
		if($customer['id_city'] > 0){
			$cities->GetSavedFields($customer['id_city']);
			$saved['city'] = $cities->fields;
		}else{
			$saved['city'] = false;
		}

		// способы доставки
		if($customer['id_delivery'] > 0){
			$delivery->GetSavedFields($customer['id_delivery']);
			$saved['deliverymethod'] = $delivery->fields;
		}else{
			$saved['deliverymethod'] = false;
		}

		// сохраненный менеджер
		if($customer['id_contragent'] > 0){
			$contragents->GetSavedFields($customer['id_contragent']);
			$saved['manager'] = $contragents->fields;
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
			$cities_list = $cities->SetFieldsByInput($saved['city']['region']);
			if(!$deliveryservice->SetFieldsByInput($saved['city']['names_regions'])){
				unset($deliverymethods_list[3]);
			}
			$deliveryservice->SetListByRegion($saved['city']['names_regions']);
			$deliveryservices_list = $deliveryservice->list;
			$delivery->SetFieldsByInput($saved['city']['shipping_comp'], $saved['city']['names_regions']);
			$deliverydepartments_list = $delivery->list;
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

		/* Дествия */
		if(isset($GLOBALS['Rewrite']) && is_numeric($GLOBALS['Rewrite'])){
			if(isset($_POST['add_order'])){
				// Добавить к корзине товары из заказа
				$cart->FillByOrderId($GLOBALS['Rewrite'], true);
			}else{
				// заменить корзину товарами из заказа
				$cart->FillByOrderId($GLOBALS['Rewrite']);
			}
			if($User->fields['gid'] == _ACL_CONTRAGENT_){
				$customers->updateContPerson($_POST['cont_person']);
				$customers->updatePhones($_POST['phones']);
				$customers->updateCity($_POST['id_city']);
				$customers->updateDelivery($_POST['id_delivery']);
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
			$products = new Products();
			foreach($_SESSION['cart']['products'] as $id=>$p){
				$products->SetFieldsById($id);
				$product = $products->fields;
				$_SESSION['cart']['products'][$id]['name'] = $product['name'];
				$_SESSION['cart']['products'][$id]['art'] = $product['art'];
				$_SESSION['cart']['products'][$id]['id_category'] = $product['id_category'];
			}
			$tpl->Assign('cart', $_SESSION['cart']);
			$cart->ClearCart();
		}elseif(isset($GLOBALS['Rewrite']) && $GLOBALS['Rewrite'] == 'clear'){
			$cart->ClearCart();
			header('Location: '._base_url.'/cart/');
			exit();
		}

		/* проверка на ошибки */
		$errm = $warnings = array();
		$err = $warn = 0;
		$cart->IsActualPrices($err, $warn, $errm, $warnings);
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
		// Если нажата кнопка Сохранить черновик
		if(isset($_GET['type']) && $_GET['type'] == 'draft'){
			$_POST['p_order'] = true;
			if($id_order = $order->Add($_POST)){
				$success = true;
				$draft = 1;
			}
		}
		// Если нажата кнопка "Оформить заказ", "Редактировать информацию" или "Отменить редактирование"
		if((isset($_POST['p_order']) && !isset($_GET['type'])) || isset($_POST['order']) || isset($_POST['apply']) || isset($_POST['cancel'])){
			$draft = 0;
			if(isset($_POST['p_order'])){
				$draft = 1;
			}
			if(!isset($_POST['cont_person'])){
				$_POST['cont_person'] = trim($_POST['last_name']).' '.trim($_POST['first_name']).' '.trim($_POST['middle_name']);
			}
			if(isset($_POST['id_manager']) == false){
				$_POST['id_manager'] = $avaMan[array_rand($avaMan)]['id_user'];
			}
			if($_SESSION['member']['email'] != 'anonymous'){
				if(isset($_POST['apply'])){
					$_SESSION['strachovka'] = $_POST['strachovka'];
					$customers->updateContPerson($_POST['cont_person']);
					$customers->updatePhones($_POST['phones']);
					$customers->updateContragent($_POST['id_manager']);
					$customers->updateCity($_POST['id_delivery_department']);
					$customers->updateDelivery($_POST['id_delivery']);
					header('Location: '._base_url.'/cart/');
					exit();
				}else{
					require_once($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
					list($err, $errm) = Order_form_validate();
					if(!$err){
						if(isset($_POST['temporary']) && $_POST['temporary'] == 1){
							if($id = $order->Add($_POST)){
								$tpl->Assign('msg_type', 'success');
								$tpl->Assign('msg', 'Заказ сформирован.');
								$success = true;
								$customers->updateContPerson($_POST['cont_person']);
								$customers->updatePhones($_POST['phones']);
								$customers->updateCity($_POST['id_delivery_department']);
								$customers->updateDelivery($_POST['id_delivery']);
								unset($_POST);
								$id_order = $id;
							}else{
								$customers->updateContPerson($_POST['cont_person']);
								$customers->updatePhones($_POST['phones']);
								$customers->updateCity($_POST['id_delivery_department']);
								$customers->updateDelivery($_POST['id_delivery']);
							}
						}else{
							if($id = $order->Add($_POST)){
								$tpl->Assign('msg_type', 'success');
								$tpl->Assign('msg', 'Заказ сформирован.');
								$success = true;
								if($User->fields['gid'] != _ACL_TERMINAL_){
									$customers->updateContPerson($_POST['cont_person']);
									$customers->updatePhones($_POST['phones']);
									$customers->updateContragent($_POST['id_manager']);
									$customers->updateCity($_POST['id_delivery_department']);
									$customers->updateDelivery($_POST['id_delivery']);
								}
								unset($_POST);
								$id_order = $id;
							}else{
								if($User->fields['gid'] != _ACL_TERMINAL_){
									$customers->updateContPerson($_POST['cont_person']);
									$customers->updatePhones($_POST['phones']);
									$customers->updateContragent($_POST['id_manager']);
									$customers->updateCity($_POST['id_delivery_department']);
									$customers->updateDelivery($_POST['id_delivery']);
								}
							}
						}
					}else{
						// показываем все заново но с сообщениями об ошибках
						$customers->updateContPerson($_POST['cont_person']);
						$customers->updatePhones($_POST['phones']);
						$customers->updateContragent($_POST['id_manager']);
						$customers->updateCity($_POST['id_delivery_department']);
						$customers->updateDelivery($_POST['id_delivery']);
						$tpl->Assign('msg_type', 'success');
						$tpl->Assign('msg', 'Заказ не сформирован!');
						$tpl->Assign('errm', $errm);
					}
				}
			}else{
				require_once($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
				list($err, $errm) = Order_form_validate();
				if(!$err){
					if($id = $order->Add($_POST)){
						$tpl->Assign('msg_type', 'success');
						$tpl->Assign('msg', 'Заказ сформирован.');
						$success = true;
						unset($_POST);
						$id_order = $id;
					}
				}else{
					// показываем все заново но с сообщениями об ошибках
					$tpl->Assign('msg_type', 'error');
					$tpl->Assign('msg', 'Заказ не сформирован!');
					$tpl->Assign('errm', $errm);
				}
			}
		}
		/* colect cart information */
		$cart->RecalcCart();

		/* fill product list */
		if(!empty($_SESSION['cart']['products'])){
			$products = new Products();
			$arr = array();
			foreach($_SESSION['cart']['products'] as $id=>$p){
				$arr[] = $id;
			}
			$products->SetProductsListFromArr($arr, '');
			$list = $products->list;
			foreach($list as $key => &$value){
				if(isset($_SESSION['errm']['products'][$value['id_product']])){
					$value['err'] = 1;
					$value['errm'] = $_SESSION['errm']['products'][$value['id_product']];
				}else{
					$value['err'] = 0;
				}
				$errflag[$key] = $value['err'];
			}
			array_multisort($list, SORT_DESC, $errflag);
			$tpl->Assign('list', $list);
		}else{
			$tpl->Assign('list', false);
		}
		/* fill unavailable_product list */
		if(!empty($_SESSION['cart']['unavailable_products'])){
			$products = new Products();
			$arr = array();
			foreach($_SESSION['cart']['unavailable_products'] as $p){
				$products->SetFieldsById($p['id_product'], 1);
				$unlist[] = $products->fields;
			}
			$tpl->Assign('unlist', $unlist);
		}else{
			$tpl->Assign('unlist', false);
		}

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
			exit();
		}else{
			if(isset($GLOBALS['REQAR'][1]) && $GLOBALS['REQAR'][1] == 'makeorder' && $_SESSION['client']['user_agent'] == 'mobile'){
				$tpl->Assign('header', 'Оформление заказа');
				$parsed_res = array(
					'issuccess'	=> true,
					'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cart_makeorder.tpl')
				);
			}else{
				// Настройка панели действий ===============================
				$list_controls = array('layout');
				$tpl->Assign('list_controls', $list_controls);
				$parsed_res = array(
					'issuccess'	=> true,
					'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cart.tpl')
				);
			}
		}
	}else{
		$tpl->Assign('msg_type', 'info');
		$tpl->Assign('msg', 'Вы не можете использовать корзину.');
		$parsed_res = array(
			'issuccess'	=> true,
			'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl')
		);
	}
	if(true == $parsed_res['issuccess']){
		$tpl_center .= $parsed_res['html'];
	}
}
exit();
?>