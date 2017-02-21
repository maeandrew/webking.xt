<?php
class mysqlPDO {
	public $response;
	public $connection; // connect ID (для совместимости с dbtree)
	public $sql;
	public $errno;

	/**
	* Конструктор класса - открывает соединение с БД
	* @param $new_link
	* @return ничего не возвращает
	*/
	public function __construct($host = 'localhost', $user = 'root', $password = '', $database = '', $new_link = 0){
		try{
			$this->connection = new PDO('mysql:dbname='.$database.';host='.$host, $user, $password);
		}catch(PDOException $e){
			echo 'Подключение не удалось: ';// . $e->getMessage();
			exit();
		}
		$sql = 'SET NAMES utf8';
		$this->Query($sql);
		$this->errno = false;
		return true;
	}

	/**
	* Подготавливает запрос
	* @return ничего не возвращает
	*/
	public function Prepare($sql){
		return $this->connection->prepare($sql);
	}

	/**
	* Закрывает соединение с БД
	* @return ничего не возвращает
	*/
	public function Close(){
		mysql_close($this->connection);
	}

	/**
	* Выполняет запрос
	* @param $sSQL
	* @return resourse идентификатор MySql
	*/
	public function Query($sql){
		$this->response = $this->Prepare($sql);
		$this->response->execute();
		return $this->response;
	}

	/**
	* Закавычивает строку
	* @param $str
	* @return String
	*/
	public function Quote($str){
		return $this->connection->quote($str);
	}

	/**
	* При вызове прерывает работу скрипта и выводит сообщение об ошибке
	* @param string $sMessage
	* @return ничего не возвращает
	*/
	protected function Error($sMessage = ""){
		die($sMessage);
	}

	/**
	* Результат в виде объекта
	* @param $response
	* @return object
	*/
	public function ResAsObject($response = NULL){
		if($response == NULL){
			$response = $this->response;
		}
		return $response->fetch(PDO::FETCH_OBJ);
	}

	/**
	* Результат в виде массива
	* @param $response
	* @return object
	*/
	public function ResAsArray($response = NULL){
		if($response == NULL){
			$response = $this->response;
		}
		return $response->fetch(PDO::FETCH_ASSOC);
	}

	/**
	* Получить массив полей и значений всех полученных строк
	* @param string $sql
	* @return array многомерный массив строк с полями и значениями
	*/
	public function GetArray($sql = '', $key_field = ''){
		$response = $this->Query($sql) or G::DieLoger("SQL Error - $sql");
		$retarr = array();
		if($key_field == ''){
			while($res = $this->ResAsArray($response)){
				$retarr[] = $res;
			}
		}else{
			while($res = $this->ResAsArray($response)){
				$retarr[$res[$key_field]] = $res;
			}
		}
		return $retarr;
	}

	/**
	* Получить массив полей и значений одной строки результата
	* @param string $sql
	* @return array массив полей и значений
	*/
	public function GetOneRowArray($sql = ''){
		$response = $this->Query($sql) or G::DieLoger("SQL Error - $sql");
		$res = $this->ResAsArray($response);
		return $res;
	}

	/**
	* Получение максимального id + 1 из таблицы
	* @param int $id
	* @param string $table
	* @return int
	*/
	public function GetMaxId($id, $table){
		$query = 'select MAX('.$id.') as max_id from '.$table;
		$res_id = $this->query($query);
		if(mysql_num_rows($res_id) != 0) {
			$res = mysql_fetch_object($res_id);
			$ret = $res->max_id + 1;
		}else{
			$ret = 0;
		}
		mysql_free_result($res_id);
		return $ret;
	}

	/**
	* Получение последнего id после выполнения INSERT
	* @return int Id
	*/
//	public function GetInsId(){
//		return mysql_insert_id($this->connection);
//	}

	/**
	* Количество строк в последнем результате
	* @return int количество строк
	*/
	public function RowsCount(){
		return mysql_num_rows($this->res_id);
	}

	/**
	* Получить количество строк в таблице
	* @param string $table
	* @return int
	*/
	public function GetCount($table){
		$query = 'SELECT COUNT(*) AS cnt FROM '.$table;
		if($res_id = $this->query($query)){
			if($res = mysql_num_rows($res_id)){
				$res = mysql_fetch_object($res_id);
			}
		}
		return $res->cnt;
	}

