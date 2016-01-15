<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$products = new Products();
	$Customer = new Customers();
	$User = new Users();
	$User->SetUser(isset($_SESSION['member'])?$_SESSION['member']:null);
	if(isset($_POST['action']))
		switch($_POST['action']){
			case "get_array_product":
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
			;
			break;
			case "add_favorite":
				// Добавление Избранного товара
				if(!isset($_SESSION['member'])){
					$data['answer'] = 'login';
				}elseif(in_array($_POST['id_product'], $_SESSION['member']['favorites'])){
					$data['answer'] = 'already';
				}else{
					if($_SESSION['member']['gid'] == _ACL_CUSTOMER_){
						$Customer->AddFavorite($User->fields['id_user'], $_POST['id_product']);
					}
					$_SESSION['member']['favorites'][] = $_POST['id_product'];
					$data['fav_count'] = count($_SESSION['member']['favorites']);
					$data['answer'] = 'ok';
				}
				echo json_encode($data);
			;
			break;
			case "add_in_waitinglist":
				// Добавление в список ожидания
				if($_POST['id_user'] != '' && $_POST['email'] == '' && $_SESSION['member']['gid'] == _ACL_CUSTOMER_){
					$data['answer'] = 'ok';
				}elseif($_POST['email'] != '' && $_POST['id_user'] == ''){
					$arr['name'] = $_POST['email'];
					$arr['email'] = $_POST['email'];
					$arr['passwd'] = substr(md5(time()), 0, 6);
					$arr['promo_code'] = '';
					$arr['descr'] = '';
					$data['answer'] = 'register_ok';
					if(!$Customer->RegisterCustomer($arr)){
						$data['answer'] = 'registered';
					}
					$User->CheckUserNoPass($arr);
					$_POST['id_user'] = $User->fields['id_user'];
				}else{
					$data['answer'] = 'error';
				}
				if($_POST['id_user'] != '' && (($_POST['email'] == '' && $_SESSION['member']['gid'] == _ACL_CUSTOMER_) || $User->fields['gid'] == _ACL_CUSTOMER_)){
					if($Customer->AddInWaitingList($_POST['id_user'], $_POST['id_product'])){
						if (isset($_SESSION['member'])) {
							$_SESSION['member']['waiting_list'][] = $_POST['id_product'];
						}
						$data['answer_data'] = 'insert_ok';
					}else{
						$data['answer_data'] = 'insert_error';
					}
				}

				echo json_encode($data);
			;
			break;
			default:
			;
			break;
		}
	exit();
}
?>