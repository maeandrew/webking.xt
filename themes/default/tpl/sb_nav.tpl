<div class="catalog<?=!in_array($GLOBALS['CurrentController'], array('search'))?' expanded':null;?>">
	<div class="label"><?=$sbheader?><i class="material-icons">&#xE315;</i></div>
	<div class="navbar_js navigation_container"></div>
</div>
<?if($GLOBALS['CurrentController'] == 'search'){?>
	<div class="searchnav_js navigation_container search_navigation"></div>
<?}?>







<script>
$(function(){
	// if ($('.second_nav li').hasClass('active')) {
	// 	$('.second_nav').find('li.active > .link_wrap > .more_cat i').html('remove');
	// }

	// $("#organization").click(function() {
	// 	if (!$(this).hasClass('activeSegment')) {
	// 		$('.main_nav li[data-nav="filter"]').addClass('hidden');
	// 		$('.filters').fadeOut();
	// 	}
	// 	if ($.cookie('Segmentation') != 1){
	// 		$(".main_nav li").removeClass('activeSegment');
	// 		$("#organization").addClass('activeSegment');
	// 		addLoadAnimation('.catalog');
	// 		ajax('segment', 'segments', {type: 1}, 'html').done(function(data){
	// 			removeLoadAnimation('.catalog');
	// 			$(".second_nav").addClass('hidden');
	// 			$("#segmentNavOrg").append(data);
	// 		});
	// 	}
	// });

	// $("#store").click(function() {
	// 	if (!$(this).hasClass('activeSegment')) {
	// 		$('.main_nav li[data-nav="filter"]').addClass('hidden');
	// 		$('.filters').fadeOut();
	// 	}
	// 	if ($.cookie('Segmentation') != 2){
	// 		$(".main_nav li").removeClass('activeSegment');
	// 		$("#store").addClass('activeSegment');
	// 		addLoadAnimation('.catalog');
	// 		ajax('segment', 'segments', {type: 2}, 'html').done(function(data){
	// 			removeLoadAnimation('.catalog');
	// 			$(".second_nav").addClass('hidden');
	// 			$("#segmentNavStore").append(data);
	// 		});
	// 	}
	// });

	// $("#allSection").click(function() {
	// 	if (!$(this).hasClass('activeSegment')) {
	// 		$('.main_nav li[data-nav="filter"]').addClass('hidden');
	// 		$('.filters').fadeOut();
	// 		$('.filters').fadeOut();
	// 	}
	// 	if ($.cookie('Segmentation') !== 0){
	// 		$(".main_nav li").removeClass('activeSegment');
	// 		$("#allSection").addClass('activeSegment');
	// 		addLoadAnimation('.catalog');
	// 		ajax('segment', 'segments', {type: 0}, 'html').done(function(data){
	// 			removeLoadAnimation('.catalog');
	// 			$(".second_nav").addClass('hidden');
	// 			/*$(".allSections").removeClass('hidden');*/
	// 			$("#allCategotyCont").append(data);
	// 		});
	// 	}
	// });
});
</script>
