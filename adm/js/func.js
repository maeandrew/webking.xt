
function ModalGraph(id_graphics){
	ajax('product', 'OpenModalGraph').done(function(data){
		$('#graph').html(data);
		componentHandler.upgradeDom();

		if(id_graphics != "text" && id_graphics != "undefined"){
			//console.log(id_graphics);
				//$('a').on('click', function(){
				//var id_graphics = $(this).attr('id');
				ajax('product', 'SearchGraph', {'id_graphics': id_graphics}, 'html').done(function(data){
					if(data != null){
						//console.log(data);
						$('#graph').html(data);
						//foo(d3.selectAll("div").text('some text'));

						componentHandler.upgradeDom();
						openObject('graph');
						$('#graph #user_bt').find('a').addClass('update');
						$('#graph').on('click', '.update', function(){
							var parent =  $(this).closest('#graph'),
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
							ajax('product', 'UpdateGraph', {'values': values, 'id_category': id_category, 'id_graphics': id_graphics, 'name_user': name_user, 'text': text, 'opt': opt}).done(function(data){
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


		}else if(id_graphics == 'text'){
			openObject('graph');
			console.log(id_graphics);
			//if ($(this).is('.Add_graph_up')) {
				$('#graph').on('click', '.btn_js.save', function(){
					var parent =  $(this).closest('#graph'),
						id_category = parent.data('target'),
						opt = 0,
						moderation = 1,
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
					ajax('product', 'SaveGraph', {
													'values': values,
													'id_category': id_category,
													'name_user': name_user,
													'moderation': moderation,
													'text': text,
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
			openObject('graph');
			$('#graph').on('click', '.btn_js.save', function(){
				var parent =  $(this).closest('#graph'),
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
				ajax('product', 'SaveGraph', {'values': values, 'id_category': id_category, 'name_user': name_user, 'text': text, 'opt': opt}).done(function(data){
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









