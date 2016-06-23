<?php
/**
* Типизирование ссылок на сайте
*/
class Link {

	/**
	 * Генерация ссылки на товар
	 * @param string $rewrite идентификатор товара
	 */
	public static function Product($rewrite){
		return _base_url.'/'.$rewrite.'.html';
	}

	/**
	 * Генерация ссылки на раздел
	 * @param string $rewrite идентификатор раздела
	 * @param array $params массив дополнительных настроек (страница, фильтр, сортировка)
	 */
	public static function Category($rewrite, $params = array()){
		$data = array();
		$clear = false;
		if(isset($GLOBALS['Sort']) && $GLOBALS['Sort'] !== ''){
			$data['str_sort'] = 'sort='.$GLOBALS['Sort'];
		}
		if(!isset($params['clear']) || $params['clear'] === false){
			$data['filter'] = isset($GLOBALS['Filters'])?$GLOBALS['Filters']:array();
			if(isset($GLOBALS['Page_id']) && $GLOBALS['Page_id'] !== 1){
				$data['str_page'] = 'p'.$GLOBALS['Page_id'];
			}
			if(isset($GLOBALS['Price_range']) && $GLOBALS['Price_range'] !== ''){
				$data['price_range'] = 'price_range='.$GLOBALS['Price_range'][0].','.$GLOBALS['Price_range'][1];
			}
		}else{
			$clear = $params['clear'];
		}
		if(isset($GLOBALS['Segment']) && $GLOBALS['Segment'] !== ''){
			$data['str_segment'] = 'segment='.$GLOBALS['Segment'];
		}
		if(!empty($params)){
			self::ParseParams($params, $data);
		}
		// if($clear){
		// 	return _base_url.'/'.$rewrite;
		// }
		return _base_url.(isset($rewrite)?'/'.$rewrite:null).self::AdressUrl($data).((isset($GLOBALS['Rewrite']) && $rewrite == $GLOBALS['Rewrite'])?$GLOBALS['GetString']:null);
	}

	/**
	 * Генерация ссылки на другие страницы
	 * @param string $controller идентификатор контроллера
	 * @param string $rewrite идентификатор статьи
	 */
	public static function Custom($controller, $rewrite = null, $params = array()){
		$data = array();
		if(!empty($params)){
			self::ParseParams($params, $data);
		}
		$controller = $controller=='main'?'':$controller;
		return _base_url.'/'.$controller.(isset($rewrite)?'/'.$rewrite:null).self::AdressUrl($data).(isset($params['clear']) && $params['clear'] == true?null:$GLOBALS['GetString']);
	}

	/**
	 * [ParseParams description]
	 * @param [type] $params [description]
	 * @param [type] &$data  [description]
	 */
	private static function ParseParams($params, &$data){
		foreach($params as $key => $param){
			switch($key){
				case 'filters':
					$data['filter'] = $param;
					break;
				case 'filter':
					if(isset($data['filter'][$param[0]])){
						if(in_array($param[1], $data['filter'][$param[0]])){
							foreach($data['filter'][$param[0]] as $key => $fil){
								if($param[1] == $fil){
									if(count($data['filter'][$param[0]]) > 1){
										unset($data['filter'][$param[0]][$key]);
									}else{
										unset($data['filter'][$param[0]]);
									}
								}
							}
						}else{
							$data['filter'][$param[0]][] = $param[1];
						}
					}else{
						$data['filter'][$param[0]][] = $param[1];
					}
					break;
				case 'page':
					$data['str_page'] = '';
					if($param != 1) {
						$data['str_page'] = 'p'.$param;
					}
					break;
				case 'sort':
					$data['str_sort'] = 'sort='.$param;
					break;
				case 'segment':
					$data['str_segment'] = 'segment='.$param;
					break;
				case 'price_range':
					$data['price_range'] = 'price_range='.$param;
					break;
			}
		}
		return true;
	}

	/**
	 * @param $data
	 * @return string
	 */
	private static function AdressUrl($data){
		if(isset($data['filter']) && is_array($data['filter']) && !empty($data['filter'])){
			$data['str_filter'] = '';
			foreach($data['filter'] as $key => $filters){
				$data['str_filter'] .= ($data['str_filter'] !== '' ? ';' : '') . $key . "=" . implode(',', $filters);
			}
		}
		$url = '';
		unset($data['filter']);
		foreach ($data as $key=>&$v){
			$url .= '/'.$v;
		}
		return $url;
	}
}