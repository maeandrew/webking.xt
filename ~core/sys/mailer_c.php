<?php
require_once($GLOBALS['PATH_sys'].'mail/class.phpmailer.php');
class Mailer extends PHPMailer {
	public $priority = 3;
	public $to_name;
	public $to_email;
	public $oApi;
	public $From = null;
	public $FromName = null;
	public $Sender = null;
	public $echo = false;
  
	public function __construct(){
		$mcfg = $GLOBALS['MAIL_CONFIG'];

		// Берем из файла config.php массив $mcfg

		if($mcfg['smtp_mode'] == 'enabled'){
			$this->Host = $mcfg['smtp_host'];
			$this->Port = $mcfg['smtp_port'];
			if($mcfg['smtp_username'] != ''){
				$this->SMTPAuth  = true;
				$this->Username  = $mcfg['smtp_username'];
				$this->Password  =  $mcfg['smtp_password'];
			}
			$this->Mailer = "smtp";
		}
		if(!$this->From){
			$this->From = $mcfg['from_email'];
		}
		if(!$this->FromName){
			$this->FromName = $mcfg['from_name'];
		}
		if(!$this->Sender){
			$this->Sender = $mcfg['from_email'];
		}
		$this->Priority = $this->priority;
		$this->CharSet = "UTF-8";

		$sPubKey = $GLOBALS['CONFIG']['smtp_key_public'];
		require($GLOBALS['PATH_model'].'APISMTP.php');
		$this->oApi = new SmtpApi($sPubKey);
		$this->oApi->setPublicKey($sPubKey);
	}

