<?php
$Products = new Products();
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
if(isset($_GET['savedprices']) == true){
	$price_list = $Products->GetPricelistById($_GET['selected-array']);
	$i = 0;
	foreach($price_list as $k=>&$l){
		if(!isset($name)){
			$name = $l['price_name'];
		}
		$image = $Products->GetPhotoById($l['id_product']);
		$list1[$l['id_category']]['name'] = $l['cat_name'];
		$list1[$l['id_category']]['products'][] = array(
			'id_product' => $l['id_product'],
			'art' => $l['art'],
			'img_1' => $l['img_1'],
			'image' => $image[0]['src'],
			'name' => $l['name'],
			'min_mopt_qty' => $l['min_mopt_qty'],
			'inbox_qty' => $l['inbox_qty'],
			'price_mopt' => $l['price_mopt'],
			'price_opt' => $l['price_opt'],
			'units' => $l['units'],
			'opt_correction_set' => $l['opt_correction_set'],
			'mopt_correction_set' => $l['mopt_correction_set']
		);
		$i++;
	}
	// $fields = array('id_category', 'name', 'pid', 'category_level');
	// $var1 = $dbtree->GetCategories($fields, 1);
	// foreach($var1 as $v1){
	// 	$list[$v1['id_category']] = $v1;
	// 	foreach($dbtree->GetSubCats($v1['id_category'], $fields) as &$v2){
	// 		if(isset($list1[$v2['id_category']])){
	// 			$v2['products'] = $list1[$v2['id_category']]['products'];
	// 		}
	// 		foreach($dbtree->GetSubCats($v2['id_category'], $fields) as &$v3){
	// 			if(isset($list1[$v3['id_category']])){
	// 				$v3['products'] = $list1[$v3['id_category']]['products'];
	// 				$v2['subcats'][$v3['id_category']] = $v3;
	// 			}
	// 		}
	// 		if(isset($v2['subcats']) == true || isset($v2['products']) == true){
	// 			$list[$v2['pid']]['subcats'][$v2['id_category']] = $v2;
	// 		}
	// 	}
	// }
	$list = $list1;
	$tpl->Assign('name', $name);
}else{
	$selected_list = explode(';', $_GET['selected-array']);
	array_pop($selected_list);
	foreach($selected_list as $sl){
		$list[$sl] = $Products->PriceListProductsByCat($sl);
		$cat[] = $dbtree->CheckParent($sl);
		if(!empty($list[$sl])){
			foreach($list[$sl] as &$p){
				$images = $Products->GetPhotoById($p['id_product']);
				$p['image'] = $images[0]['src'];
			}
		}
	}
	$tpl->Assign('cat', $cat);
}
$tpl->Assign('list', $list);
echo $tpl->Parse($GLOBALS['PATH_tpl'].'price_list.tpl');
exit(0);
