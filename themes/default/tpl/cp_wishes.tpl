<div id="wishes" class="row">
	<div class="col-md-7 col-sm-6">
	<?if(empty($wishes)){?>
		<div class="feedback_container">
			<p class="feedback_wishes">Ваше сообщение может быть первым!</p>
		</div>
	<?}else{
		foreach($wishes as $i){?>
			<div class="feedback_container" data-wishes="<?=$i['id_wishes']?>">
				<span class="feedback_author"><?=isset($i['name'])?$i['name']:"Аноним"?></span>
				<span class="feedback_date"><span class="icon-font">clock </span><?if(date("d") == date("d", strtotime($i['date_wishes']))){?>
						Сегодня
					<?}elseif(date("d")-1 == date("d", strtotime($i['date_wishes']))){?>
						Вчера
					<?}else{
						echo date("d.m.Y", strtotime($i['date_wishes']));
					}?>
				</span>
				<span class="fright reply"><a href="#">Ответить</a></span>
				<p class="feedback_wishes"><?=$i['text_wishes'];?></p>
				<!-- Конец строки розницы!-->
			</div>
			<?if(!empty($i['reply'])){?>
				<div class="reply_section">
					<div>
						<?foreach($i['reply'] as $k => $reply){?>
							<?if($k == 3){?>
								</div>
								<div class="more_reply">
							<?}?>
							<div class="feedback_container level2">
								<span class="feedback_author"><?=isset($reply['name'])?$reply['name']:"Аноним"?></span>
								<span class="feedback_date"><span class="icon-font">clock </span><?if(date("d") == date("d", strtotime($reply['date_wishes']))){?>
										Сегодня
									<?}elseif(date("d")-1 == date("d", strtotime($reply['date_wishes']))){?>
										Вчера
									<?}else{
										echo date("d.m.Y", strtotime($reply['date_wishes']));
									}?>
								</span>
								<p class="feedback_wishes"><?=$reply['text_wishes'];?></p>
								<!-- Конец строки розницы!-->
							</div>
						<?}?>
					</div>
					<?if(count($i['reply']) > 3){?>
						<p class="read_more"><a href="#">Показать все</a></p>
					<?}?>
				</div>
			<?}
		}
	}?>
	</div>
	<div class="col-md-5 col-sm-6">
		<div class="feedback_form">
			<h4>Оставить сообщение</h4>
			<span class="cancel_reply"><a href="#">Отмена</a></span>
			<hr>
			<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="message_js" onsubmit="onWishesSubmit()">
				<label for="feedback_text">Сообщение:</label>
				<textarea name="feedback_text" id="feedback_text" cols="30" rows="5" required></textarea>
				<div <?=(!isset($_SESSION['member']['id_user']) || $_SESSION['member']['id_user'] == 4028)?null:'class="hidden"';?>>
						<label for="feedback_author">Ваше имя:</label>
						<input type="text" name="feedback_author" id="feedback_author" required value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['name']:null;?>">

					<label for="feedback_authors_email">Эл.почта:</label>
					<input type="email" name="feedback_authors_email" id="feedback_authors_email" required value="<?=isset($_SESSION['member']) && $_SESSION['member']['id_user'] != 4028?$_SESSION['member']['email']:null;?>">
				</div>
				<button type="submit" name="sub_wis" class="btn-m-green">Отправить</button>
			</form>
		</div>
	</div>
</div>
<script>

	/** Плавающий блок отправки сообщения*/
	var params = $('.feedback_form'),
		topPos = params.offset().top;
	$(window).scroll(function(){
		var top = $(document).scrollTop(),
			footer = $('footer').offset().top,
      		height = params.outerHeight();
		 if(top > topPos - 50 && top < footer - (height + 70)) {
		 	params.css("top", $(this).scrollTop() - 140);
		 }else if(top > footer - height){
		 	params.css('bottom','0');
		 }else{
		 	params.css("top", '0');
		 }
	});
</script>