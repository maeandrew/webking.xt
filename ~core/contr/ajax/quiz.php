<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
//    $Cart = new Cart();
//    $Region = new Regions();
//    $City = new Citys();
//    $DeliveryService = new DeliveryService();
//    $Delivery = new Delivery();
    $Orders = new Orders();
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case "step1":
                if(isset($_POST['id_order'])){
                    $conragent = $Orders->GetContragentByIdOrder($_POST['id_order']);
                }
                $cont_person = explode(' ', $_SESSION['member']['name']);
                $Customer['first_name'] = isset($cont_person[0])?$cont_person[0]:'';
                $Customer['middle_name'] = isset($cont_person[1])?$cont_person[1]:'';
                $Customer['last_name'] = isset($cont_person[2])?$cont_person[2]:'';

                $tpl->Assign('step', $step);
                echo $tpl->Parse($GLOBALS['PATH_tpl_global'].'quiz.tpl');
                break;
        }
    }
    exit();
}
