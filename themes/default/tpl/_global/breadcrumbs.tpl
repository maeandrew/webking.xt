<div class="breadcrumbs_wrap">
	<?if(isset($navigation) && !in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])){?>
		<div class="catalog_btn btn_js" data-name="catalog">Каталог<i class="material-icons">&#xE315;</i></div>
	<?}?>
	<ul id="breadcrumbs" class="breadcrumbs clearfix">
		<?if(count($GLOBALS['IERA_LINKS']) > 1){
			for($ii = 0; isset($GLOBALS['IERA_LINKS'][$ii]); $ii++){
				$l = $GLOBALS['IERA_LINKS'][$ii]?>
				<?if(isset($GLOBALS['IERA_LINKS'][$ii+1])){?>
					<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
						<a href="<?=$l['url']?>" itemprop="url"><span itemprop="title"><?=$l['title']?></span></a>
						<i class="material-icons">&#xE315;</i>
					</li>
				<?}else{?>
					<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
						<a href="<?=$l['url']?>" itemprop="url"><span itemprop="title"><?=$l['title']?></span></a>
					</li>
				<?}
			}
		}?>
	</ul>
</div>