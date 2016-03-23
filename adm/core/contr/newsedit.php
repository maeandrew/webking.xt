<?php
$News = new News();
unset($parsed_res);

if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id_news = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
if(!$News->SetFieldsById($id_news, 1)){
	die('Ошибка при выборе новости.');
}

$tpl->Assign('h1', 'Редактирование новости');

if(isset($_GET['upload']) == true){
	$res = $Images->upload($_FILES, $GLOBALS['PATH_news_img'].'temp/');
	echo str_replace($GLOBALS['PATH_root'], '/', $res);
	exit(0);
}
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = News_form_validate();



	//Добавление фото
	//$id_news = $News->SetFieldsById($id);
	if(isset($_POST['images'])){
		foreach($_POST['images'] as $k=>$image){
			//$to_resize[] = $newname = $article['art'].($k == 0?'':'-'.$k).'.jpg';
			$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_news_img']), '', $image));
			$path = $GLOBALS['PATH_news_img'].$file['dirname'].'/';
			$bd_path = str_replace($GLOBALS['PATH_root'].'..', '', $GLOBALS['PATH_news_img']).trim($file['dirname']);  //print_r(); die();
			$photo_name = $bd_path.'/'.$file['basename'];
			$images_arr[] = $bd_path.'/'.$file['basename']; 
			// print_r($file['dirname']); die();
		}
	}else{
		$images_arr =  array();
	}

	if(!$err){
		if($id = $News->UpdateNews($_POST)){
			$News->UpdatePhoto($id_news, $images_arr);
			$tpl->Assign('msg', 'Новость обновлена.');
			if(isset($_POST['news_distribution']) && $_POST['news_distribution'] == 1){
				$Mailer = new Mailer();
				$Mailer->SendNewsToCustomers1($_POST);
				// $Mailer->SendNewsToCustomersInterview($_POST);
			}
			unset($_POST);
			if(!$News->SetFieldsById($id_news, 1)) die('Ошибка при выборе новости.');
		}else{
			$tpl->Assign('msg', 'Ошибка при обновлении новости.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		if(isset($_POST['date'])&&!isset($errm['date'])){
			list($d,$m,$y) = explode(".", trim($_POST['date']));
			$_POST['date'] = mktime(0, 0, 0, $m , $d, $y);
		}
		$tpl->Assign('msg', 'Новость не обновлена.');
		$tpl->Assign('errm', $errm);
	}
}
if(isset($_POST['test_distribution'])){
	$Mailer = new Mailer();
	$Mailer->SendNewsToCustomers1($_POST);
	// $Mailer->SendNewsToCustomersInterview($_POST);
}
if(!isset($_POST['smb'])){
	foreach($News->fields as $k=>$v){
		$_POST[$k] = $v;
	}
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_news_ae.tpl')
);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Новости";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/news/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Редактирование новости";
if(TRUE == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
?>