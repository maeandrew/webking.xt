<?php
// phpinfo();
// die();
//*************************************************

 //        $body = array("addresses"=>array(
 //                 "addressId"=> $addressId,
 //                 "main"=> True
 //                )); 
 //  print_r('<pre>');
	// print_r($body);
	// print_r('</pre>');
	// json_encode($body);
	// echo json_encode($body);

// die();

//функци просмотра свойств и методов класа
function InfoEssence($ess) {
    //Передан объект
    if(is_object($ess)){
        $class = get_class($ess); //класс объекта
        $obj = $ess;
        $vars_obj = '<pre>' . print_r(get_object_vars($obj), true) . '</pre>';
    //Передан класс
    } else {
        $class = $ess;
        $vars_obj = null;
    }  
  
    $vars_class = '<pre>' . print_r(get_class_vars($class), true) . '</pre>';    
    $methods = '<pre>' . print_r(get_class_methods($class), true) . '</pre>';

    if ($vars_obj) echo 'Свойства объекта- экземпляра класса '.$class.':'.$vars_obj;
    echo 'Свойства класса '.$class.':'.$vars_class.
         'Методы класса '.$class.':'.$methods;
}
//***********************************************************

if ($api_ukr = new UkrPochtaApi2()) {
	echo "UkrPochtaApi2<br/>";
echo 'Добавляем адрес<br/>';
$body = array(
 "postcode"=>"61160",
 "country"=>"UA",
 "region"=>"Харківcька",
 "city"=>"Харків",
 "district"=>"Харків",
 "street"=>"просп. Ювілейний",
 "houseNumber"=>"24/88А",
 "apartmentNumber"=>"1"
);
  $rest = $api_ukr->createAddress($body);
  echo 'Адрес<br/>';
  print_r('<pre>');
	print_r($rest);
	print_r('</pre>');

echo 'Получить адрес по id<br/>';
$rest1 = $api_ukr->getAddress('1230381');
	print_r('<pre>');
	print_r($rest1);
	print_r('</pre>');

echo 'Добавляем несколько Клиентов<br/>';
$body2 = array(
	array(
 "type"=>"INDIVIDUAL",
 "firstName"=>"Нано",
 "lastName"=>"Нано2",
 "name"=>"Нано2",
 "addressId"=>"1231050",
 "externalId"=>"123111250",
 "phoneNumber"=>"0671231234"
));
print_r('<pre>');
print_r(json_encode($body2));
print_r('</pre>');    

[{"type":"INDIVIDUAL",
"firstName":"\u041d\u0430\u043d\u043e",
"lastName":"\u041d\u0430\u043d\u043e2",
"name":"\u041d\u0430\u043d\u043e2",
"addressId":"1231050",
"externalId":"123111250",
"phoneNumber":"0671231234"
}]

$rest2 = $api_ukr->createClient($body2);
		
	  print_r('<pre>');
		print_r($rest2);
		print_r('</pre>');
die();
echo 'Клиент РЕДАКТИРОВАН<br/>';
  	$rest2[0]->name = 'Иван44ов Иван';
    $rest2[0]->addressId = '1224149';
    $rest2[0]->phoneNumber= '+380505953495';
$rest3 = $api_ukr->editClient($rest2[0]);		
		print_r('<pre>');
		print_r($rest3);
		print_r('</pre>');

echo 'Адрес Клиент РЕДАКТИРОВАН<br/>';		
$addressId = 1230383;
$rest4 = $api_ukr->editAddress($rest3, $addressId);
		print_r('<pre>');
		print_r($rest4);
		print_r('</pre>');

echo 'Поиск Клиент по номеру<br/>';
$phoneNumber = '+380505953495 ';
$rest5 = $api_ukr->getСlientsPhoneNumber($phoneNumber);
		
		print_r('<pre>');
		print_r($rest5);
		print_r('</pre>');










die();


}

if ($api_np = new NovaPoshtaApi2('2a8143bd0d40555c804d71cd377c669f')) {
	echo "NovaPoshtaApi2<br/>";
	$city_np = $api_np->getCity($data['city'], $data['region']);
	echo count($city_np), '<br/>';
	// print_r('<pre>');
	// print_r($city_np);
	// print_r('</pre>');
}
if ($api_del = new DeliveryApi2($company['2a8143bd0d40555c804d71cd377c669f'])) {
	echo "DeliveryAutoApi2<br/>";
	// $city_del = $api_del->getCity($data['city'], $data['region']);
	// print_r('<pre>');
	// print_r($city_del);
	// print_r('</pre>');
}
if ($api_in = new IntimeApi2('8514564', 'b5b2aad1-ccb9-11e5-8a67-0050569f5a41')) {
	echo "IntimeApi2<br/>";
	// $city_in = $api_in->getDepartmentsList($data['city'], $data['region']);
	// print_r('<pre>');
	// print_r($city_in);
	// print_r('</pre>');
}

// phpinfo();
die();

//************************************************************
$Address = new Address();
$shiping_companies = $Address->GetShippingCompanies();
	print_r('<pre>');
	print_r($shiping_companies);
	print_r('</pre>');


// $data = ()
foreach($shiping_companies as $company){
	if($company['courier'] == 1){
		$count['courier']++;
		}
		if($company['has_api'] == 1 && $company['api_key'] != ''){
			echo "string";
			$city = $Address->UseAPI($company, 'getCity', $data);
			print_r('<pre>');
			print_r($city);
			print_r('</pre>');
			$count['warehouse'] += !empty($city)?1:0;
		}
	}

	// npgetCity($company, $data)

	

// print_r('</pre>');
// var_dump($_SESSION);
// echo $_GET['link'], '<br/>';
// echo $_REQUEST['link'], '<br/>';




//************************************************************
//коректировка бонусов агента
  //   $Parser = new Parser();
  //   $sgl = 'SELECT id_zapis, agent_profits FROM c1kharkovt_bd4.xt_osp where id_order > 177535';
		// $array = $Parser->get_db($sgl);
		// 	foreach ($array as $key => $value) {
		// 	$value_NeW = '';
		// 	foreach ($value as $key => $val) {
		// 		if ($k == 'id_zapis') {
		// 			// echo $val, '<br/>';
		// 		}else{
		// 			// echo $val, '<br/>';
		// 			$array = explode(";", $val);	
		// 			$array[3] = $array[2];
		// 			$array[7] = $array[6];
		// 			$value_NeW = implode(";", $array);
		// 			// echo $val;
		// 		}

		// 	}
		// 	echo 'UPDATE c1kharkovt_bd4.xt_osp SET agent_profits = \''.$value_NeW.'\' where id_zapis = \''.$value['id_zapis'].'\';', '<br/>';
		// }
//************************************************************


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