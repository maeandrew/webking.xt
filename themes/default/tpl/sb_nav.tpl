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
		<?if($GLOBALS['CurrentController'] != 'main' && in_array($GLOBALS['CurrentController'], array('main', 'products'))){?>
			<li data-nav="filter">
				<i class="material-icons">filter_list</i>
				<span>
					<span class="title">Фильтры</span>
					<span class="included_filters"><? if(isset($cnt) && $cnt > 0) echo "($cnt)";?></span>
				</span>
			</li>
		<?}?>
	</ul>
	<?if(isset($sbheader) && isset($nav)){?>
		<?=$nav;?>
	<?}?>
</div>