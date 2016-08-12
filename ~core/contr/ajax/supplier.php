<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case "toggleSinglePrice":
                // Переключение единой цены у поставщика
                if(isset($_POST['single_price']) && isset($_POST['id_supplier'])){
                    $Suppliers = new Suppliers();
                    $Suppliers->UpdateSinglePrice($_POST['id_supplier'], $_POST['single_price']);
                    $txt = json_encode('ok');
                }
                break;
            case"exclusiveProduct":
                if(isset($_POST['id_product']) && isset($_POST['active']) && isset($_POST['id_supplier'])){
                    $Products = new Products();
                    if(checkNumeric($_POST, array('id_product','active','id_supplier'))){
                        $Product->SetExclusiveSupplier($_POST['id_product'], $_POST['id_supplier'], $_POST['active']);
                        $arr['id_product'] = $_POST['id_product'];
                        $arr['id_supplier'] = $_POST['id_supplier'];
                        $arr['active'] = $_POST['active'];
                        echo json_encode($arr);
                    }
                }
                break;
            case"updateAssort":
                if(isset($_POST['mode']) && isset($_POST['id_product'])){
                    $_POST['id_supplier'] = $_SESSION['member']['id_user'];
                    $Products = new Products();
                    $Products->UpdateAssort($_POST);
                    $arr['id_product'] = $_POST["id_product"];
                    $arr['error'] = false;
                    $arr['opt'] = $_POST['mode'] == 'mopt'?0:1;
                    $txt = json_encode($arr);
                }
                break;
        }
    }
    exit();
}