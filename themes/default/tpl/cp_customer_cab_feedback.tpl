<? require "cp_customer_cab_leftside.tpl";?>
<div class="row">
	<div class="customer_cab col-md-6">
		<div id="feedback">
			<form action="" method="GET">
				<ul id="nav">
					<li>
						<button name="t" value="administration" <?=(!isset($_GET['t']) || $_GET['t']=='administration')?'class="active"':null;?>>
							Написать администрации
						</button>
					</li>
					<li>
						<button name="t" value="manager" <?=(isset($_GET['t']) && $_GET['t']=='manager')?'class="active"':null;?>>
							Написать личному менеджеру
						</button>
					</li>
				</ul>
			</form>
			<div class="clear"></div>
			<form action="MAILTO:arikito.91@gmail.com" class="editing" method="post" enctype="text/plain">
				<div class="line">
					<label for="name">Имя:</label>
					<input type="text" name="name" id="name" required placeholder="Ваше имя"/>
				</div>
				<div class="line">
					<label for="mail">E-mail:</label>
					<input type="email" name="mail" id="mail" required placeholder="Ваш E-mail"/>
				</div>
				<div class="line">
					<label for="comment">Текст письма:</label>
					<textarea name="comment" id="comment" required cols="30" placeholder="Ваш комментарий"></textarea>
					<div class="clear"></div>
				</div>
				<div class="buttons_cab">
					<button type="submit" class="btn-m-green">Отправить</button>
				</div>
			</form>
		</div>
	</div>
</div>