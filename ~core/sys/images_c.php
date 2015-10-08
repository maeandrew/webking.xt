<?php
class Images {
	private $img_info;
	private $valid_extensions;
	private $sizes;

	function __construct(){
		$this->valid_extensions = array('image/jpeg');
		$this->sizes = array(
			'thumb' => array('w' => 120, 'h' => 90),
			'small' => array('w' => 250, 'h' => 250),
			'medium' => array('w' => 500, 'h' => 500)
		);
	}
	function upload($files, $path){
		// print_r($files);
		$this->checkStructure($path);
		$tmp_name = $files["file"]["tmp_name"];
		$name = $files["file"]["name"];
		$destination = $path.$name;
		move_uploaded_file($tmp_name, $destination);
		chmod($destination, 0777);
		$response = $destination;
		return $response;
	}
	/**
	 * Ресайз изображений товаров
	 * @param  boolean $resize_all 	Если true - запустить ресайз всех фото, по умолчанию - не обработанных
	 * @param  string  $date       	Дата, начиная с которой произвести ресайз
	 * @return array              	Массив, содержащий информацию об ошибках и о произведенных действиях
	 */
	function resize($resize_all = false, $date = null){
		$response = array();
		$img_arr = glob($GLOBALS['PATH_product_img'].'original/*/*/*/*');
		foreach($img_arr as $filename){
			$this->img_info = array_merge(getimagesize($filename), pathinfo($filename));
			if(in_array($this->img_info['mime'], $this->valid_extensions)){
				foreach($this->sizes as $name => $size){
					$structure = str_replace('original', $name, $this->img_info['dirname'].'/');
					$this->checkStructure($structure);
					if(($resize_all == true || !file_exists($structure.$this->img_info['basename'])) && file_exists($structure)){
						$res = imagecreatetruecolor($size['w'], $size['h']);
						imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
						$src = imagecreatefromjpeg($filename);
						$width = $size['w'];
						$height = $size['h'];
						$ratio_orig = $this->img_info[0]/$this->img_info[1];
						if($width/$height > $ratio_orig){
							$width = $height*$ratio_orig;
						}else{
							$height = $width/$ratio_orig;
						}
						imagecopyresampled($res, $src, ($size['w']-$width)/2, ($size['h']-$height)/2, 0, 0, $width, $height, $this->img_info[0], $this->img_info[1]);
						imagejpeg($res, $structure.$this->img_info['basename']);
						chmod($structure.$this->img_info['basename'], 0777);
						if(isset($response['msg']['done'][$name])){
							$response['msg']['done'][$name] += 1;
						}else{
							$response['msg']['done'][$name] = 1;
						}
					}
				}
			}else{
				$response['error']['mime_type'][$this->img_info['mime']][] = $filename;
			}
		}
		return $response;
	}

	function remove($file, $path){
		if(file_exists($path.$file)){
			unlink($path.$file);
			return true;
		}
		return false;
	}

	function checkStructure($structure){
		if(!file_exists($structure)){
			$old_umask = umask(0);
			if(mkdir($structure, 0777, true)){
				$response['msg']['structure'][] = 'Created new structure - '.$structure;
			}else{
				$response['error']['structure'][] = 'Couldn\'t create structure - '.$structure;
			}
			umask($old_umask);
		}
	}
}?>