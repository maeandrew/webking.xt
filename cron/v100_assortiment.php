<?php
    // error_reporting(-1);
    $Parser = new Parser();
    $Specification = new Specification();
    $Suppliers = new Suppliers();
    $Images = new Images();
    $Products = new Products();
    $id_supplier = 14291;

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
    echo "СТАРТ загружаем файл <br/>";

    //Открываем файл
    if (!$sim_url = simplexml_load_file('https://mir-comforta.com/extension/sync/upload/files/all_products.xml')){
        echo "Не удалось открыть файл<br <br/>";
        die();
    }
    echo "Файл обработан simplexml_load_file  <br/>";

    //Выборка кодов категори 
    $show_product = $Parser->categories($sim_url);
    echo "ГОТОВО <br />";

    // выбераем имеющиеся у нас артикул
    

    if(!$supcomments = $Products->GetSupComments($id_supplier)){
        echo "Массив загруженых товаров поставщика пуст<br />";
        continue;
    }
    // if(is_array($supcomments)){
    //     $supcomments = array_unique($supcomments);
    // }
    echo 'У поставщика в кабегнете товаров ', count($supcomments), "<br />","<br />";

    //создаем масивы соотметствия категорий
    $array_cat = array(5819=>675);
    // можем просмотреть
    // foreach ($array_cat as $key => $value) {
    //  echo $key, " =>  ", $value, ",";
    //  }


        
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
                $id_product = $Products->GetIdBysup_comment($id_supplier, $offer->vendorCode);
                $sql = "UPDATE "._DB_PREFIX_."assortiment SET  product_limit = 100000, active = 1, no_xtorg = 1, price_opt_otpusk = ". $offer->price*0.93. ", price_mopt_otpusk = ". $offer->price*0.93. " WHERE id_supplier = 30939 and id_product = ".$id_product;
                array_push($sql_arrey, $sql);
                echo $offer->vendorCode, " обновляем <br/>";
            }else{
                if(array_key_exists(strval($offer->categoryId), $array_cat) && !in_array($offer->vendorCode, $supcomments)){
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
    die();
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
            //  echo "CТАРТ ---------------------------------------------------------------------------------------------------------";
            //      // ob_end_clean();
            //      ob_implicit_flush(1);
            //      //Определяем категорию карточки товара на xt.ua
            //  foreach($array_cat as $k=>$value){
            //      if ($k == $offer->categoryId){
            //          $id_category = $value;
            //          break;
            //      }
                      
            //  }
            //  // получаем даные о товаре
            //  if(!$product = $Parser->NewLine_XML($offer)){
            //  continue;
            //  }
                
            //  // Добавляем новый товар в БД
            //  if(!$product){
            //      echo "Товар пропущен product пустой<br />";
            //      $i++;
            //      continue;
            //  }elseif($id_product = $Products->AddProduct($product)){
            //      print_r('<pre>OK, product added</pre>');
                    
            //      // Добавляем характеристики новому товару
            //      if(!empty($product['specs'])){
            //          foreach($product['specs'] as $specification){
            //              $Specification->AddSpecToProd($specification, $id_product);
            //          }
            //      }
            //      // Формируем массив записи ассортимента
            //      $assort = array(
            //          'id_assortiment' => false,
            //          'id_supplier' => $id_supplier,
            //          'id_product' => $id_product,
            //          'price_opt_otpusk' => $product['price_opt_otpusk'],
            //          'price_mopt_otpusk' => $product['price_mopt_otpusk'],
            //          'active' => 1,
            //          'inusd' => 0,
            //          'sup_comment' => $product['sup_comment']
            //      );
            //      // Добавляем зпись в ассортимент
            //      $Products->AddToAssortWithAdm($assort);
            //      // Получаем артикул нового товара
            //      $article = $Products->GetArtByID($id_product);
            //      // Переименовываем фото товара
            //      $to_resize = $images_arr = array();
            //      if(isset($product['images']) && !empty($product['images'])){
            //          foreach($product['images'] as $key=>$image){
            //              $to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.jpg';
            //              $file = pathinfo(str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $image));
            //              $path = $GLOBALS['PATH_product_img'].trim($file['dirname']).'/';
            //              $images_arr[] = str_replace($file['basename'], $newname, $image);
            //              rename($path.$file['basename'], $path.$newname);
            //          }
            //          //Проверяем ширину и высоту загруженных изображений, и если какой-либо из показателей выше 1000px, уменяьшаем размер
            //          foreach($images_arr as $filename){
            //              $file = $GLOBALS['PATH_product_img'].str_replace('/'.str_replace($GLOBALS['PATH_global_root'], '', $GLOBALS['PATH_product_img']), '', $filename);
            //              $size = getimagesize($file);
            //              // $size = getimagesize($path.$filename); //Получаем ширину, высоту, тип картинки
            //              $width = $size[0];
            //              $height = $size[1];
            //              if($size[0] > 1000 || $size[1] > 1000){
            //                  $ratio = $size[0]/$size[1]; //коэфициент соотношения сторон
            //                  //Определяем размеры нового изображения
            //                  if(max($size[0], $size[1]) == $size[0]){
            //                      $width = 1000;
            //                      $height = 1000 / $ratio;
            //                  }elseif(max($size[0], $size[1]) == $size[1]){
            //                      $width = 1000*$ratio;
            //                      $height = 1000;
            //                  }
            //              }
            //              $res = imagecreatetruecolor($width, $height);
            //              imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
            //              $src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);
            //              // Добавляем логотип в нижний правый угол
            //              imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            //                  $stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
            //                  $k = imagesy($stamp)/imagesx($stamp);
            //                  $widthstamp = imagesx($res)*0.3;
            //                  $heightstamp = $widthstamp*$k;
            //                  imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
            //              imagejpeg($res, $file);
            //               // sleep(2);
            //          }
            //          $Images->resize(false, $to_resize);
            //          // Привязываем новые фото к товару в БД
            //          $Products->UpdatePhoto($id_product, $images_arr, $product['images_visible']);
            //      }
            //      // Добавляем товар в категорию
            //      $Products->UpdateProductCategories($id_product, array($id_category));//, $arr['main_category']

            //  }else{
            //      echo "Проблема с добавлением продукта <br /><br />";
                    
            //  }
            // }
?>

