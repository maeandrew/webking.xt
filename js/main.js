$(window).load(function(){
	setTimeout(function(){
		$("#loading").fadeOut("slow", function(){
			$('#page').show();
			$(this).remove();
		})
	}, 300);
	// $('.text_wrapper a').hover(function(){
	// 	var id = $(this).attr('class').replace(/^\D+/g, '');
	// 	window.onmousemove = function(event) {
	// 		event = event || window.event; // IE-ism
	// 		var xPos = event.clientX;
	// 		var yPos = event.clientY;
	// 		// event.clientX and event.clientY contain the mouse position
	// 		$('.hidden_popup_descr').css({
	// 			"position": "fixed",
	// 			"left": event.clientX-200,
	// 			"top": event.clientY+20
	// 		});
	// 	}
	// 	$('.p'+id+' .hidden_popup_descr').stop(true,true).animate({
	// 		opacity: 1
	// 	}, 200);
	// },function(){
	// 	var id = $(this).attr('class').replace( /^\D+/g, '');
	// 	$('.p'+id+' .hidden_popup_descr').stop(true,true).animate({
	// 		opacity: 0
	// 	}, 200);
	// });

	// $("#kalendar").bind("click", function(){
	// 	$("#kalendar_bg").fadeToggle("slow");
	// 	$("#kalendar_content").fadeToggle("slow");
	// 	$("#overlay").fadeToggle("slow");
	// });

	// $("#close").bind("click", function(e){
	// 	e.preventDefault();
	// 	$("#kalendar_bg").fadeOut("slow");
	// 	$("#kalendar_content").fadeOut("slow");
	// });

	$("#search_content").bind("click", function(){
		$("#search_all").fadeToggle("slow");
		$("#proizv").selectbox();
		$("#kategor").selectbox();
	});

		$("#switcher").click(function(){
		if($(this).attr("value") == "Все"){
			hide_unselected();
			$(this).attr("value", "Отмеченные");
		}else{
			show_unselected();
			$(this).attr("value", "Все");
		}
	});

	$(".table_row").hover(function(){
		if($(this).hasClass("emp_row")){
			$(this).css("background-color", "#ff0");
		}else{
			$(this).css("background-color", "#eee");
		}
	},function(){
		if($(this).hasClass("emp_row")){
			$(this).css("background-color", "#ff0");
		}else{
			$(this).css("background-color", "#fff");
		}
	});

	$(".table_row").click(function(){
		var id = $(this).attr("id");
		var chb = $("#chbox_"+id);

		if(chb.prop("checked")!==true){
			chb.prop("checked", true);
			$(this).addClass("emp_row").css("background-color","#ff0");
		}else{
			chb.prop("checked", false);
			$(this).removeClass("emp_row").css("background-color","#fff");
		}
	});

	$(".table_row").each(function(){
		var id = $(this).attr("id");
		var chb = $("#chbox_"+id);

		if(chb.prop("checked")==true){
			$(this).addClass("emp_row");
		}
	});

	/** Анимация прокручивания кнопки наверх */

	var pos = getScrollWindow();
	changeToTop(pos);
	$(window).scroll(function(){
		pos = getScrollWindow();
		changeToTop(pos);
	});
	$('#toTop').click(function () {
		$('html, body').animate({
			scrollTop: 0
		}, 1000, "easeInOutCubic");
	});

	/** Анимация поля примечания в каталоге */
	// $('#cat_table td.cat_note form textarea').focus(function(){
	// 	$(this).animate({
	// 	"width":"210px",
	// 	"z-index":"1000",
	// 	"right" : "0"
	// 	},500);
	// }).blur(function(){
	// 	$(this).animate({
	// 	"width":"100%",
	// 	"height":"50px",
	// 	"z-index":"100",
	// 	"right" : "0"
	// 	},500);
	// 	if($(this).val() != ''){
	// 		$(this).css("color","red");
	// 	}
	// 	else {
	// 		$(this).css("color","black");
	// 	}
	// }).each(function(){
	// 	if($(this).val() != ''){
	// 		$(this).css("color","red");
	// 	}
	// 	else {
	// 		$(this).css("color","black");
	// 	}
	// });

	/** Анимация поля примечания в корзине */
	// $('#cart_table td.cat_note form textarea').focus(function(){
	// 	$(this).animate({
	// 	"width":"200px"
	// 	},500);
	// }).blur(function(){
	// 	$(this).animate({
	// 	"width":"100%",
	// 	"height":"50px"
	// 	},500);
	// 	if($(this).val() != ''){
	// 		$(this).css("color","red");
	// 	}
	// 	else {
	// 		$(this).css("color","black");
	// 	}
	// }).each(function(){
	// 	if($(this).val() != ''){
	// 		$(this).css("color","red");
	// 	}
	// 	else {
	// 		$(this).css("color","black");
	// 	}
	// });

	/** Выбор режима отображение цен */
	$('label[for*="info-key"]').hover(function(){
		var key = $(this).prop('for').replace(/^\D+/g, '');
		$('.info-'+key).stop(true,true).delay(300).animate({
			"top": "100%",
			"opacity": "1",
			"z-index": "100"
		});
		$(this).css({
			"z-index": "110"
		});
	},function(){
		var key = $(this).prop('for').replace(/^\D+/g, '');
		$('.info-'+key).stop(true,true).animate({
			"top": "100px",
			"opacity": "0",
			"z-index": "-100"
		});
		$(this).css({
			"z-index": "1"
		});
	});

	/** Очистка строки поиска при фокусе */
	$('input#search').focus(function(){
		query = $(this).val();
		c2s = $('#category2search').val();
		$.ajax({
			url: URL_base+'ajaxsearch',
			type: "POST",
			dataType : "json",
			data:({
				"action": 'search',
				"category2search": c2s,
				"query": query
			}),
		}).done(function(data){
			if(data != null && data.length > 0){
				$('ul.autocomplete').find('li').remove();
				for(var i = 0; i < data.length; i++){
					if(data[i]['image'] == null){
						$('ul.autocomplete').append('<li class="result_item"><a href="'+URL_base+'product/'+data[i]['id_product']+'/'+data[i]['translit']+'" class="animate"><img alt="'+data[i]['name']+'" src="'+data[i]['img_1'].replace('/image', '/_thumb/image')+'" width="50px" height="50px"/>'+data[i]['name'].replace('/\\' + query + '\\/gi','<span style="font-weight: bold;">'+query+'</span>')+'</a></li>');
					}else{
						$('ul.autocomplete').append('<li class="result_item"><a href="'+URL_base+'product/'+data[i]['id_product']+'/'+data[i]['translit']+'" class="animate"><img alt="'+data[i]['name']+'" src="'+data[i]['image'].replace('/original', '/small')+'" width="50px" height="50px"/>'+data[i]['name'].replace('/\\' + query + '\\/gi','<span style="font-weight: bold;">'+query+'</span>')+'</a></li>');
					}
				}
				$('ul.autocomplete').append('<li><a href="/search/?query='+query+'&category2search='+c2s+'" class="animate">Показать все результаты >></a></li>');
				$('ul.autocomplete').slideDown();
			}else{
				$('ul.autocomplete').slideUp();
			}
		});
		$('input#search').keyup(function(){
			query = $(this).val();
			c2s = $('#category2search').val();
			$.ajax({
				url: URL_base+'ajaxsearch',
				type: "POST",
				dataType : "json",
				data:({
					"action": 'search',
					"category2search": c2s,
					"query": query
				}),
			}).done(function(data){
				if(data != null && data.length > 0){
					$('ul.autocomplete').find('li').remove();
					for(var i = 0; i < data.length; i++){
						$('ul.autocomplete').append('<li class="result_item"><a href="'+URL_base+'product/'+data[i]['id_product']+'/'+data[i]['translit']+'" class="animate"><img alt="'+data[i]['name']+'" src="'+data[i]['img_1'].replace('/image', '/_thumb/image')+'" width="50px" height="50px"/>'+data[i]['name'].replace('/\\' + query + '\\/gi','<span style="font-weight: bold;">'+query+'</span>')+'</a></li>');
					}
					$('ul.autocomplete').append('<li><a href="/search/?query='+query+'&category2search='+c2s+'" class="animate">Показать все результаты >></a></li>');
					$('ul.autocomplete').slideDown();
				}else{
					$('ul.autocomplete').slideUp();
				}
			});
		});
	}).blur(function(){
		$('ul.autocomplete').delay(200).slideUp();
	});

	// /** Показать/спрятать форму входа */
	// $('#show_form_button').click(function(event){
	// 	event.preventDefault();
	// 	$('#modal_back, #login_form').fadeIn();
	// 	$('.close_form, #modal_back').click(function(event){
	// 		event.preventDefault();
	// 		$('#modal_back, #login_form').fadeOut();
	// 	});
	// });

	// /** Показать/спрятать форму обратной связи */
	// $('#consultation_button').click(function(event){
	// 	event.preventDefault();
	// 	$('#modal_back, #consultation form').fadeIn();
	// 	$('.close_modal, #modal_back').click(function(event){
	// 		event.preventDefault();
	// 		$('#modal_back, #consultation form').fadeOut();
	// 	});
	// });

	/** Закрытие окошка информации о ценовых диапазонах */
		$('#sum_range_modal .close_modal').click(function(event){
			event.preventDefault();
			$('#sum_range_modal_bg, #sum_range_modal').fadeOut();
		});

	/** Отключение ссылок левого подменю */
	$('.left_menu a').click(function(event){
		if($(this).attr("href") == '#'){
			event.preventDefault();
		}
	});

	/** Задержка выпадающего меню */
	$('.level1 li').hover(function(){
		$(this).delay(5000);
		$(this).find('> .level2').delay(300).fadeIn(0);
	},function(){
		$(this).find('> .level2').stop(true,true).hide();
	});

	/** Формирование накладной/счета */

	//$('.bill-form').draggable();
	$('.bill-create, .invoice-create').click(function(e){
		e.preventDefault();
		// $('.bill-form').css({
		// 	"margin-top":-$('.bill-form').height()/2,
		// 	"top": "50%",
		// 	"left": "50%"
		// });
		var orderId = Number($(this).attr('class').replace(/\D+/g,""));
		var currentClient = $('.ord-'+orderId+' .current-client').val();
		if($(this).attr("id") == "invoice"){
			$('.bill-form #doctype').val('Счет');
			$('.bill-form h4#doctype').text('Счет');
		}else{
			$('.bill-form #doctype').val('Накладная');
			$('.bill-form h4#doctype').text('Накладная');
		}
		//$('.bill-form').fadeIn();
		$('.bill-form [name="client"]').val(currentClient);
		$('.bill-form .order_num').val(orderId);
		$('.bill-form span.order_num').text(orderId);
		// $('.bill-form .close').click(function(event){
		// 	event.preventDefault();
		// 	$('.bill-form').fadeOut();
		// });
	});

	/** Изменение рабочих дней */
	//$('.work-days').draggable();

	// $('.work-days-change').click(function(e){
	// 	e.preventDefault();
	// 	$('.work-days').css({
	// 		"margin-top":-$('.work-days').height()/2,
	// 		"top": "50%",
	// 		"left": "50%"
	// 	});

	// 	$('.work-days').fadeIn();
	// 	$('.work-days .close').click(function(event){
	// 		event.preventDefault();
	// 		$('.work-days').fadeOut();
	// 	});
	// });

	/** изменение статуса заказа */
	//$('.select-status').draggable();

	$('.change-status').click(function(e){
		e.preventDefault();
		var orderId = $(this).attr('data-idorder');
		var client = $('.client-'+orderId).val();
		var target_date = $('.target-date-'+orderId).val();
		console.log(target_date);
		$('tr.ord-'+orderId).css("background","#fdd");
		//$('.select-status').fadeIn();
		$('.select-status #target_date').val(target_date);
		$('.select-status .order_num').val(orderId);
		$('.select-status span.order_num').text(orderId);
		$('.select-status span#client').text(client);
		$('.select-status #status').click(function(){
			if($('.select-status #status').val() == 8){
				$('#target_date').prop("disabled", false).prop("required", true);
			}else{
				$('#target_date').prop("disabled", true).prop("required", false).val(null);
			}
		});
		$('.close_modal, #back_modal').click(function(event){
			event.preventDefault();
			$('tr.ord-'+orderId).css("background","#F1FFF1");
		});
		$('body').keydown(function(e){
			if(e.keyCode == 27){
				$('tr.ord-'+orderId).css("background","#F1FFF1");
			}
		});
	});

	/** замена клиента для заказа */
	//$('.select-client').draggable();

	$('.change-client').click(function(e){
		e.preventDefault();
		var orderId = $(this).attr('data-idorder');
		var currentClient = $('.ord-'+orderId+' .current-client').val();
		$('tr.ord-'+orderId).css("background","#fdd");
		//$('.select-client').fadeIn();
		$('option[value="'+currentClient+'"]').attr('selected',true);
		$('.select-client .order_num').val(orderId);
		$('.select-client span.order_num').text(orderId);
		$('.close_modal, #back_modal').click(function(event){
			event.preventDefault();
			$('tr.ord-'+orderId).css("background","#F1FFF1");
		});
		$('body').keydown(function(e){
			if(e.keyCode == 27){
				$('tr.ord-'+orderId).css("background","#F1FFF1");
			}
		});
	});

	/** Выбор категорий для прайс-листа */
	/* Справка по заголовку в прайсе */
	$('#header-info-key').click(function(){
		$('.header-info').stop(true,true).zIndex(101).animate({
			"right": "-3px",
			"opacity": "1"
		});
	});
	$('#header-info-key').blur(function(){
		$('.header-info').stop(true,true).zIndex(0).animate({
			"right": "100px",
			"opacity": "0"
		});
	});

	/* Справка по выбору колонки в прайсе */
	$('#column-info-key').click(function(){
		$('.column-info').stop(true,true).zIndex(101).animate({
			"right": "-3px",
			"opacity": "1"
		});
	});
	$('#column-info-key').blur(function(){
		$('.column-info').stop(true,true).zIndex(0).animate({
			"right": "100px",
			"opacity": "0"
		});
	});

	/* Справка по выбору фото в прайсе */
	$('#photo-info-key').focus(function(){
		$('.photo-info').stop(true,true).zIndex(101).animate({
			"right": "-3px",
			"opacity": "1"
		});
	});
	$('#photo-info-key').blur(function(){
		$('.photo-info').stop(true,true).zIndex(0).animate({
			"right": "100px",
			"opacity": "0"
		});
	});

	/* Первоначальное выключение категорий, превышающих лимит */
	$('.category-select, .category-parent-select').each(function(){
		var limit = Number($('span.limit-count').text().replace(/\D+/g,""));
		if($(this).val() !== 0 && $(this).val() > limit){
			$(this).prop('disabled',true);
		}else{
			$(this).prop('disabled',false);
		}
	});

	/* Проверка input индивидуальной наценки */
	$('#margin').keyup(function(){
		var value = $(this).val().replace(/[^0-9.,]/gi,"");
		if(value.length > 0 && value.length <= 6){
			$('input[name="column[]"]').prop('disabled',true);
			$(this).val(value);
		}else{
			$('input[name="column[]"]').prop('disabled',false);
			$(this).val('');
		}
	});

	/* Снять все выделения */
	$('.uncheck_all').click(function(e){
		e.preventDefault();
		$('.category-select:checked, .category-parent-select:checked, .category-parent-select:indeterminate').each(function(){
			var id = Number($(this).attr('id').replace(/\D+/g,""));
			var pid = Number($(this).attr('class').replace(/\D+/g,""));
			var products = Number($(this).val().replace(/\D+/g,""));
			var limit = Number($('span.limit-count').text().replace(/\D+/g,""));
			var summary = Number($('span.selected-count').text().replace(/\D+/g,""));
			var massive = $('.selected-array').val();
			if(pid == 0){
				if($('.pid-'+id).length == 0){
					summary -= products;
					massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
				}
			}else{
				summary -= products;
				massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
			}
			$(this).prop('checked', false).prop('indeterminate', false);
			$('.selected-array').val(massive);
			$('.selected-count').text(summary);
			var remain = limit-summary;
			$('span.remain-count').text(remain);
			$('.category-select, .category-parent-select').each(function(){
				var pid = Number($(this).attr('class').replace(/\D+/g,""));
				var id = Number($(this).attr('id').replace(/\D+/g,""));
				if(pid == 0){
					var remain_cat = 0;
					$('.pid-'+id+':checked').each(function(){
						remain_cat += Number($(this).val().replace(/\D+/g,""));
					});
					remain_cat = Number($(this).val().replace(/\D+/g,"")) - remain_cat;
				}else{
					var remain_cat = Number($(this).val().replace(/\D+/g,""));
				}
				if($(this).prop('checked') !== true && remain_cat > remain){
					$(this).prop('disabled',true);
				}else{
					$(this).prop('disabled',false);
				}
			});
		});
	});

	/* Выбор категорий второго уровня */
	$('.pricelist_select').change(function(){
		var order = $(this).val();
		$('.selected-array').val(order);
	});

	/* Выбор категорий второго уровня */
	$('.category-select, .category-parent-select').change(function(){
		var id = Number($(this).attr('id').replace(/\D+/g,""));
		var pid = Number($(this).attr('class').replace(/\D+/g,""));
		var products = Number($(this).val().replace(/\D+/g,""));
		var limit = Number($('span.limit-count').text().replace(/\D+/g,""));
		var summary = Number($('span.selected-count').text().replace(/\D+/g,""));
		var array = 0; var massive = $('.selected-array').val();
		if(pid == 0){
			if($('.pid-'+id).length > 0){
				if($(this).prop('checked')==true){
					$('.pid-'+id+':checked').each(function(){
						products = products - Number($(this).val());
					});
					$('.pid-'+id).each(function(){
						massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
						massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
					});
					$('.pid-'+id).prop('checked',true);
					summary += products;
				}else{
					$('.pid-'+id).prop('checked',false);
					summary -= products;
					$('.pid-'+id).each(function(){
						massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
					});
				}
			}else{
				if($(this).prop('checked')==true){
					summary += products;
					massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
				}else{
					summary -= products;
					massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
				}
			}
		}else{
			if($(this).prop('checked')==true){
				summary += products;
				massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
			}else{
				summary -= products;
				massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
			}
			if($('.pid-'+pid).length > 0 && $('.pid-'+pid+':checked').length > 0){
				if($('.pid-'+pid+':checked').length !== $('.pid-'+pid).length){
					$('#cat-'+pid).prop('checked',false).prop('indeterminate', true);
				}else{
					$('#cat-'+pid).prop('checked',true).prop('indeterminate', false);
				}
			}else{
				$('#cat-'+pid).prop('checked',false).prop('indeterminate', false);
			}
		}
		$('.selected-array').val(massive);
		$('span.selected-count').text(summary);
		var remain = limit-summary;
		$('span.remain-count').text(remain);
		$('.category-select, .category-parent-select').each(function(){
			var pid = Number($(this).attr('class').replace(/\D+/g,""));
			var id = Number($(this).attr('id').replace(/\D+/g,""));
			if(pid == 0){
				var remain_cat = 0;
				$('.pid-'+id+':checked').each(function(){
					remain_cat += Number($(this).val().replace(/\D+/g,""));
				});
				remain_cat = Number($(this).val().replace(/\D+/g,"")) - remain_cat;
			}else{
				var remain_cat = Number($(this).val().replace(/\D+/g,""));
			}
			if($(this).prop('checked') !== true && remain_cat > remain){
				$(this).prop('disabled',true);
			}else{
				$(this).prop('disabled',false);
			}
		});
	});

	$('.category-select:checked, .category-parent-select:checked').each(function(){
		var id = Number($(this).attr('id').replace(/\D+/g,""));
		var pid = Number($(this).attr('class').replace(/\D+/g,""));
		var products = Number($(this).val().replace(/\D+/g,""));
		var limit = Number($('span.limit-count').text().replace(/\D+/g,""));
		var summary = Number($('span.selected-count').text().replace(/\D+/g,""));
		var array = 0; var massive = $('.selected-array').val();
		if(pid == 0){
			if($('.pid-'+id).length > 0){
				if($(this).prop('checked')==true){
					$('.pid-'+id+':checked').each(function(){
						products = products - Number($(this).val());
					});
					$('.pid-'+id).each(function(){
						massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
						massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
					});
					$('.pid-'+id).prop('checked',true);
					summary += products;
				}else{
					$('.pid-'+id).prop('checked',false);
					summary -= products;
					$('.pid-'+id).each(function(){
						massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
					});
				}
			}else{
				if($(this).prop('checked')==true){
					summary += products;
					massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
				}else{
					summary -= products;
					massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
				}
			}
		}else{
			if($(this).prop('checked')==true){
				summary += products;
				massive += Number($(this).attr('id').replace(/\D+/g,""))+';';
			}else{
				summary -= products;
				massive = massive.replace((Number($(this).attr('id').replace(/\D+/g,""))+';'),'');
			}
			if($('.pid-'+pid).length > 0 && $('.pid-'+pid+':checked').length > 0){
				if($('.pid-'+pid+':checked').length !== $('.pid-'+pid).length){
					$('#cat-'+pid).prop('checked',false).prop('indeterminate', true);
				}else{
					$('#cat-'+pid).prop('checked',true).prop('indeterminate', false);
				}
			}else{
				$('#cat-'+pid).prop('checked',false).prop('indeterminate', false);
			}
		}
		$('.selected-array').val(massive);
		$('span.selected-count').text(summary);
		var remain = limit-summary;
		$('span.remain-count').text(remain);
		$('.category-select, .category-parent-select').each(function(){
			var pid = Number($(this).attr('class').replace(/\D+/g,""));
			var id = Number($(this).attr('id').replace(/\D+/g,""));
			if(pid == 0){
				var remain_cat = 0;
				$('.pid-'+id+':checked').each(function(){
					remain_cat += Number($(this).val().replace(/\D+/g,""));
				});
				remain_cat = Number($(this).val().replace(/\D+/g,"")) - remain_cat;
			}else{
				var remain_cat = Number($(this).val().replace(/\D+/g,""));
			}
			if($(this).prop('checked') !== true && remain_cat > remain){
				$(this).prop('disabled',true);
			}else{
				$(this).prop('disabled',false);
			}
		});
	});

	/** Проверка корректности вводимого номера бонусной карты */
	$('.bonus #bonus_card').keyup(function(){
		var card = $(this).val();
		ValidateBonusCard(card);
	});

	/** Проверка корректности вводимого имени на странице регистрации */
	$('#regname').keyup(function(){
		var name = $(this).val();
		ValidateName(name);
	});

	/** Проверка корректности вводимого email на странице регистрации */
	$('#regemail').keyup(function(){
		var email = $(this).val();
		ValidateEmail(email, 0);
	});

	/** Проверка надежности пароля */
	$('#regpasswd').keyup(function(){
		var pass = $(this).val();
		var passconfirm = $('#passwdconfirm').val();
		ValidatePass(pass);
		if(passconfirm !== ''){
			ValidatePassConfirm(pass, passconfirm);
		}
	});

	/** Проверка подтверждения пароля на странице регистрации */
	$('#passwdconfirm').keyup(function(){
		var pass = $('#regpasswd').val();
		var passconfirm = $(this).val();
		ValidatePassConfirm(pass, passconfirm);
	});

	/** Проверка промо-кода */
	$('#promo_code').keyup(function(){
		var code = $(this).val();
		if(code.length > 0){
			ValidatePromoCode(code);
		}else{
			$('#promo_code').next().next().text('');
			$('#promo_code').removeClass();
		}
	});

	/** Проверка формы регистрации */
	$('#reg_form #smb').click(function(e){
		var email = $('#regemail').val();
		var code = $('#promo_code').val();
		if(code.length > 0){
			ValidatePromoCode(code);
		}
		ValidateEmail(email, 1);
		e.preventDefault();
	});

	/** Фильтры. Исключение выбора более одного фильтра в рамках одной группы */

	// $('#filters label').click(function(){
	// 	var f = $(this).prop('for');
	// 	if($('input#'+f).prop('checked')){
	// 		$('input#'+f).prop('checked', false);
	// 		var count = ($('#filters input[checked]').length)-1;
	// 	}else{
	// 		$('input#'+f).prop('checked', true);
	// 		var count = ($('#filters input[checked]').length)+1;
	// 	}
	// 	$(this).parent('form').submit();
	// });

	$('#filters .reset').click(function(event){
		event.preventDefault();
		$('#filters input').each(function(){
			$(this).prop('checked', false);
		});
		$('input#price_from').val($('input#minprice').val());
		$('input#price_to').val($('input#maxprice').val());
		$(this).parent('form').submit();
	});

	/** Прдупреждение перед очисткой корзины для контрагентов */
	$('button[name="price_mode"]').click(function(){
		if($('.cart').hasClass('full')){
			if(confirm("Корзина будет очищена.\nПродолжить?") == false){
				return false;
			}
		}
		return true;
	});

	/** Перепроведение заказа */
	//$('.order_remake').draggable();

	$('.remake_order').click(function(a){
		a.preventDefault();
		//$('.order_remake').fadeIn();
		$('.order_remake').attr('action', $(this).parent('form').attr('action'));
		// $('.order_remake .close').click(function(e){
		// 	e.preventDefault();
		// 	$('.order_remake').fadeOut();
		// });
	});

	// Ручное изменение колонки цен
	$('.manual_price_column_change').on('click', function(e){
		e.preventDefault();
		$('.price_columns').slideToggle();
	});
	$('[name="price_column"]').on('change', function(){
		if($(this).hasClass('default')){
			$('.reason').slideUp().find('textarea').removeClass('error').prop('required', false);
		}else{
			$('.reason').slideDown().find('textarea').addClass('error').prop('required', true);
		}
	});

	$('[class^="dialog"]').removeClass('hidden').dialog({
		autoOpen: false,
		show: {
			effect: "fade",
			duration: 1000
		},
		hide: {
			effect: "fade",
			duration: 1000
		}
	});

	// Инициалзация маски для ввода телефонных номеров
	$(".phone").mask("+38 (099) ?999-99-99");

	// Добавление кнопки Закрыть всем модальным окнам
	$('[class^="modal_"]').append('<a href="#" class="close_modal icon-close"></a>');

	// Открытие модального окна
	$('.open_modal').on('click', function(event){
		var target = $(this).data('target'),
			data_confirm = $(this).attr('data-confirm');
		event.preventDefault();
		if (data_confirm === undefined || data_confirm == '') {
			openModal(target);
		}else{
			if(!confirm(data_confirm)){
				return false;
			}
			openModal(target);
		}
		$('body').keydown(function(e){
			if(e.keyCode == 27){
				closeModal();
				return false;
			}
		});
	});

	// Закрытие модального окна
	$('#back_modal, .close_modal').on('click', function(event) {
		event.preventDefault();
		closeModal();
	});

	//Строчный просмотр товаров
	$('.prod_structure span.list').on('click', function(){
		ChangeView('list');
	});
	//Модульный просмотр товаров
	$('.prod_structure span.module').on('click', function(){
		ChangeView('module');
	});

	//Добавление товара в корзину
	$('.qty_js').on('change', function(){
		var id =  $(this).closest('.product_buy').attr('data-idproduct'),
			qty  = $(this).val(),
			note = $(this).closest('.product_section').find('.note textarea').val();
		SendToAjax (id,qty,false,false,note);
	});
	$('.buy_btn_js').on('click', function (){
		var id =  $(this).closest('.product_buy').attr('data-idproduct'),
			qty = $(this).closest('.product_buy').find('.qty_js').val(),
			note = $(this).closest('.product_section').find('.note textarea').val();
		SendToAjax (id,qty,false,false,note);
	});

	//Обработка примечания
	$('form.note textarea').on('blur', function(){
		$(this).css({
			height: '25px'
		});
		var id = $(this).closest('form.note').attr('data-note'),
			note = $(this).val();
		$.ajax({
			url: URL_base+'ajaxcart',
			type: "POST",
			cache: false,
			dataType : "json",
			data: {
				"action": "update_note",
				"id_product": id,
				"note": note
			}
		});
	});


	//Инициализация проставки цены
	//formPrice();
	$('.tabs_block').click(function() {
		formPrice();
	});

	//Hover add favorites
	// $('.preview_favorites').mouseenter(function(){
	// 	$(this).find('.favorite').html('favorites');
	// 	$(this).mouseleave(function(){
	// 		$(this).find('.favorite').html('favorites-o');
	// 	});
	// });

	$('.filter_title').on('click', function() {
		$(this).closest('div[class$="_filter"]').find('.filter_block').stop(true, true).slideToggle();
		$(this).closest('div[class$="_filter"]').find('span.icon-font').toggleClass('rotate');
	});

	// Отмена стандартного обработчика у ссылки c #
	$('a').click(function(event) {
		if($(this).attr('href') == '#'){
			event.preventDefault();
		}
	});

	//Получение данных для подписки на товар
	$('.preview_follprice p').on('click', function followPrice(event) {
		if ($(this).hasClass('add_waitinglist')) {
			var email = '',
			id_user = '',
			id_product = $(this).closest('.preview_follprice').attr('data-follprice'),
			isregistered = $(this).closest('.preview_follprice').find('input[name="reg"]').val();

			$('#cancel_follow_js').click(function() {
				$('.enter_mail').hide();
			});
			if (isregistered != ''){
				id_user = isregistered;
				//console.log(id_user+"-"+email+"-"+id_product);
				AddInWaitingList(id_product,id_user,email);
			}else{
				$('.enter_mail').show();
				$('#follow_price').click(function(event) {
					if($('input[name="user_email"]')[0].validity.valid == true){
						event.preventDefault();
						email = $('input[name="user_email"]').val();
						$('.enter_mail').hide();
						//console.log(id_user+"-"+email+"-"+id_product);
						AddInWaitingList(id_product,id_user,email);
					}
				});
			}
		};
	});

	//Удаление товара из листа ожидания
	$('.remove_waitinglist_js').on('click', function() {
		var id_product = $(this).closest('.waiting_list_js').attr('data-idproduct');
		if (confirm('Вы точно хотите удалить товар из списка избранных?')) {
			$.ajax({
				url: URL_base+'ajax_customer',
				type: "POST",
				cache: false,
				dataType: "json",
				data: {
					"action":'del_from_waitinglist',
					"id_product": id_product
				}
			}).done(function(){
				location.reload();
			});
		};
	});

	//Инициализация добавления товара в избранное
	$('.preview_favorites').click(function(event) {
		id_product = $(this).attr('data-idfavorite');
		AddFavorite(event,id_product);
	});

	//Удаление Избранного товара из списка
	$('.remove_favor_js').on('click', function() {
		var id_product = $(this).closest('.favorite_js').attr('data-idproduct');
		if (confirm('Вы точно хотите удалить товар из списка избранных?')) {
			$.ajax({
				url: URL_base+'ajax_customer',
				type: "POST",
				cache: false,
				dataType: "json",
				data: {
					"action":'del_favorite',
					"id_product": id_product
				}
			}).done(function(){
				location.reload();
			});
		};
	});


	//Дубликаты  товаров
	$('[class^="duplicate_check_"]').on('click', function(e){
		e.preventDefault();
		$('.dialog_duplicate').dialog('open');
		var id = $(this).prop('class').replace(/[^0-9\.]+/g, '');
		var art = $(this).next().val();
		$('.dialog_duplicate input[name="id"]').val(id);
		$('.dialog_duplicate p span').text(art);
		var onclick='ToggleDuplicate('+id+',<?=$_SESSION["member"]["id_user"]?>, $(\'.dialog_duplicate input[name="duplicate_comment"]\').val());$(\'.dialog_duplicate\').dialog(\'close\');$(\'.duplicate_check_'+id+'\').prop(\'checked\', true);$(\'.duplicate_check_'+id+'\').prop(\'disabled\', true);';
		$('.dialog_duplicate button').attr('onclick', onclick);
	});


	//Ответ на комментарий в предложениях
	$('.reply').on('click', function() {
		var id = $(this).closest('.feedback_container').attr('data-wishes');
		$(this).closest('#wishes').find('.feedback_form').css('left', '-75%');
		$(this).closest('#wishes').find('.cancel_reply').show();
		$(this).closest('#wishes').find('.feedback_form h4').html('Ответ');
		$(this).closest('#wishes').find('#feedback_text').focus();
		if($('input').is('[name="id_reply"]')){
			$(this).closest('#wishes').find('input[name="id_reply"]').val(id);
		}else{
			$(this).closest('#wishes').find('#message_js').append('<input type="hidden" name="id_reply" value="'+id+'">');
		}

	});

	//Отмена ответа на комментарий в предложениях
	$('.cancel_reply').on('click', function() {
		$(this).closest('#wishes').find('.feedback_form').css('left', '0%');
		$(this).closest('#wishes').find('.cancel_reply').hide();
		$(this).closest('#wishes').find('.feedback_form h4').html('Оставить сообщение');
		$(this).closest('#wishes').find('input[name="id_reply"]').remove();

	});

	//Показать/скрыть блок с комментариями > 3
	$('.read_more').on('click', function() {
		var vis = $('.more_reply').is(':visible'),
			text = vis ? 'Показать все' : 'Скрыть';
		$('.read_more a').text(text);
		$('.more_reply').slideToggle();
	});

	// $('.main_menu > li').hover(function(){
	// 	console.log('sssss');
	// 	expandCat($(this));
	// 	$(this).on('mouseleave', function(){
	// 		hideCat($(this));
	// 	});
	// });
});






















