<?php
if(!_acl::isAllow('product')){
	die("Access denied");
}
// ---- center ----
unset($parsed_res);
// --------------------------------------------------------------------------------------
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
$products = new Products();
$Unit = new Unit();
$Images = new Images();
//print_r($_POST);die();
if(isset($_GET['upload']) == true){
	$res = $Images->upload($_FILES, $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/');
	echo str_replace($GLOBALS['PATH_root'], '/', $res);
	exit(0);
}
// $f['images'] = $product['images'];
// foreach(explode(';', $product['images']) as $k=>$image){
// 	$newname = $data['art'].($k == 0?'':'-'.$k).'.jpg';
// 	$structure = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
// 	$images->checkStructure($structure);
// 	copy($_SERVER['DOCUMENT_ROOT'].str_replace(_base_url, '/', $image), $structure.$newname);
// 	$images->resize();
// }
$tpl->Assign('h1', 'Добавление товара');
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	if(isset($_POST['price']) && $_POST['price'] == ""){
		$_POST['price'] = 0;
	}
	list($err, $errm) = Product_form_validate();
	if(!$err){
		if($id = $products->AddProduct($_POST)){
			//Добавление видео
			if(!empty($_POST['video'])){
				$products->UpdateVideo($id, $_POST['video']);
			}
			//Добавление фото
			$article = $products->GetArtByID($id);
			foreach($_POST['images'] as $k=>$image){
				$newname = $article['art'].($k == 0?'':'-'.$k).'.jpg';
				$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']), '', $image));
				$path = $GLOBALS['PATH_product_img'].$file['dirname'].'/';
				$bd_path = str_replace($GLOBALS['PATH_root'].'..', '', $GLOBALS['PATH_product_img']).$file['dirname'];
				rename($path.$file['basename'], $path.$newname);
				$images_arr[] = $bd_path.'/'.$newname;
			}
			$Images->resize();
			$products->UpdatePhoto($id, $images_arr);
			$tpl->Assign('msg', 'Товар добавлен.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Товар не добавлен.');
			$tpl->Assign('errm', $errm);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Товар не добавлен.');
		$tpl->Assign('errm', $errm);
	}
}
// get last article
$sql = "SELECT art AS cnt
	FROM "._DB_PREFIX_."product
	WHERE (SELECT MAX(id_product) FROM "._DB_PREFIX_."product) = id_product";
$res = $db->GetOneRowArray($sql);
$tpl->Assign("max_cnt", $res['cnt']);
// Формирование списка категорий для выпадающего списка
$list = $dbtree->Full(array('id_category', 'category_level', 'name'));
$tpl->Assign('list', $list);
$tpl->Assign('unitslist', $Unit->GetUnitsList());
$tpl->Assign('mlist', $products->GetManufacturers());
if(!isset($_POST['smb'])){
	$_POST['id_product'] = 0;
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$_POST['categories_ids'][] = $GLOBALS['REQAR'][1];
	}else{
		$_POST['categories_ids'][] = 0;
	}
}
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$dbtree->Parents($GLOBALS['REQAR'][1], array('id_category', 'name', 'category_level'));
	if(!empty($dbtree->ERRORS_MES)){
	    print_r($dbtree->ERRORS_MES);die();
	}
	while($cat = $dbtree->NextRow()){
		if(0 <> $cat['category_level']){
			$GLOBALS['IERA_LINKS'][$ii]['title'] = $cat['name'];
			$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/products/'.$cat['id_category'];
		}
	}
}
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление товара";
$parsed_res = array('issuccess' => TRUE,
 					'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_product_ae.tpl'));
// --------------------------------------------------------------------------------------
if (TRUE == $parsed_res['issuccess']) {
	$tpl_center .= $parsed_res['html'];
}?>