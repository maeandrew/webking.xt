<?php
// Отрезаем завершающий слеш `/`
$_SERVER['REQUEST_URI'] = preg_replace('#/$#is', '', $_SERVER['REQUEST_URI']);
preg_match_all('#/([^/]+)#is', $_SERVER['REQUEST_URI'], $ma);
/* Далее, если REQUEST_URI пуст - устанавливается контроллер по-умолчанию
 * если контроллер не найден среди файлов, то устанавливается контроллер 404 ошибки
 */
if(empty($ma[1])){
	$ma[1][0] = $GLOBALS['DefaultController'];
}elseif (!in_array($ma[1][0], $GLOBALS['Controllers'])){
	array_unshift($ma[1], '404');
}
$GLOBALS['CurrentController'] = $ma[1][0];
$GLOBALS['REQAR'] = $ma[1];
/**
 * Для удобства некоторые переменные из REQUEST_URI объявляются в массиве $_GET
 */
foreach($ma[1] as $item){
	if(preg_match('#^p([\d]+)$#is', $item, $ma1)){
		$_GET['page_id'] = $ma1[1];
	}
	if(preg_match('#^limit([\d]+)$#is', $item, $ma1)){
		$_GET['limit'] = $ma1[1];
	}
	if(preg_match('#^limitall$#is', $item, $ma1)){
		$_GET['limit'] = 'all';
	}
}
unset($ma);unset($ma1);
// if($GLOBALS['CurrentController'] == 'srv'){
// 	require($GLOBALS['PATH_core'].'controller.php');
// 	exit(0);
// }
?>