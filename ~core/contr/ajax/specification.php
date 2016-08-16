<?php
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    $Specification = new Specification();
    if(isset($_POST['action'])){
        switch($_POST['action']){
            case"getProdlistModeration":
                $arr = $Specification->GetProdlistModeration($_POST['id_category'],$_POST['specification'],$_POST['value']);
                foreach($arr as $k=>$value) {
                    $value['id_prod'];
                    $value['name'];
                    echo "<li><a target='_blank' href='/adm/productedit/".$value['id_prod']."'>".($k+1)." - ".$value['name']."</a></li>";
                }
                break;
            default:
                break;
        }
        exit();
    }
}
?>