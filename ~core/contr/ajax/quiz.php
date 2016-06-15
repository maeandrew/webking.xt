<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
//    $Cart = new Cart();
//    $Region = new Regions();
//    $City = new Citys();
//    $DeliveryService = new DeliveryService();
//    $Delivery = new Delivery();
    $Orders = new Orders();
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case "step":
                $conragent = $Orders->GetContragentByLastOrder();
                $cont_person = explode(' ', $_SESSION['member']['name']);
                $customer['first_name'] = isset($cont_person[0])?$cont_person[0]:'';
                $customer['middle_name'] = isset($cont_person[1])?$cont_person[1]:'';
                $customer['last_name'] = isset($cont_person[2])?$cont_person[2]:'';

                $tpl->Assign('step', $_POST['$step)']);
                $tpl->Assign('conragent', $conragent);
                $tpl->Assign('customer', $customer);
                echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'quiz.tpl');
                break;
        }
    }
    exit();
}
