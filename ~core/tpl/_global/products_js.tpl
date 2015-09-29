<script type="text/javascript">
	$(function(){
		jQuery('.input_text input, .input_search input')
			.bind('focus', Function("if(this.value==this.defaultValue) this.value=''"))
			.bind('blur', Function("if(this.value=='') this.value=this.defaultValue"));

		$(".error, .done").click(function(){
			$(this).parent().parent().find('.edit_box').fadeToggle();
			return false;
		});
	});
</script>
