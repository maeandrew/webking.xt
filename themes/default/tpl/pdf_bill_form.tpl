<!-- MAKE BILL/INVOICE MODAL FORM -->
<div id="bill_form" data-type="modal">
	<form action="<?=_base_url?>/tcpdf/" target="_blank" method="POST" class="bill_form">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label class="mdl-textfield__label" for="doctype">Тип документа:</label>
			<select class="mdl-textfield__input" name="doctype" id="doctype" required>
				<option value="Счет">Счет</option>
				<option value="Расходная накладная">Расходная накладная</option>
				<option value="Товарный чек">Товарный чек</option>
			</select>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="hidden" name="order" id="order" value="<?=$_GET['order_id']?>">
			<label class="mdl-textfield__label" for="order">№ заказа: <b id="order"><?=$_GET['order_id']?></b></label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="date" name="date" id="date" value="<?=date("Y-m-d")?>">
			<label class="mdl-textfield__label" for="date">Дата:</label>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" name="pay_form" id="pay_form" value="<?=isset($_GET['pay_form'])?$_GET['pay_form']:null?>">
			<label class="mdl-textfield__label" for="pay_form">Форма оплаты:</label>			
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input class="mdl-textfield__input" type="text" name="margin" id="margin" value="<?=isset($_GET['personal_discount'])?$_GET['personal_discount']:null?>">
			<label class="mdl-textfield__label" for="margin">Индивидуальная наценка:</label>
		</div>

		<input type="hidden" name="contragent" value="<?=$current['id_user']?>">

		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label class="mdl-textfield__label" for="recipient">Отправитель:</label>
			<select class="mdl-textfield__input" name="recipient" id="recipient">
				<?foreach($remitters as $k=>$remitter){?>
					<option value="<?=$remitter['id']?>"><?=$remitter['name']?></option>
				<?}?>
			</select>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<textarea class="mdl-textfield__input" rows="3" style="-webkit-transition: none;" type="text" name="personal_client" id="personal_client" placeholder="Для замены получателя в накладной или счете, введите все необходимые данные здесь..."><?=$_GET['client']?></textarea>
			<label class="mdl-textfield__label" for="personal_client">Клиент:</label>
			<input type="hidden" name="client" value="">
		</div>

		<label for="fact" class="settings mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
			<input type="checkbox" name="fact" id="fact" class="mdl-checkbox__input">
			<span class="mdl-checkbox__label">Факт</span>
		</label>
		
		<!--
		<div class="line">			
			<label for="stamp" class="settings">
				<input type="checkbox" name="stamp" id="stamp"/>
				Прикрепить печать
			</label>
		</div>
		-->

		<label for="NDS" class="settings mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
			<input type="checkbox" name="NDS" id="NDS" class="mdl-checkbox__input">
			<span class="mdl-checkbox__label">НДС</span>
		</label>

		<button type="submit" name="create-bill" class="my_btn mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
		Сформировать
		</button>
	</form>
</div>

<script>
	$(document).ready(function() {
		openObject('bill_form');
		removeLoadAnimation('#bill_form');
	});
</script>