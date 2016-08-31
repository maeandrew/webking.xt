<div class="catalog_btn btn_js" data-name="catalog">Каталог</div>
<?if(!empty($list)){?>
	<div class="content_header clearfix">
		<div class="sort imit_select">
			<span>Сортировать:</span>
			<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
				<select id="sorting" name="sorting" class="mdl-selectfield__select sorting_js" onChange="SortProductsList($(this));">
					<?foreach($available_sorting_values as $key => $alias){ ?>
						<option <?=isset($GLOBALS['Sort']) && $GLOBALS['Sort'] == $key?'selected':null;?> value="<?=!isset($GLOBALS['Rewrite'])?Link::Custom($GLOBALS['CurrentController'], null, array('sort' => $key)):Link::Category($GLOBALS['Rewrite'], array('sort' => $key));?>"><?=$alias?></option>
					<?}?>
				</select>
			</div>
			<!-- <a href="#" class="graph_up hidden"><i class="material-icons">timeline</i></a> -->
			<!-- 	<?if(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 0){?>
					<a href="#" class="show_demand_chart_js one"><i class="material-icons">timeline</i></a>
				<?}elseif(isset($_SESSION['member']) && $_SESSION['member']['gid'] == 1){?>
					<a href="#" class="show_demand_chart_js two"><i class="material-icons">timeline</i></a>
				<?}?>	 -->
		</div>
		product_list
		<div class="productsListView">
			<i id="changeToList" class="material-icons changeView_js <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'list' ? 'activeView' : NULL?>" data-view="list">view_list</i>
			<span class="mdl-tooltip" for="changeToList">Вид списком</span>
			<i id="changeToBlock" class="material-icons changeView_js <?=!isset($_COOKIE['product_view']) || $_COOKIE['product_view'] == 'block' ? 'activeView' : NULL?>" data-view="block">view_module</i>
			<span class="mdl-tooltip" for="changeToBlock">Вид блоками</span>
			<i id="changeToColumn" class="material-icons changeView_js hidden <?=isset($_COOKIE['product_view']) && $_COOKIE['product_view'] == 'column' ? 'activeView' : NULL?>" data-view="column">view_column</i>
			<span class="mdl-tooltip" for="changeToColumn">Вид колонками</span>
		</div>
		<div class="catalog_btn btn_js mdl-cell--hide-desktop" data-name="catalog">Каталог</div>
	</div>
<?}?>
<div class="clearBoth"></div>
<div class="products">
	<?=$products_list;?>
</div>
