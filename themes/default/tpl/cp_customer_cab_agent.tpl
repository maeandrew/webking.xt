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
						<p class="info_descr_text">AG<?=$_SESSION['member']['id_user']?></p>
					</div>
					<div type="submit" class="action_icon">
						<form action="<?=Link::Custom('promo_certificate')?>" target="_blank">
							<button><i id="print_promocode" class="material-icons">print</i></button>
							<div class="mdl-tooltip" for="print_promocode">Распечатать сертификат</div>
						</form>
					</div>
				</div>
				<div class="info_item clients">
					<div class="info_icon">
						<i class="material-icons">&#xE7F0;</i>
					</div>
					<div class="info_descr">
						<p class="info_descr_title">Привелечено клиентов:</p>
						<p class="info_descr_text">0</p>
					</div>
				</div>
				<div class="info_item bonuses">
					<div class="info_icon">
						<i class="material-icons">&#xE227;</i>
					</div>
					<div class="info_descr">
						<p class="info_descr_title">Получено бонусов:</p>
						<p class="info_descr_text">0 грн.</p>
					</div>
					<div class="action_icon hidden">
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
			</div>
		<?}else{?>
			<a class="bonus_detalies" href="<?=Link::Custom('page', 'Torgovyj_agent');?>" class="details">
				<i class="material-icons">help_outline</i> Детали агентской программы
			</a>
			<div class="license_agreement">
				<h2>Условия соглашения сотрудничества</h2>
				<div class="license_agreement_descr">
					<h4>1. ПРЕДМЕТ СОГЛАШЕНИЯ И ВСТУПЛЕНИЕ В СИЛУ</h4>
					<p>
						<strong>1.1.</strong>&nbsp;Настоящее Соглашение регулирует отношения между Пользователем, с одной стороны, и Администрацией сайта http://www.x-torg.com (далее - Администрация), с другой стороны, по предоставлению Пользователю права доступа к www.x-torg.com (далее - Портал) и право пользования инструментами Портала, согласно учетной записи при регистрации.</p>
					<p>
						<strong>1.2.</strong>&nbsp;Настоящее Соглашение вступает в силу с момента нажатия пользователем кнопки, завершающей процедуру регистрации и позволяющей Пользователю приступить к использованию услуг Портала, подтверждение получения настоящей оферты происходит путем выражения Пользователем согласия с его условиями при прохождении процедуры регистрации на сайте &nbsp;&nbsp;www. x-torg.com и действует на протяжении всего периода использования услуг Портала Пользователем.</p>
					<h4>
						<u>2. ИСПОЛЬЗУЕМЫЕ ТЕРМИНЫ</u></h4>
					<p>
						<u>Портал</u>&nbsp;- программный комплекс, размещенный в сети интернет по адресу www.x-torg.com и предоставляющий Пользователям WEB-интерфейс с функциональными возможностями, различными для каждой из учетных записей, а также Посетителей портала.</p>
					<p>
						<u>Посетитель портала или Гость</u>&nbsp;- человек, просматривающий страницы Портала и не имеющий Учетной записи (аккаунта) или в текущее время не авторизованный на Портале. Посетитель может просматривать страницы Портала.</p>
					<p>
						<u>Пользователь</u>&nbsp;- физическое лицо, добровольно прошедшее регистрацию на Портале, являющееся одной из сторон настоящего Соглашения.<br />
						Пользователем может быть дееспособное совершеннолетнее лицо, либо несовершеннолетний, достигший 16 лет и объявленный полностью дееспособным (эмансипированным) в порядке, предусмотренном действующим законодательством Украины.</p>
					<p>
						<u>Регистрация</u>&nbsp;- процедура, в ходе которой Пользователь предоставляет достоверные данные о себе по утвержденной Администрацией форме, а также Логин и Пароль. Регистрация считается завершенной только в случае успешного прохождения Пользователем всех ее этапов, Нажатие пользователем кнопки &laquo;ПОДТВЕРДИТЬ&raquo; &nbsp;является моментом заключения настоящего Соглашения между Пользователем и Администрацией Портала, т.е. полного и безоговорочного согласия Сторон с условиями настоящего Соглашения.</p>
					<p>
						<u>Логин</u>&nbsp;- уникальное имя (псевдоним) Пользователя, указанный им при Регистрации с целью использования для идентификации Пользователя и используемый в сочетании с Паролем для получения доступа Пользователя к сервисам Портала.</p>
					<p>
						<u>Пароль</u>&nbsp;- буквенно-цифровой код, указанный Пользователем при Регистрации, хранимый обеими сторонами настоящего Соглашения в тайне от третьих лиц и используемый в сочетании с Логином для получения доступа Пользователя к сервисам Портала.<br />
						Логин и пароль, введенные Пользователем, признаются Сторонами аналогом собственноручной подписи Пользователя.</p>
					<p>
						<u>Персональные регистрационные данные Пользователя</u>&nbsp;- данные, добровольно указанные Пользователем при прохождении Регистрации. Данные хранятся в базе данных Портала и подлежат использованию исключительно в соответствии с настоящим Соглашением и действующим законодательством Украины.</p>
					<p>
						<u>Оферта</u>- это предложение, сделанное с целью заключить договор. Т.е. оферта всегда предшествует заключению договора.</p>
					<h4>
						<u>3. ПРАВА И ОБЯЗАННОСТИ СТОРОН</u></h4>
					<h4>
						3.1. Права и обязанности Администрации.</h4>
					<p>
						<strong>3.1.1.</strong>&nbsp;Администрация вправе предоставить Пользователю доступ к Порталу и поддерживать Портал и инструменты в рабочем состоянии.</p>
					<p>
						<strong>3.1.2.</strong>&nbsp;Администрация оставляет за собой право следить за деятельностью Пользователя в рамках использования им Портала и предотвращать публикацию любых Материалов, нарушающих настоящее Соглашение, а также принимать меры по наложению на Пользователя ответственности, предусмотренной в данном Соглашении и находящейся в компетенции Администрации.<br />
						Администрация имеет право отказать Пользователю в размещении информации любого вида без предупреждения и без объяснения причин такого отказа.<br />
						Администрация может на свое усмотрение в любой момент удалить размещаемую Пользователями информацию без предупреждения и без объяснения причин такого удаления</p>
					<p>
						<strong>3.1.3.</strong>&nbsp;Пользователь соглашается с тем, что Администрация может использовать (обрабатывать и т.п.) его персональные данные, указанные Пользователем при регистрации, в целях проведения мероприятий, связанных с Порталом, а также направлять на предоставленный Пользователем электронный адрес и размещать в пространстве, ограниченном доступом Пользователя, рекламные и информационные сообщения по своему усмотрению.</p>
					<p>
						Администрация Портала имеет право сохранять следующую информацию об использовании Пользователями (Посетителями) Портала: частоту посещаемости страниц, активность, дату последней авторизации, посещаемость разделов каталога товаров и прочее. Администрация Портала гарантирует, что подобная информация не будет передана третьим лицам, кроме случаев, прямо предусмотренных действующим законодательством Украины, и будет использована исключительно в статистических целях, которые позволят оценить качество сервиса и, возможно, улучшить или усовершенствовать его.</p>
					<p>
						Администрация Портала обеспечивает сохранность Вашей конфиденциальной информации.</p>
					<p>
						Администрация Портала оставляет за собой право передавать информацию об использовании Портала в обобщенном виде (не персонифицированную, и не привязанную к учетным записям Пользователей) третьим лицам в целях отображения статистики работы Портала, а также при проведении маркетинговых или других исследованиях.</p>
					<p>
						Администрация не несет ответственности за разглашение Пользователем своей конфиденциальной информации, а также, если такая информация стала известной из-за халатности, или в виду других обстоятельств, и не обязана возмещать моральный и/или материальный ущерб, понесенный Пользователем в случае её разглашения.</p>
					<p>
						<strong>3.1.4.</strong>&nbsp;Администрация обязуется осуществлять техническую поддержку Пользователя по вопросам и в порядке, как указано ниже.</p>
					<p>
						<strong>3.1.5.</strong>&nbsp;Техническая поддержка в форме письменной или устной телефонной консультации предоставляется только по официальному запросу Пользователя, направленному в службу поддержки Порталаwww.x-torg.com. Консультация специалиста может быть предоставлена по следующим вопросам: регистрация и проблемы при ее прохождении, функционирование Портала и его инструментов, восстановление утраченного пароля доступа. Не предоставляются консультации по вопросам настройки оборудования, программного обеспечения или Интернет-доступа Пользователя или иных третьих лиц, а также по другим вопросам, не имеющим отношения к работе Портала.</p>
					<p>
						<strong>3.1.6.</strong>&nbsp;Администратор не обязуется возвращать или уничтожать Материалы, предоставленные Пользователем в связи или при пользовании Портала.</p>
					<h4>
						3.2. Права и обязанности Посетителя.</h4>
					<p>
						<strong>3.2.1.</strong>&nbsp;Посетитель обязуется строжайшим образом соблюдать все условия данного Соглашения.</p>
					<p>
						<strong>3.2.2.</strong>&nbsp;Посетитель обязуется не пользоваться доступом к содержимому Портала иными способами, кроме как через веб-интерфейс Портала или через встроенный флеш-плеер.</p>
					<h4>
						3.3. Права и обязанности Пользователя</h4>
					<p>
						<strong>3.3.1.</strong>&nbsp;Пользователь имеет право использовать Портал не запрещенными настоящим Соглашением и действующим законодательством Украины способами.</p>
					<p>
						<strong>3.3.2.</strong>&nbsp;Пользователь принимает на себя полную ответственность за содержимое загруженной им информации, за нарушение прав интеллектуальной собственности (авторских прав) и других прав третьих лиц, за использование товарных знаков, логотипов и брендов, несогласованное с их владельцами, а также за какие-либо иные нарушения прав и интересов третьих лиц, осуществленные размещением Пользователем информации на Портале.</p>
					<p>
						Администрация не несет ответственности за содержимое файлов и информации, за несоответствие информации требованиям действующего законодательства Украины, а также за какие-либо иные нарушения прав и интересов третьих лиц, осуществленные размещением Пользователем информации на Портале, а также отосланной при помощи внутренней системы сообщений Портала. В случае если Администрации поступят какие-либо претензии от третьих лиц, связанные с содержимым информации или сообщений, урегулирование конфликта и разногласий полностью возлагается на Пользователя, загрузившего эту информацию или отославшего эти сообщения.</p>
					<p>
						<strong>3.3.3.</strong>&nbsp;В случае возникновения в работе Портала проблем технического характера, а также в случае получения Пользователем сообщений, являющихся несанкционированной рекламной рассылкой либо содержащих запрещенные настоящим Соглашением Материалы, в том числе угрозы или файлы с подозрением на вирус, в случае если Пользователь обнаруживает факты, дающие основания полагать, что его доступ был использован кем-либо несанкционированно, Пользователь имеет право обратиться к Администрации для выяснения ситуации и принятия необходимых мер.</p>
					<p>
						<strong>3.3.4.</strong>&nbsp;Пользователь ответственен за хранение пароля/логина вне доступа третьих лиц и своевременную их смену в случае утери или иной необходимости.</p>
					<h4>
						<u>4. ОТВЕТСТВЕННОСТЬ СТОРОН</u></h4>
					<h4>
						4.1. Ответственность Администрации.</h4>
					<p>
						<strong>4.1.1.</strong>&nbsp;Администрация обязуется обеспечить конфиденциальность и сохранность персональных данных Пользователя от третьих лиц кроме случаев, когда такое разглашение произошло по не зависящим от Администрации причинам, а также за исключением случаев, предусмотренных действующим законодательством Украины.</p>
					<p>
						<strong>4.1.2.</strong>&nbsp;Администрация обязуется обеспечить стабильную работу Портала, постепенное его совершенствование, максимально быстрое исправление ошибок в работе Портала, однако:</p>
					<p>
						Портал предоставляется Пользователю по принципу &laquo;как есть&raquo;. Это означает, что Администрация:</p>
					<ul>
						<li>
							не гарантирует отсутствие ошибок в работе Портала;</li>
						<li>
							не несет ответственность за его бесперебойную работу, их совместимость с программным обеспечением и техническими средствами Пользователя и иных лиц;</li>
						<li>
							не несет ответственность за потерю Материалов или за причинение любых убытков, которые возникли или могут возникнуть в связи, с или при пользовании Порталом;</li>
						<li>
							не несет ответственности, связанной с любым искажением, изменением, оптической иллюзией изображений, фото- видео- и иных Материалов Пользователя, которое может произойти или производится при использовании Портала, даже если это вызовет насмешки, скандал, осуждение или пренебрежение;</li>
						<li>
							не несет ответственность за неисполнение либо ненадлежащее исполнение своих обязательств вследствие сбоев в телекоммуникационных и энергетических сетях, действий вредоносных программ, а также недобросовестных действий третьих лиц, направленных на несанкционированный доступ и/или выведение из строя программного и/или аппаратного комплекса Портала.</li>
					</ul>
					<p>
						<strong>4.1.3.</strong>&nbsp;Администрация не при каких обстоятельствах не несет ответственности за содержание опубликованных, отправленных Пользователем или полученных им от других Пользователей Материалов и сообщений. Также Администрация не несет ответственности за результаты Договоров, Сделок купли-продажи, или любых других отношений между пользователями, совершенных при помощи сервисов Портала.</p>
					<p>
						<strong>4.1.4.</strong>&nbsp;Администрация не обязуется контролировать содержание Материалов и ни при каких обстоятельствах не несет ответственность за соответствие их требованиям действующего законодательства Украины, а также за возможное нарушение прав третьих лиц в связи с размещением Материалов при или в связи с использованием Портала.</p>
					<h4>
						4.2. Ответственность Пользователя</h4>
					<p>
						<strong>4.2.1.</strong>&nbsp;Пользователь несет ответственность за предоставление достоверной информации о себе при Регистрации.</p>
					<p>
						<strong>4.2.2.</strong>&nbsp;Пользователь соглашается никогда и ни при каких обстоятельствах не использовать Портал для:</p>
					<p>
						1. публикации, распространения, хранения, передачи в любой форме (например, но не ограничиваясь, в форме текстового сообщения, вложенного файла любого формата, ссылки на размещение в сети) Материалов, которые:</p>
					<ul>
						<li>
							носят непристойный, оскорбительный, вульгарный, вредоносный, угрожающий, клеветнический, деликтный, ложный или порнографический характер;</li>
						<li>
							оскорбляют честь и достоинство, права и законные интересы третьих лиц, способствуют разжиганию религиозной, расовой, этнической или межнациональной розни, содержат элементы насилия, призывают к нарушению действующего законодательства и противоправным действиям и т.п.;</li>
						<li>
							нарушают права на результаты интеллектуальной деятельности и на средства индивидуализации (в том числе авторские, смежные, патентные и т.д.) третьих лиц;</li>
						<li>
							нарушают права несовершеннолетних лиц;</li>
						<li>
							способствуют возникновению интереса к или распространению наркотиков, оружия и боеприпасов, любой форме террористической, противоправной и нацистской деятельности;</li>
						<li>
							содержат не разрешенную к разглашению информацию (информацию, составляющую государственную тайну, персональные данные третьих лиц, информацию, запрещенную к разглашению в силу договорных или фидуциарных отношений Пользователя и т.п.);</li>
						<li>
							направлены против других Пользователей;</li>
						<li>
							содержат программные вирусы или иные компьютерные коды, программы, файлы, направленные на нарушение функциональности любого компьютерного или телекоммуникационного оборудования, их частей, в том числе серверов и прочих компонентов сетевой инфраструктуры и программного обеспечения. Пересылка вредоносных программ запрещена в любом виде, в том числе в виде полного программного кода, либо его части, отдельных файлов любых форматов, а также ссылок на их размещение в сети;</li>
						<li>
							содержат несанкционированную с Администратором рекламную информацию, спам, флуд, &laquo;письма счастья&raquo;, схемы многоуровневого маркетинга, способы заработка в Интернет (в том числе с использованием e-mail), информацию, провоцирующую &laquo;цепную реакцию&raquo; в рассылке сообщений получателями и другую аналогичную информацию, имеют в заголовке более половины заглавных букв, содержат ненормативную лексику, содержат орфографические ошибки в словах;</li>
						<li>
							материалы, которые намеренным или случайным образом нарушают законодательство Украины.</li>
					</ul>
					<p>
						2. подключения и использования любого программного обеспечения, предназначенного для взлома или агрегации личных данных других Пользователей, включая логины, пароли и т.д., а также для проведения автоматической массовой рассылки какого бы то ни было содержания.</p>
					<p>
						3. для введения кого-либо в заблуждение путем присвоения себе чужого имени и намеренной публикации, отправки сообщений или другого способа использования присвоенного имени противозаконно, для умышленного нанесения убытков кому- либо или в любых корыстных целях.</p>
					<p>
						<strong>4.2.3.</strong>&nbsp;Присоединяясь к настоящему Соглашению, Пользователь понимает, принимает и соглашается с тем, что он:</p>
					<ul>
						<li>
							несет полную личную ответственность за содержание и соответствие нормам украинского и международного законодательства всех Материалов, включая все тексты, программы, музыку, звуки, фотографии, графику, видео и т.д.</li>
						<li>
							несет полную личную ответственность за соответствие способов использования им Материалов других Пользователей и другой информации, представленной на Портале, нормам украинского или международного права (в том числе, но не ограничиваясь, нормам права об интеллектуальной собственности и о защите информации);</li>
						<li>
							несет полную ответственность за сохранность своей учетной записи (логина и пароля), а также за все действия, совершенные под своей учетной записью;</li>
						<li>
							использует Портал на свой собственный риск.</li>
					</ul>
					<p>
						<strong>4.2.4.</strong>&nbsp;В случае нарушения Пользователем какого-либо из условий настоящего Соглашения Администрация оставляет за собой право прекратить доступ Пользователя к Порталу (в том числе путем блокирования доступа к серверу IP-адреса, с которого была осуществлена регистрация данного Пользователя/было размещено наибольшее количество Материалов данного Пользователя) и передать Материалы, подтверждающие незаконные действия Пользователя, для принятия мер в правоохранительные органы.</p>
					<p>
						<strong>4.2.5.</strong>&nbsp;Пользователь соглашается с тем, что возместит Администрации любые убытки, понесенные Администрацией в связи с использованием Пользователем Портала, нарушением Пользователем настоящего Соглашения и прав (в том числе интеллектуальных, информационных и т.д.) третьих лиц.</p>
					<p>
						<strong>4.2.6.</strong>&nbsp;Пользователь признает и соглашается, что IP-адрес персональной ЭВМ Пользователя фиксируется техническими средствами Администрации, и в случае совершения незаконных действий, в том числе действий, нарушающих интеллектуальные права третьих лиц, ответственным за указанные незаконные действия признается владелец персональной ЭВМ, определяемой техническими средствами Администратора по принадлежности IP-адреса.</p>
					<h4>
						<u>5. ИНТЕЛЛЕКТУАЛЬНЫЕ ПРАВА</u></h4>
					<p>
						<strong>5.1.</strong>&nbsp;Портал, его составляющие и отдельные компоненты (в том числе, но не ограничиваясь: программы для ЭВМ, базы данных, коды, лежащие в их основе, ноу-хау, алгоритмы, элементы дизайна, шрифты, логотипы, а также текстовые, графические и иные материалы) являются объектами интеллектуальной собственности, охраняемыми в соответствии с национальным и международным законодательством, любое использование которых допускается только на основании разрешения правообладателя.</p>
					<p>
						<strong>5.2.</strong>&nbsp;Незаконное использование указанных в п. 5.1. настоящего Соглашения объектов интеллектуальной собственности влечет гражданскую, административную и уголовную ответственность.</p>
					<p>
						<strong>5.3.</strong>&nbsp;Пользователь не вправе осуществлять в отношении Портала, их составляющих и компонентов воспроизведение (тиражирование и иное копирование), распространение, модификацию, переформатирование и иную переработку. Любые компоненты Портала запрещается использовать в составе других сайтов, программных продуктов, поисковых систем, других произведений и объектов смежных прав, копировать или иным способом использовать с целью извлечения материальной выгоды.</p>
					<h4>
						<u>6. ФОРС-МАЖОР И ЧРЕЗВЫЧАЙНЫЕ ОБСТОЯТЕЛЬСТВА</u></h4>
					<p>
						<strong>6.1.</strong>&nbsp;Стороны не несут ответственности за нарушение своих обязательств, которые возникли после вступления в силу настоящего Соглашения, если такое нарушение вызвано форс-мажорными обстоятельствами.</p>
					<p>
						<strong>6.2.</strong>&nbsp;Форс-мажорные обстоятельства означают чрезвычайные обстоятельства вне разумного контроля Сторон, включая, но не ограничиваясь, следующими обстоятельствами:</p>
					<ul>
						<li>
							война или другие военные действия (независимо от того, является ли война объявленной или необъявленной), оккупация, действия иностранных противников, мобилизация, реквизиция или эмбарго;</li>
						<li>
							ионизирующая радиация или радиоактивное заражение, вызванное определенным видом ядерного топлива или ядерных отходов, полученных в результате сжигания ядерного топлива, токсичных радиоактивных взрывчатых веществ и других вредных свойств взрывчатых или взрывных ядерных устройств или ядерных компонентов;</li>
						<li>
							перевороты, революции, бунты, военные диктатуры или захват власти и гражданскую войну;</li>
						<li>
							пожары, землетрясения, наводнения;</li>
						<li>
							акты и действия государственных органов, делающие невозможным исполнение обязательств по настоящему Договору в соответствии с законным порядком.</li>
					</ul>
					<h4>
						<u>7. РАЗРЕШЕНИЕ СПОРОВ И УДОВЛЕТВОРЕНИЕ ПРЕТЕНЗИЙ</u></h4>
					<p>
						<strong>7.1.</strong>&nbsp;Все споры и претензии регулируются на основании положений настоящего Соглашения, а в случае их не урегулирования &mdash; в порядке, установленном действующим законодательством Украины.</p>
					<p>
						<strong>7.2.</strong>&nbsp;Любые вопросы, комментарии и иная корреспонденция Пользователя должны направляться Администрации по адресам и телефонам, указанным на странице Контакты на сайте www. x-torg.com. Администрация не несет ответственности и не гарантирует ответ на запросы, вопросы, предложения и иную информацию, направленные ему любым другим способом.</p>
					<p>
						<strong>7.3.</strong>&nbsp;Возникшие в связи с настоящим Соглашением претензии, связанные с нарушением интеллектуальных прав третьих лиц, направляются Пользователем Администрации Портала по следующему адресу электронной почты: contact@ x-torg.com. Администрация обязуется в течение 10 (десяти) рабочих дней ответить на данную претензию, направив письмо с изложением своей позиции по указанному в претензии адресу электронной почты. При этом претензии Пользователей, которых не представляется возможным идентифицировать на основе предоставленных им при регистрации данных (в том числе анонимные претензии), Администрацией не рассматриваются. В случае если Пользователь не согласен с мотивами, приведенными Администрацией в ответе на претензию, процедура ее урегулирования повторяется при помощи направления мотивированного ответа Пользователя с использованием почтовой связи, а именно заказным письмом с уведомлением. В случае невозможности разрешения претензии путем переговоров, спор разрешается в порядке, предусмотренным настоящим Соглашением.</p>
					<p>
						<strong>7.4.</strong>&nbsp;Пользователь и Администрация соглашаются, что все возможные споры, возникшие в связи с настоящим Соглашением, разрешаются сторонами по нормам украинского права и рассматриваются по месту нахождения Администрации.</p>
					<h4>
						<u>8. СРОК ДЕЙСТВИЯ СОГЛАШЕНИЯ</u></h4>
					<p>
						<strong>8.1.</strong>&nbsp;Настоящее Соглашение заключается между сторонами на неопределенный срок при условии непрерывного использования Портала Пользователем.</p>
					<p>
						<strong>8.2.</strong>&nbsp;В случае, если Пользователь не пользуется Порталом в течение 90 календарных дней, а также в случае нарушения Пользователем условий настоящего Соглашения Администрация вправе прекратить действие логина и пароля Пользователя. Логин и пароль Пользователя будут сохранены с возможностью повторной активации в течение 90 дней после прекращения возможности использованиия Портала Пользователем. Для активации Пользователь должен обратиться к Администрации для повторного получения ссылки активации на указанный при первой регистрации электронный адрес. При этом право предоставления либо непредоставления Пользователю повторной активации принадлежит Администрации.</p>
					<h4>
						<u>9. ДОПОЛНИТЕЛЬНЫЕ УСЛОВИЯ</u></h4>
					<p>
						<strong>9.1.</strong>&nbsp;Администрация оставляет за собой право в одностороннем порядке и без предварительного уведомления Пользователей изменять условия Соглашения, разместив при этом окончательную версию Соглашения на странице по адресу&nbsp;http://x-torg.com.ua/page/Dogovor/&nbsp;за 5 (пять) дней до вступления изменений в силу. Положения новой редакции Пользовательского Соглашения становятся обязательными для всех ранее зарегистрировавшихся пользователей Сайта.</p>
					<p>
						<strong>9.2.</strong>&nbsp;Настоящее Соглашение ни при каких обстоятельствах не может быть трактовано как договор об установлении агентских отношений, отношений товарищества, отношений по совместной деятельности, отношений личного найма, либо каких-то иных отношений между Пользователем и Администратором, прямо не указанных в настоящем Cоглашении.</p>
					<h3>
						Посещение сайтов третьих лиц</h3>
					<p>
						Сайт Портала может содержать ссылки на другие сайты и сервисы третьих лиц, которые не контролируются Администрацией. Администрация не несет ответственности за содержимое, правила пользования и политику безопасности сайтов третьих лиц.</p>
					<p>
						Администрация не несет ответственности за действия и последствия действий Посетителей и Пользователей, которые переходят по ссылкам с Портала на сайты третьих лиц.</p>
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