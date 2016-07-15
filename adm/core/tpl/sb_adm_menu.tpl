<?if(G::IsLogged()){?>
	<div class="block paper_shadow_1">
		<h2>Меню</h2>
		<ul class="sb_menu">
			<?if(_acl::isAllow('pages')){?>
				<li <?=$GLOBALS['CurrentController'] == 'coment'?'class="sel"':null;?>>
					<a href="/adm/coment/" <?=$commentCount>0?'class="color-red"':null;?>>Вопросы по товару (<?=$commentCount;?>)</a>
				</li>
				<li <?=$GLOBALS['CurrentController'] == 'wishes'?'class="sel"':null;?>>
					<a href="/adm/wishes/" <?=$wishesCount>0?'class="color-red"':null;?>>Пожелания и предложения (<?=$wishesCount;?>)</a>
				</li>
			<?}?>
			<?if(_acl::isAllow('catalog')){?>
				<!-- <li <?=$GLOBALS['CurrentController'] == 'duplicates'?'class="sel"':null;?>>
					<a href="/adm/duplicates/">Дубли товаров (<?=$duplicateCount;?>)</a>
				</li> -->
			<?}?>
			<?if(_acl::isAllow('product_moderation')){?>
				<li <?=$GLOBALS['CurrentController'] == 'product_moderation'?'class="sel"':null;?>>
					<a href="/adm/product_moderation/" <?=$moderationCount>0?'class="color-red"':null;?>>Товары на модерации (<?=$moderationCount;?>)</a>
				</li>
			<?}?>
			<?if(_acl::isAllow('product_moderation')){?>
				<li <?=$GLOBALS['CurrentController'] == 'product_moderation'?'class="sel"':null;?>>
					<a href="/adm/graphics/" <?=$moderationCount>0?'class="color-red"':null;?>>Графики на модерации (<?=$moderationCount;?>)</a>
				</li>
			<?}?>
			<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?><li <?=$GLOBALS['CurrentController'] == 'photo_productadd'?'class="sel"':null;?>>
				<a href="/adm/photo_products/">Товары фотографа</a>
			</li><?}?>
			<?if(_acl::isAllow('catalog')){?>
				<li <?=$GLOBALS['CurrentController'] == 'cat'?'class="sel"':null;?>>
					<?=($_SESSION['member']['gid'] == _ACL_REMOTE_CONTENT_)?'Каталог':'<a href="/adm/cat/">Каталог</a>'?>
				</li>
				<li>
					<ul class="sb_menusub">
						<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?><li <?=$GLOBALS['CurrentController'] == 'catadd'?'class="sel"':null;?>>
							<a href="/adm/catadd/">Добавить категорию</a>
						</li><?}?>
						<li <?=$GLOBALS['CurrentController'] == 'productadd'?'class="sel"':null;?>>
							<a href="/adm/productadd/">Добавить товар</a>
						</li>
						<?if($_SESSION['member']['gid'] != _ACL_REMOTE_CONTENT_){?><li <?=$GLOBALS['CurrentController'] == 'unload_products'?'class="sel"':null;?>>
							<a href="/adm/unload_products/">Выгрузка товаров</a>
						</li><?}?>
					</ul>
				</li>
			<?}?>

			<?if (_acl::isAllow('specifications')){?>
				<li <?=$GLOBALS['CurrentController'] == 'specifications'?'class="sel"':null;?>>
					<a href="/adm/specifications/">Характеристики</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'specificationadd'?'class="sel"':null;?>>
							<a href="/adm/specificationadd/">Добавить характеристику</a>
						</li>
					</ul>
				</li>
			<?}?>

			<?if(_acl::isAllow('units')){?>
				<li <?=$GLOBALS['CurrentController'] == 'units'?'class="sel"':null;?>>
					<a href="/adm/units/">Единицы измерения</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'unitadd'?'class="sel"':null;?>>
							<a href="/adm/unitadd/">Добавить единицу измерения</a>
						</li>
					</ul>
				</li>
			<?}?>

			<?if (_acl::isAllow('segmentations')){?>
				<li <?=$GLOBALS['CurrentController'] == 'segmentations'?'class="sel"':null;?>>
					<a href="/adm/segmentations/">Сегментации</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'segmentationadd'?'class="sel"':null;?>>
							<a href="/adm/segmentationadd/">Добавить сегментацию</a>
						</li>
					</ul>
				</li>
			<?}?>

			<?if(_acl::isAllow('orders')){?>
				<li <?=$GLOBALS['CurrentController'] == 'orders'?'class="sel"':null;?>>
					<a href="/adm/orders/">Заказы</a>
				</li>
				<li <?=$GLOBALS['CurrentController'] == 'orders_sup'?'class="sel"':null;?>>
					<a href="/adm/orders_sup/" class="color-sgrey">Заказы по поставщикам</a>
				</li>
				<li <?=$GLOBALS['CurrentController'] == 'stat'?'class="sel"':null;?>>
					<a href="/adm/stat/" class="color-sgrey">Статистика продаж</a>
				</li>
			<?}?>
			<?if(_acl::isAllow('supplier_prov')){?>
				<li <?=$GLOBALS['CurrentController'] == 'supplier_prov'?'class="sel"':null;?>>
					<a href="/adm/supplier_prov/">Позиции поставщиков</a>
				</li>
			<?}?>

			<?if(_acl::isAllow('pricelist')){?>
				<li <?=$GLOBALS['CurrentController'] == 'pricelist'?'class="sel"':null;?>>
					<a href="/adm/pricelist/">Прайс-листы</a>
				</li>
			<?}?>


			<?if(_acl::isAllow('locations')){?>
				<!-- <li <?=$GLOBALS['CurrentController'] == 'citys'?'class="sel"':null;?>>
					<a href="/adm/citys/">Города</a>
				</li>
				<ul class="sb_menusub">
					<li <?=$GLOBALS['CurrentController'] == 'cityadd'?'class="sel"':null;?>>
						<a href="/adm/cityadd/">Добавить город</a>
					</li>
				</ul>
				<li <?=$GLOBALS['CurrentController'] == 'regions'?'class="sel"':null;?>>
					<a href="/adm/regions/">Регионы</a>
				</li>
				<ul class="sb_menusub">
					<li <?=$GLOBALS['CurrentController'] == 'regionadd'?'class="sel"':null;?>>
						<a href="/adm/regionadd/">Добавить регион</a>
					</li>
				</ul>
				<li <?=$GLOBALS['CurrentController'] == 'parkings'?'class="sel"':null;?>>
					<a href="/adm/parkings/">Стоянки</a>
				</li>
				<ul class="sb_menusub">
					<li <?=$GLOBALS['CurrentController'] == 'parkingadd'?'class="sel"':null;?>>
						<a href="/adm/parkingadd/">Добавить стоянку</a>
					</li>
				</ul>
				<li <?=$GLOBALS['CurrentController'] == 'delivservs'?'class="sel"':null;?>>
					<a href="/adm/delivservs/">Службы доставки</a>
				</li>
				 <ul class="sb_menusub">
					<li <?=$GLOBALS['CurrentController'] == 'delivservadd'?'class="sel"':null;?>>
						<a href="/adm/delivservadd/">Добавить службу доставки</a>
					</li>
				</ul>
				<li <?=$GLOBALS['CurrentController'] == 'deliverys'?'class="sel"':null;?>>
					<a href="/adm/deliverys/">Виды доставки</a>
					<a href="/adm/deliveryadd/" class="add <?=$GLOBALS['CurrentController'] == 'deliveryadd'?'sel':null;?>" title="Добавить вид доставки">Добавить вид доставки</a>
				</li>
				<ul class="sb_menusub">
					<li <?=$GLOBALS['CurrentController'] == 'deliveryadd'?'class="sel"':null;?>>
						<a href="/adm/deliveryadd/">Добавить вид доставки</a>
					</li>
				</ul>-->

			<?}?>

			<?if(_acl::isAllow('manufacturers')){?>
				<!-- <li <?=$GLOBALS['CurrentController'] == 'manufacturers'?'class="sel"':null;?>>
					<a href="/adm/manufacturers/">Производители</a>
					<a href="/adm/manufactureradd/" class="add <?=$GLOBALS['CurrentController'] == 'manufactureradd'?'sel':null;?>" title="Добавить производителя">Добавить производителя</a>
				</li>

				<ul class="sb_menusub">
					<li <?=$GLOBALS['CurrentController'] == 'manufactureradd'?'class="sel"':null;?>>
						<a href="/adm/manufactureradd/">Добавить производителя</a>
					</li>
				</ul> -->
			<?}?>

			<?if(_acl::isAllow('users')){?>
				<li <?=$GLOBALS['CurrentController'] == 'users'?'class="sel"':null;?>>
					<a href="/adm/users/">Пользователи</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li>
							<a href="/adm/users/<?=_ACL_ADMIN_?>">Администраторы</a>
							<a href="/adm/adminadd/" class="add <?=$GLOBALS['CurrentController'] == 'adminadd'?'sel':null;?>" title="Добавить администратора">Добавить администратора</a>
						</li>
						<li>
							<a href="/adm/users/<?=_ACL_MODERATOR_?>">Администраторы наполнения</a>
						</li>
						<li>
							<a href="/adm/users/<?=_ACL_SEO_?>">СЕО-оптимизаторы</a>
						</li>
						<li>
							<a href="/adm/users/<?=_ACL_CUSTOMER_?>">Покупатели</a>
							<a href="/adm/customeradd/" class="add <?=$GLOBALS['CurrentController'] == 'customeradd'?'sel':null;?>" title="Добавить покупателя">Добавить покупателя</a>
						</li>
						<li>
							<a href="/adm/users/<?=_ACL_CONTRAGENT_?>">Контрагенты</a>
							<a href="/adm/contragentadd/" class="add <?=$GLOBALS['CurrentController'] == 'contragentadd'?'sel':null;?>" title="Добавить контрагента">Добавить контрагента</a>
						</li>
						<li>
							<a href="/adm/users/<?=_ACL_SUPPLIER_?>">Поставщики</a>
							<a href="/adm/supplieradd/" class="add <?=$GLOBALS['CurrentController'] == 'supplieradd'?'sel':null;?>" title="Добавить поставщика">Добавить поставщика</a>
						</li>
						<li>
							<a href="/adm/warehouses/">Поставщики склада</a>
							<a href="/adm/warehouseadd/" class="add <?=$GLOBALS['CurrentController'] == 'warehouseadd'?'sel':null;?>" title="Добавить  поставщика склада">Добавить  поставщика склада</a>
						</li>
					</ul>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'usersadd'?'class="sel"':null;?>>
							<a href="/adm/usersadd/">Добавить нового пользователя</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'adminadd'?'class="sel"':null;?>>
							<a href="/adm/adminadd/">Добавить администратора</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'seoadd'?'class="sel"':null;?>>
							<a href="/adm/SEO_optimizatoradd/">Добавить СЕО-оптимизатора</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'customeradd'?'class="sel"':null;?>>
							<a href="/adm/customeradd/">Добавить покупателя</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'contragentadd'?'class="sel"':null;?>>
							<a href="/adm/contragentadd/">Добавить контрагента</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'supplieradd'?'class="sel"':null;?>>
							<a href="/adm/supplieradd/">Добавить поставщика</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'warehouseadd'?'class="sel"':null;?>>
							<a href="/adm/warehouseadd/">Добавить поставщика склада</a>
						</li>
					</ul>
				</li>
			<?}?>
			<?if(_acl::isAllow('profiles')){?>
				<li>
					<a href="/adm/profiles/" <?=$GLOBALS['CurrentController'] == 'profiles'?'sel':null;?>>Профили пользователей</a>
				</li>
			<?}?>
			<?if(_acl::isAllow('pages')){?>
				<li>
					<a href="/adm/users/<?=_ACL_SUPPLIER_?>" <?=$GLOBALS['CurrentController'] == 'users'?'sel':null;?>>Поставщики</a>
					<a href="/adm/supplieradd/" class="add <?=$GLOBALS['CurrentController'] == 'supplieradd'?'sel':null;?>" title="Добавить поставщика">Добавить поставщика</a>
				</li>
			<?}?>

			<?if(_acl::isAllow('remitters')){?>
				<li <?=$GLOBALS['CurrentController'] == 'remitters'?'class="sel"':null;?>>
					<a href="/adm/remitters/">Отправители</a>
				</li>
				<?if(isset($_SESSION['member']) && ($_SESSION['member']['gid'] != _ACL_SEO_)){?>
					<li>
						<ul class="sb_menusub">
							<li <?=$GLOBALS['CurrentController'] == 'remitteradd'?'class="sel"':null;?>>
								<a href="/adm/remitteradd/">Добавить отправителя</a>
							</li>
						</ul>
					</li>
				<?}?>
			<?}?>
			
			<?if(_acl::isAllow('monitoring')){?>
				<li <?=$GLOBALS['CurrentController'] == 'monitoring' && !isset($GLOBALS['REQAR'][1])?'class="sel"':null;?>>
					<a href="/adm/monitoring/">Мониторинг</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'monitoring' && $GLOBALS['REQAR'][1] == 'specifications'?'class="sel"':null;?>>
							<a href="/adm/monitoring/specifications/">Характеристики</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'uncategorised_products' && $GLOBALS['REQAR'][1] == 'uncategorised_products'?'class="sel"':null;?>>
							<a href="/adm/monitoring/uncategorised_products/">Товары без категорий</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'monitoring' && $GLOBALS['REQAR'][1] == 'ip_connections'?'class="sel"':null;?>>
							<a href="/adm/monitoring/ip_connections/">IP соединения</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'monitoring' && $GLOBALS['REQAR'][1] == 'err_feedback'?'class="sel"':null;?>>
							<a href="/adm/monitoring/err_feedback/">Ошибки от пользователей</a>
						</li>
					</ul>
				</li>
			<?}?>

			<?if(_acl::isAllow('news')){?>
				<li <?=$GLOBALS['CurrentController'] == 'news'?'class="sel"':null;?>>
					<a href="/adm/news/">Новости</a>
					<a href="/adm/newsadd/" class="add <?=$GLOBALS['CurrentController'] == 'newsadd'?'sel':null;?>" title="Добавить новость">Добавить новость</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'newsadd'?'class="sel"':null;?>>
							<a href="/adm/newsadd/">Добавить новость</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'slides'?'class="sel"':null;?>>
							<a href="/adm/slides/">Слайдер</a>
						</li>
					</ul>
				</li>
			<?}?>

			<?if(_acl::isAllow('seotext')){?>
				<li <?=$GLOBALS['CurrentController'] == 'seotext'?'class="sel"':null;?>>
					<a href="/adm/seotext/">SEO-тексты</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'seotextsadd'?'class="sel"':null;?>>
							<a href="/adm/seotextadd/">Добавить SEO-текст</a>
						</li>
					</ul>
				</li>
			<?}?>

			<?if(_acl::isAllow('posts')){?>
				<li <?=$GLOBALS['CurrentController'] == 'posts'?'class="sel"':null;?>>
					<a href="/adm/posts/">Статьи</a>
					<a href="/adm/postadd/" class="add <?=$GLOBALS['CurrentController'] == 'postadd'?'sel':null;?>" title="Добавить статью">Добавить статью</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'postadd'?'class="sel"':null;?>>
							<a href="/adm/postadd/">Добавить статью</a>
						</li>
					</ul>
				</li>
			<?}?>

			<?if(_acl::isAllow('pages')){?>
				<li <?=$GLOBALS['CurrentController'] == 'pages'?'class="sel"':null;?>>
					<a href="/adm/pages/">Страницы</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'configedit'?'class="sel"':null;?>>
							<a href="/adm/configedit/0">Инструкция для поставщика</a>
						</li>
						<li <?=$GLOBALS['CurrentController'] == 'pageadd'?'class="sel"':null;?>>
							<a href="/adm/pageadd/">Добавить страницу</a>
						</li>
					</ul>
				</li>
			<?}?>

			<?if (_acl::isAllow('configs')){?>
				<li <?=$GLOBALS['CurrentController'] == 'configs'?'class="sel"':null;?>>
					<a href="/adm/configs/">Настройки</a>
				</li>
				<li>
					<ul class="sb_menusub">
						<li <?=$GLOBALS['CurrentController'] == 'configadd'?'class="sel"':null;?>>
							<a href="/adm/configadd/">Добавить настройку</a>
						</li>
					</ul>
				</li>
			<?}?>
		</ul>
		<div class="clear"></div>
	</div>
<?}?>
