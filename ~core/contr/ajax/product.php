<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Products = new Products();
	$Customer = new Customers();
	$Users->SetUser(isset($_SESSION['member'])?$_SESSION['member']:null);
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'AddToAssort':
				if(isset($_POST['id_product'])){
					$res = $Products->AddToAssort($_POST['id_product'], isset($_POST['id_supplier'])?$_POST['id_supplier']:$_SESSION['member']['id_user']);
					echo json_encode($res);
				}
				break;
			case 'UpdateAssort':
				if(isset($_POST['id_product'])){
					$res = $Products->UpdateAssort($_POST);
					echo json_encode($res);
				}
				break;
			case 'DelFromAssort':
				if(isset($_POST['id_product'])){
					$Products->DelFromAssort($_POST['id_product'], isset($_POST['id_supplier'])?$_POST['id_supplier']:$_SESSION['member']['id_user']);
					$arr['id_product'] = $_POST['id_product'];
					echo json_encode($arr);
				}
				break;
			case 'GetPreview':
				$id_product = $_POST['id_product'];
				$Products->SetFieldsById($id_product);
				unset($parsed_res);
				if(isset($_SESSION['member'])){
					$Users->SetUser($_SESSION['member']);
				}
				$tpl->Assign('User', $Users->fields['name']);

				$product = $Products->fields;
				$product['specifications'] = $Products->GetSpecificationList($id_product);
				$product['images'] = $Products->GetPhotoById($id_product);
				$product['videos'] = $Products->GetVideoById($id_product);
				$tpl->Assign('product', $product);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'preview.tpl');
				break;
			case 'add_favorite':
				// Добавление Избранного товара
				if(!G::IsLogged()){
					$data['answer'] = 'login';
				}elseif(isset($_SESSION['member']['favorites']) && in_array($_POST['id_product'], $_SESSION['member']['favorites'])){
					$data['answer'] = 'already';
				}else{
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_){
						$Customer->AddFavorite($Users->fields['id_user'], $_POST['id_product']);
						$_SESSION['member']['favorites'][] = $_POST['id_product'];
						$data['fav_count'] = count($_SESSION['member']['favorites']);
						$data['answer'] = 'ok';
					}else{
						$data['answer'] = 'wrong user group';
					}
				}
				echo json_encode($data);
				break;
			case 'del_favorite':
				// Удаление Избранного товара (Старая версия)
					// if(isset($_POST['id_product'])){
					// 	$Customer->DelFavorite($Users->fields['id_user'], $_POST['id_product']);
					// 	foreach($_SESSION['member']['favorites'] as $key => $value){
					// 		if($value == $_POST['id_product']){
					// 			unset($_SESSION['member']['favorites'][$key]);
					// 		}
					// 	}
					// 	$txt = json_encode('ok');
					// 	echo $txt;
					// }
				if(!G::IsLogged()){
					$data['answer'] = 'login';
				}else{
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_){
						$Customer->DelFavorite($Users->fields['id_user'], $_POST['id_product']);
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
			case 'add_in_waitinglist':
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
					// 	$Users->CheckUserNoPass($arr);
					// 	$_POST['id_user'] = $Users->fields['id_user'];
					// }else{
					// 	$data['answer'] = _ACL_CUSTOMER_;
					// 	//$data['answer'] = 'error';
					// }

				if(!G::IsLogged()){
					$data['answer'] = 'login';
				}elseif(isset($_SESSION['member']['waiting_list']) && in_array($_POST['id_product'], $_SESSION['member']['waiting_list'])){
					$data['answer'] = 'already';
				} else {
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_ || $Users->fields['gid'] == _ACL_CUSTOMER_){
						if($Customer->AddInWaitingList($Users->fields['id_user'], $_POST['id_product']))
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
			case 'del_from_waitinglist':
				// Удаление Из списка ожидания (старая версия)
					// if(isset($_POST['id_product'])){
					// 	$Customer->DelFromWaitingList($Users->fields['id_user'], $_POST['id_product']);
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

				if(!G::IsLogged()){
					$data['answer'] = 'login';
				}else{
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_ || $Users->fields['gid'] == _ACL_CUSTOMER_){
						if($Customer->DelFromWaitingList($Users->fields['id_user'], $_POST['id_product'])){
							if(isset($_SESSION['member'])){
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
			case 'SaveDemandChart':
				echo json_encode($Products->AddDemandCharts($_POST));
				break;
			case 'SearchDemandChart':
				$values = $Products->SearchDemandChart($_POST['id_chart']);
				$tpl->Assign('values', $values);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'chart.tpl');
				//echo json_encode($Products->SearchDemandChart($_POST['id_chart']));
				break;
			case 'OpenModalDemandChart':
				if(isset($_POST['id_category'])){
					if($values = $Products->GetGraphList($_POST['id_category'], $_SESSION['member']['id_user'])) $tpl->Assign('values', $values);
				}
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'chart.tpl');
				break;
			case 'UpdateDemandChart':
				if(isset($_POST['moderation'])){
					$mode = true;
					echo json_encode($Products->UpdateDemandChart($_POST, $mode));
				}else{
					echo json_encode($Products->UpdateDemandChartNoModeration($_POST));
				}
				break;
			case 'ChartsByCategory':
				if(isset($_POST['id_category'])){
					$html = '';
					$charts = $Products->GetAllChartsByCategory($_POST['id_category']);
					foreach($charts as $key => $chart){
						$isActive = isset($_SESSION['member']) && $_SESSION['member']['id_user'] == $chart[0]['id_author']?'active':null;
						$html .= '<div class="chart_item mdl-cell mdl-cell--6-col '.$isActive.'">';
						$tpl->Assign('chart', $chart);
						$html .= $tpl->Parse($GLOBALS['PATH_tpl_global'].'charts.tpl');
						$html .= '<div class="charts_details">';
						$html .= '<p><span>Добавил(а):</span> '.$chart[0]['name_user'].'</p>';
						$html .= '<p><span>Создан:</span> '.$chart[0]['creation_date'].'</p>';
						if($chart[0]['comment'] != '') {
							$html .= '<p><span>Комментарий:</span> '.$chart[0]['comment'].'</p>';
						}
						if(isset($_SESSION['member']) && $_SESSION['member']['id_user'] == $chart[0]['id_author']){
							$html .= '<div class="chart_edit chart_edit_js" data-idcategory="'.$chart[0]['id_category'].'"><i id="edit_chart" class="material-icons">edit</i><div class="mdl-tooltip" for="edit_chart">Редактировать<br>график</div></div>';
						}
						$html .= '</div>';
						$html .= '</div>';

						// автора, его комментарий и дату создания.
					}
					echo $html;
				}
				break;
			case 'AddEstimate':
				//Проверка данных пользователя
				if(!G::IsLogged()){
					$Customers = new Customers();
					require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
					list($err, $errm) = Change_Info_validate();
					if($Users->CheckPhoneUniqueness($_POST['phone'])){
						$string_phone = preg_replace('~[^0-9]+~','', $_POST['phone']);
						if(strlen($string_phone) == 10){
							$phone_num = 38 + $string_phone;
						}elseif(strlen($string_phone) == 12) {
							$phone_num = $string_phone;
						}
						$data = array(
							'name' => $_POST['name'],
							'passwd' => $pass = G::GenerateVerificationCode(6),
							'descr' => 'Пользователь создан автоматически при загрузке сметы',
							'phone' => $phone_num
						);
						// регистрируем нового пользователя
						if($Customers->RegisterCustomer($data)){
							$Users->SendPassword($data['passwd'], $data['phone']);
						}
						$data = array(
							'email' => $phone_num,
							'passwd' => $pass
						);
						// авторизуем клиента в его новый аккаунт
						if($Users->CheckUser($data)){
							G::Login($Users->fields);
							_acl::load($Users->fields['gid']);
							$res['message'] = 'Пользователь авторизован';
							$res['status'] = 1;
						}
					}else{
						$res['message'] = 'Пользователь с таким номером телефона уже зарегистрирован! <a href="#" class="btn_js" data-name="auth">Авторизуйтесь!</a>';
						$res['status'] = 2;
					}
				}
				// Импорт файла
				if(G::IsLogged()){
					if(isset($_FILES['file'])){
						// Проверяем загружен ли файл
						if(is_uploaded_file($_FILES['file']['tmp_name'])){
							// Проверяем объем файла
							if($_FILES['file']['size'] > 1024*3*1024){
								$res['message'] = 'Размер файла превышает три мегабайта';
								$res['status'] = 3;
							}else{
								$folder_name = 'estimates/'.$_SESSION['member']['id_user'].'/';
								$pathname = $GLOBALS['PATH_root'].$folder_name;
								$images = new Images();
								$images->checkStructure($pathname);
								if(move_uploaded_file($_FILES['file']['tmp_name'], $pathname.$_FILES['file']['name'])) {
									// Если все загружено на сервер, выполнить запись в БД
									$file = '/'.$folder_name.$_FILES['file']['name'];
									$Products->UploadEstimate($file, $_POST['comment']);
									$res['message'] = '<h4>Загрузка прошла успешно!</h4><p>Загрузка сметы доступна только зарегестрированным пользователям.</p><br><p>Поэтому для Вас был создан аккаунт на сайте <span class="bold_text">xt.ua</span>.</p><br><p>На указанный при загрузке сметы номер телефона <span class="bold_text">'.$_POST['phone'].'</span> отправлено <span class="bold_text">смс-сообщение</span> с временным паролем для входа в личный кабинет.</p><br><p>Перейдите в свой <a href="'.Link::Custom('cabinet', 'settings', array('clear' => true)).'?t=password"><span class="bold_text">личный кабинет</span></a> для смены временного пароля на постоянный.</p>';
									$res['status'] = 1;
								}else{
									$res['message'] = '<h4>Произошла ошибка.</h4><p>Повторите попытку позже!</p>';
									$res['status'] = 4;
								}
							}
						}else{
							$res['message'] = 'Файл не был загружен!';
							$res['status'] = 5;
						}
					}
				}
				echo json_encode($res);
				break;
			case 'priceHelp':
				$Products->SetFieldsById($_POST['id_product']);
				$product = $Products->fields;
				$corrections = array(
					'opt' => explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['opt_correction_set']]),
					'mopt' => explode(';', $GLOBALS['CONFIG']['correction_set_'.$product['mopt_correction_set']])
				);
				$tpl->Assign('product', $product);
				$tpl->Assign('corrections', $corrections);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'bonus_explain.tpl');

				break;
			case 'GetGiftsList':
				$gifts = $Products->GetGiftsList();
				if(!empty($gifts)){
					foreach($gifts as &$gift){
						$gift['images'] = $Products->GetPhotoById($gift['id_product']);
					}
					$tpl->Assign('gifts', $gifts);
				}
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'product_label_modal.tpl');
				break;
			case 'agentGiftToggle':
				$promo = new promo();
				$res['success'] = $promo->TogglePromocodeGift($_POST['id_product'], 'AG'.$_POST['id_agent'], $_POST['add']);
				echo json_encode($res);
				break;
			default:
				break;
		}
		exit();
	}
}
