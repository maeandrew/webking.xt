<?if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
	if(isset($_POST['action'])){
		switch($_POST['action']){
			case "SaveGuestComment":
				if(isset($_POST['id_user']) && $_POST['id_user'] == ''){
					$User = new Users();
					if($User->CheckEmailUniqueness($_POST['email']) !== true){
						$res['err'] = 1;
						$res['msg'] = 'Пользователь с таким email уже зарегистрирован. Авторизуйтесь!';
						echo json_encode($res);
						break;
					}
				}
				if(isset($_POST['comment']) && $_POST['comment'] ==''){
					$res['err'] = 2;
					$res['msg'] = 'Поле комментария пустое';
				}else{
					if(G::InsertGuestComment($_POST)){
						$res['err'] = 3;
						$res['msg'] = 'Сообщение отправлено.';
					} else{
						$res['err'] = 4;
						$res['msg'] = 'Что-то пошло не так. Повторите попытку.';
					};
				}
				echo json_encode($res);
				break;
		}
	}
	exit();
}