<?php
if(!_acl::isAllow('news')){
	die("Access denied");
}
$News = new News();
unset($parsed_res);
$tpl->Assign('h1', 'Добавление новости');
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Новости";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/news/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление новости";
$Images = new Images();
if(isset($_GET['upload']) == true){
	$res = $Images->upload($_FILES, $GLOBALS['PATH_news_img'].'temp/');
	echo str_replace($GLOBALS['PATH_root'], '/', $res);
	exit(0);
}

if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = News_form_validate();

	//Добавление фото
	$id_news = $News->SetFieldsById($id);
	if(isset($_POST['images'])){
		foreach($_POST['images'] as $k=>$image){
			//$to_resize[] = $newname = $article['art'].($k == 0?'':'-'.$k).'.jpg';
			$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_root'], '', $GLOBALS['PATH_news_img']), '', $image));
			$path = $GLOBALS['PATH_news_img'].$file['dirname'].'/';
			$bd_path = str_replace($GLOBALS['PATH_root'].'..', '', $GLOBALS['PATH_news_img']).trim($file['dirname']);
			$photo_name = $bd_path.'/'.$file['basename'];
			$images_arr[] = $bd_path.'/'.$file['basename'];
		}
	}else{
		$images_arr =  array();
	}

	//$Images->resize(false, $to_resize);

//print_r($err); die();

	if(!$err){
		if($id = $News->AddNews($_POST)){
			$News->UpdatePhoto($id, $images_arr);
			$tpl->Assign('msg', 'Новость добавлена.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Новость не добавлена.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		if(isset($_POST['date'])&&!isset($errm['date'])){
			list($d,$m,$y) = explode(".", trim($_POST['date']));
			$_POST['date'] = mktime(0, 0, 0, $m , $d, $y);
		}
		$tpl->Assign('msg', 'Новость не добавлена.');
		$tpl->Assign('errm', $errm);
	}
}
if(!isset($_POST['smb'])){
	$_POST['id_news'] = 0;
}
$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_news_ae.tpl')
);
if($parsed_res['issuccess'] == true){
	$tpl_center .= $parsed_res['html'];
}
?>