<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	$Products = new Products();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "getFilterLink":
				echo json_encode(Link::Category($_POST['rewrite'], $_POST['params'], $_POST['segment']));
				break;
			case "getmoreproducts":
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
				$cnt = $Products->GetProductsCnt($where_arr, 0, $params);
				echo $cnt;
				break;
			case 'addPhotoProduct':
				$echo = 'error';
				if(isset($_POST['id_category'])){
					$_POST['categories_ids'][] = $_POST['id_category'];
					unset($_POST['id_category']);
				}
				if($id_product = $Products->AddPhotoProduct($_POST)){
					$Products->SetFieldsByID($id_product);
					$product = $Products->fields;
					$images = $Products->GetPhotoById($id_product, true);
					$videos = $Products->GetVideoById($id_product);
					$echo = '<div class="prodListItem">
						<div class="prodInfo">
							<div class="nameProd">
								<label>Название:</label>
								<span>'.$product['name'].'</span>
							</div>
							<div class="createData">
								<label>Добавлен:</label>
								<span>'.$product['create_date'].'</span>
							</div>
						</div>
						<div class="actions">
							<a href="/adm/productedit/'.$product['id_product'].'" class="icon-font btn-m-blue" target="_blank" title="Редактировать">e</a>
							<a href="'.Link::Product($product['translit']).'" class="icon-font btn-m-green" target="_blank" title="Посмотреть на сайте">v</a>
						</div>
						<div class="prodImages">';
					foreach($images as $image){
						$echo .= '<img src="'.str_replace('/original/', '/thumb/', $image['src']).'" '.($image['visible'] == 0?'class="imgopacity"':null).'>';
					}
					$echo .= '</div>';
					if(is_array($videos)){
						$echo .= '<div class="prodVideos">';
						foreach($videos as $video){
							$echo .= '<a href="'.$video.'" target="blank">
									<img src="/images/video_play.png">
									<span class="name">'.$video.'</span>
								</a>';
						}
						$echo .= '</div>';
					}
					$echo .= '</div>';
				}
				echo $echo;
				break;
			case 'deleteUploadedImage':
				$Images = new Images();
				if($Images->remove($GLOBALS['PATH_root'].$_POST['src'])){
					$echo = true;
				}else{
					$echo = false;
				}
				echo json_encode($echo);
				break;
			case 'updateDemandChart':
				echo json_encode($Products->UpdateDemandChart($_POST, true));
				break;
			case 'specificationUpdate':
				$Specification = new Specification();
				$Products->UpdateProduct(array('id_product'=>$_POST['id_product']));
				if($_POST['id_spec_prod'] == ''){
					if($Specification->AddSpecToProd($_POST, $_POST['id_product'])){
						echo json_encode('ok');
					}
				}else{
					if($Specification->UpdateSpecsInProducts($_POST)){
						echo json_encode('ok');
					}
				}
				break;
			case 'updateTranslit':
				echo json_encode($Products->UpdateTranslit($_POST['id_product']));
				break;
			case 'datalistSupplier':
				$Suppliers = new Suppliers();
				echo json_encode($Suppliers->GetIdOneRowArrayByArt($_POST['article']));
				break;
			case 'removeRelated':
				echo json_encode($Products->DelRelatedProduct($_POST['id_prod'], $_POST['id_related_prod']));
				break;
			case 'insertRelated':
				echo json_encode($Products->AddRelatedProduct($_POST['id_prod'], $_POST['id_related_prod']));
				break;
			case 'dataList':
				echo json_encode($Products->GetIdOneRowArrayByArt($_POST['article']));
				break;
			case 'getSegmentList':
				$Segmentation = new Segmentation();
				echo json_encode($Segmentation->GetSegmentation($_POST['type']));
				break;
			case 'addSupplier':
				$Suppliers = new Suppliers();
				$id_supplier = $Suppliers->GetSupplierIdByArt($_POST['article']);
				$Suppliers->SetFieldsByID($id_supplier);
					$_POST['product_limit'] = 0;
					$_POST['active'] = 0;
					if(($_POST['price_opt_otpusk'] != 0) || ($_POST['price_mopt_otpusk'] != 0)){
						$_POST['product_limit'] = 100000000;
						$_POST['active'] = 1;
					}
					if($_POST['inusd'] == 1){
						$_POST['price_mopt_otpusk_usd'] = $_POST['price_mopt_otpusk'];
						$_POST['price_mopt_otpusk'] = $_POST['price_mopt_otpusk']*$Suppliers->fields['currency_rate'];
						$_POST['price_opt_otpusk_usd'] = $_POST['price_opt_otpusk'];
						$_POST['price_opt_otpusk'] = $_POST['price_opt_otpusk']*$Suppliers->fields['currency_rate'];
					}else{
						$_POST['price_mopt_otpusk_usd'] = $_POST['price_mopt_otpusk']/$Suppliers->fields['currency_rate'];
						$_POST['price_opt_otpusk_usd'] = $_POST['price_opt_otpusk']/$Suppliers->fields['currency_rate'];
					}
					if(!$Products->IsInAssort($_POST['id_product'], $id_supplier)){
						$Products->AddProductToAssort($_POST['id_product'], $id_supplier, $_POST, $Suppliers->fields['koef_nazen_opt'], $Suppliers->fields['koef_nazen_mopt'], $_POST['inusd']==1?true:false);
						echo json_encode(true);
					}else{
						echo json_encode(false);
					}
				break;
			case"getValuesOfTypes":
				$valitem = $Products->getValuesItem($_POST['id'], $_POST['idcat']);
				foreach ($valitem as &$v){
					echo '<option value="'.$v['value'].'">';
				}
				break;
			case"getValuesOfTypes":
				$valitem = $Products->getValuesItem($_POST['id'], $_POST['idcat']);
				foreach ($valitem as &$v){
					echo '<option value="'.$v['value'].'">';
				}
			case "getProductBatch":
				$prod = $Products->GetProductsByIdUser($_POST['id_user'], $_POST['$date'], $_POST['$id_supplier']);
				echo json_encode($prod);
				break;
			default:
				break;
		}
	}
}
exit();
