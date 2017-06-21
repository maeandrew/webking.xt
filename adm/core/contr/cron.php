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
		$timing = [
			'year' => $task['year'],
			'mon' => $task['mon'],
			'mday' => $task['mday'],
			'hours' => $task['hours'],
			'minutes' => $task['minutes']
		];
		$current_date = getdate();
		$run = true;
		foreach($timing as $key => $value){
			// var_dump($value);
			if(strpos($value, '-')){
				preg_match_all('/(\d+)-(\d+)/', $value, $matches);
				foreach($matches[0] as $k => $v){
					$n_string = '';
					for($i = $matches[1][$k]; $i <= $matches[2][$k]; $i++) {
						$n_string .= $i;
						if($i < $matches[2][$k]){
							$n_string .= ',';
						}
					}
					$value = str_replace($v, $n_string, $value);
				}
			}
			if(strpos($value, ',')){
				$$key = explode(',', $value);
				if(!in_array($current_date[$key], $$key)){
					$run = false;
				}
			}else{
				if($value !== '*' && (int) $value !== $current_date[$key]){
					$run = false;
				}
			}
		}
		if($run){
			include(_root.'cron'.DIRSEP.$task['alias'].'.php');
			$task['alias']();
			$Cron->RegisterLastRun($task['id']);
		}
	}
}
$tpl->Assign('tasks', $tasks);
$tpl_center .= $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cron.tpl');