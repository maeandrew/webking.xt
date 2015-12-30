<?php
unset($parsed_res);
$Page = new Page();
$products = new Products();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$id_category = $GLOBALS['CURRENT_ID_CATEGORY'];
// unset($_SESSION['cart']);
// print_r($_SESSION['cart']);
// Настройка панели действий ===============================
$list_controls = array('layout', 'sorting', 'filtering');
$tpl->Assign('list_controls', $list_controls);
// =========================================================

// если отправили комментарий
if(isset($_POST['com_qtn'])){
	$put = $_POST['id_product'];
	$text = nl2br($_POST['feedback_text'], false);
	$text = stripslashes($text);
	$author = 007;
	$author_name = $_SESSION['member']['id_user'];
	$authors_email = $_SESSION['member']['email'];
	$related33 = $products->GetComentProducts($text, $author, $author_name, $authors_email, $put);
	header('Location: '.$_SERVER['REQUEST_URI']);
	exit();
}
if(isset($_POST['available_today'])){
	setcookie('available_today', $_POST['available_today'], 0, '/');
	header('Location: '.$_SERVER['REQUEST_URI']);
}
if(isset($_SERVER['HTTP_REFERER'])){
	$referer = explode('/',str_replace('http://', '', $_SERVER['HTTP_REFERER']));
	$tpl->Assign('referer', $referer);
}
if(!isset($referer[2]) || $referer[2] != $id_category){
	unset($_SESSION['filters']);
	unset($_SESSION['search']);
}
if(isset($_POST['dropfilters'])){
	unset($_SESSION['filters']);
}
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
$dbtree->Parents($id_category, array('id_category', 'name', 'translit', 'art', 'category_level', 'page_title', 'page_description', 'page_keywords'));
if(!empty($dbtree->ERRORS_MES)){
	die("Error parents");
}
if(!$dbtree->NextRow()){
	header('Location: '._base_url.'/404/');
	exit();
}
while($cat = $dbtree->NextRow()){
	if($cat['category_level'] != 0){
		$GLOBALS['IERA_LINKS'][] = array(
			'title' => $cat['name'],
			'url' => Link::Category($cat['translit'])
		);
	}
	$GLOBALS['products_canonical'] = end($GLOBALS['IERA_LINKS'])['url'];
	$GLOBALS['products_title'] = $cat['page_title'];
	$GLOBALS['products_description'] = $cat['page_description'];
	$GLOBALS['products_keywords'] = $cat['page_keywords'];
	$tpl->Assign('header', $cat['name']);
}

