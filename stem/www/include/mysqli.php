<?php
class MySQL {
	var $connect;
	var $prefix;
	var $debug;
	
	public function __construct($host, $port, $db, $user, $pass, $socket = false, $prefix = 'kt_') {
		//$this->debug = ($_SERVER['REMOTE_ADDR'] == '192.168.1.108');
	
		$this->prefix = $prefix;
		
		if ($socket) {
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
				$this->connect = new mysqli('.', $user, $pass, $db);
			} else {
				$this->connect = new mysqli(null, $user, $pass, $db, null, '/var/lib/mysql/mysql.sock');
			}
		} else {
			$this->connect = new mysqli($host, $user, $pass, $db, $port);
		}
		
		if (mysqli_connect_errno()) {
			return $this->error();
		}
		
		return true;
	}
	
	public function selectDB($db) {
		return $this->connect->select_db($db);
	}
	
	function query($query, $array = false) {
		if ($this->debug) print "QUERY!{$query}\n\n";
		$querya = $this->connect->query($query);
		if ($querya === false) return $this->error();
		if ($array) return $this->fetchRows($querya, MYSQL_ASSOC);
		
		return $querya;
	}
	
	public function getRow($query) {
		if ($this->debug) print 'getRow';
		$querya = $this->connect->query($query);
		if ($querya === false) return $this->error();
		$row = $querya->fetch_assoc();
		$this->free($querya);
		return $row;
	}
	
	public function getValue($query, $col) {
		if ($this->debug) print 'getVal';
		$querya = $this->connect->query($query);
		if ($querya === false) return $this->error();
		$row = $querya->fetch_assoc();
		$this->free($querya);
		if ($row == false) return null;
		return $row[$col];
	}
	
	public function DEBUG($query) {
		print_r($this->query($query, true));
	}
	
	public function free($query) {
		return $query->free();
	}
	
	function setResource($sql) {
		$this->connect = $sql;
	}
	
	function escape($string) {
		return $this->connect->real_escape_string($string);
	}
	
	function fetchRows($result, $numass = MYSQLI_BOTH) {
		$got = array();

		if($result->num_rows == 0) {
			$this->free($result);
			return $got;
		}

		$result->data_seek(0);

		while ($row = $result->fetch_array($numass)) {
			array_push($got, $row);
		}

		$this->free($result);

		return $got;
	}
	
	private function error() {
		return $this->connect->error;
	}
	
	public function setTablePrefix($prefix) {
		$this->prefix = $prefix;
	}
	
	public function getTablePrefix() {
		return $this->prefix;
	}
}