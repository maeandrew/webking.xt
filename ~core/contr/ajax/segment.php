<?
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {

    $dbtree = new dbtree(_DB_PREFIX_ . 'category', 'category', $db);
    $nav = new Products;

    //Достаем сегменты, которые попадают под тип сегментации
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case "segments":
                //Устанавливаем куку с типом сегмента
                setcookie("Segmentation", $_POST['type'], time() + 60 * 60 * 24 * 7);
                if($_POST['type'] == 1 || $_POST['type'] == 2) {
                    $segments = $dbtree->Getsegments($_POST['type']);
                    $segm = '<ul class="second_nav">';
                    foreach ($segments as &$v) {
                        $segm .= '<li data-id="' . $v['id'] . '" onclick="segmentOpen(' . $v['id'] . ')"> <span class="link_wrapp"><a href="#">' . $v['name'] . '</a><span><i class="material-icons">keyboard_arrow_right</i></span></span> </li>';
                    }
                    $segm .= '</ul>';
                    echo $segm;
                    exit();
                } else if ($_POST['type'] == 0){
                    $navigation = $dbtree->GetCats(array('id_category', 'category_level', 'name', 'category_banner', 'banner_href', 'translit', 'pid'), 1);
                    foreach($navigation as &$l1){
                        $level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
                        foreach($level2 as &$l2){
                            $level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
                            $l2['subcats'] = $level3;
                        }
                        $l1['subcats'] = $level2;
                    }
                    $cat = $nav->generateNavigation($navigation);
                    echo $cat;
                    exit();
                }
                break;
            case "segmid":
                //Достаем категории 1-го уровня
                $navigation = $dbtree->GetCats(array('id_category', 'category_level', 'name', 'category_banner', 'banner_href', 'translit', 'pid'), 1);
                //Перебираем категории 2-го и 3-го уровня, отсекая ненужные
                $needed = $dbtree->GetCatSegmentation($_POST['idsegment']);
                foreach ($navigation as $key1 => &$l1) {
                    $level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
                    foreach ($level2 as $key2 => &$l2) {
                        $level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
                        foreach ($level3 as $key3 => &$l3) {
                            if (!in_array($l3['id_category'], $needed)) {
                                unset($level3[$key3]);
                            }
                        }
                        if (in_array($l2['id_category'], $needed) || !empty($level3)) {
                            $l2['subcats'] = $level3;
                        } else {
                            unset($level2[$key2]);
                        }
                    }
                    if (in_array($l1['id_category'], $needed) || !empty($level2)) {
                        $l1['subcats'] = $level2;
                    } else {
                        unset($navigation[$key1]);
                    }
                }
                $segmcat = $nav->generateNavigation($navigation);
                echo $segmcat;
                exit();
                break;
            default:
                break;
        }
    }
}
