<?php
if(!_acl::isAllow('cron'))
	die("Access denied");
$tpl->Assign('h1', 'Задачи CRON');
$Cron = new Cron();
$Cron->SetList();
$tasks = $Cron->list;
if($_GET['run']){
	foreach($tasks as $task){
		if($task['active'] == 0){
			break;
		}
		$Cron->CheckTiming($task);
	}
}
$tpl->Assign('tasks', $tasks);
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cron.tpl');