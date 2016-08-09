<style>
.errmsg{
	color: #f00;
	font-size: 12px;
}
</style>

<?if (isset($errm) && isset($msg)){?><br><span class="errmsg">Ошибка! <?=$msg?></span><br><br><?}?>

<div class="cabinet">
                <a href="<?=_base_url?>/cabinet/info/" class="edit_personal">Редактировать скидку</a>
                <h2>История заказов</h2>
	<div class="supplier_search">
		<form method="post" target="_blank" action="/supplier_search">
			<input type="text" name="art_product" placeholder="Проверка наличия товара"/>
			<input type="submit" class="confirm" value="Искать" />
		</form>
	</div>
	<div class="clear"></div>
                <div class="history">
                        <table border="0" cellpadding="0" cellspacing="0" class="returns_table" width="100%">
                            <tr>
                                <th><a href="<?=$sort_links['date']?>" class="up_down">Дата</a></th>
                                <th><a href="<?=$sort_links['id_order']?>" class="up_down">Заказ №</a></th>
                                <th><a href="<?=$sort_links['status']?>" class="up_down">Статус</a></th>
                                <th>Сумма</th>
                                <th>Менеджер</th>
                                <th width="310">Клиент</th>
                                <th width="350">Примечание</th>
                            </tr>

						<?foreach ($orders as $i){?>
                            <tr>
                                 <td><a target="_blank" href="<?=_base_url?>/invoice_customer_foto/<?=$i['id_order']?>/<?=$i['skey']?>"><p><?=date("d.m.Y",$i['creation_date'])?></p></td>
                                 <td><p><a href="<?=_base_url?>/customer_order/<?=$i['id_order']?>"/><?=$i['id_order']?></a></p></td>
                                 <td><a target="_blank" href="<?=_base_url?>/invoice_customer_no_foto/<?=$i['id_order']?>/<?=$i['skey']?>"><p<?=($i['id_order_status']==2)?' class="status_done"':null?>><?=$order_statuses[$i['id_order_status']]['name']?></p></td>
                                 <td><p><?=round($i['sum_discount'],2)?></p></td>
                                 <td><p>

                                 <?php if(!empty($i['contragent_site'])):?>
                                 <a href="<?=$i['contragent_site']?>"><?=$i['contragent']?></a>
                                 <?php else:?>
                                 <?=$i['contragent']?>
                                 <?php endif?>

                                 </p></td>


								<td class="klient">
									<form action="<?=$GLOBALS['URL_request']?>" method="post">
										<div class="content">
											<input name="id_order" type="text" value="<?=$i['id_order']?>" style="display: none;"/>
											<input id="order_klient_<?=$i['id_order']?>" class="diler_order_note" name="id_klient" value="<?php if(isset($i['id_klient'])) echo $i['id_klient']?>"/>
											<input type="submit" class="confirm" value="Отправить" />
										</div>
										<p><?=$i['name_klient']?></p>
									</form>
								</td>
								<td class="notes">
									<form action="<?=$GLOBALS['URL_request']?>">
										<textarea onChange = "setOrderNote (<?=$i['id_order']?>)" rows="3" id="order_note_<?=$i['id_order']?>" class="contragent_order_note"><?php if(isset($i['note'])) echo $i['note']?></textarea>
									</form>
									<form action="<?=$_SERVER['REQUEST_URI']?>">
										<textarea onChange = "setOrderNote_zamena (<?=$i['id_order']?>)" id="order_note2_<?=$i['id_order']?>" class="contragent_order_note_2"><?php if(isset($i['note2'])) echo $i['note2']?></textarea>
									</form>
								</td>
						<?}?>
                        </table>

                        <p style="margin:100px"></p>




                </div><!--class="history"-->
            </div><!--class="cabinet"-->