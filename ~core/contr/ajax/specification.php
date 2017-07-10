<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	$Specification = new Specification();
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'getProdlistModeration':
				$arr = $Specification->GetProdlistModeration($_POST['id_category'],$_POST['specification'],$_POST['value']);
				foreach($arr as $k=>$value) {
					$value['id_prod'];
					$value['name'];
					echo "<li><a target='_blank' href='/adm/productedit/".$value['id_prod']."'>".($k+1)." - ".$value['name']."</a></li>";
				}
				unset($arr);
				break;
			case 'changeSpecificationValue':
				if($Specification->UpdateSpecsValueMonitoring($_POST)){
					echo "ok";
				}else{
					echo "error";
				}
				break;
			case 'toggleSpecInCat':
				if((boolean) $_POST['enable']){
					$Specification->AddSpecToCat($_POST);
				}else{
					$Specification->DelSpecFromCat($_POST);
				}
				break;
			case 'reorder':
				$echo = true;
				foreach($_POST['order'] as $key => &$value){
					$value = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
				}
				if(!$Specification->ReorderInCategory($_POST['order'], $_POST['id_category'])){
					$echo = false;
				}
				echo json_encode($echo);
				break;
			case 'addSpecValue':
				$echo = false;
				if($id = $Specification->AddValue($_POST)){
					$echo = $id;
				}
				echo json_encode($echo);
				break;
			case 'deleteSpecValue':
				$echo = false;
				if($Specification->DeleteValue($_POST['id'])){
					$echo = true;
				}
				echo json_encode($echo);
				break;
			case 'updateSpecValue':
				$echo = false;
				if($Specification->UpdateValue($_POST)){
					$echo = true;
				}
				echo json_encode($echo);
				break;
			default:
				break;
		}
	}
}
exit();