// if(empty($subcats)){
	// end($GLOBALS['IERA_LINKS']);
	// $GLOBALS['IERA_LINKS'][key($GLOBALS['IERA_LINKS'])]['url'] = str_replace('/limitall', '', end($GLOBALS['IERA_LINKS'])['url']);
	// $where_arr = array('cp.id_category' => $id_category);


	function selectAll($dbtree, $id_category = null, $str = array())
	{
		$subcats = $dbtree->GetSubCats($id_category, array('id_category', 'category_level', 'category_img', 'name', 'translit', 'art', 'pid', 'visible'));
		if($id_category != 0){
			$str[] = $id_category;
		}
		foreach ($subcats as $val){
			$str = selectAll($dbtree, $val["id_category"], $str);
		}
		return $str;
	}
	$res = selectAll($dbtree, $id_category);
	if(count($res) > 1){
		$where_arr['customs'][] = "cp.id_category IN (".implode(', ', $res).")";
	}else{
		$where_arr = array('cp.id_category' => $id_category);
	}

	// Инициализация соединения со Sphinx ======================
	$sphinx = new SphinxClient();
	$sphinx->SetServer("localhost", 9312);
	$sphinx->SetConnectTimeout(1);
	$sphinx->SetArrayResult(true);
	$sphinx->setMaxQueryTime(100);
	$sphinx->setLimits(0,1000);
	$sphinx->SetSortMode(SPH_SORT_RELEVANCE);
	$sphinx->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
	$sphinx->SetMatchMode(SPH_MATCH_BOOLEAN);
	// =========================================================

	// Обработка контентных страниц ============================
	if(isset($_GET['query']) && isset($_GET['search_in_cat'])){
		$query = trim($_GET['query']);
		if($GLOBALS['CONFIG']['search_engine'] == 'mysql'){
			$widened_query = Words2AllForms($query);
			if(!empty($widened_query)){
				$widened_query_utf = r_implode(' ', $widened_query);
				$combined_query = '%'.$query .' '.$widened_query_utf.'%';
			}else{
				$combined_query = '%'.$query.'%';
			}
			if($query != '*' && $query != 'Поиск по каталогу'){
				if(ctype_digit(str_replace(' ', '',$query))){
					$q = explode(' ', $query);
					if(count($q) > 1){
						foreach($q AS $k=>$v){
							if($k == 0){
								$where = "( p.art LIKE \"$v\" OR";
							}elseif($k < (count($q)-1)){
								$where .= " p.art LIKE \"$v\" OR";
							}else{
								$where .= " p.art LIKE \"$v\" ) ";
							}
						}
						$where_arr['customs'][] = $where;
					}else{
						$where_arr['customs'][] = "p.art LIKE \"%$query%\" ";
					}
				}else{
					$where_arr['customs'][] = "MATCH (p.name, p.name_index, p.art) AGAINST ('$combined_query')";
				}
			}
		}elseif($GLOBALS['CONFIG']['search_engine'] == 'sphinx'){
			if(ctype_digit(str_replace(' ', '',$query))){
				$q = explode(' ', $query);
				if(count($q) > 1){
					foreach($q AS $k=>$v){
						if($k == 0){
							$where = "( p.art LIKE \"$v\" OR";
						}elseif($k < (count($q)-1)){
							$where .= " p.art LIKE \"$v\" OR";
						}else{
							$where .= " p.art LIKE \"$v\" ) ";
						}
					}
					$where_arr['customs'][] = $where;
				}else{
					$where_arr['customs'][] = "p.art LIKE \"%$query%\" ";
				}
			}else{
				$query = explode(' ', $query);
				$q = '(';
				foreach($query as $k=>$w){
					if(strlen($w) > 2){
						$q .= $w.' | '.$w.'* | *'.$w.'* | *'.$w;
						if($k < (count($query)-1)){
							$q .= ' | ';
						}
					}
				}
				$q .= ')';
				$result = $sphinx->Query($q, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
				if($result === false){
					print_r("Произошла ошибка: ".$sphinx->GetLastError());
				}
				$i=0;
				foreach($result['matches'] as $val){
					$res[$i] = $val['id'];
					$i++;
				}
				if(!empty($res) && count($res > 0)){
					$where_arr['customs'][] = 'p.id_product IN ('.implode(', ', $res).')';
				}else{
					$where_arr['customs'][] = 'p.id_product = 2';
				}
			}
		}
	}
	// =========================================================

	// Диапазон цен ============================================
	if(isset($_SESSION['filters']['minprice']) && isset($_SESSION['filters']['maxprice'])){
		if(isset($_POST['pricefrom']) && isset($_POST['priceto'])){
			$where_arr['customs'][] = 'price_opt >= '.number_format(($_POST['pricefrom']), 2, ".","");
			$where_arr['customs'][] = 'price_opt <= '.number_format(($_POST['priceto']), 2, ".","");
			$_SESSION['filters']['pricefrom'] = $_POST['pricefrom'];
			$_SESSION['filters']['priceto'] = $_POST['priceto'];
		}elseif((!isset($_POST['pricefrom']) && !isset($_POST['priceto'])) && (isset($_SESSION['filters']['pricefrom']) && isset($_SESSION['filters']['priceto']) && ($_SESSION['filters']['pricefrom'] != $_SESSION['filters']['minprice'] || $_SESSION['filters']['priceto'] != $_SESSION['filters']['maxprice']))){
			$where_arr['customs'][] = 'price_opt >= '.number_format(($_SESSION['filters']['pricefrom']), 2, ".","");
			$where_arr['customs'][] = 'price_opt <= '.number_format(($_SESSION['filters']['priceto']), 2, ".","");
		}
	}
	// =========================================================

	// Отобрать ХИТЫ или НОВИНКИ ===============================
	// if(isset($_POST['hit'])){
	// 	if($_POST['hit'] == 'enabled' && !isset($_SESSION['filters']['new'])){
	// 		$where_arr['customs'][] = 'prod_status = 2';
	// 		$_SESSION['filters']['hit'] = 1;
	// 	}elseif($_POST['hit'] == 'enabled' && isset($_SESSION['filters']['new'])){
	// 		$where_arr['customs'][] = 'prod_status IN (2, 3)';
	// 		$_SESSION['filters']['hit'] = 1;
	// 	}elseif($_POST['hit'] == 'disabled'){
	// 		unset($_SESSION['filters']['hit']);
	// 	}
	// }elseif(!isset($_POST['hit']) && isset($_SESSION['filters']['hit']) && !isset($_SESSION['filters']['new'])){
	// 	$where_arr['customs'][] = 'prod_status = 2';
	// }elseif(!isset($_POST['hit']) && isset($_SESSION['filters']['hit']) && isset($_SESSION['filters']['new'])){
	// 	$where_arr['customs'][] = 'prod_status IN (2, 3)';
	// }
	// if(isset($_POST['new'])){
	// 	if($_POST['new'] == 'enabled' && !isset($_SESSION['filters']['hit'])){
	// 		$where_arr['customs'][] = 'prod_status = 3';
	// 		$_SESSION['filters']['new'] = 1;
	// 	}elseif($_POST['new'] == 'enabled' && isset($_SESSION['filters']['hit'])){
	// 		$where_arr['customs'][] = 'prod_status IN (2, 3)';
	// 		$_SESSION['filters']['new'] = 1;
	// 	}elseif($_POST['new'] == 'disabled'){
	// 		unset($_SESSION['filters']['new']);
	// 	}
	// }elseif(!isset($_POST['new']) && isset($_SESSION['filters']['new']) && !isset($_SESSION['filters']['hit'])){
	// 	$where_arr['customs'][] = 'prod_status = 3';
	// }elseif(!isset($_POST['new']) && isset($_SESSION['filters']['new']) && isset($_SESSION['filters']['hit'])){
	// 	$where_arr['customs'][] = 'prod_status IN (2, 3)';
	// }
	// =========================================================

	// Сортировка ==============================================
	if(!isset($sorting)){
		$sorting = array('value' => 'popularity desc');
		// $mc->set('sorting', array($GLOBALS['CurrentController'] => $sorting));
		setcookie('sorting', json_encode(array($GLOBALS['CurrentController'] => $sorting)), time()+3600*24*30, '/');
	}else{
		$_SESSION['filters']['orderby'] = $orderby = $sorting['value'];
	}

	if(isset($_SESSION['member']['gid']) && ($_SESSION['member']['gid'] == _ACL_SUPPLIER_ || $_SESSION['member']['gid'] == _ACL_ADMIN_)){
		$available_sorting_values = array(
			'popularity desc' => 'популярные сверху',
			'price_opt_otpusk asc' => 'от дешевых к дорогим',
			'price_opt_otpusk desc' => 'от дорогих к дешевым',
			'name asc' => 'по названию от А до Я',
			'name desc' => 'по названию от Я до А',
		);
	}else{
		$available_sorting_values = array(
			'popularity desc' => 'популярные сверху',
			'price_mopt asc' => 'от дешевых к дорогим',
			'price_mopt desc' => 'от дорогих к дешевым',
			'name asc' => 'по названию от А до Я',
			'name desc' => 'по названию от Я до А',
		);
	}
	$tpl->Assign('sorting', $sorting);
	$tpl->Assign('available_sorting_values', $available_sorting_values);
	if((!isset($orderby) || $orderby == '') && isset($_SESSION['filters']['orderby'])){
		$orderby = $_SESSION['filters']['orderby'];
	}
	// =========================================================

	// Фильтры =================================================
//$products->SetProductsListByFilter();
	// if((isset($_POST['filter_count']) && $_POST['filter_count'] > 0) || (isset($_SESSION['filters']['string']) && !isset($_POST['filter_count']))){
	// 	if(isset($_POST['filter_count'])){
	// 		for($i = 0; $i < $_POST['filter_count']; $i++){
	// 			if(isset($_POST['filter'.$i])){
	// 				$res = explode(' @ ', $_POST['filter'.$i]);
	// 				$group[$res[1]][] = $res[0];
	// 			}
	// 		}
	// 	}
	// 	if(((isset($group) && count($group) > 0) || isset($_SESSION['filters']['string'])) && !isset($_POST['dropfilters'])){
	// 		if(isset($_SESSION['filters']['string']) && !isset($_POST['filter_count'])){
	// 			$_POST['filters'] = $filters = $_SESSION['filters']['string'];
	// 		}else{
	// 			$filters = '';
	// 			if(isset($group)){
	// 				foreach($group as $gr){
	// 					$filters .= ' ( ';
	// 						if(count($gr) > 1){
	// 							$filters .= '( '.$gr[0].' ) | ';
	// 							for($i = 1; $i < (count($gr)-1); $i++){
	// 								$filters .= '( '.$gr[$i].' ) | ';
	// 							}
	// 							$filters .=  '( '.$gr[(count($gr)-1)].' )';
	// 						}else{
	// 							$filters .= $gr[0];
	// 						}
	// 					$filters .= ' )';
	// 				}
	// 			}
	// 			$_SESSION['filters']['string'] = $_POST['filters'] = $filters;
	// 		}
	// 		if($filters != ''){
	// 			$result = $sphinx->Query($filters, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
	// 			$k = 0;
	// 			if(isset($result['matches'])){
	// 				foreach ($result['matches'] as $val){
	// 					if($k == 0){
	// 						$mass[] = $val['id'];
	// 					}else{
	// 						$add[$k][] = $val['id'];
	// 					}
	// 				}
	// 			}
	// 			if(isset($add) && count($add) > 0){
	// 				$mass = array_unique(array_merge($mass, $add[$k]));
	// 			}
	// 			if(!empty($mass) && count($mass > 0)){
	// 				$where_arr['customs'][] = 'p.id_product IN ('.implode(', ', $mass).')';
	// 			}else{
	// 				$where_arr['customs'][] = 'p.id_product = -2';
	// 			}
	// 		}
	// 	}
	// }
	// if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_TERMINAL_ && isset($_COOKIE['available_today']) && $_COOKIE['available_today'] == 1){
	// 	$where_arr['customs'][] = "s.available_today = 1";
	// }
	// =========================================================

	$time_start = microtime(true);
	// Пагинатор ===============================================
	if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
		$GLOBALS['Limit_db'] = $_GET['limit'];
	}
	if((isset($_GET['limit']) && $_GET['limit'] != 'all' && !is_array($mass)) || !isset($_GET['limit'])){
		if(isset($GLOBALS['Page_id']) && is_numeric($GLOBALS['Page_id'])){
			$_GET['page_id'] = $GLOBALS['Page_id'];
		}
		if(isset($_SESSION['member']['gid']) && ($_SESSION['member']['gid'] == _ACL_SUPPLIER_ || $_SESSION['member']['gid'] == _ACL_ADMIN_)){
			$cnt = $products->GetProductsCnt($where_arr, $_SESSION['member']['gid']);
		}else{
			$cnt = $products->GetProductsCnt($where_arr);
		}
		$tpl->Assign('cnt', $cnt);
		$tpl->Assign('pages_cnt', ceil($cnt/$GLOBALS['Limit_db']));
		$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
		unset($cnt);
		$limit = ' LIMIT '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
	}else{
		$GLOBALS['Limit_db'] = 0;
		$limit = '';
	}

	// =========================================================

	$time_end = microtime(true);
	$time = $time_end - $time_start;
	// echo "execution time <b>$time</b> seconds\n<br>";

	$time_start = microtime(true);
	// Получение массива товаров ===============================
	$GET_limit = "";
	if(isset($_GET['limit'])){
		$GET_limit = "limit".$_GET['limit'].'/';
	}
	if(!empty($mass)){
		$products->SetProductsListFilter($where_arr, $limit, 0, array('order_by'=>isset($orderby)?$orderby:null, 'rel_search'=>isset($rel_order)?$rel_order:null));
	}else{
		if(isset($_SESSION['member']) && ($_SESSION['member']['gid'] == _ACL_SUPPLIER_ || $_SESSION['member']['gid'] == _ACL_ADMIN_)){
			$products->SetProductsList($where_arr, $limit, $_SESSION['member']['gid']);
		}else{
			$products->SetProductsList($where_arr, $limit, 0, array('order_by' => isset($orderby) ? $orderby : null));
		}
	}

	$time_end = microtime(true);
	$time = $time_end - $time_start;
	// echo "execution time <b>$time</b> seconds\n<br>";
	

	$product_list = $products->list;
	foreach($product_list as &$p){
		$p['images'] = $products->GetPhotoById($p['id_product']);
	}
	$tpl->Assign('list', $product_list);




	// =========================================================