// New Template Code
 $(function(){

	var viewport_width = $(window).width(),
		viewport_height = $(window).height(),
		center_section_height = $('section .center').height(),
		header_outerheight = $('header').outerHeight();
		// console.log('viewport_height - '+viewport_height);
		// console.log('viewport_width - '+viewport_width);
		// console.log('center_height - '+viewport_height);
		// console.log('header_outerheight - '+header_outerheight);

	if(viewport_width < 711) {

		//Замена картинок баннера
		var banner_img = $('#owl-main_slider img');
		$('#owl-main_slider').css({
			'height': viewport_width,
			'max-height':  $(window).height()*0.8
		});
		$.each( banner_img ,function(index, obj) {
			var src = $(this).attr('data-src'),
				mobile_src = src.replace('banner', 'banner/mobile');
			$(this).attr( 'data-src' , mobile_src);
		});

		//Замена картинок в слайдере миниатюр
		var slider_img = $('#owl-product_mini_img_js img');
		$.each( slider_img ,function(index, obj) {
			var src = $(this).attr('src'),
				mobile_src = src.replace('small', 'medium');
			$(this).attr( 'src' , mobile_src);
		});
		//Удаление класса акт картинки на моб версии
		$('#owl-product_mini_img_js').find('img').removeClass('act_img');
	}

	//Высота сайдбара
	$('.sidebar_wrapp').css('max-height', (viewport_height - header_outerheight - 15));

	//Инициализаци слайдера
	$("#owl-main_slider").owlCarousel({
		autoPlay: true,
		stopOnHover: true,
		slideSpeed: 300,
		paginationSpeed: 400,
		itemsScaleUp: true,
		singleItem: true,
		lazyLoad: true,
		lazyFollow: false,
		pagination: false,
		navigation: true, // Show next and prev buttons
		navigationText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left"></use></svg>',
						'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right"></use></svg>']
	});

	//Максимальная высота корзины
	if(viewport_width > 712) {
		var coeff = 0.8;
	}else{
		var coeff = 0.9;
	}
	$('#cart .order_wrapp').css('max-height', (viewport_height - header_outerheight)*coeff);

	//Отправка формы Search
	// $('.mob_s_btn').on('click', function() {
	// 	alert('dfs');
	// 	$(this).closest('form').submit();
	// 	$('#search').focus();
	// });

	// Фокусировка Search
	// $('#search').on('focus', function() {
	// 	$('html').css('overflow-y', 'scroll');
	// 	$('body').addClass('active_search');
	// });
	// Активация кнопки поиска при вводе
	$('#search').on('keyup', function() {
		var val = $(this).val();
		if(val != ''){
			if(!$('.search_btn').hasClass('color-grey-search')){
				$('.search_btn').addClass('color-grey-search');
			}
		}else{
			if($('.search_btn').hasClass('color-grey-search')){
				$('.search_btn').removeClass('color-grey-search');
			}
		}
	});
	//Отмена обработчика отпраки формы
	$('#category-lower-right').on('click', function(event) {
		event.preventDefault();
	});

	//Емитация Select
	$('.imit_select .mdl-menu__item').on('click', function() {
		var value = $(this).text();
		$('.imit_select .mdl-menu__item').removeClass('active');
		$(this).addClass('active');
		$(this).closest('.imit_select').find('.select_fild').text(value);
	});

	// Активация меню mobile
	$('.menu').on('click', function() {
		var action = $(this).text(),
			indent = $("header").outerHeight(),
			panel_height = viewport_height - indent;
		if(action == 'menu'){
			$(this).html('close');
			// $('.panel[data-type="panel"]').css('display', 'block').height(panel_height);
			// $('body').addClass('active_panel');
		}else{
			$(this).html('menu');
			// $('.panel[data-type="panel"]').height(0);
			// $('body').removeClass('active_panel');
		}
	});

	//Закрытие search mobile
	$('.search_close').on('click', function(){
		closeObject();
	});

	//Scroll Magic
	var header = $("header"),
		over_scroll = $('body').hasClass('banner_hidden')?true:false,
		banner_height = $('.banner').outerHeight();
		console.log('banner_height - '+banner_height);
		console.log(over_scroll);
	$(window).scroll(function(){
		if(banner_height == 0){
			banner_height = $('.banner').outerHeight();
		}
		var height = header.outerHeight(),
			fixed_height = (banner_height/2) - height;
		if(over_scroll == false){
			if($(this).scrollTop() > fixed_height && header.hasClass("default")){
			    header.removeClass("default").addClass("fixed_panel");
			}else if($(this).scrollTop() <= fixed_height && header.hasClass("fixed_panel")){
			    header.removeClass("fixed_panel").addClass("default");
			}
		}
		//Скрытия баннера
		var banner_out_height = banner_height - height;
		if($(this).scrollTop() > banner_out_height && over_scroll == false){
			over_scroll = true;
			$('body').addClass('banner_hide');
			$('#owl-main_slider').height(header_outerheight);
			$(this).scrollTop(0);
		}
	});

	//Возврат баннера если он скрыт
	$('.logo').on('click', function(event) {
		if(over_scroll === true){
			event.preventDefault();
			$('#owl-main_slider').animate({height: banner_height}, 300);
			$('html, body').animate({
				scrollTop: 0
			}, 300);
			$('body').removeClass('banner_hide');
		    header.removeClass("fixed_panel").addClass("default");
			setTimeout(function(){over_scroll = false;},305);
		}
	});

	//Меню
	$('.more_cat').on('click', function() {
		var lvl = $(this).closest('ul').data('lvl'),
			parent = $(this).closest('li'),
			parent_label = parent.hasClass('active');
		$(this).closest('ul').find('li').removeClass('active').find('ul').stop(true, true).slideUp();
		$(this).closest('ul').find('.material-icons').removeClass('rotate');
		if(!parent_label){
			parent.addClass('active').find('> ul').stop(true, true).slideDown();
			$(this).find('.material-icons').addClass('rotate');
		}
	});

	//Переключение вкладок главного меню
	$('.catalog').on('click', '.main_nav li', function() {
		var section = $(this).data('nav');

		if(section == 'filter'){
			var name = $(this).find('i').text();
			if(name == 'filter_list'){
				$(this).find('i').text('highlight_off');
				$(this).find('span.title').text('Скрыть');
				$('.second_nav, .news , .included_filters').fadeOut();
				$('.filters').fadeIn();
				$(this).addClass('active');
			}else{
				$(this).find('i').text('filter_list');
				$(this).find('span.title').text('Фильтры');
				$('.filters').fadeOut();
				$('.second_nav, .news, .included_filters').fadeIn();
				$(this).removeClass('active');
			}
		}else{
			$('.catalog .main_nav li').removeClass('active');
			$(this).addClass('active');
		}


	});

	//Стрелка указывающая на цену
	var price_el = $('.price'),
		price_nav_el = $('.price_nav');
		price_pos = Math.round(price_el.offset().left + (price_el.width()/2) - (price_nav_el.width()/2));
	price_nav_el.offset({left:price_pos });

	//Высота блока главной картики продукта
	$('.product_main_img').css('height', $('.product_main_img').outerWidth());
	console.log($('.product_main_img').outerWidth());
	//Инициализация owl carousel
	$("#owl-product_mini_img_js").owlCarousel({
		items: 6,
		itemsCustom: [[320, 1], [727, 2], [950, 3], [1250, 4], [1600, 5]],
		navigation: true, // Show next and prev buttons
		pagination: false,
		navigationText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
						'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>']
	});
	$("#owl-popular, #owl-last-viewed, #owl-accompanying").owlCarousel({
		autoPlay: false,
		stopOnHover: true,
		slideSpeed: 300,
		paginationSpeed: 400,
		itemsScaleUp: true,
		items: 5,
		navigation: true, // Show next and prev buttons
		navigationText: ['<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
						'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>']
	});

	//Слайдер картинок
	$('#owl-product_mini_img_js .item').on('click', function(event) {
		var src = $(this).find('img').attr('src');
		if(viewport_width > 711){
			$('#owl-product_mini_img_js').find('img').removeClass('act_img');
			$(this).find('img').addClass('act_img');
			src = src.replace('small', 'original');
			$('.product_main_img').find('img').attr('src', src);
			$('.product_main_img').hide().fadeIn('100');
		}else{
			event.preventDefault();
		}
	});

	//Raiting stars
	$('.set_rating').on('change', function(){
		var rating = $(this).val();
		changestars(rating);
	});
	$('.star').hover(function(){
		var rating = $(this).closest('label').find('input').val();
		changestars(rating);
		$('.feedback_stars').on('mouseleave', function(){
			rating = $(this).find('input:checked').val();
			if(!rating){
				rating = 0;
			}
			changestars(rating);
		});
	});
	$('.star').on('click', function(e){
		var input = $(this).closest('label').find('input');
		if(input.is(":checked")){
			e.preventDefault();
			input.removeAttr('checked');
			changestars(0);
		}
	});

	//Закрытие подложки и окон
	$('body').on('click', '.background_panel', function(){
		closeObject();
	});

	// Добавление кнопки Закрыть всем модальным окнам
	$('[data-type="modal"]').each(function(index, el) {
		$(this).append('<a href="#" class="material-icons close_modal btn_js" data-name="'+$(this).attr('id')+'">close</a>');
	});

	//Замена картинки для открытия в ориг размере
	$('.product_main_img').on('click', function() {
		var img_src = $(this).find('img').attr('src'),
			img_alt = $(this).find('img').attr('alt');
		$('#big_photo img').attr({
			src: img_src,
			alt: img_alt
		}).css({
			'max-height': (viewport_height - header_outerheight)*0.9,
			'max-width': viewport_width*0.9
		});

	});
	//Закрытие окна при клике на картинку
	$('#big_photo img').on('click', function(){
		closeObject();
	});
	//Открытие обьектов с подложкой
	$('body').on('click', '.btn_js', function(){
		var name = $(this).data('name');
		if(name != undefined){
			openObject(name);
		}
	});
	//Обработка примечания
	$('.note textarea').on('blur', function(){
		$(this).css({
			height: '30px'
		});
		// var id = $(this).closest('form.note').attr('data-note'),
		// 	note = $(this).val();
		// $.ajax({
		// 	url: URL_base+'ajaxcart',
		// 	type: "POST",
		// 	cache: false,
		// 	dataType : "json",
		// 	data: {
		// 		"action": "update_note",
		// 		"id_product": id,
		// 		"note": note
		// 	}
		// });
	});
	//Обработка примечания
	$('.add_cart_state input:radio').on('click', function(){
		var checked = false;
		if($(this.checked)){
			checked = true;
		}
		$(this).prop("checked", checked);
		console.log('sdf');
	});
});