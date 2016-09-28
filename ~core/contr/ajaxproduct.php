<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Products = new Products();
	$Customer = new Customers();
	$User = new Users();
	$User->SetUser(isset($_SESSION['member'])?$_SESSION['member']:null);
	if(isset($_POST['action']))
		switch($_POST['action']){
			case "get_array_product":
				$Products->SetFieldsById($_POST['id_product']);
				$prod = $Products->fields;
				$prod['images'] = $Products->GetPhotoById($prod['id_product']);
				$rating_stars = '';
				for($i = 1; $i <= 5; $i++){
					$star = 'star';
					if($i > floor($prod['c_rating'])){
						if($i == ceil($prod['c_rating'])){
							$star .= '_half';
						}else{
							$star .= '_outline';
						}
					}
					$rating_stars .= '<li><span class="icon-font">'.$star.'</span></li>';
				}
				$rating_title = ($prod['c_rating'] != '')?'Рейтинг: '.round($prod['c_rating'],2):'Нет оценок';
				$comments_count = $prod['c_count'];
				if($prod['c_count'] == 1){
					$comments_count .= ' отзыв';
				}elseif(substr($prod['c_count'], -1) == 1 && substr($prod['c_count'], -2, 1) != 1){
					$comments_count .= ' отзыв';
				}elseif(substr($prod['c_count'], -1) == 2 || substr($prod['c_count'], -1) == 3 || substr($prod['c_count'], -1) == 4 && substr($prod['c_count'], -2, 1) != 1){
					$comments_count .= ' отзыва';
				}else{
					$comments_count .= ' отзывов';
				}
				$sum_range = $_COOKIE['sum_range'];
				$opt_cor_set = explode(";",$GLOBALS['CONFIG']['correction_set_'.$prod['opt_correction_set']]);
				$mopt_cor_set = explode(";",$GLOBALS['CONFIG']['correction_set_'.$prod['mopt_correction_set']]);
				$actual_price_descr = $prod['inbox_qty'].' '.$prod['units'];
				$other_price_descr = $prod['inbox_qty'].' '.$prod['units'];

				if(isset($_SESSION['cart']['products'][$_POST['id_product']])){
					$cart_control = 1;
					$qty_js = $_SESSION['cart']['products'][$_POST['id_product']]['quantity'];
					$actual_price = $_SESSION['cart']['products'][$_POST['id_product']]['actual_prices'][$sum_range];
					$other_price = $_SESSION['cart']['products'][$_POST['id_product']]['other_prices'][$sum_range];
				}else{
					$cart_control = 0;
					$qty_js = $prod['inbox_qty'];
					$actual_price = number_format($prod['price_opt']*$opt_cor_set[$sum_range], 2, '.', '');
					$other_price = number_format($prod['price_mopt']*$mopt_cor_set[$sum_range], 2, '.', '');
				}

				$qty_descr = '';
				if(isset($prod['qty_control']) && !empty($prod['qty_control'])){
					$qty_descr = 'мин.'.$prod['min_mopt_qty'].' '.$prod['units'].' (кратно)';
				}

				if(!isset($_SESSION['member']) || !in_array($prod['id_product'], $_SESSION['member']['favorites'])){
					$favorite = 'favorites-o';
					$favorite_descr = 'В избранное';
				}else{
					$favorite = 'favorites';
					$favorite_descr = 'В избранном';
				}

				if(!isset($_SESSION['member']) || !in_array($prod['id_product'], $_SESSION['member']['waiting_list'])){
					$waiting_list = "not_list";
					$waiting_list_descr = 'Следить за ценой';
				}else{
					$waiting_list = "in_list";
					$waiting_list_descr = 'В листе ожидания';
				}

				// $data['obj'] = $prod;
				$data['name'] = $prod['name'];
				$data['id_product'] = $prod['id_product'];
				$data['art'] = $prod['art'];
				$data['translit'] = $prod['translit'];
				$data['descr'] = $prod['descr'];
				$data['c_rating'] = $prod['c_rating'];
				$data['rating_stars'] = $rating_stars;
				$data['rating_title'] = $rating_title;
				$data['comments_count'] = $comments_count;
				$data['images'] = $prod['images'];
				$data['img_1'] = $prod['img_1'];
				$data['img_2'] = $prod['img_2'];
				$data['img_3'] = $prod['img_3'];
				$data['note_control'] = $prod['note_control'];
				$data['price_mopt'] = $prod['price_mopt'];
				$data['price_opt'] = $prod['price_opt'];
				$data['visible'] = $prod['visible'];
				$data['cart_control'] = $cart_control;
				$data['qty_value'] = $qty_js;
				$data['actual_price'] = $actual_price;
				$data['other_price'] = $other_price;
				$data['actual_price_descr'] = $actual_price_descr;
				$data['other_price_descr'] = $other_price_descr;
				$data['qty_control'] = $prod['qty_control'];
				$data['qty_descr'] = $qty_descr;
				$data['favorite'] = $favorite;
				$data['favorite_descr'] = $favorite_descr;
				$data['waiting_list'] = $waiting_list;
				$data['waiting_list_descr'] = $waiting_list_descr;
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