// }
$products_list = $tpl->Parse($GLOBALS['PATH_tpl_global'].'products_list.tpl');
$tpl->Assign('products_list', $products_list);
// Вывод на страницу =======================================
if(isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] == _ACL_SUPPLIER_){
	$products->FillAssort($_SESSION['member']['id_user']);
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_assortiment.tpl')
	);
}elseif(isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] == _ACL_MANAGER_){
	$Customer = new Customers();
	$Customer->SetFieldsById($_SESSION['member']['id_user']);
	$Customer->fields['discount'] = 1-$Customer->fields['discount']/100;
	$tpl->Assign('contragent', $Customer->fields);
	if(!isset($_POST['price_mode']) && isset($_SESSION['price_mode']) && $_SESSION['price_mode'] != 3){
		$_SESSION['price_mode'] = $_SESSION['price_mode'];
	}elseif(isset($_POST['price_mode'])){
		if($_SESSION['price_mode'] != $_POST['price_mode']){
			$_SESSION['cart']['products'] = array();
		}
		$_SESSION['price_mode'] = $_POST['price_mode'];
		setcookie('sum_range', 3, 0, '/');
		header('Location: '.$_SERVER['REQUEST_URI']);
	}else{
		$_SESSION['price_mode'] = 1;
	}
	$Status = new Status();
	$warehouse = $Status->GetWarehouseProducts();
	$prods = array();
	foreach($warehouse AS $k=>$v){
		foreach($v AS $i){
			array_push($prods ,$i);
		}
	}
	$tpl->Assign('warehouse', $prods);
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_products_contragent.tpl')
	);
}else{
	$_SESSION['price_mode'] = 3;
	$parsed_res = array(
		'issuccess'	=> true,
		'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_products.tpl')
	);
}
// =========================================================

