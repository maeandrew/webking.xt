<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch ($_POST['action']) {
			case 'generateNavigation':
				$echo = $Products->generateNavigation($navigation);
				break;
			case 'generateSearchNavigation':
				$echo = 'Поиск не дал результатов';
				if(is_array($_POST['list'])){
					foreach (json_decode($_POST['list']) as $cat) {
						$categories[] = (int)$cat->id_category;
						$count_cat[$cat->id_category] = (int)$cat->count;
					}
					$echo = $Products->generateNavigation($Products->navigation($categories, $count_cat), 0, false, true);
				}
				break;
			default:
				break;
		}
		echo $echo;
	}
}
exit(0);