	/**
	* Удалить строку из таблицы
	* @param string $table
	* @param string $field_id_name
	* @param int $field_id_value
	* @return resourse идентификатор MySql
	*/
	public function DeleteRowFrom($table, $field_id_name, $field_id_value){
		$query = 'DELETE FROM '.$table.' WHERE '.$field_id_name.'='.$field_id_value;
		return $this->query($query);
	}

	/**
	* Удалить строки из таблицы
	* @param string $table
	* @param array $fv
	* @return resourse идентификатор MySql
	*/
	public function DeleteRowsFrom($table, $fv){
		$str = implode(" AND ", $fv);
		$query = 'DELETE FROM '.$table.' WHERE '.$str;
		return $this->query($query);
	}

	/**
	* Мастер вставки
	* @param string $table
	* @param array $fields
	* @return bool
	*/
	public function Insert($table, $fields){
		$keys = array_keys($fields);
		$values = array_values($fields);
		$sql = "INSERT INTO $table (`";
		$sql .= implode("`, `", $keys);
		$sql .="`) VALUES (";
		foreach($values as $key => $value){
			if(gettype($value) == 'string'){
				$sql .= $this->Quote($value);
			}else{
				$sql .= "'".$value."'";
			}
			if($key < count($values)-1){
				$sql .= ', ';
			}
		}
		$sql .=")";
		// if(G::IsLogged() && $_SESSION['member']['id_user'] == 25143){
		// 	print_r($sql);
		// }
		return $this->Query($sql) or G::DieLoger("SQL error - $sql");
	}

	public function Insert_user($table, $fields){
		$keys = array_keys($fields);
		$values = array_values($fields);
		$sql = "INSERT INTO $table (`";
		$sql .= implode("`, `", $keys);
		$sql .="`) VALUES (\"";
		$sql .= implode("\", \"", $values);
		$sql .="\")";
		return  $this->Query($sql);
	}

	/**
	* Мастер вставки группы
	* @param string $table
	* @param array $fields
	* @return bool
	*/
	public function InsertArr($table, $arr){
		$keys = array_keys($arr[0]);
		$sql = "INSERT INTO $table (`";
		$sql .= implode("`, `", $keys);
		$sql .="`) VALUES ";
		$ii = 0;
		foreach($arr as $key=>$val){
			$i = 0;
			if($ii++) $sql .= ', ';
			$sql .= '(';
			foreach($val as $k=>$v){
				$sql .= (gettype($v) == 'string'?$this->Quote($v):(gettype($v) == 'NULL'?'NULL':$v));
				$i++;
				if($i !== count($keys)){
					$sql .= ', ';
				}
			}
			$sql .= ')';
			// if($_SESSION['member']['id_user'] == 20793){

			// }else{
			// 	if($ii++) $sql .= ", ";
			// 	$sql .="(\"";
			// 	$sql .= implode("\", \"", $val);
			// 	$sql .="\")";
			// }
		}

		// if($_SESSION['member']['id_user'] == 20793){
		// 	print_r($sql);die();
		// }
		return $this->Query($sql);
	}

	/**
	* Мастер апдейта
	* @param string $table
	* @param array $fields
	* @return bool
	*/
	public function Update($table, $fields, $where){
		$sql = "UPDATE $table SET ";
		$arr = array();
		foreach($fields as $k=>$v){
			$arr[] = "$k = ".(gettype($v) == 'string'?$this->Quote($v):(gettype($v) == 'NULL'?'NULL':$v));
		}
		$sql .= implode(", ", $arr);
		$sql .=" WHERE $where";
		$this->sql = $sql;
		return $this->Query($sql);
	}

	/**
	* Мастер апдейта про (не обворачивает в кавычки)
	* @param string $table
	* @param array $fields
	* @return bool
	*/
	public function UpdatePro($table, $fields, $where){
		$keys = array_keys($fields);
		$values = array_values($fields);
		$sql = "UPDATE $table SET ";
		$arr = array();
		foreach ($fields as $k=>$v){
			$arr[] = "`$k` = $v";
		}
		$sql .= implode(", ", $arr);
		$sql .=" WHERE $where";
		$this->sql = $sql;
		return $this->Query($sql);
	}

