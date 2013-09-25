<?php
class session {
	var $sessionID;
	var $data = array();
	// -1 = not at all
	// 0 = guest
	// 1 = logged in
	var $loggedIn;
	var $permissions = array();
	var $ip;
	var $debug;
	var $sdata;
	var $db;
	var $userTable = 'kt_users';
	var $sessionTable = 'kt_sessions';
	
	public function __construct() {
		global $_SESSION;
		$this->ip = preg_replace('/[^0-9.]/', '', $_SERVER['REMOTE_ADDR']);
		$this->debug = ($this->ip == '192.168.1.108');
		$this->loggedIn = -1;
		if (empty($_SESSION['kt'])) $_SESSION['kt'] = array();
		$this->sdata = &$_SESSION['kt'];
		$this->permissions = array();
		$this->data = array();
	}
	
	public function linkDB(&$db) {
		$this->db = $db;
	}
	
	public function setData($key, $value, $update = true) {
		$this->data[$key] = $this->sdata[$key] = $value;
		if ($update) $this->updateSession();
	}
	
	private function loadUserData($user_id) {
		global $db;
		$user = $this->db->query("SELECT * FROM `".$this->userTable."` WHERE user_id = '{$user_id}'", true);
		if (empty($user)) { 
			if ($this->debug) print 'user not found';
			return false;
		}
		
		return $user;
	}
	
	public function startSession() {
		global $db, $_COOKIE;
		if ($this->db == null) $this->db = &$db;
		
		//$this->ip = preg_replace('/[^0-9.]/', '', $_SERVER['REMOTE_ADDR']);
		
		$this->setLoggedIn(-1);
		
		// TODO: Fix IP Hijacking Exploit
		if (!isset($_COOKIE['1_kt_sid'])) {
			if ($this->debug) print 'does not have ktsid cookie';
			/*$sesssql = "SELECT session_id, session_time FROM `".$this->sessionTable."` WHERE session_ip = '{$this->ip}'";
			$session = $this->db->query($sesssql, true);
			// If no valid sessions were found, make a new one
			if (empty($session)) { if ($this->debug) print 'existing session not found'; return $this->createSession($this->sdata); }
			
			foreach ($session as $id => $data) {
				if ($data['session_time'] > time() - 60*60*24*7) { $ok = $id; break; }
				if ($this->debug) print 'no valid sessions found';
				return $this->createSession($this->sdata);
			}
			if (!isset($ok)) { if ($this->debug) print 'no valid sessions found'; return $this->createSession($this->sdata); }
			$sesssql1 = "SELECT * FROM `".$this->sessionTable."` WHERE session_id = '{$session[$ok]['session_id']}'";
			$session2 = $this->db->query($sesssql1, true);*/
			return $this->createSession();
		} else {
			if ($this->debug) print 'cookie found';
			$cookie = $this->db->escape($_COOKIE['1_kt_sid']);
			$sesssql1 = "SELECT * FROM `".$this->sessionTable."` sess, `".$this->userTable."` usr 
				WHERE sess.session_id = '{$cookie}' 
				AND sess.session_ip = '{$this->ip}'
				AND sess.session_user_id = usr.user_id";
			$session2 = $this->db->query($sesssql1, true);
			if (empty($session2)) { 
				if ($this->debug) print 'cookie invalid'; 
				setcookie('1_kt_sid', '', time() - 3600, '/'); 
				return $this->createSession(); 
			}
		}
		
		$session2 = $session2[0];
		//print_r($session2);
		$this->setSessionID($session2['session_id']);
		//$data = explode(',', $session2['session_data']);
		try { 
			$data2 = unserialize($session2['session_data']);
		} catch (ErrorException $e) {
			$this->db->query("DELETE FROM `".$this->sessionTable."` WHERE session_id = '{$this->sessionID}'");
			$this->setFlash('error', 'A terrible error has occured!');
			$this->redirect('/');
		}
		//foreach ($data as $id => $value) $data[$id] = explode('=', $value);
		//foreach ($data as $id => $value) $data2[$value[0]] = $value[1];
		
		$this->setLoggedIn(($session2['session_user_id'] == 0) ? 0 : 1);
		
		/*$user = $this->loadUserData($session2['session_user_id']);
		if ($user === false) {
			$this->logout();
		}*/
		$perm = explode(',', $session2['user_permissions']);
		$this->permissions = $perm;
		
		$this->data = array_merge($data2, $this->data);
		$this->data = array_merge($this->sdata, $this->data);
		$this->sdata = $this->data;
		$this->updateSession();
		
		if (!isset($_COOKIE['1_kt_sid'])) {
			setcookie('1_kt_sid', $this->getSessionID(), time() + 604800, '/'); 
		}
		
		if ($this->debug) print 'SID: ' . $this->data['session_id'];
		
		return true;
	}
		
