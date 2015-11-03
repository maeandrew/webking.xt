<?php
class G {
	/**
	 * Действия при старте приложения
 	 */
 	public static function Start(){
		$GLOBALS['__JS__'] = array();
		$GLOBALS['__JS_S__'] = array();
		$GLOBALS['__CSS__'] = array();
		$GLOBALS['__CSS_S__'] = array();
		G::SetBasicCookies();
	}

	/**
	 * Install default Cookies
 	 */
 	public static function SetBasicCookies(){
		//Установка базовой колоники цен
		if(!isset($_COOKIE['manual'])){
			if(!isset($_SESSION['cart']['cart_sum']) || $_SESSION['cart']['cart_sum'] == 0 || (isset($_SESSION['cart']['cart_sum']) && $_SESSION['cart']['cart_sum'] >= $GLOBALS['CONFIG']['full_wholesale_order_margin'])){
				setcookie('sum_range', 0, time()+3600, '/');
				$_COOKIE['sum_range'] = 0;
			}elseif(isset($_SESSION['cart']['cart_sum']) && $_SESSION['cart']['cart_sum'] > $GLOBALS['CONFIG']['wholesale_order_margin'] && $_SESSION['cart']['cart_sum'] < $GLOBALS['CONFIG']['full_wholesale_order_margin']){
				setcookie('sum_range', 1, time()+3600, '/');
				$_COOKIE['sum_range'] = 1;
			}elseif($_SESSION['cart']['cart_sum'] < $GLOBALS['CONFIG']['wholesale_order_margin'] && $_SESSION['cart']['cart_sum'] > $GLOBALS['CONFIG']['retail_order_margin']){
				setcookie('sum_range', 2, time()+3600, '/');
				$_COOKIE['sum_range'] = 2;
			}elseif(isset($_SESSION['cart']['cart_sum']) && $_SESSION['cart']['cart_sum'] <= $GLOBALS['CONFIG']['retail_order_margin']){
				setcookie('sum_range', 3, time()+3600, '/');
				$_COOKIE['sum_range'] = 3;
			}
		}

		// Обработка сортировок ====================================
		if(isset($_COOKIE['sorting'])){
			$sort = unserialize($_COOKIE['sorting']);
		}
		if(isset($_POST['value']) && isset($_POST['direction'])){
			$sort_value = $_POST['value'];
			$sorting    = array('value' => $sort_value);
			setcookie('sorting', serialize(array($GLOBALS['CurrentController']=> $sorting)), time()+3600*24*30, '/');
		}elseif(!empty($sort) && isset($sort[$GLOBALS['CurrentController']])){
			$sorting = $sort[$GLOBALS['CurrentController']];
		}

		// Строчный просмотр списка товаров
		if(!isset($_COOKIE['product_view'])){
			setcookie('product_view', 'list', 0, '/');
		}

	}
	/**
	 * Пополнение массива глобальных переменных из массива
 	 * @param array $arr
 	 */
 	public static function ToGlobals($arr){
		foreach($arr as $name=>$value){
			$GLOBALS[$name] = $value;
		}
	}

	/**
	 * Добавляет файл CSS
 	 * @param string $pName
 	 */
 	public static function AddCSS($pName){
 		if(!in_array($pName, $GLOBALS['__CSS__'])){
			$GLOBALS['__CSS__'][] = $pName;
		}
	}

	/**
	 * Возвращает CSS
 	 * @return array
 	 */
 	public static function GetCSS(){
		return $GLOBALS['__CSS__'];
	}

	/**
	 * Добавляет файл CSS_S
 	 * @param string $pName
 	 */
 	public static function AddCSS_S($pName){
		if(!in_array($pName, $GLOBALS['__CSS_S__'])){
			$GLOBALS['__CSS_S__'][] = $pName;
		}
	}

	/**
	 * Возвращает CSS_S
	 * @return array
	 */
	public static function GetCSS_S(){
		return $GLOBALS['__CSS_S__'];
	}

	/**
	 * Добавляет элемент в список JavaScripts
 	 * @param string $pName
 	 * @param boolean $pAsync
 	 */
 	public static function AddJS($pName, $pAsync = false){
		if(!in_array($pName, $GLOBALS['__JS__'])){
			$GLOBALS['__JS__'][] = array('name'=>$pName,'async'=>$pAsync);
		}
	}

	/**
	 * Возвращает JS скрипты приложения
	 * @return array
	 */
	public static function GetJS(){
		return $GLOBALS['__JS__'];
	}

	/**
	 * Добавляет элемент в список JavaScripts S
	 * @param string $pName
	 */
	public static function AddJS_S($pName){
		if(!in_array($pName, $GLOBALS['__JS_S__'])){
			$GLOBALS['__JS_S__'][] = $pName;
		}
	}

