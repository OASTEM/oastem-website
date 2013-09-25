<?php
// A class for cacheing data.
class Cache {
	private $lastRun;
	private $root;
	
	public function Cache() {
		$this->root = $_SERVER['DOCUMENT_ROOT'] . 'cache/';
	}
	
	public function crap() {}
}