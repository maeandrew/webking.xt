<div class="row">
	<div class="customer_cab col-md-6">
		<h1><?=isset($_GET['t']) && $_GET['t'] === 'password'?'Смена пароля':'Настройки'?> </h1>
		<div id="settings">
			<?if(isset($msg) && empty($_SESSION['member']['email'])){?>
				<div class="msg-<?=$msg['type']?>">
					<div class="msg_icon">
						<i class="material-icons"></i>
					</div>
				    <p class="msg_title">!</p>
				    <p class="msg_text"><?=$msg['text']?></p>
				</div>
			<?}?>
			<form class="editing forPassStrengthContainer_js" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
				<input required="required" type="hidden" name="id_user" value="<?=$User['id_user']?>"/>
				<?!isset($_GET['t'])?$var = '':$var = $_GET['t'];
				switch($var){
					default:?>
						<input required="required" type="hidden" name="save_settings" value="1"/>
						<input required="required" type="hidden" name="gid" value="<?=$User['gid']?>"/>
						<input required="required" type="hidden" name="email" value="<?=$User['email']?>"/>
						<!-- <div class="line email lineMail"> -->
							<!-- <label for="news">Хочу получать рассылку новостей сайта</label>
							<input type="checkbox" name="news" id="news" <?if($User['news']==1){?>checked<?}?> value="1"/> -->
							<!-- <label class="mdl-checkbox mdl-js-checkbox" for="news">
								<input type="checkbox" name="news" id="news" class="mdl-checkbox__input" <?if($User['news']==1){?>checked<?}?> value="1">
								<span class="mdl-checkbox__label">Хочу получать рассылку новостей сайта</span>
							</label> -->
						<!-- </div> -->
						<div class="notification_settings">
							<div class="notifications_block_js">
								<?
								$checked = true;
								foreach ($newsletters as $item) {
									if ($item['enable'] == 0){
										$checked = false;
									}?>
									<label class="mdl-checkbox mdl-js-checkbox" for="notify_<?=$item['id']?>">
										<input type="hidden" class="id_notify_js" value="<?=$item['id']?>">
										<input type="checkbox" name="notify_<?=$item['id']?>" id="notify_<?=$item['id']?>" class="mdl-checkbox__input notify_checkbox_js" <?=empty($_SESSION['member']['email'])?'disabled':null?> <?=$item['enable'] == 1?'checked':null?>>
										<span class="mdl-checkbox__label"><?=$item['title']?></span>
										<p class="notification_description">(Текст описания данной рассылки. Что быдет в ней и зачем она нужна.)</p>
									</label>
								<?}?>
								<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored <?=$checked == false?'select_all_js':null?>" <?=empty($_SESSION['member']['email'])?'disabled':null?>><?=$checked == false?'Выбрать все':'Снять все'?></button>
							</div>
						</div>

						<!-- <div id="contragent" class="line contragent">
							<label for="id_manager">Менеджер</label>
							<select required name="id_manager" id="id_manager">
								<?if(!$savedmanager || !$availablemanagers){?>
									<option selected="selected" disabled="disabled" class="cntr_0" value="">Менеджер</option>
								<?}
								$ii = 1;
								shuffle($availablemanagers);
								foreach($availablemanagers as $manager){?>
									<option <?=$manager['id_user'] == $savedmanager['id_user']?'selected="selected"':null;?> class="cntr_<?=$ii?>" value="<?=$manager['id_user']?>"><?=$manager['name_c']?></option>
									<?$ii++;
								}?>
							</select>
						</div> -->


						<!--
						<div class="line email">
							<label for="promo_code">Промо-код:</label>
							<input type="text" name="promo_code" id="promo_code"  value="<?=$User['promo_code'];?>"/>
						</div>-->

						<!-- <div class="buttons_cab">
							<button type="submit" data-role="none" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Сохранить</button>
						</div> -->
					<?break;
					case 'password':?>
						<input required="required" type="hidden" name="save_password" value="1"/>
						<input type="hidden" name="email" id="email" value="<?=$User['email']?>"/>
						<input type="hidden" name="gid" id="gid" value="<?=$User['gid']?>"/>
						<div class="new_passwd mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<label class="mdl-textfield__label" for="regpasswd">Новый пароль:</label>
							<input class="mdl-textfield__input" type="password" name="new_passwd" id="regpasswd"/>
							<div class="password_error"></div>
							<div class="error_description"></div>
							<span class="mdl-textfield__error"></span>
						</div>
						<div class="passStrengthContainer_js">
							<p class="ps_title">надежность пароля</p>
							<div class="ps">
								<div class="ps_lvl ps_lvl_js"></div>
							</div>
						</div>
						<div class="passwdconfirm mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<label class="mdl-textfield__label" for="passwdconfirm">Подтверждение нового пароля:</label>
							<input class="mdl-textfield__input" type="password" name="passwdconfirm" id="passwdconfirm"/>
							<div id="passwdconfirm_error"></div>
							<div class="error_description"></div>
							<span class="mdl-textfield__error"></span>
						</div>
						<div class="buttons_cab">
							<input type="button" data-role="none" data-name="verification" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored btn_js verification_btn" value="Сохранить">
						</div>
					<?break;
				}?>
			</form>
		</div>
		<!--<?if(isset($_GET['success'])){ ?>
			<div class="msg-success">
				<p><b>Успех!</b> Изменения успешно сохранены.</p>
			</div>
		<?}elseif(isset($_GET['unsuccess'])){?>
			<div class="msg-error">
				<p><b>Упс!</b> Что-то пошло не так.</p>
			</div>
		<?}?>-->
		<script type="text/javascript">
			$(function(){
				// $('div[class^="msg-"]').delay(3000).fadeOut(2000);
				//Снять/Выбрать все
				$('.notifications_block_js button').on('click', function(e){
					var action = 'delete';
					e.preventDefault();
					if ($(this).hasClass('select_all_js')){
						$(this).removeClass('select_all_js').html('Снять все');
						$('.notifications_block_js input').prop('checked', true);
						$('.notifications_block_js label').addClass('is-checked');
						action = 'add';
					}else{
						$(this).addClass('select_all_js').html('Выбрать все');
						$('.notifications_block_js input').prop('checked', false);
						$('.notifications_block_js label').removeClass('is-checked');
					}
					ajax('cabinet','updateUserNewsletter', {update:action, id_newsletter:''});
				});
				$('.notify_checkbox_js').on('click', function(){
					var action = 'delete';
					var id = $(this).closest('label').find('.id_notify_js').val();
					if ($(this).prop('checked')){
						action = 'add';
					}
					ajax('cabinet','updateUserNewsletter', {update:action, id_newsletter:id});
				});

			});
		</script>
	</div>
</div>