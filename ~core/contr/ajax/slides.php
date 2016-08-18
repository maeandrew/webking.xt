<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    $Slides = new Slides();
    if(isset($_POST['action']))
        switch($_POST['action']){
            case "sort":
                if($Slides->SortSlides($_POST['data'])){
                    return true;
                }else{
                    return false;
                }
                break;
            case "add":
                $id = $Slides->AddSlide($_POST);
                echo $id;
                break;
            case "delete":
                if($id = $Slides->DeleteSlide($_POST['id'])){
                    return true;
                }else{
                    return false;
                }
                break;
            case "update":
                if($Slides->UpdateSlide($_POST)){
                    echo 'good';
                }else{
                    return false;
                }
                break;
            default:
                break;
        }
    exit();
}