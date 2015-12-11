<div class="breadcrumbs_wrapp clearfix">
	<?if(isset($navigation) && !in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])){?>
		<div class="catalog_btn mdl-cell--hide-phone btn_js" data-name="catalog">Каталог<i class="material-icons">keyboard_arrow_right</i></div>
	<?}?>
	<ul id="breadcrumbs" class="clearfix">
		<?if(count($GLOBALS['IERA_LINKS'])>1){
			for($ii = 0; isset($GLOBALS['IERA_LINKS'][$ii]); $ii++){
				$l = $GLOBALS['IERA_LINKS'][$ii]?>
				<?if(isset($GLOBALS['IERA_LINKS'][$ii+1])){?>
					<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
						<a href="<?=$l['url']?>" itemprop="url"><span itemprop="title"><?=$l['title']?></span></a>
						<i class="material-icons">keyboard_arrow_right</i>
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