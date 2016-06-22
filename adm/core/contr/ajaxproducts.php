<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Products = new Products();
	if(isset($_POST['action']))
		switch($_POST['action']){
			case 'specification_update':
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
			case 'update_translit':
				echo json_encode($Products->UpdateTranslit($_POST['id_product']));
				break;
			case 'datalist':
				echo json_encode($Products->GetIdOneRowArrayByArt($_POST['article']));
				break;
			case 'datalist_supplier':
				$Supplier = new Suppliers();
				echo json_encode($Supplier->GetIdOneRowArrayByArt($_POST['article']));
				break;
			case 'insert_related':
				echo json_encode($Products->AddRelatedProduct($_POST['id_prod'], $_POST['id_related_prod']));
				break;
			case 'remove_related':
				echo json_encode($Products->DelRelatedProduct($_POST['id_prod'], $_POST['id_related_prod']));
				break;
			case 'add_supplier':
				echo json_encode($Products->GetSupplierInfoByArticle($_POST['art']));
				break;
			case 'get_segment_list':
				$Segmentation = new Segmentation();
				echo json_encode($Segmentation->GetSegmentation($_POST['type']));
				break;
			case 'UpdateGraph':
				echo json_encode($Products->UpdateGraph($_POST, true));
				break;
			case 'AddPhotoProduct':
				$echo = 'error';
				if($id_product = $Products->AddPhotoProduct($_POST)){
					$Products->SetFieldsByID($id_product);
					$product = $Products->fields;
					$images = $Products->GetPhotoById($id_product);
					$videos = $Products->GetVideoById($id_product);
					$echo = '<div class="prodListItem">
						<div class="nameProd">
							<a href="'.Link::Product($product['translit']).'"><span>Товар:</span></a>
							<span>'.$product['name'].'</span>
						</div>
						<div class="createData">
							<span>Дата:</span>
							<span>'.$product['create_date'].'</span>
						</div>
						<div class="prodImages">';
					foreach($images as $image){
						$echo .= '<img src="'.$image['src'].'" '.($image['visible'] == 0?'class="imgopacity"':null).'>';
					}
					$echo .= '</div>
						<div class="prodVideos">';
					if(is_array($videos)){
						foreach($videos as $video){
							$echo .= '<a href="'.$video.'" target="blank">
									<img src="/images/video_play.png">
									<span class="name">'.$video.'</span>
								</a>';
						}
					}
					$echo .= '</div>
						</div>';
				}
				echo $echo;
				break;
			case 'DeleteUploadedImage':
				$Images = new Images();
				// var_dump($GLOBALS['PATH_root'].$_POST['src']);
				if($Images->remove($GLOBALS['PATH_root'].$_POST['src'])){
					$echo = true;
				}else{
					$echo = false;
				}
				echo json_encode($echo);
				break;
			default:
				break;
		}
	exit();
}