	/**
	* Генератор строки WHERE на основании массива and
	* @param array $and
	* @return string
	*/
	public function GetWhere($and){
		if(is_array($and) && !empty($and)){
			$where = ' WHERE ';
			foreach($and as $k=>$v){
				if($k === 'customs'){
					if(!empty($v)){
						$where_a[] = implode(' AND ', $v);
					}
				}elseif(is_array($v)){
					$where_a[] = $k.' IN ('.implode(', ', $v).') ';
				}elseif(stripos($v, '*') !== false){
					$where_a[] = $k.' LIKE (\''.str_replace('*', '%', $v).'\')';
				}else{
					$where_a[] = $k.' = '.(gettype($v) == 'string'?$this->Quote($v):(gettype($v) == 'NULL'?'NULL':$v));
				}
			}
			$where .= implode(' AND ', $where_a);
		}
		return isset($where)?$where:null;
	}

	/**
	* Получить ID последний вставки
	* @param array $and
	* @return string
	*/
	public function GetLastId(){
		return $this->connection->lastInsertId();
	}

	// -----------------------------------------------   dbtree   --------------------------------------------

	/**
	* Generate unique insert ID
	*
	* @param string $seqname - Sequence table name
	* @param integer $start - Initial value
	*/
	function GenID($seqname, $start){
		$sql = 'update ' . addslashes($seqname) . ' set id=LAST_INSERT_ID(id+1)';
		$res = $this->Execute($sql);
		if(false === $res){
			$sql = 'create table ' . addslashes(strtoupper($seqname)) . ' (id int not null)';
			$this->Execute($sql);
			$sql = 'insert into ' . addslashes(strtoupper($seqname)) . ' values (' . (int)($start-1) . ')';
			$this->Execute($sql);
		}
		return $this->GetLastId();
	}

	/**
	* Execute SQL query
	*
	* @param string $sql - SQL query
	* @return object Recordset
	*/
	function Execute($sql){
		$res = $this->Query($sql);
		// $res = mysql_query($sql, $this->conn);
		if($res === false){
			return false;
		}
		$recordset = new recordset($res, $sql);
		return $recordset;
	}

	/**
	* Cache SQL query (added for compatibility), not realized
	*
	* @param integer $cache
	* @param string $sql - SQL query
	*/
	function CacheExecute($cache, $sql){
		return $this->Execute($sql);
	}

	/**
	* Generate UPDATE SQL query
	*
	* @param object $recordset - SELECT query result
	* @param array $data - Contains parameters for additional fields of a tree (if is): array('filed name' => 'importance', etc)
	* @return string - Complete SQL query or empty string
	*/
	function GetUpdateSQL($recordset, $data){
		if(empty($data)){
			return '';
		}
		preg_match_all("~FROM\s+([^\s]*)~", $recordset->sql, $maches, PREG_PATTERN_ORDER);
		if(!isset($maches[1][0])){
			return '';
		}else{
			$table = $maches[1][0];
		}
		preg_match_all("~(WHERE\s+.*)~is", $recordset->sql, $maches, PREG_PATTERN_ORDER);
		if(!isset($maches[0][0])){
			return '';
		}else{
			$where = $maches[0][0];
		}
		$fld_names = array_keys($data);
		$fld_values = array_values($data);
		$data = 'SET ';
		for($max = count($fld_names), $i = 0;$i < $max;$i++){
			$data .= $fld_names[$i] . ' = \'' . $fld_values[$i] . '\' ';
			if($i < $max-1){
				$data .= ', ';
			}
		}
		$sql = 'UPDATE ' . $table . ' ' . $data . ' ' . $where;
		return $sql;
	}

	/**
	* Generate SELECT SQL query
	*
	* @param object $recordset - SELECT query result
	* @param array $data - Contains parameters for additional fields of a tree (if is): array('filed name' => 'importance', etc)
	* @return string - Complete SQL query or empty string
	*/
	function GetInsertSQL($recordset, $data){
		if(empty($data)){
			return '';
		}
		preg_match_all("~FROM\s+([^\s]*)~", $recordset->sql, $maches, PREG_PATTERN_ORDER);
		if(!isset($maches[1][0])){
			return '';
		}else{
			$table = $maches[1][0];
		}
		if(!empty($data)){
			$fld_names = implode(', ', array_keys($data));
			$fld_values = '\'' . implode('\', \'', array_values($data)) . '\'';
		}
		$sql = 'INSERT INTO ' . $table . ' (' . $fld_names . ') VALUES (' . $fld_values . ')';
		return $sql;
	}

