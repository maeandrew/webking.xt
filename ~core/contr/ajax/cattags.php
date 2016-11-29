<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    $dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
    $Specification = new Specification();
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case "update":
                $dbtree->UpdateTags($_POST['ID'], $_POST['id_category'], $_POST['tag_name'], $_POST['tag_keys'], $_POST['tag_level'], $_POST['tag_level_name']);
                break;
            case "add":
                if($dbtree->AddTags($_POST['id_category'], $_POST['tag_name'], $_POST['tag_keys'], $_POST['tag_level'], $_POST['tag_level_name'])){
                    echo json_encode('good');
                }else{
                    echo json_encode('bad');
                }
                break;
            case "drop":
                if($dbtree->DropTagById($_POST['ID'])){
                    echo json_encode('ready');
                }else{
                    echo json_encode('ERROR');
                }
                break;
            case "updateLevel":
                if($dbtree->UpdateLevelById($_POST['id_category'], $_POST['tag_level'], $_POST['tag_level_name'])){
                    echo json_encode('ready');
                }else{
                    echo json_encode('ERROR');
                }
                break;
            case "dropLevel":
                if($dbtree->DropLevelById($_POST['id_category'], $_POST['tag_level'])){
                    echo json_encode('ready');
                }else{
                    echo json_encode('ERROR');
                }
                break;
            case "setSpecToCat":
                if($Specification->AddSpecToCat($_POST)){
                    $dbtree->UpdateEditUserDate($_POST['id_category']);
                    echo json_encode('ok');
                }
                break;
            case "updateTranslit":
                echo json_encode($dbtree->UpdateTranslit($_POST['id_category']));
                break;
            default:
                break;
        }
    }
    exit();
}