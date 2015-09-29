<?php



	// ---- center ----

	unset($parsed_res);



	$Page = new Page();

	$Page->PagesList();

	$tpl->Assign('list_menu', $Page->list);





	if (isset($GLOBALS['REQAR'][1]) && !is_numeric($GLOBALS['REQAR'][1])){

		$Manufacturers = new Manufacturers();

		if(!$Manufacturers->SetFieldsByTranslit($GLOBALS['REQAR'][1])){

			header('Location: '. _base_url.'/404/');

			exit();

		}else{

			$manufacturer_id = $Manufacturers->fields['manufacturer_id'];

		}



		if (isset($GLOBALS['REQAR'][2]) && is_numeric($GLOBALS['REQAR'][2])){

			$cat_id = $GLOBALS['REQAR'][2];

		}

	}else{

		header('Location: '. _base_url.'/404/');

		exit();

	}



	$ii = count($GLOBALS['IERA_LINKS']);

	$GLOBALS['IERA_LINKS'][$ii]['title'] = "Производители";

	$GLOBALS['IERA_LINKS'][$ii++]['url'] =  _base_url.'/manufacturers/';

	$GLOBALS['IERA_LINKS'][$ii]['title'] = $Manufacturers->fields['name'];

	$GLOBALS['IERA_LINKS'][$ii++]['url'] =  _base_url.'/manufacturer/'.$Manufacturers->fields['translit'].'/';



	$dbtree = new dbtree('im_cat', 'cat', $db);

	$items = new Items();



	// Список категорий производителя

	$items->SetCatListMan($manufacturer_id);

	$subcats = array();

	$branch = 0;

	foreach ($items->list as $l){



		$dbtree->Parents($l['cat_id'], array('cat_id', 'name', 'translit', 'cat_level'));

		if (!empty($dbtree->ERRORS_MES)) {

		    die("Error parents");

		}



		$jj=0;



		while ($cat = $dbtree->NextRow()) {

	        if (0 <> $cat['cat_level']) {



	        	$fl = true;

	        	if($branch){

	        		if(isset($psubcats[$branch-1][$jj]['cat_id']) && ($psubcats[$branch-1][$jj]['cat_id'] == $cat['cat_id']))

	        			$fl = false;

	        	}



	        	if ($fl){

		        	$subcats[$branch][$jj]['cat_id'] = $cat['cat_id'];

	            	$subcats[$branch][$jj]['name'] = $cat['name'];

	            	$subcats[$branch][$jj]['cat_level'] = $cat['cat_level'];

	            	$subcats[$branch][$jj]['translit'] = $cat['translit'];



	            	$subcats[$branch][$jj]['nolink'] = false;

	            	$subcats[$branch][$jj]['selected'] = false;



	            	if($l['cat_id'] != $cat['cat_id'])

	            		$subcats[$branch][$jj]['nolink'] = true;



	            	if(isset($cat_id) && ($cat_id == $cat['cat_id'])){

	            		$subcats[$branch][$jj]['selected'] = true;

	            		$subcats[$branch][$jj]['nolink'] = true;

	            	}

	            }



	            $psubcats[$branch][$jj]['cat_id'] = $cat['cat_id'];



	            $jj++;

	        }



		}

		$branch++;

	}





	$tpl->Assign('manname', $Manufacturers->fields['name']);

	$tpl->Assign('mantranslit', $Manufacturers->fields['translit']);

	$tpl->Assign('man_image', $Manufacturers->fields['m_image']);

	$tpl->Assign('subcats', $subcats);







	if (isset($cat_id)){



		$items->SetItemsList(array('cat_id'=>$cat_id, 'manufacturer_id'=>$manufacturer_id, 'visible'=>1));

		$catarr = $dbtree->GetNodeFields($cat_id, array('name', 'translit'));

		$tpl->Assign('cat_id', $cat_id);

		$tpl->Assign('list', $items->list);



		$ii = count($GLOBALS['IERA_LINKS']);

		$GLOBALS['IERA_LINKS'][$ii]['title'] = $catarr['name'];

	}





	$parsed_res = array('issuccess' => TRUE,

 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_manufacturer.tpl'));



	if (TRUE == $parsed_res['issuccess']) {

		$tpl_center .= $parsed_res['html'];

	}



	// ---- right ----



?>