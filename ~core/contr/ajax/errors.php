<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case "error":
                if(isset($_POST['comment']) && $_POST['comment'] !=''){
                    if(isset($_FILES['file'])){
                        // Проверяем загружен ли файл
                        if(is_uploaded_file($_FILES['file']['tmp_name'])){
                            $folder_name = 'error_feedback/';
                            $pathname = $GLOBALS['PATH_root'].$folder_name;
                            $images = new Images();
                            $images->checkStructure($pathname);
                            if(move_uploaded_file($_FILES['file']['tmp_name'], $pathname.$_FILES['file']['name'])) {
                                $arr['file'] = '/'.$folder_name.$_FILES['file']['name'];
                            }
                        }
                    }
                    $arr['comment'] = $_POST['comment'];
                    if(G::InsertError($arr)){
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