	public function SendCustomEmail($address, $subject = '', $content = ''){
		// Устанавливаем тему письма
		$this->Subject = $subject;
		// Задаем тело письма
		$this->Body = $content;
		// Добавляем адрес в список получателей
		$this->isHTML(true);
		$this->AddAddress($address);
		if(!$this->echo){
			ob_start();
		}
		if(!$this->Send()){
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $address." - Не могу отослать письмо! \n<br>";
			return false;
		}else{
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $address." - Письмо отослано! \n<br>";
			return true;
		}
		if(!$this->echo){
			ob_end_clean();
		}
	}
	// Отсылка письма контрагенту со ссылками на накладные покупателя и контрагета
	public function SendOrderInvoicesToContragent($id_order){
		global $db;
		$Order = new Orders();
		$Order->SetFieldsById($id_order);
		// Устанавливаем тему письма
		$this->Subject = 'Накладная покупателя и контрагента по заказу № '.$id_order;
		// Задаем тело письма
		$this->Body = "Поступил заказ № ".$id_order."\n\n".
			"Накладная покупателя - ".$_SERVER['SERVER_NAME'].'/'."invoice_customer/".$id_order."/".$Order->fields['skey']. "\n\n";
		$sql = "SELECT email, name FROM "._DB_PREFIX_."user AS u, "._DB_PREFIX_."order AS o WHERE u.id_user = o.id_contragent AND o.id_order = ".mysql_real_escape_string($id_order);
		$arr = $db->GetOneRowArray($sql);
		// Добавляем адрес в список получателей
		$this->AddAddress($arr['email'], $arr['name']);
		if(!$this->echo){
			ob_start();
		}
		if(!$this->Send()){
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $arr['email']." - Не могу отослать письмо! \n<br>";
			return false;
		}else{
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $arr['email']." - Письмо отослано! \n<br>";
			return true;
		}
		if(!$this->echo){
			ob_end_clean();
		}
	}
	public function SendConsulRequest($data){
		$RET = "Поступил запрос на обратный звонок:<br>
		Имя клиента: ".$data['name']."<br>
		Телефон клиента: ".$data['phone']."<br>
		Тема вопроса: ".$data['topic']."<br>
		Запрос отправлен ".date("d.m.Y")." в ".date("H:i");
		$aEmail = array(
			'html' => $RET,
			'subject' => $data['topic'],
			'encoding' => "UTF-8",
			'from' => array(
				'name' => $this->FromName,
				'email' => 'callback@x-torg.com',
			),
			'to' => array(
				array(
					'email' => $GLOBALS['CONFIG']['consult_request_email'],
				),
			),
		);
		if(!$this->res = $this->oApi->send_email($aEmail)){
			return false;
		}
		return true;
		// // Устанавливаем тему письма
		// $this->Subject = "Запрос на обратный звонок";
		// // Задаем тело письма
		// $this->Body = "Поступил запрос на обратный звонок:<br>".
		// 	"Имя клиента: ".$data['name']."<br>".
		// 	"Телефон клиента: ".$data['phone']."<br>".
		// 	"Тема вопроса: ".$data['topic']."<br>".
		// 	"Запрос отправлен ".date("d.m.Y")." в ".date("H:i");
		// $this->isHTML(true);
		// // print_r($GLOBALS['CONFIG']['consult_request_email']);
		// // Добавляем адрес в список получателей
		// $this->AddAddress($GLOBALS['CONFIG']['consult_request_email'], 'CallBack');
		// if(!$this->Send()){
		// 	$this->ClearAddresses();
		// 	$this->ClearAttachments();
		// 	echo $GLOBALS['CONFIG']['consult_request_email']." - Не могу отослать письмо! \n<br>";
		// 	return false;
		// }else{
		// 	$this->ClearAddresses();
		// 	$this->ClearAttachments();
		// 	echo $GLOBALS['CONFIG']['consult_request_email']." - Письмо отослано! \n<br>";
		// 	return true;
		// }
	}
	// Отсылка письма клиенту со ссылками на накладные покупателя
	public function SendOrderInvoicesToCustomers($id_order){
		global $db;
		$Order = new Orders();
		$Order->SetFieldsById($id_order);
		// Устанавливаем тему письма
		$this->Subject = "Заказ № ".$id_order." в интернет-магазине ".$_SERVER['SERVER_NAME'];
		// Задаем тело письма
		$this->Body = "Ваш заказ № ".$id_order."<br>".
			"Для его выполнения необходимо произвести полную или частичную предоплату (условия можно посмотреть в разделе ОПЛАТА И ДОСТАВКА - <a href=\"http://".$_SERVER['SERVER_NAME']."/page/Oplata-i-dostavka\">".$_SERVER['SERVER_NAME']."/page/Oplata-i-dostavka"."</a>).<br>".
			"Пожалуйста, после выполнения предоплаты сообщите менеджеру сумму проплаты по номеру заказа по телефону.<br>".
			"Контактную информацию менеджера и данные по заказу можно увидеть в накладной - <a href=\"http://".$_SERVER['SERVER_NAME'].'/'."invoice_customer/".$id_order."/".$Order->fields['skey']."\">".$_SERVER['SERVER_NAME'].'/'."invoice_customer/".$id_order."/".$Order->fields['skey']."</a><br>".
			"Спасибо что воспользовались услугами нашего интернет-магазина.<br>".
			"С уважением, администрация интернет-магазина <a href=\"http://".$_SERVER['SERVER_NAME']."\">".$_SERVER['SERVER_NAME']."</a><br><br>".
			"_________________________________________________________<br>".
			"Телефоны для справок:<br>".
			"067 577-39-07<br>".
			"099 563-28-17<br>".
			"Техподдержка и вопросы по работе сайта:<br>".
			"098 957-32-53";

		$sql = "SELECT email, name FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."order o WHERE u.id_user=o.id_customer AND o.id_order=".$db->Quote($id_order);
		$arr = $db->GetOneRowArray($sql);
		// Добавляем адрес в список получателей
		$this->isHTML(true);
		$this->AddAddress($arr['email'], $arr['name']);
		if(!$this->echo){
			ob_start();
		}
		if(!$this->Send()){
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $arr['email']." - Не могу отослать письмо! \n<br>";
			return false;
		}else{
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $arr['email']." - Письмо отослано! \n<br>";
			return true;
		}
		if(!$this->echo){
			ob_end_clean();
		}
	}
	// Отсылка письма поставщикам с накладной поставщика
	public function SendOrderInvoicesToAllSuppliers($id_order){
		global $db;
		
		$Order = new Orders();
		$Order->SetFieldsById($id_order);
		
		// Устанавливаем тему письма
		$this->Subject = "Накладная поставщика по заказу № ".$id_order;
		
		$sql = "SELECT DISTINCT u.id_user AS id_supplier, u.email, u.name FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."osp osp 
				WHERE (u.id_user=osp.id_supplier 
				OR u.id_user=osp.id_supplier_mopt)
				AND osp.id_order=".$db->Quote($id_order);
		$arr = $db->GetArray($sql);
		//print_r($arr);
		$return = true;
		foreach($arr as $i){
			// Добавляем адрес в список получателей
			$this->isHTML(true);
			$this->AddAddress($i['email'], $i['name']);
			
			$this->Body = "Поступил заказ № ".$id_order."<br>".
				"Накладная поставщика - <a href=\"http://".$_SERVER['SERVER_NAME']."/invoice_supplier/".$id_order."/".$i['id_supplier']."/".$Order->fields['skey']."\">".$_SERVER['SERVER_NAME']."/invoice_supplier/".$id_order."/".$i['id_supplier']."/".$Order->fields['skey']."</a>";
			if(!$this->Send()){
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo $i['email']." - Не могу отослать письмо! \n<br>";
				$return = false;
			}else{
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo $i['email']." - Письмо отослано! \n<br>";
			}
		}
		return $return;
	}
	
	
	// Отсылка письма контрагенту со ссылками на претензии по накладным  покупателя и контрагета
	public function SendOrderPretInvoicesToContragent($id_order){
		global $db;
		$Order = new Orders();
		$Order->SetFieldsById($id_order);
		// Устанавливаем тему письма
		$this->Subject = "Претензия на накладные покупателя и контрагента по заказу № ".$id_order;
		// Задаем тело письма
		$this->Body = "Претензия на заказ № ".$id_order."<br>"."Претензия на накладную покупателя - <a href=\"http://".$_SERVER['SERVER_NAME']."/invoice_customer_pret/".$id_order."/".$Order->fields['skey']."\">".$_SERVER['SERVER_NAME']."/invoice_customer_pret/".$id_order."/".$Order->fields['skey']."</a><br>";
		$sql = "SELECT email, name FROM "._DB_PREFIX_."user AS u, "._DB_PREFIX_."order AS o WHERE u.id_user = o.id_contragent AND o.id_order = ".mysql_real_escape_string($id_order);
		$arr = $db->GetOneRowArray($sql);
		// Добавляем адрес в список получателей.
		$this->isHTML(true);
		$this->AddAddress($arr['email'], $arr['name']);
		if(!$this->Send()){
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $arr['email']." - Не могу отослать письмо! \n<br>";
			return false;
		}else{
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $arr['email']." - Письмо отослано! \n<br>";
			return true;
		}
	}

