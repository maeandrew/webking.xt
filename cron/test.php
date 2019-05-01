<?php
	//Устанавливаем настройки памяти
	echo "memory_limit ", ini_get('memory_limit'), "<br />";
	// ini_set('memory_limit', '1024M');	
	// echo "memory_limit ", ini_get('memory_limit'), "<br />";

	//Устанавливаем настройки времени
	echo "max_execution_time ", ini_get('max_execution_time'), "<br />";
	ini_set('max_execution_time', 600000);
	// set_time_limit(6000);// одно и тоже что ini_set('max_execution_time', 600);
	echo "max_execution_time ", ini_get('max_execution_time'), "<br />";

	//Устанавливаем настройки загружаемого файла
	echo "upload_max_filesize ", ini_get('upload_max_filesize'), "<br />";
	// ini_set("upload_max_filesize","100M");
	// echo "upload_max_filesize ", ini_get('upload_max_filesize'), "<br />";

	echo "post_max_size ", ini_get('post_max_size'), "<br />";
	echo "set_time_limit ", ini_get('set_time_limit'), "<br />";

	$Products = new Products();
	$Parser = new Parser();

	//****************************************************************************************************
	//Обновление названия товаров в программе
		//Открываем файл списка нужных товаров
		// $fail = $GLOBALS['PATH_post_img'].'ObTov.txt';
		// if (!$ObTov = fread(fopen($fail, "r"), filesize($fail))){
		// 	echo "Не удалось открыть файл<br/>";
		// 	die();
		// }
		// $result = array_unique(explode(",", $ObTov));
		// echo count($result), '<br/>';
		// foreach ($result as $key => $value) {
		// 	if ($Product = $Products->GetIdnameArrayByArt(trim($value))) {
		// 		echo "UPDATE tblMain SET SiteIdProduct = ".$Product['id_product']. ", Product = '".$Product['name']. "' WHERE ProductCode = ".$value.';', '<br/>';
		// 	}
		// }
	// die();
	//****************************************************************************************************
	//удаление товаров по списоку в файле (без удаления фото)
		//Открываем файл
		$fail = $GLOBALS['PATH_post_img'].'del_ID.txt';
		if (!$del = fread(fopen($fail, "r"), filesize($fail))){
			echo "Не удалось открыть файл<br />";
			die();
		}
		$del = $result = array_unique(explode(";", $del));
		echo count($del), '<br/>';
	// die('СТОП');
	// $del = array(310737,);
		foreach ($del as $key => $value) {
			// $Products->DelProduct($value);
			echo $value, " Удален<br/>";
		}
	die('СТОП');
	//****************************************************************************************************
	//выбераем список нужных фото с старой формы базы
	$PATH_pro2 = '/var/www/clients/client1/web1/web';
	$PATH_original = '/var/www/clients/client1/web1/web/efiles/image/';
	$PATH_thumb = '/var/www/clients/client1/web1/web/efiles/_thumb/image/';
	$PATH_500 = '/var/www/clients/client1/web1/web/efiles/image/500/';
	
	$sgl = "SELECT images, img_1, img_2, img_3 FROM c1kharkovt_bd4.xt_product where images <> ''";
	$array = $Parser->get_db($sgl);
	$array2 = array();
	foreach ($array as $key => $value) {
		$array2[] = $value['images'];
		$array2[] = $value['img_1'];
		$array2[] = $value['img_2'];
		$array2[] = $value['img_3'];
	}
	$array2 = array_unique($array2);
	echo 'В таблице product сылок на картинку', count($array2), "<br/>";

	$array_img2 = array();
	foreach ($array2 as $key => $value) {	
		if (!strstr($value, 'original') && $value != '') {
			echo $PATH = $PATH_pro2.$value, "<br/>";
			$array_img2[] = $PATH;
			echo $img = str_replace($PATH_original, $PATH_thumb, $PATH), "<br/>";
			$array_img2[] = $img;
			echo $img = str_replace($PATH_original, $PATH_500, $PATH), "<br/>";
			$array_img2[] = $img;
			echo "<br/>";
		}
		if (strstr($value, 'original')) {
			echo $PATH_prod.$value, "<br/>";
			$array_img[] = $PATH_prod.$value;
			echo $img = str_replace($poduct_images_original, $product_images_medium, $PATH_prod.$value), "<br/>";
			$array_img[] = $img;
			echo $img = str_replace($poduct_images_original, $product_images_thumb, $PATH_prod.$value), "<br/>";
			$array_img[] = $img;	
			echo "<br/>";
		}
	}
	echo 'Оставить фото список 2 ', count($array_img2), "<br/>";
	// die();
	//Проходи по каталогу и выбераем имена фото проверяем на нужность и УДАЛЯЕМ ненужные
 	$s2 = $n2 = 0; 	
 	$PATH_efiles = '/var/www/clients/client1/web1/web/efiles';
	$objects2 = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($PATH_efiles), RecursiveIteratorIterator::SELF_FIRST);
	foreach($objects2 as $name => $object){
		if(substr($name, -3) == 'jpg'){
			if(!in_array($name, $array_img2)){
				echo $name, " Удаление ", $n2++, " <br/>";
				//удаляем фото
				unlink($name);			
			}else{
				echo  $name, " ОК ", $s++,"<br/>";
			}
		 }   		 
	}
	echo 'Удалили фото', count($n2), "*****************************************************************<br/>";
	echo 'Осталось фото', count($s2), "*****************************************************************<br/>";
	//выбераем список нужных фото с базы
	$PATH_prod = '/var/www/xt.ua/web';
	$poduct_images_original = '/product_images/original/';
	$product_images_medium = '/product_images/medium/';
	$product_images_thumb = '/product_images/thumb/';
	
	$sgl = 'SELECT * FROM c1kharkovt_bd4.xt_image';
	$array_image = $Parser->get_db($sgl);
	echo 'В таблице записей',count($array_image), "<br/>";

	$array_img = array();
	foreach ($array_image as $key => $value) {
		echo $PATH_prod.$value['src'], "<br/>";
		$array_img[] = $PATH_prod.$value['src'];
		echo $img = str_replace($poduct_images_original, $product_images_medium, $PATH_prod.$value['src']), "<br/>";
		$array_img[] = $img;
		echo $img = str_replace($poduct_images_original, $product_images_thumb, $PATH_prod.$value['src']), "<br/>";
		$array_img[] = $img;	
		echo "<br/>";
	}
	echo 'Оставить фото', count($array_img), "<br/>";
	// die();	
	//Проходим по каталогу /var/www/xt.ua/web/product_images' и выбераем имена фото
 	$s = $n = 0; 	
 	$PATH_product_images = '/var/www/xt.ua/web/product_images';	
	$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($PATH_product_images), RecursiveIteratorIterator::SELF_FIRST);
	foreach($objects as $name => $object){		
		if(substr($name, -3) == 'jpg'){			
			if(!in_array($name, $array_img)){
				echo $name, " Удаление ", $n++, " <br/>";
				//удаляем фото
				unlink($name);
			}else{
				echo  $name, " ОК ", $s++,"<br/>";
			}
		}
	}
	echo 'Удалили фото', count($n), "*****************************************************************<br/>";
	echo 'Осталось фото', count($s), "*****************************************************************<br/>";	
	// die();
		

	//****************************************************************************************************
	//ВОЗВРАТ НУЖНЫХ ФОТО С БЕКАПА
	//****************************************************************************************************
	// //выбераем список нужных фото
	// $sgl = 'SELECT * FROM c1kharkovt_bd4.xt_image where id_product IN (SELECT distinct id_product FROM xt_assortiment LEFT JOIN xt_user ON xt_user.id_user = xt_assortiment.id_supplier WHERE xt_user.active + xt_assortiment.active = 2)';
	// $array_image = $Parser->get_db($sgl);
	// echo 'В таблице записей',count($array_image), "<br/>";
	// $not_foto = $array_img = array();
	// foreach ($array_image as $key => $value) {				
	// 	if (file_exists($PATH_prod.$value['src'])) {
	// 		// echo $PATH_prod.$value['src'], ' ->';
	// 	    // echo " Есть файл", '<br/>';
	// 	} else {			
	// 		$not_foto[] = $value;
	// 		echo $PATH_prod.$value['src'], ' ->';
	// 	    echo " НЕТ файла ", $value['id_product'], '<br/>';
	// 	}
	// }
	// echo 'нет фото ', count($not_foto);

	// //****************************************************************************************************
	// //выбераем список нужных фото

	// $prod = 'E:/xt/mainstor/rdiff-backup/vm2818_restore/var/www/clients/client1/web1/web';
	// $prod_500 = 'E:/xt/mainstor/rdiff-backup/vm2818_restore/var/www/clients/client1/web1/web';
	// $prod_250 = 'E:/xt/mainstor/rdiff-backup/vm2818_restore/var/www/clients/client1/web1/web';
	// // E:\xt\mainstor\rdiff-backup\vm2818_restore\var\www\clients\client1\web1\web\efiles\image\250\
	// // /efiles/image/17742-5.jpg

	// $sgl = 'SELECT id_product, images, img_1, img_2, img_3 FROM c1kharkovt_bd4.xt_product where id_product IN (SELECT distinct id_product FROM xt_assortiment LEFT JOIN xt_user ON xt_user.id_user = xt_assortiment.id_supplier WHERE xt_user.active + xt_assortiment.active = 2)';
	// $array_image = $Parser->get_db($sgl);
	// // echo 'В таблице записей',count($array_image), "<br/>";
	// // $array_img = array();
	// foreach ($array_image as $key => $value) {
	// 	if ($value['images'] != '' && !file_exists($prod.$value['images']) && !strstr($prod.$value['images'], 'original')) {
	// 		$not_foto[] = $value;
	// 		echo $prod.$value['images'], " НЕТ images ", $value['id_product'], '<br/>';
	// 	}else{
	// 		echo $prod.$value['images'], " ЕСТЬ images ", $value['id_product'], '<br/>';
	// 	}
	// 	if ($value['img_1'] != '' && !file_exists($prod.$value['img_1']) && !strstr($prod.$value['img_1'], 'original')) {
	// 		$not_foto[] = $value;
	// 		echo $prod.$value['img_1'], " НЕТ img_1 ", $value['id_product'], '<br/>';
	// 	}else{
	// 		echo $prod.$value['img_1'], " ЕСТЬ img_1 ", $value['id_product'], '<br/>';
	// 	}
	// 	if ($value['img_2'] != '' && !file_exists($prod.$value['img_2']) && !strstr($prod.$value['img_2'], 'original')) {
	// 		$not_foto[] = $value;
	// 		echo $prod.$value['img_2'], " НЕТ img_2 ", $value['id_product'], '<br/>';
	// 	}else{
	// 		echo $prod.$value['img_2'], " ЕСТЬ img_2 ", $value['id_product'], '<br/>';
	// 	}
	// 	if ($value['img_3'] != '' && !file_exists($prod.$value['img_3']) && !strstr($prod.$value['img_3'], 'original')) {
	// 		$not_foto[] = $value;
	// 		echo $prod.$value['img_3'], " НЕТ  img_3 ", $value['id_product'], '<br/>';
	// 	}else{
	// 		echo $prod.$value['img_3'], " НЕТ  img_3 ", $value['id_product'], '<br/>';
	// 	}
	// }
	// echo 'Товары нет фото ', count($not_foto);



// phpinfo();
?>