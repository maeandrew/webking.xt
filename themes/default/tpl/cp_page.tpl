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

	<!-- Страница "Справка" -->
	<div id="base" class="page_information hidden">
		<div>
			<img src="" alt="someimg">
			<p>Оплата и доставка</p>
		</div>
		<div>
			<img src="" alt="someimg">
			<p>Гарантия и сервис</p>
		</div>
		<div>
			<img src="" alt="someimg">
			<p>Оплата и доставка</p>
		</div>
		<div>
			<img src="" alt="someimg">
			<p>Оплата и доставка</p>
		</div>
    </div>

	<!-- Страница "Оплата" -->
	<div id="base" class="page_payment hidden" >
		<div>
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
		</div>
    </div>

	<!-- Страница "O нас" -->
	<div id="base" class="page_about_us hidden">
		<div class="page_about_us_first_line">
			<img src="/themes/default/images/page/about/about1.png" alt="">
			<h1>Немного о нас</h1>
			<p>XT - служба снабжения,<br>поставляющая товары непродовольственной<br>группы на предприятия, в магазины и<br>домашние хозяйства.</p>			
		</div>
		<div class="page_about_us_second_line">
			<h4>Что мы создали</h4>
			<p>1500 человек со всей Украины ежедневно покупают на XT, а так же мы ежедневно поставляем товары в 42 предприятия.</p>
			<div class="second_line_img">
				<p class="text1"><span>7,000</span><br>оптовых клиентов регулярно производят закупки на XT</p>
				<p class="text2"><span>140,000</span><br>товаров в ассортименте</p>
			</div>			
		</div>
		<div class="page_about_us_third_line">
			<h4>Что мы ценим</h4>
			<p>Мы стремимся к простоте и прозрачности. Работая с XT клиент всегда уверен в соответствии каталога складу, а доставка - всегда своевременна. Ещё, мы действительно гордимся нашими оптовыми скидками.</p>
			<img src="/themes/default/images/page/about/about3.png" alt="">
		</div>
		<div class="page_about_us_fourth_line">
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
		<div class="page_about_us_fifth_line">				
			<img src="/themes/default/images/page/about/about4.png" alt="">
			<h4>Мы стараемся ради Вас!<br>Присоединяйтесь!</h4>
		</div>
	</div>


</div><!--id="content"-->