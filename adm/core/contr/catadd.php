<?php
if(!_acl::isAllow('catalog')){
	die("Access denied");
}
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);

// ---- center ----
unset($parsed_res);

// --------------------------------------------------------------------------------------

$tpl->Assign('h1', 'Добавление категории');

$ii = count($GLOBALS['IERA_LINKS']);
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Каталог";
$GLOBALS['IERA_LINKS'][$ii++]['url'] = $GLOBALS['URL_base'].'adm/cat/';
$GLOBALS['IERA_LINKS'][$ii]['title'] = "Добавление категории";

if(isset($_POST['smb'])){
	require_once($GLOBALS['PATH_block'].'t_fnc.php'); // для ф-ции проверки формы
	list($err, $errm) = Cat_form_validate();
	if(!$err){
		$arr = array();
		$arr['name'] = trim($_POST['name']);
		$arr['translit'] = G::StrToTrans($_POST['name']);
		$arr['pid'] = ($_POST['pid'] != 1)?trim($_POST['pid']):0;
		$arr['visible'] = isset($_POST['visible']) && $_POST['visible'] == "on"?0:1;
		$arr['indexation'] = isset($_POST['indexation']) && $_POST['indexation'] == "on"?1:0;
		$arr['edit_user'] = $_SESSION['member'][id_user];
		if(isset($_POST['add_image'])) {
			$arr['category_img'] = '/images/categories/' . $arr['translit'] . '.jpg';
		}
		if($id = $dbtree->Insert($arr['pid'], $arr)){
			if(isset($_POST['add_image'])){
				$name_image = pathinfo($GLOBALS['PATH_global_root'].$_POST['add_image']);
				$folder = $GLOBALS['PATH_global_root'].'/images/categories/';
				$file_name = $GLOBALS['PATH_global_root'].$arr['category_img'];
				$array_folder = scandir($folder);
				if(in_array($name_image['basename'], $array_folder)){
					rename($folder.$name_image['basename'], $file_name);
				}
				//Переопределяем размер загруженной картинки
				$size = getimagesize($file_name); //Получаем ширину, высоту, тип картинки
				if($size[0] > 1000 || $size[1] > 1000){
					$ratio=$size[0]/$size[1]; //коэфициент соотношения сторон
					//Определяем размеры нового изображения
					if(max($size[0], $size[1]) == $size[0]){
						$width = 1000;
						$height = 1000/$ratio;
					}else if(max($size[0], $size[1]) == $size[1]){
						$width = 1000*$ratio;
						$height = 1000;
					}
				}
				if(isset($width) && isset($height)){
					$res = imagecreatetruecolor($width, $height);
					imagefill($res, 0, 0, imagecolorallocate($res, 255, 255, 255));
					$src = $size['mime']=='image/jpeg'?imagecreatefromjpeg($file_name):imagecreatefrompng($file_name);
					imagecopyresampled($res, $src, 0,0,0,0, $width, $height, $size[0], $size[1]);
					imagejpeg($res, $file_name);
				}
			}
			$tpl->Assign('msg', 'Категория добавлена.');
			unset($_POST, $name_image, $folder, $file_name, $array_folder);
		}else{
			$tpl->Assign('msg', 'Ошибочка. Категория не добавлена.');
			$tpl->Assign('errm', 1);
		}
	}else{
		// показываем все заново но с сообщениями об ошибках
		$tpl->Assign('msg', 'Ошибка! Категория не добавлена.');
		$tpl->Assign('errm', $errm);
	}
}

$list = $dbtree->Full(array('id_category', 'category_level', 'name'));

$tpl->Assign('list', $list);

if(!isset($_POST['smb'])){
	$_POST['id_category'] = 0;
	if(isset($GLOBALS['REQAR'][1]) && is_numeric($GLOBALS['REQAR'][1])){
		$_POST['pid'] = $GLOBALS['REQAR'][1];
	}
}

$parsed_res = array(
	'issuccess' => true,
 	'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_cat_ae.tpl')
 );

// --------------------------------------------------------------------------------------

if(true == $parsed_res['issuccess']){
	$tpl_center .= $parsed_res['html'];
}