	/**
	* Return on field result
	*
	* @param string $sql - SQL query
	* @return unknown
	*/
	function GetOne($sql){
		$res = $this->Execute($sql);
		if(false === $res){
			return false;
		}
		return reset($res->FetchRow());
	}

	/**
	* Transactions mechanism (added for compatibility, not realised)
	*
	*/
	function StartTrans(){
		$this->connection->beginTransaction();
		return;
	}

	/**
	* Transactions mechanism (added for compatibility, not realised)
	*
	*/
	function FailTrans(){
		$this->connection->rollBack();
		return;
	}

	/**
	* Transactions mechanism (added for compatibility, not realised)
	*
	*/
	function CompleteTrans(){
		$this->connection->commit();
		return;
	}

	/**
	* Return database error message
	*
	* @return string
	*/
	function ErrorMsg(){
		return "<span style=\"color:red;\">". implode(' - ', $this->connection->errorInfo()) ."</span>";//переписал в PDO и убрал паредаваемый параметр $this->connection
	}

	/**
	* Мастер проверки полей на совпадение
	* @param string $table
	* @param array $fields
	* @return bool
	*/
	public function ValidationFields($table, $fields){
		foreach ($fields as $key => $value) {
			if(!isset($if)){
				$if = "WHERE ";
			}else{
				$if .= " AND ";
			}
			$if .= $key." = '".$value."'";
		}
		$sql = "SELECT COUNT(*) AS count FROM $table ";
		$sql .= $if;
		$count = $this->GetOneRowArray($sql);
		if($count['count'] > 0){
			return false;
		}
		return true;
	}
}

