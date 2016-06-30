<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    $Product = new Products;
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case "error":
                if(isset($_POST['comment']) && $_POST['comment'] !=''){
                    if($Product->InsertError($_POST)){
                        $res['message'] = 'Комментарий об ошибке отправлен.';
                        $res['status'] = 1;
                    } else{
                        $res['message'] = 'Что-то пошло не так. Повторите попытку позже.';
                        $res['status'] = 2;
                    }
                } else {
                    $res['message'] = 'Комментарий об ошибке отсутствует.';
                    $res['status'] = 3;
                }
                echo json_encode($res);
                break;
        }
    }
    exit();
}