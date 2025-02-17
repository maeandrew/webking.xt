<style>
.errmsg{
	color: #f00;
	font-size: 16px;
	clear:both;
}
.input_text .errmsg {
	margin-left: 400px;
	width: 300px;
	}
</style>
<!-- SHOWCASE SLIDER -->
<div id="showcase_bg" class="showcase_bg animate"></div>
<div id="showcase" class="showcase animate paper_shadow_1"></div>
<!-- Скрытая форма со значениями параметров дл яскидок и надбавок, которые можно изменить в панели администратора.
Инициализация переменных, исходя из этих значений происходит в скрипте func.js !-->
<form id="cart_discount_and_margin_parameters">
	<input type="hidden" id="cart_full_wholesale_order_margin" value="<?=$GLOBALS['CONFIG']['full_wholesale_order_margin']?>"/>
	<input type="hidden" id="cart_wholesale_order_margin" value="<?=$GLOBALS['CONFIG']['wholesale_order_margin']?>"/>
	<input type="hidden" id="cart_wholesale_discount" value="<?=$GLOBALS['CONFIG']['wholesale_discount']?>"/>
	<input type="hidden" id="cart_retail_order_margin" value="<?=$GLOBALS['CONFIG']['retail_order_margin']?>"/>
	<input type="hidden" id="cart_retail_multiplyer" value="<?=$GLOBALS['CONFIG']['retail_multiplyer']?>"/>
	<input type="hidden" id="cart_personal_discount" value="<?=$personal_discount ?>"/>
	<input type="hidden" id="cart_price_mode" value="<?=$_SESSION['price_mode']?>"/>
