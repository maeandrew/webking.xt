<?if(count($GLOBALS['IERA_LINKS']) > 1){?>
	<div class="breadcrumbs_wrap">
		<ul id="breadcrumbs" class="breadcrumbs">
			<?if(G::isMobile() || (isset($navigation) && !in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar']))){
				unset($GLOBALS['IERA_LINKS'][0]);?>
				<li class="btn_js" data-name="catalog"><a rel="nofollow" href="#">Каталог товаров</a></li>
			<?}
			foreach($GLOBALS['IERA_LINKS'] as $key => $breadcrumb){?>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
					<a rel="nofollow" href="<?=$breadcrumb['url']?>" itemprop="url"><span itemprop="title"><?=$breadcrumb['title']?></span></a>
				</li>
			<?}?>
		</ul>
	</div>
<?}?>