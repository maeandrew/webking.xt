<?php
if(!_acl::isAllow('news')){
	die("Access denied");
}
$News = new News();
unset($parsed_res);
$header = 'Добавление новости';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Новости";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/news/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
$Images = new Images();
if(isset($_GET['upload']) == true){
	$res = $Images->upload($_FILES, $GLOBALS['PATH_news_img'].'temp/');
	echo str_replace($GLOBALS['PATH_global_root'], '', $res);
	exit(0);
}
if(isset($_POST['smb'])){
	require_once ($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = News_form_validate();
	if(!$err){
		if($id = $News->AddNews($_POST)){
			//Добавление фото
			if(isset($_POST['images'])){
				foreach($_POST['images'] as &$image){
					if(preg_match('/[А-Яа-яЁё]/u', $image)){
						$file = pathinfo($GLOBALS['PATH_global_root'].$image);
						$new_file = $file['dirname'].'/'.G::StrToTrans($file['filename']).'.'.$file['extension'];
						rename($GLOBALS['PATH_global_root'].$image, $new_file);
						$image = str_replace($GLOBALS['PATH_global_root'], '', $new_file);
					}
				}
			}
			$News->UpdatePhoto($id, $_POST['images']);
			$_POST['id_news'] = $id;
			$News->UpdateNews($_POST);
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