<?
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){

	//header('Content-Type: text/javascript; charset=utf-8');
	$dbtree = new dbtree(_DB_PREFIX_.'category', 'category', $db);
	$specification = new Specification();
	if (isset($_POST['action'])){
		switch($_POST['action']){
			case "update":
				$dbtree->UpdateTags($_POST['ID'], $_POST['id_category'], $_POST['tag_name'], $_POST['tag_keys'], $_POST['tag_level'], $_POST['tag_level_name']);
				break;
			case "add":
				if($dbtree->AddTags($_POST['id_category'], $_POST['tag_name'], $_POST['tag_keys'], $_POST['tag_level'], $_POST['tag_level_name'])){
					echo 'good';
				}else{
					echo 'bad';
				}
				break;
			case "drop":
				if($dbtree->DropTagById($_POST['ID'])){
					echo 'ready';
				}else{
					echo 'ERROR';
				}
				break;
			case "updatelevel":
				if($dbtree->UpdateLevelById($_POST['id_category'], $_POST['tag_level'], $_POST['tag_level_name'])){
					echo 'ready';
				}else{
					echo 'ERROR';
				}
				break;
			case "droplevel":
				if($dbtree->DropLevelById($_POST['id_category'], $_POST['tag_level'])){
					echo 'ready';
				}else{
					echo 'ERROR';
				}
				break;
			default:
				break;
		}
	}
	exit();
}