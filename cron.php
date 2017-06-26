<?php
session_start();
date_default_timezone_set('Europe/Kiev');
define('EXECUTE', 1);
define('CMD', true);
define('DIRSEP', DIRECTORY_SEPARATOR);
require(dirname(__FILE__).DIRSEP.'~core'.DIRSEP.'sys'.DIRSEP.'global_c.php');
require(dirname(__FILE__).DIRSEP.'~core'.DIRSEP.'cfg.php');
G::Start();
$Cron = new Cron();
$Cron->SetList();
$tasks = $Cron->list;
if(!empty($tasks)){
	foreach($tasks as $task){
		if($task['active'] == 0){
			break;
		}
		$Cron->CheckTiming($task);
	}
}
session_write_close();
