<style>
.errmsg{
	color: #f00;
	font-size: 12px;
}
</style>
<div class="cabinet">
<?if (isset($errm) && isset($msg)){?><br><span class="errmsg">Ошибка! <?=$msg?></span><br><?}?>
<?=isset($errm['products'])?"<span class=\"errmsg\">".$errm['products']."</span>":null?>
<?if(isset($_SESSION['errm'])){
	foreach ($_SESSION['errm'] as $msg){if (!is_array($msg)){?>
		<span class="errmsg"><?=$msg?></span><br>
        <?}}}unset($_SESSION['errm'])?>
	<rh3>Заказ №<?=$order['id_order']?>   <span><?=date("d.m.Y",$order['target_date'])?></span> <span><?=$Customer['name']?></span> <span>Тел. <?=str_replace("\r\n", ", ", $Customer['phones'])?></span></rh3>
			<form action="<?=$GLOBALS['URL_request']?>" method="post" id="orderForm">
                <script>p_ids = new Array();ii=0;</script>
                <table border="0" cellpadding="0" cellspacing="0" class="returns_table" width="100%">
				<col width="64" />
                    <tr>
                        <th class="code_cell">Код</th>
                        <th class="name_cell">Название</th>
                        <th class="price_cell">Цена за 1 шт. грн.</th>
                        <th class="count_cell">Заказано <br>штук</th>
                        <th class="count_cell">Сумма <br>заказано</th>
                        <th class="price_cell">Кол-во <br>по контр-<br>агенту</th>
                        <th class="price_cell">Сумма <br>по контр-<br>агенту</th>
						<th class="price_cell">Цена<br>закупки</th>
						<th class="price_cell">Сумма <br>закупки</th>
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
                    	$t['price_mopt_otpusk']=0;
                    	$t['fact_msum']=0;
                    ?>
					<?$articles_arr = array();foreach($data as $i){?>
                    <?if(($i['opt_qty']!=0 && $show_pretense===false) || ($i['opt_qty']!=0 && $show_pretense===true && $i['contragent_qty']!=$i['fact_qty'])){// строка по опту?>
                    <?$articles_arr[] = $i['article'];?>
                    <tr>
                         <td class="code_cell" style="padding: 2px 1px 6px;"><p><?=$i['article']?></p></td>
                         <td class="name_cell">
                             <a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/images/nofoto.png'?>" onClick="return hs.expand(this)" class="highslide"><img alt="<?=$i['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/images/nofoto.png'?>" title="Нажмите для увеличения" /></a>
                             <?=$i['name']?>
                                <div>&nbsp
                                </div>
                                <div style="padding: 0px">
                                Арт.<?=$i['art']?></div>
                         </td>
                         <td class="price_cell"><p id="pprice_opt_<?=$i['id_product']?>"><?=round($i['site_price_opt'],2)?></p></td>
                         <td class="price_cell"><p><?=$i['opt_qty']?> шт.</p></td>
                         <td class="price_cell"><p><?=round($i['opt_sum'],2)?></p></td>
                         <?$t['opt_sum']+=round($i['opt_sum'],2);?>
						 <?$i['contragent_qty'] = ($i['contragent_qty']>=0)?$i['contragent_qty']:$i['opt_qty'];?>
                         <td class="count_cell"><p><?=$i['contragent_qty']?></p></td>
                         <?$t['contragent_qty']+=$i['contragent_qty'];?>
                         <?$i['contragent_sum'] = ($i['contragent_sum']!=0 || $i['contragent_qty']>=0)?$i['contragent_sum']:round($i['site_price_opt']*$i['opt_qty'],2);?>
                         <td class="price_cell"><p><?=$i['contragent_sum']?></p></td>
                         <?$t['contragent_sum']+=$i['contragent_sum'];?>
                         <?$i['fact_qty'] = ($i['fact_qty']>=0)?$i['fact_qty']:$i['contragent_qty'];?>
                         <td class="price_cell"><p id="pprice_opt_<?=$i['id_product']?>"><?=round($i['price_opt_otpusk'],2)?></p></td>
                         <?$t['price_opt_otpusk']+=$i['price_opt_otpusk'];?>
                         <td class="price_cell"><p id="pfact_sum_<?=$i['id_product']?>"><?=round($i['price_opt_otpusk']*$i['contragent_qty'],2)?></p></td>
                         <?$t['fact_sum']+=round($i['price_opt_otpusk']*$i['contragent_qty'],2);?>
                    </tr>
                    <?} if(($i['mopt_qty']!=0 && $show_pretense===false) || ($i['mopt_qty']!=0 && $show_pretense===true && $i['contragent_mqty']!=$i['fact_mqty'])){// строка по мелкому опту?>
                    <?$articles_arr[] = $i['article_mopt'];?>
                    <tr>
                         <td class="code_cell" style="padding: 2px 1px 6px;"><p><?=$i['article_mopt']?></p></td>
                         <td class="name_cell">
                             <a href="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars($i['img_1']):'/images/nofoto.png'?>" onClick="return hs.expand(this)" class="highslide"><img alt="<?=$i['name']?>" src="<?=file_exists($GLOBALS['PATH_root'].$i['img_1'])?_base_url.htmlspecialchars(str_replace("/efiles/", "/efiles/_thumb/", $i['img_1'])):'/images/nofoto.png'?>" title="Нажмите для увеличения" /></a>
                            <?=$i['name']?>
                                <div>&nbsp
                                </div>
                                <div style="padding: 0px">
                                Арт.<?=$i['art']?></div>
                         </td>
                         <td class="price_cell"><p id="pprice_mopt_<?=$i['id_product']?>"><?=round($i['site_price_mopt'],2)?></p></td>
                         <td class="price_cell"><p><?=$i['mopt_qty']?> шт.</p></td>
                         <td class="price_cell"><p><?=round($i['mopt_sum'],2)?></p></td>
                         <?$t['mopt_sum']+=round($i['mopt_sum'],2);?>
						 <?$i['contragent_mqty'] = ($i['contragent_mqty']>=0)?$i['contragent_mqty']:$i['mopt_qty'];?>
                         <td class="count_cell"><p><?=$i['contragent_mqty']?></p></td>
                         <?$t['contragent_mqty']+=$i['contragent_mqty'];?>
                         <?$i['contragent_msum'] = ($i['contragent_msum']!=0 || $i['contragent_mqty']>=0)?$i['contragent_msum']:round($i['site_price_mopt']*$i['mopt_qty'],2);?>
                         <td class="price_cell"><p><?=$i['contragent_msum']?></p></td>
                         <?$t['contragent_msum']+=$i['contragent_msum'];?>
                         <?$i['fact_mqty'] = ($i['fact_mqty']>=0)?$i['fact_mqty']:$i['contragent_mqty'];?>
                         <td class="price_cell"><p id="pprice_opt_<?=$i['id_product']?>"><?=round($i['price_mopt_otpusk'],2)?></p></td>
                         <?$t['price_mopt_otpusk']+=$i['price_mopt_otpusk'];?>
                         <td class="price_cell"><p id="pfact_msum_<?=$i['id_product']?>"><?=round($i['price_mopt_otpusk']*$i['contragent_mqty'],2)?></p></td>
                         <?$t['fact_msum']+=round($i['price_mopt_otpusk']*$i['contragent_mqty'],2);?>
                    </tr>
                    <?}?>
                    <script>p_ids[ii++] = <?=$i['id_product']?>;</script>
                    <?}?>
                    <tr class="itogo">
                         <td colspan="4"><p>Итого :</p></td>
                         <td class="count_cell"><p><?=$i['sum_discount']?></p></td>
                         <td class="price_cell"><p></p></td>
                         <td class="price_cell"><p><?=$t['contragent_sum']+$t['contragent_msum']?></p></td>
                         <td class="price_cell"><p id="pfact_qty"></p></td>
                         <td class="price_cell"><p id="pfact_sum"><?=$t['fact_sum']+$t['fact_msum']?></p></td>
                    </tr>
                </table>
            <!--class="cabinet"-->