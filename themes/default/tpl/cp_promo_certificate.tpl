<?for($i = 0; $i < (isset($_REQUEST['share'])?1:3); $i++){?>
	<div class="flyer">
		<div class="gift_prod">
			<div class="gift_prod_descr">
				<p class="flyer_title">Подарочный сертификат</p>
				<?if(isset($gift)){?>
					<div class="gift_prod_image">
						<?if(!empty($gift['images'])){?>
							<img itemprop="image" src="<?=G::GetImageUrl($gift['images'][0]['src'], 'medium')?>"/>
						<?}else if(!empty($gift['img_1'])){?>
							<img itemprop="image" src="<?=G::GetImageUrl($gift['img_1'], 'medium')?>"/>
						<?}else{?>
							<img itemprop="image" src="<?=G::GetImageUrl('/images/nofoto.png')?>"/>
						<?}?>
					</div>
					<div class="gift_prod_name">
						<?=$gift['name']?>Радиоприёмник аналоговый KIPO KB-308АС (19,8х11х5,9 см, Китай)
					</div>
					<div class="gift_prod_art">
						Артикул: <span><?=$gift['art']?></span>
					</div>
				<?}else{?>
					<img class="all_products_img" src="/images/assort.jpg">
				<?}?>
				<p class="gift_title"><span class="green">Получай подарок</span><sup class="star">*</sup> при заказе на <span class="green">XT.UA</span></p>
			</div>
			<div class="explanation">
				* Под подарком подразумевается покупка товара за 0,01 грн. Для получения подарка необходимо применить промо-код в корзине сайта при оформлении заказа. Подарок доступен только при первом заказе.
			</div>
		</div>
		<div class="flyer_content">
			<div class="flyer_header">
				<img class="logo" src="/themes/default/img/_xt.svg">
				<p class="company_title">Служба снабжения ХарьковТорг</p>
				<p class="site">xt.ua</p>
			</div>
			<div class="promo_info">
				<div class="personal_consultant_block">
					<p class="personal_consultant_title">Ваш консультант:</p>
					<p class="personal_consultant_name"><?=$customer['first_name']?></p>
					<p class="personal_consultant_phone">+<?=$user['phone']?></p>
				</div>
				<div class="promocode_block">
					<p class="promocode_title">промо-код:</p>
					<p class="promocode">AG<?=$user['id_user']?></p>
				</div>
			</div>
		</div>
		<div class="cut_line"></div>
	</div>
<?}?>
