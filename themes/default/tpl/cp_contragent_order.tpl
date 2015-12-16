<style>

.errmsg{color: #f00;font-size: 12px;}

.run_order {

background-image: linear-gradient(bottom, rgb(46,179,219) 0%, rgb(177,230,245) 100%);

background-image: -o-linear-gradient(bottom, rgb(46,179,219) 0%, rgb(177,230,245) 100%);

background-image: -moz-linear-gradient(bottom, rgb(46,179,219) 0%, rgb(177,230,245) 100%);

background-image: -webkit-linear-gradient(bottom, rgb(46,179,219) 0%, rgb(177,230,245) 100%);

background-image: -ms-linear-gradient(bottom, rgb(46,179,219) 0%, rgb(177,230,245) 100%);

background-image: -webkit-gradient(linear, left bottom, left top, color-stop(0, rgb(46,179,219)), color-stop(1, rgb(177,230,245)));}

.fakt {

background-image: linear-gradient(bottom, rgb(217,117,50) 0%, rgb(255,192,125) 100%);

background-image: -o-linear-gradient(bottom, rgb(217,117,50) 0%, rgb(255,192,125) 100%);

background-image: -moz-linear-gradient(bottom, rgb(217,117,50) 0%, rgb(255,192,125) 100%);

background-image: -webkit-linear-gradient(bottom, rgb(217,117,50) 0%, rgb(255,192,125) 100%);

background-image: -ms-linear-gradient(bottom, rgb(217,117,50) 0%, rgb(255,192,125) 100%);

background-image: -webkit-gradient(linear,left bottom,left top,color-stop(0, rgb(217,117,50)),color-stop(1, rgb(255,192,125)));}

.fakt, .run_order {

border-radius: 3px;

color: #fff;

cursor: pointer;

display: block;

font-family: "Trebuchet MS", Helvetica, sans-serif;

font-size: 14px;

margin: 10px 0;

max-width: 200px;

padding: 5px 15px;

text-align: center;

text-decoration: none;

text-shadow: 0px 1px 20px rgba(0,0,0,.8);}

</style>



<div class="cabinet">

<?if (isset($errm) && isset($msg)){?><br><span class="errmsg">Ошибка! <?=$msg?></span><br><?}?>

<?=isset($errm['products'])?"<span class=\"errmsg\">".$errm['products']."</span>":null?>



<?if(isset($_SESSION['errm'])){

	foreach ($_SESSION['errm'] as $msg){if (!is_array($msg)){?>

		<span class="errmsg"><?=$msg?></span><br>

<?}}}unset($_SESSION['errm'])?>





                <rh3>Заказ № <?=$order['id_order']?>   <span><?=date("d.m.Y",$order['target_date'])?></span>



                    <?php if($order['id_order_status']==4): ?>

                    (Отменено контрагентом)

                    <?php endif ?>



                    <?php if($order['id_order_status']==5): ?>

                    (Отменено клиентом)

                    <?php endif ?>



                </rh3>

<?php if($order['id_order_status']==1): ?>

<form action="<?=$GLOBALS['URL_request']?>" method="post">

    <input type="submit" name="smb_run" class="run_order" value="На выполнение">

</form>

<?php endif ?>

<?php if($order['id_order_status']==2): ?>

	<a target="_blank" class="fakt" href="<?=_base_url?>/invoice_customer_fakt/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная покупателя ФАКТ</a>

<?php endif ?>



<b><?php echo $order['note'] ?> </b>

                <form action="<?=$GLOBALS['URL_request']?>" method="post">

<script>p_ids = new Array();ii=0;</script>

                <table border="0" cellpadding="0" cellspacing="0" class="returns_table" width="100%">

					<col width="70">

                    <tr>

                        <th class="code_cell">Код</th>

                        <th class="name_cell">Название</th>

                        <th class="price_cell">Цена за 1 шт. <br>от ящика, грн.</th>

                        <th class="count_cell">Кол-во <br>в ящике</th>



                        <th class="count_cell">Заказано <br>штук</th>

                        <th class="count_cell">Сумма <br>заказано</th>



                        <th class="price_cell">Кол-во <br>по контр-<br>агенту</th>

                        <th class="price_cell">Сумма <br>по контр-<br>агенту</th>



						<th class="price_cell">Кол-во <br>факт.</th>

						<th class="price_cell">Сумма <br>факт.</th>

                    </tr>

                    <?

                    	$t['opt_sum']=0;

                    	$t['contragent_qty']=0;

                    	$t['contragent_sum']=0;

                    	$t['fact_qty']=0;

                    	$t['fact_sum']=0;



                    	$t['mopt_sum']=0;

                    	$t['contragent_mqty']=0;

                    	$t['contragent_msum']=0;

                    	$t['fact_mqty']=0;

                    	$t['fact_msum']=0;

                    ?>



                    <?$Contragent = new Contragents();?>

					<?foreach($data as $i){?>

                    <?if($i['opt_qty']!=0){// строка по опту?>



                    <tr>

                         <td class="code_cell" style="padding: 2px 1px 6px;">

                         	<?if($order['id_order_status']!=2){?>

                         	<select<?if($order['id_order_status']==2){?>disabled="disabled"<?}?> name="article[<?=$i['id_product']?>]" style="width: 60px;">

	                         	<?$art_arr = $Contragent->GetSupplierArticlesByOrder($order['id_order'], $i['id_product'], true)?>

								<?foreach ($art_arr as $art){?>

	                         		<option<?if($i['article']==$art['article']){?> selected="selected"<?}?> value="<?=$art['article']?>"><?=$art['article']?></option>

	                         	<?}?>

                         	</select>

                         	<?}else{?>

                         		<div style="margin-left: 20px;"><?=$i['article']?></div>

                         	<?}?>

                         </td>



                         <td class="name_cell">

                             <a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/efiles/_thumb/nofoto.jpg'?>" onclick="return hs.expand(this)" class="highslide"><img alt="<?=$i['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/efiles/_thumb/nofoto.jpg'?>" title="Нажмите для увеличения"></a>

                             <a href="<?=_base_url?>/product/<?=$i['id_product']?>/"><?=$i['name']?></a>

                                <div>&nbsp;

                                </div>

                                <div style="padding: 0px">

                                <!--noindex-->Арт.<!--/noindex--><?=$i['art']?></div>

                         </td>

                         <td class="price_cell"><p id="pprice_opt_<?=$i['id_product']?>"><?=round($i['site_price_opt'],2)?></p></td>

                         <td class="count_cell"><p><?=$i['inbox_qty']?> шт.</p></td>

                         <td class="price_cell"><p><?=$i['opt_qty']?> шт.</p></td>

                         <td class="price_cell"><p><?=round($i['opt_sum'],2)?></p></td>

                         <?$t['opt_sum']+=round($i['opt_sum'],2);?>



						 <?$i['contragent_qty'] = ($i['contragent_qty']>=0)?$i['contragent_qty']:$i['opt_qty'];?>

                         <td class="count_cell"><div class="unit"><input <?if($i['id_order_status']==2){?>disabled="disabled"<?}?> name="contr_qty[<?=$i['id_product']?>]" id="contr_qty_<?=$i['id_product']?>" type="text" value="<?=$i['contragent_qty']?>" onchange="ContrRecalcSum(this,<?=$i['id_product']?>,true)" class="input_table" /></div></td>

                         <?$t['contragent_qty']+=$i['contragent_qty'];?>



                         <?$i['contragent_sum'] = ($i['contragent_sum']!=0 || $i['contragent_qty']>=0)?$i['contragent_sum']:round($i['site_price_opt']*$i['opt_qty'],2);?>

                         <td class="price_cell"><p id="pcontr_sum_<?=$i['id_product']?>"><?=$i['contragent_sum']?></p></td>

                         <?$t['contragent_sum']+=$i['contragent_sum'];?>



                         <?$i['fact_qty'] = ($i['fact_qty']>=0)?$i['fact_qty']:0;?>

                         <td class="price_cell"><p><?=$i['fact_qty']?></p></td>

                         <?$t['fact_qty']+=$i['fact_qty'];?>



                         <?$i['fact_sum'] = ($i['fact_sum']!=0)?$i['fact_sum']:0;?>

                         <td class="price_cell"><p><?=$i['fact_sum']?></p></td>

                         <?$t['fact_sum']+=$i['fact_sum'];?>



                    </tr>

                    <?} if($i['mopt_qty']!=0){// строка по мелкому опту?>

                    <tr>

                         <td class="code_cell" style="padding: 2px 1px 6px;">

	                        <?if($order['id_order_status']!=2){?>

	                        <select name="article_mopt[<?=$i['id_product']?>]" style="width: 60px;">

	                         	<?$art_arr = $Contragent->GetSupplierArticlesByOrder($order['id_order'], $i['id_product'], false)?>

								<?foreach ($art_arr as $art){?>

	                         		<option<?if($i['article_mopt']==$art['article']){?> selected="selected"<?}?> value="<?=$art['article']?>"><?=$art['article']?></option>

	                         	<?}?>

                         	</select>

                         	<?}else{?>

                         		<div style="margin-left: 20px;"><?=$i['article_mopt']?></div>

                         	<?}?>

						</td>

                         <td class="name_cell">
                             <a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/efiles/_thumb/nofoto.jpg'?>" onclick="return hs.expand(this)" class="highslide"><img alt="<?=$i['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/efiles/_thumb/nofoto.jpg'?>" title="Нажмите для увеличения"></a>

                             <a href="<?=_base_url?>/product/<?=$i['id_product']?>/"><?=$i['name']?></a>

                                <div>&nbsp;

                                </div>

                                <div style="padding: 0px">

                                <!--noindex-->Арт.<!--/noindex--><?=$i['art']?></div>

                         </td>

                         <td class="price_cell"><p id="pprice_mopt_<?=$i['id_product']?>"><?=round($i['site_price_mopt'],2)?></p></td>

                         <td class="count_cell"><p><?=$i['inbox_qty']?> шт.</p></td>

                         <td class="price_cell"><p><?=$i['mopt_qty']?> шт.</p></td>

                         <td class="price_cell"><p><?=round($i['mopt_sum'],2)?></p></td>

                         <?$t['mopt_sum']+=round($i['mopt_sum'],2);?>



						 <?$i['contragent_mqty'] = ($i['contragent_mqty']>=0)?$i['contragent_mqty']:$i['mopt_qty'];?>

                         <td class="count_cell"><div class="unit"><input <?if($i['id_order_status']==2){?>disabled="disabled"<?}?> name="contr_mqty[<?=$i['id_product']?>]" id="contr_mqty_<?=$i['id_product']?>" type="text" value="<?=$i['contragent_mqty']?>" onchange="ContrRecalcSum(this,<?=$i['id_product']?>, false)" class="input_table" /></div></td>

                         <?$t['contragent_mqty']+=$i['contragent_mqty'];?>



                         <?$i['contragent_msum'] = ($i['contragent_msum']!=0 || $i['contragent_mqty']>=0)?$i['contragent_msum']:round($i['site_price_mopt']*$i['mopt_qty'],2);?>

                         <td class="price_cell"><p id="pcontr_msum_<?=$i['id_product']?>"><?=$i['contragent_msum']?></p></td>

                         <?$t['contragent_msum']+=$i['contragent_msum'];?>



                         <?$i['fact_mqty'] = ($i['fact_mqty']>=0)?$i['fact_mqty']:0;?>

                         <td class="price_cell"><p><?=$i['fact_mqty']?></p></td>

                         <?$t['fact_mqty']+=$i['fact_mqty'];?>



                         <?$i['fact_msum'] = ($i['fact_msum']!=0)?$i['fact_msum']:0;?>

                         <td class="price_cell"><p><?=$i['fact_msum']?></p></td>

                         <?$t['fact_msum']+=$i['fact_msum'];?>







                    </tr>

                    <?}?>

<script>p_ids[ii++] = <?=$i['id_product']?>;</script>

                    <?}?>



                    <tr class="itogo">

                         <td colspan="5"><p>Итого с учетом скидок и наценок:</p></td>



                         <td class="count_cell"><p><?=$i['sum_discount']?></p></td>

                         <td class="price_cell"><p id="pcontragent_qty"><?=$t['contragent_qty']+$t['contragent_mqty']?></p></td>

                         <td class="price_cell"><p id="pcontragent_sum"><?=$t['contragent_sum']+$t['contragent_msum']?></p></td>

                         <td class="price_cell"><p><?=$t['fact_qty']+$t['fact_mqty']?></p></td>

                         <td class="price_cell"><p><?=$t['fact_sum']+$t['fact_msum']?></p></td>

                    </tr>



                    <?if ($i['id_pretense_status']!=0){?>

                    <?foreach ($pretarr as $p){?>

						<tr>

	                        <td class="code_cell" style="padding: 2px 1px 6px;"><div class="unit"><input type="text" disabled="disabled" value="<?=$p['article']?>" class="input_table" /></div></td>

	                        <td class="name_cell">

	                            <div class="unit4"><input type="text" value="<?=$p['name']?>" disabled="disabled" class="input_table" /></div>

	                        </td>

	                        <td class="price_cell"><div class="unit2"><input type="text" disabled="disabled" value="<?=$p['price']?>" class="input_table" /></div></td>

	                        <td colspan="5" class="count_cell">&nbsp;</td>

	                        <td class="count_cell"><div class="unit"><input type="text" disabled="disabled" value="<?=$p['qty']?>" class="input_table" /></div></td>

	                        <td class="price_cell">&nbsp;</td>

                    	</tr>

					<?}}?>

                </table>



                <script type="text/javascript">

                	function ContrRecalcSum(obj, id, opt){

						if (opt)

							$("#pcontr_sum_"+id).text((obj.value * $("#pprice_opt_"+id).text()).toFixed(2) );

						else{

							$("#pcontr_msum_"+id).text((obj.value * $("#pprice_mopt_"+id).text()).toFixed(2) );

						}

						contr_qty = 0;

						for(jj=0;jj<ii;jj++){

							if ($("#contr_qty_"+p_ids[jj]).length)

								contr_qty += parseFloat($("#contr_qty_"+p_ids[jj]).val());



							if ($("#contr_mqty_"+p_ids[jj]).length)

								contr_qty += parseFloat($("#contr_mqty_"+p_ids[jj]).val());

						}

						$("#pcontragent_qty").text(contr_qty);



						contr_sum = 0;

						for(jj=0;jj<ii;jj++){

							if ($("#contr_qty_"+p_ids[jj]).length)

								contr_sum += parseFloat($("#pcontr_sum_"+p_ids[jj]).text());

							if ($("#contr_mqty_"+p_ids[jj]).length)

								contr_sum += parseFloat($("#pcontr_msum_"+p_ids[jj]).text());

						}

						$("#pcontragent_sum").text(contr_sum.toFixed(2));

                	}

                </script>

                	<?if($i['id_order_status']==6){?>

                	<input type="submit" name="smb" class="exec_order" value="">

                	<?}?>



                	<?if($i['id_pretense_status']==1){?>

                		<input type="submit" name="smb_pretense" class="exec_pret" value="">

                	<?}?>

                </form>



<!--<?php if($i['id_order_status']==1): ?>

<form action="<?=$GLOBALS['URL_request']?>" method="post">

    <input type="submit" name="smb_run" class="run_order" value="На выполнение">

</form>

<?php endif ?>-->



<?php if($i['id_order_status']==1 || $i['id_order_status']==6): ?>

<form action="<?=$GLOBALS['URL_request']?>" method="post">

    <input type="submit" name="smb_cancel" class="cancel_order" value="">

</form>

<?php endif ?>



<br>

<a target="_blank" href="<?=_base_url?>/invoice_contragent/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная контрагента</a>

<?if ($i['id_pretense_status']!=0){?>

<br>

<a target="_blank" href="<?=_base_url?>/invoice_contragent_pret/<?=$order['id_order']?>/<?=$order['skey']?>">Претензия на накладную контрагента</a>

<br>

<a target="_blank" href="<?=_base_url?>/invoice_customer_pret/<?=$order['id_order']?>/<?=$order['skey']?>">Претензия на накладную покупателя</a>

<?}?>

<?if ($i['id_return_status']!=0){?>

<br>

<a target="_blank" href="<?=_base_url?>/invoice_contragent_ret/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная по возврату контрагента</a>

<br>

<a target="_blank" href="<?=_base_url?>/invoice_customer_ret/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная по возврату покупателя</a>

<?}?>

<br>

<a target="_blank" href="<?=_base_url?>/invoice_customer/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная покупателя</a>

<br>

<!--<a target="_blank" href="<?=$GLOBALS['URL_base']?>invoice_customer_fakt/<?=$order['id_order']?>/<?=$order['skey']?>">Накладная покупателя ФАКТ</a>-->

            </div><!--class="cabinet"-->