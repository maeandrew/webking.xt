<table name="order" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:95% !important; width:95% !important;">
    <tbody>
    	<tr>
        	<td valign="top" style="margin:0;padding:0; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;">
                    <tbody>
                    	<tr>
                        	<td valign="top" style="margin:0;padding:0; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
								Вы длительное время не посещали наш сайт. У Вас еще осталась незавершенная наполенная товарами корзина.
	                        </td>
	                    </tr>
                	</tbody>
                </table>
            </td>
        </tr>
        <tr>
        	<td valign="top" style="margin:0;padding:0; padding-bottom: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
        		<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;">
                    <tbody>
                    	<tr>
                    		<td align="center" colspan="2" style="margin-bottom: 18px; color:#202020; font-family:Helvetica; font-style:normal; font-weight: bold; line-height:125%;letter-spacing:normal;text-align: center;">
                    			<p>Список товаров в корзине</p>
                    		</td>
                    	</tr>
                    	<?foreach ($cart['prod_list'] as $item) {?>
		                    <tr>
								<td valign="middle" style="margin:0; border: 1px solid #e3e3e3; border-top: 2px solid #bbbbbb; padding: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: center;">
									<img src="<?=G::GetImageUrl($item['src'], 'medium')?>" style="display:block; width:100%; min-width: 55px; max-width: 100px;" >
								</td>
								<td colspan="3" valign="top" style="margin:0; border: 1px solid #e3e3e3; border-top: 2px solid #bbbbbb; padding: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: left;">
									<?=$item['title']?>
									<br>
									<p style="font-size: 12px; padding: 0px; margin-bottom: 0px; margin-top: 5px;">Арт.: <?=$item['art']?></p>
								</td>
							</tr>
						<?}?>
                	</tbody>
                </table>
            </td>
        </tr>
    	<tr>
        	<td valign="top" style="margin:0;padding:0; color:#202020; font-family:Helvetica; font-style:normal; line-height:125%;letter-spacing:normal;text-align: justify;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; max-width:100% !important; width:100% !important;">
                    <tbody>
                    	<tr>
                        	<td valign="top" style="margin:0;padding:0; padding-top: 9px; padding-bottom: 9px; color:#202020; font-family:Helvetica; font-style:normal; line-height:200%;letter-spacing:normal;text-align: justify;">
								Вы можете вернуться на наш сайт <a href="<?=_base_url?>">xt.ua</a>, авторизоваться и подолжить покупку.
	                        </td>
	                    </tr>
                	</tbody>
                </table>
            </td>
        </tr>
	</tbody>
</table>