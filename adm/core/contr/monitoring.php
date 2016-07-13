<?php
if(!_acl::isAllow('monitoring')){
	die("Access denied");
}
unset($parsed_res);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Мониторинг";
$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);

if(isset($GLOBALS['REQAR'][1])){
	switch ($GLOBALS['REQAR'][1]){
		case 'specifications':
			$ii = count($GLOBALS['IERA_LINKS']);
			$GLOBALS['IERA_LINKS'][$ii]['title'] = "Характеристики";
			$product = new Products();
			$specification = new Specification();
			// получить список категорий
			$res = $specification->GetSpecsForCats();
			// die();
			foreach($res as $value){
				$cat_spec[$value['id_cat']]['name'] = $value['name'];
				$cat_spec[$value['id_cat']]['specs'][$value['id_spec']] = $value['caption'];
			}
			// список категории и характеристик для выпадающего списка фильтров
			$tpl->Assign('cat_spec', $cat_spec);
			if(isset($_GET['smb'])){
				if(isset($_GET['id_category']) && $_GET['id_category'] !== '0'){
					$arr['id_category'] = $_GET['id_category'];
				}
				if(isset($_GET['id_caption']) && $_GET['id_caption'] !== '0'){
					$arr['id_caption'] = $_GET['id_caption'];
				}
			}elseif(isset($_GET['clear_filters'])){
				unset($_GET);
				$url = explode('?',$_SERVER['REQUEST_URI']);
				header('Location: '.$url[0]);
				exit();
			}
			$specification->GetMonitoringList(false, $arr);
			if((isset($_GET['limit']) && $_GET['limit'] != 'all') || !isset($_GET['limit'])){
				if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
					$_GET['page_id'] = $_POST['page_nbr'];
				}
				$cnt = count($specification->list);
				$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
				$limit = ' '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
			}else{
				$GLOBALS['Limit_db'] = 0;
				$limit = false;
			}
			foreach($specification->list as $value){
				$specifications[$value['id_caption']] = $value['caption'];
			}
			$specification->GetMonitoringList($limit, $arr);
			$tpl->Assign('specifications', $specifications);
			$tpl->Assign('list', $specification->list);
			break;
		case 'products':
			$product = new Products();
			// $product->
			break;
		case 'characteristics':
			$product = new Products();
			// $product->
			break;
		case 'ip_connections':
			$where = '';
			if(isset($_GET['smb'])){
				if(isset($_GET['sid'])){
					$where .= 'WHERE sid = '.$_GET['sid'];
				}
			}elseif(isset($_GET['clear_filters'])){
				unset($_GET);
				$url = explode('?',$_SERVER['REQUEST_URI']);
				header('Location: '.$url[0]);
				exit();
			}
			$sql = 'SELECT COUNT(*) AS cnt FROM '._DB_PREFIX_.'ip_connections '.$where.' ORDER BY connections DESC';
			$res = $GLOBALS['db']->GetOneRowArray($sql);
			if((isset($_GET['limit']) && $_GET['limit'] != 'all') || !isset($_GET['limit'])){
				if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
					$_GET['page_id'] = $_POST['page_nbr'];
				}
				$cnt = $res['cnt'];
				$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
				$limit = ' '.$GLOBALS['Start'].', '.$GLOBALS['Limit_db'];
			}else{
				$GLOBALS['Limit_db'] = 0;
				$limit = false;
			}
			$sql = 'SELECT * FROM '._DB_PREFIX_.'ip_connections '.$where.' ORDER BY connections DESC LIMIT '.$limit;
			$list = $GLOBALS['db']->GetArray($sql);
			foreach($list as &$v){
				if($v['id_user'] !== null){
					$User = new Users();
					$User->SetFieldsById($v['id_user']);
					$v['email'] = $User->fields['email'];
				}
			}
			$tpl->Assign('list', $list);
			break;
		case 'uncategorised_products':
			if(isset($_POST['clear_filters'])){
				$where_art = null;
				$_POST['filter_art'] = null;
			} else{
				if(isset($_POST['filter_art']) && $_POST['filter_art'] !=''){
					$where_art = ' AND art LIKE \''.trim($_POST['filter_art']).'\'';
				}
			}
			$Products = new Products();
			/*Pagination*/
			if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
				$GLOBALS['Limit_db'] = $_GET['limit'];
			}
			if((isset($_GET['limit']) && $_GET['limit'] != 'all')||(!isset($_GET['limit']))){
				if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
					$_GET['page_id'] = $_POST['page_nbr'];
				}
				$cnt = count($Products->GetUncategorisedProducts($where_art));
				$tpl->Assign('cnt', $cnt);
				$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
				$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
			}else{
				$GLOBALS['Limit_db'] = 0;
				$limit = '';
			}
			$uncat_prod = $Products->GetUncategorisedProducts($where_art, $limit);
			$tpl->Assign('list', $uncat_prod);
			break;
		case 'err_feedback':
			if(isset($_POST['error_fix']) && isset($_POST['id_error'])){
				G::FixError($_POST['id_error']);
			}

			if(isset($_POST['clear_filters'])){
				$where_arr = null;
				$_POST['filter_user_name'] = null;
			} else{
				if(isset($_POST['filter_user_name']) && $_POST['filter_user_name'] !=''){
					if($_POST['filter_user_name'] == 'аноним'){
						$where_arr = ' AND u.name IS NULL';
					} else{
						$where_arr = ' AND u.name LIKE \'%'.trim($_POST['filter_user_name']).'%\'';
					}
				}
			}
			/*Pagination*/
			if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
				$GLOBALS['Limit_db'] = $_GET['limit'];
			}
			if((isset($_GET['limit']) && $_GET['limit'] != 'all')||(!isset($_GET['limit']))){
				if(isset($_POST['page_nbr']) && is_numeric($_POST['page_nbr'])){
					$_GET['page_id'] = $_POST['page_nbr'];
				}
				$cnt = count(G::GetErrors($where_arr));
				$tpl->Assign('cnt', $cnt);
				$GLOBALS['paginator_html'] = G::NeedfulPages($cnt);
				$limit = ' LIMIT '.$GLOBALS['Start'].','.$GLOBALS['Limit_db'];
			}else{
				$GLOBALS['Limit_db'] = 0;
				$limit = '';
			}
			$errors = G::GetErrors($where_arr, $limit);
			$tpl->Assign('list', $errors);
			break;
		default:
			break;
	}
	$tpl->Assign('h1', $GLOBALS['IERA_LINKS'][$ii]['title']);
	$parsed_res = array(
		'issuccess' => true,
		'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_monitoring_'.$GLOBALS['REQAR'][1].'.tpl')
	);
}else{
	$parsed_res = array(
		'issuccess' => true,
		'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_monitoring.tpl')
	);
}
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}
