<h1><?=$h1?></h1>
<?if (isset($errm) && isset($msg)){?><div class="notification error"> <span class="strong">Ошибка!</span><?=$msg?></div><br>
<?}elseif(isset($msg)){?><div class="notification success"> <span class="strong">Сделано!</span><?=$msg?></div><br><?}?>

<?if(isset($wishes) && !empty($wishes)){?>
	<?foreach($wishes as $i){?>
		<div class="feedback_container <?=date("d") == date("d", strtotime($i['date_wishes']))?'today':null?>" data-wishes="<?=$i['id_wishes']?>">
			<span class="feedback_author"><?=isset($i['name'])?$i['name']:"Аноним"?></span>
			<span class="feedback_date"><?if(date("d") == date("d", strtotime($i['date_wishes']))){?>
					Сегодня
				<?}elseif(date("d")-1 == date("d", strtotime($i['date_wishes']))){?>
					Вчера
				<?}else{
					echo date("d.m.Y", strtotime($i['date_wishes']));
				}?>
			</span>
			<div class="controls fr">
				<button class="reply open_modal btn-s-green" data-target="reply_js">Ответить</button>
				<label>Видимость <input class="visible" type="checkbox" value="<?=$i['id_wishes']?>" <?=$i['visible'] == 1?'checked':null?>></label>
				<span class="icon-font del_wishes_js">t</span>
			</div>
			<p class="feedback_wishes"><?=$i['text_wishes'];?></p>
			<!-- Конец строки розницы!-->
		</div>
		<?if(!empty($i['reply'])){?>
			<div class="reply_section">
				<div>
					<?foreach($i['reply'] as $k => $reply){?>
						<div class="feedback_container level2 <?=date("d") == date("d", strtotime($reply['date_wishes']))?'today':null?>" data-wishes="<?=$reply['id_wishes']?>">
							<span class="feedback_author"><?=isset($reply['name'])?$reply['name']:"Аноним"?></span>
							<span class="feedback_date"><?if(date("d") == date("d", strtotime($reply['date_wishes']))){?>
									Сегодня
								<?}elseif(date("d")-1 == date("d", strtotime($reply['date_wishes']))){?>
									Вчера
								<?}else{
									echo date("d.m.Y", strtotime($reply['date_wishes']));
								}?>
							</span>
							<div class="controls fr">
								<label>Видимость <input class="visible" type="checkbox" value="<?=$reply['id_wishes']?>" <?=$reply['visible'] == 1?'checked':null?>></label>
								<span class="icon-font del_wishes_js">t</span>
							</div>
							<p class="feedback_wishes"><?=$reply['text_wishes'];?></p>
							<!-- Конец строки розницы!-->
						</div>
					<?}?>
				</div>
			</div>
		<?}
	}?>
	<div id="reply_js" class="modal_hidden">
		<div  class="feedback_form">
			<h2>Ответить</h2>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="message_js">
				<label for="feedback_text">Сообщение:</label>
				<textarea name="feedback_text" id="feedback_text" cols="30" rows="5" required></textarea>
				<div <?=(!isset($_SESSION['member']['id_user']) || $_SESSION['member']['id_user'] == 4028)?null:'class="hidden"';?>>
						<label for="feedback_author">Ваше имя:</label>
						<input type="text" name="feedback_author" id="feedback_author" required value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['name']:null;?>">
					<label for="feedback_authors_email">Эл.почта:</label>
					<input type="email" name="feedback_authors_email" id="feedback_authors_email" required value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['email']:null;?>">
				</div>
				<input type="hidden" name="id_reply" value="">
				<button type="submit" name="sub_wis" class="btn-m-green">Отправить</button>
			</form>
		</div>
	</div>
<?}else{?>
	<div class="notification warning"> <span class="strong">Пожеланий и предложений нет</span></div>
<?}?>