	// Отсылка письма контрагенту со ссылками на возврат по накладным  покупателя и контрагета
	public function SendOrderRetInvoicesToContragent($id_order){
		global $db;
		$Order = new Orders();
		$Order->SetFieldsById($id_order);
		// Устанавливаем тему письма
		$this->Subject = "Возврат на накладные покупателя и контрагента по заказу № ".$id_order;
		// Задаем тело письма
		$this->Body = "Возврат на заказ № ".$id_order."<br>"."Возврат по накладной покупателя - <a href=\"http://".$_SERVER['SERVER_NAME']."/invoice_customer_ret/".$id_order."/".$Order->fields['skey']."\">".$_SERVER['SERVER_NAME']."/invoice_customer_ret/".$id_order."/".$Order->fields['skey']."</a><br>";
		$sql = "SELECT email, name FROM "._DB_PREFIX_."user u, "._DB_PREFIX_."order o WHERE u.id_user=o.id_contragent AND o.id_order=".mysql_real_escape_string($id_order);
		$arr = $db->GetOneRowArray($sql);
		// Добавляем адрес в список получателей
		$this->isHTML(true);
		$this->AddAddress($arr['email'], $arr['name']);
		if(!$this->Send()){
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $arr['email']." - Не могу отослать письмо! \n<br>";
			return false;
		}else{
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $arr['email']." - Письмо отослано! \n<br>";
			return true;
		}
	}

	// Отсылка письма клиенту с паролем и логином после регистрации
	public function SendRegisterToCustomers($data){
		global $db;
		// Устанавливаем тему письма
		$this->Subject = "Регистрация в интернет-магазине ".$_SERVER['SERVER_NAME'];
		// Задаем тело письма
		$this->Body = "Благодарим Вас за регистрацию на сайте интернет-магазина <a href=\"http://".$_SERVER['SERVER_NAME']."\">".$_SERVER['SERVER_NAME']."</a><br>".
		"Вы можете войти в свой личный кабинет на сайте по ссылке - <a href=\"http://".$_SERVER['SERVER_NAME']."/cabinet/\">личный кабинет</a><br>".
		"Логин: ". $data['email']."<br>".
		"Пароль: ". $data['passwd']."<br>".
		"Спасибо что воспользовались услугами нашего интернет-магазина.<br>".
		"С уважением, администрация интернет-магазина ".$_SERVER['SERVER_NAME']."<br>".
		"_________________________________________________________<br>".
		"Телефоны для справок:<br>".
		"067 577-39-07<br>".
		"099 563-28-17<br>".
		"Техподдержка и вопросы по работе сайта:<br>".
		"098 957-32-53";
		// Добавляем адрес в список получателей
		$this->AddAddress($data['email'], $data['name']);
		// Указываем тип письма как HTML
		$this->isHTML(true);
		// if(!$this->echo){
		// 	ob_start();
		// }
		if(!$this->Send()){
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $data['email']." - Не могу отослать письмо! \n<br>";
			return false;
		}//else{
		// 	$this->ClearAddresses();
		// 	$this->ClearAttachments();
		// 	if($this->echo) echo $data['email']." - Письмо отослано! \n<br>";
		// 	return true;
		// }
		// if(!$this->echo){
		// 	ob_end_clean();
		// }
	}

