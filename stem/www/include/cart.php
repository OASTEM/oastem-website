<?php
class Cart {
	var $db;
	var $user;
	var $table;
	var $cart = array();
	var $userId;
	
	public function __construct(&$theUser, &$dbLink, $dbTable = 'kt_cart') {
		$this->db = $dbLink;
		$this->user = $theUser;
		$this->table = $dbTable;
		$this->userId = $this->user->getSessionID();
		
		$this->refresh();
	}
	
	private function get($id) {
		$id = intval($id);
		if ($id == 0) {
			return false;
		}
		
		return $this->db->getValue("SELECT COUNT(*) FROM {$this->table} WHERE `product_id` = {$id} AND `user_id` = '{$this->userId}'", 'COUNT(*)');
	}
	
	public function add($id, $quantity = 1) {
		$id = intval($id);
		if ($id == 0) {
			return false;
		}
		
		if ($this->get($id) != 0) return $this->update($id, $quantity);
		
		$quantity = intval($quantity);
		if ($quantity == 0) {
			return false;
		}
		
		return $this->db->query("INSERT INTO {$this->table} VALUES (null, '{$this->userId}', {$id}, {$quantity})");
	}
	
	public function remove($id) {
		$id = intval($id);
		if ($id == 0) {
			return false;
		}
		
		return $this->db->query("DELETE FROM {$this->table} WHERE `product_id` = {$id} AND `user_id` = '{$this->userId}'");
	}
	
	public function update($id, $quantity = 1) {
		$id = intval($id);
		if ($id == 0) {
			return false;
		}
		
		$quantity = intval($quantity);
		if ($quantity == 0) {
			return false;
		}
		
		return $this->db->query("UPDATE {$this->table} SET `quantity` = quantity + {$quantity} 
			WHERE `product_id` = {$id} AND `user_id` = '{$this->userId}'");
	}
	
	public function set($id, $quantity = 1) {
		$id = intval($id);
		if ($id == 0) {
			return false;
		}
		
		$quantity = intval($quantity);
		if ($quantity == 0) {
			return false;
		}
		
		return $this->db->query("UPDATE {$this->table} SET `quantity` = {$quantity} 
			WHERE `product_id` = {$id} AND `user_id` = '{$this->userId}'");
	}
	
	public function getList() {
		$qCart = $this->db->query("SELECT product_id, quantity FROM {$this->table} WHERE `user_id` = '{$this->userId}'");

		$cart = array();
		while ($data = $qCart->fetch_array(MYSQLI_BOTH)) {
			$cart[$data['product_id']] = $data['quantity'];
		}
	
		return $cart;
	}
	
	public function calculateTotals() {
		$part = $this->db->getRow("SELECT SUM(p.price * c.quantity) AS subTotal, ROUND(SUM(p.price * c.quantity * 0.0775), 2) AS tax 
			FROM {$this->table} c, kt_products p 
			WHERE c.`user_id` = '{$this->userId}' AND p.`id` = c.`product_id`");
		
		$part['total'] = $part['subTotal'] + $part['tax'];
		
		return $part;
	}
	
	private function refresh() {
		return $this->db->query("SELECT * FROM {$this->table} WHERE `user_id` = '{$this->user->getID()}'", true);
	}
}