<div id="content">
	<?if($GLOBALS['CurrentController'] == 'main'){?>
		<input type="checkbox" id="read_more" class="hidden">
		<div class="content_page">
			<?=$data['new_content']?>
		</div>
		<?if(strlen($data['new_content']) >= 500){?>
			<label for="read_more">Читать полностью</label>
		<?}?>
	<?}else{?>
		<div class="content_page">
			<?=$data['new_content']?>
		</div>
	<?}?>
	<?if(isset($sdescr)){
		echo $sdescr;
	}?>

	<!-- Страница "Доставка" -->
	<div id="base" class="page_delivery hidden">
		<div class="blockline">
			<img class="delivery1 forflex" src="/themes/default/images/page/delivery/delivery1.png" alt="">
			<h1>Доставка</h1>
		</div>
		<div class="blockline flexwrapp">			
			<div class="forflex blockOfText">
				<h4>Доставка транспортной <br>компанией</h4>
				<div>
					<p>Отправим удобным перевозчиком:</p>					
					<p>1. Запомните ТТН и номер отделения</p>
					<p>2. При получении проверьте товар</p>
					<p>3. Оплатите услуги перевозчика</p>					
				</div>	
			</div>
			<div class="forflex blockOfImg">
				<img class="delivery4" src="/themes/default/images/page/delivery/delivery4.png" alt="">
			</div>										
		</div>
		<div class="blockline flexwrapp">
			<video class="blockOfImg" id="movie" width="495" height="278" src="/themes/default/images/page/delivery/delivery3.mp4" autoplay loop>			   
			</video>
			<div class="forflex blockOfText blockForOrder">
				<h4>XT доставка</h4>
				<p>Наша логистика работает за счёт <br>собственного автопарка.</p>
			</div>			
		</div>
		<div class="blockline flexwrapp">
			<div class="forflex blockOfText">
				<h4>Самовывоз</h4>
				<p>Производится с парковочных стоянок <br>ТЦ Барабашово, а еще у нас бесплатная <br>доставка товара до парковки.</p>
			</div>
			<div class="forflex blockOfImg">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1282.2924160061052!2d36.29807765817873!3d50.00039271893146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTDCsDAwJzAxLjQiTiAzNsKwMTcnNTcuMCJF!5e0!3m2!1sru!2sru!4v1455287401346" width="495" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>
		<div class="blockline">
			<img class="delivery5" src="/themes/default/images/page/delivery/delivery5.png" alt="">			
		</div>
	</div>

	<!-- Страница "Как стать дилером" -->
	<div id="base" class="become_a_dealer hidden">
		<div class="dealer_line_first  mdl-grid">
			<h4 class="mdl-cell mdl-cell--12-col">Если Вы умеете</h4>
			<ul class="abilities_list mdl-cell mdl-cell--5-col">
				<li>Определять границы территории</li>
				<li>Понимать потребности клиента</li>
				<li>Снабжать торговые точки прайсами</li>
				<li>Собирать заказы</li>
				<li>Доставлять товар</li>
				<li>Правильно расходовать топливо</li>
			</ul>
			<div class="mdl-cell mdl-cell--5-col">
				<img class="car_pic" src="/themes/default/images/page/deliveryCar.png"/ alt="машина xt">
			</div>
		</div>
		
		<h4>Мы предоставим</h4>
		
		<div class="services">			
			<div class="services_item">
				<p>Ассортимент</p>
				<div class="circleForImg"></div>
			</div>
			
			<div class="services_item">
				<p>Дилерские цены</p>
				<div class="circleForImg"></div>
			</div>

			<div class="services_item">
				<p>Свободный график</p>
				<div class="circleForImg"></div>
			</div>

			<div class="services_item">
				<p>Бесплатное обучение</p>
				<div class="circleForImg"></div>
			</div>
		
			<div class="services_item">
				<p>Независимость от склада</p>
				<div class="circleForImg"></div>
			</div>

			<div class="services_item">
				<p>Готовый план действий</p>
				<div class="circleForImg"></div>
			</div>
			
		</div>
		<button class="mdl-cell mdl-cell--12-col">Присоединяйтесь к нам!</button>
	</div>

	<!-- Страница "Справка" -->
	<div id="base" class="page_information hidden">
		<div class="info_line">
			<img class="info0" src="/themes/default/images/page/info/info0.png" alt="">
			<h1>Справка</h1>
		</div>
		<div class="info_line flexwrapp">
			<div id="infoBlock1" class="info_block forflex" data-target="ppp1">
				<img src="/themes/default/images/page/info/info1.png" alt="someimg">
				<h4>Гарантия и сервис</h4>
			</div>
			<div id="infoBlock2" class="info_block forflex" data-target="ppp2">
				<img src="/themes/default/images/page/info/info2.png" alt="someimg">
				<h4>Вопросы и ответы</h4>
			</div>
			<div id="infoBlock3" class="info_block forflex" data-target="ppp3">
				<img src="/themes/default/images/page/info/info3.png" alt="someimg">
				<h4>Оплата и доставка</h4>
			</div>			
		</div>
		<div class="blockforline hidden">
			<div id="blockwrapp">
				<div class="block1"></div>
				<div class="block2"></div>
			</div>
		</div>
				
		<div id="info_text_block_service" class="ppp1 info_line flexwrapp hidden">
			<section class="ac-container">
				<div>
					<input id="ab-1" name="accordion-1" type="checkbox" />
					<label for="ab-1">На какие товары предоставляется гарантия?</label>
					<article class="ac-large">							
						<p>На товары в нашем магазине предоставляется гарантия, подтверждающая обязательства по отсутствию в товаре заводских дефектов. Гарантия предоставляется на срок от 2-х недель до 36 месяцев в зависимости от сервисной политики производителя. Срок гарантии указан в описании каждого товара на нашем сайте. Подтверждением гарантийных обязательств служит гарантийный талон производителя, или гарантийный талон "ROZETKA — online супермаркет продвинутой электроники".

						Пожалуйста, проверьте комплектность и отсутствие дефектов в товаре при его получении (комплектность определяется описанием изделия или руководством по его эксплуатации).</p>
					</article>
				</div>
				<div>
					<input id="ab-2" name="accordion-1" type="checkbox" />
					<label for="ab-2">Куда обращаться за гарантийным обслуживанием?</label>
					<article class="ac-large">
						<p>Гарантийным обслуживанием занимаются сервисные центры, авторизованные производителями.
						Адреса и телефоны сервисных центров вы можете найти на гарантийном талоне или по адресу — полный список сервисных центров.

						Право на бесплатное гарантийное обслуживание дает гарантийный талон, в котором указываются:

						модель;
						серийный номер;
						гарантийный срок;
						дата продажи товара.

						Пожалуйста, сохраняйте его в течение всего срока эксплуатации.

						Срок ремонта определяется авторизованным СЦ, в случае возникновения проблем с сервис-партнером, вы можете обратиться в точку продажи.</p>
					</article>
				</div>
				<div>
					<input id="ab-3" name="accordion-1" type="checkbox" />
					<label for="ab-3">Я могу обменять или вернуть товар?</label>
					<article class="ac-large">
						<p>Да, вы можете обменять или вернуть товар в течение 14 дней после покупки. Это право гарантирует вам «Закон о защите прав потребителя».

						Чтобы использовать эту возможность, пожалуйста убедитесь что:

						- товар, не был в употреблении и не имеет следов использования: царапин, сколов, потёртостей, на счётчике телефона не более 5 минут разговоров, программное обеспечение не подвергалось изменениям и т. п.; 
						- товар полностью укомплектован и не нарушена целостность упаковки; 
						- сохранены все ярлыки и заводская маркировка.

						Если товар не работает, обмен или возврат товара производится только при наличии заключения сервисного центра, авторизованного производителем, о том, что условия эксплуатации не нарушены.</p>
					</article>
				</div>
				<div>
					<input id="ab-4" name="accordion-1" type="checkbox" />
					<label for="ab-4">Где и как можно произвести обмен или возврат?</label>
					<article class="ac-large">
						<p>Обменять или вернуть товар можно в нашем сервисном отделе по адресу:

						г. Киев, улица Ярославская, 57 c понедельника по пятницу с 10-00 до 19-00, в субботу — с 10-00 до 17-00.

						Сервисный отдел раздела "Бытовая техника и интерьер" находится по адресу г. Киев, улица Фрунзе, 40.


						При возврате товара нужно иметь при себе паспорт. Мы вернем деньги в день возврата товара или, в случае отсутствия денег в кассе, не позже, чем через 7 дней.

						Если вы живете не в Киеве, можете отправить товар обратно тем же способом, которым вы его получили, например с помощью "Новой Почты". Если у товара сохранён товарный вид и упаковка, мы обменяем его вам или вернём деньги.</p>
					</article>
				</div>
				<div>
					<input id="ab-5" name="accordion-1" type="checkbox" />
					<label for="ab-5">Сервисный центр не может отремонтировать мой товар в гарантийный период</label>
					<article class="ac-large">
						<p>Если в гарантийный период товар, который вы у нас купили, вышел из строя по вине производителя и не может быть отремонтирован в авторизованном сервисном центре, мы обменяем товар на аналогичный или вернём деньги.

						Для этого, пожалуйста, предоставьте нам:

						- товар с полной комплектацией; 
						- гарантийный талон; 
						- документ подтверждающий оплату; 
						- заключение сервисного центра с отметкой о том, что товар имеет «существенный недостаток».</p>
					</article>
				</div>
				<div>
					<input id="ab-6" name="accordion-1" type="checkbox" />
					<label for="ab-6">В каких случаях гарантия не предоставляется?</label>
					<article class="ac-large">
						<p>Сервисный центр может отказать в гарантийном ремонте если:

						- нарушена сохранность гарантийных пломб; 
						- есть механические или иные повреждения, которые возникли вследствие умышленных или неосторожных действий покупателя или третьих лиц; 
						- нарушены правила использования, изложенные в эксплуатационных документах; 
						- было произведено несанкционированное вскрытие, ремонт или изменены внутренние коммуникации и компоненты товара, изменена конструкция или схемы товара; 
						- неправильно заполнен гарантийный талон; 
						- серийный или IMEI номер, находящийся в памяти изделия, изменён, стёрт или не может быть установлен.

						Гарантийные обязательства не распространяются на следующие неисправности:

						- естественный износ или исчерпание ресурса; 
						- случайные повреждения, причиненные клиентом или повреждения, возникшие вследствие небрежного отношения или использования (воздействие жидкости, запыленности, попадание внутрь корпуса посторонних предметов и т. п.); 
						- повреждения в результате стихийных бедствий (природных явлений); 
						- повреждения, вызванные аварийным повышением или понижением напряжения в электросети или неправильным подключением к электросети; 
						- повреждения, вызванные дефектами системы, в которой использовался данный товар, или возникшие в результате соединения и подключения товара к другим изделиям; 
						- повреждения, вызванные использованием товара не по назначению или с нарушением правил эксплуатации.

						Согласно статьи 9 Закона Украины «О защите прав потребителей». Кабинетом Министров Украины утвержден перечень товаров надлежащего качества, которые не подлежат обмену или возврату.

						К таким товарам относятся:

						перопуховые изделия
						детские игрушкимягкие
						детские игрушки резиновые надувные
						перчатки
						тюлегардинные и кружевные полотна
						белье нательное
						белье постельное
						чулочно-носочныеизделия
						печатные издания
						диски для лазерных систем считывания с записью
						товары для новорожденных (пеленки, соски, бутылочки для кормления т.д.)
						товары для личной гигиены (например: эпиляторы, электробритвы, машинки для стрижки волос)
						продовольственные товары (детское питание и т.д.)</p>
					</article>
				</div>
				<label><a class="a_question" href="#">Не нашли ответ на свой вопрос?</a></label>
			</section>
		</div>
		<div id="info_text_block_answers" class="ppp2 info_line flexwrapp hidden">	
			<section class="ac-container">
				<div>
					<input id="ac-1" name="accordion-2" type="checkbox" />
					<label for="ac-1">Какой у вас график работы?</label>
					<article class="ac-large">							
						<p>Мы работаем по следующему графику:</p>

						<p>Call-центр:</p>

						<p>- понедельник — пятница: с 8-00 до 21-00; </p>
						<p>- суббота: с 9-00 до 20-00; </p>
						<p>- воскресенье: с 10-00 до 19-00.</p>

						<p>Магазины в г. Киев, ул. Ярославская, 57 и г. Одесса, ул. Балковская, 199:</p>

						<p>- понедельник — пятница: с 10-00 до 21-00; </p>
						<p>- суббота: с 10-00 до 19-00; </p>
						<p>- воскресенье: с 10-00 до 17-00.</p>	
					</article>
				</div>
				<div>
					<input id="ac-2" name="accordion-2" type="checkbox" />
					<label for="ac-2">Я хочу обменять или вернуть товар. Какой график работы у сервисного отдела?</label>
					<article class="ac-small">
						<p>Сервисный отдел работает: c понедельника по пятницу с 10-00 до 19-00, в субботу — с 10-00 до 17-00. По адресу: г. Киев, улица Ярославская, 57</p>
					</article>
				</div>
				<div>
					<input id="ac-3" name="accordion-2" type="checkbox" />
					<label for="ac-3">На сайте указано, что товара нет в наличии, можно ли его заказать?</label>
					<article class="ac-small">
						<p>Вы можете оставить свой адрес электронной почты и мы пришлем Вам уведомление, как только товар появится в наличии.</p>
					</article>
				</div>
				<div>
					<input id="ac-4" name="accordion-2" type="checkbox" />
					<label for="ac-4">Какие преимущества дает регистрация?</label>
					<article class="ac-small">
						<p>Регистрация позволяет вам:
							- просматривать историю своих заказов; 
							- получать по электронной почте рассылку о новинках и акциях Розетки.

							Логином для входа (т. е. полем, по которому система сможет вас распознать) является адрес электронной почты.
						</p>
					</article>
				</div>
				<div>
					<input id="ac-5" name="accordion-2" type="checkbox" />
					<label for="ac-5">Как отменить заказ?</label>
					<article class="ac-small">
						<p>Вы можете отменить заказ по телефону (044) 537-0-222 или (044) 503-80-80.</p>
					</article>
				</div>
				<div>
					<input id="ac-6" name="accordion-2" type="checkbox" />
					<label for="ac-6">Что делать, если оплаченный товар не доставлен?</label>
					<article class="ac-small">
						<p>Мы страхуем весь товар, который отправляем в другие города. В случае отсутствия (по каким-либо причинам) Вашего товара в офисе перевозчика, мы в течение 2 — 3 дней отправим Вам новый товар.</p>
					</article>
				</div>
				<div>
					<input id="ac-7" name="accordion-2" type="checkbox" />
					<label for="ac-7">Какая гарантия, что после предоплаты заказа я его получу?</label>
					<article class="ac-medium">
						<p>У вас остаются два документа, которые подтверждают наше с Вами сотрудничество: выписанная нами счет-фактура и документ об оплате, который предоставляет банк. При перечислении денег у нас возникает долговое обязательство перед Вами. Оно погашается только после подписания накладной, которую Вам привезет курьер.

						Таким образом, у Вас есть все рычаги влияния на нас: суд, общество защиты прав потребителей и прочие. Также Ваши интересы защищает закон "О защите прав потребителей".</p>
					</article>
				</div>
				<div>
					<input id="ac-8" name="accordion-2" type="checkbox" />
					<label for="ac-8">Какая гарантия, что отправляемый товар не подменят в пути?</label>
					<article class="ac-small">
						<p>Любой товар сопровождается заполненным гарантийным талоном, в котором указан его серийный номер. Таким образом, любая подмена исключена.</p>
					</article>
				</div>
				<label><a class="a_question" href="#">Не нашли ответ на свой вопрос?</a></label>
			</section>
		</div>
		<div id="info_text_block_delivery" class="ppp3 info_line flexwrapp hidden">
			<section class="ac-container">
				<div>
					<input id="ad-1" name="accordion-3" type="checkbox" />
					<label for="ad-1">Куда и на каких условиях осуществляется доставка?</label>
					<article class="ac-large">							
						<p>Условия доставки зависят от региона. Мы доставляем товары по всей Украине, кроме АР Крым и некоторых регионов Донецкой и Луганской областей.

						Вы также можете сами забрать заказ в нашем магазине в г. Киев, в точках в крупных городах и в отделениях Новой Почты.

						Условия доставки бытовой техники и товаров от других продавцов несколько отличаются от остальных товаров.</p>
					</article>
				</div>
				<div>
					<input id="ad-2" name="accordion-3" type="checkbox" />
					<label for="ad-2">Как я могу оплатить свой заказ?</label>
					<article class="ac-small">
						<p>Сейчас доступны такие способы оплаты:
							- наличная оплата;
							- безналичная оплата
							- оплата картами Visa и MasterCard

							<a>Мы постарались также дать ответы на другие вопросы, касающиеся оплаты.</a></p>
					</article>
				</div>
				<div>
					<input id="ad-3" name="accordion-3" type="checkbox" />
					<label for="ad-3">Как осуществляется доставка по Киеву?</label>
					<article class="ac-small">
						<p>Доставка в пределах Киева при заказе на сумму свыше 1500 грн бесплатна
							Стоимость доставки товаров до 1500 грн составляет 35 грн.

							Товары из разделов "Активный отдых и туризм", "Дом, сад", "Музыкальные инструменты", "Детский мир", "Одежда и обувь", "Косметика и парфюмерия" доставляются бесплатно при сумме заказа от 500 грн.

							Товары из раздела "Бытовая техника и интерьер" по Киеву доставляются бесплатно при сумме заказа от 1500 грн, стоимость доставки заказов до 1500 грн составляет 35 грн. Доставка товаров из данного раздела по Киеву и Украине осуществляется отдельно от доставки товаров из других разделов сайта.

							Наш курьер продемонстрирует работоспособность товара (для устройств, работающих автономно) и оформит все необходимые документы:

							- гарантийный талон; 
							- документ, подтверждающий оплату.

							Время доставки:

							- понедельник — пятница: с 9:00 до 21:00;
							- суббота — с 10:00 до 19:00;
							- воскресенье: с 10:00 до 17:00.</p>
					</article>
				</div>
				<div>
					<input id="ad-4" name="accordion-3" type="checkbox" />
					<label for="ad-4">Как осуществляется доставка по Киевской области?</label>
					<article class="ac-small">
						<p>Стоимость доставки — 35 грн

							Стоимость доставки бытовой техники составляет 4 грн. за км, от черты Киева, в одну сторону (расстояние до 30 км).

							Сроки доставки по Киевской области озвучивает менеджер при оформлении заказа.</p>
					</article>
				</div>
				<div>
					<input id="ad-5" name="accordion-3" type="checkbox" />
					<label for="ad-5">Как осуществляется доставка по Украине?</label>
					<article class="ac-small">
						<p>- Новая Почта
							- Точки выдачи в областных центрах
							- Мист Экспресс

							<a>Подробнее о доставке по Украине
							</a>
							Стоимость доставки товаров из раздела "Бытовая техника и интерьер" определяется по тарифам компаний-перевозчиков: <a>узнать подробнее</a>.</p>
					</article>
				</div>
				<div>
					<input id="ad-6" name="accordion-3" type="checkbox" />
					<label for="ad-6">Можно ли приехать к вам в офис?</label>
					<article class="ac-small">
						<p>Да, наши магазины расположены по адресу 
							г. Киев, ул. Ярославская, 57
							Для товаров из раздела "Бытовая техника и интерьер" только г. Киев, ул.Фрунзе, 40
							Вы сможете посмотреть товары вживую и купить то, что понравится. Если Вы хотите какой-то конкретный товар, можно предварительно уточнить его наличие по телефону. Если этого товара не окажется в магазине, мы доставим его со склада к Вашему приходу</p>
					</article>
				</div>
				<div>
					<input id="ad-7" name="accordion-3" type="checkbox" />
					<label for="ad-7">Как можно оплатить заказ наличными?</label>
					<article class="ac-medium">
						<p>Оплата наличными при получении товара возможна во всех населенных пунктах на территории Украины. 
						Оплата производится исключительно в национальной валюте.
						В подтверждение оплаты мы выдаем Вам товарный чек.</p>
					</article>
				</div>
				<div>
					<input id="ad-8" name="accordion-3" type="checkbox" />
					<label for="ad-8">Как оплатить товар по безналичному расчету? Являетесь ли вы плательщиком НДС?</label>
					<article class="ac-small">
						<p>Вы можете оплатить заказ банковским переводом либо с помощью платежных карт Visa и MasterCard любого банка.

						Позвоните или напишите нам и мы отправим Вам счет-фактуру по электронной почте или по факсу. Мы являемся плательщиками НДС и налога на прибыль на общих основаниях.

						При получении товара вы получите все необходимые документы:

						- гарантийный талон; 
						- расходную накладную; 
						- налоговую накладную.

						Оплатить заказ картами Visa и MasterCard можно только при оформлении заказа через сайт</p>
					</article>
				</div>
				<div>
					<input id="ad-9" name="accordion-3" type="checkbox" />
					<label for="ad-9">Что нужно для получения товара, оплаченного по безналичному расчету?</label>
					<article class="ac-small">
						<p>Для частных лиц:

							- паспорт.

							Для юридических лиц и СПД:

							- доверенность, выписанная на предъявителя 
							- копия свидетельства плательщика НДС (если есть).

							Без оформления доверенности товар может получить директор предприятия лично, с заверением расходных накладных круглой печатью предприятия</p>
					</article>
				</div>
				<div>
					<input id="ad-10" name="accordion-3" type="checkbox" />
					<label for="ad-10">Возможна ли оплата заказа банковской картой?</label>
					<article class="ac-small">
						<p>Вы можете оплатить заказ онлайн любой картой Visa и MasterCard любого банка без комиссии.
						Оплата с помощью платежных карт осуществляется следующим способом:
						во время оформления заказа на сайте, Вам будет предложено сделать выбор способа оплаты. В графе "Оплата" вам нужно выбрать «Visa/MasterCard». После этого Вы будете переадресованы на страницу системы безопасных платежей ПриватБанка, где Вам необходимо будет подтвердить оплату.
						Пожалуйста, обратите внимание, получить товар, оплаченный платежной картой, может только тот клиент, на ФИО которого оформлен заказ, поэтому при получении заказа обязательно нужно иметь при себе паспорт.</p>
					</article>
				</div>
				<label><a class="a_question" href="#">Не нашли ответ на свой вопрос?</a></label>
			</section>
		</div>

		<div class="info_line">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit adipisci pariatur, nihil laboriosam fugit, laborum. Quisquam, iure blanditiis voluptatibus, quibusdam deserunt nobis vero quaerat cupiditate, animi consequatur sed vel facilis.</p>
			<p>Qui, magni, adipisci molestiae temporibus nulla aperiam optio doloribus commodi velit delectus beatae et eligendi. Quae quia, voluptates illum sint dolorem mollitia iste nostrum rem. Provident corrupti esse reiciendis molestiae.</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit adipisci pariatur, nihil laboriosam fugit, laborum. Quisquam, iure blanditiis voluptatibus, quibusdam deserunt nobis vero quaerat cupiditate, animi consequatur sed vel facilis.</p>
			<p>Qui, magni, adipisci molestiae temporibus nulla aperiam optio doloribus commodi velit delectus beatae et eligendi. Quae quia, voluptates illum sint dolorem mollitia iste nostrum rem. Provident corrupti esse reiciendis molestiae.</p>
		</div>

		<div id="question" data-type="modal">
			<div class="modal_container blockForForm">				
				<div class="mdl-card__supporting-text">
					<p>Вы можете задать свой вопрос и получить ответ по электронной почте</p>
					<form action="">
						<div class="mdl-textfield mdl-js-textfield">
							<input class="mdl-textfield__input" type="text" id="sample1">
							<label class="mdl-textfield__label" for="sample1">Email...</label>
						</div><br>
						<div class="mdl-textfield mdl-js-textfield">
							<textarea class="mdl-textfield__input" type="text" rows= "3" id="sample5" ></textarea>
							<label class="mdl-textfield__label" for="sample5">Вопрос...</label>
						</div><br>							
					</form>
				</div>
				<div class="mdl-card__actions mdl-card--border">
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Задать вопрос</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Страница "Оплата" -->
	<div id="page_payment" class="page_payment hidden" >
		<div class="info_line">
			<img class="payment0" src="/themes/default/images/page/payment/payment0.png" alt="">
			<h1>Оплата</h1>
		</div>

		<div class="info_line flexwrapp">
			<div id="paymentBlock1" class="payment_block forflex" data-target="ppp1">
				<img src="/themes/default/images/page/payment/payment1.png" alt="someimg">
				<h4>Он-лайн <br>оплата</h4>
			</div>
			<div id="paymentBlock2" class="payment_block forflex" data-target="ppp2">
				<img src="/themes/default/images/page/payment/payment2.png" alt="someimg">
				<h4>Офф-лайн <br>оплата</h4>
			</div>
			<div id="paymentBlock3" class="payment_block forflex" data-target="ppp3">
				<img src="/themes/default/images/page/payment/payment3.png" alt="someimg">
				<h4>Наложенный <br>платёж</h4>
			</div>
			<div id="paymentBlock4" class="payment_block forflex" data-target="ppp4">
				<img src="/themes/default/images/page/payment/payment4.png" alt="someimg">
				<h4>Безналичный <br>платёж</h4>
			</div>			
		</div>

		<div class="blockforline hidden">
			<div id="blockwrapp2">
				<div class="block1"></div>
				<div class="block2"></div>
			</div>
		</div>

		<div id="info_text_block_on_line" class="ppp1 info_line styleFortext flexwrapp hidden">
			<p>Приват24</p>
			<p>Web Money</p>
			<p>Яндекс Деньги</p>
		</div>
		<div id="info_text_block_off_line" class="ppp2 info_line styleFortext flexwrapp hidden">	
			<div class="forflex">
				<h5>Через терминал</h5>
				<p>1. Получить платёжные реквизиты.</p>
				<p>2. Оплатить заказ и забрать квитанцию.</p>
				<p>3. Сообщить название бакна, сумму оплаты и номер заказа менеджеру.</p>
			</div>
			<div class="forflex">
				<h5>Через кассу</h5>
				<p>1. Получить номер карты ПриватБанка.</p>
				<p>2. Пополнить карту и распечатать квитанцию.</p>
				<p>3. Сообщить сумму оплаты и номер заказа менеджеру.</p>
			</div>
		</div>
		<div id="info_text_block_payment_1" class="ppp3 info_line styleFortext flexwrapp hidden">
			<div class="forflex">
				<h5>Транспортная компания</h5>
				<p>Комиссия за передачу средств 2%.</p>
			</div>
			<div class="forflex">
				<h5>Курьер XT</h5>
				<p>Нет комиссии за передачу средств.</p>
			</div>
		</div>
		<div id="info_text_block_payment_2" class="ppp4 info_line styleFortext flexwrapp hidden">
			<p>Счёт фактура доступен в меню биллинг, после оформления заказа. </p>
			<p>Мы не возвращаем НДС</p>
		</div>

		<div class="info_line">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit adipisci pariatur, nihil laboriosam fugit, laborum. Quisquam, iure blanditiis voluptatibus, quibusdam deserunt nobis vero quaerat cupiditate, animi consequatur sed vel facilis.</p>
			<p>Qui, magni, adipisci molestiae temporibus nulla aperiam optio doloribus commodi velit delectus beatae et eligendi. Quae quia, voluptates illum sint dolorem mollitia iste nostrum rem. Provident corrupti esse reiciendis molestiae.</p>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit adipisci pariatur, nihil laboriosam fugit, laborum. Quisquam, iure blanditiis voluptatibus, quibusdam deserunt nobis vero quaerat cupiditate, animi consequatur sed vel facilis.</p>
			<p>Qui, magni, adipisci molestiae temporibus nulla aperiam optio doloribus commodi velit delectus beatae et eligendi. Quae quia, voluptates illum sint dolorem mollitia iste nostrum rem. Provident corrupti esse reiciendis molestiae.</p>
		</div>
	</div>


	<div>
		<!-- <div>
			<h4>Он-лайн</h4>
			<div class="payment_methods">
				<img src="/themes/default/images/page/payment/payment1.png" alt="Приват банк">
				<img src="/themes/default/images/page/payment/payment2.png" alt="web money">
				<img src="/themes/default/images/page/payment/payment3.png" alt="Яндекс деньги">
			</div>
		</div>
		<div>
			<h4>Офф-лайн</h4>
			<div>
				<div>
					<h4>Через терминал</h4>
					<img src="/themes/default/images/page/payment/payment4.png" alt="">
					<ol>
						<li>Получить номер карты ПриватБанка.</li>
						<li>Пополнить карту и распечатать квитанцию.</li>
						<li>Сообщить сумму оплаты и номер заказа менеджеру.</li>
					</ol>
				</div>
				<div>
					<h4>Через кассу</h4>
					<img src="/themes/default/images/page/payment/payment4.png" alt="">
					<ol>
						<li>Получить платёжные реквизиты.</li>
						<li>Оплатить заказ и забрать квитанцию.</li>
						<li>Сообщить название бакна, сумму оплаты и номер заказа менеджеру.</li>
					</ol>
				</div>
			</div>
		</div>
		<div>
			<h4>Наложенный платёж</h4>
			<div>
				<div>
					<h4>Транспортная компания</h4>
					<img src="/themes/default/images/page/payment/payment4.png" alt="">
					<p>Комиссия за передачу средств 2%.</p>
				</div>
				<div>
					<h4>Курьер xT</h4>
					<p>Нет комиссии за передачу средств.</p>
				</div>
			</div>
		</div>
		<div>
			<h4>Безналичный платёж</h4>
			<div>
				<p>Счёт фактура доступен в меню биллинг, после оформления заказа.</p>
				<img src="/themes/default/images/page/payment/payment4.png" alt="">
				<p>Мы не возвращаем НДС</p>
			</div>
		</div> -->
	</div>

	<!-- Страница "O нас" -->
	<div id="base" class="page_about_us hidden">
		<div class="blockline">
			<img class="about1" src="/themes/default/images/page/about/about1.png" alt="">
			<h1>Немного о нас</h1>
			<p>XT - служба снабжения,<br>поставляющая товары непродовольственной<br>группы на предприятия, в магазины и<br>домашние хозяйства.</p>			
		</div>
		<div class="blockline">
			<h4>Что мы создали</h4>
			<p>1500 человек со всей Украины ежедневно покупают на XT, а так же мы ежедневно поставляем товары в 42 предприятия.</p>
			<div class="second_line_img">
				<img class="about2" src="/themes/default/images/page/about/about2.png" alt="">
				<p class="text1">
					<span>7,000</span><br>оптовых клиентов регулярно производят закупки на XT
				</p>
				<p class="text2">
					<span>140,000</span><br>товаров в ассортименте
				</p>
			</div>			
		</div>
		<div class="blockline">
			<h4>Что мы ценим</h4>
			<p>Мы стремимся к простоте и прозрачности. Работая с XT клиент всегда уверен в соответствии каталога складу, а доставка - всегда своевременна. Ещё, мы действительно гордимся нашими оптовыми скидками.</p>
			<img class="about3" src="/themes/default/images/page/about/about3.png" alt="">
		</div>
		<div class="blockline">
			<h4>Наша миссия</h4>
			<p>Опираясь на многолетний опыт, качественно и быстро решаем задачи снабжения каждой компании, создавая комфортные условия для бизнеса.</p>
			<div class="members hidden">
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Виталий Пасичник</p>
					<p class="person_post">Основатель<br>компании</p>
				</div>
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Николай Козлов</p>
					<p class="person_post">Заместитель<br>директора</p>
				</div>
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Елена Пальчик</p>
					<p class="person_post">Финансовый<br>директор</p>
				</div>
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Валентина Игушева</p>
					<p class="person_post">Руководитель отдела<br>кадров</p>
				</div>
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Диана Жердева</p>
					<p class="person_post">Motion graphics<br>дизайнер</p>
				</div>
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Оксана Вишневская</p>
					<p class="person_post">Старший менеджер по<br>продажам</p>
				</div>
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Виталий Чуприна</p>
					<p class="person_post">Руководитель отдела<br>логистики</p>
				</div>
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Наталья Ясинская</p>
					<p class="person_post">Главный<br>бухгалтер</p>
				</div>
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Владимир Моисеенко</p>
					<p class="person_post">Системный<br>администратор</p>
				</div>
				<div class="member">
					<div class="divForPhoto"><img src="" alt=""></div>
					<p class="person">Алена Гвоздик</p>
					<p class="person_post">Руководитель отдела<br> продаж</p>
				</div>
			</div>
		</div>
		<div class="blockline">
			<img class="about4" src="/themes/default/images/page/about/about4.png" alt="">
			<h4>Мы стараемся ради Вас!<br>Присоединяйтесь!</h4>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function () {
			var left = {
				0: '18%',
				1: '48%',
				2: '77%'
			}
			var left2 = {
				0: '15%',
				1: '37%',
				2: '58%',
				3: '80%'
			}
			$('.info_block').click(function (e) {
				var target = $('.'+$(this).data('target')),
					eq = $(this).index();
				if($(this).hasClass('active')){
					$('.info_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
					$('[id^="info_text_block_"], .blockforline').addClass('hidden');
				}else{
					target.removeClass('hidden');
					$('.blockforline').removeClass('hidden');
					$('[class^="ppp"]').addClass('hidden')
					$('.info_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
					$(this).addClass('active');
					target.removeClass('hidden')
					$(this).find('img').css('-webkit-filter', 'grayscale(0%)');
					$(".block1, .block2").css({"left": left[eq]});					
				}
					// $(".block2").css({"left": left[eq]});
			});

			$('.a_question').click(function(event) {
				openObject('question');
			});

			$('.payment_block').click(function (e) {
				var target = $('.'+$(this).data('target')),
					eq = $(this).index();
				if($(this).hasClass('active')){
					$('.payment_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
					$('[id^="info_text_block_"], .blockforline').addClass('hidden');
				}else{
					target.removeClass('hidden');
					$('.blockforline').removeClass('hidden');
					$('[class^="ppp"]').addClass('hidden')
					$('.payment_block').removeClass('active').find('img').css('-webkit-filter', 'grayscale(100%)');
					$(this).addClass('active');
					target.removeClass('hidden')
					$(this).find('img').css('-webkit-filter', 'grayscale(0%)');					
					$(".block1, .block2").css({"left": left2[eq]});
				}
					// $(".block2").css({"left": left[eq]});
			});

	 		// $('#infoBlock1').click(function (e) {
	 		//     $('#infoBlock1').removeClass('hidden');
	 		//      	$('#infoBlock1 img').css('-webkit-filter', 'grayscale(0%)');
	 		//      	$('#infoBlock2 img').css('-webkit-filter', 'grayscale(100%)');
	 		//      	$('#infoBlock3 img').css('-webkit-filter', 'grayscale(100%)');
	 		//     $('#info_text_block_service').removeClass('hidden');
	 		//     $('#info_text_block_answers').addClass('hidden');
	 		//     $('#info_text_block_delivery').addClass('hidden');	
	 		//     	$(".block1").animate({"left": "18%"}, "slow");
	 		//     	$(".block2").animate({"left": "18%"}, "slow");            
	 		// });
	 		// $('#infoBlock2').click(function (e) {
	 		//     $('.blockforline').removeClass('hidden');
	 		//     	$('#infoBlock2 img').css('-webkit-filter', 'grayscale(0%)');
	 		//     	$('#infoBlock1 img').css('-webkit-filter', 'grayscale(100%)');
	 		//     	$('#infoBlock3 img').css('-webkit-filter', 'grayscale(100%)');
	 		//     $('#info_text_block_answers').removeClass('hidden');
	 		//     $('#info_text_block_service').addClass('hidden');
	 		//     $('#info_text_block_delivery').addClass('hidden');
	 		//     	$(".block1").animate({"left": "48%"}, "slow");
	 		//     	$(".block2").animate({"left": "48%"}, "slow");
	 		// });
	 		// $('#infoBlock3').click(function (e) {
	 		//     $('.blockforline').removeClass('hidden');
	 		//     	$('#infoBlock3 img').css('-webkit-filter', 'grayscale(0%)');
	 		//     	$('#infoBlock1 img').css('-webkit-filter', 'grayscale(100%)');
	 		//     	$('#infoBlock2 img').css('-webkit-filter', 'grayscale(100%)');
	 		//     $('#info_text_block_delivery').removeClass('hidden');
	 		//     $('#info_text_block_service').addClass('hidden');
	 		//     $('#info_text_block_answers').addClass('hidden');
	 		//     	$(".block1").animate({"left": "77%"}, "slow");
	 		//     	$(".block2").animate({"left": "77%"}, "slow");
	 		// });
	 		// $(':not(.info_block)').click(function (e) {
	 		// 	$('#infoBlock1 img').css('-webkit-filter', 'grayscale(100%)');
	 		// 	$('#infoBlock2 img').css('-webkit-filter', 'grayscale(100%)');
	 		// 	$('#infoBlock3 img').css('-webkit-filter', 'grayscale(100%)');
	 		// });
	 	});	
	</script>

</div><!--id="content"-->

