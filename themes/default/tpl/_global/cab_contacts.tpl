<h1>Основная информация</h1>
<div class="edit_contacts_block">
	<form id="edit_contacts" class="editing" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
		<input required="required" type="hidden" name="id_user" id="id_user" value="<?=$User['id_user']?>"/>
		<input required="required" type="hidden" name="news" id="news" value="<?=$User['news']?>"/>

		<div class="user_avatar">
			<label for="photobox">Фото:</label>
			<div id="photobox">
				<div class="previews">
					<div class="image_block dz-preview dz-file-preview">
						<div class="image old_image_js">
							<img data-dz-thumbnail src="/images/noavatar.png"/>
						</div>
						<div class="controls">
							<p id="forDelU" class="del_u_photo_js del_avatar" data-dz-remove><i class="material-icons">delete</i></p>
							<div class="mdl-tooltip" for="forDelU">Удалить фото</div>
						</div>
						<input type="hidden" name="images_visible[]" value="0">
					</div>
				</div>
				<div class="image_block_new drop_zone animate avatar_menu">
					<div class="dz-default dz-message">Загрузить фото</div>
					<input type="file" class="dz-hidden-input" style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
				</div>
			</div>
		</div>

		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label class="mdl-textfield__label" for="email">E-mail:</label>
			<input class="mdl-textfield__input" pattern="(^([\w\.]+)@([\w]+)\.([\w]+)$)|(^$)" type="text" name="email" id="email" value="<?=$User['email']?>"/>
			<span class="mdl-textfield__error">Введите корректный Email</span>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label for="phone" class="mdl-textfield__label">Контактный телефон:</label>
			<input class="mdl-textfield__input phone" type="tel" required name="phones" id="phones" value="<?=$User['phone']?>" pattern="\+38 \(\d{3}\) \d{3}-\d{2}-\d{2}"/>
			<span class="mdl-textfield__error">Введите все цифры Вашего номера телефона</span>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label for="last_name" class="mdl-textfield__label">Фамилия:</label>
			<input class="mdl-textfield__input" pattern="^[\'А-Яа-я-ЇїІіЁё]+|^[\'A-Za-z-]+$" type="text" name="last_name" id="last_name" value="<?=$Customer['last_name']?>"/>
			<span class="mdl-textfield__error">Использованы недопустимые символы</span>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label for="first_name" class="mdl-textfield__label">Имя:</label>
			<input class="mdl-textfield__input" pattern="^[\'А-Яа-яЇїІіЁё]+|^[\'A-Za-z]+$" type="text" name="first_name" id="first_name" value="<?=$Customer['first_name']?>"/>
			<span class="mdl-textfield__error">Использованы недопустимые символы</span>
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label for="middle_name" class="mdl-textfield__label">Отчество:</label>
			<input class="mdl-textfield__input" pattern="^[\'А-Яа-я-ЇїІіЁё]+|^[\'A-Za-z-]+$" type="text" type="text" name="middle_name" id="middle_name" value="<?=$Customer['middle_name']?>"/>
			<span class="mdl-textfield__error">Использованы недопустимые символы</span>
		</div>
		<label class="label_for_input_blocks" for="date_container">День рождения:</label>
		<div id="date_container" class="date_container">
			<div class="mdl-textfield mdl-js-textfield bdate_select_block">
				<label for="day" class="mdl-textfield__label">день</label>
				<input id="day" name="day" pattern="^(0?[1-9])$|^([1-2]\d)$|^(3[0-1])$" type="text" placeholder="день" maxlength="2" size="4" class="mdl-textfield__input day_js day" value="<?=isset($Customer['b_day'])?$Customer['b_day']:null;?>">
				<span class="mdl-textfield__error">Укажите день</span>
			</div>
			<input id="customer_month" type="hidden" value="<?=isset($Customer['b_month'])?$Customer['b_month']:null;?>">
			<div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label bdate_select_block">
				<select name="month" class="month_js month mdl-selectfield__select">
					<?=!isset($Customer['b_month'])?print_r('<option disabled selected>месяц</option>'):null;?>
					<script>
						var month = ['январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь'],
							customer_month = $('#customer_month').val(),
							temp;

						for (var i = 0; i < month.length; i++) {
							temp = ((i<9)?'0'+(i+1):(i+1));
							document.write('<option value="' + temp + '">'+ month[i] +'</option>');
							if (temp == customer_month) {
								$('.month_js').find('option[value="'+temp+'"]').attr('selected', 'selected');
							}
						};
					</script>
				</select>
				<span class="mdl-textfield__error">Выберите месяц</span>
			</div>
			<div class="mdl-textfield mdl-js-textfield bdate_select_block">
				<label for="year" class="mdl-textfield__label">год</label>
				<input id="year" name="year" pattern="^(19|20)\d{2}$" type="text" placeholder="год" maxlength="4" size="8" class="mdl-textfield__input year_js year" value="<?=isset($Customer['b_year'])?$Customer['b_year']:null;?>">
				<span class="mdl-textfield__error"></span>
			</div>
		</div>
		<div id="gend_block" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<label class="label_for_input_blocks" for="gender">Пол:</label>
			<div id="gender">
				<label class="mdl-radio mdl-js-radio" for="male">
					<input <?=$Customer['sex'] == 'male'?'checked="checked"':null;?> type="radio" name="gender" class="mdl-radio__button" id="male" value="male">Мужской
				</label> &nbsp;&nbsp;
				<label class="mdl-radio mdl-js-radio" for="female">
					<input <?=$Customer['sex'] == 'female'?'checked="checked"':null;?> type="radio" name="gender" class="mdl-radio__button" id="female" value="female">Женский
				</label>
			</div>
		</div>

		<div class="errMsg_js"></div>
		<input type="button" value="Сохранить" name="save_contacts" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
	</form>
