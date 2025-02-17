<h1><?=$h1?></h1>
<br>
<?if (isset($errm) && isset($msg)){?>
<div class="notification error">
<span class="strong">Ошибка!</span><?=$msg?>
</div>
<br>
<?}elseif(isset($msg)){?>
<div class="notification success">
<span class="strong">Сделано!</span><?=$msg?>
</div>
<br>
<?}?>
<button class="all_slide_down btn-m-green">Развернуть все</button>
<button class="all_slide_up btn-m-orange">Свернуть все</button>
<div class="legend fr">
	<p>
		<span class="icon-font addprod">a</span> — добавить товар в категорию
		<span class="icon-font editcat">e</span> — редактировать
		<span class="icon-font addsubcat">A</span> — добавить подкатегорию
		<span class="icon-font delcat">t</span> — удалить категорию
		<span class="icon-font lockcat">v</span> — посмотреть на сайте
	</p>
</div>
<div class="cat_head">
	<ul>
		<li class="icon-font draggable">s</li>
		<li class="prom_id">Prom ID</li>
		<li class="section_name">Название раздела</li>
		<li class="fr controlls">Управление</li>
	</ul>
</div>
<div class="wrapp">
	<ul class="main_cat">
		<?foreach($cat_arr as $l1){?>
			<li class="lev1 clearfix" id="item_<?=$l1['id_category']?>">
				<div class="icon-font hndlr1 fl">m</div>
				<div class="switch_slide fl">
					<?if(!empty($l1['subcats'])){?>
						<span class="switch_plus"></span>
					<?}?>
				</div>
				<div class="fl">
					<span class="prom_id"><?=$l1['prom_id']?></span>
					<?=!$l1['visible']?'<span class="invisible">(скрытая) </span>':null?>
					<a href="<?=$GLOBALS['URL_base'].'adm/products/'.$l1['id_category']?>"><?=$l1['name']?></a>
				</div>
				<div class="controls fr">
					<a class="icon-font addprod" title="Добавить товар" href="/adm/productadd/<?=$l1['id_category']?>">a</a>
					<a class="icon-font editcat" title="Редактировать категорию" href="/adm/catedit/<?=$l1['id_category']?>">e</a>
					<a class="icon-font addsubcat" title="Добавить подкатегорию" href="/adm/catadd/<?=$l1['id_category']?>">A</a>
					<a class="icon-font delcat" title="Удалить категорию" href="/adm/catdel/<?=$l1['id_category']?>">t</a>
					<a class="icon-font lockcat" title="Посмотреть категорию на сайте" href="/<?=$l1['translit']?>">v</a>
				</div>
				<?if(!empty($l1['subcats'])){?>
					<ul id="cat_<?=$l1['id_category']?>" class="first_submenu">
						<?foreach($l1['subcats'] as $l2){?>
							<li class="lev2 clearfix" id="item_<?=$l2['id_category']?>">
								<div class="icon-font hndlr2 fl">m</div>
								<div class="switch_slide fl">
									<?if(!empty($l2['subcats'])){?>
										<span class="switch_plus"></span>
									<?}?>
								</div>
								<div class="fl">
									<span class="prom_id"><?=$l2['prom_id']?></span>
									<?=!$l2['visible']?'<span class="invisible">(скрытая) </span>':null?>
									<a href="<?=$GLOBALS['URL_base'].'adm/products/'.$l2['id_category']?>"><?=$l2['name']?></a>
								</div>
								<div class="controls fr">
									<a class="icon-font addprod" title="Добавить товар" href="/adm/productadd/<?=$l2['id_category']?>">a</a>
									<a class="icon-font editcat" title="Редактировать категорию" href="/adm/catedit/<?=$l2['id_category']?>">e</a>
									<a class="icon-font addsubcat" title="Добавить подкатегорию" href="/adm/catadd/<?=$l2['id_category']?>">A</a>
									<a class="icon-font delcat" title="Удалить категорию" href="/adm/catdel/<?=$l2['id_category']?>">t</a>
									<a class="icon-font lockcat" title="Посмотреть категорию на сайте" href="/<?=$l2['translit']?>">v</a>
								</div>
								<?if(!empty($l2['subcats'])){?>
									<ul id="cat_<?=$l2['id_category']?>" class="second_submenu">
										<?foreach($l2['subcats'] as $k=>$l3){?>
											<li class="lev3 clearfix" id="item_<?=$l3['id_category']?>">
												<div class="icon-font hndlr3 fl">m</div>
												<div class="switch_slide fl">
													<?if(!empty($l3['subcats'])){?>
														<span class="switch_plus"></span>
													<?}?>
												</div>
												<div class="fl">
													<span class="prom_id"><?=$l3['prom_id']?></span>
													<?=!$l3['visible']?'<span class="invisible">(скрытая) </span>':null?>
													<a href="<?=$GLOBALS['URL_base'].'adm/products/'.$l3['id_category']?>"><?=$l3['name']?></a>
												</div>
												<div class="controls fr">
													<a class="icon-font addprod" title="Добавить товар" href="/adm/productadd/<?=$l3['id_category']?>">a</a>
													<a class="icon-font editcat" title="Редактировать категорию" href="/adm/catedit/<?=$l3['id_category']?>">e</a>
													<a class="icon-font addsubcat" title="Добавить подкатегорию" href="/adm/catadd/<?=$l3['id_category']?>">A</a>
													<a class="icon-font delcat" title="Удалить категорию" href="/adm/catdel/<?=$l3['id_category']?>">t</a>
													<a class="icon-font lockcat" title="Посмотреть категорию на сайте" href="/<?=$l3['translit']?>">v</a>
												</div>
												<?if(!empty($l3['subcats'])){?>
													<ul id="cat_<?=$l3['id_category']?>" class="second_submenu">
														<?foreach($l3['subcats'] as $k=>$l4){?>
															<li class="lev3 clearfix" id="item_<?=$l4['id_category']?>">
																<div class="icon-font hndlr3 fl">m</div>
																<div class="fl">
																	<span class="prom_id"><?=$l4['prom_id']?></span>
																	<?=!$l4['visible']?'<span class="invisible">(скрытая) </span>':null?>
																	<a href="<?=$GLOBALS['URL_base'].'adm/products/'.$l4['id_category']?>"><?=$l4['name']?></a>
																</div>
																<div class="controls fr">
																	<a class="icon-font addprod" title="Добавить товар" href="/adm/productadd/<?=$l4['id_category']?>">a</a>
																	<a class="icon-font editcat" title="Редактировать категорию" href="/adm/catedit/<?=$l4['id_category']?>">e</a>
																	<a class="icon-font addsubcat" title="Добавить подкатегорию" href="/adm/catadd/<?=$l4['id_category']?>">A</a>
																	<a class="icon-font delcat" title="Удалить категорию" href="/adm/catdel/<?=$l4['id_category']?>">t</a>
																	<a class="icon-font lockcat" title="Посмотреть категорию на сайте" href="/<?=$l4['translit']?>">v</a>
																</div>
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
			</li>
		<?}?>
	</ul>
</div>
<script type="text/javascript">
	$(function(){
		$("ul.main_cat").sortable({
			items: ".lev1",
			cursor: "move",
			placeholder:"placeh ui-state-highlight",
			handle:'.hndlr1',
			update: function (event, ui){
				var order = $(this).sortable('serialize');
				SendCatOrder(order);
				ui.item.addClass('dragged');
			}
		});
		$("ul.first_submenu" ).sortable({
			items: ".lev2",
			axis: "y",
			cursor: "move",
			placeholder:"placeh ui-state-highlight",
			handle:'.hndlr2',
			update: function (event, ui){
				var order = $(this).sortable('serialize');
				SendCatOrder(order);
				ui.item.addClass('dragged');
			}
		});
		$("ul.second_submenu" ).sortable({
			items: ".lev3",
			axis: "y",
			cursor: "move",
			placeholder:"placeh ui-state-highlight",
			handle:'.hndlr3',
			update: function (event, ui){
				var order = $(this).sortable('serialize');
				SendCatOrder(order);
				ui.item.addClass('dragged');
			}
		});
		$('.switch_slide span').on('click', function(){
			$(this).closest('li[id^="item_"]').children('ul[id^="cat_"]').stop(true,true).slideToggle();
			$(this).toggleClass('switch_minus');
		});
		//Развернуть все категории
		$('.all_slide_down').on('click', function(){
			$('ul[id^="cat_"]').slideDown();
			$('.switch_slide span').addClass('switch_minus');
		});
		//Свернуть все категории
		$('.all_slide_up').on('click', function(){
			$('ul[id^="cat_"]').slideUp();
			$('.switch_slide span').removeClass('switch_minus');
		});
	});
</script>