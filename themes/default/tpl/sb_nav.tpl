<div class="catalog">
	<ul class="main_nav">
		<li data-nav="organization">
			<i class="material-icons">work</i>Для организаций
			<label class="info_key">?</label>
			<div class="info_description">
				<p>Поле для ввода примечания к товару.</p>
			</div>
		</li>
		<li data-nav="store">
			<i class="material-icons">store</i>Для магазинов
			<label class="info_key">?</label>
			<div class="info_description">
				<p>Поле для ввода примечания к товару.</p>
			</div>
		</li>
		<li class="active" data-nav="all_section">
			<i class="material-icons">list</i>Все разделы
			<label class="info_key">?</label>
			<div class="info_description">
				<p>Поле для ввода примечания к товару.</p>
			</div>
		</li>
		<li data-nav="filter"><i class="material-icons">filter_list</i><span class="title">Фильтры</span><span class="included_filters">(активно 10)</span></li>
	</ul>
	<?if(isset($sbheader) && isset($navigation)){?>
		<ul class="second_nav" data-lvl="1">
			<li>
				<span class="link_wrapp">
					<a href="<?=Link::Category('NOVINKI-KATALOGA');?>">Новинки каталога</a>
				</span>
			</li>
			<?foreach($navigation as $l1){?>
				<li class="<?=$l1['id_category']==$GLOBALS['CURRENT_ID_CATEGORY']?'active':'';?>">
					<span class="link_wrapp">
						<a href="<?=Link::Category($l1['translit']);?>">
							<style type="text/css" media="screen">a {color: #000;}</style>
							<?=$l1['name']?>
						</a>
						<?if(!empty($l1['subcats'])){?><span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span><?}?>
					</span>
					<?if(!empty($l1['subcats'])){?>
						<ul data-lvl="2">
							<?foreach($l1['subcats'] as $l2){?>
								<li>
									<span class="link_wrapp">
										<a href="<?=Link::Category($l2['translit']);?>"><?=$l2['name'];?></a>
										<?if(!empty($l2['subcats'])){?><span class="more_cat"><i class="material-icons">keyboard_arrow_right</i></span><?}?>
									</span>
									<?if(!empty($l2['subcats'])){?>
										<ul data-lvl="3">
											<?foreach($l2['subcats'] as $l3){?>
												<li>
													<span class="link_wrapp">
														<a href="<?=Link::Category($l3['translit']);?>"><?=$l3['name']?></a><span class="qnt_products">323</span>
													</span>
												</li>
											<?}?>
										</ul>
									<?}?>
								</li>
							<?}?>
						</ul>
					<?}?>
				</li>
			<?}?>
		</ul>
	<?}?>
</div>