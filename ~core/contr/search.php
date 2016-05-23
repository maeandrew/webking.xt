<?php
//setlocale(LC_ALL, 'ru_RU');
// ---- center ----
unset($parsed_res);
$Page = new Page();
$Page->PagesList();
$tpl->Assign('list_menu', $Page->list);
$header = 'Результаты поиска';
$GLOBALS['IERA_LINKS'][] = array(
	'title' => $header,
	'url' => _base_url.'/search/'
);
$tpl->Assign('header', $header);

// Настройка панели действий ===============================
$list_controls = array('layout', 'sorting');
$tpl->Assign('list_controls', $list_controls);
// =========================================================

if(isset($_SERVER['HTTP_REFERER'])){
	$referer = explode('/',str_replace('http://', '', $_SERVER['HTTP_REFERER']));
	if($referer[1] != 'search'){
		unset($_SESSION['search']);
		unset($_SESSION['filters']);
	}
}else{
	unset($_SESSION['search']);
	unset($_SESSION['filters']);
}
$products = new Products();

// Получаем строку поискового запроса ======================
if(isset($_POST['query']) && !isset($_GET['query']) && $_POST['query'] != ''){
	$query = preg_replace('/[()*|,.*"^&@#$%\/]/', ' ', $_POST['query']);
	$query = trim($query);
}elseif(isset($_GET['query']) && !isset($_POST['query']) && $_GET['query'] != ''){
	$query = preg_replace('/[()*|,.*"^&@#$%]/', ' ', $_GET['query']);
	$query = trim($query);
}
if(isset($_SESSION['search']['query']) && isset($query) && $query != '' && $query != $_SESSION['search']['query']){
	$_SESSION['search']['newsearch'] = 1;
	$_POST['dropfilters'] = 1;
}else{
	$_SESSION['search']['newsearch'] = 0;
}
if((isset($_SESSION['search']['query']) && $_SESSION['search']['query'] != '') && (!isset($query) || $query == '')){
	$query = $_SESSION['search']['query'];
}elseif((isset($query) && $query != '') || !isset($_SESSION['search']['query']) || $_SESSION['search']['query'] == ''){
	if(isset($query)){
		$_SESSION['search']['query'] = $query;
	}else{
		$_SESSION['search']['query'] = $query = '';
	}
}
if(isset($_POST['dropfilters'])){
	unset($_SESSION['filters']);
}

// Категория для поиска ====================================
if((isset($_POST['category2search']) && $_POST['category2search'] != 0) || (isset($_GET['category2search']) && $_GET['category2search'] != 0)){
	$_SESSION['search']['category2search'] = isset($_POST['category2search'])?$_POST['category2search']:$_GET['category2search'];
	$where_arr['customs'][] = 'cp.id_category IN (
		SELECT id_category
		FROM '._DB_PREFIX_.'category c
		WHERE c.pid = '.$_SESSION['search']['category2search'].'
		OR c.pid IN (
			SELECT id_category
			FROM '._DB_PREFIX_.'category c
			WHERE c.pid = '.$_SESSION['search']['category2search'].'
		)
	)';
}else{
	$_SESSION['search']['category2search'] = 0;
}

if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_TERMINAL_ && isset($_COOKIE['available_today']) && $_COOKIE['available_today'] == 1){
	$where_arr['customs'][] = "s.available_today = 1";
}

// Диапазон цен ============================================
if(isset($_SESSION['member']['gid']) && $_SESSION['member']['gid'] != _ACL_ADMIN_){
	if(isset($_POST['pricefrom']) && isset($_POST['priceto'])){
		$where_arr['customs'][] = 'price_mopt >= '.number_format(($_POST['pricefrom']), 2, ".","");
		$where_arr['customs'][] = 'price_mopt <= '.number_format(($_POST['priceto']), 2, ".","");
		$_SESSION['filters']['pricefrom'] = $_POST['pricefrom'];
		$_SESSION['filters']['priceto'] = $_POST['priceto'];
	}elseif((!isset($_POST['pricefrom']) && !isset($_POST['priceto'])) && (isset($_SESSION['filters']['pricefrom']) && isset($_SESSION['filters']['priceto']))){
		$where_arr['customs'][] = 'price_mopt >= '.number_format(($_SESSION['filters']['pricefrom']), 2, ".","");
		$where_arr['customs'][] = 'price_mopt <= '.number_format(($_SESSION['filters']['priceto']), 2, ".","");
	}
}

