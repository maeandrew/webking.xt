<?php
if(!_acl::isAllow('cron')){
	die("Access denied");
}
$Cron = new Cron();
unset($parsed_res);
$header = 'Добавление задачи CRON';
$tpl->Assign('h1', $header);
$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = 'Задачи CRON';
$GLOBALS['IERA_LINKS'][$ii++]['url'] = '/adm/cron/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = $header;
if(isset($_POST['smb'])){
	if(!$Cron->CheckAliasUniqueness($_POST['alias'])){
		$err = 1;
		$errm['alias'] = 'Введенный алиас не уникален.';
	}
	if(!$err){
		if($id = $Cron->Add($_POST)){
			$file = $_POST['alias'].".php";
			if(!file_exists($file)){
				$fp = fopen(_root.'cron'.DIRSEP.$file, "w"); // ("r" - считывать "w" - создавать "a" - добовлять к тексту),мы создаем файл
				fwrite($fp, $_POST['post_editor']);
				fclose($fp);
			}
			$tpl->Assign('msg', 'Задача создана.');
			unset($_POST);
		}else{
			$tpl->Assign('msg', 'Задача не создана.');
		}
	}else{
		$tpl->Assign('msg', 'Задача не создана.');
		$tpl->Assign('errm', $errm);
	}
}
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cron_ae.tpl');