</div>
<div id="preview-template" style="display: none;">
	<div class="image_block dz-preview dz-file-preview">
		<div class="image">
			<img data-dz-thumbnail />
		</div>
		<div class="controls">
			<p id="forDelU" class="del_u_photo_js del_avatar" data-dz-remove><i class="material-icons">delete</i></p>
			<div class="mdl-tooltip" for="forDelU">Удалить фото</div>
		</div>
		<input type="hidden" name="images_visible[]" value="0">
	</div>
</div>
<script>
	//Загрузка Фото на сайт
	var	url = URL_base+'cabinet/';
	var dropzone = new Dropzone(".drop_zone", {
		method: 'POST',
		url: URL_base+'ajax?target=image&action=uploadAvatar',
		// url: url+"?upload=true",
		clickable: true,
		maxFiles: 1,
		// acceptedFiles: 'image/jpeg,image/png',
		previewsContainer: '.previews',
		previewTemplate: document.querySelector('#preview-template').innerHTML
	});
	dropzone.on('addedfile', function(file){
		$('#photobox .old_image_js img').remove();
		// $('.previews .dz-file-preview').addClass('forUpload');
		componentHandler.upgradeDom();
	}).on('maxfilesexceeded', function(file) {
		this.removeAllFiles();
		this.addFile(file);
		componentHandler.upgradeDom();
	}).on('success', function(file, path){
		console.log(file);
		console.log(path);
		// file.previewElement.innerHTML += '<input type="hidden" name="avatar" value="'+path+'">';
		componentHandler.upgradeDom();
	}).on('removedfile', function(file){
		$('#photobox .old_image_js').append('<img data-dz-thumbnail src="/images/noavatar.png"/>');
		// removed_file2 = '/product_images/original/'+year+'/'+(month+1)+'/'+day+'/'+file.name;
		// $('.previews').append('<input type="hidden" name="removed_images[]" value="'+removed_file2+'">');
		componentHandler.upgradeDom();
	});

	//Удаление ранее загруженного фото
	$("body").on('click', '.del_photo_js', function(e) {
		alert('Изобрежение будет удалено.');
		if(confirm('Изобрежение будет удалено.')){
			// var path = $(this).closest('.image_block'),
			// 	removed_file = path.find('input[name="images[]"]').val(); //  /news_images/482/cat.jpg
			// RemovedFile(path, removed_file);
		}
	});
</script>