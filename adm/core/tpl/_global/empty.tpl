<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<title><?= isset($__page_title) ? $__page_title : ''?></title>
	<meta name="description" content="<?=$__page_description?>" />
    <meta name="keywords" content="<?= isset($__page_title) ? $__page_title : ''?>" />
	<?php
        if (isset($css_arr)) {
            $tmpstr = '<link href="'.$GLOBALS['URL_css'].'%s" rel="stylesheet" type="text/css" media="screen, projection">'."\n";
            foreach ($css_arr as $css)
                echo sprintf($tmpstr, $css);
        }
	?>
	<link type="image/x-icon" href="http://artjoker.com.ua/favicon.ico" rel="icon"/>
 		<link type="image/x-icon" href="http://artjoker.com.ua/favicon.ico" rel="shortcut icon"/>
</head>


<body>
<center>
<div style="width:600px;text-align:left;">
<?=$__center?>
</div>
</center>

</body>
</html>