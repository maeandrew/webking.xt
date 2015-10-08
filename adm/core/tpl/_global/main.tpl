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
			echo sprintf($tmpstr, $js['name'], $js['async'] == true?' async':null);
		}
	}?>
	<script>var URL_base = "<?=$GLOBALS['URL_base']?>adm/";</script>
	<link type="image/x-icon" href="/adm/favicon.ico" rel="icon"/>
	<link type="image/x-icon" href="/adm/favicon.ico" rel="shortcut icon"/>
	<script type="text/javascript" src="/adm/js/ace/ace.js"></script>
	<script type="text/javascript" src="/adm/js/Chart.min.js"></script>
	<script type="text/javascript" src="/plugins/dropzone.js"></script>
</head>
<body class="bg-retina_dust">
	<div id="back_modal" class="hidden"></div>
	<section id="wrapper">
		<header class="paper_shadow_1 animate">
			<?=$__header?>
		</header>
		<aside>
			<?=$__sidebar_l?>
		</aside><!-- sideLeft -->
		<article class="container">
			<div class="content paper_shadow_1">
				<?=$__center?>
			</div><!-- #content-->
		</article><!-- #container-->
		<footer>
			<small>&copy; <?=date("Y", time())?> ХарьковТОРГ</small>
		</footer><!-- #footer -->
		<div id="toTop" class="btn-l animate">Наверх</div>
	</section><!-- #wrapper -->
	<script type="text/javascript">FixHeader();</script>
</body>
</html>