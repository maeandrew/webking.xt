<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
    if(isset($_POST['action'])){
        if(isset ($_COOKIE['Segmentation']) && ($_COOKIE['Segmentation'] == 1 || $_COOKIE['Segmentation'] == 2)) {
            $segments = $dbtree->Getsegments($_COOKIE['Segmentation']);
            $segm = '<ul class="second_nav">';
            foreach($segments as &$v){
                $segm .= '<li data-id="'.$v['id'].'"'.(isset($GLOBALS['Segment']) && $GLOBALS['Segment'] == $v['id']?' class="active"':null).' onclick="segmentOpen('.$v['id'].')">
                    <span class="link_wrapp">
                        <a href="#">'.$v['name'].'</a>
                        <span><i class="material-icons">&#xE315;</i></span>
                    </span>';
                if(isset($GLOBALS['Segment']) && $GLOBALS['Segment'] == $v['id']){
                    $segm .= $Products->generateNavigation($Products->navigation($v['id']));
                }
                $segm .= '</li>';
            }
            $segm .= '</ul>';

            $tpl->Assign('nav', $segm);
        //если куки нету или ее тип = 0, то выводим стандартные категории
        }else{
            $tpl->Assign('nav', $Products->generateNavigation($navigation));
        }
    $tpl->Assign('sbheader', 'Каталог товаров');

    echo json_encode($tpl);
    }
}