<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title><?= isset($__page_title) ? $__page_title : ''?></title>
		<?if(isset($css_arr)){
			$tmpstr = '<link href="'.$GLOBALS['URL_css'].'%s" rel="stylesheet" type="text/css" media="screen, projection">'."\n";
			foreach ($css_arr as $css){
				echo sprintf($tmpstr, $css);
			}
		}
		if(isset($js_arr)){
			$tmpstr = '<script src="'.$GLOBALS['URL_js'].'%s" type="text/javascript"%s></script>'."\n";
			foreach($js_arr as $js){
				echo sprintf($tmpstr, $js['name'], $js['async']==true?' async':null);
			}
		}?>
		<link type="image/x-icon" href="/adm/favicon.ico" rel="icon"/>
		<link type="image/x-icon" href="/adm/favicon.ico" rel="shortcut icon"/>
	</head>
	<body class="bg-retina_dust">
		<div id="wrapper">
			<?=$__center?>
		</div><!-- #wrapper -->
		<footer>
			<small>&copy; <?=date("Y", time())?> ХарьковТорг</small>
		</footer><!-- #footer -->
	</body>
</html>