

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



<?if (isset($errm) && isset($msg)){?><br><span class="errmsg">Ошибка! <?=$msg?></span><br><br><?}?>



<div class="cabinet">



                <rh3>История заказов</rh3>

                <div class="history">

                    <form method="post" name = "composed_invoice_diler" action="/composed_invoice_diler" id="composed_invoice_form" target="_blank">

                        <input type="submit" value="Отбразить маршрут"/>

                        <table border="0" cellpadding="0" cellspacing="0" class="returns_table" width="100%">



                            <tr>



                                <th><a href="<?=$sort_links['id_order']?>" class="up_down">Заказ №</a></th>

                                <th><a href="<?=$sort_links['status']?>" class="up_down">Статус</a></th>

                                <th>Сумма</th>

                                <th>Наценка</th>

                                <th width=310>Клиент</th>





                                <th width=350>Примечание</th>

                            </tr>

                           <?$z = 0?>

                          <?foreach ($orders as $i){?>

                            <tr>

 <td align="center" class="hotspot" style="display:none"><input type="checkbox" name='orders[]' value="<?=$i['id_order']?>"  id="chbox_<?php echo $z?>" class="table_switcher"/></td>

                                 <td id="<?php echo $z?>" class="table_row"><p><a href="<?=_base_url?>/m_diler_order/<?=$i['id_order']?>"/><?=$i['id_order']?></a></p></td>

                                 <td><p<?=($i['id_order_status']==2)?' class="status_done"':null?>><?=$order_statuses[$i['id_order_status']]['name']?></p></td>

                                 <td><p><?=round($i['sum_discount'],2)?></p></td>

                                 <td><p><?=round((1-$i['discount'])/0.95,4)?></p></td>





                                 <td >



<?=$i['name_klient']?></p><?=$i['email_klient']?>





                                  </td>





                                  <td> </form>









                          <form action="<?=$GLOBALS['URL_request']?>">

                          <textarea

                          onChange = "setOrderNote (<?=$i['id_order']?>)"

                          cols="20"

                          rows="3"

                          id="order_note_<?=$i['id_order']?>"

                          class="contragent_order_note"

                          ><?php if(isset($i['note'])) echo $i['note']?></textarea>

                          </form>

                          <form action="#">

                          <textarea

                          onChange = "setOrderNote_zamena (<?=$i['id_order']?>)"



                          id="order_note2_<?=$i['id_order']?>"

                          class="contragent_order_note_2"

                          ><?php if(isset($i['note2'])) echo $i['note2']?></textarea>



                          </form>











                          </td>

 <?$z++?>

                          <?}?>



                        </table>



                        <p style="margin:100px">  </p>









                </div><!--class="history"-->

            </div><!--class="cabinet"-->