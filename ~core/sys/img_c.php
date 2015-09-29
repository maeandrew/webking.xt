<?php
  class img {
	 var $path_to_img;
	 var $size;
	 var $file;
	 var $target;
	 var $watermark_url;
	 var $wm_offset_direction;
	 var $wm_offset_x;
	 var $wm_offset_y;
	function img($w = 60, $h = 60){
		$this->file = array();
		$this->path_to_img = ''; //'http://go/img_c/img/';
		$this->size = array(
			//"small"=>array("width"=>900,"height"=>90),
			"nam" => array("width"=>$w,"height"=>$h)
		);
		$this->angle = 0;
		$this->target = 'b'; // file (jpg, gif, png) `b` - вывод в браузер
		$this->watermark_url = '';
		$this->wm_offset_corner = '1'; // может быть {1, 2, 3, 4}
		$this->wm_offset_x = 10;
		$this->wm_offset_y = 10;
	}
	function GenFileInfo($f){
		$f = trim($f);
		$this->file = array();
		if(strstr($f, "http")){ // удаленный файл
			if(preg_match("/(?:.*?)\/(.*)[.]{1,1}(gif|jpg|png|jpeg)$/iU", $f, $ma)){
				$this->file['file'] = $f;
				$this->file['name'] = $ma[1];
				$this->file['ext'] = $ma[2];
			}else{
				return false;
			}
		}else{ // локальный файл
			$fs = str_replace('\\', '/', $f);
			if(preg_match("/(?:.*?)\/(.*)[.]{1,1}(gif|jpg|png|jpeg|tmp)$/iU", $fs, $ma)){
				$this->file['file'] = $f;
				$this->file['name'] = $ma[1];
				$this->file['ext'] = $ma[2];
			}else{
				return false;
			}
		}
		return $this->file;
	}
	function change($fpath=null){
		$url_im = $this->file['file'];
		$im_type = getimagesize($url_im);
		switch($im_type[2]){
			case 1:
				$im_out = imagecreatefromgif($url_im);
			break;
			case 2:
				$im_out = imagecreatefromjpeg($url_im);
			break;
			case 3:
				$im_out = imagecreatefrompng($url_im);
			break;
			default:
				return false;
			break;
		}
		if($this->angle){
			if($this->angle!=180){			// поворот 90 или -90 или 180
				$width = $im_type[1];
				$height = $im_type[0];
				$rot_im = imagecreatetruecolor($width,$height);
				$rot_im = imagerotate ( $im_out, $this->angle,0);
				$im_out = $rot_im;
				$im_type[1]=$height;
				$im_type[0]=$width;
			}else{
				$im_out = imagerotate ( $im_out, $this->angle,0);
			}
		}
		foreach($this->size as $sn=>$swh){
			$width = $im_type[0];
			$height = $im_type[1];
			if($width > $swh['width']){
				$width = $swh['width'];
				$height = ($im_type[1]/$im_type[0])*$swh['width'];
			}
			if($height > $swh['height']){
				$t = $height;
				$height = $swh['height'];
				$width = ($width/$t)*$swh['height'];
			}
			$left = ($swh['width']-$width)/2;
			$top = ($swh['height']-$height)/2;
			$im_dst = imagecreatetruecolor($swh['width'], $swh['height']);
			$white = imagecolorallocate($im_dst, 255, 255, 255);
			//$white = imagecolorallocate ($im_dst, 0, 0, 0);
			imagefill($im_dst, 0, 0, $white);
			imagecopyresampled($im_dst, $im_out, $left, $top, 0, 0, $width, $height, $im_type[0], $im_type[1]);
			//imagegif($im_dst,"img/".$foto_alias."_".$id."_".$sn.".gif");
			//imagejpeg($im_dst,"img/".$foto_alias."_".$id."_".$sn.".jpg");
			if($this->watermark_url != ''){
				$im_wm_type = getimagesize($this->watermark_url);
				$wm_width = $im_wm_type[0];
				$wm_height = $im_wm_type[1];
				switch($im_wm_type[2]){
					case 1:
						$im_wm = imagecreatefromgif($this->watermark_url);
					break;
					case 2:
						$im_wm = imagecreatefromjpeg($this->watermark_url);
					break;
					case 3:
						$im_wm = imagecreatefrompng($this->watermark_url);
					break;
					default:
						return false;
					break;
				}
				list($left, $top) = $this->CalculateWMLeftTop($left, $top, $width, $height, $wm_width, $wm_height);
				imagecopy($im_dst, $im_wm, $left, $top, 0, 0, $wm_width, $wm_height);
			}
			if($this->target == 'b'){
				header("Cache-Control: max-age=86400");
				header("Content-Type: image/jpeg");
				imagejpeg($im_dst);
				@ImageDestroy($im_dst);
			}else{
				imagejpeg($im_dst, $fpath);
			}
		}
		$err = ImageDestroy($im_out);
	 return true;
	}
	function CalculateWMLeftTop($x0, $y0, $w, $h, $wm_w, $wm_h){
		switch($this->wm_offset_corner){
			case 1: // лев верхн
				$left = $x0 + $this->wm_offset_x;
				$top = $y0 + $this->wm_offset_y;
			break;
			case 2: // прав верхн
				$left = $x0 + $w - $this->wm_offset_x - $wm_w;
				$top = $y0 + $this->wm_offset_y;
			break;
			case 3: // прав нижн
				$left = $x0 + $w - $this->wm_offset_x - $wm_w - $x0;
				$top = $y0 + $h - $this->wm_offset_y - $wm_h;
			break;
			case 4: // лев нижн
				$left = $x0 + $this->wm_offset_x;
				$top = $y0 + $h - $this->wm_offset_y - $wm_h;
			break;
		}
		return array($left, $top);
	}
}
?>