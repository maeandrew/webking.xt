<div class="row">
	<div class="customer_cab col-md-6">
		<div id="bonus">
			<?=$content;?>
		</div>
	</div>
</div>
<script>
	$(function(){		
		$('input, select').on('change', function(){			
			var bonus_card = $('#bonus_card').val();
			var day = $('#day').val();
			var month = $('.month_js').val();
			var year = $('#year').val();
			var learned_from = $('.learned_from_js').val();
			var buy_volume = $('.buy_volume_js').val();
			var check_gender = 0;
			$('#gender input').each(function(){
				if ($(this).prop("checked")) {
					check_gender = 1;
				}
			});
			if ((bonus_card && day && month && year && learned_from && buy_volume !== null) &&  check_gender !== 0) {
				$('.save_btn_js').attr('disabled', false);
			}else{
				$('.save_btn_js').attr('disabled', true);
			}
		});
	});
</script>