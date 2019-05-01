<?php
    // error_reporting(-1);
    $Parser = new Parser();
    global $Specification;
    $Specification = new Specification();
    $Suppliers = new Suppliers();
    global $Images;
    $Images = new Images();
    global $Products;
    $Products = new Products();
    $id_supplier = 32076;

     
    //Устанавливаем настройки времени
    // echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
    ini_set('max_execution_time', 6000);
    // echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
    //Устанавливаем настройки памяти
    // echo "memory_limit ", ini_get('memory_limit'), "<br />";
    ini_set('memory_limit', '1024M');   
    // echo "memory_limit ", ini_get('memory_limit'), "<br />";

    ini_set('display_errors','on');
    ini_set('error_reporting',E_ALL);

    // ob_start();
    // ob_end_flush();
    // ob_end_clean();
    // ob_implicit_flush();
        
    // выбераем имеющиеся у нас артикул
    $supcomments = $Products->GetSupComments($id_supplier);
    if(is_array($supcomments)){
        $supcomments = array_unique($supcomments);
    }
    echo 'В кабенете поставшика X101 ', count($supcomments, COUNT_RECURSIVE), "<br />","<br />";
        //создаем масивы соотметствия категорий
        
    $array_cat = array(1=>1583,2=>1851,3=>1597,5=>1574,6=>1603,8=>1853,9=>1588,10=>1603,11=>1637,12=>1572,13=>1562,14=>1655,15=>1855,17=>1731,18=>1731,19=>1217,20=>1593,22=>1564,23=>1854,24=>1682,25=>1599,26=>1218,27=>1582,28=>1731,29=>1598,30=>1557,31=>1856,32=>1731,33=>1623,35=>1561,36=>1731,40=>1731,42=>1215,43=>1731,44=>1661,45=>1679,47=>1731,48=>1599,50=>1631,51=>1731,54=>1595,56=>1857,58=>992,59=>655,62=>1849,63=>1731,64=>1677,67=>1731,68=>1561,69=>1669,71=>1731,72=>1731,73=>1731,74=>1731,75=>1731,76=>666,77=>1731,78=>1697,84=>1731,85=>1597,86=>1731,88=>1731,89=>1731,90=>1212,91=>1568,92=>1647,93=>1731,95=>1731,96=>1644,97=>1731,98=>1731,99=>1594,100=>166,103=>1599,104=>1731,105=>1697,107=>1731,109=>1731,110=>1215,113=>1812,114=>1812,115=>1812,116=>1812,125=>1731,127=>1731,131=>1812,133=>675,134=>986,135=>1419,137=>1812,138=>1572,139=>989,140=>1858,141=>1812,142=>1812,146=>1594,147=>1731,148=>1731,149=>1599,150=>1697,152=>559,153=>1731,154=>1188,155=>1731,158=>1561,159=>1561,160=>1557,162=>1731,164=>1606,169=>673,170=>121,172=>1731,173=>1731,174=>1731,175=>1731,176=>1731,178=>1731,179=>1186,180=>1617,181=>1731,182=>1674,183=>1277,184=>1186,185=>168,186=>1573,187=>167,188=>122,189=>1663,190=>1619,191=>1633,192=>1624,193=>1325,194=>1591,195=>1203,196=>198,197=>127,198=>1684,199=>177,200=>1325,201=>1611,202=>1325,203=>129,204=>198,205=>198,206=>198,207=>652,208=>128,209=>125,210=>128,211=>6,212=>148,213=>1731,214=>1472,215=>125,216=>1731,217=>1731,218=>613,219=>1641,220=>163,221=>167,222=>1211,223=>1197,224=>121,225=>1622,226=>1411,227=>1731,229=>1646,230=>1731,231=>1697,232=>1731,233=>1731,234=>1731,235=>1731,236=>1731,237=>1731,238=>1731,239=>1731,241=>1731,242=>179,243=>1568,245=>198,246=>198,248=>198,249=>1731,250=>1731,251=>196,252=>1731,253=>1731,254=>1731,255=>166,256=>1731,257=>1731,258=>1572,259=>166,260=>1559,261=>1216,262=>1731,263=>166,264=>1731,265=>1731,266=>1731,267=>1731,268=>1731,272=>1659,273=>1731,274=>1731,275=>1584,276=>1141,277=>112,279=>112,280=>191,281=>1472,282=>1731,283=>955,284=>1731,285=>1418,286=>125,287=>1198,288=>1584,289=>1581,290=>1566,291=>1325,292=>128,293=>128,294=>1731,299=>1731,300=>1731,301=>1648,302=>1731,303=>1731,304=>1648,305=>1731,306=>1648,307=>126,308=>126,309=>1623,310=>1731,311=>1648,312=>1731,313=>1731,314=>996,315=>1195,316=>1629,317=>1577,318=>1192,319=>1192,320=>1195,321=>1194,322=>1194,323=>999,324=>635,325=>943,326=>1731,328=>1648,329=>1731,330=>1692,331=>1692,332=>1692,333=>1692,334=>1692,335=>1692,336=>1692,337=>1692,338=>1692,339=>1692,340=>1692,341=>1692,342=>1692,343=>1692,344=>1692,345=>1731,346=>1731,347=>1731,348=>126,349=>1731,350=>1731,351=>1731,352=>1731,353=>1731,354=>1731,355=>1731,356=>1731,357=>1731,358=>1731,359=>1731,360=>1731,361=>1731,362=>1731,363=>1731,364=>1731,365=>1731,366=>1731,367=>1731,368=>1731,370=>1731,371=>1731,372=>1731,373=>1731,374=>1731,375=>1731,376=>1252,377=>1731,378=>191,379=>191,380=>1378,381=>1411,382=>1731,383=>1731,384=>1731,385=>1731,386=>1325,387=>1566,388=>1581,389=>1198,390=>1584,391=>173,392=>1731,393=>1731,394=>1585,395=>1575,396=>123,397=>1566,398=>1581,399=>1198,400=>1566,401=>173,402=>1731,403=>1731,404=>162,405=>1573,406=>1731,408=>1731,409=>1731,410=>62,411=>171,412=>1812,413=>1812,414=>1812,415=>1812,416=>1812,417=>1812,418=>1812,419=>1812,420=>1812,421=>1731,423=>1812,424=>1812,425=>1731,427=>1731,428=>1692,429=>1692,430=>1731,432=>1731,433=>1692,434=>1692,435=>1731,436=>1731,437=>1812,438=>1731,439=>1692,440=>1731,441=>159,442=>159,444=>186,445=>1419,446=>934,447=>1194,448=>1638,449=>179,450=>1731,451=>179,452=>146,453=>157,454=>796,455=>1731,456=>63,457=>1731,458=>951,459=>945,460=>1419,461=>928,462=>94,463=>935,464=>1731,465=>949,466=>1731,467=>946,469=>1196,471=>1196,472=>1731,473=>1731,474=>1731,475=>1731,476=>1731,477=>1731,478=>1731,479=>1445,480=>632,481=>159,482=>95,483=>951,484=>1731,485=>953,486=>1731,487=>659,488=>662,489=>947,490=>926,491=>957,492=>1731,493=>1731,494=>1411,495=>142,496=>1731,497=>1731,498=>1731,499=>941,500=>922,501=>1445,502=>631,503=>94,504=>1419,505=>1419,506=>93,507=>1419,508=>928,509=>921,510=>1419,511=>1419,512=>1419,513=>931,514=>935,515=>935,516=>935,517=>1731,518=>935,519=>781,520=>781,521=>949,522=>1456,523=>1457,524=>1458,525=>935,526=>1485,527=>935,528=>1474,529=>1411,530=>782,531=>1459,532=>1459,533=>939,534=>1411,535=>939,536=>1731,537=>1731,538=>1648,539=>1812,540=>1812,541=>1812,542=>1812,543=>1812,544=>1812,545=>1812,546=>1812,547=>1812,548=>1812,549=>1812,550=>1812,551=>1731,552=>1731,553=>1731,554=>1659,555=>1628,556=>1731,557=>1564,558=>1731,559=>1731,560=>1731,561=>1731,562=>1731,563=>596,564=>1731,565=>1731,566=>64,567=>1731,568=>1731,569=>1812,570=>1812,571=>1812,572=>1812,573=>1731,575=>1698,576=>1731,577=>67,578=>1731,579=>67,580=>67,581=>1216,582=>1731,583=>1731,584=>67,585=>1731,586=>996,587=>1731,588=>1731,589=>1731,591=>1731,592=>67,593=>67,595=>1731,596=>1731,597=>1598,598=>1731,599=>1598,600=>1598,601=>772,602=>1598,603=>1731,605=>1731,607=>1731,608=>587,609=>1598,610=>1731,611=>1731,612=>1731,613=>1731,614=>1598,615=>1598,616=>1598,617=>1563,618=>1597,619=>1217,620=>163,621=>1731,622=>1588,623=>1588,624=>1563,625=>1731,626=>1731,627=>1563,628=>1563,630=>1731,631=>1731,632=>1731,633=>1731,634=>1731,635=>1731,636=>1731,637=>1731,638=>1731,639=>1731,640=>1731,641=>1593,642=>1731,643=>1731,644=>992,645=>992,646=>992,647=>992,648=>992,649=>992,650=>1655,651=>1655,652=>1731,653=>1731,654=>1731,655=>1379,656=>99,657=>666,658=>173,659=>992,660=>1731,661=>1731,662=>1731,663=>1731,664=>99,665=>990,666=>1731,667=>1731,668=>1594,669=>1731,670=>1594,672=>1698,673=>1698,674=>992,675=>1731,676=>1731,677=>1731,679=>1731,680=>592,682=>1662,683=>1212,684=>1731,685=>1731,686=>1731,687=>12,688=>1731,689=>1731,690=>1731,691=>1731,692=>1731,693=>633,694=>1395,695=>99,696=>1731,697=>1558,698=>1731,699=>1731,700=>1697,701=>1697,703=>1731,704=>954,705=>1731,706=>1731,707=>1731,708=>1731,711=>56,712=>679,713=>78,715=>713,720=>713,721=>717,722=>78,723=>1731,724=>1731,725=>1731,726=>1731,727=>1252,728=>1252,729=>165,730=>1252,731=>113,732=>12,733=>1652,734=>1731,735=>1731,736=>1677,737=>1731,738=>1731,739=>1731,740=>1731,741=>94,742=>948,743=>1731,744=>1731,745=>1731,746=>996,747=>1731,748=>1731,749=>1731,750=>13,751=>995,752=>13,753=>995,754=>998,755=>13,756=>1749,757=>1731,758=>1419,760=>1731,761=>1731,762=>1731,763=>1731,764=>1731,765=>944,767=>1595,770=>1669,771=>1669,773=>1697,774=>695,775=>1731,778=>579,779=>79,780=>1558,781=>1731,783=>1731,786=>135,787=>78,788=>1731,789=>1139,790=>198,791=>194,792=>1731,793=>198,794=>111,795=>111,796=>122,797=>1282,799=>121,800=>1731,801=>1281,802=>1281,803=>1281,804=>1281,807=>195,808=>195,809=>1286,810=>1286,811=>198,812=>1731,813=>1286,814=>128,815=>128,816=>1282,817=>1281,818=>1281,819=>1287,820=>1287,821=>1731,822=>1282,823=>1282,824=>1282,825=>1282,826=>1282,827=>1282,829=>1731,830=>155,831=>1286,832=>1287,834=>196,835=>196,836=>196,837=>1731,838=>1356,839=>192,840=>1357,841=>1731,842=>196,843=>148,844=>1731,845=>1731,846=>1731,847=>1697,848=>1731,849=>1697,850=>1697,851=>1411,852=>1697,853=>1731,854=>77,855=>719,856=>714,857=>71,858=>1731,859=>1478,860=>712,861=>71,862=>716,863=>718,864=>714,865=>77,866=>711,867=>718,868=>1731,869=>78,870=>71,871=>143,872=>71,873=>719,874=>1731,875=>563,876=>1331,877=>1331,878=>1221,879=>712,880=>1331,881=>1331,882=>1331,883=>148,884=>1189,885=>1489,886=>1481,887=>1488,888=>1731,890=>1331,891=>724,892=>1731,893=>1452,894=>722,895=>12,896=>14,897=>721,898=>1731,899=>1331,900=>1331,901=>1331,902=>1331,903=>1331,904=>1731,905=>1233,906=>764,907=>812,908=>1353,909=>811,910=>1731,911=>1331,912=>1331,913=>1331,914=>1331,915=>1331,916=>1331,917=>159,918=>18,919=>1331,920=>711,921=>1731,922=>155,923=>1331,924=>1331,925=>1331,926=>1331,927=>1331,928=>1514,929=>1331,930=>1731,931=>99,932=>942,933=>99,934=>1192,935=>125,936=>1731,937=>1731,938=>1731,939=>172,946=>1731,947=>1731,948=>1731,949=>1731,950=>1731,951=>1731,952=>1731,953=>1731,954=>1731,955=>1731,956=>1731,958=>1731,959=>1731,963=>1731,964=>1731,965=>1731,966=>1731,967=>1623,968=>1731,969=>1731,970=>1731,972=>1731,973=>1731,974=>1731,975=>1731,976=>1731,977=>1731,978=>1731,979=>1731,980=>1731,981=>1731,982=>1731,983=>1731,985=>1731,986=>1731,987=>1731,988=>1731,989=>1731,990=>1731,991=>1731,992=>1731,993=>1731,994=>1731,995=>1731,996=>1731,997=>1731,998=>1731,999=>1731,1000=>1731,1001=>1731,1002=>1731,1003=>1731,1004=>1731,1005=>1731,1006=>179,1007=>1138,1008=>1731,1009=>1731,1010=>1731,1011=>1731,1012=>1731,1013=>1731,1014=>1731,1015=>1731,1016=>1731,1017=>1812,1018=>1731,1019=>1731,1020=>1812,1021=>1731,1023=>1731,1024=>1731,1025=>1731,1026=>1731,1027=>1731,1028=>1731,1029=>1731,1030=>1731,1031=>1731,1032=>1731,1033=>1731,1034=>1731);
            
    //Подключаем API+++++++++++++++++++++++++++++++++++++++++++++++++
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array (
            'login' => 'ХозТорг(Харьков)',
            'password' => 'm2kyCSZv',
            'showprice' => '1',
            'altname' => '1')); //параметры запроса 
        //Получаем прайс
        curl_setopt($ch, CURLOPT_URL, "https://api.dclink.com.ua/api/GetPrice");
        if (!$sim_url = simplexml_load_string(curl_exec($ch))){
            echo "Не удалось получить прайс<br/>";
            die();
        }         
        //Получаем сылки на фото
        curl_setopt($ch, CURLOPT_URL, "https://api.dclink.com.ua/api/GetPicturesUrl");
        if (!$sim_url_imag = simplexml_load_string(curl_exec($ch))){
            echo "Не удалось получить сылки фото<br/>";
            die();
        }
        //курс долара
        curl_setopt($ch, CURLOPT_URL, "https://api.dclink.com.ua/api/GetExchangeRates");
        if (!$sim_url_Rates = simplexml_load_string(curl_exec($ch))){
            echo "Не удалось получить курс долара<br/>";
            die();
        }
        $Rates = $sim_url_Rates->ExchangeRates->CashRate;
        echo 'Курс долара',  $Rates, '<br/>';
        //список категорий
        // curl_setopt($ch, CURLOPT_URL, "https://api.dclink.com.ua/api/GetCategories");
        // if (!$sim_Categories = simplexml_load_string(curl_exec($ch))){
        //     echo "Не удалось <br/>";
        //     die();
        // }
        curl_close($ch);
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //Список категорий для файла сответствия
        // foreach ($sim_Categories as $key => $Cat_value) {
        //  $col=0;
        //  foreach ($sim_url as $key => $PriceValue) {     
        //      if (strval($PriceValue->CategoryID) == strval($Cat_value->CategoryID)) {
        //          // echo gettype($PriceValue->CategoryID),";", gettype($Cat_value->CategoryID), '<br/>';
        //          $col++;
        //      }
        //  }
        //  echo $Cat_value->ParentID, ";", $Cat_value->CategoryID,";", $Cat_value->CategoryName,";", $col, '<br/>';
        // }
        
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //Авто обновление
        $array_add = array(); //количество товаров на добавление
        $not_cat_offer = $not_cat = $sql_arrey = array(); //количество товаров на обновляние
        //обнуляем метку обновления (no_xtorg = 0)
        $sql = "UPDATE xt_supplier SET currency_rate = ".strval($Rates)." WHERE id_user = ".$id_supplier;
        $sql_arrey[] = $sql;
        $sql = "UPDATE xt_assortiment SET no_xtorg = 0 WHERE id_supplier = ".$id_supplier;
        $sql_arrey[] = $sql;
        foreach ($sim_url->Product as $Product) {
            if (in_array($Product->Code, $supcomments)) {
                $id_product = $Products->GetIdBysup_comment($id_supplier, $Product->Code);
                foreach ($array_cat as $key => $value) {
                    if ($key == $Product->CategoryID ) {
                        $sql_arrey[] = "delete from "._DB_PREFIX_."cat_prod WHERE id_product = ".$id_product;
                        $sql_arrey[] = "INSERT IGNORE INTO "._DB_PREFIX_."cat_prod(id_category, id_product, main, test) VALUES(".$value.", ".$id_product.", ".'1'.", '')";
                    }                     
                }
                if ($Product->PriceType == 'USD') {
                    $sql = "UPDATE "._DB_PREFIX_."assortiment SET  product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".round(strval($Rates)*strval($Product->Price), 2)."', price_mopt_otpusk = '".round(strval($Rates)*strval($Product->Price), 2)."', price_mopt_otpusk_usd = '".strval($Product->Price)."', price_opt_otpusk_usd = '".strval($Product->Price)."', inusd = 1  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_product;
                    echo $Product->Code, " обновляем USD->", strval($Product->Price), ' в грн ->', round(strval($Rates)*strval($Product->Price), 2), "<br/>";
                }else{
                    $sql = "UPDATE "._DB_PREFIX_."assortiment SET product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = '".strval($Product->Price)."', price_mopt_otpusk = '".strval($Product->Price)."', inusd = 0  WHERE id_supplier = ".$id_supplier." and id_product = ".$id_product;
                    echo $Product->Code, " в грн ->", strval($Product->Price), " обновляем <br/>";
                }
                // echo $sql, "<br/><br/>";
                $sql_arrey[] = $sql;
            }else{
                if (array_key_exists(strval($Product->CategoryID), $array_cat)&& $Product->Name != '') {
                    echo $Product->Code, "на добавление <br/>";
                    array_push($array_add, $Product);
                }else{//Товары без категории и весь остаток
                    echo $Product->Code, "Нет категории <br/>";
                    array_push($not_cat, $Product->categoryId);
                    array_push($not_cat_offer, $Product);
                }
            }
        }      
        //выключаем не обновленые позиции
        $sql = "UPDATE xt_assortiment SET product_limit = 0, active = 0 WHERE id_supplier = ".$id_supplier." and no_xtorg = 0";
        $sql_arrey[] = $sql;
        echo 'Количество товаров на обновление', count($sql_arrey), '<br/>';
        //обновляем (можем посмотреть спысок запросов)
        // foreach ($sql_arrey as $key => $value) {
        //     echo $key, " ", $value, '<br/>';
        // }
        // die();
        // ob_end_clean();
        if($Products->ProcessAssortimentXML($sql_arrey)){
            echo "ОБНОВЛЕНЫ категрии и наличие  <br />";
        }
        echo "Количество товаров на добавление ", count($array_add), "<br />";
        $not_cat = array_unique($not_cat);
        echo 'Нет категории: ', count($not_cat_offer), "<br/>";  
        foreach ($not_cat as $key => $value) {
             echo 'Категория: ', $value, "<br/>";
        } 
        //Смотрим товары без категории
         foreach ($not_cat_offer as $key => $offer) {
             echo 'Категория: ', $offer->categoryId, ' товар: ',$offer->name, "<br/>";
        }
        echo 'СТАРТ добавления: <br/>';
        $i = $l = $d = $ldi = 0;
        foreach ($array_add as $Product) {
            // ob_end_clean();
            ob_implicit_flush(1);
            //условие на количество
            // if(1 < $ldi++){
            //      echo "СТОП по КОЛИЧЕСТВУ <br/>";
            //     die();
            // }               

            //определяем категорию товара
            foreach($array_cat as $k => $value){
                if ($k == $Product->CategoryID){
                    $id_category = $value;
                    break;
                }                     
            }
            echo $Product->Name, "<br />";
             if ($Product->PriceType == 'USD') {
                    $Price = round(strval($Rates)*strval($Product->Price), 2);
                }else{
                    $Price = strval($Product->Price);
                }

    // die();
            if(!$product = $Parser->DCLing_API($Product->Code, $Product->Name, $Price, $sim_url_imag)){
                continue;

            }
        echo "<br />Посмотрим продакт-------------------------<br />";
        echo 'id_supplier -> ',$id_supplier, "<br />";
        echo 'id_category -> ',$id_category, "<br />";  
        echo 'sup_comment -> ', $product['sup_comment'], "<br />";
        echo 'name -> ', $product['name'], "<br />";
        echo 'price_mopt_otpusk -> ', $product['price_mopt_otpusk'], "<br />";
        echo 'price_opt_otpusk -> ', $product['price_opt_otpusk'], "<br />";
        echo 'inbox_qty -> ', $product['inbox_qty'], "<br />";
        echo 'min_mopt_qty -> ', $product['min_mopt_qty'], "<br />";
        echo 'note_control -> ', $product['note_control'], "<br />";
        echo 'descr -> ', $product['descr'], "<br />";
        echo 'active -> ', $product['active'], "<br />";
        echo "Количество характеристик ", count($product['specs']), "<br />";
            foreach ($product['specs'] as $key => $value) {
                foreach ($value as $key => $value) {
                    echo $key," ", $value," ";
                }
                echo "<br />";
            }
        echo "Количество фото ", count($product['images']), "<br />";
            foreach ($product['images'] as $key => $value) {
                echo $key," ", $value," <br />";
            }
                // die();
                // continue;

                // Добавляем новый товар в БД
                if(!$product){
                    $i++;   
                    echo "product пустой -> Товар пропущен<br />";
                    continue;
                }
                if($id_product = $Products->AddProduct($product)){
                    $d++;
                    print_r('<pre>OK, добавляем товар</pre>');
                        // Добавляем характеристики новому товару
                        if(!empty($product['specs'])){
                            foreach($product['specs'] as $specification){
                                $Specification->AddSpecToProd($specification, $id_product);
                            }
                        }
                        // Формируем массив записи ассортимента
                        $assort = array(
                            'id_assortiment' => false,
                            'id_supplier' => $id_supplier,
                            'id_product' => $id_product,
                            'price_opt_otpusk' => $product['price_opt_otpusk'],
                            'price_mopt_otpusk' => $product['price_mopt_otpusk'],
                            'active' => 1,
                            'inusd' => 0,
                            'sup_comment' => $product['sup_comment']
                        );
                        // Добавляем зпись в ассортимент
                        $Products->AddToAssortWithAdm($assort);
                        // Получаем артикул нового товара
                        $article = $Products->GetArtByID($id_product);
                        // Переименовываем фото товара
                            $to_resize = $images_arr = array();
                            if(isset($product['images']) && !empty($product['images'])){
                                foreach($product['images'] as $key=>$image){
                                    $to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.jpg';
                                    $file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
                                    $path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
                                    $images_arr[] = str_replace($file['basename'], $newname, $image);
                                    rename($path.$file['basename'], $path.$newname);
                                }
                                //Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
                                foreach($images_arr as $filename){
                                    $file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
                                    $size = getimagesize($file);
                                    // $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
                                    $width = $size[0];
                                    $height = $size[1];
                                    if($size[0] > 1000 || $size[1] > 1000){
                                        $ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
                                        //Определяем размеры нового изображения
                                        if(max($size[0], $size[1]) == $size[0]){
                                            $width = 1000;
                                            $height = 1000 / $ratio;
                                        }elseif(max($size[0], $size[1]) == $size[1]){
                                            $width = 1000*$ratio;
                                            $height = 1000;
                                        }
                                    }
                                    $res = imagecreatetruecolor($width, $height);
                                    imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
                                    $src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
                                    // Добавляем логотип в нижний правый угол
                                    imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
                                        $stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
                                        $k = imagesy($stamp)/imagesx($stamp);
                                        $widthstamp = imagesx($res)*0.3;
                                        $heightstamp = $widthstamp*$k;
                                        imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
                                    imagejpeg($res, $file);
                                     // sleep(2);
                                }
                                $Images->resize(false, $to_resize);
                            // Привязываем новые фото к товару в БД
                            $Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
                        }
                        // Добавляем товар в категорию
                        $Products->UpdateProductCategories($id_product, array($id_category));
                        array_push($supcomments, trim($Product->Code));
                        $ldi++;
                        echo 'товар добавлен  ', "<br />";                          
                        // die();
                }else{
                    echo "Проблема с добавлением продукта <br /><br />";
                    $l++;
                }
            }
    // echo "Товаров нет картинки ", $n_jpg, "<br/>";
    echo "Добавлено товаров ", $d, ' из : ', count($array_add), "<br/>";
    echo "Товар пропущен product пустой ", $i, "<br />";
    echo "Проблема с добавлением продукта ", $l, "<br />";
    echo "Товаров не добавлено нет категорий ", count($not_cat_offer), "<br />";
    //возвращаем настройки памяти
    ini_set('memory_limit', '128M');    
    //возвращаем настройки времени
    ini_set('max_execution_time', 300);
     
?>