<div class="row">
	<div class="customer_cab col-md-6">
		<h1>Уголок агента</h1>
		<?if(G::IsAgent()){?>
			<div class="agent_profile_info">
				<div class="info_item promocode">
					<div class="info_icon">
						<i class="material-icons">&#xE800;</i>
					</div>
					<div class="info_descr">
						<p class="info_descr_title">Ваш промокод:</p>
						<p class="info_descr_text">AG<?=$_SESSION['member']['id_user']?></p>
					</div>
					<div class="action_icon" id="print_promocode" type="submit">
						<form action="<?=Link::Custom('promo_certificate')?>" target="_blank">
							<input type="hidden" name="agent" value="<?=$_SESSION['member']['id_user']?>">
							<button>
								<i class="material-icons">print</i>
								<p>Распечатать</p>
							</button>
							<div class="mdl-tooltip" for="print_promocode">Распечатать сертификат</div>
						</form>
					</div>
				</div>
				<div class="info_item clients">
					<div class="info_icon">
						<i class="material-icons">&#xE7F0;</i>
					</div>
					<div class="info_descr">
						<p class="info_descr_title">Привлечено клиентов:</p>
					</div>
				</div>
				<div class="info_item bonuses">
					<div class="info_icon">
						<i class="material-icons">&#xE227;</i>
					</div>
					<div class="info_descr">
						<p class="info_descr_title">Получено бонусов:</p>
						<p class="info_descr_text"><?=number_format($total_bonus, 2, ',', '')?> грн.</p>
					</div>
					<div class="action_icon hidden">
						<i id="bonuses_history" class="material-icons">history</i>
						<div class="mdl-tooltip" for="bonuses_history">Просмотреть исторю начисления бонусов</div>
					</div>
				</div>
			</div>
		<?}?>
		<?=$content;?>
	</div>
</div>

<script>
	$(function(){
		$('.confirm_checkbox_js').on('change', function(){
			if($(this).prop('checked')){
				$('.confirm_btn_js').attr('disabled', false);
			}else{
				$('.confirm_btn_js').attr('disabled', true);
			}
		});
		$('.toggle_btn_js').on('click', function(){
			var qty = $(this).closest('.orders_history_content').find('.agents_client_order').size();
			if(!$(this).closest('.orders_history_content').hasClass('opened')){
				if(IsMobile){
					$(this).closest('.orders_history_content').css('max-height', qty*50*4 + 'px');
				}else{
					$(this).closest('.orders_history_content').css('max-height', qty*50 + 'px');
				}
			}else{
				$(this).closest('.orders_history_content').css('max-height', '50px');
			}
			$(this).closest('.orders_history_content').toggleClass('opened');
		});
	});
</script>