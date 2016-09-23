<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$products = new Products();
	$Customer = new Customers();
	$User = new Users();
	$User->SetUser(isset($_SESSION['member'])?$_SESSION['member']:null);
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'AddToAssort':
				if(isset($_POST['id_product'])){
					$res = $products->AddToAssort($_POST['id_product'], isset($_POST['id_supplier'])?$_POST['id_supplier']:$_SESSION['member']['id_user']);
					echo json_encode($res);
				}
				break;
			case 'UpdateAssort':
				if(isset($_POST['id_product'])){
					$res = $products->UpdateAssort($_POST);
					echo json_encode($res);
				}
				break;
			case 'DelFromAssort':
				if(isset($_POST['id_product'])){
					$products->DelFromAssort($_POST['id_product'], isset($_POST['id_supplier'])?$_POST['id_supplier']:$_SESSION['member']['id_user']);
					$arr['id_product'] = $_POST['id_product'];
					echo json_encode($arr);
				}
				break;
			case 'GetPreview':
				$id_product = $_POST['id_product'];
				$products->SetFieldsById($id_product);
				unset($parsed_res);
				if(isset($_SESSION['member'])){
					$User->SetUser($_SESSION['member']);
				}
				$tpl->Assign('User', $User->fields['name']);

				$product = $products->fields;
				$product['specifications'] = $products->GetSpecificationList($id_product);
				$product['images'] = $products->GetPhotoById($id_product);
				$product['videos'] = $products->GetVideoById($id_product);
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
						$Customer->AddFavorite($User->fields['id_user'], $_POST['id_product']);
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
					// 	$Customer->DelFavorite($User->fields['id_user'], $_POST['id_product']);
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
						$Customer->DelFavorite($User->fields['id_user'], $_POST['id_product']);
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
					// 	$User->CheckUserNoPass($arr);
					// 	$_POST['id_user'] = $User->fields['id_user'];
					// }else{
					// 	$data['answer'] = _ACL_CUSTOMER_;
					// 	//$data['answer'] = 'error';
					// }

				if(!G::IsLogged()){
					$data['answer'] = 'login';
				}elseif(isset($_SESSION['member']['waiting_list']) && in_array($_POST['id_product'], $_SESSION['member']['waiting_list'])){
					$data['answer'] = 'already';
				} else {
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_ || $User->fields['gid'] == _ACL_CUSTOMER_){
						if($Customer->AddInWaitingList($_POST['id_user'], $_POST['id_product']))
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
					// 	$Customer->DelFromWaitingList($User->fields['id_user'], $_POST['id_product']);
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
				}else {
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_ || $User->fields['gid'] == _ACL_CUSTOMER_){
						if($Customer->DelFromWaitingList($User->fields['id_user'], $_POST['id_product']))
						{
							if (isset($_SESSION['member'])) {
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
				echo json_encode($products->AddDemandCharts($_POST));
				break;
			case 'SearchDemandChart':
				$values = $products->SearchDemandChart($_POST['id_chart']);
				$tpl->Assign('values', $values);
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'chart.tpl');
				//echo json_encode($products->SearchDemandChart($_POST['id_chart']));
				break;
			case 'OpenModalDemandChart':
				if(isset($_POST['id_category'])){
					if($values = $products->GetGraphList($_POST['id_category'], $_SESSION['member']['id_user'])) $tpl->Assign('values', $values);
				}
				echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'chart.tpl');
				break;
			case 'UpdateDemandChart':
				if(isset($_POST['moderation'])){
					$mode = true;
					echo json_encode($products->UpdateDemandChart($_POST, $mode));
				}else{
					echo json_encode($products->UpdateDemandChartNoModeration($_POST));
				}
				break;
			case 'ChartsByCategory':
				if(isset($_POST['id_category'])){
					$html = '';
					$charts = $products->GetAllChartsByCategory($_POST['id_category']);
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
				$Product = new Products();
				//Проверка данных пользователя
				if(!G::IsLogged()){
					$Users = new Users();
					$Customers = new Customers();
					require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
					list($err, $errm) = Change_Info_validate();
					$unique_phone = $Users->CheckPhoneUniqueness($_POST['phone']);
					if($unique_phone === true){
						$data = array(
							'name' => $_POST['name'],
							'passwd' => $pass = G::GenerateVerificationCode(6),
							'descr' => 'Пользователь создан автоматически при загрузке сметы',
							'phone' => $_POST['phone']
						);
						// регистрируем нового пользователя
						if($Customers->RegisterCustomer($data)){
							$Users->SendPassword($data['passwd'], $data['phone']);
						}
						$data = array(
							'email' => $_POST['phone'],
							'passwd' => $pass
						);
						// авторизуем клиента в его новый аккаунт
						if($Users->CheckUser($data)){
							G::Login($Users->fields);
							_acl::load($Users->fields['gid']);
							$res['message'] = 'Пользователь авторизован';
							$res['status'] = 1;
						}
					} else {
						$res['message'] = 'Пользователь с таким номером телефона уже зарегистрирован! Авторизуйтесь!';
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
							} else {
								$folder_name = 'estimates/'.$_SESSION['member']['id_user'].'/';
								$pathname = $GLOBALS['PATH_root'].$folder_name;
								$images = new Images();
								$images->checkStructure($pathname);
								if(move_uploaded_file($_FILES['file']['tmp_name'], $pathname.$_FILES['file']['name'])) {
									// Если все загружено на сервер, выполнить запись в БД
									$file = '/'.$folder_name.$_FILES['file']['name'];
									$Product->UploadEstimate($file, $_POST['comment']);
									$res['message'] = 'Загрузка прошла успешно';
									$res['status'] = 1;
								} else{
									$res['message'] = 'Произошла ошибка. Повторите попытку позже!';
									$res['status'] = 4;
								}
							}
						} else{
							$res['message'] = 'Файл не был загружен!';
							$res['status'] = 5;
						}
					}
				}
				echo json_encode($res);
				break;
			case 'priceHelp':
				$Products = new Products();
				$Products->SetFieldsById($_POST['id_product']);
				$product = $Products->fields;
				$helper = '<div class="prices_table">
								<div class="prices_table_title">
									<p>Таблица цен для тех хто в бронепоезде</p>
								</div>
								<div class="title_row">
									<div class="summ_title_cell column_cell_title">
										<p>Сумма заказа</p>
									</div>
									<div class="price_title_cell">
										<div class="price_cell">
											<p>Цена товара</p>
										</div>
										<div class="price_cell">
											<p>от '.$product['min_mopt_qty'].' шт.</p>
										</div>
										<div class="price_cell">
											<p>от '.$product['inbox_qty'].' шт.</p>
										</div>
									</div>
								</div>
								<div class="column_row">
									<div class="column_cell column_cell_title">до 500 грн.</div>
									<div class="column_cell">'.$product['prices_mopt'][3].' грн.</div>
									<div class="column_cell">'.$product['prices_opt'][3].' грн.</div>
								</div>
								<div class="column_row">
									<div class="column_cell column_cell_title">от 500 до 3000 грн.</div>
									<div class="column_cell">'.$product['prices_mopt'][2].' грн.</div>
									<div class="column_cell">'.$product['prices_opt'][2].' грн.</div>
								</div>
								<div class="column_row">
									<div class="column_cell column_cell_title">от 3000 до 10 000 грн.</div>
									<div class="column_cell">'.$product['prices_mopt'][1].' грн.</div>
									<div class="column_cell">'.$product['prices_opt'][1].' грн.</div>
								</div>
								<div class="column_row">
									<div class="column_cell column_cell_title">более 10 000 грн.</div>
									<div class="column_cell">'.$product['prices_mopt'][0].' грн.</div>
									<div class="column_cell">'.$product['prices_opt'][0].' грн.</div>
								</div>
							</div>
							<div class="msg-info bonus_info">
								<div class="msg_icon">
									<i class="material-icons"></i>
								</div>
								<p class="msg_title">!</p>
								<p class="msg_text">Тут текст про бонуси проценты шо могут быть и бла бла бла</p>
							</div>';
				echo $helper;
				break;
			default:
				break;
		}
		exit();
	}
}
