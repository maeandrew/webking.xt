<?php
if(!_acl::isAllow('catalog')){
	die("Access denied");
}
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
$specification = new Specification();
$user = new Users();
$specification->Setlist();
$tpl->Assign('spec_list', $specification->list);
unset($parsed_res);
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_category = $GLOBALS['REQAR'][1];
}
//else{
//	if(isset($_GET['upload'])){
//		$img_upload = array();
//		$img_upload = array(
//			'download_via_php' => true,
//			'upload_dir' => $_SERVER['DOCUMENT_ROOT'].'/images/category_banner/',
//			'upload_url' => $_SERVER['DOCUMENT_ROOT'].'/images/category_banner/',
//			'user_dirs' => false,
//			'param_name' => 'img',
//			'accept_file_types' => '/\.(gif|jpe?g|jpg|png)$/i'
//		);
//		if(isset($_GET['category_img_urls'])){
//			$arr = $dbtree->Full(array('translit'), array('and' => array('id_category = '.$_POST['id_category'])));
//			$img_name = $arr[0]['translit'];
//			$_FILES['img']['name'] = $img_name;
//			$img_upload['upload_dir'] = $_SERVER['DOCUMENT_ROOT'].'/efiles/katalog/';
//			$img_upload['upload_url'] = $_SERVER['DOCUMENT_ROOT'].'/efiles/katalog/';
//			$img_upload['max_file_size'] = '102400';
//		}
//		$upload_handler = new UploadHandler($img_upload);
//	}else{
//		header('Location: '.$GLOBALS['URL_base'].'404/');
//	}
//	exit();
//}
$specification->SetListByCatId($id_category);
$tpl->Assign('cat_spec_list', $specification->list);
if(isset($_GET['action']) && $_GET['action'] == "delete_spec"){
	$dbtree->UpdateEditUserDate($id_category);
	$specification->DelSpecFromCat($_GET['id_spec_cat']);
	header('Location: '.$GLOBALS['URL_base'].'adm/catedit/'.$id_category);
}
$category = $dbtree->Full(array('id_category', 'category_level', 'name', 'edit_user', 'edit_date', 'translit', 'pid', 'visible', 'prom_id', 'indexation'),$id_category );
$tpl->Assign('h1', 'Редактирование категории');
$dbtree->Parents($id_category, array('id_category', 'name', 'category_level'));
if(!empty($dbtree->ERRORS_MES)) {
    print_r($dbtree->ERRORS_MES);die();
}
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
while($cat = $dbtree->NextRow()){
	if(0 <> $cat['category_level']){
		$GLOBALS['IERA_LINKS'][$ii]['title'] = $cat['name'];
		$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/items/'.$cat['id_category'];
	}
}
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование категории";
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Cat_form_validate();
	if(!$err){
		$arr['name'] = trim($_POST['name']);
		$arr['prom_id'] = trim(is_numeric($_POST['prom_id'])?$_POST['prom_id']:null);
		//$arr['translit'] = G::StrToTrans($_POST['name']);
		$arr['pid'] = trim($_POST['pid']);
		//$arr['old_pid'] = $category[0]['pid'];
		$arr['visible'] = 1;
		if(isset($_POST['visible']) && $_POST['visible'] == "on"){
			$arr['visible'] = 0;
		}
		$arr['indexation'] = 0;
		if(isset($_POST['indexation']) && $_POST['indexation'] == "on"){
			$arr['indexation'] = 1;
		}
		if($dbtree->Update($id_category, $arr)){
			$tpl->Assign('msg', 'Категория обновлена.');
			unset($_POST);
			$category = $dbtree->Full(array('id_category', 'category_level', 'name', 'edit_user', 'edit_date', 'translit', 'pid', 'visible', 'prom_id', 'indexation'), $id_category);

		}else{
			$tpl->Assign('msg', 'Ошибка. Категория не обновлена.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Ошибка! Категория не обновлена.');
		$tpl->Assign('errm', $errm);
	}
}
$user->SetFieldsById($category[0]['edit_user']);
$category[0]['username'] = $user->fields['name'];
$list = $dbtree->Full(array('id_category', 'category_level', 'name', 'prom_id'));
$tpl->Assign('list', $list);
if(!isset($_POST['smb'])){
	foreach($category as $v){
		$_POST = $v;
	}
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cat_ae.tpl')
);
if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}?>