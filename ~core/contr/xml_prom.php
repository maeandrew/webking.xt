<?php
$xml = new SimpleXMLElement('<xml/>');
$Products = new Products();
ini_set('memory_limit', '1024M');	
ini_set('max_execution_time', 3000);
$cat_arr = $dbtree->GetAllCats(array('id_category', 'category_level', 'name', 'translit', 'prom_id', 'pid', 'visible'), 1);
if(!empty($cat_arr)){
	foreach($cat_arr as $ct){
		$track = $xml->addChild('track');
    		$track->addChild('path', $ct['id_category']);
			$track->addChild('title', $ct['name']);
	}
}
ini_set('memory_limit', '192M');
ini_set('max_execution_time', 30);
Header('Content-type: text/xml');
echo $xml->asXML();