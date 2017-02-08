<div class="catalog">
	<div class="label"><?=$sbheader?></div>
	<div class="navbar_js navigation_container"><div>
	<?if($GLOBALS['CurrentController'] != 'main' && in_array($GLOBALS['CurrentController'], array('main', 'products'))){?>
			<li data-nav="filter" class="activeFilters_js">
				<i class="material-icons">filter_list</i>
				<span>
					<span class="title">Фильтры</span>
					<span class="included_filters"><? if(isset($cnt) && $cnt > 0) echo "($cnt)";?></span>
				</span>
			</li>
		<?}?>
	<div id="segmentNavOrg"></div>
	<div id="segmentNavStore"></div>
	<div id="allCategotyCont"></div>
</div>

<script>
$(function(){
	if ($('.second_nav li').hasClass('active')) {
		$('.second_nav').find('li.active > .link_wrapp > .more_cat i').html('remove');
	}

	$("#organization").click(function() {
		if (!$(this).hasClass('activeSegment')) {
			$('.main_nav li[data-nav="filter"]').addClass('hidden');
			$('.filters').fadeOut();
		}
		if ($.cookie('Segmentation') != 1){
			$(".main_nav li").removeClass('activeSegment');
			$("#organization").addClass('activeSegment');
			addLoadAnimation('.catalog');
			ajax('segment', 'segments', {type: 1}, 'html').done(function(data){
				removeLoadAnimation('.catalog');
				$(".second_nav").addClass('hidden');
				$("#segmentNavOrg").append(data);
			});
		}
	});

	$("#store").click(function() {
		if (!$(this).hasClass('activeSegment')) {
			$('.main_nav li[data-nav="filter"]').addClass('hidden');
			$('.filters').fadeOut();
		}
		if ($.cookie('Segmentation') != 2){
			$(".main_nav li").removeClass('activeSegment');
			$("#store").addClass('activeSegment');
			addLoadAnimation('.catalog');
			ajax('segment', 'segments', {type: 2}, 'html').done(function(data){
				removeLoadAnimation('.catalog');
				$(".second_nav").addClass('hidden');
				$("#segmentNavStore").append(data);
			});
		}
	});

	$("#allSection").click(function() {
		if (!$(this).hasClass('activeSegment')) {
			$('.main_nav li[data-nav="filter"]').addClass('hidden');
			$('.filters').fadeOut();
			$('.filters').fadeOut();
		}
		if ($.cookie('Segmentation') !== 0){
			$(".main_nav li").removeClass('activeSegment');
			$("#allSection").addClass('activeSegment');
			addLoadAnimation('.catalog');
			ajax('segment', 'segments', {type: 0}, 'html').done(function(data){
				removeLoadAnimation('.catalog');
				$(".second_nav").addClass('hidden');
				/*$(".allSections").removeClass('hidden');*/
				$("#allCategotyCont").append(data);
			});
		}
	});
});
</script>