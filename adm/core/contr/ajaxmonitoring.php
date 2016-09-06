<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'ChangeSpecificationValue':
				$specification = new Specification();
				if($specification->UpdateSpecsValueMonitoring($_POST)){
					echo "ok";
				}else{
					echo "error";
				}
				break;
			case 'blockIP':
				$f['block'] = $_POST['block'] === 'true'?1:0;
				$GLOBALS['db']->StartTrans();
				if(!$GLOBALS['db']->Update(_DB_PREFIX_.'ip_connections', $f, ' id = '.$_POST['id'])){
					$GLOBALS['db']->FailTrans();
					$res = false;
				}else{
					$GLOBALS['db']->CompleteTrans();
					$res = true;
				}
				echo json_encode($res);
				break;
			default:
				break;
		}
	}
}
exit();
?>