<div class="row">
	<div class="customer_cab col-md-6">

		<div id="settings">
			<form class="editing" action="" method="post">
				<input required="required" type="hidden" name="id_user" value="<?=$User['id_user']?>"/>
				<?!isset($_GET['t'])?$var = '':$var = $_GET['t'];
				switch($var){
					default:?>
						<input required="required" type="hidden" name="save_settings" value="1"/>
						<input required="required" type="hidden" name="gid" value="<?=$User['gid']?>"/>
						<input required="required" type="hidden" name="email" value="<?=$User['email']?>"/>
						<div class="line email">
							<label for="news">Хочу получать рассылку новостей сайта</label>
							<input type="checkbox" name="news" id="news" <?if($User['news']==1){?>checked<?}?> value="1"/>
						</div>
						<div id="contragent" class="line">
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
						</div>
						<!--
						<div class="line email">
							<label for="promo_code">Промо-код:</label>
							<input type="text" name="promo_code" id="promo_code"  value="<?=$User['promo_code'];?>"/>
						</div>-->
						<div class="buttons_cab">
							<button type="submit" data-role="none" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Сохранить</button>
						</div>
					<?break;
					case 'password':?>
						<input required="required" type="hidden" name="save_password" value="1"/>
						<input type="hidden" name="email" id="email" value="<?=$User['email']?>"/>
						<input type="hidden" name="gid" id="gid" value="<?=$User['gid']?>"/>
						<div class="new_passwd mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<label class="mdl-textfield__label" for="regpasswd">Новый пароль:</label>
							<input class="mdl-textfield__input" type="password" name="new_passwd" id="regpasswd"/>

							<!-- <div id="passstrength">
								<div id="passstrengthlevel"></div>
							</div> -->
							<div id="password_error"></div>
							<div class="error_description"></div>
							<span class="mdl-textfield__error"></span>
						</div>
						<div id="passstrength"><div id="passstrengthlevel"></div></div>
						<div class="passwdconfirm mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<label class="mdl-textfield__label" for="passwdconfirm">Подтверждение нового пароля:</label>
							<input class="mdl-textfield__input" type="password" name="passwdconfirm" id="passwdconfirm"/>
							<div id="passwdconfirm_error"></div>
							<div class="error_description"></div>
							<span class="mdl-textfield__error"></span>
						</div>
						<div class="buttons_cab">
							<button type="submit" data-role="none" class="btn-m-green mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Сохранить</button>
						</div>
					<?break;
				}?>
			</form>
		</div>
		<?if(isset($_GET['success'])){?>
			<div class="msg-success">
				<p><b>Успех!</b> Изменения успешно сохранены.</p>
			</div>
		<?}elseif(isset($_GET['unsuccess'])){?>
			<div class="msg-error">
				<p><b>Упс!</b> Что-то пошло не так.</p>
			</div>
		<?}?>
		<script type="text/javascript">
			$('div[class^="msg-"]').delay(3000).fadeOut(2000);
		</script>
	</div>
</div>