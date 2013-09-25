<?php

if (!class_exists('Logger')) die;

class MySQLLogger extends Logger {
	private $db;
	private $tableName;
	
	public static function getInstance() {
		if (!isset($instance)) $instance = new MySQLLogger();
		return $instance;
	}
	
	public function linkDB(&$dbLink) {
		$this->db = $dbLink;
	}
	
	public function setTableName($tbl) {
		if (!isset($this->db)) throw_error('DB not linked');
		$this->tableName = $tbl;
	}
	
	protected function log($msg, $data) {
		if (!isset($this->db)) throw_error('DB not linked');
		$dataSer = (empty($data) ? '' : serialize($data));
		$msg= $this->db->escape($msg);
		$ip = $this->db->escape($_SERVER['REMOTE_ADDR']);
		$uri= $this->db->escape($_SERVER['REQUEST_URI']);
		$time = time();
		
		return $this->db->query("INSERT INTO `{$this->tableName}` 
					(log_ip, log_time, log_uri, log_data, log_msg)
					VALUES ('{$ip}', {$time}, '{$uri}', '{$dataSer}', '{$msg}')");
	}
}