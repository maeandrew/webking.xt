<div class="cabinet row">
	<div class="col-md-12">
		<div class="msg-info">
			<p>Раздел сайта на реконструкции. Попробуйте зайти позже.</p>
		</div>
	</div>
<!-- <div class="promo_table">
		<div class="header">
			<div class="row">
				<div>№</div>
				<div class="name">Название</div>
				<div class="promo_code">Код</div>
				<div class="percent">Наценка</div>
				<div class="action_edit">Изменить</div>
				<div class="action_delete">Удалить</div>
			</div>
		</div>
		<div class="body">
			<?$i = 0;
			if(!empty($promo)){
				foreach($promo AS $p){
					$i++;?>
					<div class="row" <?=$i%2==0?'style="background:#eee"':null;?>>
						<div><?=$i?></div>
						<div class="name"><?=$p['name']?></div>
						<div class="promo_code"><?=$p['code']?></div>
						<div class="percent"><?=$p['percent']?>%</div>
						<div class="action_edit">
							<form class="row new_promo" action="#" method="POST">
								<input type="hidden" name="id" value="<?=$p['id']?>">
								<input type="text" name="name" style="width:90px;" placeholder="Название">
								<input type="text" name="percent" placeholder="%">
								<input type="submit" name="edit" class="btn-m btn-green" value="Изменить">
							</form>
						</div>
						<div class="action_delete">
							<form class="row new_promo" action="#" method="POST">
								<input type="hidden" name="id" value="<?=$p['id']?>">
								<input type="submit" name="delete" class="btn-m btn-red" value="Удалить">
							</form>
						</div>
					</div>
					<?
				}
			}else{?>
				<div class="row">
					<div class="promo_code" style="max-width: 100%;">Не активировано ни одного кода</div>
				</div>
			<?}
			if($i < 5){?>
				<div class="row">
					<form class="row new_promo" action="#" method="POST">
						<div class="promo_code" style="max-width: 100%;">Добавить код<input type="text" name="name" style="width:150px;" placeholder="Название" required="required"> с наценкой:<input type="text" name="percent">% <input type="submit" name="submit" class="btn-m btn-green" value="Добавить"></div>
					</form>
				</div>
			<?}?>
		</div>
	</div>
	<h1>Список клиентов с вашим кодом</h1>
	<div class="clear"></div>
	<div class="promo_clients_table">
		<div class="header">
			<div class="row">
				<div>№</div>
				<div class="name">Контактное лицо</div>
				<div class="promo_code"><b>Код</b></div>
				<div class="phones">Контактный телефон</div>
				<div class="email">E-mail</div>
			</div>
		</div>
		<div class="body">
			<?$i = 0;
			if(!empty($code)){
				foreach($code AS $c){
					if(!empty($c['users'])){
						foreach($c['users'] AS $u){
							$i++;?>
							<div class="row" <?=$i%2==0?'style="background:#eee"':null;?>>
								<div><?=$i?></div>
								<div class="name"><?=$u['cont_person']?></div>
								<div class="promo_code"><?=$c['name']?> <span> <?=$u['promo_code']?></span></div>
								<div class="phones"><?=$u['phones']?></div>
								<div class="email"><?=$u['email']?></div>
							</div>
							<?
						}
					}
				}
			}else{?>
				<div class="row">
					<div class="promo_code" style="max-width: 100%;">Нету ни одного клиента</div>
				</div>
			<?}?>
		</div>
	</div> -->
</div>
<script>
	// $(function(){
	// 	$('.promo_table input[name="percent"]').keyup(function(){
	// 		$(this).val($(this).val().replace(/\D+/g,""));
	// 	});
	// });
</script>