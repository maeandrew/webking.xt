<script type="text/javascript">
$(function(){
	var tabContainers = $('div.tabs > div');
	tabContainers.hide().filter(':eq(<?=$_SESSION['ActiveTab']?>)').show();
	$('div.tabs ul.tabNavigation a').click(function () {
		if($(this).attr('href')=="#first"){
			$.post(
				URL_base+'ajaxmain',
				{
					action:"switchtab",
					activetab: "0"
				}
			);
		}else{
			$.post(
				URL_base+'ajaxmain',
				{
					action:"switchtab",
					activetab: "1"
				}
			);
		}
		tabContainers.hide();
		tabContainers.filter(this.hash).show();
		$('div.tabs ul.tabNavigation a').removeClass('selected');
		$(this).addClass('selected');
		$(this).parent().parent().addClass('tabNavigation2');
		return false;
	});
	$(".error, .done").click(function(){
		$(this).parent().parent().find('.edit_box').fadeToggle();
		return false;
	});
});
$(window).scroll(function(){
	var posnow = $(window).scrollTop();
	var header = $("#header").height()+ 20;
	//var catalog=$("#first").height()-475;
	//var size=catalog+header-$(".fixed_box").height()-373;
	var frst = $("#first").css('display');
	if(frst == 'block'){
		var size = $("#first").height()+$("#header").height()-$(".fixed_box").height()-270;
	}else{
		var size = $("#second").height()+$("#header").height()-$(".fixed_box").height()-270;
	}
	if(posnow > header){
		if(size > header){
			if(posnow > size){
				$('.fixed_item, .tabNavigation, .advanced_search, .search_big').removeClass('fix');
				$('.advanced_search').addClass('rel').width($(".cabinet").width());
				$('.fixed_item').addClass('rel').width($(".tabs").width()-27);
				$('.tabNavigation, .search_big').addClass('rel');
				$('.advanced_search').css('top',size);
				$('.search_big').css('top',size+38);
				$('.fixed_item, .tabNavigation').css('top',size-200);
			}else{
				if(posnow > header){
					$('.advanced_search, .fixed_item, .tabNavigation, .search_big').removeClass('rel');
					$('.advanced_search').css('top','0');
					$('.fixed_item').css('top',0);
					$('.tabNavigation').css('top',48);
					$('.search_big').css('top',35);
					$('.tabNavigation, .search_big').addClass('fix');
					$('.fixed_item').addClass('fix').width($(".tabs").width()-27);
					$('.advanced_search').addClass('fix').width($(".cabinet").width());
				}else{
					$('.advanced_search, .fixed_item, .tabNavigation, .search_big').removeClass('fix');
					$('.advanced_search, .fixed_item, .tabNavigation, .search_big').removeClass('rel');
					$('.search_big').css('top',241);
				}
			}
		}else{
			$('.advanced_search, .fixed_item, .tabNavigation, .search_big').removeClass('fix');
			$('.advanced_search, .fixed_item, .tabNavigation, .search_big').removeClass('rel');
			$('.search_big').css('top',241);
			$('.catable').css('margin-top',0);
		}
	}else{
		$('.advanced_search, .fixed_item, .tabNavigation, .search_big').removeClass('fix');
		$('.advanced_search, .fixed_item, .tabNavigation, .search_big').removeClass('rel');
		$('.search_big').css('top',241);
		$('.catable').css('margin-top',0);
	}
});
$(function(){
	$("#datepicker").datepicker({
		dayName: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
		dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
		monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
		monthNamesShort: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
		firstDay: 1,
		showOn: "button",
		buttonImage: "<?=_base_url?>/images/calendar.png",
		minDate: "+<?=$GLOBALS['CONFIG']['order_day_start']?>d",
		maxDate: "+<?=$GLOBALS['CONFIG']['order_day_end']?>d",
		dateFormat: "dd.mm.yy",
		buttonImageOnly: true
	});
});
</script>