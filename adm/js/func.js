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