<?php

class db_query {
	function __construct($file = null) {
		if($file == null) {
			$config = require(ROOT_PATH . INCLUDE_DIR . 'config.php');
		} else {
			$config = require(ROOT_PATH . INCLUDE_DIR . 'config2.php');
		}

		try	{
			if($file == null) {
				$this->db = new PDO("mysql:host=".$config['host'].";dbname=".$config['db'].";port=".$config['port'].";charset=utf8",$config['user'],$config['pass'],[PDO::ATTR_EMULATE_PREPARES => FALSE, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
			} else {
				$this->db = new PDO("mysql:host=".$config['host'].";dbname=".$config['db'].";port=".$config['port'].";charset=utf8",$config['user'],$config['pass'],[PDO::ATTR_EMULATE_PREPARES => FALSE, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
			}
			
			$this->query = require(ROOT_PATH . INCLUDE_DIR . 'query.php');
		} catch(PDOexception $error) {
			echo "Error login to database! <br>" . $error->getMessage();			
			exit();
		}
	}
	
	public function returnQuery($content) {
		if(isset($this->query[$content])) {
			return $this->query[$content];
		} else {
			echo "This query dont exist";
			exit;
		}
	}
	
	public function beginTransaction() {
		$this->db->beginTransaction();
	}
	
	public function commit() {
		$this->db->commit();
	}
		
	public function rollBack() {
		$this->db->rollBack();
	}
		
	public function fetch_all($query) {
			$this->result = $this->db->query($query);
			return $this->rows($this->result->rowCount() > 0);
		}
	
	public function prep_query($query, $parametrs) {
		$this->result = $this->db->prepare($query);
		$this->check($parametrs);
		$this->result->execute();
		
		return $this->rows($this->result->rowCount() > 0);
	}
	
	private function rows($rows) {
		if(!false) {
			$this->row = 1;
			return $this->result->fetchALL();
		} else {
			return false;
		}
	}
		
	public function readCount() {
		return $this->row;
	}
	
	public function CountRow() {
		return $this->result->rowCount();
	}
	
	
	private function check($string) {
		$list_param = explode(';',$string);
			
		foreach($list_param as $list) {
			$list_detail = explode('&',$list);
			
			if($list_detail[2] == "STR") {
				$this->result->bindParam(':'.$list_detail[0],$list_detail[1], PDO::PARAM_STR);
			} else {
				$this->result->bindParam(':'.$list_detail[0],$list_detail[1], PDO::PARAM_INT);
			}	
		}
	}
		
	public function last_id() {
		return $this->db->lastInsertId();
	}
	
	public function fetch_exception($query) {
		try{
			$this->result = $this->db->query($query);
			return $this->rows($this->result->rowCount() > 0);
		} catch(PDOexception $error) {
			echo $error->getMessage();
			exit;
		}
	}
	
	public function prep_exception($query, $parametrs) {
		try{
			$this->result = $this->db->prepare($query);
			$this->check($parametrs);
			$this->result->execute();
			
			return $this->rows($this->result->rowCount() > 0);
			
		} catch(PDOexception $error) {
			echo $error->getMessage();
			exit;
		}
	}
}

?>