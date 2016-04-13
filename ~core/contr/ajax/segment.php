<?
$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
//Segmentation
if(isset($_POST['segmtype']) && $_POST['segmtype'] !='' ){
    $navigation = $dbtree->GetCatSegmentation(array('id_category', 'category_level', 'name', 'category_banner', 'banner_href', 'translit', 'pid'), $_POST['segmtype']);
    foreach($navigation as &$l1){
        $level2 = $dbtree->GetSubCats($l1['id_category'], 'all');
        foreach($level2 as &$l2){
            $level3 = $dbtree->GetSubCats($l2['id_category'], 'all');
            foreach ($level3 as &$l3) {
                if(!$l3['id_category']){
                    unset($l3);
                }
            }
            $l2['subcats'] = $level3;
        }
        $l1['subcats'] = $level2;
    }
}