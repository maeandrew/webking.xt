function ajax(target, action, data, dataType){
	if(typeof(data) == 'object'){
		data['target'] = target;
		data['action'] = action;
	}else{
		data = {'target': target, 'action': action};
	}
	dataType = dataType || 'json';
	var ajax = $.ajax({
		url: URL_base_global+'ajax',
		type: "POST",
		dataType : dataType,
		data: data
	});
	return ajax;
}
function ModalDemandChart(id_chart){
	ajax('product', 'OpenModalDemandChart').done(function(data){
		$('#demand_chart').html(data);
		componentHandler.upgradeDom();

		if(id_chart != "text" && id_chart != "undefined"){
			//console.log(id_chart);
				//$('a').on('click', function(){
				//var id_chart = $(this).attr('id');
				ajax('product', 'SearchDemandChart', {'id_chart': id_chart}, 'html').done(function(data){
					if(data != null){
						//console.log(data);
						$('#demand_chart').html(data);
						//foo(d3.selectAll("div").text('some text'));

						componentHandler.upgradeDom();
						openObject('demand_chart');
						$('#demand_chart #user_bt').find('a').addClass('update');
						$('#demand_chart').on('click', '.update', function(){
							var parent =  $(this).closest('#demand_chart'),
								id_category = parent.data('target'),
								opt = 0,
								name_user = parent.find('#name_user').val(),
								text = parent.find('textarea').val(),
								arr = parent.find('input[type="range"]'),
								values = {};
							if($('.select_go label').is(':checked')){
								opt = 1;
							}
							arr.each(function(index, val){
								values[index] = $(val).val();
							});
							ajax('product', 'UpdateDemandChart', {'values': values, 'id_category': id_category, 'id_chart': id_chart, 'name_user': name_user, 'text': text, 'opt': opt}).done(function(data){
								if(data === true){
									console.log('Your data has been saved successfully!');
									closeObject('graph');
									location.reload();
								}else{
									console.log('Something goes wrong!');
								}
							});
						});
					}else{
						console.log('Something goes wrong!');
					}
				});


		}else if(id_chart == 'text'){
			openObject('demand_chart');
			console.log(id_chart);
			//if ($(this).is('.Add_graph_up')) {
				$('#demand_chart').on('click', '.btn_js.save', function(){
					var parent =  $(this).closest('#demand_chart'),
						id_category = parent.data('target'),
						opt = 0,
						moderation = 1,
						name_user = parent.find('#name_user').val(),
						comment = parent.find('textarea').val(),
						arr = parent.find('input[type="range"]'),
						values = {};
					if ($('.select_go label').is(':checked')) {
						opt = 1;
					}
					arr.each(function(index, val){
						values[index] = $(val).val();
					});
					ajax('product', 'SaveDemandChart', {
						'values': values,
						'id_category': id_category,
						'name_user': name_user,
						'moderation': moderation,
						'text': comment,
						'opt': opt
					}).done(function(data){
						if(data === true){
							console.log('Your data has been saved successfully!');
							closeObject('graph');
							location.reload();
						}else{
							console.log('Something goes wrong!');
						}
					});
				});

		}else{
			openObject('demand_chart');
			$('#demand_chart').on('click', '.btn_js.save', function(){
				var parent =  $(this).closest('#demand_chart'),
					id_category = parent.data('target'),
					opt = 0,
					name_user = parent.find('#name_user').val(),
					text = parent.find('textarea').val(),
					arr = parent.find('input[type="range"]'),
					values = {};
				if ($('.select_go label').is(':checked')) {
					opt = 1;
				}
				arr.each(function(index, val){
					values[index] = $(val).val();
				});
				ajax('product', 'SaveDemandChart', {'values': values, 'id_category': id_category, 'name_user': name_user, 'text': text, 'opt': opt}).done(function(data){
					if(data === true){
						console.log('Your data has been saved successfully!');
						closeObject('graph');
						location.reload();
					}else{
						console.log('Something goes wrong!');
					}
				});
			});
		};
	});
}
// Установить куки
function setCookie(name, value) {
	var valueEscaped = escape(value);
	var expiresDate = new Date();
	expiresDate.setTime(expiresDate.getTime() + 365 * 24 * 60 * 60 * 1000); // срок - 1 год
	var expires = expiresDate.toGMTString();
	var newCookie = name + "=" + valueEscaped + "; path=/; expires=" + expires;
	if (valueEscaped.length <= 4000) document.cookie = newCookie + ";";
}
// Получить куки
function getCookie(name) {
	var prefix = name + "=";
	var cookieStartIndex = document.cookie.indexOf(prefix);
	if (cookieStartIndex == -1) return null;
	var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length);
	if (cookieEndIndex == -1) cookieEndIndex = document.cookie.length;
	return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex));
}
/* Определение расстояния прокрутки страницы */
function getScrollWindow() {
	var html = document.documentElement;
	var body = document.body;
	var top = html.scrollTop || body && body.scrollTop || 0;
	top -= html.clientTop;
	return top;
}
function FixHeader(){
	var colors = ['red', 'lblue', 'blue', 'orange', 'green', 'default', 'lgrey-inv', 'yellow'];
	var color = '';
	$(window).scroll(function(){
		if(getScrollWindow() > 30){
			if(color == ''){
				color = colors[Math.floor(Math.random()*colors.length)];
				$('#toTop').attr('class', 'btn-l-'+color+' animate').addClass('visible');
			}else{
				$('#toTop').addClass('visible');
			}
			$('header').addClass('hide').removeClass('paper_shadow_1').addClass('paper_shadow_2');
		}else if(getScrollWindow() <= 30){
			$('#toTop').removeClass('visible');
			$('header').removeClass('hide').removeClass('paper_shadow_2').addClass('paper_shadow_1');
			color = '';
		}
	});
}

