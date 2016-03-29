<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$specification = new Specification();
	$products = new Products();
	if(isset($_POST['action']))
		switch($_POST['action']){
			case"specification_update":
				$products->UpdateProduct(array('id_product'=>$_POST['id_product']));
				if($_POST['id_spec_prod'] == ''){
					if($specification->AddSpecToProd($_POST, $_POST['id_product'])){
						echo json_encode('ok');
					}
				}
				else {
					if($specification->UpdateSpecsInProducts($_POST)){
						echo json_encode('ok');
					}
				}
			break;
			case"get_prodlist_moderation":
				$arr = $specification->GetProdlistModeration($_POST['id_category'],$_POST['specification'],$_POST['value']);
				foreach($arr as $k=>$value) {
					$value['id_prod'];
					$value['name'];
					echo "<li><a target='_blank' href='/adm/productedit/".$value['id_prod']."'>".($k+1)." - ".$value['name']."</a></li>";
				}
				break;
			case"getValuesOfTypes":
				$valitem = $products->getValuesItem($_POST['id'], $_POST['idcat']);

				foreach ($valitem as &$v){
					echo '<option value="'.$v['value'].'">';
				}
				break;
			default:
			break;
		}
	exit();
}
?>