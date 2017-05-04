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
			var check_items = true;
			$('.check_val_js').each(function(){
				switch($(this).prop('type')){
					case 'radio':
						if($('[name='+$(this).prop('name')+']:checked').length === 0){
							check_items = false;
						}
						break;
					default:
						if ($(this).val() === null || $(this).val() === ''){
							check_items = false;
						}
						break;
				}
			});
			if (check_items === true) {
				$('.save_btn_js').attr('disabled', false);
			}else{
				$('.save_btn_js').attr('disabled', true);
			}
		});
	});
</script>