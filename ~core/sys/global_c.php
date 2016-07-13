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

		// Строчный просмотр списка товаров
		if(!isset($_COOKIE['product_view'])){
			setcookie('product_view', 'block', 0, '/');
		}
	}

	/**
	 * parsing url parameters (filters)
 	 */
 	public static function ParseUrlParams($params){
		if($params !== null){
			$param = explode(';', $params);
			foreach($param as $p){
				if(preg_match('/^(.+)=(.*)$/', $p, $match)){
					$res[$match[1]] = explode(',', $match[2]);
					foreach($res[$match[1]] as $key => &$value){
						$value = (integer) $value;
					}
				}
			}
		}
		return isset($res)?$res:null;
	}
	/**
	 * Defining _base_url global
 	 */
 	public static function DefineBaseURL(){
 		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'];
		define('_base_url', $protocol.$domainName);
 	}

	/**
	 * Defining _root global
 	 */
 	public static function DefineRootDirectory(){
		define('_root', $_SERVER['DOCUMENT_ROOT']?$_SERVER['DOCUMENT_ROOT'].DIRSEP:dirname(__FILE__).DIRSEP.'..'.DIRSEP);
 	}

 	public static function isMobile(){
		$user_agent = strtolower(getenv('HTTP_USER_AGENT'));
		$accept     = strtolower(getenv('HTTP_ACCEPT'));
		if((strpos($accept, 'text/vnd.wap.wml') !== false) || (strpos($accept, 'application/vnd.wap.xhtml+xml') !== false)){
			return true;// Мобильный браузер обнаружен по HTTP-заголовкам
		}
		if(isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])){
			return true;// Мобильный браузер обнаружен по установкам сервера
		}
		if(preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|'.
				'wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|'.
				'lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|'.
				'mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|'.
				'm881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|'.
				'r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|'.
				'i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|'.
				'htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|'.
				'sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|'.
				'p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|'.
				'_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|'.
				's800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|'.
				'd736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |'.
				'sonyericsson|samsung|240x|x320vx10|nokia|sony cmd|motorola|'.
				'up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|'.
				'pocket|kindle|mobile|psp|treo|android|iphone|ipod|webos|wp7|wp8|'.
				'fennec|blackberry|htc_|opera m|windowsphone)/', $user_agent)){
			return true;// Мобильный браузер обнаружен по сигнатуре User Agent
		}
		if(in_array(substr($user_agent, 0, 4),
				Array("1207", "3gso", "4thp", "501i", "502i", "503i", "504i", "505i", "506i",
					"6310", "6590", "770s", "802s", "a wa", "abac", "acer", "acoo", "acs-",
					"aiko", "airn", "alav", "alca", "alco", "amoi", "anex", "anny", "anyw",
					"aptu", "arch", "argo", "aste", "asus", "attw", "au-m", "audi", "aur ",
					"aus ", "avan", "beck", "bell", "benq", "bilb", "bird", "blac", "blaz",
					"brew", "brvw", "bumb", "bw-n", "bw-u", "c55/", "capi", "ccwa", "cdm-",
					"cell", "chtm", "cldc", "cmd-", "cond", "craw", "dait", "dall", "dang",
					"dbte", "dc-s", "devi", "dica", "dmob", "doco", "dopo", "ds-d", "ds12",
					"el49", "elai", "eml2", "emul", "eric", "erk0", "esl8", "ez40", "ez60",
					"ez70", "ezos", "ezwa", "ezze", "fake", "fetc", "fly-", "fly_", "g-mo",
					"g1 u", "g560", "gene", "gf-5", "go.w", "good", "grad", "grun", "haie",
					"hcit", "hd-m", "hd-p", "hd-t", "hei-", "hiba", "hipt", "hita", "hp i",
					"hpip", "hs-c", "htc ", "htc-", "htc_", "htca", "htcg", "htcp", "htcs",
					"htct", "http", "huaw", "hutc", "i-20", "i-go", "i-ma", "i230", "iac",
					"iac-", "iac/", "ibro", "idea", "ig01", "ikom", "im1k", "inno", "ipaq",
					"iris", "jata", "java", "jbro", "jemu", "jigs", "kddi", "keji", "kgt",
					"kgt/", "klon", "kpt ", "kwc-", "kyoc", "kyok", "leno", "lexi", "lg g",
					"lg-a", "lg-b", "lg-c", "lg-d", "lg-f", "lg-g", "lg-k", "lg-l", "lg-m",
					"lg-o", "lg-p", "lg-s", "lg-t", "lg-u", "lg-w", "lg/k", "lg/l", "lg/u",
					"lg50", "lg54", "lge-", "lge/", "libw", "lynx", "m-cr", "m1-w", "m3ga",
					"m50/", "mate", "maui", "maxo", "mc01", "mc21", "mcca", "medi", "merc",
					"meri", "midp", "mio8", "mioa", "mits", "mmef", "mo01", "mo02", "mobi",
					"mode", "modo", "mot ", "mot-", "moto", "motv", "mozz", "mt50", "mtp1",
					"mtv ", "mwbp", "mywa", "n100", "n101", "n102", "n202", "n203", "n300",
					"n302", "n500", "n502", "n505", "n700", "n701", "n710", "nec-", "nem-",
					"neon", "netf", "newg", "newt", "nok6", "noki", "nzph", "o2 x", "o2-x",
					"o2im", "opti", "opwv", "oran", "owg1", "p800", "palm", "pana", "pand",
					"pant", "pdxg", "pg-1", "pg-2", "pg-3", "pg-6", "pg-8", "pg-c", "pg13",
					"phil", "pire", "play", "pluc", "pn-2", "pock", "port", "pose", "prox",
					"psio", "pt-g", "qa-a", "qc-2", "qc-3", "qc-5", "qc-7", "qc07", "qc12",
					"qc21", "qc32", "qc60", "qci-", "qtek", "qwap", "r380", "r600", "raks",
					"rim9", "rove", "rozo", "s55/", "sage", "sama", "samm", "sams", "sany",
					"sava", "sc01", "sch-", "scoo", "scp-", "sdk/", "se47", "sec-", "sec0",
					"sec1", "semc", "send", "seri", "sgh-", "shar", "sie-", "siem", "sk-0",
					"sl45", "slid", "smal", "smar", "smb3", "smit", "smt5", "soft", "sony",
					"sp01", "sph-", "spv ", "spv-", "sy01", "symb", "t-mo", "t218", "t250",
					"t600", "t610", "t618", "tagt", "talk", "tcl-", "tdg-", "teli", "telm",
					"tim-", "topl", "tosh", "treo", "ts70", "tsm-", "tsm3", "tsm5", "tx-9",
					"up.b", "upg1", "upsi", "utst", "v400", "v750", "veri", "virg", "vite",
					"vk-v", "vk40", "vk50", "vk52", "vk53", "vm40", "voda", "vulc", "vx52",
					"vx53", "vx60", "vx61", "vx70", "vx80", "vx81", "vx83", "vx85", "vx98",
					"w3c ", "w3c-", "wap-", "wapa", "wapi", "wapj", "wapm", "wapp", "wapr",
					"waps", "wapt", "wapu", "wapv", "wapy", "webc", "whit", "wig ", "winc",
					"winw", "wmlb", "wonu", "x700", "xda-", "xda2", "xdag", "yas-", "your",
					"zeto", "zte-"))){
			return true; // Мобильный браузер обнаружен по сигнатуре User Agent
		}
		return false; // Мобильный браузер не обнаружен
	}
	/**
	 * Get info about client (ip, user agent etc.)
 	 */
 	public static function GetUserInfo(){
		if(isset($_GET['rememberDesktop']) || isset($_COOKIE['user_agent'])){
			if(!isset($_COOKIE['user_agent'])){
				$user_agent = 'desktop';
				setcookie('user_agent', $user_agent, time()+3600*24*30, '/');
				header('Location: /');
				exit();
			}else{
				$user_agent = $_COOKIE['user_agent'];
			}
		}else{
			if(G::isMobile() === false){
				$user_agent = 'desktop';
			}else{
				$user_agent = 'mobile';
			}
		}
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$_SESSION['client']['ip'] = $ip;
		$_SESSION['client']['user_agent'] = $user_agent;
		unset($user_agent, $ip);
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
		return isset($_SESSION['member'])?true:false;
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
		return G::IsLogged()?$_SESSION['member']:false;
	}

	/**
	 * Возвращает массив Controllers наполненный именами файлов из папки contr
	 * @param string $dir
	 */
	public static function GetControllers($dir){
		$arr = scandir($dir);
		$cont_arr = array();
		foreach($arr as $item){
			if($item != '.' && $item != '..'){
				$cont_arr[] = str_replace('.php', '', $item);
			}
		}
		return $cont_arr;
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
	public static function NeedfulPages($cnt, $items_per_page = null){
		if(!isset($items_per_page)){
			$items_per_page = $GLOBALS['Limit_db'];
		}
		if($cnt > $items_per_page){
			// в конструктор отправляется id текущ страницы и количество всего записей
			$Paginator = new Paginator(isset($GLOBALS['Page_id'])?$GLOBALS['Page_id']:1, $cnt, $items_per_page);
			$content = $Paginator->ShowPages();
			$GLOBALS['Start'] = ($Paginator->GetPage() - 1) * $items_per_page;	// забить start для использования в других местах
		}else{
			$content = '';
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
						$errm = 'Минимальное количество символов - '.$cval;
						return array(FALSE, $errm);
					}
				break;
				case 'Lmax':
					if(strlen($var) > $cval){
						$errm = 'Максимальное количество символов - '.$cval;
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
				case 'IsDate':
					if(checkdate($var['month'], $var['day'], $var['year']) === false){
						$errm = 'Такой даты не существует.';
						return array(FALSE, $errm);
					}
				break;
				case 'PM_glob':
					// пропускает все
				break;
				case 'PM_login':
					if(!(preg_match("^[A/-z0-9,\.>)}@{(<~_=-]+$/i", $var) && preg_match("/^[^'\"\\\]+$/i", $var))){
						$errm = 'Недопустимый символ.';
						return array(FALSE, $errm);
					}
				break;
				case 'PM_tel':
					if(!(preg_match("/^( +)?(38)?(\(\d{3}\)|0\d{2})?(\d{3}\d{2}\d{2})( +)?$/i", $var))){
						$errm = 'Недопустимый формат (пример: 38012345678)';
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
				case 'PM_name':
					if(!(preg_match("/^[a-zA-Zа-яёіїА'`-ЯЁІЇ\s\-]+$/i", $var))){
						$errm = 'Недопустимый символ.';
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
		$str = preg_replace('/[^a-z0-9]+/i', "_", $str);  // все символы которые не англ. буквы или цифры заменить на -
		// если первый и последний - то удалить эти символы
		if(isset($str[0]) && ($str[0]  == "_" )){
			$str = substr( $str, 1, strlen($str));
		}
		$pos = strlen($str)-1;
		if($pos>0 && $str[ $pos ]  == "_" ){
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

	public static function GenerateVerificationCode($length=4){
		return str_pad(rand(0,str_repeat("9", $length)),$length,'0');
	}
	public static function metaTags($data = false){
		// meta tags
		switch($GLOBALS['CurrentController']){
			case 'main':
				$GLOBALS['__page_title'] = 'Оптовый интернет-магазин xt.ua';
				$GLOBALS['__page_description'] = '';
				$GLOBALS['__page_keywords'] = '';
				break;
			case 'product':
				$GLOBALS['__page_title'] = htmlspecialchars($data['name'].'. '.$data['page_title']);
				$GLOBALS['__page_description'] = htmlspecialchars($data['name'].'. '.$data['page_description']);
				$GLOBALS['__page_keywords'] = htmlspecialchars(!empty($data['page_keywords'])?$data['page_keywords']:str_replace(' ', ', ', mb_strtolower($data['name_index'])));
				break;
			case 'page':
				$GLOBALS['__page_title'] = htmlspecialchars(!empty($data['page_title'])?$data['page_title']:$data['title']);
				$GLOBALS['__page_description'] = htmlspecialchars(isset($data['page_description'])?$data['page_description']:null);
				$GLOBALS['__page_keywords'] = htmlspecialchars(isset($data['page_keywords'])?$data['page_keywords']:null);
				break;
			case 'news':
				$GLOBALS['__page_title'] = htmlspecialchars(!empty($data['page_title'])?$data['page_title']:$data['title']);
				$GLOBALS['__page_description'] = htmlspecialchars(isset($data['page_description'])?$data['page_description']:null);
				$GLOBALS['__page_keywords'] = htmlspecialchars(isset($data['page_keywords'])?$data['page_keywords']:null);
				break;
			default:
				$GLOBALS['__page_title'] = htmlspecialchars(!empty($data['page_title'])?$data['page_title']:$data['name']);
				$GLOBALS['__page_description'] = htmlspecialchars(isset($data['page_description'])?$data['page_description']:null);
				$GLOBALS['__page_keywords'] = htmlspecialchars(isset($data['page_keywords'])?$data['page_keywords']:null);
				break;
		}
	}

	public static function SiteMap($navigation = false){
		if (!file_exists($GLOBALS['PATH_global_root'].'sitemap')) {
			mkdir($GLOBALS['PATH_global_root'].'sitemap', 0777, true);
		}
		global $db;
		// sitemap.xml
		switch($navigation){
			case 'products':
				$sql = "SELECT CONCAT('<url><loc>http://xt.ua/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '\"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '.html</loc></url>') AS url FROM "._DB_PREFIX_."product WHERE indexation = 1 AND visible = 1";
				break;
			case 'pages':
				$sql = "SELECT CONCAT('<url><loc>http://xt.ua/page/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '\"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '/</loc></url>') AS url FROM "._DB_PREFIX_."page WHERE indexation = 1 AND visible = 1 AND sid = 1;";
				break;
			case 'categories':
				$sql = "SELECT CONCAT('<url><loc>http://xt.ua/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '\"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '/</loc></url>') AS url FROM "._DB_PREFIX_."category WHERE indexation = 1 AND visible = 1 AND sid = 1";
				break;
			case 'news':
				$sql = "SELECT CONCAT('<url><loc>http://xt.ua/news/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '\"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '/</loc></url>') AS url FROM "._DB_PREFIX_."news WHERE indexation = 1 AND visible = 1 AND sid = 1";
				break;
			case 'posts':
				$sql = "SELECT CONCAT('<url><loc>http://xt.ua/posts/', REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(translit, '&', '&amp;'), '\'', '&apos;'), '\"', '&quot;'), '<', '&gt;'), '>', '&lt;'), '/</loc></url>') AS url FROM "._DB_PREFIX_."post WHERE indexation = 1 AND visible = 1 AND sid = 1";
				break;
			case 'promotions':
				$sql = "";
				break;
			default:
				$arr = array('products', 'pages', 'categories', 'news', 'posts');
				$r = array();
				foreach ($arr as &$v){
					$a = self::SiteMap($v);
					if(is_array($a) && !empty($a)){
						$r = array_merge($r, $a);
					}
				}
				return $r;
				break;
		}
		$res = $db->GetArray($sql);
		if(!$res){
			return false;
		}
		$count_files = 1;
		$limit = 50000;
		if(count($res)>$limit){
			$count_files =  ceil(count($res)/$limit);
		}
		array_map('unlink', glob($GLOBALS['PATH_global_root'].'sitemap/'.$navigation.'*.xml'));
		$new_files = array();
		for($i=0; $i<$count_files; $i++){
			$result = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
			foreach($res as $k => &$val){
				if($k >= $limit*$i && $k < $limit*($i+1)) {
					$result .= implode($val) . "\n";
				}
			}
			$result .='</urlset>';
			$filename = $GLOBALS['PATH_global_root'].'sitemap/'.$navigation.($i>0?'-'.$i:null).'.xml'; // путь к файлу в который нужно писать
			file_put_contents($filename, $result); // записываем результат в файл
			$new_files[] = $navigation.($i>0?'-'.$i:null).'.xml';
		}
		return $new_files;
	}

	// Сохранение в БД сообщений об ошибке
	public static function InsertError($arr){
		global $db;
		$f['comment'] = trim($arr['comment']);
		$f['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$f['url'] = $GLOBALS['_SERVER']['HTTP_REFERER'];
		if(isset($arr['image']) && $arr['image'] !='') $f['image'] = trim($arr['image']);
		if(isset($_SESSION['member']['id_user'])) $f['id_user'] = $_SESSION['member']['id_user'];
		unset($arr);
		$db->StartTrans();
		if(!$db->Insert(_DB_PREFIX_.'errors', $f)){
			$db->FailTrans();
			return false;
		}
		unset($f);
		$db->CompleteTrans();
		return true;
	}

	// Вывод сообщений об ошибке на экран
	public static function GetErrors($where_arr = false, $limit = false){
		global $db;
		$sql = "SELECT u.name, u.email, e.* FROM "._DB_PREFIX_."errors e
		 		LEFT JOIN "._DB_PREFIX_."user u ON e.id_user = u.id_user WHERE e.visible  = 1"
				.($where_arr !== false?$where_arr:'').
			    " ORDER BY e.id_error DESC".($limit !== false?$limit:'');
		$res = $db->GetArray($sql);
		if(!$res){
			return false;
		}
		return $res;
	}

	// Обновление видимости ошибки
	public static function FixError($id_error){
		global $db;
		$f['visible'] = 0;
		$db->StartTrans();
		if(!$db->Update(_DB_PREFIX_."errors", $f, "id_error = ".$id_error)){
			$db->FailTrans();
			return false;
		}
		$db->CompleteTrans();
		return true;
	}
}