	/**
	 * Возвращает JS скрипты приложения S
 	 * @return array
 	 */
 	public static function GetJS_S(){
		return $GLOBALS['__JS_S__'];
	}

	/**
	 * Регистрирует данные текущего пользователя.
 	 * @param $pValue
 	 */
 	public static function Login($pValue){
		$_SESSION['member'] = $pValue;
	}

	/**
	 * Возвращает текущее состояния сеанса работы с приложением.
 	 * @return bool
 	 */
 	public static function IsLogged(){
		return isset($_SESSION['member']) ? TRUE : FALSE;
	}

	/**
	 * Завершает сеанс работы текущего пользователя.
	 */
	public static function Logout(){
		$_SESSION = array();
		session_destroy();
	}

	/**
	 * Возвращает данные текущего пользователя.
	 * @return array|bool
	 */
	public static function GetLoggedData(){
		return (G::IsLogged()) ? $_SESSION['member'] : FALSE;
	}

	/**
	 * Заполняет массив Controllers именами файлов из папки contr
	 * @param string $dir
	 */
	public static function DefineControllers($dir){
		$arr = scandir($dir);
		$cont_arr = array();
		foreach($arr as $item){
			if($item!='.' && $item!='..'){
				$cont_arr[] = str_replace(".php","",$item);
			}
		}
		$GLOBALS['Controllers'] = $cont_arr;
	}

	/**
	 * Получить microtime
	 * @return float
	 */
	public static function getmicrotime(){
		list($usec, $sec) = explode(" ", microtime());
		$res = ((float) $usec + (float) $sec);
		if(!isset($GLOBALS['first_getmicrotime'])){
			$GLOBALS['first_getmicrotime'] = $res;
		}
		return $res;
	}

	/**
	 * Запись в лог ошибок
	 * @param string $txt
	 * @param string $fname
	 * @param string $mode
	 */
	public static function LogerE($txt, $fname = "main.log", $mode = "a"){
		$fp = fopen($fname, $mode);
		fputs($fp, $txt);
		fclose($fp);
	}

	/**
	 * Запись в лог с датой
	 * @param string $txt
	 * @param string $fname
	 * @param string $mode
	 */
	public static function Loger($txt, $fname = "main.log", $mode = "a"){
		$fp = fopen($fname, $mode);
		print_r($txt);
		$d = date("h:i:s d.m.Y", time());
		fputs($fp, $d."  ".$txt."\n");
		fclose($fp);
	}

	/**
	 * Запись в лог ошибок и завершение работы скрипта
	 * @param string $txt
	 * @param string $fname
	 * @param string $mode
	 */
	public static function DieLoger($txt, $fname = "error.log", $mode = "a"){
		// $txt .= "\n".mysql_errno() . ": " . mysql_error() . "\n";
		G::Loger($txt, $fname, $mode);
		die();
	}

	/**
	 * Функция  проверки нужен пагинатор или нет
	 * @param int $cnt
	 * @return html
	 */
	public static function NeedfulPages($cnt){
		$content = '';
		if($cnt > $GLOBALS['Limit_db']){										//  если количество выводимого достаточно для появления пагинатора
			if(!isset($_GET['page_id']) || !is_numeric($_GET['page_id'])){
				$_GET['page_id'] = '1';
			}
			$pages = new pages($_GET['page_id'], $cnt);							// в конструктор отправляется id текущ страницы  и количество всего записей
			$content .= $pages->ShowPages();
			$GLOBALS['Start'] = ($pages->GetPage() - 1) * $GLOBALS['Limit_db'];	// забить start для использования в других местах
		}
		return $content;
	}

