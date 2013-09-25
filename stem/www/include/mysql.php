<?php
class MySQL {
	var $connect;
	var $prefix;
	var $debug;
	
	public function __construct($host, $port = '3306', $db, $user, $pass, $prefix = 'kt_') {
		//$this->debug = ($_SERVER['REMOTE_ADDR'] == '192.168.1.108');
	
		$this->prefix = $prefix;
		
		$con = '.';
		if ($host != null) {
			$con = $host . ':' . $port;
		}
		
		if ($this->connect = @mysql_connect($con, $user, $pass)) {
			if (@mysql_select_db($db)) {
				return $this->connect;
			}
		}
		return $this->error();
	}
	
	public function selectDB($db) {
		return mysql_select_db($db);
	}
	
	function query($query, $array = false) {
		if ($this->debug) print "QUERY!{$query}\n\n";
		$querya = @mysql_query($query, $this->connect);
		if ($querya === false) return $this->error();
		if ($array) return $this->fetchRows($querya, MYSQL_ASSOC);
		
		return $querya;
	}
	
	public function getRow($query) {
		if ($this->debug) print 'getRow';
		$querya = @mysql_query($query, $this->connect);
		if ($querya === false) return $this->error();
		$row = mysql_fetch_assoc($querya);
		$this->free($querya);
		return $row;
	}
	
	public function getValue($query, $col) {
		if ($this->debug) print 'getVal';
		$querya = @mysql_query($query, $this->connect);
		if ($querya === false) return $this->error();
		$row = mysql_fetch_assoc($querya);
		$this->free($querya);
		if ($row == false) return null;
		return $row[$col];
	}
	
	public function DEBUG($query) {
		print_r($this->query($query, true));
	}
	
	public function free($query) {
		return mysql_free_result($query);
	}
	
	function setResource($sql) {
		$this->connect = $sql;
	}
	
	function escape($string) {
		return mysql_real_escape_string($string, $this->connect);
	}
	
	function fetchRows($result, $numass = MYSQL_BOTH) {
		$got = array();

		if(mysql_num_rows($result) == 0) {
			$this->free($result);
			return $got;
		}

		mysql_data_seek($result, 0);

		while ($row = mysql_fetch_array($result, $numass)) {
			array_push($got, $row);
		}

		$this->free($result);

		return $got;
	}
	
	private function error() {
		return mysql_error($this->connect);
	}
	
	public function setTablePrefix($prefix) {
		$this->prefix = $prefix;
	}
	
	public function getTablePrefix() {
		return $this->prefix;
	}
}