</form>
<!-- Скрытая форма !-->
<div class="cabinet" id="cart">
<script>var randomManager; qtycontrol = new Array(); notecontrol = new Array();</script>
<?if(!count($list)){?>
	<div class="no_items">
		<p class="cat_no_items">Ваша корзина пуста!</p>
		<img src="<?file_exists($GLOBALS['PATH_root'].'/images/empty-cart.jpg')?_base_url.'/images/empty-cart.jpg':'/images/nofoto.png'?>"/>
		<p>Перейдите в <a href="<?=_base_url?>/promo">каталог</a> для совершения покупок</p>
	</div>
<?}else{?>
<h1>Корзина</h1>
<?if(isset($errm) && isset($msg)){?>
	<br><span class="errmsg">Ошибка! <?=$msg?></span><br>
<?}?>
<?=isset($errm['products'])?"<span class=\"errmsg\">".$errm['products']."</span>":null?>
<?if(isset($_SESSION['errm'])){
	foreach ($_SESSION['errm'] as $msg){
		if (!is_array($msg)){?>
			<span class="errmsg"><?=$msg?></span><br>
			<script type="text/javascript">
			$('html, body').animate({
				scrollTop: 0
			}, 500, "easeInOutCubic");
			</script>
		<?}
	}
}?>
<table id="cart_table" class="promo_cart_table">
	<thead>
		<tr>
			<!-- Верхние строчки шапки таблицы товаров!-->
			<td class="name" colspan="3">Наименование товара</td>
			<td class="note">Примечание</td>
			<td class="price">Цена</td>
			<td class="quantity">Количество</td>
			<td class="sum">Сумма по товару</td>
		</tr>
		<!-- Начало строк товаров!-->
	</thead>
	<tbody>
	<?$i=0;
	foreach($list as $item){
		$item['price_mopt']>0 ? $mopt_available = TRUE : $mopt_available = FALSE;
		$item['price_opt']>0 ? $opt_available = TRUE : $opt_available = FALSE; ?>
		<!-- Начало строки опта!-->
		<tr class="cat_item_<?php echo ($i % 2 === 0)?'odd':'even' ?>_<?php echo $item['price_opt']>0 && $item['inbox_qty']>0?'active':'disabled' ?> opt" id="cat_item_<?=$item['id_product']?>_opt">
			<td rowspan="2" class="cart_remove">
				<a onClick="cartRemove(<?=$item['id_product']?>)">X</a>
			</td>
			<td class="cat_photo"  rowspan="2">
				<a href="<?=file_exists($GLOBALS['PATH_root'].$item['img_1'])?_base_url.htmlspecialchars($item['img_1']):'/images/nofoto.png'?>">
					<img alt="" src="<?=_base_url.G::GetImageUrl($item['img_1'], 'thumb')?>" title="Нажмите для увеличения" />
				</a>
			</td>
			<td class="cat_name" rowspan="2">
				<?if(isset($_SESSION['erri']['limit_err'][$item['id_product']])){
					echo $_SESSION['erri']['limit_err'][$item['id_product']]."<br>";?>
					<script type="text/javascript">
					$('html, body').animate({
						scrollTop: 0
					}, 500, "easeInOutCubic");
					</script>
				<?}?>
				<?=isset($_SESSION['errm']['products'][$item['id_product']]['order_opt_sum'])?'<span class="errmsg">'.number_format($_SESSION['errm']['products'][$item['id_product']]['order_opt_sum'],2,",","")."</span><br>":null?>
				<?=isset($_SESSION['errm']['products'][$item['id_product']]['order_mopt_sum'])?'<span class="errmsg">'.number_format($_SESSION['errm']['products'][$item['id_product']]['order_mopt_sum'],2,",","")."</span><br>":null?>
				<div class="text_wrapper">
					<span style="color:rgb(44,44,44);">
						<?=G::CropString($item['name'])?>
					</span>
					<span class="cart_note_mopt" id="cart_note_mopt_<?=$item['id_product']?>"><?=$_SESSION['Cart']['products'][$item['id_product']]['note_mopt']?></span>
					<span class="cart_note_opt" id="cart_note_opt_<?=$item['id_product']?>"><?=$_SESSION['Cart']['products'][$item['id_product']]['note_opt']?></span>
				</div>
			</td>
		</tr>
		<tr class="cat_item_<?php echo ($i % 2 === 0)?'odd':'even' ?>_<?php echo $item['price']>0 && $item['min_mopt_qty']>0 ?'active':'disabled' ?> mopt" id="cat_item_<?=$item['id_product']?>_mopt" >
			<!--Начало строки розницы!-->
			<!--****************************************************************************-->
			<!--*******************************МЕЛКООПТОВЫЕ ЦЕНЫ ЦЕНЫ **********************-->
			<!--****************************************************************************-->
			<!--Примечание к Товару-->
			<?if($_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty']>0){?>
			<td class="cat_note">
				<!--Скрытая форма примечания ОСТОРОЖНО, если между тегами textarea будут проблеы - примечания перестанут нормально работвть-->
				<form action="<?=$_SERVER['REQUEST_URI']?>">
					<textarea cols="30" rows="3" id="mopt_note_<?=$item['id_product']?>" onchange="toCart(<?=$item['id_product']?>, 0)"><?=isset($_SESSION['Cart']['products'][$item['id_product']]['note_mopt'])?$_SESSION['Cart']['products'][$item['id_product']]['note_mopt']:null?></textarea>
				</form>
				<?if($item['qty_control']){?>
					<script>qtycontrol[<?=$item['id_product']?>] = 1;</script>
				<?}?>
				<?if($item['note_control']){?>
					<script>notecontrol[<?=$item['id_product']?>] = 1;</script>
				<?}?>
			</td>
			<td id="correction_set_price_mopt_<?=$item['id_product']?>" style="display: none;"><?=$GLOBALS['CONFIG']['correction_set_'.$item['mopt_correction_set']]?></td>
			<td class="cart_basic_price" style="display:none;" id="price_mopt_<?=$item['id_product']?>_basic"><?=number_format($item['price'],2,",","");?>грн.</td>
			<td class="cart_your_price price<?=$item['id_product']?>" id="price_mopt_<?=$item['id_product']?>" name="<?=$item['id_product']?>"><?=number_format($item['price'],2,",","")?>грн.</td>
				<!--****************************************************************************-->
			<td class="cat_min_order" style="display: none;">
				От <span id="min_mopt_qty_<?=$item['id_product']?>"><?echo $item['min_mopt_qty']?></span> шт. <?=$item['qty_control']?" *":null?>
			</td>
			<td class="cat_make_order">
				<?if($mopt_available && $item['min_mopt_qty']>0){
					if($_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty']==0){?>
						<div class="buy_button_container" id="mopt_buy_button_<?=$item['id_product']?>" onClick="ch_qty('plus',<?=$item['id_product']?>);return false;">
							<div class="buy_quantity"><?=$item['min_mopt_qty'].$item['units']?><?=$item['qty_control']?"*":null?></div>
							<input type="button" class="buy_button" onClick="return false;" value="Купить"/>
						</div>
						<div class="buy_buttons" id="mopt_buy_buttons_<?=$item['id_product']?>" style="display: none;">
					<?}else{?>
						<div class="buy_button_container" id="mopt_buy_button_<?=$item['id_product']?>" style="display: none;" onClick="ch_qty('plus',<?=$item['id_product']?>);return false;">
							<div class="buy_quantity"><?=$item['min_mopt_qty'].$item['units']?><?=$item['qty_control']?"*":null?></div>
							<input type="button" class="buy_button" onClick="return false;" value="Купить"/>
						</div>
					<div class="buy_buttons" id="mopt_buy_buttons_<?=$item['id_product']?>">
					<?}?>
						<a href="" class="cat_count_up_icon buy_button" onClick="ch_qty('plus',<?=$item['id_product']?>);return false;">+</a>
						<input type="text" class="cat_mopt_order_qty" id="order_mopt_qty_<?=$item['id_product']?>" value="<?=isset($_SESSION['Cart']['products'][$item['id_product']]['order_box_qty'])?$_SESSION['Cart']['products'][$item['id_product']]['order_mopt_qty']:"0"?>" onchange="toCart(<?=$item['id_product']?>, 0)" size="4" />
						<a href="#" class="cat_count_down_icon buy_button" onClick="ch_qty('minus',<?=$item['id_product']?>);return false;">-</a>
					</div>
				<?}else{?>
					<div class="buy_button">Недоступно</div>
				<?}?>
			</td>
			<td class="cart_item_sum" >
				<span id="order_mopt_sum_<?=$item['id_product']?>">
					<?=isset($_SESSION['Cart']['products'][$item['id_product']]['order_mopt_sum'])?number_format($_SESSION['Cart']['products'][$item['id_product']]['order_mopt_sum'],2,",",""):"0,00"?>
				</span> грн.
			</td>
			<!-- Конец строки розницы!-->
			<?}?>
		</tr>
		<?$i++;?>
	<?}?>
	</tbody>
</table>
<script>pcart=1;discount=<?=$discount?>;</script>
<div id="cart_order_total">
	<div class="sum_order">
		<div id="cart_order_sum_caption_base">Сумма к оплате:</div>
		<div id="cart_order_sum_caption">
			<div id="cart_order_sum">
				<?=isset($_SESSION['Cart']['sum_discount'])?number_format($_SESSION['Cart']['sum_discount'],2,",",""):"0,00"?>
			</div>грн.
		</div>
	</div>
	<div class="clear_cart">
		<span>&times;</span>
		<a href="<?=_base_url?>/cart/clear/">Очистить корзину</a>
	</div>
	<?if(isset($filial_notificator) == true){?>
		<span class="filial_notificator"><img src="<?=file_exists($GLOBALS['PATH_root'].'/images/odessa_filial.png')?_base_url.'/images/odessa_filial.png':'/images/nofoto.png'?>" width="80" alt="В заказе имеются товары с одесского склада"><p>Отмеченные товары будут отгружены со склада в Одессе.</p></span>
	<?}?>
</div>
<div id="order" class="order">
	<h2>Оформление заказа</h2>
	<?if(isset($_SESSION['member']['email'])
		&& $_SESSION['member']['email'] !== 'anonymous'
		&& (!$SavedContragent
			|| !$SavedCity
			|| !$SavedDeliveryMethod['id_delivery']
			|| !$Customer['cont_person']
			|| !$Customer['phones'])){
		$_POST['edit']=1;
	}?>
	<form action="<?=_base_url?>/promo_cart/#order" method="post" style="padding-bottom: 10px;">
		<section class="left">
			<div class="line cont_person">
				<label for="cont_person">Контактное лицо</label>
				<input required type="text" name="cont_person" id="cont_person" value="<?=$Customer['cont_person']?>"/>
				<div id="name_error"></div>
			</div>
			<div class="line phone">
				<label for="phone">Контактный телефон</label>
				<div class="phones">
					<input required type="tel" name="phones" id="phone" maxlength="15" value="<?=$Customer['phones']?>"/>
					<div id="phone_error"></div>
				</div>
				<p class="shadowtext">(099 123-45-67) - образец!</p>
			</div>
			<div id="addressdescr" class="line">
				<label for="description">Дополнительная информация</label>
				<textarea name="description" id="description"></textarea>
			</div>
			<input type="hidden" name="discount" value="<?=$personal_discount?>"/>
			<div class="clear"></div>
			<br>
			<div class="buttons">
				<input type="submit" name="order" class="send_order confirm" value="Оформить заказ"/>
			</div>
		</section>
		<div class="clear"></div>
	</form>
</div>
<?}?>
<?unset($_SESSION['errm'])?>
<script type="text/javascript">
$('input.send_order, input.save_order').click(function(e){
	var name = $('#edit #name').val().length;
	var phone = $('#edit #phone').val().length;
	var id_manager = $('#edit #id_manager').val();
	var id_city = $('#edit #id_delivery_department').val();
	if(name > 3){
		if(phone > 0){
			if(id_manager != null){
				if(id_city != null){
					$(this).submit();
				}else{
					e.preventDefault();
					alert("Город не выбран");
				}
			}else{
				e.preventDefault();
				alert("Менеджер не выбран");
			}
		}else{
			e.preventDefault();
			$("#phone").removeClass().addClass("unsuccess");
			alert("Телефон не указан");
		}
	}else{
		e.preventDefault();
		$("#name").removeClass().addClass("unsuccess");
		alert("Контактное лицо не заполнено");
	}
});
$("#name").blur(function(){
	var name = this.value;
	var nName = name.replace(/[^A-zА-я ]+/g, "");
	var count = nName.length;
	if(count < 3){
		$(this).removeClass().addClass("unsuccess");
	}else{
		$("#name").prop("value",nName);
		$(this).removeClass().addClass("success");
	}
});
$("#phone").blur(function(){
	var phone = this.value;
	var nPhone = phone.replace(/[^0-9]+/g, "");
	var count = nPhone.length;
		$("#phone").prop("value",nPhone);
	if(count == 10){
		$(this).removeClass().addClass("success");
	}else{
		$(this).removeClass().addClass("unsuccess");
	}
});
/** Set Random contragent */
if(randomManager == 1){
	var arr = new Array();
	var n = 1;
	$("#id_manager option").each(function(){
		arr.push(n);
		n++;
	});
	var random = Math.ceil(Math.random() * arr.length);
	$("#id_manager .cntr_"+random).prop("selected","true");
}
function ResetForm(){
	$("#id_delivery").val(0);
	$("#id_city").val(0);
	$("#cityblock").fadeOut();
	$("#id_delivery_service").val(0);
	$("#delivery_serviceblock").fadeOut();
	$("#id_parking").val(0);
	$("#parkingblock").fadeOut();
	$("#id_contragent").val(0);
	$("#contragentblock").fadeOut();
	$("#addressdescr").val(0);
	$("#addressdescr").fadeOut();
	$("#contrlink").val(0);
	$("#contrlink").fadeOut();
}
</script>
<script>cartUpdateInfo();</script>
<!--class="cabinet"-->
</div>