<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case "error":
                if(isset($_POST['err_msg']) && $_POST['err_msg'] !=''){
                    if(isset($_POST['img_src']) && $_POST['img_src'] !=''){
                        $data = $_POST['img_src'];
                        list($type, $data) = explode(';', $data);
                        list(, $data)      = explode(',', $data);
                        $data = base64_decode($data);
                        $folder_name = 'error_feedback/';
                        $pathname = $GLOBALS['PATH_root'].$folder_name;
                        $filenameDB = 'error_'.date('Y-m-d').'_'.date('H_m_i').'.png';
                        $images = new Images();
                        $images->checkStructure($pathname);
                        $filename = $pathname.$filenameDB; // путь к файлу в который нужно писать
                        file_put_contents($filename, $data);
                        $err['image'] = '/'.$folder_name.$filenameDB; // записываем результат в файл
                    }
//                    if(isset($_FILES['file'])){
//                        // Проверяем загружен ли файл
//                        if(is_uploaded_file($_FILES['file']['tmp_name'])){
//                            $folder_name = 'error_feedback/';
//                            $pathname = $GLOBALS['PATH_root'].$folder_name;
//                            $images = new Images();
//                            $images->checkStructure($pathname);
//                            if(move_uploaded_file($_FILES['file']['tmp_name'], $pathname.$_FILES['file']['name'])) {
//                                $arr['file'] = '/'.$folder_name.$_FILES['file']['name'];
//                            }
//                        }
//                    }
                    $err['comment'] = $_POST['err_msg'];
                    if(G::InsertError($err)){
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