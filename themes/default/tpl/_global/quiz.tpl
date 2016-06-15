<div class="modal_container summary_info">
	<div class="row hidden">
		<span class="span_title">Фамилия:</span>
		<span class="lastname"></span>
	</div>
	<div class="row hidden">
		<span class="span_title">Имя:</span>
		<span class="firstname"></span></div>
	<div class="row hidden">
		<span class="span_title">Отчество:</span>
		<span class="middlename"></span></div>
	<div class="row hidden">
		<span class="span_title">Область:</span>
		<span class="region"></span>
	</div>
	<div class="row hidden">
		<span class="span_title">Город:</span>
		<span class="city"></span>
	</div>
	<div class="row hidden">
		<span class="span_title">Служба доставки:</span>
		<span class="delivery_service"></span>
	</div>
	<div class="row hidden">
		<span class="span_title">Способ доставки:</span>
		<span class="delivery_method"></span>
	</div>
	<div class="row hidden">
		<span class="span_title">Адрес клиента:</span>
		<span class="client_address"></span>
	</div>
	<div class="row hidden">
		<span class="span_title">Адрес склада:</span>
		<span class="post_office_address"></span>
	</div>
</div>
<?switch($step){
	case 1:?>
		<div class="modal_container step_1 active" data-step="1">
			<div class="head_top">
				<h5>Здравствуйте! Меня зовут Алёна и я сопровождаю Ваш заказ.</h5>
				<span>Сейчас я вижу Вас как "Клиент 2345623", скажите, как Вас зовут?</span>
			</div>
			<div class="row">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="lastname">
					<input class="mdl-textfield__input" type="text" name="lastname" value="">
					<label class="mdl-textfield__label" for="lastname">Фамилия</label>
					<span class="mdl-textfield__error">Введите фамилию</span>
				</div>
			</div>
			<div class="row">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="firstname">
					<input class="mdl-textfield__input" type="text" name="firstname" value="">
					<!-- value="Александр"> -->
					<label class="mdl-textfield__label" for="firstname">Имя</label>
					<span class="mdl-textfield__error">Введите имя</span>
				</div>
			</div>
			<div class="row">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="middlename">
					<input class="mdl-textfield__input" type="text" name="middlename" value="">
					<label class="mdl-textfield__label" for="middlename">Отчество</label>
					<span class="mdl-textfield__error">Введите отчество</span>
				</div>
			</div>
			<div class="row">
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="2">Далее</button>
			</div>
		</div>
		<?break;
	case 2:?>
		<div class="modal_container step_2 " data-step="2">
			<div class="head_top">
				<h6><span class="client">Пользователь</span>, приятно познакомиться!</h6>
				<span>Мы доставляем в 460 городов, а откуда Вы?</span>
			</div>
			<div class="row">
				<span class="number_label">Область</span>
				<div class="region imit_select">
					<button id="region_select" class="mdl-button mdl-js-button">
						<span class="select_field">Харьковская область<!-- Выбрать --></span>
						<i class="material-icons">keyboard_arrow_down</i>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="region_select"></ul>
				</div>

			</div>
			<div class="row">
				<span class="number_label">Город</span>
				<div class="city imit_select">
					<button id="city_select" class="mdl-button mdl-js-button">
						<span class="select_field">Харьков<!-- Выбрать --></span>
						<i class="material-icons">keyboard_arrow_down</i>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="city_select"></ul>
				</div>
			</div>

			<div class="row">
				<div class="error_div hidden">

				</div>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="1">Назад</button>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="3">Далее</button>
			</div>
		</div>
		<?break;
	case 3:?>
		<div class="modal_container step_3 " data-step="3">
			<div class="head_top">
				<h6><span class="client">Пользователь</span>, доставка в <span class="city">Город</span> возможна!</h6>
			</div>
			<div class="row delivery_service">
			</div>

			<div class="row">
				<span>Вам удобнее забрать заказ со склада, или принять по адресу?</span>
				<div class="imit_select delivery_type">
					<button id="select_delivery_type" class="mdl-button mdl-js-button">
						<span class="select_field">Выбрать</span>
						<i class="material-icons fright">keyboard_arrow_down</i>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="select_delivery_type">
						<li class="mdl-menu__item" data-value="1" >Адресная доставка</li>
						<li class="mdl-menu__item" data-value="2" >Забрать со склада</li>
					</ul>
				</div>


				<div class="row post_office imit_select">
					<button id="post_office_select" class=" mdl-button mdl-js-button">
						<span class="select_field">Выбрать отделение<!-- Выбрать --></span>
						<i class="material-icons">keyboard_arrow_down</i>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect list_post_office" for="post_office_select"></ul>
				</div>
			</div>
			<div id="client_address" class="row delivery_address mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input id="delivery_address" class="mdl-textfield__input" type="text" name="clientaddress" value="" id="sample3">
				<label class="mdl-textfield__label" for="sample3">Доставить по адресу...</label>
				<span class="mdl-textfield__error">Введите адрес</span>
			</div>

			<div class="row">
				<div class="error_div hidden"></div>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="2">Назад</button>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="4">Далее</button>
			</div>
		</div>
		<?break;
	case 4:?>
		<div class="modal_container step_4 " data-step="4">
			<div class="head_top">
				<h6>Виталий Петрович, у меня есть необходимые данные для отправки заказа.</h6>
				<span>Вы готовы внести предоплату?</span>
			</div>
			<div class="label_wrap">
				<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-6">
					<input type="radio" id="option-6" class="mdl-radio__button" name="options" value="6" checked>
					<span class="mdl-radio__label">Нет, мне необходима телефонная консультация.</span>
				</label>
				<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-7">
					<input type="radio" id="option-7" class="mdl-radio__button" name="options" value="7">
					<span class="mdl-radio__label">Да, предоставьте реквизиты!</span>
				</label>
			</div>
			<div class="company_details">
				<h4>Реквизиты компании</h4>
			</div>
			<div class="row">
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="3">Назад</button>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="5" onclick="javascript:window.location.hash = ''">Отправить</button>
			</div>
		</div>
		<?break;
	case 5:?>
		<div class="modal_container step_5 " data-step="5">
			<div class="head_top">
				<h6>Готово!</h6>
				<p class="msg_for_client">Я свяжусь с Вами в ближайшее время.</p>
			</div>
		</div>
		<?break;
	default:
		# code...
		break;
}?>
<div class="progress">
	<div class="line">
		<div class="line_active"></div>
	</div>
	<span class="go">Заполнено: </span>
</div>