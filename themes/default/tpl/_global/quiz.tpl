<div class="modal_container summary_info hidden">
	<div class="row ">
		<span class="span_title">Фамилия:</span>
		<span class="lastname"><?=$customer['first_name']?></span>
	</div>
	<div class="row ">
		<span class="span_title">Имя:</span>
		<span class="firstname"><?=$customer['middle_name']?></span>
	</div>
	<div class="row ">
		<span class="span_title">Отчество:</span>
		<span class="middlename"><?=$customer['last_name']?></span>
	</div>
	<div class="row ">
		<span class="span_title">Область:</span>
		<span class="region"><?=$savedcity['region']?></span>
	</div>
	<div class="row ">
		<span class="span_title">Город:</span>
		<span class="city"><?=$savedcity['name']?></span>
	</div>
	<div class="row ">
		<span class="span_title">Служба доставки:</span>
		<span class="delivery_service"><?=$savedcity['shipping_comp']?></span>
	</div>
	<div class="row ">
		<span class="span_title">Способ доставки:</span>
		<span class="delivery_method">адресня/забрать со склада (в зависимости от выбора)</span>
	</div>
	<div class="row ">
		<span class="span_title">Адрес клиента:</span>
		<span class="client_address">инфа, которую введет пользователь</span>
	</div>
	<div class="row ">
		<span class="span_title">Адрес склада:</span>
		<span class="post_office_address"><?=$savedcity['address']?></span>
	</div>
