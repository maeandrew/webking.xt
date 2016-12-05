<div class="row">
	<div class="customer_cab col-md-6">
		<h1>Уголок агента</h1>
		<?if(G::IsAgent()){?>
			<div class="agent_profile_info">
				<div class="info_item promocode">
					<div class="info_icon">
						<i class="material-icons">&#xE800;</i>
					</div>
					<div class="info_descr">
						<p class="info_descr_title">Ваш промокод:</p>
						<p class="info_descr_text">AK<?=$_SESSION['member']['id_user']?></p>
					</div>
					<div class="action_icon">
						<i id="print_promocode" class="material-icons">print</i>
						<div class="mdl-tooltip" for="print_promocode">Распечатать промокод</div>
					</div>
				</div>
				<div class="info_item clients">
					<div class="info_icon">
						<i class="material-icons">&#xE7F0;</i>
					</div>
					<div class="info_descr">
						<p class="info_descr_title">Привелечено клиентов:</p>
						<p class="info_descr_text">154</p>
					</div>
				</div>
				<div class="info_item bonuses">
					<div class="info_icon">
						<i class="material-icons">&#xE227;</i>
					</div>
					<div class="info_descr">
						<p class="info_descr_title">Получено бонусов:</p>
						<p class="info_descr_text">1236 грн.</p>
					</div>
					<div class="action_icon">
						<i id="bonuses_history" class="material-icons">history</i>
						<div class="mdl-tooltip" for="bonuses_history">Просмотреть исторю начисления бонусов</div>
					</div>
				</div>
			</div>
			<div class="orders_history">
				<h2>История</h2>
				<div class="orders_history_header">
					<div class="header_item date">Дата</div>
					<div class="header_item client">Клиент</div>
					<div class="header_item phone">Телефон</div>
					<div class="header_item order_sum">Сумма заказа</div>
					<div class="header_item profit">Начислено</div>
				</div>
				<div class="orders_history_content">
					<div class="agents_client_order opening_tab open_close_btn_js">
						<div class="order_info date">
							<i class="material-icons">&#xE315;</i>
							02.12.2016
						</div>
						<div class="order_info profit">1200 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович <span><i id="new_client_12345" class="material-icons">&#xE548;</i></span></div>
						<div class="mdl-tooltip" for="new_client_12345">Новый клиент</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
				</div>
				<div class="orders_history_content">
					<div class="agents_client_order opening_tab open_close_btn_js">
						<div class="order_info date">
							<i class="material-icons">&#xE315;</i>
							02.12.2016
						</div>
						<div class="order_info profit">1200 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
				</div>
				<div class="orders_history_content">
					<div class="agents_client_order opening_tab open_close_btn_js">
						<div class="order_info date">
							<i class="material-icons">&#xE315;</i>
							02.12.2016
						</div>
						<div class="order_info profit">1200 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
				</div>
				<div class="orders_history_content">
					<div class="agents_client_order opening_tab open_close_btn_js">
						<div class="order_info date">
							<i class="material-icons">&#xE315;</i>
							02.12.2016
						</div>
						<div class="order_info profit">1200 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
				</div>
				<div class="orders_history_content">
					<div class="agents_client_order opening_tab open_close_btn_js">
						<div class="order_info date">
							<i class="material-icons">&#xE315;</i>
							02.12.2016
						</div>
						<div class="order_info profit">1200 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12000 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
					<div class="agents_client_order">
						<div class="order_info client">Варламов Мудак Петрович</div>
						<div class="order_info phone">+38 (066) 666-65-66</div>
						<div class="order_info order_sum">1200 грн.</div>
						<div class="order_info profit">12 грн.</div>
					</div>
				</div>
			</div>
		<?}else{?>
			<a class="bonus_detalies" href="<?=Link::Custom('page', 'Torgovyj_agent');?>" class="details">
				<i class="material-icons">help_outline</i> Детали агентной программы
			</a>
			<div class="license_agreement">
				<h2>Условия соглашения сотрудничества</h2>
				<div class="license_agreement_descr">
					Что такое Lorem Ipsum?
					Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.
					Почему он используется?
					Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
					Откуда он появился?
					Многие думают, что Lorem Ipsum - взятый с потолка псевдо-латинский набор слов, но это не совсем так. Его корни уходят в один фрагмент классической латыни 45 года н.э., то есть более двух тысячелетий назад. Ричард МакКлинток, профессор латыни из колледжа Hampden-Sydney, штат Вирджиния, взял одно из самых странных слов в Lorem Ipsum, "consectetur", и занялся его поисками в классической латинской литературе. В результате он нашёл неоспоримый первоисточник Lorem Ipsum в разделах 1.10.32 и 1.10.33 книги "de Finibus Bonorum et Malorum" ("О пределах добра и зла"), написанной Цицероном в 45 году н.э. Этот трактат по теории этики был очень популярен в эпоху Возрождения. Первая строка Lorem Ipsum, "Lorem ipsum dolor sit amet..", происходит от одной из строк в разделе 1.10.32
					Классический текст Lorem Ipsum, используемый с XVI века, приведён ниже. Также даны разделы 1.10.32 и 1.10.33 "de Finibus Bonorum et Malorum" Цицерона и их английский перевод, сделанный H. Rackham, 1914 год.
					Где его взять?
					Есть много вариантов Lorem Ipsum, но большинство из них имеет не всегда приемлемые модификации, например, юмористические вставки или слова, которые даже отдалённо не напоминают латынь. Если вам нужен Lorem Ipsum для серьёзного проекта, вы наверняка не хотите какой-нибудь шутки, скрытой в середине абзаца. Также все другие известные генераторы Lorem Ipsum используют один и тот же текст, который они просто повторяют, пока не достигнут нужный объём. Это делает предлагаемый здесь генератор единственным настоящим Lorem Ipsum генератором. Он использует словарь из более чем 200 латинских слов, а также набор моделей предложений. В результате сгенерированный Lorem Ipsum выглядит правдоподобно, не имеет повторяющихся абзацей или "невозможных" слов.
					Что такое Lorem Ipsum?
					Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.
					Почему он используется?
					Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах, которое не получается при простой дубликации "Здесь ваш текст.. Здесь ваш текст.. Здесь ваш текст.." Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, так что поиск по ключевым словам "lorem ipsum" сразу показывает, как много веб-страниц всё ещё дожидаются своего настоящего рождения. За прошедшие годы текст Lorem Ipsum получил много версий. Некоторые версии появились по ошибке, некоторые - намеренно (например, юмористические варианты).
					Откуда он появился?
					Многие думают, что Lorem Ipsum - взятый с потолка псевдо-латинский набор слов, но это не совсем так. Его корни уходят в один фрагмент классической латыни 45 года н.э., то есть более двух тысячелетий назад. Ричард МакКлинток, профессор латыни из колледжа Hampden-Sydney, штат Вирджиния, взял одно из самых странных слов в Lorem Ipsum, "consectetur", и занялся его поисками в классической латинской литературе. В результате он нашёл неоспоримый первоисточник Lorem Ipsum в разделах 1.10.32 и 1.10.33 книги "de Finibus Bonorum et Malorum" ("О пределах добра и зла"), написанной Цицероном в 45 году н.э. Этот трактат по теории этики был очень популярен в эпоху Возрождения. Первая строка Lorem Ipsum, "Lorem ipsum dolor sit amet..", происходит от одной из строк в разделе 1.10.32
					Классический текст Lorem Ipsum, используемый с XVI века, приведён ниже. Также даны разделы 1.10.32 и 1.10.33 "de Finibus Bonorum et Malorum" Цицерона и их английский перевод, сделанный H. Rackham, 1914 год.
					Где его взять?
					Есть много вариантов Lorem Ipsum, но большинство из них имеет не всегда приемлемые модификации, например, юмористические вставки или слова, которые даже отдалённо не напоминают латынь. Если вам нужен Lorem Ipsum для серьёзного проекта, вы наверняка не хотите какой-нибудь шутки, скрытой в середине абзаца. Также все другие известные генераторы Lorem Ipsum используют один и тот же текст, который они просто повторяют, пока не достигнут нужный объём. Это делает предлагаемый здесь генератор единственным настоящим Lorem Ipsum генератором. Он использует словарь из более чем 200 латинских слов, а также набор моделей предложений. В результате сгенерированный Lorem Ipsum выглядит правдоподобно, не имеет повторяющихся абзацей или "невозможных" слов.
				</div>
				<div class="confirm_block">
					<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="confirm">
						<input type="checkbox" id="confirm" class="mdl-checkbox__input confirm_checkbox_js">
						<span class="mdl-checkbox__label">Я принимаю условия соглашения</span>
					</label>
					<form action="">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored confirm_btn_js" name="confirm_agent" disabled="disabled">Продолжить</button>
					</form>
				</div>
			</div>
		<?}?>
	</div>
</div>

<script>
	$(function(){
		$('.confirm_checkbox_js').on('change', function(){
			if($(this).prop('checked')){
				$('.confirm_btn_js').attr('disabled', false);
			}else{
				$('.confirm_btn_js').attr('disabled', true);
			}
		});
		$('.open_close_btn_js').on('click', function(){
			var qty = $(this).closest('.orders_history_content').find('.agents_client_order').size();
			if ($(this).closest('.orders_history_content').height() == 50){
				$(this).closest('.orders_history_content').css('max-height', qty*50 + 'px');
			}else{
				$(this).closest('.orders_history_content').css('max-height', '50px');
			}
			$(this).closest('.orders_history_content').toggleClass('opened');
		});
	});
</script>