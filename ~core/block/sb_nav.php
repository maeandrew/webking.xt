<?php
$nav = new Products;
//если есть кука Segmentation и она не пустая (1,2 - тип сегментации), выводим категории, принадлежащие этой сегментации
if (isset($_COOKIE['Segmentation']) && ($_COOKIE['Segmentation'] == 1 || $_COOKIE['Segmentation'] == 2)) {
    $segments = $dbtree->Getsegments($_COOKIE['Segmentation']);
    $segm = '<ul class="second_nav">';
    foreach ($segments as &$v) {
        $segm .= '<li data-id="'.$v['id'].'"'.(isset($GLOBALS['Segment']) && $GLOBALS['Segment'] == $v['id']?' class="active"':null).' onclick="segmentOpen('.$v['id'].')">
            <span class="link_wrapp">
                <a href="#">'.$v['name'].'</a>
                <span><i class="material-icons">&#xE315;</i></span>
            </span>';
        if(isset($GLOBALS['Segment']) && $GLOBALS['Segment'] == $v['id']){
            $segm .= $nav->generateNavigation($nav->navigation($v['id']));
        }
        $segm .= '</li>';
    }
    $segm .= '</ul>';

    $tpl->Assign('nav', $segm);
//если куки нету или ее тип = 0, то выводим стандартные категории
} else {
    $tpl->Assign('nav', $nav->generateNavigation($navigation));
}
$tpl->Assign('sbheader', 'Каталог товаров');
$news = new News();
$tpl->Assign('news', $news->LastNews(1));
$post = new Post();
$tpl->Assign('post', $post->LastPost());

$parsed_res = array(
    'issuccess' => true,
    'html' => $tpl->Parse($GLOBALS['PATH_tpl'] . 'sb_nav.tpl')
);




