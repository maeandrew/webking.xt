<style>
#reg_form .input_text input {
    background: none repeat scroll 0 0 transparent;
    border: 1px solid #ccc;
    height: 22px;
	width: 300px;
    line-height: 22px;
    padding-left: 5px;
    margin-bottom: 10px;
}

#reg_form textarea, input {
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px !important;
	border: 1px solid #ccc;
	margin-bottom: 10px;
}
.errmsg{
	color: #f00;
	font-size: 12px;
}
</style>

<span>&nbsp;</span>Подписка на новостую рассылку
<?if (isset($errm) && isset($msg)){?><br><span class="errmsg">Ошибка! <?=$msg?></span><br><br><?}?>