// Добавление или обновление товара в ассортименте
function toAssort(id, opt, nacen, comment){
	var inusd = $('.inusd'+id).prop('checked');
	var currency_rate = $('#currency_rate').val();
	if(opt == 1){
		mode = "opt";
	}else{
		mode = "mopt";
	}
	var a,b,c;
	a = parseFloat($("#price_"+mode+"_otpusk_"+id).val().replace(",","."));
	b = parseFloat($("#price_"+mode+"_otpusk_"+id).val().replace(",","."));
	if(inusd == true){
		a = a*currency_rate;
		b = b*currency_rate;
	}
	c = parseFloat($("#product_limit_mopt_"+id).val());
	$("#product_limit_mopt_"+id).val(c);
	active = 0;
	if(c > 0){
		if(opt){
			po = parseFloat($("#price_opt_"+id).val());
			pom = Number(po - po*parseFloat($("#price_delta_otpusk").val())*0.01).toFixed(2);
			if(po != 0 && a > pom){
				alert("Предлагаемая Вами крупнооптовая цена не позволяет продавать данный товар на сайте.");
			}
			pop = Number(po + po*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			pom = Number(po - po*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			if(po != 0 && (b > pop || b < pom)){
				alert("Предлагаемая Вами среднерыночная цена значительно отличается от цены сайта (более "+parseFloat($("#price_delta_recom").val())+"%).");
			}
		}else{
			pm = parseFloat($("#price_mopt_"+id).val());
			pmm = Number(pm - pm*parseFloat($("#price_delta_otpusk").val())*0.01).toFixed(2);
			if(pm != 0 && a > pmm){
				alert("Предлагаемая Вами мелкооптовая цена не позволяет продавать данный товар на сайте.");
			}
			pmp = Number(pm + pm*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			pmm = Number(pm - pm*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			if(pm != 0 && (b > pmp || b < pmm)){
				alert("Предлагаемая Вами среднерыночная цена значительно отличается от цены сайта (более "+parseFloat($("#price_delta_recom").val())+"%).");
			}
		}
		ao = parseFloat($("#price_opt_otpusk_"+id).val());
		bo = parseFloat($("#price_opt_otpusk_"+id).val());
		am = parseFloat($("#price_mopt_otpusk_"+id).val());
		bm = parseFloat($("#price_mopt_otpusk_"+id).val());
		active = 1;
		if((ao > 0 && bo == 0) || (ao == 0 && bo > 0)){
			active = 0;
			alert("Необходимо заполнить цены.");
		}else if((am > 0 && bm == 0) || (am == 0 && bm > 0)){
			active = 0;
			alert("Необходимо заполнить цены.");
		}
	}
	if(active == 1){
		$("#tr_opt_"+id).removeClass('notavailable notprice').addClass('available');
		$("#tr_mopt_"+id).removeClass('notavailable notprice').addClass('available');
	}else{
		$("#tr_opt_"+id).removeClass('available').addClass('notavailable');
		$("#tr_mopt_"+id).removeClass('available').addClass('notavailable');
		$("#product_limit_opt_"+id).val(0);
		$("#product_limit_mopt_"+id).val(0);
	}
	if(a <= 0 || b <= 0){
		//$("#checkbox_"+mode+"_"+id).attr('checked','');
		$("#tr_opt_"+id).removeClass('available').addClass('notavailable notprice');
		$("#tr_mopt_"+id).removeClass('available').addClass('notavailable notprice');
	}
	if(a < 0){
		a = 0;
		$("#price_opt_otpusk_"+id).val(a);
	}
	//if (b<0){ b=0;$("#price_opt_recommend_"+id).val(b);}
	$.ajax({
		url: URL_base+'ajaxassort',
		type: "POST",
		cache: false,
		dataType: "json",
		data:{
			"action": "update_assort",
			"opt": opt,
			"id_product": id,
			"price_otpusk": a,
			"price_recommend": b,
			"nacen": nacen,
			"product_limit": c,
			"active": active,
			"sup_comment": comment,
			"inusd": inusd,
			"currency_rate": currency_rate
		}
	});
}

/*MODAL WINDOW*/

// Вызов модального окна
function openModal(target){
	$('#back_modal').removeClass('hidden');
	$('#'+target+'.modal_hidden').removeClass('modal_hidden').addClass('modal_opened');
}
// Закрытие модального окна
function closeModal(){
	$('.modal_opened').removeClass('modal_opened').addClass('modal_hidden');
	$('#back_modal').addClass('hidden');
}
function SwitchVisibleWishes(obj, id){
	action = "show";
	if(!obj[0].checked){
		action = "hide";
	}
	$.ajax({
		url: URL_base+'ajax_wishes',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action": 'switch_visible',
			"id_wishes": id,
			"visible": action
		}
	}).done(function(){
		location.reload();
	});
}
function delWishes(id){
	$.ajax({
		url: URL_base+'ajax_wishes',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action": 'del_wishes',
			"id_wishes": id
		}
	}).done(function(){
		$('div[data-wishes="'+id+'"]').remove();
	});
}
function SwitchPops1(obj, id){
	action = "show";
	if(!obj.checked){
		action = "hide";
	}
	$.ajax({
		url: URL_base+'ajaxcoment',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action": action,
			"Id_coment": id
		}
	}).done(function(){
		location.reload();
	});
}
function dropComent(id){
	action = "drop";
	$.ajax({
		url: URL_base+'ajaxcoment',
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action": action,
			"Id_coment": id
		}
	}).done(function(){
		$('.coment'+id).remove();
	});
}
function SendCatOrder(order){
	$('.wrapp').addClass('ajax_loading');
	$(this).css('background', '#f00');
	$.ajax({
		url: URL_base+'ajax_cat/?'+order,
		type: "POST",
		cache: false,
		dataType : "json",
		data: {
			"action":"sort_category"
		}
	}).done(function(){
		$('.wrapp').removeClass('ajax_loading');
	});
}

function RecalcSupplierCurrency(){
	$("#popup_msg").fadeIn();
	cur = parseFloat($("#currency_rate").val());
	cur_old = parseFloat($("#currency_rate_old").val());
	$.ajax({
		url: '/ajaxsupdate',
		type: "POST",
		cache: false,
		dataType: "json",
		data: {
			"action": "RecalcCurrency",
			"cur": cur,
			"cur_old": cur_old,
			"id_supplier": id_supplier
		}
	}).done(function(){
		setTimeout(function(){
			$("#popup_msg").fadeOut();
			location.reload();
		},1000);
	});
}
