<?php
class Images {
	private $db;
	private $img_info;
	private $valid_extensions;
	private $sizes;
	private $default_folder;

	function __construct(){
		$this->db =& $GLOBALS['db'];
		$this->valid_extensions = array('image/jpeg');
		$this->sizes = array(
			'thumb' => array('w' => 120, 'h' => 90),
			// 'small' => array('w' => 250, 'h' => 250),
			'medium' => array('w' => 500, 'h' => 500)
		);
		$this->default_folder = 'original';
	}
	public function upload($files, $path){
		$this->checkStructure($path);
		$tmp_name = $files['file']['tmp_name'];
		$name = $files['file']['name'];
		$destination = $path.$name;
		//Только для дублирования фото на X-torg
		if($GLOBALS['CurrentController'] == 'cabinet'){
			$xtorg_path = str_replace('files', '../web/files', $path);
			$this->checkStructure($xtorg_path);
			copy($tmp_name, $xtorg_path.$name);
			chmod($xtorg_path.$name, 0777);
		}
		move_uploaded_file($tmp_name, $destination);
		chmod($destination, 0777);
		return $destination;
	}
	/**
	 * Ресайз изображений товаров
	 * @param  boolean $resize_all 	Если true - запустить ресайз всех фото, по умолчанию - не обработанных
	 * @param  array  $images  		Список названий фотграфий, которые необходимо обработать
	 * @param  string  $date       	Дата, начиная с которой произвести ресайз
	 * @return array              	Массив, содержащий информацию об ошибках и о произведенных действиях
	 */
	public function resize($resize_all = false, $images = false, $date = false){
		$response = array();
		$img_arr = array();
		// if(isset($date)){
		// 	$i = 0;
		// 	$img_arr = array_merge($img_arr, glob($GLOBALS['PATH_product_img'].$this->default_folder.'/'.date('Y', $date).'/'.date('m', $date).'/'.date('d', $date).'/*.*'));
		// 	foreach($img_arr as $img){
		// 		$path = str_replace($GLOBALS['PATH_global_root'], '/', $img);
		// 		if(!$this->checkUsage($path)){
		// 			$this->remove($img);
		// 			$i++;
		// 		}
		// 	}
		// 	print_r('Путь - '.$GLOBALS['PATH_product_img'].$this->default_folder.'/'.date('Y', $date).'/'.date('m', $date).'/'.date('d', $date).'/, всего - '.count($img_arr).', удалено -'.$i);
		// 	die();
		// }
		// var_dump($images);die();
		if(is_array($images)){
			if(!empty($images)){
				$resize_all = true;
				foreach($images as $img){
					$img_arr = array_merge($img_arr, glob($GLOBALS['PATH_product_img'].$this->default_folder.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$img));
				}
			}else{
				return true;
			}
		}else{
			$img_arr = glob($GLOBALS['PATH_product_img'].$this->default_folder.'/*/*/*/*.jpg');
		}
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', '3600');
		set_time_limit(3600);
		foreach($img_arr as $filename){
			$img_info = array_merge(getimagesize($filename), pathinfo($filename));
			// if(in_array($this->img_info['mime'], $this->valid_extensions)){
				foreach($this->sizes as $name => $size){
					$structure = str_replace($this->default_folder, $name, $img_info['dirname'].'/');
					$this->checkStructure($structure);
					if(($resize_all === true || !file_exists($structure.$img_info['basename'])) && file_exists($structure)){
						$res = imagecreatetruecolor($size['w'], $size['h']);
						imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
						switch ($img_info['mime']) {
							case 'image/jpeg':
								$src = imagecreatefromjpeg($filename);
								break;
							case 'image/png':
								$src = imagecreatefrompng($filename);
								break;
							case 'image/gif':
								$src = imagecreatefromgif($filename);
								break;							
							default:
									break;
						}
						// $src = imagecreatefromjpeg($filename);
						$width = $size['w'];
						$height = $size['h'];
						$ratio_orig = $img_info[0]/$img_info[1];
						if($width/$height > $ratio_orig){
							$width = $height*$ratio_orig;
						}else{
							$height = $width/$ratio_orig;
						}
						imagecopyresampled($res, $src, ($size['w']-$width)/2, ($size['h']-$height)/2, 0, 0, $width, $height, $img_info[0], $img_info[1]);
						switch ($img_info['mime']) {
							case 'image/jpeg':
								imagejpeg($res, $structure.$img_info['basename']);
								break;
							case 'image/png':
								imagepng($res, $structure.$img_info['basename']);
								break;
							case 'image/gif':
								imagegif($res, $structure.$img_info['basename']);
								break;							
							default:
									break;
						}
						// imagejpeg($res, $structure.$this->img_info['basename']);
						chmod($structure.$img_info['basename'], 0777);
						if(isset($response['msg']['done'][$name])){
							$response['msg']['done'][$name] += 1;
						}else{
							$response['msg']['done'][$name] = 1;
						}
					}
				}
			// }else{
			// 	$response['error']['mime_type'][$this->img_info['mime']][] = $filename;
			// }
		}
		ini_set('max_execution_time', '30');
		ini_set('memory_limit', '128M');
		return $response;
	}

