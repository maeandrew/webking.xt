<!-- MAKE BILL/INVOICE MODAL FORM -->
<div class="row col-md-6 col-xs-12">
	<form action="<?=_base_url?>/tcpdf/" target="_blank" method="POST" class="bill_form">
		<div class="row">
			<label for="order" class="col-md-12">Тип документа:</label>
			<div class="col-md-12">
				<select name="doctype" id="doctype" required>
					<option value="Счет">Счет</option>
					<option value="Расходная накладная">Расходная накладная</option>
					<option value="Товарный чек">Товарный чек</option>
				</select>
			</div>
		</div>
		<div class="row">
			<label for="order" class="col-md-6">№ заказа: <b id="order"><?=$_GET['order_id']?></b></label>
			<input type="hidden" name="order" id="order" value="<?=$_GET['order_id']?>">
		</div>
		<div class="row">
			<label for="date" class="col-md-12">Дата:</label>
			<div class="col-md-12">
				<input type="date" name="date" id="date" value="<?=date("Y-m-d")?>">
			</div>
		</div>
		<div class="row">
			<label for="pay_form" class="col-md-12">Форма оплаты:</label>
			<div class="col-md-12">
				<input type="text" name="pay_form" id="pay_form" placeholder="Форма оплаты..." value="<?=isset($_GET['pay_form'])?$_GET['pay_form']:null?>">
			</div>
		</div>
		<div class="row">
			<label for="margin" class="col-md-12">Индивидуальная наценка:</label>
			<div class="col-md-12">
				<input type="text" name="margin" id="margin" placeholder="Введите наценку..." value="<?=isset($_GET['personal_discount'])?$_GET['personal_discount']:null?>">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" name="contragent" value="<?=$current['id_user']?>">
			</div>
		</div>
		<div class="row">
			<label for="recipient" class="col-md-12">Отправитель:</label>
			<div class="col-md-12">
				<select name="recipient" id="recipient">
					<?foreach($remitters as $k=>$remitter){?>
						<option value="<?=$remitter['id']?>"><?=$remitter['name']?></option>
					<?}?>
				</select>
			</div>
		</div>
		<div class="row">
			<label for="personal_client" class="col-md-12">Клиент:</label>
			<div class="col-md-12">
				<textarea style="-webkit-transition: none;" type="text" name="personal_client" id="personal_client" placeholder="Для замены получателя в накладной или счете, введите все необходимые данные здесь..."><?=$_GET['client']?></textarea>
				<input type="hidden" name="client" value="">
			</div>
		</div>
		<div class="row">
			<label for="fact" class="settings col-md-12">
				<input type="checkbox" name="fact" id="fact"> Факт
			</label>
		</div>
		<!--
		<div class="line">			
			<label for="stamp" class="settings">
				<input type="checkbox" name="stamp" id="stamp"/>
				Прикрепить печать
			</label>
		</div>
		-->
		<div class="row">
			<label for="NDS" class="settings col-md-12">
				<input type="checkbox" name="NDS" id="NDS"> НДС
			</label>
		</div>
		<div class="row">
			<div class="col-md-12">
				<button type="submit" name="create-bill" class="btn-m-green">Сформировать</button>
			</div>
		</div>
	</form>
</div>