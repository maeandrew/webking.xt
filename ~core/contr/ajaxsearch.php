<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	header('Content-Type: text/javascript; charset=utf-8');
	$Product = new Products();
	if(isset($_POST['action']))
		switch($_POST['action']){
			case "search":
				// Асинхронный поиск по сайту
				if(isset($_POST['query']) && $_POST['query'] != ''){
					$query = trim($_POST['query']);
					// Инициализация соединения со Sphinx
					$sphinx = new SphinxClient();
					// $sphinx->SetServer("localhost", 9312);
					$sphinx->SetServer('81.17.140.234', 9312);
					$sphinx->SetConnectTimeout(1);
					$sphinx->SetArrayResult(true);
					$sphinx->setMaxQueryTime(3);
					$sphinx->setLimits(0, 5000);
					$sphinx->SetSortMode(SPH_SORT_RELEVANCE);
					// разбор строки запроса
					if(ctype_digit($query)){
						$result = $sphinx->Query($query, 'art'.$GLOBALS['CONFIG']['search_index_prefix']);
					}else{
						$query = preg_replace('/[()*|,.*^"&@#$%]/', ' ', $query);
						$words = explode(' ', $query);
						$sphinx->SetMatchMode(SPH_MATCH_BOOLEAN);
						$sphinx->SetRankingMode(SPH_RANK_BM25);
						$wo = '';
						foreach($words as $k=>$word){
							if(strlen($word) > 2){
								if($k == 0){
									$wo .= '( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' )';
								}else{
									$wo .= ' & ( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' )';
								}
							}
						}
						if($wo != ''){
							$result = $sphinx->Query($wo, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
						}
						if(!isset($result['total']) || $result['total'] == 0){
							$wo = '';
							$sphinx->SetMatchMode(SPH_MATCH_BOOLEAN);
							foreach($words as $word){
								for($i = 1; $i < count($words); $i++){
									if(isset($words[$i]) && strlen($words[$i]) > 2){
											$wo .= '( ( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' ) & ';
										if(count($words) > 2){
											$wo .= '( '.$words[$i].' | '.$words[$i].'* | *'.$words[$i].'* | *'.$words[$i].' ) ) | ';
										}else{
											$wo .= '( '.$words[$i].' | '.$words[$i].'* | *'.$words[$i].'* | *'.$words[$i].' ) )';
										}
									}
								}
								array_shift($words);
							}
							if($wo != ''){
								$result = $sphinx->Query($wo, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
							}
							var_dump($result);
						}
						$words = explode(' ', $query);
						if(!isset($result['total']) || $result['total'] == 0){
							$wo = '';
							$sphinx->SetMatchMode(SPH_MATCH_BOOLEAN);
							foreach($words as $k=>$word){
								if(strlen($word) > 2){
									if($k < count($words)-1){
										$wo .= '( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' ) | ';
									}else{
										$wo .= '( '.$word.' | '.$word.'* | *'.$word.'* | *'.$word.' ) ';
									}
								}
							}
							if($wo != ''){
								$result = $sphinx->Query($wo, 'name'.$GLOBALS['CONFIG']['search_index_prefix']);
							}
						}
					}
					//print_r('^'.implode(' ^', $words).' | '.implode('* ', $words).'*');
					if(isset($result['matches'])){
						foreach($result['matches'] as $val){
							$mass[] = $val['id'];
						}
						if(!empty($mass) && count($mass > 0)){
							$where_arr['customs'][] = 'p.id_product IN ('.implode(', ', $mass).')';
						}else{
							$where_arr['customs'][] = 'p.id_product = -1';
						}
						if(isset($_POST['category2search']) && $_POST['category2search'] != 0){
							$where_arr['customs'][] = 'cp.id_category IN (
								SELECT id_category
								FROM xt_category c
								WHERE c.pid = '.$_POST['category2search'].'
								OR c.pid IN (
									SELECT id_category
									FROM xt_category c
									WHERE c.pid = '.$_POST['category2search'].'
								)
							)';
						}
						if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == _ACL_TERMINAL_){
							$where_arr['customs'][] = "s.available_today = 1";
						}
						echo json_encode($Product->SetProductsListDropDownSearch($where_arr));
					}else{
						echo json_encode(null);
					}

				}else{
					exit();
				}
			;
			break;

			default:
			;
			break;
		}
	exit();
}?>