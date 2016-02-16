<?php
class dbtree {
	/**
	* Detailed errors of a class (for the programmer and log-files)
	* array('error type (1 - fatal (write log), 2 - fatal (write log, send email)',
	* 'error info string', 'function', 'info 1', 'info 2').
	*
	* @var array
	*/
	var $ERRORS = array();
	/**
	* The information on a error for the user
	* array('string (error information)').
	*
	* @var array
	*/
	var $ERRORS_MES = array();
	/**
	* Name of the table where tree is stored.
	*
	* @var string
	*/
	var $table;
	/**
	* Unique number of node.
	*
	* @var bigint
	*/
	var $table_id;
	/**
	* @var integer
	*/
	var $table_left;
	/**
	* @var integer
	*/
	var $table_right;
	/**
	* Level of nesting.
	*
	* @var integer
	*/
	var $table_level;

	/**
	* DB resource object.
	*
	* @var object
	*/
	var $res;

	/**
	* Databse layer object.
	*
	* @var object
	*/
	var $db;

	/**
	* The class constructor: initializes dbtree variables.
	*
	* @param string $table Name of the table
	* @param string $prefix A prefix for fields of the table(the example, mytree_id. 'mytree' is prefix)
	* @param object $db
	* @return object
	*/
	public function __construct($table, $prefix, &$db){
		$this->db = &$db;
		$this->table = $table;
		$this->table_id = 'id_'.$prefix;
		$this->table_left = $prefix.'_left';
		$this->table_right = $prefix.'_right';
		$this->table_level = $prefix.'_level';
		unset($prefix, $table);
		$sql = 'SET AUTOCOMMIT=0';
		$this->db->Execute($sql);
	}
	/**
	* Sets initial parameters of a tree and creates root of tree
	* ATTENTION, all previous values in table are destroyed.
	*
	* @param array $data Contains parameters for additional fields of a tree (if is): 'filed name' => 'importance'
	* @return bool true if successful, false otherwise.
	*/
	public function Clear($data = array()){
		$sql = 'TRUNCATE '.$this->table;
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$sql = 'DELETE FROM '.$this->table;
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$fld_names = $fld_values = '';
		if(!empty($data)){
			$fld_names = implode(', ', array_keys($data)).', ';
			$fld_values = '\''.implode('\', \'', array_values($data)).'\', ';
		}
		$fld_names .= $this->table_left.', '.$this->table_right.', '.$this->table_level;
		$fld_values .= '1, 2, 0';
		$id = $this->db->GenID($this->table.'_seq', 1);
		$sql = ' INTO '.$this->table.' ('.$this->table_id.', '.$fld_names.') VALUES ('.$id.', '.$fld_values.')';
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetNodeFields($section_id, $fields){
		$sql = 'SELECT '.implode(', ',$fields).' FROM '.$this->table.' WHERE '.$this->table_id.' = '.(int)$section_id;
		return $this->db->GetOneRowArray($sql);
	}

	public function Search($query){
		$sql = "SELECT id_category, name, translit
			FROM ".$this->table."
			WHERE visible = 1 AND name like \"%$query%\"";
		$list = $this->db->GetArray($sql);
		return $list;
	}

	/**
	* Receives left, right and level for unit with number id.
	*
	* @param integer $section_id Unique section id
	* @param integer $cache Recordset is cached for $cache microseconds
	* @return array - left, right, level
	*/
	public function GetNodeInfo($section_id, $cache = false){
		$sql = 'SELECT '.$this->table_left.', '.$this->table_right.', '.$this->table_level.' FROM '.$this->table.' WHERE '.$this->table_id.' = '.(int)$section_id;
		if(false === DB_CACHE || false === $cache || 0 == (int)$cache){
			$res = $this->db->Execute($sql);
		}else{
			$res = $this->db->CacheExecute((int)$cache, $sql);
		}
		if(false === $res) {
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return false;
		}
		if(0 == $res->RecordCount()){
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('no_element_in_tree') : 'no_element_in_tree';
			return false;
		}
		$data = $res->FetchRow();
		unset($res);
		return array($data[$this->table_left], $data[$this->table_right], $data[$this->table_level]);
	}
	/**
	* Receives parent left, right and level for unit with number $id.
	*
	* @param integer $section_id
	* @param integer $cache Recordset is cached for $cache microseconds
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @return array - left, right, level
	*/
	public function GetParentInfo($section_id, $condition = '', $cache = false){
		$node_info = $this->GetNodeInfo($section_id);
		if(false === $node_info){
			return false;
		}
		list($leftId, $rightId, $level) = $node_info;
		$level--;
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->table_left.' < '.$leftId.' AND '.$this->table_right.' > '.$rightId.' AND '.$this->table_level.' = '.$level.$condition.' ORDER BY '. $this->table_left;
		if(false === DB_CACHE || false === $cache || 0 == (int)$cache){
			$res = $this->db->Execute($sql);
		}else{
			$res = $this->db->CacheExecute((int)$cache, $sql);
		}
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return false;
		}
		return $res->FetchRow();
	}
	/**
	* Add a new element in the tree to element with number $section_id.
	*
	* @param integer $section_id Number of a parental element
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @param array $data Contains parameters for additional fields of a tree (if is): array('filed name' => 'importance', etc)
	* @return integer Inserted element id
	*/
	public function Insert($section_id, $condition = '', $data = array()){
		$node_info = $this->GetNodeInfo($section_id);
		if(false === $node_info){
			return false;
		}
		list($leftId, $rightId, $level) = $node_info;
		$data[$this->table_left] = $rightId;
		$data[$this->table_right] = ($rightId + 1);
		$data[$this->table_level] = ($level + 1);
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'UPDATE '.$this->table.' SET '
		.$this->table_left.'=CASE WHEN '.$this->table_left.'>'.$rightId.' THEN '.$this->table_left.'+2 ELSE '.$this->table_left.' END, '
		.$this->table_right.'=CASE WHEN '.$this->table_right.'>='.$rightId.' THEN '.$this->table_right.'+2 ELSE '.$this->table_right.' END '
		.'WHERE '.$this->table_right.'>='.$rightId;
		$sql .= $condition;
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->table_id.' = -1';
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$data[$this->table_id] = $this->db->GenID($this->table.'_seq', 2);
		$sql = $this->db->GetInsertSQL($res, $data);
		if(!empty($sql)){
			$res = $this->db->Execute($sql);
			if(false === $res){
				$this->ERRORS[] = array(2, 'SQL query error', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
				$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
				$this->db->FailTrans();
				return false;
			}
		}
		$this->db->CompleteTrans();
		return $data[$this->table_id];
	}
	/**
	* Add a new element in the tree near element with number id.
	*
	* @param integer $ID Number of a parental element
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @param array $data Contains parameters for additional fields of a tree (if is): array('filed name' => 'importance', etc)
	* @return integer Inserted element id
	*/
	public function InsertNear($ID, $condition = '', $data = array()){
		$node_info = $this->GetNodeInfo($ID);
		if(false === $node_info){
			return false;
		}
		list($leftId, $rightId, $level) = $node_info;
		$data[$this->table_left] = ($rightId + 1);
		$data[$this->table_right] = ($rightId + 2);
		$data[$this->table_level] = ($level);
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'UPDATE '.$this->table.' SET '
		.$this->table_left.' = CASE WHEN '.$this->table_left.' > '.$rightId.' THEN '.$this->table_left.' + 2 ELSE '.$this->table_left.' END, '
		.$this->table_right.' = CASE WHEN '.$this->table_right.'> '.$rightId.' THEN '.$this->table_right.' + 2 ELSE '.$this->table_right.' END, '
		.'WHERE '.$this->table_right.' > '.$rightId;
		$sql .= $condition;
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->table_id.' = -1';
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$data[$this->table_id] = $this->db->GenID($this->table.'_seq', 2);
		$sql = $this->db->GetInsertSQL($res, $data);
		if(!empty($sql)){
			$res = $this->db->Execute($sql);
			if(false === $res){
				$this->ERRORS[] = array(2, 'SQL query error', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
				$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
				$this->db->FailTrans();
				return false;
			}
		}
		$this->db->CompleteTrans();
		return $data[$this->table_id];
	}
	/**
	* Assigns a node with all its children to another parent.
	*
	* @param integer $ID node ID
	* @param integer $newParentId ID of new parent node
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @return bool true if successful, false otherwise.
	*/
	public function MoveAll($ID, $newParentId, $condition = ''){
		$node_info = $this->GetNodeInfo($ID);
		if(false === $node_info){
			return false;
		}
		list($leftId, $rightId, $level) = $node_info;
		$node_info = $this->GetNodeInfo($newParentId);
		if(false === $node_info){
			return false;
		}
		list($leftIdP, $rightIdP, $levelP) = $node_info;
		if($ID == $newParentId || $leftId == $leftIdP || ($leftIdP >= $leftId && $leftIdP <= $rightId) || ($level == $levelP+1 && $leftId > $leftIdP && $rightId < $rightIdP)){
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('cant_move_tree') : 'cant_move_tree';
			return false;
		}
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition);
		}
		if($leftIdP < $leftId && $rightIdP > $rightId && $levelP < $level - 1){
			$sql = 'UPDATE '.$this->table.' SET '
			.$this->table_level.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_level.sprintf('%+d', -($level-1)+$levelP).' ELSE '.$this->table_level.' END, '
			.$this->table_right.' = CASE WHEN '.$this->table_right.' BETWEEN '.($rightId+1).' AND '.($rightIdP-1).' THEN '.$this->table_right.'-'.($rightId-$leftId+1).' '
			.'WHEN '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_right.'+'.((($rightIdP-$rightId-$level+$levelP)/2)*2+$level-$levelP-1).' ELSE '.$this->table_right.' END, '
			.$this->table_left.' = CASE WHEN '.$this->table_left.' BETWEEN '.($rightId+1).' AND '.($rightIdP-1).' THEN '.$this->table_left.'-'.($rightId-$leftId+1).' '
			.'WHEN '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_left.'+'.((($rightIdP-$rightId-$level+$levelP)/2)*2+$level-$levelP-1).' ELSE '.$this->table_left.' END '
			.'WHERE '.$this->table_left.' BETWEEN '.($leftIdP+1).' AND '.($rightIdP-1);
		}elseif($leftIdP < $leftId){
			$sql = 'UPDATE '.$this->table.' SET '
			.$this->table_level.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_level.sprintf('%+d', -($level-1)+$levelP).' ELSE '.$this->table_level.' END, '
			.$this->table_left.' = CASE WHEN '.$this->table_left.' BETWEEN '.$rightIdP.' AND '.($leftId-1).' THEN '.$this->table_left.'+'.($rightId-$leftId+1).' '
			.'WHEN '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_left.'-'.($leftId-$rightIdP).' ELSE '.$this->table_left.' END, '
			.$this->table_right.' = CASE WHEN '.$this->table_right.' BETWEEN '.$rightIdP.' AND '.$leftId.' THEN '.$this->table_right.'+'.($rightId-$leftId+1).' '
			.'WHEN '.$this->table_right.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_right.'-'.($leftId-$rightIdP).' ELSE '.$this->table_right.' END '
			.'WHERE ('.$this->table_left.' BETWEEN '.$leftIdP.' AND '.$rightId. ' '
			.'OR '.$this->table_right.' BETWEEN '.$leftIdP.' AND '.$rightId.')';
		}else{
			$sql = 'UPDATE '.$this->table.' SET '
			.$this->table_level.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_level.sprintf('%+d', -($level-1)+$levelP).' ELSE '.$this->table_level.' END, '
			.$this->table_left.' = CASE WHEN '.$this->table_left.' BETWEEN '.$rightId.' AND '.$rightIdP.' THEN '.$this->table_left.'-'.($rightId-$leftId+1).' '
			.'WHEN '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_left.'+'.($rightIdP-1-$rightId).' ELSE '.$this->table_left.' END, '
			.$this->table_right.' = CASE WHEN '.$this->table_right.' BETWEEN '.($rightId+1).' AND '.($rightIdP-1).' THEN '.$this->table_right.'-'.($rightId-$leftId+1).' '
			.'WHEN '.$this->table_right.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_right.'+'.($rightIdP-1-$rightId).' ELSE '.$this->table_right.' END '
			.'WHERE ('.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightIdP.' '
			.'OR '.$this->table_right.' BETWEEN '.$leftId.' AND '.$rightIdP.')';
		}
		$sql .= $condition;
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	* Change items position.
	*
	* @param integer $id1 first item ID
	* @param integer $id2 second item ID
	* @return bool true if successful, false otherwise.
	*/
	public function ChangePosition($id1, $id2){
		$node_info = $this->GetNodeInfo($id1);
		if(false === $node_info){
			return false;
		}
		list($leftId1, $rightId1, $level1) = $node_info;
		$node_info = $this->GetNodeInfo($id2);
		if(false === $node_info){
			return false;
		}
		list($leftId2, $rightId2, $level2) = $node_info;
		$sql = 'UPDATE '.$this->table.' SET '
		.$this->table_left.' = '.$leftId2 .', '
		.$this->table_right.' = '.$rightId2 .', '
		.$this->table_level.' = '.$level2 .' '
		.'WHERE '.$this->table_id.' = '.(int)$id1;
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$sql = 'UPDATE '.$this->table.' SET '
		.$this->table_left.' = '.$leftId1 .', '
		.$this->table_right.' = '.$rightId1 .', '
		.$this->table_level.' = '.$level1 .' '
		.'WHERE '.$this->table_id.' = '.(int)$id2;
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	* Swapping nodes within the same level and limits of one parent with all its children: $id1 placed before or after $id2.
	*
	* @param integer $id1 first item ID
	* @param integer $id2 second item ID
	* @param string $position 'before' or 'after' $id2
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @return bool true if successful, false otherwise.
	*/
	public function ChangePositionAll($id1, $id2, $position = 'after', $condition = ''){
		$node_info = $this->GetNodeInfo($id1);
		if(false === $node_info){
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('cant_change_position') : 'cant_change_position';
			return false;
		}
		list($leftId1, $rightId1, $level1) = $node_info;
		$node_info = $this->GetNodeInfo($id2);
		if(false === $node_info){
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('cant_change_position') : 'cant_change_position';
			return false;
		}
		list($leftId2, $rightId2, $level2) = $node_info;
		if($level1 <> $level2){
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('cant_change_position') : 'cant_change_position';
			return false;
		}
		if('before' == $position){
			if($leftId1 > $leftId2){
				$sql = 'UPDATE '.$this->table.' SET '
				.$this->table_right.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId1.' AND '.$rightId1.' THEN '.$this->table_right.' - '.($leftId1 - $leftId2).' '
				.'WHEN '.$this->table_left.' BETWEEN '.$leftId2.' AND '.($leftId1 - 1).' THEN '.$this->table_right.' +  '.($rightId1 - $leftId1 + 1).' ELSE '.$this->table_right.' END, '
				.$this->table_left.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId1.' AND '.$rightId1.' THEN '.$this->table_left.' - '.($leftId1 - $leftId2).' '
				.'WHEN '.$this->table_left.' BETWEEN '.$leftId2.' AND '.($leftId1 - 1).' THEN '.$this->table_left.' + '.($rightId1 - $leftId1 + 1).' ELSE '.$this->table_left.' END '
				.'WHERE '.$this->table_left.' BETWEEN '.$leftId2.' AND '.$rightId1;
			}else{
				$sql = 'UPDATE '.$this->table.' SET '
				.$this->table_right.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId1.' AND '.$rightId1.' THEN '.$this->table_right.' + '.(($leftId2 - $leftId1) - ($rightId1 - $leftId1 + 1)).' '
				.'WHEN '.$this->table_left.' BETWEEN '.($rightId1 + 1).' AND '.($leftId2 - 1).' THEN '.$this->table_right.' - '.(($rightId1 - $leftId1 + 1)).' ELSE '.$this->table_right.' END, '
				.$this->table_left.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId1.' AND '.$rightId1.' THEN '.$this->table_left.' + '.(($leftId2 - $leftId1) - ($rightId1 - $leftId1 + 1)).' '
				.'WHEN '.$this->table_left.' BETWEEN '.($rightId1 + 1).' AND '.($leftId2 - 1).' THEN '.$this->table_left.' - '.($rightId1 - $leftId1 + 1).' ELSE '.$this->table_left.' END '
				.'WHERE '.$this->table_left.' BETWEEN '.$leftId1.' AND '.($leftId2 - 1);
			}
		}
		if('after' == $position){
			if($leftId1 > $leftId2){
				$sql = 'UPDATE '.$this->table.' SET '
				.$this->table_right.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId1.' AND '.$rightId1.' THEN '.$this->table_right.' - '.($leftId1 - $leftId2 - ($rightId2 - $leftId2 + 1)).' '
				.'WHEN '.$this->table_left.' BETWEEN '.($rightId2 + 1).' AND '.($leftId1 - 1).' THEN '.$this->table_right.' +  '.($rightId1 - $leftId1 + 1).' ELSE '.$this->table_right.' END, '
				.$this->table_left.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId1.' AND '.$rightId1.' THEN '.$this->table_left.' - '.($leftId1 - $leftId2 - ($rightId2 - $leftId2 + 1)).' '
				.'WHEN '.$this->table_left.' BETWEEN '.($rightId2 + 1).' AND '.($leftId1 - 1).' THEN '.$this->table_left.' + '.($rightId1 - $leftId1 + 1).' ELSE '.$this->table_left.' END '
				.'WHERE '.$this->table_left.' BETWEEN '.($rightId2 + 1).' AND '.$rightId1;
			}else{
				$sql = 'UPDATE '.$this->table.' SET '
				.$this->table_right.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId1.' AND '.$rightId1.' THEN '.$this->table_right.' + '.($rightId2 - $rightId1).' '
				.'WHEN '.$this->table_left.' BETWEEN '.($rightId1 + 1).' AND '.$rightId2.' THEN '.$this->table_right.' - '.(($rightId1 - $leftId1 + 1)).' ELSE '.$this->table_right.' END, '
				.$this->table_left.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId1.' AND '.$rightId1.' THEN '.$this->table_left.' + '.($rightId2 - $rightId1).' '
				.'WHEN '.$this->table_left.' BETWEEN '.($rightId1 + 1).' AND '.$rightId2.' THEN '.$this->table_left.' - '.($rightId1 - $leftId1 + 1).' ELSE '.$this->table_left.' END '
				.'WHERE '.$this->table_left.' BETWEEN '.$leftId1.' AND '.$rightId2;
			}
		}
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition);
		}
		$sql .= $condition;
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	* Delete element with number $id from the tree wihtout deleting it's children.
	*
	* @param integer $ID Number of element
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @return bool true if successful, false otherwise.
	*/
	public function Delete($ID, $condition = ''){
		$node_info = $this->GetNodeInfo($ID);
		if(false === $node_info){
			return false;
		}
		list($leftId, $rightId) = $node_info;
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'DELETE FROM '.$this->table.' WHERE '.$this->table_id.' = '.(int)$ID;
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$sql = 'UPDATE '.$this->table.' SET '
		.$this->table_level.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_level.' - 1 ELSE '.$this->table_level.' END, '
		.$this->table_right.' = CASE WHEN '.$this->table_right.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_right.' - 1 '
		.'WHEN '.$this->table_right.' > '.$rightId.' THEN '.$this->table_right.' - 2 ELSE '.$this->table_right.' END, '
		.$this->table_left.' = CASE WHEN '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId.' THEN '.$this->table_left.' - 1 '
		.'WHEN '.$this->table_left.' > '.$rightId.' THEN '.$this->table_left.' - 2 ELSE '.$this->table_left.' END '
		.'WHERE '.$this->table_right.' > '.$leftId;
		$sql .= $condition;
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	* Delete element with number $ID from the tree and all it childret.
	*
	* @param integer $ID Number of element
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @return bool true if successful, false otherwise.
	*/
	public function DeleteAll($ID, $condition = ''){
		$node_info = $this->GetNodeInfo($ID);
		if(false === $node_info){
			return false;
		}
		list($leftId, $rightId) = $node_info;
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition);
		}
		$sql = 'DELETE FROM '.$this->table.' WHERE '.$this->table_left.' BETWEEN '.$leftId.' AND '.$rightId;
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$deltaId = (($rightId - $leftId) + 1);
		$sql = 'UPDATE '.$this->table.' SET '
		.$this->table_left.' = CASE WHEN '.$this->table_left.' > '.$leftId.' THEN '.$this->table_left.' - '.$deltaId.' ELSE '.$this->table_left.' END, '
		.$this->table_right.' = CASE WHEN '.$this->table_right.' > '.$leftId.' THEN '.$this->table_right.' - '.$deltaId.' ELSE '.$this->table_right.' END '
		.'WHERE '.$this->table_right.' > '.$rightId;
		$sql .= $condition;
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}
	/**
	* Returns all elements of the tree sortet by left.
	*
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @param array $fields needed fields (if is): array('filed1 name', 'filed2 name', etc)
	* @param integer $cache Recordset is cached for $cache microseconds
	* @return array needed fields
	*/
	public function Full($fields, $condition = '', $cache = false){
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition, true);
		}
		if(is_array($fields)){
			$fields = implode(', ', $fields);
		}else{
			$fields = '*';
		}
		$sql = 'SELECT '.$fields.' FROM '.$this->table;
		$sql .= $condition;
		$sql .= ' ORDER BY '.$this->table_left;
		if(false === DB_CACHE || false === $cache || 0 == (int)$cache){
			$res = $this->db->GetArray($sql);
		}else{
			$res = $this->db->CacheExecute((int)$cache, $sql);
		}
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return false;
		}
		return $res;
	}
	/**
	* Returns all elements of a branch starting from an element with number $ID.
	*
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @param array $fields needed fields (if is): array('filed1 name', 'filed2 name', etc)
	* @param integer $cache Recordset is cached for $cache microseconds
	* @param integer $ID Node unique id
	* @return array - [0] => array(id, left, right, level, additional fields), [1] => array(...), etc.
	*/
	public function Branch($ID, $fields, $condition = '', $cache = false){
		if(is_array($fields)){
			$fields = 'A.'.implode(', A.', $fields);
		}else{
			$fields = 'A.*';
		}
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition, false, 'A.');
		}
		$sql = 'SELECT '.$fields.', CASE WHEN A.'.$this->table_left.' + 1 < A.'.$this->table_right.' THEN 1 ELSE 0 END AS nflag FROM '.$this->table.' A, '.$this->table.' B WHERE B.'.$this->table_id.' = '.(int)$ID.' AND A.'.$this->table_left.' >= B.'.$this->table_left.' AND A.'.$this->table_right.' <= B.'.$this->table_right;
		$sql .= $condition;
		$sql .= ' ORDER BY A.'.$this->table_left;
		if(false === DB_CACHE || false === $cache || 0 == (int)$cache){
			$res = $this->db->Execute($sql);
		}else{
			$res = $this->db->CacheExecute((int)$cache, $sql);
		}
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return false;
		}
		$this->res = $res;
		return true;
	}
	/**
	* Returns all parents of element with number $ID.
	*
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @param array $fields needed fields (if is): array('filed1 name', 'filed2 name', etc)
	* @param integer $cache Recordset is cached for $cache microseconds
	* @param integer $ID Node unique id
	* @return array - [0] => array(id, left, right, level, additional fields), [1] => array(...), etc.
	*/
	public function Parents($ID, $fields, $condition = '', $cache = false){
		if(is_array($fields)){
			$fields = 'A.'.implode(', A.', $fields);
		}else{
			$fields = 'A.*';
		}
		if(!empty($condition)){
			$condition = $this->_PrepareCondition($condition, false, 'A.');
		}
		$sql = 'SELECT '.$fields.', CASE WHEN A.'.$this->table_left.' + 1 < A.'.$this->table_right.' THEN 1 ELSE 0 END AS nflag FROM '.$this->table.' A, '.$this->table.' B WHERE B.'.$this->table_id.' = '.(int)$ID.' AND B.'.$this->table_left.' BETWEEN A.'.$this->table_left.' AND A.'.$this->table_right;
		$sql .= $condition;
		$sql .= ' ORDER BY A.'.$this->table_left;
		if(false === DB_CACHE || false === $cache || 0 == (int)$cache){
			$res = $this->db->Execute($sql);
		}else{
			$res = $this->db->CacheExecute((int)$cache, $sql);
		}
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return false;
		}
		$this->res = $res;
		return true;
	}
	/**
	* Returns a slightly opened tree from an element with number $ID.
	*
	* @param array $condition Array structure: array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc where array key - condition (AND, OR, etc), value - condition string
	* @param array $fields needed fields (if is): array('filed1 name', 'filed2 name', etc)
	* @param integer $cache Recordset is cached for $cache microseconds
	* @param integer $ID Node unique id
	* @return array - [0] => array(id, left, right, level, additional fields), [1] => array(...), etc.
	*/
	public function Ajar($ID, $fields, $condition = '', $cache = false){
		if(is_array($fields)){
			$fields = 'A.'.implode(', A.', $fields);
		}else{
			$fields = 'A.*';
		}
		$condition1 = '';
		if(!empty($condition)){
			$condition1 = $this->_PrepareCondition($condition, false, 'B.');
		}
		$sql = 'SELECT A.'.$this->table_left.', A.'.$this->table_right.', A.'.$this->table_level.' FROM '.$this->table.' A, '.$this->table.' B '.'WHERE B.'.$this->table_id.' = '.(int)$ID.' AND B.'.$this->table_left.' BETWEEN A.'.$this->table_left.' AND A.'.$this->table_right;
		$sql .= $condition1;
		$sql .= ' ORDER BY A.'.$this->table_left;
		if(false === DB_CACHE || false === $cache || 0 == (int)$cache){
			$res = $this->db->Execute($sql);
		}else{
			$res = $this->db->CacheExecute((int)$cache, $sql);
		}
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return false;
		}
		if(0 == $res->RecordCount()){
			$this->ERRORS_MES[] = _('no_element_in_tree');
			return false;
		}
		$alen = $res->RecordCount();
		$i = 0;
		if(is_array($fields)){
			$fields = implode(', ', $fields);
		}else{
			$fields = '*';
		}
		if(!empty($condition)){
			$condition1 = $this->_PrepareCondition($condition, false);
		}
		$sql = 'SELECT '.$fields.' FROM '.$this->table.' WHERE ('.$this->table_level.' = 1';
		while($row = $res->FetchRow()){
			if((++$i == $alen) && ($row[$this->table_left] + 1) == $row[$this->table_right]){
				break;
			}
			$sql .= ' OR ('.$this->table_level.' = '.($row[$this->table_level] + 1).' AND '.$this->table_left.' > '.$row[$this->table_left].' AND '.$this->table_right.' < '.$row[$this->table_right].')';
		}
		$sql .= ') '.$condition1;
		$sql .= ' ORDER BY '.$this->table_left;
		if(false === DB_CACHE || false === $cache || 0 == (int)$cache){
			$res = $this->db->Execute($sql);
		}else{
			$res = $this->db->CacheExecute($cache, $sql);
		}
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			return false;
		}
		$this->res = $res;
		return true;
	}

	public function Update($id_category, $arr){
		$sql = "UPDATE ".$this->table."
			SET `name` = ".$this->db->Quote($arr['name']).",
			`category_img` = ".$this->db->Quote($arr['category_img']).",
			`category_banner` = ".$this->db->Quote($arr['category_banner']).",
			`banner_href` = ".$this->db->Quote($arr['banner_href']).",
			`edit_user` = '".$_SESSION['member']['id_user']."',
			`edit_date` = '".date('Y-m-d H:i:s')."',
			`art` = '".$arr['art']."',
			`content` = ".$this->db->Quote($arr['content']).",
			`pid` = '".$arr['pid']."',
			`visible` = '".$arr['visible']."',
			`filial_link` = ".$this->db->Quote($arr['filial_link']).",
			`prom_id` = '".$arr['prom_id']."',
			`page_title` = ".$this->db->Quote($arr['page_title']).",
			`page_description` = ".$this->db->Quote($arr['page_description']).",
			`page_keywords` = ".$this->db->Quote($arr['page_keywords']).",
			`indexation` = '".$arr['indexation']."'
			WHERE ".$this->table_id." = ".$id_category;
			// print_r($sql);die();
		$this->db->StartTrans();
		if(!$this->db->Execute($sql)){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		if($arr['old_pid'] <> $arr['pid']){
			$this->MoveAll($id_category, $arr['pid']);
		}
		return true;
	}

	public function UpdateEditUserDate($id_category){
		$sql = "UPDATE ".$this->table."
		SET `edit_user` = \"{$_SESSION['member']['id_user']}\",
			`edit_date` = \"".date('Y-m-d H:i:s')."\"
			WHERE ".$this->table_id." = $id_category";
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function UpdateTranslit($id_category){
		$this->db->StartTrans();
		$cat = $this->Full(array('name'), array('and' => array('id_category = '.$id_category)));
		$translit = G::StrToTrans($cat[0]['name']);
		$sql = "UPDATE ".$this->table."
			SET `edit_user` = \"{$_SESSION['member']['id_user']}\",
			`edit_date` = \"".date('Y-m-d H:i:s')."\",
			`translit` = \"".$translit."\"
			WHERE ".$this->table_id." = $id_category";
		$this->db->StartTrans();
		$res = $this->db->Execute($sql);
		if(false === $res){
			$this->ERRORS[] = array(2, 'SQL query error.', __FILE__.'::'.__CLASS__.'::'.__FUNCTION__.'::'.__LINE__, 'SQL QUERY: '.$sql, 'SQL ERROR: '.$this->db->ErrorMsg());
			$this->ERRORS_MES[] = extension_loaded('gettext') ? _('internal_error') : 'internal_error';
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return $translit;
	}

	public function GetTranslitById($id_category){
		$sql = "SELECT translit FROM xt_category  WHERE id_category = ".$id_category;
		//
		$res = $this->db->GetOneRowArray($sql);
		return $res;
	}

	public function GetNameById($id_category){
		$sql = "SELECT name FROM xt_category  WHERE id_category = ".$id_category;
		//
		$res = $this->db->GetOneRowArray($sql);
		return $res;
	}

	/**
	* Returns amount of lines in result.
	*
	* @return integer
	*/
	public function RecordCount(){
		return $this->res->RecordCount();
	}
	/**
	* Returns the current row.
	*
	* @return array
	*/
	public function NextRow(){
		return $this->res->FetchRow();
	}
	/**
	* Transform array with conditions to SQL query
	* Array structure:
	* array('and' => array('id = 0', 'id2 >= 3'), 'or' => array('sec = \'www\'', 'sec2 <> \'erere\'')), etc
	* where array key - condition (AND, OR, etc), value - condition string.
	*
	* @param array $condition
	* @param string $prefix
	* @param bool $where - true - yes, flase - not
	* @return string
	*/
	private function _PrepareCondition($condition, $where = false, $prefix = ''){
		if(!is_array($condition)){
			return $condition;
		}
		$sql = ' ';
		if(true === $where){
			$sql .= 'WHERE '.$prefix;
		}
		$keys = array_keys($condition);
		for($i = 0;$i < count($keys);$i++){
			if(false === $where || (true === $where && $i > 0)){
				$sql .= ' '.strtoupper($keys[$i]).' '.$prefix;
			}
			$sql .= implode(' '.strtoupper($keys[$i]).' '.$prefix, $condition[$keys[$i]]);
		}
		return $sql;
	}

	public function CheckParent($rewrite, $fields = null){
	   if(is_array($fields)){
			$fields = implode(', ', $fields);
		}else{
			$fields = '*';
		}
		$sql = 'SELECT '.$fields.' FROM '.$this->table.' WHERE '.(is_numeric($rewrite)?'id_category = '.$this->db->Quote($rewrite):'translit = '.$this->db->Quote($rewrite)).' AND visible = 1 ORDER BY '.$this->table_left;
		$res = $this->db->GetOneRowArray($sql);
		return $res;
	}

	public function GetCats($fields, $level){
		if(is_array($fields)){
			$fields = implode(', ', $fields);
		}else{
			$fields = '*';
		}
		$sql = 'SELECT '.$fields.' FROM '.$this->table.' WHERE '.$this->table_level.' = '.$level.' AND visible = 1 ORDER BY position';
		$res = $this->db->GetArray($sql);
		return $res;
	}

	public function GetSubCats($ID, $fields){
		if(is_array($fields)){
			$fields = implode(', ', $fields);
		}else{
			$fields = '*';
		}
		$sql = 'SELECT '.$fields.' FROM '.$this->table.' WHERE pid = '.$ID.' AND visible = 1 ORDER BY position';
		$res = $this->db->GetArray($sql);
		return $res;
	}

	public function GetAllCats($fields, $level){
		if(is_array($fields)){
			$fields = implode(', ', $fields);
		}else{
			$fields = '*';
		}
		$sql = 'SELECT '.$fields.' FROM '.$this->table.' WHERE '.$this->table_level.' = '.$level.' ORDER BY position';
		$res = $this->db->GetArray($sql);
		return $res;
	}

	public function GetAllSubCats($ID, $fields){
		$ID = $this->db->Quote($ID);
		if(is_array($fields)){
			$fields = implode(', ', $fields);
		}else{
			$fields = '*';
		}
		$sql = 'SELECT '.$fields.' FROM '.$this->table.' WHERE xt_category.pid = '.$ID.' ORDER BY position';
		$res = $this->db->GetArray($sql);
		return $res;
	}

	//Обновление позиции категории
	public function UpdateCatPosition($pos, $cat_id){
		$category_id = $this->db->Quote($cat_id);
		$position = $this->db->Quote($pos);
		$sql = 'UPDATE xt_category SET position = '.$position.' WHERE id_category = '.$category_id;
		$this->db->StartTrans();
		if(!$this->db->Execute($sql)){
			$this->db->FailTrans();
			return false;
		}
		$this->db->CompleteTrans();
		return true;
	}

	public function GetTagsLevelsList($category_id){
		$category_id = $this->db->Quote($category_id);
		$sql = 'SELECT tag_level, tag_level_name FROM xt_category_tags WHERE id_category = '.$category_id.' GROUP BY tag_level ORDER BY tag_level, tag_level_name';
		$res = $this->db->GetArray($sql);
		return $res;
	}

	public function GetTagsList($category_id, $tag_level){
		$category_id = $this->db->Quote($category_id);
		$tag_level = $this->db->Quote($tag_level);
		$sql = 'SELECT * FROM xt_category_tags WHERE id_category = '.$category_id.' AND tag_level = '.$tag_level.' ORDER BY tag_level, tag_name';
		$res = $this->db->GetArray($sql);
		return $res;
	}

	public function GetTagById($tag_id){
		$tag_id = $this->db->Quote($tag_id);
		$sql = 'SELECT * FROM xt_category_tags WHERE tag_id = '.$tag_id;
		$res = $this->db->GetOneRowArray($sql);
		return $res;
	}

	public function DropTagById($tag_id){
		$tag_id = $this->db->Quote($tag_id);
		$sql = 'DELETE FROM xt_category_tags WHERE tag_id = '.$tag_id;
		$this->db->StartTrans();
		if($this->db->Execute($sql)){
			$this->db->CompleteTrans();
			return true;
		}else{
			$this->db->FailTrans();
			return false;
		}
	}

	public function DropLevelById($category_id, $tag_level){
		$category_id = $this->db->Quote($category_id);
		$tag_level = $this->db->Quote($tag_level);
		$sql = 'DELETE FROM xt_category_tags WHERE tag_level = '.$tag_level.' AND id_category = '.$category_id;
		$this->db->StartTrans();
		if($this->db->Execute($sql)){
			$this->db->CompleteTrans();
			return true;
		}else{
			$this->db->FailTrans();
			return false;
		}
	}

	public function AddTags($category_id, $name, $keys, $level, $level_name){
		$category_id = $this->db->Quote($category_id);
		$name = $this->db->Quote($name);
		$keys = $this->db->Quote($keys);
		$level = $this->db->Quote($level);
		$level_name = $this->db->Quote($level_name);
		$sql = 'INSERT INTO xt_category_tags (id_category, tag_name, tag_keys, tag_level, tag_level_name) VALUES ('.$category_id.', '.$name.', '.$keys.', '.$level.', '.$level_name.')';
		$this->db->StartTrans();
		if($this->db->Execute($sql)){
			$this->db->CompleteTrans();
			return true;
		}else{
			$this->db->FailTrans();
			return false;
		}
	}

	public function UpdateTags($tag_id, $category_id, $name, $keys, $level, $level_name){
		$tag_id = $this->db->Quote($tag_id);
		$category_id = $this->db->Quote($category_id);
		$name = $this->db->Quote($name);
		$keys = $this->db->Quote($keys);
		$level = $this->db->Quote($level);
		$level_name = $this->db->Quote($level_name);
		$sql = 'UPDATE xt_category_tags SET id_category = '.$category_id.', tag_name = '.$name.', tag_keys = '.$keys.', tag_level = '.$level.', tag_level_name = '.$level_name.' WHERE tag_id = '.$tag_id;
		$this->db->StartTrans();
		if($this->db->Execute($sql)){
			$this->db->CompleteTrans();
			return true;
		}else{
			$this->db->FailTrans();
			return false;
		}
	}

	public function UpdateLevelById($category_id, $level, $level_name){
		$category_id = $this->db->Quote($category_id);
		$level = $this->db->Quote($level);
		$level_name = $this->db->Quote($level_name);
		$sql = 'UPDATE xt_category_tags SET tag_level_name = '.$level_name.' WHERE tag_level = '.$level.' AND id_category = '.$category_id;
		$this->db->StartTrans();
		if($this->db->Execute($sql)){
			$this->db->CompleteTrans();
			return true;
		}else{
			$this->db->FailTrans();
			return false;
		}
	}

	public function GetActiveCats(){
		$sql = "SELECT c.*, COUNT(p.id_product) AS products
			FROM ".$this->table." AS c
			LEFT JOIN "._DB_PREFIX_."cat_prod AS cp
				ON cp.id_category = c.id_category
			LEFT JOIN "._DB_PREFIX_."product AS p
				ON p.id_product = cp.id_product
			WHERE c.visible = 1
			AND (SELECT COUNT(c2.id_category)
				FROM ".$this->table." AS c2
				WHERE c.id_category = c2.pid) = 0
			AND p.price_mopt > 0
			AND p.visible = 1
			AND p.min_mopt_qty = 1
			GROUP BY c.id_category
			ORDER BY c.art";
		if(!$res = $this->db->GetArray($sql)){
			return false;
		}
		return $res;
	}
}?>