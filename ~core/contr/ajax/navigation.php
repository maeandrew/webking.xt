<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    if(isset($_POST['action'])){
    	switch ($_POST['action']) {
    		case 'generateNavigation':
	        	$echo = $Products->generateNavigation($navigation);
    			break;
    		case 'generateSearchNavigation':
		        $echo = $Products->generateNavigation($navigation, 0, false, true);
				break;
    		default:
    			break;
    	}
	    echo $echo;
    }
}
exit(0);