// Сортировка ==============================================
if(!isset($sorting)){
	$sorting = array('value' => 'popularity desc');
	// $mc->set('sorting', array($GLOBALS['CurrentController'] => $sorting));
	setcookie('sorting', serialize(array($GLOBALS['CurrentController'] => $sorting)), time()+3600*24*30, '/');
}else{
	$_SESSION['filters']['orderby'] = $orderby = $sorting['value'];
}
if(isset($_SESSION['member']['gid']) && ($_SESSION['member']['gid'] == _ACL_SUPPLIER_ || $_SESSION['member']['gid'] == _ACL_ADMIN_)){
	$available_sorting_values = array(
		'popularity desc' => 'популярные',
		'price_opt_otpusk asc' => 'от дешевых к дорогим',
		'price_opt_otpusk desc' => 'от дорогих к дешевым',
		'name asc' => 'по названию от А до Я',
		'name desc' => 'по названию от Я до А',
	);
}else{
	$available_sorting_values = array(
		'popularity desc' => 'популярные',
		'price_opt asc' => 'от дешевых к дорогим',
		'price_opt desc' => 'от дорогих к дешевым',
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

// Отобрать ХИТЫ или НОВИНКИ ===============================
if(isset($_POST['hit'])){
	if($_POST['hit'] == 'enabled' && !isset($_SESSION['filters']['new'])){
		$where_arr['customs'][] = 'prod_status = 2';
		$_SESSION['filters']['hit'] = 1;
	}elseif($_POST['hit'] == 'enabled' && isset($_SESSION['filters']['new'])){
		$where_arr['customs'][] = 'prod_status IN (2, 3)';
		$_SESSION['filters']['hit'] = 1;
	}elseif($_POST['hit'] == 'disabled'){
		unset($_SESSION['filters']['hit']);
	}
}elseif(!isset($_POST['hit']) && isset($_SESSION['filters']['hit']) && !isset($_SESSION['filters']['new'])){
	$where_arr['customs'][] = 'prod_status = 2';
}elseif(!isset($_POST['hit']) && isset($_SESSION['filters']['hit']) && isset($_SESSION['filters']['new'])){
	$where_arr['customs'][] = 'prod_status IN (2, 3)';
}
if(isset($_POST['new'])){
	if($_POST['new'] == 'enabled' && !isset($_SESSION['filters']['hit'])){
		$where_arr['customs'][] = 'prod_status = 3';
		$_SESSION['filters']['new'] = 1;
	}elseif($_POST['new'] == 'enabled' && isset($_SESSION['filters']['hit'])){
		$where_arr['customs'][] = 'prod_status IN (2, 3)';
		$_SESSION['filters']['new'] = 1;
	}elseif($_POST['new'] == 'disabled'){
		unset($_SESSION['filters']['new']);
	}
}elseif(!isset($_POST['new']) && isset($_SESSION['filters']['new']) && !isset($_SESSION['filters']['hit'])){
	$where_arr['customs'][] = 'prod_status = 3';
}elseif(!isset($_POST['new']) && isset($_SESSION['filters']['new']) && isset($_SESSION['filters']['hit'])){
	$where_arr['customs'][] = 'prod_status IN (2, 3)';
}
// Поиск MySQL =============================================
$gid = 0;
if(isset($_SESSION['member'])){
	$gid = $_SESSION['member']['gid'];
//	if(substr($_SESSION['member']['email'], -11) == "@x-torg.com"){
//		$gid = _ACL_ADMIN_;
//	}
}

if($GLOBALS['CONFIG']['search_engine'] == 'mysql' || ($GLOBALS['CONFIG']['search_engine'] == 'sphinx' && isset($_SESSION['member']) && in_array($gid, array(_ACL_SUPPLIER_, _ACL_ADMIN_)))){
	$widened_query = Words2AllForms($query);
	if(!empty($widened_query)){
		$widened_query_utf = r_implode(' ', $widened_query);
		$combined_query = '%'.$query .' '.$widened_query_utf.'%';
	}else{
		$combined_query = '%'.$query.'%';
	}
	if(isset($_SESSION['member']) && in_array($gid, array(_ACL_SUPPLIER_,_ACL_ADMIN_))){
		$where_arr['p.visible'] = 1;
	}
	if($query != '*' && $query != 'Поиск по каталогу'){
		if(is_numeric($query)){
			$where_arr['customs'][] = 'p.art LIKE "%'.$query.'%" ';
			$rel_order = ", MATCH (p.name, p.name_index, p.art) AGAINST ('".$combined_query."') AS rel";
		}else{
			$where_arr['customs'][] = "MATCH (p.name, p.name_index, p.art) AGAINST ('".$combined_query."')";
			//$where_arr['customs'] =  array_unique($where_arr['customs']);
			$rel_order = ", MATCH (p.name, p.name_index, p.art) AGAINST ('".$combined_query."') AS rel";
		}
	}


	// Пагинатор ===============================================
	if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
		$GLOBALS['Limit_db'] = $_GET['limit'];
	}
	if((isset($_GET['limit']) && $_GET['limit'] != 'all') || !isset($_GET['limit'])){
		if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
			$_GET['page_id'] = $_POST['page_nbr'];
		}
		if(isset($_SESSION['member']) && in_array($gid, array(_ACL_SUPPLIER_,_ACL_ADMIN_))){
			$cnt = $products->GetProductsCnt($where_arr, $gid);
		}else{
			$cnt = $products->GetProductsCnt($where_arr);
		}
		$tpl->Assign('cnt', $cnt);
		$tpl->Assign('pages_cnt', ceil($cnt/$GLOBALS['Limit_db']));
		$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
		$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
	}else{
		$GLOBALS['Limit_db'] = 0;
		$limit = '';
	}
	$GET_limit = "";
	if(isset($_GET['limit'])){
		$GET_limit = " LIMIT ".$_GET['limit'].'/';
	}
	$res = $products->SetProductsListOldSearch($where_arr, $limit, $gid, array('order_by'=>isset($orderby)?$orderby:null, 'rel_search'=>isset($rel_order)?$rel_order:null));
	if(!empty($res)){
		foreach($res as $k=>$r){
			if(!empty($r)){
				$list[$k] = $r;
			}
		}
	}
	$limit = '';
	$res = $products->SetProductsListOldSearch($where_arr, $limit, $gid, array('order_by'=>isset($orderby)?$orderby:null, 'rel_search'=>isset($rel_order)?$rel_order:null));
	if(!empty($res)){
		foreach($res as $k=>$r){
			if($r['price_mopt'] != 0){
				$prices[$k] = number_format($r['price_mopt'], 0, ".","");
			}
		}
	}
// Поиск Sphinx ============================================
}elseif($GLOBALS['CONFIG']['search_engine'] == 'sphinx'){
	// Инициализация соединения со Sphinx
	$sphinx = new SphinxClient();
	// $sphinx->SetServer("localhost", 9312);
	$sphinx->SetServer('81.17.140.234', 9312);
	$sphinx->SetConnectTimeout(1);
	$sphinx->SetArrayResult(true);
	$sphinx->setMaxQueryTime(100);
	$sphinx->setLimits(0,150);
	$sphinx->SetSortMode(SPH_SORT_RELEVANCE);
	$sphinx->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
	// разбор строки запроса
	if(ctype_digit($query)){
		$result = $sphinx->Query($query, 'art'.$GLOBALS['CONFIG']['search_index_prefix']);
	}else{
		$words = explode(' ', $query);
		$i = 0;
		foreach($words as &$w){
			if(strlen($w) > 2){
				$sphinx->SetMatchMode(SPH_MATCH_ALL);
				$result = $sphinx->Query('( '.$w.' | '.$w.'* | *'.$w.'* | *'.$w.' ) ', 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
				if($result['total'] == 0){
					$w = Transliterate($w);
					$res = $sphinx->Query('( '.$w.' | '.$w.'* | *'.$w.'* | *'.$w.' ) ', 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
					if($res['total'] == 0){
						unset($words[$i]);
					}else{
						$words[$i] = $w;
						$i++;
					}
				}else{
					$i++;
				}
			}
		}
		$wo = '';
		foreach($words as $k=>$word){
			if(strlen($word) > 2){
				if($k < count($words)-1){
					$wo .= '( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' ) & ';
				}else{
					$wo .= '( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' ) ';
				}
			}
		}
		if($wo != ''){
			$result = $sphinx->Query($wo, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
			if($result['total'] == 0){
				$wo = '';
				$sphinx->SetMatchMode(SPH_MATCH_BOOLEAN);
				foreach($words as $word){
					for($i = 1; $i < count($words); $i++){
						if(isset($words[$i]) && strlen($words[$i]) > 2){
								$wo .= '( ( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' ) & ';
							if(count($words) > 2){
								$wo .= '( '.$words[$i].' | '.$words[$i].'* | *'.$words[$i].'* | *'.$words[$i].' ) ) | ';
							}else{
								$wo .= '( '.$words[$i].' | '.$words[$i].'* | *'.$words[$i].'* | *'.$words[$i].' ) )';
							}
						}
					}
					array_shift($words);
				}
				if($wo != ''){
					$result = $sphinx->Query($wo, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
				}
			}
			$words = explode(' ', $query);
			if($result['total'] == 0){
				$wo = '';
				$sphinx->SetMatchMode(SPH_MATCH_BOOLEAN);
				foreach($words as $k=>$word){
					if(strlen($word) > 2){
						if($k < count($words)-1){
							$wo .= '( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' ) | ';
						}else{
							$wo .= '( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' ) ';
						}
					}
				}
				if($wo != ''){
					$result = $sphinx->Query($wo, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
				}
			}
			$result = $sphinx->Query($wo, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
			if($result['total'] > 0){
				$_POST['queryalt'] = implode(' ', $words);
			}
		}
		/*
		if(count($words) > 1){
			$sphinx->SetMatchMode(SPH_MATCH_ALL);
			$result = $sphinx->Query($query, 'nameIndex');
		}else{
			$result = $sphinx->Query($query, 'nameIndex');
		}*/
	}
	// if(!isset($result) || $result===false){
	// 	print_r("Произошла ошибка: ".$sphinx->GetLastError());
	// }
	if(isset($result['matches'])){
		foreach($result['matches'] as $val){
			$mass[] = $val['id'];
		}
	}
	if(!empty($mass) && count($mass > 0)){
		$where_arr['customs'][] = 'p.id_product IN ('.implode(', ', $mass).')';
	}else{
		$where_arr['customs'][] = 'p.id_product = 1';
	}
	// Пагинатор ===============================================
	if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
		$GLOBALS['Limit_db'] = $_GET['limit'];
	}
	if((isset($_GET['limit']) && $_GET['limit'] != 'all' && !isset($mass)) || !isset($_GET['limit'])){
		if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
			$_GET['page_id'] = $_POST['page_nbr'];
		}
		if(isset($_SESSION['member']) && ($_SESSION['member']['gid'] == _ACL_SUPPLIER_ || $_SESSION['member']['gid'] == _ACL_ADMIN_)){
			$cnt = $products->GetProductsCnt($where_arr, $_SESSION['member']['gid'], array('group_by'=>'a.id_product'));
		}else{
			$cnt = $products->GetProductsCnt($where_arr, 0, array('group_by'=>'a.id_product'));
		}
		$tpl->Assign('cnt', $cnt);
		$tpl->Assign('pages_cnt', ceil($cnt/$GLOBALS['Limit_db']));
		$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
		$limit = ' limit '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
	}else{
		$GLOBALS['Limit_db'] = 0;
		$limit = '';
	}
	/*Pagination*/
	$GET_limit = "";
	if(isset($_GET['limit'])){
		$GET_limit = "limit".$_GET['limit'].'/';
	}
	$list = $products->SetProductsList4Search($where_arr, $limit, 0, array(isset($orderby)?$orderby:null));
	if(isset($list) == true && empty($list) == false){
		foreach($list AS $res){
			if($res['price_mopt'] != 0){
				$prices[] = number_format($res['price_mopt'], 0, ".","");
			}
		}
	}
}
if(!empty($list)){
	foreach($list as &$p){
		$p['images'] = $products->GetPhotoById($p['id_product']);
	}
}
$tpl->Assign('list', isset($list)?$list:array());
$products_list = $tpl->Parse($GLOBALS['PATH_tpl_global'].'products_list.tpl');
$tpl->Assign('products_list', $products_list);

