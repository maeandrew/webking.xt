<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    $Config = new Config();
    if(isset($_POST['action']))
        switch($_POST['action']){
            case "getOption":
                $Config->SetFieldsByName($_POST['nameOption']);
                echo json_encode($Config->fields);
                break;
            case "updateOption":
                echo json_encode($Config->UpdateByName($_POST['nameOption'],$_POST['valueOption']));
                break;
            default:
                break;
        }
    exit();
}