	public function SendNewsToCustomers($data){
		global $db;
		// Добавляем адрес в список получателей
		$sql = "SELECT COUNT(DISTINCT email) FROM "._DB_PREFIX_."user WHERE news = 1";
		$arr = $db->GetArray($sql);
		foreach($arr[0] as $link_mail)
		for($mail_ii = 0; $mail_ii < $link_mail; $mail_ii += 1) {
			$sql = "SELECT DISTINCT  email, name, md5(id_user) FROM "._DB_PREFIX_."user WHERE news = 1 LIMIT ".$mail_ii.", 1";
			$arr = $db->GetArray($sql);
			//print_r($arr); exit();  	
			
			// Устанавливаем тему письма
			$this->Subject = "Новости оптового интернет-магазина ".$_SERVER['SERVER_NAME'];
			foreach ($arr as $i){		
				//замедлитель рассылки

				// Задаем тело письма
				$this->Body = $data['descr_full'];
				$this->Body .= "<table><tr><td width=".'"600"'.">
				С уважением, администрация интернет-магазина ".$_SERVER['SERVER_NAME']." <br>
				067 577-39-07<br>
				099 563-28-17<br>
				Техподдержка и вопросы по работе сайта:<br>
				098 957-32-53<br>";
				$this->Body .= "<p>Если вы  хотите отказаться от нашей  рассылки - перейдите пожалуйста по ссылке - http://".$_SERVER['SERVER_NAME']."/remind1/";
				$this->Body .= $i['md5(id_user)'];
				$this->Body .= "</p></td></tr></table>";
				$this->isHTML(true);
				// Добавляем адрес в список получателей
				$this->AddAddress($i['email'], $i['name']);
				if(!$this->Send()){
					$this->ClearAddresses();
					$this->ClearAttachments();
					if ($this->echo) echo $i['email']." - Не могу отослать письмо! \n<br>";
					$return = false;
				}else{
					$this->ClearAddresses();
					$this->ClearAttachments();
					if ($this->echo) echo $i['email']." - Письмо отослано! \n<br>";
				}
			}
			//set_time_limit (23);
			//print_r($ii);
			//sleep (19);
		}
		return $return;
	}

