<h1>Мой бонусный счет</h1>
<a class="bonus_detalies" href="<?=Link::Custom('page', 'Skidki_i_bonusy');?>" class="details"><i class="material-icons">help_outline</i> Детали бонусной программы</a>
<?if(!$Customer['bonus_card'] && isset($msg)){?>
	<div class="msg-<?=$msg['type']?> bonus_info">
		<div class="msg_icon">
			<i class="material-icons"></i>
		</div>
	    <p class="msg_title">!</p>
	    <p class="msg_text"><?=$msg['text']?></p>
	</div>
<?}?>
<div class="bonus_content">
	<?if(!$Customer['bonus_card']){?>
		<div class="info_text">
			<p>Вы получили бонусную карту?</p>
			<p>Пришло время ее активировать!</p>
			<span>Для этого заполните, пожалуйста, в <a href="?t=change_bonus">личных данных</a> информацию, которая поможет нам сделать Ваши покупки проще, а работу с нами - приятнее.</span>
		</div>
	<?}else{?>
		<div class="bonus_balance">
			<p>Номер карты:
				<span class="value">№<?=$Customer['bonus_card']?></span>
			</p>
			<p>Бонусный баланс:
				<span class="value">
					<?=$Customer['bonus_balance']!=null?number_format($Customer['bonus_balance'],2,",",""):"20,00"?><span class="unit"> грн.</span>
				</span>
			</p>
			<p>Бонусный Процент:
				<span class="value">
					<?=$Customer['bonus_discount']!=null?$Customer['bonus_discount']:1?><span class="unit"> %</span>
				</span>
			</p>
		</div>
	<?}?>
</div>
