<?php
if(!_acl::isAllow('cron')){
	die("Access denied");
}
$Cron = new Cron();
if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
	$id = $GLOBALS['REQAR'][1];
}else{
	header('Location: '.$GLOBALS['URL_base'].'404/');
	exit();
}
$header = 'Редактирование задачи CRON';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Задачи CRON';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/cron/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;

if(!$Cron->SetFieldsById($id)){
	$tpl->Assign('errm', 1);
	$tpl->Assign('msg', 'Ошибка при выборе задачи. ID '.$id.' не существует.');
	$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl');
}else{
	if(isset($_POST['smb'])){
		if($_POST['alias'] !== $Cron->fields['alias']){
			if(!$Cron->CheckAliasUniqueness($_POST['alias'])){
				$err = 1;
				$errm['alias'] = 'Введенный алиас не уникален.';
			}else{
				unlink(_root.'cron'.DIRSEP.$Cron->fields['alias'].'.php');
			}
		}
		if(!$err){
			if($Cron->Update($_POST)){
				$file = $_POST['alias'].'.php';
				if(!file_exists($file)){
					$fp = fopen(_root.'cron'.DIRSEP.$file, "w"); // ("r" - считывать "w" - создавать "a" - добовлять к тексту),мы создаем файл
					fwrite($fp, $_POST['post_editor']);
					fclose($fp);
				}
				$tpl->Assign('msg', 'Задача обновлена.');
				unset($_POST);
				$Cron->SetFieldsById($id);
			}else{
				$tpl->Assign('errm', 1);
				$tpl->Assign('msg', 'Задача не обновлена.');
			}
		}else{
			$tpl->Assign('errm', 1);
			$tpl->Assign('msg', 'Задача не обновлена.');
			$tpl->Assign('errm', $errm);
		}
	}
	if(!isset($_POST['smb'])){
		if(file_exists(_root.'cron'.DIRSEP.$Cron->fields['alias'].'.php')){
			$_POST['post_editor'] = file_get_contents(_root.'cron'.DIRSEP.$Cron->fields['alias'].'.php');
		}
		foreach($Cron->fields as $k=>$v){
			$_POST[$k] = $v;
		}
	}
	$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cron_ae.tpl');
}
