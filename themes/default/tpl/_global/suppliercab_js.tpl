<script type="text/javascript">
	$(function(){
		    jQuery('.input_text input, .input_search input')
	 .bind('focus', Function("if(this.value==this.defaultValue) this.value=''"))
	  .bind('blur', Function("if(this.value=='') this.value=this.defaultValue"));


	    var tabContainers = $('div.tabs > div');
	    	    	tabContainers.hide().filter(':eq(<?=$_SESSION['ActiveTab']?>)').show();

	$('div.tabs ul.tabNavigation a').click(function () {

	if ($(this).attr('href')=="#first")
			$.post(URL_base+'ajaxmain', { action:"switchtab", activetab: "0"} );
				else
				$.post(URL_base+'ajaxmain', { action:"switchtab", activetab: "1"} );

			    tabContainers.hide();
		tabContainers.filter(this.hash).show();
		$('div.tabs ul.tabNavigation a').removeClass('selected');
		$(this).addClass('selected');
		$(this).parent().parent().addClass('tabNavigation2');
		return false;
		    });
		});

	      $(window).scroll(function(){
	    	var posnow=$(window).scrollTop();
			var header=$("#header").height()+ 130;
			var frst=$("#first").css('display');
			if(frst=='block'){
			var size=$("#first").height()+$("#header").height()-$(".fixed_box").height()-160;
			}else{
			var size=$("#second").height()+$("#header").height()-$(".fixed_box").height()-160;
			}
			if(posnow>header){
			if(size>header){
				if(posnow>size){
				$('.fixed_item, .tabNavigation, .advanced_search, .search_big').removeClass('fix');
				$('.advanced_search').addClass('rel').width($(".cabinet").width());
				$('.fixed_item').addClass('rel').width($(".tabs").width()-27);
				$('.tabNavigation, .search_big').addClass('rel');
				$('.advanced_search').css('top',size);
				$('.search_big').css('top',size+38);
				$('.fixed_item, .tabNavigation').css('top',size-315);
				}else{
				if(posnow>header){
					$('.catable').css('margin-top',0);
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
					$('.catable').css('margin-top',0);
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
	</script>
