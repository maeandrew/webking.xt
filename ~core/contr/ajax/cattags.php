<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    $dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
    $specification = new Specification();
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case "setSpecToCat":
                $dbtree->UpdateEditUserDate($_POST['id_category']);
                if($specification->AddSpecToCat($_POST)){
                    echo json_encode('ok');
                }
                break;
            case "updateTranslit":
                echo json_encode($dbtree->UpdateTranslit($_POST['id_category']));
                break;
        }
    }
    exit();
}