// Установка границ цен ====================================
// if(empty($subcats)){
// 	unset($where_arr['customs']);
// 	$products->SetProductsListFilter($where_arr, '', 0, array('order_by'=>isset($orderby)?$orderby:null, 'rel_search'=>isset($rel_order)?$rel_order:null));
// 	foreach($products->list as $k=>$p){
// 		if($p['price_mopt'] != 0){
// 			$prices[$k] = $p['price_mopt'];
// 		}
// 	}
// 	if((!isset($_POST['minprice']) && !isset($_POST['maxprice'])) || isset($_POST['dropfilters'])){
// 		if(isset($prices)){
// 			$min = floor(min($prices?$prices:null));
// 			$max = ceil(max($prices));
// 			if($min < 0){
// 				$min = 0;
// 				$_SESSION['filters']['minprice'] = $min;
// 			}else{
// 				$_SESSION['filters']['minprice'] = $min;
// 			}
// 			$_SESSION['filters']['maxprice'] = $max;
// 		}
// 	}
// 	if((!isset($referer[2]) || $referer[2] != $id_category) || isset($_POST['dropfilters'])){
// 		if(isset($min)){
// 			$_SESSION['filters']['pricefrom'] = $min;
// 		}
// 		if(isset($max)){
// 			$_SESSION['filters']['priceto'] = $max;
// 		}
// 	}
// }
// =========================================================

