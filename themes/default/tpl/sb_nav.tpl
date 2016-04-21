<div class="catalog">
	<ul class="main_nav">
		<li id="estimate" data-name="estimateLoad" class="btn_js <?=(isset($_COOKIE['Segmentation']) && $_COOKIE['Segmentation'] == 2)?'activeSegment':null;?>" data-nav="estimate">
			<i class="material-icons">assignment</i>Загрузить свою смету
			<label class="info_key">?</label>
			<div class="info_description">
				<p>Вы можете загрузить свою смету.</p>
			</div>
		</li>
		<li id="organization" class="<?=(isset($_COOKIE['Segmentation']) && $_COOKIE['Segmentation'] == 1)?'activeSegment':null;?>" data-nav="organization">
			<i class="material-icons">work</i>Для организаций
			<label class="info_key">?</label>
			<div class="info_description">
				<p>Поле для ввода примечания к товару.</p>
			</div>
		</li>
		<li id="store" class="<?=(isset($_COOKIE['Segmentation']) && $_COOKIE['Segmentation'] == 2)?'activeSegment':null;?>" data-nav="store">
			<i class="material-icons">store</i>Для магазинов
			<label class="info_key">?</label>
			<div class="info_description">
				<p>Поле для ввода примечания к товару.</p>
			</div>
		</li>
		<li id="allSection" class="<?=(isset($_COOKIE['Segmentation']) && $_COOKIE['Segmentation'] == 0)?'activeSegment':'active';?>" data-nav="all_section">
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
		if ($.cookie('Segmentation') != 1){
			$(".main_nav li").removeClass('activeSegment');
			$("#organization").addClass('activeSegment');
			addLoadAnimation('.catalog');
			ajax('segment', 'segments', {type: 1}, 'html').done(function(data){
				removeLoadAnimation('.catalog');
				console.log(data);
				$(".second_nav").addClass('hidden');
				$("#segmentNavOrg").append(data);
			});
		}
	})

	$("#store").click(function() {
		if ($.cookie('Segmentation') != 2){
			$(".main_nav li").removeClass('activeSegment');
			$("#store").addClass('activeSegment');
			addLoadAnimation('.catalog');
			ajax('segment', 'segments', {type: 2}, 'html').done(function(data){
				removeLoadAnimation('.catalog');
				console.log(data);
				$(".second_nav").addClass('hidden');
				$("#segmentNavStore").append(data);
			});
		}
	})

	$("#allSection").click(function() {
		if ($.cookie('Segmentation') != 0){
			$(".main_nav li").removeClass('activeSegment');
			$("#allSection").addClass('activeSegment');
			addLoadAnimation('.catalog');
			ajax('segment', 'segments', {type: 0}, 'html').done(function(data){
				removeLoadAnimation('.catalog');
				console.log('все секции');
				$(".second_nav").addClass('hidden');
				/*$(".allSections").removeClass('hidden');*/
				$("#allCategotyCont").append(data);
			});
		}
	})
;});
</script>