<div class="catalog_btn btn_js" data-name="catalog">Каталог</div>
<?if(!empty($list)){?>
	<!-- <div class="sorting">
		
		<?if(!isset($_GET['search_in_cat'])){?>
			<form action="" method="POST">
				<?if(in_array('sorting', $list_controls)){?>
					<label for="sort_prod">Сортировка</label>
					<select id="sort_prod" name="value" data-role="none" onchange="$(this).closest('form').submit();">
						<?foreach($available_sorting_values as $key => $alias){?>
							<option value="<?=$key?>" <?=isset($sorting['value']) && $sorting['value'] == $key?'selected="selected"':null;?>><?=$alias?></option>
						<?}?>
					</select>
					<select name="direction" data-role="none" class="hidden" onchange="$(this).closest('form').submit();">
						<option value="asc" <?=isset($sorting['direction']) && $sorting['direction'] == 'asc'?'selected="selected"':null;?>>по возрастанию</option>
						<option value="desc" <?=isset($sorting['direction']) && $sorting['direction'] == 'desc'?'selected="selected"':null;?>>по убыванию</option>
					</select>
				<?}?>
			</form>
		<?}?>
	</div> -->
	<div class="sort imit_select">
		<button id="sort-lower-left" class="mdl-button mdl-js-button">
			<i class="material-icons fleft">keyboard_arrow_down</i><span class="selected_sort select_fild"><?= $available_sorting_values[$sorting['value']]?></span>
		</button>

		<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="sort-lower-left">
			<?foreach($available_sorting_values as $key => $alias){ ?>
				<a href="<?=Link::Category($GLOBALS['Rewrite'], array('sort' => $key))?>">
					<li class="mdl-menu__item sort <?=isset($sorting['value']) && $sorting['value'] == $key ? 'active' : NULL ?>" data-value="<?=$key?>" >
						<?=$alias?>
					</li>
				</a>
			<?}?>
		</ul>

		<!-- <a href="#" class="graph_up hidden"><i class="material-icons">timeline</i></a> -->
		<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 0){?>
			<a href="#" class="xgraph_up one"><i class="material-icons">timeline</i></a>
		<?}elseif(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1){?>
			<a href="#" class="xgraph_up two"><i class="material-icons">timeline</i></a>
		<?}?>
	</div>
<?}?>
<div class="separateBlocks"></div>
<div class="products">
	<?=$products_list;?>
</div>
<!-- <div class="products">
	<div class="card card_wrapper clearfix">
		<div class="product_photo card_item">Фото товара</div>
		<p class="product_name card_item">Наименование товара</p>
		<div class="suplierPriceBlock headerPriceBlock">
			<div class="price card_item">Цена<br>за еденицу товара</div>
			<div class="count_cell card_item">Минимальное<br>количество</div>
			<div class="count_cell card_item">Кол-во<br>в ящике</div>
			<div class="product_check card_item">Добавить в<br>ассортимент</div>
		</div>
	</div>
	тут был блок из supplier_products_list.tpl	
</div> -->