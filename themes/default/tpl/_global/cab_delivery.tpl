<h1>Адрес доставки</h1>
<?if(isset($addresses) && !empty($addresses)){?>
	<div class="saved_addresses">
		<?foreach($addresses as $address){?>
			<div class="address" data-id-address="<?=$address['id']?>">
				<h4><?=$address['title']?><div class="actions"><i class="material-icons address_edit_js hidden">edit</i><i class="material-icons address_delete_js">delete</i></div></h4>
				<ul>
					<li><span>Область:</span><?=$address['region']?></li>
					<li><span>Город:</span><?=$address['city']?></li>
					<li><span>Способ доставки:</span><?=$address['delivery']?></li>
					<li><span>Транспортная компания:</span><?=$address['shipping_company']?></li>
					<?if($address['id_delivery'] == 1){?>
						<li><span>Отделение:</span><?=$address['delivery_department']?></li>
					<?}else{?>
						<li><span>Адрес:</span><?=$address['address']?></li>
					<?}?>
				</ul>
			</div>
		<?}?>
	</div>
<?}?>
<h4>Добавить новый адрес</h4>
<div class="add_new_address mdl-grid">
	<form id="edit_contacts" class="editing" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<input required type="hidden" name="id_user" id="id_user" value="<?=$User['id_user']?>"/>
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" name="title" id="title" required>
				<label class="mdl-textfield__label" for="title">Название</label>
				<label class="mdl-textfield__error">Заполине это поле!</label>
			</div>
			<p class="explanation">например - Дом, Работа</p>
		</div>
		<fieldset>
			<legend>Адрес</legend>
			<div class="mdl-cell mdl-cell--12-col addres_field addres_elem_js">
				<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label region">
					<select id="region" name="region" class="mdl-selectfield__select" onChange="regionSelect($(this));">
						<option value=""></option>
						<?foreach($allregions as $region){?>
							<option value="<?=$region['title']?>"><?=$region['title']?></option>
						<?}?>
					</select>
					<label class="mdl-selectfield__label" for="region">Область</label>
					<span class="mdl-selectfield__error">Выберите область!</span>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--12-col addres_field addres_elem_js">
				<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label city">
					<select id="city" name="city" class="mdl-selectfield__select" disabled onChange="citySelect($(this));">
						<!-- <?foreach($availablecities as $city){?>
							<option value="<?=$city['names_regions']?>"><?=$city['name']?></option>
						<?}?> -->
					</select>
					<label class="mdl-selectfield__label" for="city">Город</label>
					<span class="mdl-selectfield__error">Выберите город!</span>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--12-col addres_elem_js">
				<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label delivery">
					<select id="id_delivery" name="id_delivery" class="mdl-selectfield__select" disabled onChange="deliverySelect($(this));">
						<?// Если в городе есть хоть одно отделение какой-либо компании, выводим пункт Самовывоз
						if($count['warehouse'] > 0){?>
							<option value="1">Получить в пункте выдачи</option>
						<?}
						// Если в город возможна адресная доставка хоть одной компанией, выводим пункт Адресная доставка
						if($count['courier'] > 0){?>
							<option value="2">Адресная доставка</option>
						<?}?>
					</select>
					<label class="mdl-selectfield__label" for="id_delivery">Способ доставки</label>
					<span class="mdl-textfield__error">Выберите способ доставки!</span>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--12-col addres_elem_js">
				<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label delivery_service">
					<select id="id_delivery_service" name="id_delivery_service" class="mdl-selectfield__select" onChange="deliveryServiceSelect($(this));" disabled></select>
					<label class="mdl-selectfield__label" for="id_delivery_service">Служба доставки</label>
					<span class="mdl-textfield__error">Выберите службу доставки!</span>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--12-col addres_elem_js hidden">
				<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label delivery_department">
					<select id="delivery_department" name="delivery_department" class="mdl-selectfield__select" disabled></select>
					<label class="mdl-selectfield__label" for="delivery_department">Отделение</label>
					<span class="mdl-textfield__error">Выберите отделение транспортной компании!</span>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--12-col addres_elem_js hidden">
				<div class="mdl-textfield mdl-js-textfield mdl-selectfield--floating-label address">
					<textarea id="address" name="address" class="mdl-textfield__input" type="text" rows= "3" disabled></textarea>
					<label class="mdl-textfield__label" for="address">Адрес доставки</label>
					<span class="mdl-textfield__error">Укажите свой адрес!</span>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend>Получатель</legend>
			<div id="flm_name" class="flm_name">
				<div class="mdl-cell mdl-cell--12-col addres_field">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" name="first_name" id="title" value="<?=$Customer['first_name']?>" required>
						<label class="mdl-textfield__label" for="first_name">Фамилия</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col addres_field">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" name="middle_name" id="title" value="<?=$Customer['middle_name']?>" required>
						<label class="mdl-textfield__label" for="middle_name">Имя</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col addres_field">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" name="last_name" id="title" value="<?=$Customer['last_name']?>" required>
						<label class="mdl-textfield__label" for="last_name">Отчество</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col addres_field">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label for="phone" class="mdl-textfield__label">Контактный телефон:</label>
						<input class="mdl-textfield__input phone" type="tel" required name="phone" id="phone" value="<?=$User['phone']?>" pattern="\+38 \(\d{3}\) \d{3}-\d{2}-\d{2}"/>
						<span class="mdl-textfield__error">Введите все цифры Вашего номера телефона</span>
					</div>
				</div>
			</div>
		</fieldset>
		<div class="buttons_cab">
			<button name="save_delivery" type="submit" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored save_delivery_js">Сохранить</button>
		</div>
	</form>
</div>

<script>
	$(function(){
		$('.address_delete_js').on('click', function(){
			var parent = $(this).closest('.address'),
				id_address = parent.data('id-address');
			addLoadAnimation(parent);
			if(confirm('Вы уверены, что хотите удалить адрес?')){
				ajax('location', 'deleteAddress', {id: id_address}).done(function(response){
					parent.remove();
				});
			}else{
				removeLoadAnimation(parent);
			}
		});
		$('.address_edit_js').on('click', function(){
			var parent = $(this).closest('.address'),
				id_address = parent.data('id-address');
			ajax('location', 'getAddress', {id: id_address}).done(function(response){
				console.log(response);
			});
		});
		//Валидация формы
		$('#edit_contacts').submit(function(e){
			$(this).find('select', 'textarea').each(function(){
				if ($(this).closest('.addres_elem_js').hasClass('hidden') === false){
					if ($(this).val() === null || $(this).val() === '') {
						$(this).closest('div').addClass('is-invalid');
						e.preventDefault();
					}
				}
			});
		});
	});
</script>