	/**
	 * Проверка значений, введенных в формах
	 * @param mixed $var
	 * @param array $c_arr
	 * @return array
	 */
	public static function CheckV($var, $c_arr){
		foreach($c_arr as $ckey=>$cval){
			switch ($ckey){
				case 'Lmin':
					if(strlen($var) < $cval){
						$errm = 'Cлишком короткое. Минимальное количество символов '.$cval;
						return array(FALSE, $errm);
					}
				break;
				case 'Lmax':
					if(strlen($var) > $cval){
						$errm = 'Cлишком длинное. Максимальное количество символов '.$cval;
						return array(FALSE, $errm);
					}
				break;
				case 'V':
					if($var != $cval[1]){
						$errm = 'Не совпадает с полем '.$cval[0];
						return array(FALSE, $errm);
					}
				break;
				case 'IsInt':
					if(!is_numeric($var)){
						$errm = 'Недопустимый формат.';
						return array(FALSE, $errm);
					}
				break;
				case 'IsFloat':
					if(!is_numeric($var)){
						if(!is_float($var)){
							$errm = 'Недопустимый формат.';
							return array(FALSE, $errm);
						}
					}
				break;
				case 'PM_glob':
					// пропускает все
				break;
				case 'PM_login':
					if(!(preg_match("/^[A-z0-9,\.>)}@{(<~_=-]+$/i", $var) && preg_match("/^[^'\"\\\]+$/i", $var))){
						$errm = 'Недопустимый символ.';
						return array(FALSE, $errm);
					}
				break;
				case 'PM_tel':
					if(!(preg_match("/^[0-9)(-\s,\.]+$/i", $var) && preg_match("/^[^'\"\\\]+$/i", $var))){
						$errm = 'Недопустимый символ.';
						return array(FALSE, $errm);
					}
				break;
				case 'PM_email':
					if(!(preg_match("/^[A-z0-9_\.-]+@[A-z0-9_-]+\.[A-z0-9_\.-]+$/i", $var) && preg_match("/^[^ '\"\\\]+$/i", $var))){
						$errm = 'Недопустимый формат email.';
						return array(FALSE, $errm);
					}
				break;
				case 'PM_date':
					if(!(preg_match("/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/i", $var) && preg_match("/^[^ '\"\\\]+$/i", $var))){
						$errm = 'Недопустимый формат даты (дд.мм.гггг).';
						return array(FALSE, $errm);
					}
				break;
				case 'PM_url':
					if(!(preg_match("#^(http://)*(.*?)\.(.*?)$#i", $var) && preg_match("/^[^ '\"\\\]+$/i", $var))){
						$errm = 'Недопустимый формат ссылки (пример: http://mysite.com/).';
						return array(FALSE, $errm);
					}
				break;
			}
		}
		return array(TRUE, '');
	}

	/**
	 * Перевод с русского на транслит
	 * @param string $str
	 * @return string
	 */
	public static function StrToTrans($str){
		$trans = array(
			"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
			"Е"=>"E","Ё"=>"Yo","Ж"=>"Zh",
			"З"=>"Z","И"=>"I","Й"=>"J","К"=>"K","Л"=>"L",
			"М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
			"С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"X",
			"Ц"=>"C","Ч"=>"Ch","Ш"=>"Sh","Щ"=>"Shh","Ъ"=>"",
			"Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"Yu","Я"=>"Ya",

			"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
			"е"=>"e","ё"=>"yo","ж"=>"zh",
			"з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
			"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
			"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"x",
			"ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
			"ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
		);
		$str = strtr( $str, $trans);
		$str = preg_replace('/[^a-z0-9]+/i', "-", $str);  // все символы которые не англ. буквы или цифры заменить на -
		// если первый и последний - то удалить эти символы
		if(isset($str[0]) && ($str[0]  == "-" )){
			$str = substr( $str, 1, strlen($str));
		}
		$pos = strlen($str)-1;
		if($pos>0 && $str[ $pos ]  == "-" ){
			$str = substr( $str, 0, $pos);
		}
		return $str;
	}

	/**
	 * Сериализация с заменой \n...
	 */
	function _serialize($a){
		static $Replaces = array(array("\n", "\t", "\r", "\b", "\f"),
		array('\\n', '\\t', '\\r', '\\b', '\\f'));
		return str_replace($Replaces[0], $Replaces[1], serialize($a));
	}

	function _unserialize($a){
		static $Replaces = array(array("\n", "\t", "\r", "\b", "\f"),
		array('\\n', '\\t', '\\r', '\\b', '\\f'));
		return unserialize(str_replace($Replaces[1], $Replaces[0], $a));
	}

	static function WordForNum($num){
		$words = array( "товар", "товара", "товаров", "товаров" );
		$num = $num % 100;
		if($num > 20){
			$num = $num % 10;
		}
		if(1 == $num){
			return $words[0];
		}elseif(!$num){
			return $words[3];
		}elseif($num <= 4){
			return $words[1];
		}else{
			return $words[2];
		}
	}

	// Обрезает строку до заданного кол-ва символов и завершая строку определенными символами
	static function CropString($str, $lenght = 221, $last_chars = "..."){
		if(strlen($str)>$lenght){
			$s1 = substr($str, 0, $lenght);
			$str = preg_replace("#(.*?)([ ]+[^ ]+)$#is","\$1".$last_chars,$s1);
		}
		return $str;
	}

	// Преобразование запроса
	function TransformQuery($query){
		$query = substr($query, 0, 64);
		$query = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $query);
		$good = trim(preg_replace("/\s(\S{1,4})\s/", " ", ereg_replace(" +", "  "," $query ")));
		$good = ereg_replace(" +", " ", $good);
		return $good;
	}
}?>