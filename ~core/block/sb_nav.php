<?php
function generateNavigation($list, $lvl = 0){
	$lvl++;
	$ul = '<ul '.($lvl == 1?'class="second_nav" ':'').'data-lvl="'.$lvl.'">';
	foreach($list as $l){
		$ul .= '<li'.(isset($GLOBALS['current_categories']) && in_array($l['id_category'], $GLOBALS['current_categories'])?' class="active"':'').'><span class="link_wrapp"><a href="'.Link::Category($l['translit']).'">'.$l['name'].'</a>';
		if(!empty($l['subcats'])){
			/*if($l['pid'] != 0 && $l['category_level'] != 1) {
				$ul .= '<span class="more_cat"><i class="material-icons rotate">keyboard_arrow_right</i></span></span>';
			}else{
				$ul .= '<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span></span>';
			}*/
			$ul .= '<span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span></span>';
			$ul .= generateNavigation($l['subcats'], $lvl);
			$ul .= '</li>';
		}else{
			$ul .= '</span></li>';
		}
	}
	$ul .= '</ul>';
	return $ul;
}
$tpl->Assign('nav', generateNavigation($navigation));
$tpl->Assign('sbheader', 'Каталог товаров');

$parsed_res = array(
	'issuccess'	=> true,
	'html'		=> $tpl->Parse($GLOBALS['PATH_tpl'].'sb_nav.tpl')
);?>