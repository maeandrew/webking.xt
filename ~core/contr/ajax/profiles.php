<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'getAdditionalFields':
				$tpl->Assign('id_profile', $_POST['id_profile']);
				switch($_POST['id_profile']){
					case _ACL_SUPPLIER_:
						$className = 'Suppliers';
						break;
					case _ACL_CONTRAGENT_:
						$className = 'Contragents';
						break;
					case _ACL_CUSTOMER_:
						$className = 'Customers';
						break;
					case _ACL_ADMIN_:
						$className = 'Customers';
						break;
					default:
						$className = 'Users';
						break;
				}
				if(isset($_POST['id_user'])){
					$$className = new $className();
					if($data = $$className->Read($_POST['id_user'])){
						foreach($data as $key => $value){
							if(!in_array($key, array('passwd'))){
								$_POST[$key] = $value;
							}
						}
					}
				}
				$Contragents = new Contragents();
				$Contragents->SetList();
				$tpl->Assign('managers_list', $Contragents->list);
				echo file_exists($GLOBALS['PATH_adm_tpl_global'].'profiles_additional_fields_'.$_POST['id_profile'].'.tpl')?$tpl->Parse($GLOBALS['PATH_adm_tpl_global'].'profiles_additional_fields_'.$_POST['id_profile'].'.tpl'):'<div class="col-md-12">Нет</div>';
				break;
			default:
				break;
		}
	}
}
exit();