if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}
function Highlight($whereText, $whatText){
	$highlightWords = $highlightWordsRepl = array();
	$highlightWordsT = $this->Words2AllForms($_REQUEST['text']);
	foreach($highlightWordsT as $k => $v){
		if(!$v){
			$highlightWords[]  = "#\b($k)\b#isU";
			$highlightWordsRepl[] = '[highlight]\\1[/highlight]';
		}else{
			foreach( $v as $v1 ){
				$highlightWords[]  = "#\b($v1)\b#isU";
				$highlightWordsRepl[] = '[highlight]\\1[/highlight]';
			}
		}
	}
	return $message['message_text'] = preg_replace(array_reverse($highlightWords), '[highlight]$1[/highlight]', $whereText);
}
function Words2AllForms($text){
	require_once(dirname(__FILE__).'/../sys/phpmorphy/src/common.php');
	// set some options
	$opts = array(
		// storage type, follow types supported
		// PHPMORPHY_STORAGE_FILE - use file operations(fread, fseek) for dictionary access, this is very slow...
		// PHPMORPHY_STORAGE_SHM - load dictionary in shared memory(using shmop php extension), this is preferred mode
		// PHPMORPHY_STORAGE_MEM - load dict to memory each time when phpMorphy intialized, this useful when shmop ext. not activated. Speed same as for PHPMORPHY_STORAGE_SHM type
		'storage' => PHPMORPHY_STORAGE_MEM,
		// Extend graminfo for getAllFormsWithGramInfo method call
		'with_gramtab' => false,
		// Enable prediction by suffix
		'predict_by_suffix' => true,
		// Enable prediction by prefix
		'predict_by_db' => true
	);
	$dir = dirname(__FILE__).'/../sys/phpmorphy/dicts';
	// Create descriptor for dictionary located in $dir directory with russian language
	$dict_bundle = new phpMorphy_FilesBundle($dir, 'rus');
	// Create phpMorphy instance
	$morphy = new phpMorphy($dict_bundle, $opts);
	$words = preg_split('#\s|[,.:;!?"\'()]#', $text, -1, PREG_SPLIT_NO_EMPTY);
	$bulk_words = array();
	foreach($words as $v){
		if(strlen($v) > 2){
			//$v = iconv ('cp1251', 'utf-8', $v);
			$v = mb_strtoupper($v, 'utf-8');
			//$v = iconv ('utf-8', 'cp1251', $v);
			$bulk_words[] = $v;
		}
		$bulk_words[] = strtoupper($v);
	}
	return $morphy->getAllForms($bulk_words);
}
function Words2BaseForm($text){
	require_once(dirname(__FILE__).'/../sys/phpmorphy/src/common.php');
	// set some options
	$opts = array(
		// storage type, follow types supported
		// PHPMORPHY_STORAGE_FILE - use file operations(fread, fseek) for dictionary access, this is very slow...
		// PHPMORPHY_STORAGE_SHM - load dictionary in shared memory(using shmop php extension), this is preferred mode
		// PHPMORPHY_STORAGE_MEM - load dict to memory each time when phpMorphy intialized, this useful when shmop ext. not activated. Speed same as for PHPMORPHY_STORAGE_SHM type
		'storage' => PHPMORPHY_STORAGE_MEM,
		// Extend graminfo for getAllFormsWithGramInfo method call
		'with_gramtab' => false,
		// Enable prediction by suffix
		'predict_by_suffix' => true,
		// Enable prediction by prefix
		'predict_by_db' => true
	);
	$dir = dirname(__FILE__).'/../sys/phpmorphy/dicts';
	// Create descriptor for dictionary located in $dir directory with russian language
	$dict_bundle = new phpMorphy_FilesBundle($dir, 'rus');
	// Create phpMorphy instance
	$morphy = new phpMorphy($dict_bundle, $opts);
	$words = preg_replace('#\[.*\]#isU', '', $text);
	$words = preg_split('#\s|[,.:;!?"\'()]#', $words, -1, PREG_SPLIT_NO_EMPTY);
	$bulk_words = array();
	foreach($words as $v ){
		if(strlen($v) > 2){
			$bulk_words[] = strtoupper($v);
		}
	}
	$base_form = $morphy->getBaseForm($bulk_words);
	$fullList = array();
	if(is_array($base_form) && count($base_form)){
		foreach($base_form as $k => $v){
			if(is_array($v)){
				foreach($v as $v1){
					if(strlen($v1) > 2){
						$fullList[$v1] = 1;
					}
				}
			}
		}
	}
	$words = join(' ', array_keys($fullList));
	return $words;
}
function r_implode($glue, $pieces){
	foreach($pieces as $r_pieces){
		if(is_array($r_pieces)){
			$retVal[] = r_implode($glue, $r_pieces);
		}else{
			$retVal[] = $r_pieces;
		}
	}
	return implode($glue, $retVal);
}
// Фильтр на странице списка товаров=================================
$filter_cat = $products->GetFilterFromCategory($id_category);

$group_arr = [];
$cnt = 0;
if($filter_cat) {
	foreach ($filter_cat as $value) {

		if (!isset($group_arr[$value['id']])) {
			$group_arr[$value['id']] = array(
				'caption' => $value['caption'],
				'units' => $value['units']
			);
		}

		$check =  '';
		if(isset($GLOBALS['Filters']) && is_array($GLOBALS['Filters'])){
			foreach($GLOBALS['Filters'] as $val){
				if(in_array($value['id_val'], $val)){
					$check =  'checked';
					$cnt += $value['cnt'];
				}
			}
		}

		$group_arr[$value['id']]['values'][] = array(
			'id' => array($value['id'], $value['id_val']),
			'value' => $value['value'],
			'count' => $value['cnt'],
			'checked' => $check
		);

	}
}
$tpl->Assign('cnt', $cnt); //бщее количество товаров по активным фильтрам

if($group_arr){
	$tpl->Assign('filter_cat', $group_arr);
};

// =========================================================
?>