	public function logout() {
		global $db;
		if ($this->isLoggedIn()) {
			$this->setLoggedIn(-1);
			
			$sid = $this->getSessionID();
			
			setcookie('1_kt_sid', '', time() - 3600, '/'); 
			
			$this->db->query("DELETE FROM `".$this->sessionTable."` WHERE `session_id` = '{$sid}'");
			$this->sdata = array();
			$this->__construct();
			return true;
		} else { // not logged in. why are you calling it
			return true;
		}
	}
	
	// Creates a new session. 
	private function createSession() {
		global $db;
		$time = time();
		//$this->ip = preg_replace('/[^0-9.]/', '', $_SERVER['REMOTE_ADDR']);
		$useragent = $this->db->escape(((isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'None'));
		$sid = $time.$this->ip.rand(0,100);
		$sid = md5(base64_encode($sid));
		
		$this->data['session_id'] = $sid;
		$this->data['session_time'] = $time;
		$this->data = array_merge($this->sdata, $this->data);
		$this->sdata = $this->data;
		$this->setSessionID($sid);
		
		$mdata = $this->data; 
		unset($mdata['logged_in']);
		$data = $this->db->escape(serialize($mdata));
		
		$sesssql = "INSERT INTO `".$this->sessionTable."` VALUES ('{$sid}', '0', '0', '{$time}', '{$time}', '{$this->ip}', '{$useragent}', '', '{$data}')";
		$session = $this->db->query($sesssql);
		
		setcookie('1_kt_sid', $this->getSessionID(), time() + 604800, '/'); 
		
		$this->setLoggedIn(0);
		
		if ($this->debug) print 'creating new session w/ SID: ' . $this->data['session_id'];
		
		if (!$session) return $session;
		return true;
	}
	
	public function updateSession() {
		global $db;
		if (!isset($this->sdata['user_id']) || !isset($this->sdata['lastvisit']) || empty($this->sessionID)) return false;
		$this->data = array_merge($this->sdata, $this->data);
		
		/*$data = '';
		foreach ($this->data as $id => $value) {
			if ($value != 'logged_in') $data .= $this->db->escape((string) $id).'='.$this->db->escape((string) $value);
		}
		$data = substr($data, 0, strlen($data)-1); //*/
		$mdata = $this->data; 
		unset($mdata['logged_in']);
		$data = $this->db->escape(serialize($mdata));
		
		$userid = $this->getData('user_id');
		$lastvisit = $this->getData('lastvisit');
		$sid = $this->getSessionID();
		$updatesql = "UPDATE `".$this->sessionTable."` SET session_user_id = '{$userid}', session_last_visit = '{$lastvisit}', session_data = '{$data}' WHERE session_id = '{$sid}'";
		$update = $this->db->query($updatesql);
		
		if (!$update) return $update;
		return true;
	}
	
	private function trimSessions() {
		global $db;
		$lastTrimTime = $this->db->getValue("SELECT `config_value` FROM `kt_config` WHERE `config_name` = 'lastTrimTime'", 'config_value');
		if ($lastTrimTime < time() - 60*60*24*7) {
			$this->db->query("DELETE FROM `".$this->sessionTable."` WHERE `session_last_visit` < " . time() - 60*60*24*7);
		}
	}
	
	public function redirect($url) {
		header("Location: {$url}");
		die;
	}
	
	public function getSessionID() {
		return $this->sessionID;
	}
	
	public function setSessionID($sid) {
		$this->sessionID = $sid;
	}
	
	public function isLoggedIn() {
		return $this->loggedIn === 1;
	}
	
	public function setLoggedIn($login) {
		$this->loggedIn = $login;
		$this->setData('logged_in', $login, false);
	}
	
	public function getUsername() {
		return $this->getData('username');
	}
	
	public function getID() {
		return (int) $this->getData('user_id');
	}
	
	public function getData($key) {
		if (array_key_exists($key, $this->data)) {
			return $this->data[$key];
		} else { 
			return null;
		}		
	}
	
	public function hasPermission($acl) {
		return in_array($acl, $this->permissions);
	}
	
	public function addPermission($acl) {
		global $db;
		$this->permissions[] = $acl;
		$perm = $this->db->escape(implode(',', $this->permissions));
		return $this->db->query("UPDATE ".$this->userTable." SET user_permissions = '{$perm}'");
	}
	
	public function is($user) {
		return $this->getData('username') == $user || $this->getData('user_id') == $user;
	}
	
	public function getUsernameByID($id) {
		global $db;
		$id = $this->db->escape($id);
		return $this->db->getValue("SELECT `username` FROM `".$this->userTable."` WHERE `user_id` = {$id}", 'username');
	}
	
	public function setFlash($severity, $str) {
		$_SESSION['flashtype'] = $severity;
		$_SESSION['flash'] = $str;
	}
	
	public function hasFlash() {
		return isset($_SESSION['flash']);
	}
	
	public function getFlashType() {
		$type = $_SESSION['flashtype'];
		unset($_SESSION['flashtype']);
		return $type;
	}
	
	public function getFlash() {
		$msg = $_SESSION['flash'];
		unset($_SESSION['flash']);
		return $msg;
	}
}

/**
*	The user class, which provides all functions available for users.
*/
class user extends session {
	
}
?>