	public function SendNewsToCustomers2($adres){
		global $db;
		// Добавляем адрес в список получателей
		$sql = "SELECT DISTINCT email, name, md5(id_user) FROM "._DB_PREFIX_."user WHERE news=1";
		$arr = $db->GetArray($sql);
		//print_r($arr); exit();  	
		
		// Устанавливаем тему письма
		$this->Subject = "Новости оптового интернет-магазина ".$_SERVER['SERVER_NAME'];
		foreach($arr as $i){
			//замедлитель рассылки

			// Задаем тело письма
			$this->Body ="Добрый день, Уважаемый Клиент!"."\n\n".
			"На нашем сайте есть новость - '".$adres['title']."'"."\n\n".
			"Полный текст новости можно увидеть по ссылке - http://".$_SERVER['SERVER_NAME']."/news/".$adres['id_news']."/"."\n\n".
			"С уважением, администрация интернет-магазина ".$_SERVER['SERVER_NAME']."\n\n".
			"_____________________________________________________________________" ."\n\n".
			"Если вы  хотите отказаться от нашей  рассылки - перейдите пожалуйста по ссылке - http://".$_SERVER['SERVER_NAME']."/remind1/".$i['md5(id_user)']."\n\n".
			"Если вы затем хотите возобновить рассылку  - пожалуйста, откоректируйте свои личные данные в кабинете пользователя, чтобы добавить свой адрес в список рассылки." ."\n\n".
			"Телефоны для справок:"."\n\n".
			"067 577-39-07"."\n\n".
			"099 563-28-17"."\n\n".
			"Техподдержка и вопросы по работе сайта:"."\n\n".
			"098 957-32-53";
			// Добавляем адрес в список получателей
			$this->AddAddress($i['email'], $i['name']);
			if(!$this->Send()){
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo $i['email']." - Не могу отослать письмо! \n<br>";
				$return = false;
			}else{
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo $i['email']." - Письмо отослано! \n<br>";
			}
		}
		return $return;
	}
	// Отправка писем поставщикам при печати сводной накладной
	public function SendOrdersToSuppliers($supplier, $id_supplier, $orders, $contragent, $sorders){
		global $db;
		$Suppliers = new Suppliers();
		$Suppliers->SetFieldsById($id_supplier);
		$c1 = 30;
		$c2 = 45;
		$c3 = 96;
		$c4 = 350;
		$c5 = 80;
		$c6 = 80;
		$c7 = 50;
		$c8 = 95;
		$otpusk=0;$kotpusk=0;
		$this->Body = "
		<style>
		* {
			padding: 0;
			margin: 0;
		}
		.logo { font-size: 28px; color: #00F; font-weight: bold; }

		.undln { text-decoration: underline; }
		.lb { border-left: 1px dashed #000; padding-left: 5px; }

		.table_header { margin-left: 3px; width: 827px; }
		.table_header .top td { padding: 10px 0 15px 0; font-size: 14px; }
		.table_header .first_col { width: 150px; }
		.table_header .second_col { width: 300px; }
		.table_header .top span.invoice { margin-left: 20px; font-size: 18px; text-decoration: underline; }

		.bl { border-left: 1px solid #000; }
		.br { border-right: 1px solid #000; }
		.bt { border-top: 1px solid #000; }
		.bb { border-bottom: 1px solid #000 !important; }
		.bn { border: none !important; }
		.bla { text-align: left; }

		.bnb { border-bottom: none !important; }

		.blf { border-left: 1px solid #FFF; }
		.brf { border-right: 1px solid #FFF; }
		.bbf { border-bottom: 1px solid #FFF; }

		.table_main { margin: 10px 0 0 1px; clear: both; }
		.table_main td { padding: 1px 1px 0; font-size: 12px; text-align: center; border-right: 1px #000 solid; border-bottom: 1px #000 solid; vertical-align: middle; font-size: 14px; font-weight: 900; }
		.table_main th { text-align: center; vertical-align: middle; font-weight: lighter; font-size: 11px;}
		.table_main td.name { padding: 1px; font-size: 12px; text-align: left; border-right: 1px #000 solid; border-bottom: 1px solid #000; }
		.table_main .hdr td { font-weight: bold; padding: 1px; }.
		.table_main .hdr1 td { text-align: left; }
		.table_main td.postname {
			text-align: left;
		}
		.table_main .main td { height: 50px; font-size: 14px; font-weight: 900; }
		.table_main .main td.img { width: 56px; }

		.table_sum { margin: 10px 0 0 1px; }
		.table_sum td { padding: 1px 1px 0; font-size: 12px; text-align: center; vertical-align: middle; }
		.table_sum td.name { padding: 1px; font-size: 12px; text-align: left; }

		.adate { font-size: 11px; margin-left: 177px; }
		.note_red { color: #f00; font-size: 14px; font-weight: 900; }
		.note_grin { color: #f00; font-size: 22px; font-weight: 900; }

		.break { page-break-before: always; }
		.break_after { page-break-after: always; }
		.dash { border-bottom: 1px #f00 dashed; margin-bottom: 10px; }
	</style>";
		$this->Body .= "<div style=\"display: block; \">
			<p style=\"margin: 1px 0 0 10px; font-size: 14px; font-weight: bold;\">
				<div style=\"float:left\">
					<span class=\"logo\">".$_SERVER['SERVER_NAME']."</span>
				</div>
			</p>
		</div>
		<div style=\"clear: both; float:left; margin: 10px; font-size: 14px; font-weight: bold; width: 383px; padding-left: 10px;\">
			<b>".$supplier['name'].", ".$supplier['phone'].", ".$supplier['place']."</b>
		</div>
		<div style=\"float:left; margin: 10px; white-space: normal; width: 383px; padding-left: 10px;\" class=\"bl\">
			<p>".$contragent['descr']."</p>
		</div>
		<div style=\"clear: both;\"> </div>
		<table cellspacing=\"0\" border=\"1\" style=\"width: 827px; clear: both; float: left; margin-top: 10px\" class=\"table_main\">
			<thead>
				<tr class=\"hdr\">
					<th class=\"br bl bt bb\">№ заказа</th>
					<th class=\"br bt bb\">Сумма по отп. ценам</th>
					<th class=\"br bt bb\">Сумма факт</th>
				</tr>
			</thead>
			<tbody>";
			foreach($sorders[$id_supplier] as $k=>$o){
				$this->Body .= "<tr class=\"hdr\">
					<td class=\"bl bb\">".$k."</td>
					<td class=\"note_red bb\">".$o['order_otpusk']."</td>
					<td class=\"bb br\">&nbsp;</td>
				</tr>";
				$otpusk += $o['order_otpusk'];
				$kotpusk += isset($o['site_sum'])?$o['site_sum']:0;
			}
			$this->Body .= "<tr class=\"hdr\">
					<td class=\"bnb\" style=\"text-align:right\">Сумма</td>
					<td class=\"note_red\">".$otpusk."</td>
					<td class=\"bb br\">&nbsp;</td>
				</tr>
				<tr class=\"hdr\">
					<td class=\"bnb note_red\" style=\"text-align: right; font-size: 13pt;\">Скидка</td>
					<td class=\"bb bt br\">&nbsp;</td>
					<td class=\"bb bt br\">&nbsp;</td>
				</tr>
				<tr class=\"hdr\">
					<td class=\"bnb note_red\" style=\"text-align: right; font-size: 13pt;\">Сумма к оплате</td>
					<td class=\"bb br\">&nbsp;</td>
					<td class=\"bb br\">&nbsp;</td>
				</tr>
			</tbody>
		</table>";
		$this->Subject = "Заказы ".$GLOBALS['CONFIG']['invoice_logo_text']." от " .(date("d")+1)."-".date("m")."-". date("Y");
		foreach($supplier['orders'] as $order_key=>$order){
			$this->Body .= "<table class=\"table_main\" border=\"1\" cellspacing=\"0\">
			<col style=\"width:".$c1.";\" />
			<col style=\"width:".$c2.";\" />
			<col style=\"width:".$c3.";\" />
			<col style=\"width:".$c4.";\" />
			<col style=\"width:".$c5.";\" />
			<col style=\"width:".$c6.";\" />
			<col style=\"width:".$c7.";\" />
			<col style=\"width:".$c8.";\" />
			<thead>
				<tr>
					<th colspan=\"9\" style=\"border: 0;\">
						<p style=\"font-size: 20px; font-weight: bold; width: 827px; text-align: center\">
							№ &nbsp;".$order_key." - <b style=\"font-size:16px;color:Red\">".$orders[$order_key]['note2']."</b>
						</p>
					</th>
				</tr>
				<tr class=\"hdr\">
					<th class=\"bt br bl bb\">№</th>
					<th class=\"bt br bb\">Арт</th>
					<th class=\"bt br bb\">Фото</th>
					<th class=\"bt br bb\">Название</th>
					<th class=\"bt br bb\">Цена 1шт.</th>
					<th class=\"bt br bb\">Заказано, шт</th>
					<th class=\"bt br bb\">факт</th>
					<th class=\"bt br bb\">Сумма</th>
				</tr>
			</thead>
			<tbody>";
			$ii=1;$sum=0;$qty=0;$weight=0;$volume=0;$sum_otpusk=0;
			foreach($order as &$i){
				if($i['opt_qty']>0 && $i['id_supplier'] == $id_supplier){
					$this->Body .= "<tr class=\"main\">
						<td class=\"bl bb\">".$ii++."</td>
						<td class=\"bb\">".$i['art']."</td>
						<td class=\"bb\">
							<img height=\"96\" width=\"96\" src=\"".$_SERVER['SERVER_NAME'].'/'.htmlspecialchars(str_replace("/efiles/image/", "efiles/image/500/", $i['img_1']))."\" />
						</td>
						<td class=\"name bb\">";
						if($i['note_opt']!=''){
							$this->Body .= "<span class=\"note_red\">".$i['note_opt']."</span><br>";
						}
						$this->Body .= $i['name']."</td>
						<td class=\"bb\">";
						if(!$supplier['is_partner']){
							$this->Body .= $i['price_opt_otpusk'];
						}
						$this->Body .= "</td>
						<td class=\"bb\">".$i['opt_qty']."</td>
						<td class=\"bb\">&nbsp;</td>
						<td class=\"bb\">";
						if(!$supplier['is_partner']){
							$this->Body .= round($i['price_opt_otpusk']*$i['opt_qty'], 2);
						}
						$this->Body .= "</td>
					</tr>";
					$sum_otpusk = round(($sum_otpusk+round($i['price_opt_otpusk']*$i['opt_qty'], 2)),2);
					$qty += $i['opt_qty'];
					$volume += $i['volume']*$i['opt_qty'];
					$weight += $i['weight']*$i['opt_qty'];
					$sum = round($sum+$i['opt_sum'],2);
				}
				if($i['mopt_qty'] > 0 && $i['id_supplier_mopt'] == $id_supplier){
					$this->Body .= "<tr class=\"main\">
						<td class=\"bl bb\">".$ii++."</td>
						<td class=\"bb\">".$i['art']."</td>
						<td class=\"bb\">
							<img height=\"96\" width=\"96\" src=\"http:".$_SERVER['SERVER_NAME'].'/'.htmlspecialchars(str_replace("/efiles/image/", "efiles/image/500/", $i['img_1']))."\" />
						</td>
						<td class=\"name bb\">";

						if($i['note_mopt']!=''){
							$this->Body .= "<span class=\"note_red\">".$i['note_mopt']."</span><br>";
						}
						$this->Body .= $i['name']."</td>
						<td class=\"bb\">";
						if(!$supplier['is_partner']){
							$this->Body .= $i['price_mopt_otpusk'];
						}
						$this->Body .= "</td>
						<td class=\"bb\">".
							$i['mopt_qty'].
						"</td>
						<td class=\"bb\">&nbsp;</td>
						<td class=\"bb\">";
						if(!$supplier['is_partner']){
							$this->Body .= round($i['price_mopt_otpusk']*$i['mopt_qty'], 2);
						}
						$this->Body .= "</td>
					</tr>";
					$sum_otpusk = round(($sum_otpusk+round($i['price_mopt_otpusk']*$i['mopt_qty'], 2)),2);
					$qty += $i['mopt_qty'];
					$volume += $i['volume']*$i['mopt_qty'];
					$weight += $i['weight']*$i['mopt_qty'];
					$sum = round($sum+$i['mopt_sum'],2);
				}
			}
			$this->Body .= "<tr class=\"table_sum\">
				<td class=\"bn\">&nbsp;</td>
				<td class=\"bn\">&nbsp;</td>
				<td class=\"bn\">&nbsp;</td>
				<td class=\"bn\">&nbsp;</td>
				<td class=\"bn\">&nbsp;</td>
				<td class=\"bn\">&nbsp;</td>
				<td class=\"bn\" style=\"text-align:right\">Сумма:</td>
				<td class=\"br bb bl\">";
			if(!$supplier['is_partner']){
				$this->Body .= "<div class=\"note_red\">".$sum_otpusk."</div>";
			}
			$this->Body .= "</td>
					</tr>
				</tbody>
			</table>";
		}
		/*$aEmail = array(
			'html' => $this->Body,
			'subject' => "Заказ ".$GLOBALS['CONFIG']['invoice_logo_text'],
			'attachments' => array($_SERVER['DOCUMENT_ROOT']."/temp/".$supplier['art'].'.csv'),
			'encoding' => "UTF-8",
			'from' => array(
				'name' => $GLOBALS['CONFIG']['invoice_logo_text'],
				'email' => 'order@x-torg.com',
			),
			'to' => array(
				array(
					'email' => $Suppliers->fields['real_email'],//$client['email'],
				),
			),
		);
		$res = $this->oApi->send_email($aEmail);*/
		$this->isHTML(true);
		if($supplier['make_csv'] == 1){
			$this->AddAttachment($_SERVER['DOCUMENT_ROOT']."/temp/".$supplier['real_phone'].'.csv', $supplier['real_phone'].'.csv');
		}
		if(is_null($supplier['real_email']) == false){
			// Добавляем адрес в список получателей
			$this->AddAddress($supplier['real_email']);
			if(!$this->Send()){
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo "Не могу отослать письмо! \n<br>";
				$return = false;
			}else{
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo "Письмо отослано! \n<br>";
				$return = true;
			}
			return $return;
		}else{
			return false;
		}
	}

	public function SendNewsToCustomers1($params){
		global $db;
		// Добавляем адрес в список получателей
		if(isset($params['test_distribution'])){
			$clients[] = array(
				'email'	=> $GLOBALS['CONFIG']['mail_email_test'],
				'name'	=> 'Test',
				'skey'	=> null
			);
		}else{
			$limit = '';
			if(isset($params['limit_from']) && $params['limit_from'] != '' && isset($params['limit_howmuch']) && $params['limit_howmuch'] != ''){
				$limit = "LIMIT ".$params['limit_from'].", ".$params['limit_howmuch'];
			}
			$sql = "SELECT DISTINCT email, name, md5(id_user) as skey FROM "._DB_PREFIX_."user WHERE news = 1 ".$limit;
			$clients = $db->GetArray($sql);
		}
		$this->Subject =$params['title'];
		foreach($clients as &$client){
			//замедлитель рассылки
			// Задаем тело письма
			$this->Body = $params['descr_full'];
			$this->Body .= "<table><tr><td width=".'"600"'.">
			С уважением, администрация интернет-магазина ".$_SERVER['SERVER_NAME']." <br>
			067 577-39-07<br>
			099 563-28-17<br>
			Техподдержка и вопросы по работе сайта:<br>
			098 957-32-53<br>";
			$this->Body .= "<p>Если вы  хотите отказаться от нашей  рассылки - перейдите пожалуйста по ссылке - http://".$_SERVER['SERVER_NAME']."/remind1/";
			$this->Body .= $client['skey'];
			$this->Body .= "</p></td></tr></table>";
			$this->isHTML(true);
			// Добавляем адрес в список получателей
			$this->AddAddress($client['email'], $client['name']);
			if(!$this->Send()){
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo $client['email']." - Не могу отослать письмо! \n<br>";
				$return = false;
			}else{
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo $client['email']." - Письмо отослано! \n<br>";
			}
			set_time_limit(4);
			sleep(1);
		}
	}

	public function SendNewsToCustomersInterview($params){
		global $db;
		// Добавляем адрес в список получателей
		if(isset($params['test_distribution'])){
			$clients[] = array('email' => $GLOBALS['CONFIG']['mail_email_test'], 'name' => 'Ванька', 'cont_person' => 'Покрышкина Резина', 'name_c' => 'Суперчувак');
		}else{
			$limit = '';
			if(isset($params['limit_from']) && $params['limit_from'] != '' && isset($params['limit_howmuch']) && $params['limit_howmuch'] != ''){
				$limit = "LIMIT ".$params['limit_from'].", ".$params['limit_howmuch'];
			}
			// $sql = "SELECT DISTINCT email, cont_person, name, md5("._DB_PREFIX_."user.id_user) as skey, (SELECT CONCAT(UCASE(LEFT(name_c, 1)), LCASE(SUBSTRING(name_c, 2))) AS name_c FROM "._DB_PREFIX_."contragent WHERE "._DB_PREFIX_."contragent.id_user = "._DB_PREFIX_."customer.id_contragent) FROM "._DB_PREFIX_."user LEFT JOIN "._DB_PREFIX_."customer ON "._DB_PREFIX_."user.id_user = "._DB_PREFIX_."customer.id_user WHERE news = 0 ".$limit;
			// $sql = "SELECT DISTINCT email, name, md5("._DB_PREFIX_."user.id_user) as skey FROM "._DB_PREFIX_."contragent WHERE "._DB_PREFIX_."contragent.id_user = "._DB_PREFIX_."customer.id_contragent) FROM "._DB_PREFIX_."user WHERE "._DB_PREFIX_."user.id_user NOT IN (SELECT "._DB_PREFIX_."customer.id_user FROM "._DB_PREFIX_."customer) ".$limit;
			$sql = "SELECT DISTINCT email, name, md5("._DB_PREFIX_."user.id_user) as skey FROM "._DB_PREFIX_."user WHERE email NOT IN (SELECT email FROM "._DB_PREFIX_."emails) ".$limit;
			$clients = $db->GetArray($sql);
		}
		foreach($clients as &$client){
			$this->Subject = $params['title'];
			$this->Body = $params['descr_full'];
			$this->Body .= "<table><tr><td width=".'"600"'.">
			С уважением, администрация интернет-магазина ".$_SERVER['SERVER_NAME']." <br>
			067 577-39-07<br>
			099 563-28-17<br>
			Техподдержка и вопросы по работе сайта:<br>
			098 957-32-53<br>";
			$this->Body .= "<p>Если вы  хотите отказаться от нашей  рассылки - перейдите пожалуйста по ссылке - http://".$_SERVER['SERVER_NAME']."/remind1/";
			$this->Body .= $client['skey'];
			$this->Body .= "</p></td></tr></table>";
			$this->isHTML(true);
			// Добавляем адрес в список получателей
			$this->AddAddress($client['email'], $client['name']);
			if(!$this->Send()){
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo $client['email']." - Не могу отослать письмо! \n<br>";
				$return = false;
			}else{
				$this->ClearAddresses();
				$this->ClearAttachments();
				if($this->echo) echo $client['email']." - Письмо отослано! \n<br>";
			}
			set_time_limit(4);
			sleep(1);
		}
	}

	public function SendInterviewResult($html){
		global $db;
		$this->Subject = 'Результат опроса';
		$email = $GLOBALS['CONFIG']['market_email'];
		$this->Body = '<h1>Результат опроса</h1>';
		$this->Body .= $html;
		$this->isHTML(true);
		// Добавляем адрес в список получателей
		$this->AddAddress($email);
		if(!$this->Send()){
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $email." - Не могу отослать письмо! \n<br>";
			$return = false;
		}else{
			$this->ClearAddresses();
			$this->ClearAttachments();
			if($this->echo) echo $email." - Письмо отослано! \n<br>";
		}
		set_time_limit(4);
		sleep(1);
	}

	public function GenerateCSVForSupplier($orders, $supplier, $real_phone){
		$products = new Products();
		$plist = $products->SetProductsList4SuppliersCSV($orders, $supplier);
		if(!empty($plist)){
			foreach($plist as $key => $row) {
				$id_order[$key]  = $row['id_order'];
				$art[$key] = $row['art'];
			}
			array_multisort($id_order, SORT_ASC, $art, SORT_ASC, $plist);
		}
		$handle = $_SERVER['DOCUMENT_ROOT']."/temp/".$real_phone.".csv";
		file_put_contents($handle, array(
			'"',
			mb_convert_encoding('№ заказа', "windows-1251", "utf-8"),'"',',','"',
			mb_convert_encoding('арт. сайт', "windows-1251", "utf-8"),'"',',','"',
			mb_convert_encoding('арт. поставщика', "windows-1251", "utf-8"),'"',',',
			mb_convert_encoding('Цена', "windows-1251", "utf-8"),',',
			mb_convert_encoding('Количество', "windows-1251", "utf-8"),',','"',
			mb_convert_encoding('Ед. измерения', "windows-1251", "utf-8"),'"',',',
			mb_convert_encoding('Название', "windows-1251", "utf-8"),',',
			mb_convert_encoding('Примечание', "windows-1251", "utf-8"),
			"\r\n"
		));
		if(!empty($plist)){
			foreach($plist AS $p){
				$art = explode('арт.', $p['name']);
				if($p['id_supplier'] == $supplier){
					file_put_contents($handle, array(
						mb_convert_encoding($p['id_order'], "windows-1251", "utf-8"),',',
						mb_convert_encoding($p['art'], "windows-1251", "utf-8"),',',
						mb_convert_encoding(isset($art[1])?$art[1]:null, "windows-1251", "utf-8"),',',
						mb_convert_encoding($p['price_opt_otpusk'], "windows-1251", "utf-8"),',',
						mb_convert_encoding($p['opt_qty'], "windows-1251", "utf-8"),',',
						mb_convert_encoding($p['units'], "windows-1251", "utf-8"),',','"',
						mb_convert_encoding($p['name'] = str_replace('"','""',$p['name']), "windows-1251", "utf-8"),'"',',',
						mb_convert_encoding($p['note_opt'], "windows-1251", "utf-8"),
						"\r\n"
					), FILE_APPEND );
				}
				if($p['id_supplier_mopt'] == $supplier){
					file_put_contents($handle, array(
						mb_convert_encoding($p['id_order'], "windows-1251", "utf-8"),',',
						mb_convert_encoding($p['art'], "windows-1251", "utf-8"),',',
						mb_convert_encoding(isset($art[1])?$art[1]:null, "windows-1251", "utf-8"),',',
						mb_convert_encoding($p['price_mopt_otpusk'], "windows-1251", "utf-8"),',',
						mb_convert_encoding($p['mopt_qty'], "windows-1251", "utf-8"),',',
						mb_convert_encoding($p['units'], "windows-1251", "utf-8"),',','"',
						mb_convert_encoding($p['name'] = str_replace('"','""',$p['name']), "windows-1251", "utf-8"),'"',',',
						mb_convert_encoding($p['note_mopt'], "windows-1251", "utf-8"),
						"\r\n"
					), FILE_APPEND );
				}
			}
		}
		return true;
	}
}
?>