</div>
<div class="modal_container step_<?=$step?> active" data-step="<?=$step?>">
	<?switch($step){
		case 1:?>
			<div class="head_top">
				<h6>Здравствуйте! Меня зовут <?=$contragent?> и я сопровождаю Ваш заказ.</h6>
				<span>Сейчас я вижу Вас как <?=$_SESSION['member']['name']?>, <?=(substr($_SESSION['member']['name'], 0, 4)=='user')?' скажите, как Вас зовут?':' подтвердите данные.'?></span>
			</div>
			<div class="row">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="lastname">
					<input class="mdl-textfield__input" type="text" name="lastname" value="<?=$customer['first_name']?>">
					<label class="mdl-textfield__label" for="lastname">Фамилия</label>
					<span class="mdl-textfield__error">Введите фамилию</span>
				</div>
			</div>
			<div class="row">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="firstname">
					<input class="mdl-textfield__input" type="text" name="firstname" value="<?=$customer['middle_name']?>">
					<!-- value="Александр"> -->
					<label class="mdl-textfield__label" for="firstname">Имя</label>
					<span class="mdl-textfield__error">Введите имя</span>
				</div>
			</div>
			<div class="row">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="middlename">
					<input class="mdl-textfield__input" type="text" name="middlename" value="<?=$customer['last_name']?>">
					<label class="mdl-textfield__label" for="middlename">Отчество</label>
					<span class="mdl-textfield__error">Введите отчество</span>
				</div>
			</div>
			<div class="row">
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="2">Далее</button>
			</div>
			<?break;
		case 2:?>
			<div class="head_top">
				<h6><span class="client"><?=$customer['middle_name']?> <?=$customer['last_name']?></span>, мы доставляем в 460 городов, а откуда Вы?</h6>
			</div>
			<div class="row">
				<span class="number_label">Область</span>
				<div class="region imit_select">
					<select required="required" name="id_region" id="id_region" onChange="regionSelect(id_region.value);">
						<option selected="selected" disabled="disabled">Выберите область</option>
						<?foreach($allregions as $region){ ?>
							<option <?=$region['region'] == $savedcity['region']?'selected="selected"':null;?> value="<?=$region['region']?>"><?=$region['region']?></option>
						<?}?>
					</select>
				</div>

			</div>
			<div class="row">
				<span class="number_label">Город</span>
				<div class="city imit_select">
					<select required="required" name="id_city" id="id_city">
						<?foreach($availablecities as $city){ ?>
							<option <?=$city['name'] == $savedcity['name']?'selected="selected"':null;?> value="<?=$city['names_regions']?>"><?=$city['name']?></option>
						<?}?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="error_div hidden">

				</div>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="1">Назад</button>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="3">Далее</button>
			</div>
			<?break;
		case 3:?>
			<div class="head_top">
				<h6><span class="client"><?=$customer['middle_name']?> <?=$customer['last_name']?></span>, доставка в <span class="city"><?=$savedcity['name']?></span> возможна! Выберите службу доставки.</h6>
			</div>
			<div class="row delivery_service">
				<?foreach($availabledeliveryservices as $k => $delivery){?>
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="shipping_comp-<?=$k?>">
						<input type="radio" name="shipping_comp" id="shipping_comp-<?=$k?>" class="mdl-radio__button" name="options" value="<?=$delivery['shipping_comp']?>" <?=$delivery['shipping_comp'] == $savedcity['shipping_comp']?'checked':null;?>>
						<span class="mdl-radio__label"><?=$delivery['shipping_comp']?></span>
					</label>
				<?}?>
			</div>

			<!--Появляется после выбора службы доставки-->

			<div class="row">
				<span>Вам удобнее забрать заказ со склада или принять по адресу?</span>
				<div class="imit_select delivery_type">
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="shipping_method-1">
						<input type="radio" name="shipping_method" id="shipping_method-1" class="mdl-radio__button" value="address">
						<span class="mdl-radio__label">Адресная доставка</span>
					</label>
					<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="shipping_method-2">
						<input type="radio" name="shipping_method" id="shipping_method-2" class="mdl-radio__button" value="warehouse" <?=isset($savedcity['address'])?'checked':null?>>
						<span class="mdl-radio__label" >Забрать со склада</span>
					</label>
					
					<!--<button id="select_delivery_type" class="mdl-button mdl-js-button">
						<span class="select_field">Выбрать</span>
						<i class="material-icons fright">keyboard_arrow_down</i>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="select_delivery_type">
						<li class="mdl-menu__item" data-value="1" >Адресная доставка</li>
						<li class="mdl-menu__item" data-value="2" >Забрать со склада</li>
					</ul>-->
				</div>


				<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label city">
					<select id="city" name="city" class="mdl-selectfield__select" onChange="regionSelect($(this));">
						<?foreach($availabledeliverydepartment as $office){?>
							<option <?=$office['address'] == $savedcity['address']?'selected="selected"':null;?> value="<?=$office['address']?>"><?=$office['address']?></option>
						<?}?>
					</select>
					<label class="mdl-selectfield__label" for="region">Отделение в Вашем городе</label>
				</div>
				<!-- <span>Отделение в Вашем городе (ЕСЛИ ВЫБРАНО "ЗАБРАТЬ СО СКЛАДА")</span>
				<div class="imit_select">
					<select required="required" name="id_city" id="id_city">
						<?foreach($availabledeliverydepartment as $office){ ?>
							<option <?=$office['address'] == $savedcity['address']?'selected="selected"':null;?> value="<?=$office['address']?>"><?=$office['address']?></option>
						<?}?>
					</select>
				</div>-->

				<span>Введите адрес доставки (ЕСЛИ ВЫБРАНО "АДРЕСНАЯ ДОСТАВКА")</span>
				<div class="imit_select">
					<input id="delivery_address" type="text" name="clientaddress" value="<?=$customer['address_ur']?>">
				</div>


				<!--<div class="row post_office imit_select">
					<button id="post_office_select" class=" mdl-button mdl-js-button">
						<span class="select_field">Выбрать отделение</span>
						<i class="material-icons">keyboard_arrow_down</i>
					</button>
					<ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect list_post_office" for="post_office_select"></ul>
				</div>-->
			</div>
			<!--<div id="client_address" class="row delivery_address mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input id="delivery_address" class="mdl-textfield__input" type="text" name="clientaddress" value="" id="sample3">
				<label class="mdl-textfield__label" for="sample3">Доставить по адресу...</label>
				<span class="mdl-textfield__error">Введите адрес</span>
			</div>-->

			<div class="row">
				<div class="error_div hidden"></div>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="2">Назад</button>
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect to_step" data-step="4">Далее</button>
			</div>
			<?break;
		case 4:?>
			<div class="head_top">
				<h6><?=$customer['middle_name']?> <?=$customer['last_name']?>, у меня есть необходимые данные для отправки заказа.</h6>
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
			<?break;
		case 5:?>
			<div class="head_top">
				<h6>Готово!</h6>
				<p class="msg_for_client">Я свяжусь с Вами в ближайшее время.</p>
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
</div>