//class mysqlDb {
//	public $res_id;
//	public $iCID; // connect ID
//	var $conn; // connect ID (для совместимости с dbtree)
//	public $sql;
//	public $errno;
//		/**
//	* Конструктор класса - открывает соединение с БД
//	* @param $new_link
//	* @return ничего не возвращает
//	*/
//	public function __construct($host = "localhost", $user = "root", $password = "", $database = "", $new_link = 0){
//		$this->conn = $this->iCID = mysql_connect($host, $user, $password, $new_link);
//		if($this->iCID > 0) {
//			if(!mysql_select_db($database, $this->iCID)) {
//				$this->Error("Can't select database = <strong> $database </strong>");
//			}
//		}else{
//			$this->Error("Can't connect to database <strong> $database </strong>");
//		}
//		$sql = "SET NAMES utf8";
//		$this->Query($sql);
//		$this->errno = false;
//		return true;
//	}
//	/**
//	* Закрывает соединение с БД
//	* @return ничего не возвращает
//	*/
//	public function Close(){
//		mysql_close($this->iCID);
//	}
//	/**
//	* Выполняет запрос
//	* @param $sSQL
//	* @return resourse идентификатор MySql
//	*/
//	public function Query($sSQL){
//		return $this->res_id = mysql_query($sSQL, $this->iCID);
//	}
//	/**
//	* Закавычивает строку
//	* @param $str
//	* @return String
//	*/
//	public function Escape($str){
//		return mysql_real_escape_string($str);
//	}
//	/**
//	* При вызове прерывает работу скрипта и выводит сообщение об ошибке
//	* @param string $sMessage
//	* @return ничего не возвращает
//	*/
//	protected function Error($sMessage = ""){
//		die($sMessage);
//	}
//	/**
//	* Результат в виде объекта
//	* @param $res_id
//	* @return object
//	*/
//	public function ResAsObject($res_id = NULL){
//		if($res_id == NULL){
//			$res_id = $this->res_id;
//		}
//		return mysql_fetch_object($res_id);
//	}
//	/**
//	* Результат в виде массива
//	* @param $res_id
//	* @return object
//	*/
//	public function ResAsArray($res_id = NULL){
//		if($res_id == NULL){
//			$res_id = $this->res_id;
//		}
//		return mysql_fetch_assoc($res_id);
//	}
//
//	/**
//	* Получить массив полей и значений всех полученных строк
//	* @param string $sql
//	* @return array многомерный массив строк с полями и значениями
//	*/
//	public function GetArray($sql = '', $key_field = ''){
//		$res_id = $this->Query($sql) or G::DieLoger("SQL Error - $sql");
//		$retarr = array();
//		if($key_field == ''){
//			while($res = $this->ResAsArray($res_id)){
//				$retarr[] = $res;
//			}
//		}else{
//			while($res = $this->ResAsArray($res_id)){
//				$retarr[$res[$key_field]] = $res;
//			}
//		}
//		return $retarr;
//	}
//
//	/**
//	* Получить массив полей и значений одной строки результата
//	* @param string $sql
//	* @return array массив полей и значений
//	*/
//	public function GetOneRowArray($sql = ''){
//		$res_id = $this->Query($sql) or G::DieLoger("SQL Error - $sql");
//		$retarr = array();
//		$res = $this->ResAsArray($res_id);
//		return $res;
//	}
//
//	/**
//	* Получение максимального id + 1 из таблицы
//	* @param int $id
//	* @param string $table
//	* @return int
//	*/
//	public function GetMaxId($id, $table){
//		$query = 'select MAX('.$id.') as max_id from '.$table;
//		$res_id = $this->query($query);
//		if(mysql_num_rows($res_id) != 0) {
//			$res = mysql_fetch_object($res_id);
//			$ret = $res->max_id + 1;
//		}else{
//			$ret = 0;
//		}
//		mysql_free_result($res_id);
//		return $ret;
//	}
//
//	/**
//	* Получение последнего id после выполнения INSERT
//	* @return int Id
//	*/
////	public function GetInsId(){
////		return mysql_insert_id($this->iCID);
////	}
//
//	/**
//	* Количество строк в последнем результате
//	* @return int количество строк
//	*/
//	public function RowsCount(){
//		return mysql_num_rows($this->res_id);
//	}
//
//	/**
//	* Получить количество строк в таблице
//	* @param string $table
//	* @return int
//	*/
//	public function GetCount($table){
//		$query = 'SELECT COUNT(*) as cnt FROM '.$table;
//		if($res_id = $this->query($query)){
//			if($res = mysql_num_rows($res_id)){
//				$res = mysql_fetch_object($res_id);
//			}
//		}
//		return $res->cnt;
//	}
//
//	/**
//	* Удалить строку из таблицы
//	* @param string $table
//	* @param string $field_id_name
//	* @param int $field_id_value
//	* @return resourse идентификатор MySql
//	*/
//	public function DeleteRowFrom($table, $field_id_name, $field_id_value){
//		$query = 'delete from '.$table.' where '.$field_id_name.'='.$field_id_value;
//		return $this->query($query);
//	}
//
//	/**
//	* Удалить строки из таблицы
//	* @param string $table
//	* @param array $fv
//	* @return resourse идентификатор MySql
//	*/
//	public function DeleteRowsFrom($table, $fv){
//		$str = implode(" AND ", $fv);
//		$query = 'delete from '.$table.' where '.$str;
//		return $this->query($query);
//	}
//
//	/**
//	* Мастер вставки
//	* @param string $table
//	* @param array $fields
//	* @return bool
//	*/
//	public function Insert($table, $fields){
//		$keys = array_keys($fields);
//		$values = array_values($fields);
//		$sql = "INSERT INTO $table (`";
//		$sql .= implode("`, `", $keys);
//		$sql .="`) VALUES (\"";
//		$sql .= implode("\", \"", $values);
//		$sql .="\")";
//		return $this->Query($sql) or G::DieLoger("SQL error - $sql");
//	}
//
//	public function Insert_user($table, $fields){
//		$keys = array_keys($fields);
//		$values = array_values($fields);
//		$sql = "INSERT INTO $table (`";
//		$sql .= implode("`, `", $keys);
//		$sql .="`) VALUES (\"";
//		$sql .= implode("\", \"", $values);
//		$sql .="\")";
//		return  $this->Query($sql);
//	}
//
//	/**
//	* Мастер вставки группы
//	* @param string $table
//	* @param array $fields
//	* @return bool
//	*/
//	public function InsertArr($table, $arr){
//		$keys = array_keys($arr[0]);
//		$sql = "INSERT INTO $table (`";
//		$sql .= implode("`, `", $keys);
//		$sql .="`) VALUES ";
//		$ii=0;
//		foreach($arr as $key=>$val){
//			if($ii++) $sql .= ", ";
//			$sql .="(\"";
//			$sql .= implode("\", \"", $val);
//			$sql .="\")";
//		}
//		return $this->Query($sql);
//	}
//
//	/**
//	* Мастер апдейта
//	* @param string $table
//	* @param array $fields
//	* @return bool
//	*/
//	public function Update($table, $fields, $where){
//		$keys = array_keys($fields);
//		$values = array_values($fields);
//		$sql = "UPDATE $table SET ";
//		$arr = array();
//		foreach($fields as $k=>$v){
//			$arr[] = "`$k` = \"$v\"";
//		}
//		$sql .= implode(", ", $arr);
//		$sql .=" WHERE $where";
//		$this->sql = $sql;
//		return $this->Query($sql);
//	}
//
//	/**
//	* Мастер апдейта про (не обворачивает в кавычки)
//	* @param string $table
//	* @param array $fields
//	* @return bool
//	*/
//	public function UpdatePro($table, $fields, $where){
//		$keys = array_keys($fields);
//		$values = array_values($fields);
//		$sql = "UPDATE $table SET ";
//		$arr = array();
//		foreach ($fields as $k=>$v){
//			$arr[] = "`$k` = $v";
//		}
//		$sql .= implode(", ", $arr);
//		$sql .=" WHERE $where";
//		$this->sql = $sql;
//		return $this->Query($sql);
//	}
//
//	/**
//	* Генератор строки WHERE на основании массива and
//	* @param array $and
//	* @return string
//	*/
//	public function GetWhere($and){
//		$where = "";
//		if($and !== FALSE && count($and)){
//			$where = " WHERE ";
//			foreach ($and as $k=>$v){
//				if(FALSE !== stripos($v,	"*")){
//					$where_a[] = "$k LIKE(\"".str_replace("*", "%", $v)."\")";
//				}else{
//					$where_a[] = "$k=\"$v\"";
//				}
//			}
//			$where .= implode(" AND ", $where_a);
//		}
//		return $where;
//	}
//
//	// -----------------------------------------------   dbtree   --------------------------------------------
//
//	/**
//	* Generate unique insert ID
//	*
//	* @param string $seqname - Sequence table name
//	* @param integer $start - Initial value
//	*/
//	function GenID($seqname, $start){
//		$sql = 'update ' . addslashes($seqname) . ' set id=LAST_INSERT_ID(id+1)';
//		$res = $this->Execute($sql);
//		if(false === $res){
//			$sql = 'create table ' . addslashes(strtoupper($seqname)) . ' (id int not null)';
//			$this->Execute($sql);
//			$sql = 'insert into ' . addslashes(strtoupper($seqname)) . ' values (' . (int)($start-1) . ')';
//			$this->Execute($sql);
//		}
//		return mysql_insert_id($this->conn);
//	}
//
//	/**
//	* Execute SQL query
//	*
//	* @param string $sql - SQL query
//	* @return object Recordset
//	*/
//	function Execute($sql){
//		$res = mysql_query($sql, $this->conn);
//		if(false === $res){
//			return false;
//		}
//		$recordset = new recordset($res, $sql);
//		return $recordset;
//	}
//
//	/**
//	* Cache SQL query (added for compatibility), not realized
//	*
//	* @param integer $cache
//	* @param string $sql - SQL query
//	*/
//	function CacheExecute($cache, $sql){
//		return $this->Execute($sql);
//	}
//
//	/**
//	* Generate UPDATE SQL query
//	*
//	* @param object $recordset - SELECT query result
//	* @param array $data - Contains parameters for additional fields of a tree (if is): array('filed name' => 'importance', etc)
//	* @return string - Complete SQL query or empty string
//	*/
//	function GetUpdateSQL($recordset, $data){
//		if(empty($data)){
//			return '';
//		}
//		preg_match_all("~FROM\s+([^\s]*)~", $recordset->sql, $maches, PREG_PATTERN_ORDER);
//		if(!isset($maches[1][0])){
//			return '';
//		}else{
//			$table = $maches[1][0];
//		}
//		preg_match_all("~(WHERE\s+.*)~is", $recordset->sql, $maches, PREG_PATTERN_ORDER);
//		if(!isset($maches[0][0])){
//			return '';
//		}else{
//			$where = $maches[0][0];
//		}
//		$fld_names = array_keys($data);
//		$fld_values = array_values($data);
//		$data = 'SET ';
//		for($max = count($fld_names), $i = 0;$i < $max;$i++){
//			$data .= $fld_names[$i] . ' = \'' . $fld_values[$i] . '\' ';
//			if($i < $max-1){
//				$data .= ', ';
//			}
//		}
//		$sql = 'UPDATE ' . $table . ' ' . $data . ' ' . $where;
//		return $sql;
//	}
//
//	/**
//	* Generate SELECT SQL query
//	*
//	* @param object $recordset - SELECT query result
//	* @param array $data - Contains parameters for additional fields of a tree (if is): array('filed name' => 'importance', etc)
//	* @return string - Complete SQL query or empty string
//	*/
//	function GetInsertSQL($recordset, $data){
//		if(empty($data)){
//			return '';
//		}
//		preg_match_all("~FROM\s+([^\s]*)~", $recordset->sql, $maches, PREG_PATTERN_ORDER);
//		if(!isset($maches[1][0])){
//			return '';
//		}else{
//			$table = $maches[1][0];
//		}
//		if(!empty($data)){
//			$fld_names = implode(', ', array_keys($data));
//			$fld_values = '\'' . implode('\', \'', array_values($data)) . '\'';
//		}
//		$sql = 'INSERT INTO ' . $table . ' (' . $fld_names . ') VALUES (' . $fld_values . ')';
//		return $sql;
//	}
//
//	/**
//	* Return on field result
//	*
//	* @param string $sql - SQL query
//	* @return unknown
//	*/
//	function GetOne($sql){
//		$res = $this->Execute($sql);
//		if(false === $res){
//			return false;
//		}
//		return reset($res->FetchRow());
//	}
//
//	/**
//	* Transactions mechanism (added for compatibility, not realised)
//	*
//	*/
//	function StartTrans(){
//		$sql = 'START TRANSACTION;';
//		$this->Execute($sql);
//		return;
//	}
//
//	/**
//	* Transactions mechanism (added for compatibility, not realised)
//	*
//	*/
//	function FailTrans(){
//		$sql = 'ROLLBACK;';
//		$this->Execute($sql);
//		return;
//	}
//
//	/**
//	* Transactions mechanism (added for compatibility, not realised)
//	*
//	*/
//	function CompleteTrans(){
//		$sql = 'COMMIT;';
//		$this->Execute($sql);
//		return;
//	}
//
//	/**
//	* Return database error message
//	*
//	* @return string
//	*/
//	function ErrorMsg(){
//		return "<span style=\"color:Red;\">".mysql_error($this->iCID)." (".mysql_errno($this->iCID).")"."</span>";
//	}
//
//	/**
//	* Мастер проверки полей на совпадение
//	* @param string $table
//	* @param array $fields
//	* @return bool
//	*/
//	public function ValidationFields($table, $fields){
//		foreach ($fields as $key => $value) {
//			if(!isset($if)){
//				$if = "WHERE ";
//			}else{
//				$if .= " AND ";
//			}
//			$if .= $key." = '".$value."'";
//		}
//		$sql = "SELECT COUNT(*) AS count FROM $table ";
//		$sql .= $if;
//		$count = $this->GetOneRowArray($sql);
//		if($count['count'] > 0){
//			return false;
//		}
//		return true;
//	}
//

class recordset {
	/**
	* Recordset resource.
	*
	* @var resource
	*/
	var $recordset;

	/**
	* SQL query
	*
	* @var string
	*/
	var $sql;

	/**
	* Constructor.
	*
	* @param resource $recordset
	* @return recordset object
	*/
	function __construct($recordset, $sql){
		$this->recordset = $recordset;
		$this->sql = $sql;
	}

	/**
	* Returns amount of lines in result.
	*
	* @return integer
	*/
	function RecordCount(){
		return $this->recordset->fetchColumn();
	}

	/**
	* Returns the current row
	* @return array
	*/
	function FetchRow(){
		return $this->recordset->fetch(PDO::FETCH_ASSOC);
	}
}
