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
$Products = new Products();
$News = new News();
$Images = new Images();
$specification = new Specification();
$segmentation = new Segmentation();
if($News->GetCommentListById($id_product)){
	$tpl->Assign('list_comment', $News->list);
}
$pops1 = $News->GetComent();
$tpl->Assign('pops1', $pops1);
$tpl->Assign('related_prods_list', $Products->GetArrayRelatedProducts($id_product));
$specification->SetListByProdId($id_product);
$tpl->Assign('product_specs', $specification->list);
$specification->SetList();
$tpl->Assign('specs', $specification->list);
$tpl->Assign('unitslist', $Unit->GetUnitsList());
$tpl->Assign('list_segment_types', $segmentation->GetSegmentationType());

if(isset($_GET['upload']) == true){
	$res = $Images->upload($_FILES, $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/');
	echo str_replace($GLOBALS['PATH_root'], '/', $res);
	exit(0);
}
if(isset($_GET['action']) && $_GET['action'] == "update_spec"){
	if($_GET['id_spec_prod'] == ''){
		$specification->AddSpecToProd($_GET, $id_product);
	}else {
		$specification->UpdateSpecsInProducts($_GET);
	}
	header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id_product);
}elseif(isset($_GET['action']) && $_GET['action'] == "delete_spec"){
	$specification->DelSpecFromProd($_GET['id_spec_prod']);
	$Products->UpdateProduct(array('id_product'=>$id_product));
	header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id_product);
}
if(isset($_POST['smb']) || isset($_POST['smb_new'])){
	if(isset($_POST['images_visible'])){
		$_POST['images_visible'][0] = 1;
	}
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
				foreach($_POST['removed_images'] as $path){
					if(file_exists(str_replace('\\/', '/', $GLOBALS['PATH_global_root'].$path)) && $Products->CheckImages($path)){
						$Images->remove(str_replace('\\/', '/', $GLOBALS['PATH_global_root'].$path));
					}
				}
			}
			//Добавление фото
			foreach($_POST['images'] as $k=>&$image){
				if(strpos($image, '/temp/') !== false){
					$Images = new Images();
					$path = $GLOBALS['PATH_product_img'].'original/'.date('Y').'/'.date('m').'/'.date('d').'/';
					$Images->checkStructure($path);
					$file = pathinfo($GLOBALS['PATH_global_root'].$image);
					if(strpos($file['filename'], $_POST['art']) === false){
						$file['filename'] = $_POST['art'];
						if(!empty(glob($GLOBALS['PATH_product_img'].'original/*/*/*/'.$file['filename'].'.*'))){
							$file['filename'] .= '-'.GenerateNewImageName($file['filename']);
						}
						$file['basename'] = $file['filename'].'.'.$file['extension'];
					}
					rename($GLOBALS['PATH_global_root'].$image, $path.$file['basename']);
					$to_resize[] = $file['basename'];
					//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
					$size = getimagesize($path.$file['basename']); //Получаем ширину, высоту, тип картинки
					if($size[0] > 1000 || $size[1] > 1000){
						$ratio=$size[0]/$size[1]; //коэфициент соотношения сторон
						//Определяем размеры нового изображения
						if(max($size[0], $size[1]) == $size[0]){
							$width = 1000;
							$height = 1000/$ratio;
						}else if(max($size[0], $size[1]) == $size[1]){
							$width = 1000*$ratio;
							$height = 1000;
						}
						$res = imagecreatetruecolor($width, $height);
						imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
						$src = $size['mime']=='image/jpeg'?imagecreatefromjpeg($path.$file['basename']):imagecreatefrompng($path.$file['basename']);
						imagecopyresampled($res, $src, 0,0,0,0, $width, $height, $size[0], $size[1]);
						imagejpeg($res, $path.$file['basename']);
					}
					$image = str_replace($GLOBALS['PATH_global_root'], '/', $path.$file['basename']);
				}
			}
			$response = $Images->resize(false, $to_resize);
		}

		if($Products->UpdateProduct($_POST)){
			$err_mes = '';
			//обновление видео товара
			if(!empty($_POST['video'])){
				$Products->UpdateVideo($id_product, $_POST['video']);
			}
			//обновление Фото товара
			$Products->UpdatePhoto($id_product, isset($_POST['images'])?$_POST['images']:null, isset($_POST['images_visible'])?$_POST['images_visible']:null);

			// if(isset($_POST['id_supplier'])){
			// 	//Формирем массив поставщиков товара
			// 	for($i=0; $i < count($_POST['id_supplier']); $i++){
			// 		$supp_arr[] = array(
			// 			"id_assortiment" => isset($_POST['id_assortiment'][$i])?$_POST['id_assortiment'][$i]:false,
			// 			"id_supplier" => $_POST['id_supplier'][$i],
			// 			"price_opt_otpusk" => $_POST['supplier_price_opt'][$i],
			// 			"price_mopt_otpusk" => $_POST['supplier_price_mopt'][$i],
			// 			"active" => $_POST['supplier_product_available'][$i],
			// 			"inusd" => $_POST['inusd'][$i]
			// 		);
			// 	}
			// 	foreach($supp_arr as $k => $value){
			// 		$value['id_product'] = $id_product;
			// 		if($value['id_assortiment'] === false){
			// 			//Добавляем поставщика в ассортимент
			// 			if(!$Products->AddToAssortWithAdm($value)){
			// 				$err_mes = '<script>alert("Ошибка при добавлении поставщика!\nДанный товар уже имеется в ассортименте поставщика!");</script>';
			// 			}
			// 		}else{
			// 			//Обновляем данные в ассортименте
			// 			$Products->UpdateAssortWithAdm($value);
			// 		}
			// 	}
			// }
			//Отвязываем постащика от товара
			if(isset($_POST['del_from_assort']) && !empty($_POST['del_from_assort'])){
				foreach($_POST['del_from_assort'] as &$id_assort){
					$Products->DelFromAssortWithAdm($id_assort, $id_product);
				}
			}
			//Привязываем сегментяцию к продукту
			if(isset($_POST['id_segment'])){
				foreach ($_POST['id_segment'] as &$id_segment){
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
	}
}
if(!$Products->SetFieldsById($id_product, 0)) die('Ошибка при выборе товара.');
// Формирование списка категорий для выпадающего списка
$list = $Products->generateCategory();
// Определение категории к которой принадлежит товар
if(isset($item['id_category']) && $item['id_category'] == $Products->fields['id_category']){
	$category['name'] = $item['name'];
	$category['id_category'] = $item['id_category'];
}
$tpl->Assign('list', $list);
// get last article
$tpl->Assign('last_article', $Products->GetLastArticle());
//Дубликат товара
if(isset($_POST['smb_duplicate'])){
	if($id = $Products->DuplicateProduct($_POST)){
		header('Location: '.$GLOBALS['URL_base'].'adm/productedit/'.$id);
	}else{
		$tpl->Assign('msg', 'Товар не добавлен.');
		$tpl->Assign('errm', $errm);
	}
}
$tpl->Assign('suppliers_info', $Products->GetSuppliersInfoForProduct($id_product));
//Получение списка сегментаций прикрепленных к тоавру
$tpl->Assign('segmentations', $segmentation->GetSegmentationsForProduct($id_product));
//Заполнение массива POST
$video = $Products->GetVideoById($id_product);
$photo = $Products->GetPhotoById($id_product, 'all');
$_POST['id_product'] = 0;
$prod_fields = $Products->fields;
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
	$res = $dbtree->Parents($category['id_category'], array('id_category', 'name', 'category_level'));
	foreach($res as $cat){
		if($cat['category_level'] > 0){
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
	$file = pathinfo($GLOBALS['PATH_root'].$path);
	$exists = glob($GLOBALS['PATH_product_img'].'original/*/*/*/'.$file['basename']);
	if(!empty($exists)){
		return true;
	}
	return false;
}
function GenerateNewImageName($filename, $i = 1){
	if(!empty(glob($GLOBALS['PATH_product_img'].'original/*/*/*/'.$filename.'-'.$i.'.*'))){
		$i++;
		$i = GenerateNewImageName($filename, $i);
	}
	return $i;
}
