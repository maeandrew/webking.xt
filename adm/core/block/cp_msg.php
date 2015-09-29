<?php

 	$msg = 'Такой страницы не предусмотрено.';

 	$ra = $GLOBALS['REQAR'];
 	if (isset($ra[1]) && is_numeric($ra[1])){
        $mid = $ra[1];

        switch ($mid){

			case '1':
					$msg = 'Запрошенная Вами страница доступна только для зарегистрированных пользователей.';
				break;

			case '2':
					$msg = 'У Вас недостаточно прав для выполнения запрошенного действия либо запись отсутствует.';
				break;

			case '4':
					$msg = 'Такой страницы не существует.';
				break;

			case '5':
					$msg = 'Ошибка. Нет данных.';
				break;

			case '10':
					$msg = 'Ошибка. Не верный формат данных.';
				break;

			case '51':
					$msg = 'Итем удален.';
				break;

			case '52':
					$msg = 'Отзыв удален.';
				break;

			case '53':
					$msg = 'Структура итема используется, поэтому не может быть удалена.';
				break;

			case '54':
					$msg = 'Структура итема удалена.';
				break;

			case '55':
					$msg = 'Структура отзыва используется, поэтому не может быть удалена.';
				break;

			case '56':
					$msg = 'Структура отзыва удалена.';
				break;


        }
    }else{
    	header('Location: '._base_url.'404');
    	exit();
    }

   	$tpl->Assign('msg', $msg);
	$parsed_res = array('issuccess' => TRUE,
 						'html' 		=> $tpl->Parse($GLOBALS['PATH_tpl'].'cp_message.tpl'));

?>