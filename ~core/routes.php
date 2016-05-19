<?php
$request = $request_url = preg_replace('/^\//', '', preg_replace('/\/$/', '', isset($_GET['q'])?$_GET['q']:$_SERVER['REQUEST_URI']));
// print_r($request);die();
preg_match('/[\?].*$/', $_SERVER['REQUEST_URI'], $match);
$GLOBALS['GetString'] = !empty($match)?$match[0]:'';
preg_match_all('#/([^/]+)#is', $_SERVER['REQUEST_URI'], $ma);
$GLOBALS['REQAR'] = $ma[1];
// Redirecting old pages to new format
if(isset($GLOBALS['REQAR'][2])){
	switch($GLOBALS['REQAR'][0]){
		case 'product':
			if(is_numeric($GLOBALS['REQAR'][1])){
				// print_r("http://".$_SERVER['SERVER_NAME'].'/'.$GLOBALS['REQAR'][2].'.html');
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: http://".$_SERVER['SERVER_NAME'].'/'.$GLOBALS['REQAR'][2].'.html');
				exit();
			}
		break;
	}
}

// check if this is product url
$GLOBALS['CurrentController'] = 'main';
if(preg_match('/^.*\.html$/', $request)){
	$GLOBALS['CurrentController'] = 'product';
	$rewrite_arr = explode('/', $request);
	$GLOBALS['Rewrite'] = str_replace('.html', '', array_pop($rewrite_arr));
}else{
	if($request !== ''){
		// detecting page if exist
		if(preg_match('/\/p[0-9]+/', $request, $match)){
			$GLOBALS['Page_id'] = (integer) preg_replace('/^\/p/', '', $match[0]);
			$request = preg_replace('/\/p[0-9]+/', '', $request);
		}else{
			$GLOBALS['Page_id'] = 1;
		}
		// detecting sort if exist
		if(preg_match('/\/sort=[^\/]+/', $request, $match)){
			$GLOBALS['Sort'] = preg_replace('/^\/sort=/', '', $match[0]);
			$request = preg_replace('/\/sort=[^\/]+/', '', $request);
		}
		// detecting segment if exist
		if(preg_match('/\/segment=[^\/]+/', $request, $match)){
			$GLOBALS['Segment'] = preg_replace('/^\/segment=/', '', $match[0]);
			$request = preg_replace('/\/segment=[^\/]+/', '', $request);
		}
		//Диапазон цен
		if(preg_match('/\/price_range=[^\/]+/', $request, $match)){
			$GLOBALS['Price_range'] = explode(',', preg_replace('/^\/price_range=/', '', $match[0]));
			$request = preg_replace('/\/price_range=[^\/]+/', '', $request);
		}
		$rewrite_arr = explode('/', $request);
		if(!in_array($rewrite_arr[0], $GLOBALS['Controllers']) || $rewrite_arr[0] == 'products'){
			$GLOBALS['CurrentController'] = 'products';
			$GLOBALS['Rewrite'] = array_shift($rewrite_arr);
		}else{
			$GLOBALS['CurrentController'] = array_shift($rewrite_arr);
			$GLOBALS['Rewrite'] = array_shift($rewrite_arr);
			$GLOBALS['Rewrite'] = $GLOBALS['Rewrite'] == $GLOBALS['CurrentController']?false:$GLOBALS['Rewrite'];
		}
		// парсим строку с примененными фильтрами
		$GLOBALS['Filters'] = G::ParseUrlParams(array_pop($rewrite_arr));
	}
}

if(isset($rewrite_arr) && count($rewrite_arr) > 0){
	switch($GLOBALS['CurrentController']){
		case 'product':
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: http://".$_SERVER['SERVER_NAME'].'/'.str_replace(implode('/', $rewrite_arr).'/', '', $request_url));
			break;
		default:
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: http://".$_SERVER['SERVER_NAME'].'/'.str_replace(implode('/', $rewrite_arr).'/', '', $request_url).'/');
			break;
	}
}
unset($rewrite_arr, $request_url, $request);
