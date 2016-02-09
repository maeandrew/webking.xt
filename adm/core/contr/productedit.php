<?php
if(!_acl::isAllow('product')){
	die("Access denied");
}
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_product = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
$Unit = new Unit();
$products = new Products();
$News = new News();
$Images = new Images();
$specification = new Specification();
$segmentation = new Segmentation();
if($News->GetCommentListById($id_product)){
	$tpl->Assign('list_comment', $News->list);
}
$pops1 = $News->GetComent();
$tpl->Assign('pops1', $pops1);
$tpl->Assign('related_prods_list', $products->GetArrayRelatedProducts($id_product));
$specification->SetListByProdId($id_product);
$tpl->Assign('product_specs', $specification->list);
$specification->SetList();
$tpl->Assign('specs', $specification->list);
$tpl->Assign('unitslist', $Unit->GetUnitsList());
$tpl->Assign('list_segment_types', $segmentation->GetSegmentationType());

if(isset($_GET['action']) && $_GET['action'] == "update_spec"){
	if($_GET['id_spec_prod'] == ''){
		$specification->AddSpecToProd($_GET, $id_product);
	}else {
		$specification->UpdateSpecsInProducts($_GET);
	}
	header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id_product);
}elseif(isset($_GET['action']) && $_GET['action'] == "delete_spec"){
	$specification->DelSpecFromProd($_GET['id_spec_prod']);
	$products->UpdateProduct(array('id_product'=>$id_product));
	header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id_product);
}
if(isset($_POST['smb']) || isset($_POST['smb_new'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	if(isset($_POST['price']) && $_POST['price'] == ""){
		$_POST['price'] = 0;
	}
	list($err, $errm) = Product_form_validate();
	if(!$err){
		if(isset($_POST['images']) && !empty($_POST['images'])){
			$to_resize = array();
			//Физическое удалание файлов
			if(isset($_POST['removed_images']) && !empty($_POST['removed_images'])){
				foreach($_POST['removed_images'] as $k=>$path){
					if(file_exists($path) && $products->CheckImages($path)){
						$Images->remove($GLOBALS['PATH_root'].'..'.$path);
					}
				}
			}
			//Добавление фото
			foreach($_POST['images'] as $k=>$image){
				if(IsRenameNeeded($image)){
					$to_rename[$k] = $image;
				}else{
					$no_rename[$k] = $image;
				}
			}
			//Высчитываем номер посл. добавленной картинки
			if(isset($no_rename) && !empty($no_rename)){
				$i = 0;
				foreach($no_rename as $k=>$value){
					$img_info = pathinfo($value);
					$num_arr = explode('-',$img_info['filename']);
					$num = array_pop($num_arr);
					if($num > $i){
						$i = $num;
					}
				}
			}else{
				$i = 0;
			}
			if(isset($to_rename) && !empty($to_rename)){
				foreach($to_rename as $key => $value){
					//$newname = $_POST['art'].'-'.(count($_POST['images'])-count($to_rename)+$i+1).'.jpg';
					$newname = $_POST['art'].'-'.($i+1).'.jpg';
					$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']), '', $value));
					$path = $GLOBALS['PATH_product_img'].$file['dirname'].'/';
					if(is_dir($path) && file_exists($path.$file['basename'])){
						rename($path.$file['basename'], $path.$newname);
						$_POST['images'][$key] = str_replace($GLOBALS['PATH_root'].'..', '', $path.$newname);
						$i++;
					}
					$to_resize[] = $newname;
				}
			}
			$response = $Images->resize(false, $to_resize);
		}
		if($products->UpdateProduct($_POST)){
			$err_mes = '';
			//обновление видео товара
			if(!empty($_POST['video'])){
				$products->UpdateVideo($id_product, $_POST['video']);
			}
			//обновление Фото товара
			$products->UpdatePhoto($id_product, isset($_POST['images'])?$_POST['images']:null);

			if(isset($_POST['id_supplier'])){
				//Формирем массив поставщиков товара
				for ($i=0; $i < count($_POST['id_supplier']); $i++) {
					$supp_arr[] = array(
						"id_assortiment" => isset($_POST['id_assortiment'][$i])?$_POST['id_assortiment'][$i]:false,
						"id_supplier" => $_POST['id_supplier'][$i],
						"price_opt_otpusk" => $_POST['price_opt_otpusk'][$i],
						"price_mopt_otpusk" => $_POST['price_mopt_otpusk'][$i],
						"product_limit" => $_POST['product_limit'][$i],
						"inusd" => $_POST['inusd'][$i]
					);
				}

				foreach($supp_arr as $k => $value){
					$value['id_product'] = $id_product;
					if($value['id_assortiment'] == false){
						//Добавляем поставщика в ассортимент
						if(!$products->AddToAssortWithAdm($value)){
							$err_mes = '<script>alert("Ошибка при добавлении поставщика!\nДанный товар уже имеется в ассортименте поставщика!");</script>';
						}
					}else{
						//Обновляем данные в ассортименте
						$products->UpdateAssortWithAdm($value);
					}
				}
			}

			//Отвязываем постащика от товара
			if(isset($_POST['del_from_assort']) && !empty($_POST['del_from_assort'])){
				foreach($_POST['del_from_assort'] as &$id_assort){
					$products->DelFromAssortWithAdm($id_assort, $id_product);
				}
			}

			//Привязываем сегментяцию к продукту
			if(isset($_POST['id_segment'])){
				foreach ($_POST['id_segment'] as &$id_segment) {
					if(!$segmentation->AddSegmentInProduct($id_product, $id_segment)){
						$err_mes = '<script>alert("Ошибка при добавлении сегмента!\nСегмент уже закреплен за данным товаром!");</script>';
					}
				}
			}
			//Удаляем сегментяцию с товара
			if(isset($_POST['del_segment_prod']) && !empty($_POST['del_segment_prod'])){
				foreach($_POST['del_segment_prod'] as $id_segment){
					$segmentation->DelSegmentInProduct($id_product, $id_segment);
				}
			}
			$tpl->Assign('msg', 'Товар обновлен.'.$err_mes);
			if(isset($_POST['smb_new'])){
				header('Location: '.$GLOBALS['URL_base'].'adm/productadd/');
				exit();
			}
			header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id_product);
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Товар не обновлен.');
			$tpl->Assign('errm', $errm);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Товар не обновлен2.');
		$tpl->Assign('errm', $errm);
		//print_r($errm);
	}
}
if(!$products->SetFieldsById($id_product, 1)) die('Ошибка при выборе товара.');
// Формирование списка категорий для выпадающего списка
$list = $dbtree->Full(array('id_category', 'category_level', 'name'));
// Определение категории к которой принадлежит товар
if(isset($item['id_category']) && $item['id_category'] == $products->fields['id_category']){
	$category['name'] = $item['name'];
	$category['id_category'] = $item['id_category'];
}
$tpl->Assign('list', $list);
$tpl->Assign('mlist', $products->GetManufacturers());

// get last article
$sql = "SELECT art AS cnt
	FROM "._DB_PREFIX_."product
	WHERE (SELECT MAX(id_product) FROM "._DB_PREFIX_."product) = id_product";
$res = $db->GetOneRowArray($sql);
$max_cnt = $res['cnt'];
//Дубликат товара
if(isset($_POST['smb_duplicate'])){
	if($id = $products->DuplicateProduct($_POST)){
		header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id);
	}else{
		$tpl->Assign('msg', 'Товар не добавлен.');
		$tpl->Assign('errm', $errm);
	}


	$_POST['art'] = $products->CheckArticle((int) $_POST['art']);
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	if(isset($_POST['price']) && $_POST['price'] == ""){
		$_POST['price'] = 0;
	}
	list($err, $errm) = Product_form_validate();
	if(!$err){
		die();
		if($id = $products->AddProduct($_POST)){
			$products->UpdateVideo($id, $_POST['video']);
			$products->UpdatePhoto($id, $_POST['images']);
			header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id);
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

$tpl->Assign('suppliers_info', $products->GetSuppliersInfoForProduct($id_product));
//Получение списка сегментаций прикрепленных к тоавру
$tpl->Assign('segmentations', $segmentation->GetSegmentationsForProduct($id_product));
//Заполнение массива POST
$video = $products->GetVideoById($id_product);
$photo = $products->GetPhotoById($id_product);
$_POST['id_product'] = 0;
$prod_fields = $products->fields;
$prod_fields['video'] = $video;
$prod_fields['images'] = $photo;
foreach($prod_fields as $k=>$v){
	if(!isset($_POST['smb']) || !isset($_POST[$k])){
		$_POST[$k] = $v;
	}
}
$tpl->Assign('h1', $_POST['name']);
$parsed_res = array(
	'issuccess' => true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_product_ae.tpl')
);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
if(isset($category['id_category'])){
	$dbtree->Parents($category['id_category'], array('id_category', 'name', 'category_level'));
	if(!empty($dbtree->ERRORS_MES)) {
	    print_r($dbtree->ERRORS_MES);die();
	}
	while($cat = $dbtree->NextRow()){
		if(0 <> $cat['category_level']){
			$GLOBALS['IERA_LINKS'][$ii]['title'] = $cat['name'];
			$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/products/'.$cat['id_category'];
		}
	}
}
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование товара";
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}

function IsRenameNeeded($path){
	$path_arr = explode('/', $path);
	$file_name = array_pop($path_arr);
	$exists = glob($GLOBALS['PATH_product_img'].'original/*/*/*/'.$file_name);
	if(!strpos($path, str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img'])) && !empty($exists) && file_exists($GLOBALS['PATH_product_img'].'..'.$path)){
		return false;
	}
	return true;
}
?>