	//----------------
	public function parse_rename($image, $article){
				foreach($image as $key=>$image){
					$to_resize[] = $newname = $article['art'].($key == 0?'':'-'.$key).'.'.pathinfo($image, PATHINFO_EXTENSION);
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
						switch ($size['mime']) {
							case 'image/jpeg':
								$src = imagecreatefromjpeg($file);
								break;
							case 'image/png':
								$src = imagecreatefrompng($file);
								break;
							case 'image/gif':
								$src = imagecreatefromgif($file);
								break;							
							default:
									break;
						}
					// $src = $size['mime'] == 'image/jpeg'?imagecreatefromjpeg($file):imagecreatefrompng($file);

					// Добавляем логотип в нижний правый угол
					// imagecopyresampled($res, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
					// 	$stamp = imagecreatefrompng($GLOBALS['PATH_global_root'].'images/watermark_colored.png');
					// 	$k = imagesy($stamp)/imagesx($stamp);
					// 	$widthstamp = imagesx($res)*0.3;
					// 	$heightstamp = $widthstamp*$k;
					// 	imagecopyresampled($res, $stamp, imagesx($res) - $widthstamp, imagesy($res) - $heightstamp, 0, 0, $widthstamp, $heightstamp, imagesx($stamp), imagesy($stamp));
					// imagejpeg($res, $file);
					 // sleep(2);
				}
		$this->resize(false, $to_resize);
		return $images_arr;
	}



	/**
	 * Удаление файлов
	 * @param  string	$path		полный физический путь к файлу
	 * @return bool					true - успех, false - файла не существует
	 */
	public function remove($path){
		if(file_exists($path)){
			if(strpos($path, $this->default_folder) !== false){
				foreach($this->sizes as $name=>$size){
					$this->remove(str_replace($this->default_folder, $name, $path));
				}
			}
			unlink($path);
			return true;
		}
		return false;
	}

	public function checkStructure($structure){
		if(!file_exists($structure)){
			$old_umask = umask(0);
			if(mkdir($structure, 0777, true)){
				$response['msg']['structure'][] = 'Created new structure - '.$structure;
			}else{
				$response['error']['structure'][] = 'Couldn\'t create structure - '.$structure;
			}
			umask($old_umask);
			return $response;
		}
		return false;
	}

	/**
	 * Удаление всех размеров, которых нет в default_folder
	 * @return array 	количество удаленных файлов по папкам
	 */
	public function clearThumbs(){
		foreach($this->sizes AS $size=>$v){
			$count[$size] = 0;
			$img_arr = glob($GLOBALS['PATH_product_img'].$size.'/*/*/*/*');
			foreach($img_arr as $filename){
				$img_info = array_merge(getimagesize($filename), pathinfo($filename));
				if(!file_exists(str_replace($size, 'original', $img_info['dirname'].'/'.$img_info['basename']))){
					$this->remove($img_info['dirname'].'/'.$img_info['basename']);
					$count[$size]++;
				}
			}
		}
		return $count;
	}

	public function checkUsage($path){
		$sql = "SELECT * FROM "._DB_PREFIX_."image
			WHERE src = ".$this->db->Quote($path);
		$res = $this->db->GetArray($sql);
		if(empty($res)){
			return false;
		}
		return true;
	}
}?>