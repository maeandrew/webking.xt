<?
if(isset($_POST['action'])){
    switch($_POST['action']) {
        case "GetUrlWithPrice":
            $link = Link::Category( $GLOBALS['Rewrite'], array('price_range' => $_POST['price']));
            echo $link;
            break;
    }
}
exit();
?>