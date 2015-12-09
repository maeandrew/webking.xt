<div class="menu_breadcrumbs clearfix">
	<?if(isset($navigation) && !in_array($GLOBALS['CurrentController'], $GLOBALS['LeftSideBar'])){?>
		<div class="sb_block">
			<nav class="left_menu">
				<a href="#" class="nav_btn">Каталог товаров<span class="icon-font fright">arrow_down</span></a>
				<ul class="main_menu">
					<?foreach($navigation as $l1){?>
						<li>
							<a id="cat_<?=$l1['id_category']?>" class="<?if(count($l1['subcats']) > 0){?>parent"<?}?> href="<?=_base_url?>/products/<?=$l1['id_category'].'/'.$l1['translit'].'/';?><?=!empty($l1['subcats'])?'limitall/':null;?>"><?=$l1['name']?><span class="icon-font fright">arrow_right</span></a>
							<?if(!empty($l1['subcats'])){?>
								<div class="second_menu">
									<a href="<?=$l1['banner_href']?>" class="banner">
										<img src="<?=file_exists($GLOBALS['PATH_root'].$l1['category_banner'])?htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $l1['category_banner'])):'/efiles/_thumb/nofoto.jpg'?>" alt="<?=$l1['category_banner']?>">
									</a>
									<div class="second_menu_scroll">
										<ul id="cat_<?=$l1['id_category']?>" class="first_submenu">
											<?foreach($l1['subcats'] as $l2){?>
												<li>
													<a class="a2" href="<?=_base_url?>/products/<?=$l2['id_category'].'/'.$l2['translit'].'/';?><?=!empty($l2['subcats'])?'limitall/':null;?>"><?=$l2['name']?><?=!empty($l2['subcats'])?'<span class="icon-font fright">arrow_right</span>':null;?></a>
													<?if(!empty($l2['subcats'])){?>
														<div class="third_menu <?=count($l2['subcats']) > count($l1['subcats'])?' two':' one';?>-columned">
															<div class="third_menu_scroll">
																<ul id="cat_<?=$l2['id_category']?>" class="second_submenu">
																	<?foreach($l2['subcats'] as $k=>$l3){?>
																		<li>
																			<a class="a3" href="<?=_base_url?>/products/<?=$l3['id_category'].'/'.$l3['translit'].'/';?>"><span><?=$l3['name']?></span></a>
																		</li>
																	<?}?>
																</ul>
															</div>
														</div>
													<?}?>
												</li>
											<?}?>
										</ul>
									</div>
								</div>
							<?}?>
						</li>
					<?}?>
				</ul>
			</nav>
		</div>
	<?}?>
	<ul id="breadcrumbs" class="clearfix">
		<?if(count($GLOBALS['IERA_LINKS'])>1){?>
			<?for($ii = 0; isset($GLOBALS['IERA_LINKS'][$ii]); $ii++){
				$l = $GLOBALS['IERA_LINKS'][$ii]?>
				<?if(isset($GLOBALS['IERA_LINKS'][$ii+1])){?>
					<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
						<a href="<?=$l['url']?>" itemprop="url"><span itemprop="title"><?=$l['title']?></span></a>
						<?=isset($GLOBALS['IERA_LINKS'][$ii+1])?'<span class="icon-font">arrow_right</span>':null?>
					</li>
				<?}else{?>
					<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
						<a href="<?=$l['url']?>" itemprop="url"><span itemprop="title"><?=$l['title']?></span></a>
					</li>
				<?}?>
			<?}
		}?>
	</ul>
</div>