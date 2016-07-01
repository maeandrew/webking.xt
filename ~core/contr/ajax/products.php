<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	$Products = new Products();
	$id_category = isset($_POST['id_category'])?$_POST['id_category']:null;
	$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
	function selectAll($dbtree, $id_category = null, $str = array()){
		$subcats = $dbtree->GetSubCats($id_category, array('id_category', 'category_level', 'category_img', 'name', 'translit', 'art', 'pid', 'visible'));
		if($id_category != 0){
			$str[] = $id_category;
		}
		if(!empty($subcats)){
			foreach($subcats as $val){
				$str = selectAll($dbtree, $val["id_category"], $str);
			}
		}
		return $str;
	}
	$res = selectAll($dbtree, $id_category);
	if(count($res) > 1){
		$where_arr['customs'][] = "cp.id_category IN (".implode(', ', $res).")";
	}else{
		$where_arr = array('cp.id_category' => $id_category);
	}
	$params = array(
		'group_by' => 'a.id_product',
		'ajax' => true,
		'rel_search' => null
	);
	if(isset($_COOKIE['sorting'])) {
		$sort = json_decode($_COOKIE['sorting'], true);
		$sorting = $sort['products'];
		$params['order_by'] = $sorting['value'];
	}

	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "getFilterLink":
				echo json_encode(Link::Category($_POST['rewrite'], $_POST['params'], $_POST['segment']));
				break;
			case "getmoreproducts":
				$Products->SetProductsList($where_arr, ' LIMIT '.($_POST['skipped_products']+$_POST['shown_products']).', 30', 0, $params);
				if($Products->list){
					foreach($Products->list as &$p){
						$p['images'] = $Products->GetPhotoById($p['id_product']);
					}
				}
				$tpl->Assign('list', $Products->list);
				$i = $_POST['shown_products']+1;
				$products_list = $tpl->Parse($GLOBALS['PATH_tpl_global'].'products_list.tpl');
				echo $products_list;
				break;
			case "getproductscount":
				$cnt = $Products->GetProductsCnt($where_arr, 0, $params);
				echo $cnt;
				break;
			default:
				break;
		}
		exit();
	}
}
?>