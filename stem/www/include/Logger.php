<?php
abstract class Logger {
	protected static $instance;
	
	public function error($msg, $data = array()) {
		return $this->log('ERROR: ' . $msg, $data);
	}
	
	public function notice($msg, $data = array()) {
		return $this->log('NOTICE: ' . $msg, $data);
	}
	
	abstract protected function log($msg, $data);
	abstract public static function getInstance();
}