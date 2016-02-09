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
$segmentation = new Segmentation();
//print_r($_POST);die();
if(isset($_GET['upload']) == true){
	$res = $Images->upload($_FILES, $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/');
	echo str_replace($GLOBALS['PATH_root'], '/', $res);
	exit(0);
}
$tpl->Assign('h1', 'Добавление товара');
if(isset($_POST['smb'])){
	$_POST['art'] = $products->CheckArticle((int) $_POST['art']);
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
			$to_resize = array();

			//Добавление фото
			$article = $products->GetArtByID($id);
			if(isset($_POST['images'])){
				foreach($_POST['images'] as $k=>$image){
					$to_resize[] = $newname = $article['art'].($k == 0?'':'-'.$k).'.jpg';
					$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_product_img']), '', $image));
					$path = $GLOBALS['PATH_product_img'].$file['dirname'].'/';
					$bd_path = str_replace($GLOBALS['PATH_root'].'..', '', $GLOBALS['PATH_product_img']).$file['dirname'];
					rename($path.$file['basename'], $path.$newname);
					$images_arr[] = $bd_path.'/'.$newname;
				}
			}else{
				$images_arr =  array();
			}
			$Images->resize(false, $to_resize);
			// print_r('assadasd');die();
			$products->UpdatePhoto($id, $images_arr);

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

				foreach ($supp_arr as $k => $value) {
					if($value['id_assortiment'] == false){
						$value['id_product'] = $id;
						//Добавляем поставщика в ассортимент
						if(!$products->AddToAssortWithAdm($value)){
							echo '<script>alert("Ошибка при добавлении поставщика!\nДанный товар уже имеется в ассортименте поставщика!");</script>';
						}
					}else{
						//Обновляем данные в ассортименте
						$products->UpdateAssortWithAdm($value);
					}
				}
			}

			//Привязываем сегментяцию к продукту
			if(isset($_POST['id_segment'])){
				foreach ($_POST['id_segment'] as &$id_segment) {
					if(!$segmentation->AddSegmentInProduct($id, $id_segment)){
						$err_mes = '<script>alert("Ошибка при добавлении сегмента!\nСегмент уже закреплен за данным товаром!");</script>';
					}
				}
			}
			$tpl->Assign('msg', 'Товар добавлен.');
			echo "<script Language=\"JavaScript\">setTimeout(\"document.location='".$GLOBALS['URL_base']."adm/productedit/".$id."'\", 2000);</script>";
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
if(!isset($_POST['art'])){
	// get last article
	$sql = "SELECT art
		FROM "._DB_PREFIX_."product
		WHERE id_product = (SELECT MAX(id_product) FROM "._DB_PREFIX_."product)";
	$res = $db->GetOneRowArray($sql);
	$tpl->Assign("max_cnt", $res['art']+1);
}
// Формирование списка категорий для выпадающего списка
$list = $dbtree->Full(array('id_category', 'category_level', 'name'));
$tpl->Assign('list', $list);
$tpl->Assign('unitslist', $Unit->GetUnitsList());
$tpl->Assign('mlist', $products->GetManufacturers());
$tpl->Assign('list_segment_types', $segmentation->GetSegmentationType());
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