// Общий код ===============================================
if($_SESSION['search']['newsearch'] == 1 || isset($_POST['dropfilters'])){
	if(isset($prices)){
		$min = floor(min($prices));
		$max = ceil(max($prices));
	}
	if(isset($min) && isset($max) && $min != $max){
		$_SESSION['filters']['minprice'] = $min;
		$_SESSION['filters']['maxprice'] = $max;
	}
}
if(((!isset($_POST['pricefrom']) && !isset($_POST['priceto']) && !isset($_SESSION['filters']['pricefrom']) && !isset($_SESSION['filters']['priceto']))
	|| $referer[1] != 'search' || $_SESSION['search']['newsearch'] == 1)
	&& isset($_SESSION['filters']['minprice']) && isset($_SESSION['filters']['maxprice'])){
	$_SESSION['filters']['pricefrom'] = $_SESSION['filters']['minprice'];
	$_SESSION['filters']['priceto'] = $_SESSION['filters']['maxprice'];
}
$tpl->Assign('header', $GLOBALS['IERA_LINKS'][1]['title']);

if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_SUPPLIER_){
	$_SESSION['price_mode'] = 3;
	$parsed_res = array('issuccess' => TRUE,
						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_assortiment.tpl'));
}elseif(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_CONTRAGENT_){
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

if(TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}

function Transliterate($word){
	$transliterationTableRuEng = array(' ' => '', 'й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r', 'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o', 'з' => 'p', 'х' => '[', 'ъ' => ']', 'ф' => 'a', 'ы' => 's', 'в' => 'd', 'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j', 'л' => 'k', 'д' => 'l', 'ж' => ';', 'э' => '', 'я' => 'z', 'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b', 'т' => 'n', 'ь' => 'm', 'б' => ',', 'ю' => '.', 'Й' => 'Q', 'Ц' => 'W', 'У' => 'E', 'К' => 'R', 'Е' => 'T', 'Н' => 'Y', 'Г' => 'U', 'Ш' => 'I', 'Щ' => 'O', 'З' => 'P', 'Х' => '{', 'Ъ' => '}', 'Ф' => 'A', 'Ы' => 'S', 'В' => 'D', 'А' => 'F', 'П' => 'G', 'Р' => 'H', 'О' => 'J', 'Л' => 'K', 'Д' => 'L', 'Ж' => ':', 'Э' => '"', 'Я' => 'Z', 'Ч' => 'X', 'С' => 'C', 'М' => 'V', 'И' => 'B', 'Т' => 'N', 'Ь' => 'M', 'Б' => '<', 'Ю' => '>');
	$transliterationTableEngRu = array(' ' => '', 'q' => 'й', 'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н', 'u' => 'г', 'i' => 'ш', 'o' => 'щ', 'p' => 'з', '[' => 'х', ']' => 'ъ', 'a' => 'ф', 's' => 'ы', 'd' => 'в', 'f' => 'а', 'g' => 'п', 'h' => 'р', 'j' => 'о', 'k' => 'л', 'l' => 'д', ';' => 'ж', '' => 'э', 'z' => 'я', 'x' => 'ч', 'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т', 'm' => 'ь', ',' => 'б', '.' => 'ю', 'Q' => 'Й', 'W' => 'Ц', 'E' => 'У', 'R' => 'К', 'T' => 'Е', 'Y' => 'Н', 'U' => 'Г', 'I' => 'Ш', 'O' => 'Щ', 'P' => 'З', '{' => 'Х', '}' => 'Ъ', 'A' => 'Ф', 'S' => 'Ы', 'D' => 'В', 'F' => 'А', 'G' => 'П', 'H' => 'Р', 'J' => 'О', 'K' => 'Л', 'L' => 'Д', ':' => 'Ж', '"' => 'Э', 'Z' => 'Я', 'X' => 'Ч', 'C' => 'С', 'V' => 'М', 'B' => 'И', 'N' => 'Т', 'M' => 'Ь', '<' => 'Б', '>' => 'Ю');
	if(preg_match('/[A-Za-z]/', $word)){
		$transword = str_replace(array_keys($transliterationTableEngRu), array_values($transliterationTableEngRu), $word);
	}else{
		$transword = str_replace(array_keys($transliterationTableRuEng), array_values($transliterationTableRuEng), $word);
	}
	trim($transword, " ");
	return $transword;
}

function Words2AllForms($text){
	require_once($GLOBALS['PATH_sys'].'phpmorphy/src/common.php');
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
	foreach ($words as $v )
		if (strlen($v) > 2 )
			$bulk_words[] = strtoupper($v);
	$base_form = $morphy->getBaseForm($bulk_words);
	$fullList = array();
	if (is_array($base_form) && count($base_form) )
		foreach ( $base_form as $k => $v )
			if ( is_array($v) )
				foreach ( $v as $v1 )
					if ( strlen($v1) > 2 )
						$fullList[$v1] = 1;
	$words = join(' ', array_keys($fullList));
	return $words;
}

function r_implode( $glue, $pieces ){
	foreach( $pieces as $r_pieces ){
		if( is_array( $r_pieces ) ){
			$retVal[] = r_implode( $glue, $r_pieces );
		}else{
			$retVal[] = $r_pieces;
		}
	}
	return implode( $glue, $retVal );
}