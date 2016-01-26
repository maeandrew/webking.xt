<? require "cp_customer_cab_leftside.tpl";?>
<div class="customer_cab">
    <div class="msg-info">
        <p>Заказы отгружаются в статусе "Выполняется". Этот статус заказ получает после подтверждения полной или
            частичной предоплаты по заказу (условия в разделе "Оплата и доставка").</p>
    </div>
    <div id="orders_history">

        <?!isset($_GET['t'])?$_GET['t']='all':null;?>
        <div class="<?switch ($_GET['t']){
			case 'working':
				$s[] = 10;
				$s[] = 20;
				?>working<?
			break;
			case 'completed':
				$s[] = 11;
				$s[] = 21;
				?>completed<?
			break;
			case 'canceled':
				$s[] = 4;
				$s[] = 5;
				?>canceled<?
			break;
			case 'drafts':
				$s[] = 3;
				?>drafts<?
			break;
			default:
				$s = array();
			break;
		}?> editing">
            <?if($orders){ ?>
            <ul class="orders_list">
                <?foreach ($infoCarts as $i){
						if(in_array($i['status'], $s) || (isset($_GET['t']) && $_GET['t'] == 'all') || !isset($_GET['t'])){ ?>
                    <li>
                        <section class="order mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
                            <div class="title">
                                <div class="container">
                                    <span class="number">Совместная корзина № <?=$i['id_cart']?></span>
                                    <div class="print">
                                        <div class="icon"><img src="<?=_base_url?>/themes/default/img/print1.png"></div>
                                        <ul class="expanded">
                                            <!-- <img src="<?=_base_url?>/themes/default/img/ic_paper_XLS_black_24px.svg">
                                            <li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_txt_black_24px.svg"></a></li>
                                            <li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_img_black_24px.svg"></a></li>
                                            <li><a href="#"><img src="<?=_base_url?>/themes/default/img/ic_paper_black_24px.svg"></a></li> -->
                                            <li>
                                                <a href="#">
                                                    <svg class="icon" id="tt1">
                                                        <use xlink:href="#XLS"></use>
                                                    </svg>
                                                </a>
                                                <div class="mdl-tooltip" for="tt1">Распечатать в XML</div>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <svg class="icon" id="tt2">
                                                        <use xlink:href="#txt"></use>
                                                    </svg>
                                                </a>
                                                <div class="mdl-tooltip" for="tt2">Распечатать для реализатора</div>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <svg class="icon" id="tt3">
                                                        <use xlink:href="#img"></use>
                                                    </svg>
                                                </a>
                                                <div class="mdl-tooltip" for="tt3">Распечатать с картинками</div>
                                            </li>

                                            <li><a href="#">
                                                    <svg class="icon" id="tt4">
                                                        <use xlink:href="#paper"></use>
                                                    </svg>
                                                </a>
                                                <div class="mdl-tooltip" for="tt4">Распечатать документом</div>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="status">Выполнен</div>
                                </div>
                                <div class="tabs mdl-tabs__tab-bar">
                                    <a href="#starks-panel-<?=$i['id_cart']?>" class="mdl-tabs__tab is-active">Детали</a>
                                    <a href="#lannisters-panel-<?=$i['id_cart']?>" class="mdl-tabs__tab">Участники</a>
                                    <a href="#targaryens-panel-<?=$i['id_cart']?>" class="mdl-tabs__tab"
                                       onClick=" GetProdListForCart(<?=$i['id_cart']?>);">Список товаров</a>
                                </div>
                            </div>
                            <div class="content">
                                <div class="mdl-tabs__panel is-active" id="starks-panel-<?=$i['id_cart']?>">
                                    <div class="info">
                                        <div class="date">
                                                    <span class="icon">
                                                        <!-- <img src="<?=_base_url?>/themes/default/img/ic_date_range_black_24px.svg"> -->

                                                        <svg class="icon">
                                                            <use xlink:href="#date"></use>
                                                        </svg>

                                                    </span>
                                            <span class="label">Дата заказа</span>
                                            <span class="value"><?=date("d.m.Y", strtotime($i['creation_date']))?></span>
                                        </div>
                                        <div class="count">
                                                    <span class="icon">
                                                        <!--<img src="<?=_base_url?>/themes/default/img/ic_local_shipping_black_24px.svg"> -->
                                                        <svg class="icon">
                                                            <use xlink:href="#shipping"></use>
                                                        </svg>
                                                    </span>
                                            <span class="label">Товаров</span>
                                            <span class="value"><?=count($prodsCarts)?> шт.</span>
                                        </div>
                                        <div class="sum">
                                                    <span class="icon">
                                                        <!-- <img src="<?=_base_url?>/themes/default/img/ic_attach_money_black_24px.svg"> -->
                                                        <svg class="icon">
                                                            <use xlink:href="#money"></use>
                                                        </svg>
                                                    </span>
                                            <span class="label">Сумма к оплате</span>
                                            <span class="value"><?=$details['sum_prods']?> грн.</span>
                                        </div>
                                        <div class="discount">
                                                    <span class="icon">
                                                        <!-- <img src="<?=_base_url?>/themes/default/img/ic_shuffle_black_24px.svg"> -->
                                                        <svg class="icon">
                                                            <use xlink:href="#shuffle"></use>
                                                        </svg>
                                                    </span>
                                            <span class="label">Скидка</span>
                                            <span class="value"><?=$details['discount']?>%</span>
                                        </div>
                                    </div>
                                    <div class="additional">
                                        <div class="manager">
                                            <div class="label">Ваш менеджер</div>
                                            <div class="avatar">
                                                <img src="http://lorempixel.com/fashion/70/70/" alt="avatar"/>
                                            </div>
                                            <div class="details">
                                                <div class="line_1"><? print_r($_SESSION['member']['contragent']['name_c'])?></div>
                                                <div class="line_2"><? print_r($_SESSION['member']['contragent']['phones'])?></div>
                                                <div class="line_3">
                                                    <a href="#">
                                                        <svg class="icon">
                                                            <use xlink:href="#like"></use>
                                                        </svg>
                                                    </a>
                                                    <a href="#">
                                                        <svg class="icon">
                                                            <use xlink:href="#dislike"></use>
                                                        </svg>
                                                    </a>
                                                    <span class="votes_cnt">15686</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="delivery">
                                            <div class="label">Способ доставки</div>
                                            <!--<div class="avatar">
                                                <img src="http://lorempixel.com/abstract/70/70/" alt="avatar"/>
                                            </div>-->
                                            <div class="details">
                                                <div class="line_1">
                                                    <span class="label">ТТН:</span>
                                                    <span class="value"> - </span>
                                                </div>
                                                <div class="line_2">
                                                    <span class="label">Город:</span>
                                                    <span class="value"><?//=$i['city_info']['name']?></span>
                                                </div>
                                                <div class="line_3">
                                                    <span class="label">Отделение:</span>
                                                    <span class="value"><?//=$i['city_info']['address']?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mdl-tabs__panel" id="lannisters-panel-<?=$i['id_cart']?>">
                                    <table class="mdl-data-table mdl-js-data-table  mdl-shadow--2dp" id="list_coop">
                                        <thead>
                                        <tr>
                                            <th class="mdl-data-table__cell--non-numeric">
                                            </th>
                                            <th class="mdl-data-table__cell--non-numeric">Статус</th>
                                            <th>Сумма</th>
                                            <th></th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        <?if (isset($infoCarts) && is_array($infoCarts)) : foreach($infoCarts as $infoCart) :?>
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <div class="avatar img"><img src="http://lorempixel.com/fashion/70/70/" alt="avatar"/></div>
                                            </td>
                                            <td class="mdl-data-table__cell--non-numeric stat_user_cab"><?=$infoCart['title_status']?></td>
                                            <td><?=$infoCart['sum_cart']?></td>
                                            <td class="del_x"><i class="material-icons">close</i></td>
                                        </tr>
                                        <?endforeach; endif;?>
                                        <?//print_r($i)?>
                                        </tbody>
                                    </table>
                                    <!--<div class="additional info">
                                        <div class="manager">
                                            <div class="label">Ваш менеджер</div>
                                            <div class="avatar"><img src="http://lorempixel.com/fashion/70/70/" alt="avatar" /></div>
                                            <div class="details">
                                                <div class="line_1"><?=$i['contragent']?> / Гвоздик Алёна</div>
                                                <div class="line_2"><?=$i['contragent_info']['phones']?></div>
                                                <div class="line_3">like dislike <span class="votes_cnt">15686</span></div>
                                            </div>
                                        </div>

                                    </div>-->
                                    <?//print_r($prodsCarts)?>
                                    <div id="block_promo">
                                        <div class="label">Промо-кода для совместной корзины: 5577321</div>
                                        <div class="label">Вы можете передать его любым удобным для Вас способом:</div>
                                        <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
                                            <thead>
                                            <tr>
                                                <th class="mdl-data-table__cell--non-numeric">Пригласить участника
                                                    <label class="mdl-button mdl-js-button mdl-button--primary">Отправить</label>
                                                </th>
                                            </tr>
                                            </thead>
                                            <form action="#">
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                            <input class="mdl-textfield__input" type="text" id="sample1">
                                                            <label class="mdl-textfield__label" for="sample1">Отправить на
                                                                Email</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                            <input class="mdl-textfield__input" type="text" id="sample2">
                                                            <label class="mdl-textfield__label" for="sample2">Отправить SMS
                                                                на номер</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </form>
                                        </table>
                                    </div>
                                </div>

                                <div class="mdl-tabs__panel" id="targaryens-panel-<?=$i['id_cart']?>">
                                    <?//if($orders): ?>
                                        <ul class="sorders_list">
                                            <?//foreach ($infoCarts as $i){ if(in_array($i['status'], $s) || (isset($_GET['t']) && $_GET['t'] == 'all') || !isset($_GET['t'])){ ?>
                                            <?foreach ($infoCarts as $i){ ?>
                                            <li>
                                                <section class="order mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
                                                    <div class="title">
                                                        <div class="container">
                                                            <a href="#" class="mdl-tabs__tab"
                                                               onClick="GetCabCoopProdAjax(<?=$i['id_cart']?>);"><span class="username"><?=$i['name']?></span></a>
                                                        </div>
                                                    </div>
                                                    <div id="products_cart"></div>
                                                </section>
                                            </li>
                                            <?}?>
                                        </ul>
                                    <?//endif?>


                                    <div id="products"></div>
                                    <div class="over_sum">Итого: <?=$details['sum_prods']?> грн.</div>
                                </div>
                            </div>
                        </section>
                    </li>
                <?}?>
                <?}?>
            </ul>
            <?}else{ ?>
            <p class="no_orders">У Вас нету ни одного заказа</p>
            <?}?>
        </div>
    </div><!--class="history"-->
</div><!--class="cabinet"-->

<div id="graph" data-type="modal">
    <div class="modal">
        <div class="modal_container">
            <h1 >Start</h1>
        </div>
    </div>
</div>