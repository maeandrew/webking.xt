<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    if(isset($_POST['action'])){
        $nav = $Products->generateNavigation($navigation);
        echo $nav;
        $nav_searh = $Products->generateSearhNavigation($navigation);
        echo $nav_searh;
    }
}