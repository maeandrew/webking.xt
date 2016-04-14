<?

$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);


//Достаем сегменты, которые попадают под тип сегментации

if(isset($_POST['action'])){
    switch($_POST['action']){
        case "segments":
            $segments = $dbtree->Getsegments($_POST['segmentation']);
            break;
        case "segmcat":
            //Достаем категории 1-го уровня
            $navigation = $dbtree->GetCats(array('id_category', 'category_level', 'name', 'category_banner', 'banner_href', 'translit', 'pid'), 1);
            //Перебираем категории 2-го и 3-го уровня, отсекая ненужные
            $needed = $dbtree->GetCatSegmentation(1, 12);
            foreach($navigation as $key1 => &$l1){
                $level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
                foreach($level2 as $key2 => &$l2){
                    $level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
                    foreach($level3 as $key3 => &$l3){
                        if(!in_array($l3['id_category'], $needed)){
                            unset($level3[$key3]);
                        }
                    }
                    if(in_array($l2['id_category'], $needed) || !empty($level3)){
                        $l2['subcats'] = $level3;
                    }else{
                        unset($level2[$key2]);
                    }
                }
                if(in_array($l1['id_category'], $needed) || !empty($level2)){
                    $l1['subcats'] = $level2;
                }else{
                    unset($navigation[$key1]);
                }
            }
            break;
        default:
            break;
    }
}


//$segments = $dbtree->Getsegments($_POST['action']);
//Достаем категории 1-го уровня
//$navigation = $dbtree->GetCats(array('id_category', 'category_level', 'name', 'category_banner', 'banner_href', 'translit', 'pid'), 1);
//Перебираем категории 2-го и 3-го уровня, отсекая ненужные
//$needed = $dbtree->GetCatSegmentation(1, 12);
//foreach($navigation as $key1 => &$l1){
//    $level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
//    foreach($level2 as $key2 => &$l2){
//        $level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
//        foreach($level3 as $key3 => &$l3){
//            if(!in_array($l3['id_category'], $needed)){
//                unset($level3[$key3]);
//            }
//        }
//        if(in_array($l2['id_category'], $needed) || !empty($level3)){
//            $l2['subcats'] = $level3;
//        }else{
//            unset($level2[$key2]);
//        }
//    }
//    if(in_array($l1['id_category'], $needed) || !empty($level2)){
//        $l1['subcats'] = $level2;
//    }else{
//        unset($navigation[$key1]);
//    }
//}