<div class="catalog">
	<ul class="main_nav">
		<li id="organization" data-nav="organization">
			<i class="material-icons">work</i>Для организаций
			<label class="info_key">?</label>
			<div class="info_description">
				<p>Поле для ввода примечания к товару.</p>
			</div>
		</li>
		<li id="store" data-nav="store">
			<i class="material-icons">store</i>Для магазинов
			<label class="info_key">?</label>
			<div class="info_description">
				<p>Поле для ввода примечания к товару.</p>
			</div>
		</li>
		<li id="allSection" class="active" data-nav="all_section">
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
	<div id="segmentNavOrg"></div>
	<div id="segmentNavStore"></div>
	<div id="allCategotyCont"></div>
</div>

<script>
$(function(){
	$("#organization").click(function() {
		addLoadAnimation('.catalog');
		ajax('segment', 'segments', {type: 1}, 'html').done(function(data){
			removeLoadAnimation('.catalog');
			console.log(data);
			$(".second_nav").addClass('hidden');
			$("#segmentNavOrg").append(data);
		});
	})

	$("#store").click(function() {
		addLoadAnimation('.catalog');
		ajax('segment', 'segments', {type: 2}, 'html').done(function(data){
			removeLoadAnimation('.catalog');
			console.log(data);
			$(".second_nav").addClass('hidden');
			$("#segmentNavStore").append(data);
		});
	})

	$("#allSection").click(function() {
		addLoadAnimation('.catalog');
		ajax('segment', 'segments', {type: 0}, 'html').done(function(data){
			removeLoadAnimation('.catalog');
			console.log('все секции');
			$(".second_nav").addClass('hidden');
			/*$(".allSections").removeClass('hidden');*/
			$("#allCategotyCont").append(data);

		});
	})
;});
</script>