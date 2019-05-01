<?php
ini_set('memory_limit', '3072M');
echo $GLOBALS['CONFIG']['yandex_counter'];
// phpinfo();
die();
error_reporting(-1);
echo "<br/><br/><br/><br/><br/>";
// номер порта берется из конфига сфикса а не наугад
// Если вместо 127.0.0.1 написать localhost, то под линуксом PDO может приконнектиться к MySQL
// вместо сфинкса через юникс-сокет,  игнорируя указанный номер порта (MySQL использует 
// порт 3306 в отличие от сфинкса)
// Мануал: http://php.net/manual/ru/ref.pdo-mysql.connection.php#refsect1-ref.pdo-mysql.connection-notes
$sphinx = new SphinxClient();
$sphinx->SetServer("127.0.0.1", 9312);
// $sphinx->SetServer('31.131.16.159', 9312);
$sphinx->SetConnectTimeout(1);
$sphinx->SetArrayResult(true);
$sphinx->setMaxQueryTime(100);
$sphinx-> SetLimits(0,10000);
$sphinx->SetSortMode(SPH_SORT_RELEVANCE);
$sphinx->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
$sphinx->SetMatchMode(SPH_MATCH_BOOLEAN);
// Ищем слово «курс» в индексе новостей
// мануал: http://sphinxsearch.com/docs/manual-2.2.1.html#sphinxql-select
echo $GLOBALS['CONFIG']['search_index_prefix'],'<br/>';
// $GLOBALS['CONFIG']['search_index_prefix']= 'IndexKharkov';
// echo $GLOBALS['CONFIG']['search_index_prefix'],'<br/>';
// $query = '220657';
// $result = $sphinx->Query($query, 'art'.$GLOBALS['CONFIG']['search_index_prefix']);
// die("Не могу подключиться к базе.");
$wo = 'семена';
$result = $sphinx->Query($wo, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
echo count($result, 1), '<br/>';
// $wo = 'машинка';
// $result = $sphinx->Query($wo, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
// echo count($result), '<br/>';



// var_dump($result);
foreach ($result as $key => $value) {
	echo $key,"<br/>";
	// var_dump($value);
}
print_r('<pre>');
print_r($result);
print_r('</pre>');
// function search($array, $key, $value)
// {
//     $results = array();

//     if (is_array($array)) {
//         if (isset($array[$key]) && $array[$key] == $value) {
//             $results[] = $array;
//         }

//         foreach ($array as $subarray) {
//             $results = array_merge($results, search($subarray, $key, $value));
//         }
//     }

//     return $results;
// }

// $arr = array(0 => array(id=>1,name=>"cat 1"),
//              1 => array(id=>2,name=>"cat 2"),
//              2 => array(id=>3,name=>"cat 1"));

// print_r(search($arr, 'name', 'cat 1'));