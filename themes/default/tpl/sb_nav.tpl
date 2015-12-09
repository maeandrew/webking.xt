<?if(isset($sbheader) && isset($navigation)){?>
	<div class="sb_block">
		<nav class="left_menu">
			<a href="#" class="nav_btn"><?=$sbheader?><span class="icon-font fright">arrow_down</span></a>
			<ul class="main_menu">
				<li><a id="cat_469" href="<?=Link::Category('NOVINKI-KATALOGA');?>" class="<?=(isset($GLOBALS['CURRENT_ID_CATEGORY']) && 469 == $GLOBALS['CURRENT_ID_CATEGORY']) || 469 == $curcat['pid']?'active ':null;?>">Новинки каталога</a></li>
				<?foreach($navigation as $l1){?>
					<li>
						<a id="cat_<?=$l1['id_category']?>" class="<?=(isset($GLOBALS['CURRENT_ID_CATEGORY']) && $l1['id_category'] == $GLOBALS['CURRENT_ID_CATEGORY']) || $l1['id_category'] == $curcat['pid']?'active ':null;?> <?if(count($l1['subcats']) > 0){?>parent"<?}?> href="<?=Link::Category($l1['translit']);?>"><?=$l1['name']?><span class="icon-font fright">arrow_right</span></a>
						<?if(!empty($l1['subcats'])){?>
							<div class="second_menu">
								<a href="<?=$l1['banner_href']?>" class="banner"><img src="<?=file_exists($GLOBALS['PATH_root'].$l1['category_banner'])?$l1['category_banner']:'/efiles/_thumb/nofoto.jpg'?>" alt="<?=$l1['category_banner']?>"></a>
								<div class="second_menu_scroll">
									<ul id="cat_<?=$l1['id_category']?>" class="first_submenu<?=$l1['id_category'] == $curcat['pid']?' active':null;?>">
										<?foreach($l1['subcats'] as $l2){?>
											<li>
												<a class="a2<?=isset($GLOBALS['CURRENT_ID_CATEGORY']) && $GLOBALS['CURRENT_ID_CATEGORY'] == $l2['id_category']?' active':null;?>" href="<?=Link::Category($l2['translit']);?>"><?=$l2['name']?><?=!empty($l2['subcats'])?'<span class="icon-font fright">arrow_right</span>':null;?></a>
												<?if(!empty($l2['subcats'])){?>
													<div class="third_menu <?=count($l2['subcats']) > count($l1['subcats'])?' two':' one';?>-columned">
														<div class="third_menu_scroll">
															<ul id="cat_<?=$l2['id_category']?>" class="second_submenu<?=$l2['id_category'] == $curcat['pid']?' active':null;?>">
																<?foreach($l2['subcats'] as $k=>$l3){?>
																	<li>
																		<a class="a3<?=isset($GLOBALS['CURRENT_ID_CATEGORY']) && $l3['id_category'] == $GLOBALS['CURRENT_ID_CATEGORY']?' active':null;?>" href="<?=Link::Category($l3['translit']);?>"><span><?=$l3['name']?></span></a>
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