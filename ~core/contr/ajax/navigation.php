<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    if(isset($_POST['action'])){
        $nav = $Products->generateNavigation($navigation);
        echo $nav;
    }
}