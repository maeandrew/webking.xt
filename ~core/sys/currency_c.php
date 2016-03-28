<?php
class Currency {
	private $db;

	public $list;
	public $fields;

	public function __construct(){
		$this->db =& $GLOBALS['db'];
	}
	

}?>