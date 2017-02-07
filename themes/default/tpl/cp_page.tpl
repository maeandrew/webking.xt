<div id="content">
	<?if($GLOBALS['CurrentController'] == 'main'){?>
		<input type="checkbox" id="read_more" class="hidden">
		<div class="content_page">
			<?=$data['new_content'];?>
		</div>
		<?if(strlen($data['new_content']) >= 500){?>
			<label for="read_more">Читать полностью</label>
		<?}?>
	<?}else{?>
		<div class="content_page">
            <div id="page_agent" class="page_agent">
                <div class="blockline">
                    <img class="main_img" src="/themes/default/images/page/payment/payment0.png" alt="">
                    <p class="tagline"> </p>
                    <h1>Торговый агент заработок от 1000 до 20&nbsp;000&nbsp;грн в месяц.</h1>
                </div>
                <div class="blockline">
                    <div class="container flexwrapp">
                        <div class="forflex">
                            <h4>Зарабатывай с заказов привлеченного клиента:</h4>
                            <ul>
                                <li><i class="material-icons">done</i> 5,0% с РОЗНИЧНЫХ (0 - 1000 грн) заказов;</li>
                                <li><i class="material-icons">done</i> 2,0% с ОПТОВЫХ (1000 - 5000 грн) заказов;</li>
                                <li><i class="material-icons">done</i> 1,5% с ДИЛЕРСКИХ (5000 - 10000 грн) заказов;</li>
                                <li><i class="material-icons">done</i> 0,5% с ПАРТНЕРСКИХ (10000 - 100000 грн) заказов.</li>

                                <li><i class="material-icons">done</i> 50 грн подключение дилера.</li>
                                <li><i class="material-icons">done</i> 50 грн подключение торгового агента.</li>



                            </ul>
                        </div>
                        <div class="forflex">
                            <img class="payment_information_img"  src="/themes/default/images/page/payment/payment3.png">
                        </div>
                    </div>
                </div>
                <div class="agent__getstarted">
                    <p>Начинайте прямо сейчас:<a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent login_btn agent__analytic__btn">Создать аккаунт</a></p>
                </div>
                <div class="blockline">
                    <div class="container flexwrapp">
                        <div class="forflex">
                            <img  src="/themes/default/images/page/dealer/dealer0.png" alt="">
                        </div>
                        <div class="forflex">
                            <h4>Все очень просто:</h4>
                            <ul>
                                <li><i class="material-icons">done</i>зарегистрируйся на сайте xt.ua;</li>
                                <li><i class="material-icons">done</i>получи промокод агента;</li>
                                <li><i class="material-icons">done</i>расскажи о нашем сайте: соседям, друзьям, знакомым, предпринимателям на рынке, владельцам магазинов, руководителям организациий.....;</li>
                                <li><i class="material-icons">done</i>помоги оформить заказ и укажи свой код агента в поле промокод;</li>
                                <li><i class="material-icons">done</i>новый клиент, оформивший заказ с вашим промокодом, получает подарок;</li>
                                <li><i class="material-icons">done</i>вы зарабатываете с первого и последующих заказов, привлеченных вами клиентов.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="blockline three_inline_wrap">
                    <h4>Кто наши клиенты</h4>
                    <div class="flexwrapp three_inline">
                        <div class="forflex">
                            <h4>Предприятия</h4>
                            <ul>
                                <li><i class="material-icons">done</i>Базы отдыха</li>
                                <li><i class="material-icons">done</i>Коммунальные предприятия</li>
                                <li><i class="material-icons">done</i>Бани и сауны</li>
                                <li><i class="material-icons">done</i>Аграрные предприятия</li>
                                <li><i class="material-icons">done</i>Фабрики</li>
                                <li><i class="material-icons">done</i>Учебные заведения</li>
                                <li><i class="material-icons">done</i>Строительные компании</li>
                            </ul>
                        </div>
                        <div class="forflex">
                            <h4>Магазины</h4>
                            <ul>
                                <li><i class="material-icons">done</i>Магазины 1000 мелочей</li>
                                <li><i class="material-icons">done</i>Магазины бытовой и цифровой техники</li>
                                <li><i class="material-icons">done</i>Магазины хозтоваров</li>
                                <li><i class="material-icons">done</i>Магазины канцтовары</li>
                                <li><i class="material-icons">done</i>Магазины книг</li>
                                <li><i class="material-icons">done</i>Магазины одежды</li>
                                <li><i class="material-icons">done</i>Магазины спорт товаров</li>
                            </ul>
                        </div>
                        <div class="forflex">
                            <h4>Частные лица</h4>
                            <ul>
                                <li><i class="material-icons">done</i>Домохозяйки</li>
                                <li><i class="material-icons">done</i>Студенты</li>
                                <li><i class="material-icons">done</i>Пенсионеры</li>
                                <li><i class="material-icons">done</i>Мамы</li>
                                <li><i class="material-icons">done</i>Рабочие</li>
                                <li><i class="material-icons">done</i>Учителя</li>
                                <li><i class="material-icons">done</i>Ваш сосед</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="agent__getstarted">
                    <p>Начинайте прямо сейчас:<a href="#" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent login_btn agent__analytic__btn">Создать аккаунт</a></p>
                </div>
                <div class="blockline contacts">
                    <h4>Возникли вопросы? Звони и мы поможем</h4>
                    <p><a href="tel:0675447255">(067) 544-72-55</a></p>
                    <p><a href="tel:0503037564">(050) 303-75-64</a></p>
                </div>
            </div>
		</div>
	<?}?>
	<?if(isset($sdescr)){
		echo $sdescr;
	}?>
</div><!--id="content"-->