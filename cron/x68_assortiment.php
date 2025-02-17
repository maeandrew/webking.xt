<?php
	// error_reporting(-1);
	$Parser = new Parser();
	$Specification = new Specification();
	$Suppliers = new Suppliers();
	$Images = new Images();
	$Products = new Products();
	$id_supplier = 30939;

	//Устанавливаем настройки памяти
	echo "memory_limit ", ini_get('memory_limit'), "<br />";
	ini_set('memory_limit', '3072M');	
	echo "memory_limit ", ini_get('memory_limit'), "<br />";

	//Устанавливаем настройки времени
	echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
	ini_set('max_execution_time', 6000);
	// set_time_limit(6000);
	echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

	// echo "post_max_size ", ini_get('post_max_size'), "<br />";
	// echo "set_time_limit ", ini_get('set_time_limit'), "<br />";
	// ob_end_flush();
	// ob_end_clean();
	// ob_implicit_flush();


	ini_set('display_errors','on');
	ini_set('error_reporting',E_ALL);
	echo "СТАРТ загружаем файл <br/>";

	//загружаем файл
	// $url='https://www.nl.ua/export_files/Kharkov.xml'; 
	// if(!copy($url, $GLOBALS['PATH_post_img'].'NL.xml')){
	// 	echo "не удалось скопировать ...\n";
	// }else{
	// 	echo "Файл скопирован ...\n";
	// }

	//Открываем файл
	$html = $GLOBALS['PATH_post_img'].'NL.xml';
	if (!$sim_url = simplexml_load_file($html)){
		echo "Не удалось открыть файл<br />\n";
		die();
	}
	echo "Файл обработан simplexml_load_file  <br/>";
	// выбераем имеющиеся у нас артикул
	$supcomments = $Products->GetSupComments($id_supplier);
	if(is_array($supcomments)){
		$supcomments = array_unique($supcomments);
	}
	if(!$supcomments){
		echo "Массив загруженых товаров поставщика пуст<br />";
		continue;
	}
	echo 'У поставщика в кабегнете товаров ', count($supcomments), "<br />","<br />";
	//создаем масивы соотметствия категорий
	$array_cat = array(5819=>675,5834=>675,5840=>1067,5977=>1009,5995=>1790,5997=>1790,5999=>1006,6001=>1790,6002=>1790,6004=>1790,6005=>1790,6007=>1790,6009=>1790,6011=>1790,6013=>1790,6014=>1790,6015=>1790,6016=>1006,6017=>1790,6018=>1790,6020=>1006,6021=>1192,6022=>1405,6023=>1006,6024=>1006,6028=>632,6032=>948,6033=>945,6034=>1343,6036=>1697,6039=>1737,6040=>1439,6041=>951,6042=>1749,6044=>921,6045=>957,6047=>1411,6048=>949,6050=>1457,6051=>1458,6052=>1323,6053=>920,6054=>1714,6055=>1419,6056=>940,6057=>1749,6058=>922,6059=>1697,6060=>939,6061=>950,6062=>1011,6063=>1749,6064=>935,6066=>1465,6067=>1012,6068=>1199,6069=>1697,6070=>941,6071=>1463,6072=>632,6073=>923,6075=>940,6076=>939,6078=>1564,6080=>1442,6081=>1697,6082=>1434,6083=>937,6084=>635,6085=>1210,6086=>931,6088=>934,6089=>1395,6090=>1211,6091=>1438,6092=>938,6093=>1419,6094=>635,6095=>1419,6096=>1419,6097=>635,6098=>1677,6099=>1439,6100=>1438,6101=>1419,6102=>946,6103=>679,6104=>953,6105=>1445,6106=>940,6107=>1445,6108=>635,6109=>1463,6110=>1419,6111=>924,6112=>1411,6113=>918,6114=>635,6115=>1410,6116=>632,6117=>933,6118=>1419,6119=>930,6120=>1205,6121=>632,6122=>831,6123=>1749,6124=>1564,6125=>940,6126=>632,6127=>1403,6128=>1395,6130=>1463,6131=>1697,6132=>1460,6133=>941,6134=>1435,6135=>946,6136=>946,6137=>1697,6138=>1178,6139=>1012,6140=>1419,6143=>941,6144=>1697,6145=>1448,6146=>1419,6147=>1436,6148=>1564,6149=>1697,6150=>1456,6151=>1697,6152=>940,6153=>946,6154=>1697,6155=>1175,6156=>945,6157=>1459,6158=>952,6159=>1697,6160=>1474,6161=>954,6162=>946,6163=>781,6164=>935,6165=>679,6166=>940,6167=>1697,6168=>1697,6169=>1418,6170=>946,6171=>935,6172=>677,6173=>1412,6174=>1419,6175=>915,6176=>634,6177=>677,6178=>950,6179=>1564,6180=>632,6181=>940,6182=>940,6183=>743,6184=>1347,6185=>940,6186=>928,6187=>1474,6189=>941,6190=>1465,6191=>1221,6192=>1447,6193=>1697,6194=>1440,6195=>1474,6196=>1697,6197=>1448,6198=>1463,6199=>1419,6200=>1697,6201=>940,6202=>1419,6203=>947,6204=>1389,6206=>601,6207=>978,6209=>1419,6213=>944,6217=>961,6220=>944,6224=>903,6231=>961,6234=>901,6235=>900,6236=>1796,6237=>903,6238=>902,6240=>1794,6243=>634,6244=>1795,6245=>1797,6246=>1797,6247=>1794,6248=>908,6249=>910,6251=>961,6254=>1503,6256=>909,6260=>1382,6262=>1794,6263=>1794,6265=>957,6267=>639,6268=>1796,6269=>1796,6270=>1796,6271=>1796,6272=>1796,6273=>1796,6274=>944,6275=>944,6276=>944,6285=>961,6286=>961,6290=>1382,6293=>634,6294=>568,6295=>903,6296=>955,6297=>1004,6298=>953,6303=>1786,6305=>919,6307=>1006,6309=>1787,6311=>917,6312=>917,6313=>917,6315=>912,6316=>912,6317=>914,6318=>1787,6319=>912,6321=>918,6322=>912,6323=>1340,6324=>1344,6325=>912,6326=>917,6327=>917,6328=>1726,6329=>912,6330=>1344,6331=>1787,6332=>1787,6334=>964,6335=>912,6336=>912,6337=>914,6338=>964,6339=>1726,6340=>912,6341=>796,6342=>1787,6343=>912,6344=>915,6345=>917,6346=>1726,6347=>1726,6348=>919,6349=>1344,6351=>1726,6352=>1344,6354=>1785,6355=>917,6357=>912,6358=>1785,6360=>1785,6361=>1344,6362=>1785,6363=>1344,6364=>1787,6365=>1787,6366=>917,6368=>1786,6369=>1786,6370=>1786,6371=>1785,6372=>1726,6373=>1344,6374=>912,6375=>1787,6376=>917,6378=>1113,6379=>1113,6380=>912,6386=>1209,6388=>896,6389=>1684,6390=>1201,6391=>1208,6392=>1204,6393=>1325,6395=>1557,6396=>1199,6398=>1666,6399=>1205,6401=>1629,6403=>1325,6405=>1217,6407=>1591,6408=>1201,6409=>1200,6410=>1623,6411=>1325,6412=>1578,6414=>1198,6415=>1624,6417=>1325,6418=>1622,6420=>1532,6421=>1211,6422=>1602,6425=>1197,6426=>1325,6427=>1616,6429=>1581,6430=>1611,6431=>1618,6432=>1572,6433=>1566,6434=>1325,6435=>1202,6436=>1599,6438=>1201,6439=>1203,6442=>1593,6443=>1707,6444=>1575,6445=>1207,6446=>1204,6450=>1654,6451=>1593,6452=>1620,6453=>1626,6455=>1623,6456=>1063,6457=>1214,6460=>1568,6463=>1619,6465=>1565,6469=>1209,6473=>1201,6474=>1641,6478=>1648,6480=>1692,6482=>1325,6483=>1192,6484=>1325,6485=>1196,6486=>1325,6495=>1594,6499=>772,6500=>1647,6501=>1559,6502=>1682,6506=>990,6507=>1006,6509=>1476,6510=>1783,6511=>980,6512=>1782,6513=>980,6514=>967,6515=>1476,6517=>1782,6518=>1385,6519=>1422,6520=>970,6521=>1422,6522=>1782,6523=>1476,6524=>1782,6525=>1782,6526=>1476,6527=>975,6528=>975,6529=>975,6530=>975,6531=>1215,6532=>1112,6536=>997,6538=>1000,6540=>998,6541=>997,6542=>998,6543=>997,6544=>1000,6546=>1001,6547=>997,6550=>995,6552=>995,6553=>1000,6554=>1193,6555=>995,6556=>1075,6557=>1075,6558=>1003,6561=>995,6562=>1403,6563=>998,6564=>998,6565=>1598,6566=>1001,6567=>995,6571=>994,6572=>995,6574=>995,6575=>1075,6581=>1192,6582=>998,6583=>1000,6584=>999,6586=>995,6588=>999,6589=>1192,6590=>1194,6592=>997,6593=>1383,6594=>1192,6595=>997,6596=>1553,6599=>997,6600=>1001,6601=>1001,6602=>1193,6604=>1001,6606=>1001,6607=>1749,6611=>1784,6612=>1784,6614=>1071,6616=>1082,6617=>1071,6618=>1172,6619=>1784,6620=>1076,6625=>1075,6627=>1070,6630=>1070,6631=>1784,6632=>1662,6633=>1784,6635=>1074,6636=>1662,6637=>1076,6638=>1784,6640=>1784,6641=>1784,6642=>1784,6644=>1130,6645=>728,6646=>1076,6647=>967,6648=>1212,6649=>970,6651=>1073,6652=>1073,6653=>1142,6654=>1662,6656=>1070,6657=>1070,6658=>1076,6659=>1076,6666=>1081,6670=>1793,6672=>1287,6674=>1171,6676=>1791,6677=>1178,6678=>1425,6679=>1793,6680=>640,6682=>1792,6683=>629,6684=>1472,6685=>1426,6686=>1793,6687=>1171,6688=>1792,6689=>1428,6690=>1179,6691=>1184,6692=>1792,6694=>1187,6695=>1186,6696=>1185,6701=>1088,6704=>1227,6706=>1139,6708=>1141,6712=>1057,6713=>1088,6715=>759,6720=>1057,6722=>1088,6723=>1712,6726=>816,6727=>1446,6730=>1102,6731=>1137,6732=>1125,6733=>1089,6734=>1057,6737=>1133,6738=>1125,6740=>1066,6742=>1138,6743=>1550,6744=>1057,6746=>1005,6749=>1057,6750=>1709,6752=>1095,6753=>1139,6754=>1008,6755=>1125,6756=>1098,6757=>1646,6758=>1057,6759=>1057,6760=>1131,6761=>1111,6762=>1230,6763=>1305,6764=>1105,6765=>1120,6769=>1426,6771=>1381,6772=>771,6774=>1415,6775=>1415,6776=>1415,6777=>1415,6778=>1415,6779=>1415,6783=>1246,6784=>1555,6785=>1555,6786=>1555,6787=>1732,6788=>1243,6789=>1245,6790=>1555,6791=>1555,6793=>1244,6794=>1241,6795=>1243,6797=>1101,6800=>1288,6805=>1058,6806=>1057,6807=>1054,6808=>1055,6809=>722,6810=>1053,6811=>1057,6812=>1057,6813=>1057,6814=>891,6815=>1429,6816=>679,6817=>1429,6828=>1133,6829=>873,6830=>1135,6831=>1134,6832=>1007,6833=>1135,6834=>1125,6835=>1125,6840=>990,6842=>987,6843=>987,6844=>987,6845=>991,6846=>987,6848=>987,6849=>990,6850=>990,6851=>987,6852=>990,6853=>990,6854=>987,6855=>987,6856=>987,6857=>990,6858=>987,6859=>991,6860=>987,6861=>987,6862=>990,6863=>987,6864=>1104,6865=>989,6866=>991,6867=>987,6868=>991,6869=>987,6870=>987,6872=>990,6873=>990,6874=>987,6875=>987,6876=>990,7990=>1788,7992=>1009,7996=>1789,7997=>1788,8001=>1789,8002=>1789,8007=>1788,8017=>1789,8019=>1789,8021=>1788,8022=>1788,8023=>1789,8027=>1789,8028=>1788,8029=>1789,8030=>1788,8031=>1788,8032=>1009,8034=>1788,8035=>1789,8044=>1789,8045=>1789,8056=>1789,8060=>1789,8062=>1789,8063=>1789,8069=>1789,8070=>1789,8074=>1789,8075=>1788,8076=>1788,8083=>1788,8088=>1788,8089=>1788,8102=>1788,8103=>1788,8107=>1789,8111=>1788,8112=>1788,8113=>1788,8114=>1788,8130=>1788,8134=>1788,8135=>1788,8145=>1788,8147=>1788,8148=>1788,8161=>1788,8163=>1788,8179=>1788,8183=>1788,8191=>1788,8193=>1788,8203=>1789,8205=>1789,8206=>1789,8210=>1789,8212=>1789,8215=>1009,8216=>1009,8218=>1009,8219=>1009,8220=>1009,9166=>1790,9178=>1006,9192=>990,9197=>988,9330=>1195,9589=>1403,10043=>1796,10048=>679,10049=>1192,10098=>903,10302=>679,10338=>1182,10350=>1190,10352=>1189,10357=>1792,10358=>1171,10359=>1325,10360=>1792,10362=>1793,10367=>1427,10368=>1183,10370=>1179,10371=>1792,10372=>638,10373=>638,10375=>1180,10376=>1183,10378=>1186,10379=>1186,10380=>1792,10384=>1426,10388=>1426,10395=>1784,10411=>1103,10416=>1075,10427=>1426,10431=>961,10432=>633,10596=>925,10597=>1205,10608=>1485,10670=>1676,11024=>1782,11592=>679,11601=>679,11602=>679,11617=>1216,11618=>679,11619=>1565,11652=>1568,11660=>679,11664=>679,11665=>1593,11666=>679,11749=>679,11755=>1009,11815=>1786,11816=>1456,11817=>1697,11818=>995,11819=>988,12164=>941,12166=>634,12167=>1677,12171=>1114,12187=>1082,12194=>1662,12228=>1075,12271=>1761,12397=>1415,12398=>1230,12399=>1125,12400=>1429,12480=>1788,12481=>1788,12498=>1789,12520=>1789,12534=>1789,12539=>1788,12712=>1788,12714=>1788,12718=>1789,12987=>1788,12990=>1788,13063=>997,13659=>1789,13666=>1788,13671=>1788,13672=>1788,13680=>1789,13682=>1789,13683=>1788,13692=>1788,13694=>1788,13697=>1788,13699=>1788,13704=>1788,13707=>1789,13710=>1788,13712=>1003,13713=>1003,13723=>1125,13730=>1788,13733=>1788,13735=>1788,13738=>1789,13749=>1481,13750=>1785,13752=>1788,13756=>917,13758=>1426,13762=>1789,13765=>1009,13768=>629,13770=>1788,13772=>1789,13773=>1789,13778=>1788,13780=>1788,13784=>1788,13786=>1788,13788=>1788,13793=>1788,13796=>1344,13799=>1114,13800=>1171,13803=>952,13805=>1736,13806=>1023,13809=>1789,13813=>1697,13816=>1789,13821=>945,13823=>917,13825=>1697,13827=>1697,13829=>1004,13830=>1697,13832=>1697,13835=>1108,13845=>990,13847=>1357,13849=>1381,13855=>1788,13857=>1788,13858=>1788,13863=>1788,13865=>1788,13866=>1788,13869=>1789,13872=>1788,13874=>1789,13876=>1788,13878=>1788,13880=>1789,13891=>1789,13892=>1789,13896=>1789,13898=>1789,13900=>1789,13902=>1789,13904=>1788,13913=>1789,13914=>1789,13923=>1788,13924=>1789,13927=>1073,13928=>1789,13930=>1789,13932=>1789,13934=>1788,13936=>1789,13939=>1787,13941=>978,13956=>1081,13958=>1789,13960=>1789,13964=>970,13965=>1788,13968=>1077,13969=>970,13971=>1788,13974=>970,13977=>1789,13979=>1788,13985=>1789,13989=>1788,13991=>1788,13995=>1789,14002=>1068,14008=>1313,14010=>1131,14015=>1788,14017=>1789,14019=>1788,14023=>1788,14027=>1788,14029=>1788,14037=>1789,14041=>1789,14070=>1380,14071=>1380,14072=>1380,14073=>1380,14074=>1380,14075=>1380,14077=>1380,14078=>560,14079=>1380,14080=>1380,14081=>1380,14082=>1380,14084=>1380,14085=>1380,14086=>1380,14087=>1380,14089=>1380,14090=>1380,14091=>679,14094=>679,14096=>1380,14097=>1788,14099=>1788,14101=>1789,14104=>607,14105=>1789,14113=>1789,14115=>1325,14118=>1111,14126=>603,14127=>1788,14132=>1325,14134=>1112,14136=>1253,14137=>1057,14140=>1074,14142=>832,14144=>1446,14145=>1789,14151=>1789,14153=>1789,14155=>1789,14157=>1788,14161=>1788,14163=>1788,14165=>1789,14167=>1789,14169=>1789,14171=>1472,14172=>1716,14173=>1713,14174=>1714,14175=>1714,14176=>1714,14177=>1714,14178=>1713,14179=>1714,14180=>1713,14181=>1714,14182=>1714,14183=>1713,14184=>1713,14185=>1714,14186=>1713,14187=>1789,14189=>1788,14191=>1789,14193=>891,14194=>1789,14200=>1789,14202=>1788,14204=>1789,14209=>1788,14210=>1789,14212=>1788,14215=>1788,14217=>1789,14219=>1789,14221=>1789,14223=>1788,14225=>1788,14227=>1788,14229=>1788,14233=>1788,14235=>1788,14237=>1789,14241=>1788,14243=>1789,14249=>1788,14252=>1054,14255=>1054,14258=>1788,14260=>1788,14262=>1789,14264=>1789,14268=>1788,14270=>1489,14272=>1788,14275=>1081,14290=>1788,14292=>1788,14294=>1788,14310=>1788,14320=>1789,14322=>1788,14332=>1789,14338=>1789,14346=>1789,14348=>1788,14356=>1070,14364=>1076,14366=>1074,14369=>1125,14371=>1125,14373=>1125,14374=>1782,14377=>1125,14378=>1788,14380=>1788,14382=>1788,14384=>1789,14386=>1788,14390=>1788,14396=>1788,14398=>1788,14400=>1788,14402=>1789,14415=>1788,14419=>1789);
		//можем просмотреть
		// foreach ($array_cat as $key => $value) {
		// 	echo $key, " =>  ", $value, ",";
		//  }
		// die();
	//vendorCode c ошибками
	$error_vendorCode = array(90511154,90601164,90601155,31035202,31034348,31043393,31035285,31034456,31034457,31034783,31010710,31030315,31034727,31035744,31030241,31034960,31035656,31035657,31033112,31033141,31034408,31033163,31010917,31009331,31009182,31009610,31009956,31009747,31009719,31253016,31012419,31012859,31005556,31012547,31012920,31047006,70837168,30110072,30101867,30138035,31021463,31021885,31044046,31044047,31003432,31227591,31227595,31227597,31241252,31227594,31227745,31227746,31246183,31222310,40617387,80335841,10843549,10922639,10920157,10927034,10906804,10922620,10924541,10922687,10922685,10924557,10901515,10704282,10704284,10704288,10704286,10704280,10704277,10704279,10704293,51333094,51333205,51333044,51333092,51333095,51333206,51333118,51333119,51333120,80132359,80213729,60306687,60306688,60306689,60611545,60611548,60611549,60611550,60611551,60611555,60611556,60611558,60611559,60611560,60611562,60611563,60611564,60611565,60611569,80128191,0128153,60802989,60809689,60814219,60814626,10316609,20535278);
	//обеденяем позииции которые не нужно добавлять
	$supcomments_error = array_merge($supcomments, $error_vendorCode);
	
	//авто обновление
	
	$all = $ldi = 0; //количество товаров в файле
	$array_add = array(); //количество товаров на добавление
	$sql_arrey = array(); //количество товаров обновляется
	//проставляем метку обновления no_xtorg = 0
	$sql = "UPDATE xt_assortiment SET no_xtorg = 0 WHERE id_supplier = 30939";
	$sql_arrey[] = $sql;
	foreach ($sim_url->xpath('/yml_catalog/shop') as $element) {
		foreach ($element->xpath('offers/offer') as $offer) {
			if (in_array($offer->vendorCode, $supcomments)) {
				// $ldi++;
				// if($ldi> 1000){
				// 	echo "СТОП по КОЛИЧЕСТВУ <br/>";
				// 	break 2;
				// }
				$id_product = $Products->GetIdBysup_comment($id_supplier, $offer->vendorCode);
				$sql = "UPDATE "._DB_PREFIX_."assortiment SET  product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = ". $offer->price*0.93. ", price_mopt_otpusk = ". $offer->price*0.93. " WHERE id_supplier = 30939 and id_product = ".$id_product;
				array_push($sql_arrey, $sql);
				echo $offer->vendorCode, " обновляем <br/>";
			}else{
				if(array_key_exists(strval($offer->categoryId), $array_cat) && !in_array($offer->vendorCode, $supcomments_error)){
					array_push($array_add, $offer);
					echo $offer->categoryId, ' - ',$offer->vendorCode, " на добавление <br/>";
				}else{
					echo $offer->vendorCode, " пропускаем <br/>";
				}	
			}
			$all++;
		}
	}
	//выключаем не обновленые позиции
	$sql = "UPDATE xt_assortiment SET product_limit = 0, active = 0 WHERE id_supplier = 30939 and no_xtorg = 0";
	$sql_arrey[] = $sql;
	
	//посмотрим масив sql запросов
	echo "Количество товаров в файле ", $all, "<br />";
	echo "Количество товаров на добавление ", count($array_add), "<br />";
	echo 'в масиве $sql_arrey ', count($sql_arrey), '<br/>';
	foreach ($sql_arrey as $key => $value) {
		echo $key, " ", $value, '<br/>';
	}	
	//обновляем
	// if($Products->ProcessAssortimentXML($sql_arrey)){
	// echo "ГОТОВО <br />";
	// }
	//возвращаем настройки памяти
	ini_set('memory_limit', '128M');	
	echo "memory_limit ", ini_get('memory_limit'), "<br />";
	//возвращаем настройки времени
	ini_set('max_execution_time', 300);
	echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
	

			// echo "ОК можно парсить <br/>";	
			// foreach ($array_add as $offer) {
			// 	echo "CТАРТ ---------------------------------------------------------------------------------------------------------";
			// 		// ob_end_clean();
			// 		ob_implicit_flush(1);
			// 		//Определяем категорию карточки товара на xt.ua
			// 	foreach($array_cat as $k=>$value){
			// 		if ($k == $offer->categoryId){
			// 			$id_category = $value;
			// 		 	break;
			// 		}
					  
			// 	}
			// 	// получаем даные о товаре
			// 	if(!$product = $Parser->NewLine_XML($offer)){
			// 	continue;
			// 	}
				
			// 	// Добавляем новый товар в БД
			// 	if(!$product){
			// 		echo "Товар пропущен product пустой<br />";
			// 		$i++;
			// 		continue;
			// 	}elseif($id_product = $Products->AddProduct($product)){
			// 		print_r('<pre>OK, product added</pre>');
					
			// 		// Добавляем характеристики новому товару
			// 		if(!empty($product['specs'])){
			// 			foreach($product['specs'] as $specification){
			// 				$Specification->AddSpecToProd($specification, $id_product);
			// 			}
			// 		}
			// 		// Формируем массив записи ассортимента
			// 		$assort = array(
			// 			'id_assortiment' => false,
			// 			'id_supplier' => $id_supplier,
			// 			'id_product' => $id_product,
			// 			'price_opt_otpusk' => $product['price_opt_otpusk'],
			// 			'price_mopt_otpusk' => $product['price_mopt_otpusk'],
			// 			'active' => 1,
			// 			'inusd' => 0,
			// 			'sup_comment' => $product['sup_comment']
			// 		);
			// 		// Добавляем зпись в ассортимент
			// 		$Products->AddToAssortWithAdm($assort);
			// 		// Получаем артикул нового товара
			// 		$article = $Products->GetArtByID($id_product);
			// 		// Переименовываем фото товара
			// 		$to_resize = $images_arr = array();
			// 		if(isset($product['images']) && !empty($product['images'])){
			// 			foreach($product['images'] as $key=>$image){
			// 				$to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.jpg';
			// 				$file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
			// 				$path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
			// 				$images_arr[] = str_replace($file['basename'], $newname, $image);
			// 				rename($path.$file['basename'], $path.$newname);
			// 			}
			// 			//Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
			// 			foreach($images_arr as $filename){
			// 				$file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
			// 				$size = getimagesize($file);
			// 				// $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
			// 				$width = $size[0];
			// 				$height = $size[1];
			// 				if($size[0] > 1000 || $size[1] > 1000){
			// 					$ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
			// 					//Определяем размеры нового изображения
			// 					if(max($size[0], $size[1]) == $size[0]){
			// 						$width = 1000;
			// 						$height = 1000 / $ratio;
			// 					}elseif(max($size[0], $size[1]) == $size[1]){
			// 						$width = 1000*$ratio;
			// 						$height = 1000;
			// 					}
			// 				}
			// 				$res = imagecreatetruecolor($width, $height);
			// 				imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
			// 				$src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
			// 				// Добавляем логотип в нижний правый угол
			// 				imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			// 					$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
			// 					$k = imagesy($stamp)/imagesx($stamp);
			// 					$widthstamp = imagesx($res)*0.3;
			// 					$heightstamp = $widthstamp*$k;
			// 					imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
			// 				imagejpeg($res, $file);
			// 				 // sleep(2);
			// 			}
			// 			$Images->resize(false, $to_resize);
			// 			// Привязываем новые фото к товару в БД
			// 			$Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
			// 		}
			// 		// Добавляем товар в категорию
			// 		$Products->UpdateProductCategories($id_product, array($id_category));//, $arr['main_category']

			// 	}else{
			// 		echo "Проблема с добавлением продукта <br /><br />";
					
			// 	}
			// }
?>

