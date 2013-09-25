<?php
require($_SERVER['DOCUMENT_ROOT'].'/config.php');
require($_SERVER['DOCUMENT_ROOT'].'/include/mysql.php');
$db = new MySQL($dbhost, $dbport, $dbname, $dbuser, $dbpass);
class session {
	var $sessionID;
	var $data = array();
	// -1 = not at all
	// 0 = guest
	// 1 = logged in
	var $logged_in;
	var $permissions = array();
	var $ip;
	var $debug;
	var $sdata;
	
	public function __construct() {
		global $_SESSION;
		$this->ip = preg_replace('/[^0-9.]/', '', $_SERVER['REMOTE_ADDR']);
		$this->debug = ($this->ip == '192.168.1.101');
		$this->loggedIn = -1;
		if (empty($_SESSION['kt'])) $_SESSION['kt'] = array();
		$this->sdata = &$_SESSION['kt'];
		$this->permissions = array();
		$this->data = array();
	}
	
	private function updateData($key, $value) {
		$this->data[$key] = $this->sdata[$key] = $value;
	}
	
	private function loadUserData($user_id) {
		global $db;
		$user = $db->query("SELECT * FROM `kt_users` WHERE user_id = '{$user_id}'", true);
		if (empty($user)) { 
			if ($this->debug) print 'user not found';
			return false;
		}
		
		return $user;
	}
	
	public function session_go() {
		global $db, $_COOKIE;
		
		//$this->ip = preg_replace('/[^0-9.]/', '', $_SERVER['REMOTE_ADDR']);
		
		$this->loggedIn = -1;
		
		// TODO: Fix IP Hijacking Exploit
		if (!isset($_COOKIE['1_kt_sid'])) {
			if ($this->debug) print 'does not have ktsid cookie';
			/*$sesssql = "SELECT session_id, session_time FROM `kt_sessions` WHERE session_ip = '{$this->ip}'";
			$session = $db->query($sesssql, true);
			// If no valid sessions were found, make a new one
			if (empty($session)) { if ($this->debug) print 'existing session not found'; return $this->createSession($this->sdata); }
			
			foreach ($session as $id => $data) {
				if ($data['session_time'] > time() - 60*60*24*7) { $ok = $id; break; }
				if ($this->debug) print 'no valid sessions found';
				return $this->createSession($this->sdata);
			}
			if (!isset($ok)) { if ($this->debug) print 'no valid sessions found'; return $this->createSession($this->sdata); }
			$sesssql1 = "SELECT * FROM `kt_sessions` WHERE session_id = '{$session[$ok]['session_id']}'";
			$session2 = $db->query($sesssql1, true);*/
			return $this->createSession();
		} else {
			if ($this->debug) print 'cookie found';
			$cookie = mysql_real_escape_string($_COOKIE['1_kt_sid']);
			$sesssql1 = "SELECT * FROM `kt_sessions` WHERE session_id = '{$cookie}' AND session_ip = '{$this->ip}'";
			$session2 = $db->query($sesssql1, true);
			if (empty($session2)) { 
				if ($this->debug) print 'cookie invalid'; 
				setcookie('1_kt_sid', '', time() - 3600, '/'); 
				return $this->createSession(); 
			}
		}
		
		$session2 = $session2[0];
		//print_r($session2);
		$this->setSessionID($session2['session_id']);
		$data = explode(',', $session2['session_data']);
		foreach ($data as $id => $value) $data[$id] = explode('=', $value);
		foreach ($data as $id => $value) $data2[$value[0]] = $value[1];
		
		if ($session2['session_user_id'] == 0) {
			$this->updateData('isGuest', true);
			$this->updateData('logged_in', 0); $this->loggedIn = 0;
		} else {
			$this->updateData('logged_in', 1); $this->loggedIn = 1;
		}
		
		$user = $this->loadUserData($session2['session_user_id']);
		if ($user === false) {
			$this->logout();
		}
		$perm = explode(',', $user[0]['user_permissions']);
		$this->permissions = $perm;
		
		$this->data = array_merge($data2, $this->data);
		$this->data = array_merge($this->sdata, $this->data);
		$this->sdata = $this->data;
		$this->updateSession();
		
		if (!isset($_COOKIE['1_kt_sid'])) {
			header('Set-Cookie: '.rawurlencode('1_kt_sid').'='.rawurlencode($this->getSessionID()).'; Max-Age='.(time() + 60*60*24*7).'; Path=/');
		}
		
		return true;
	}
		
	public function logout() {
		global $db;
		if ($this->isLoggedIn()) {
			$this->setLoggedIn(-1);
			$sid = $this->getSessionID();
			header('Set-Cookie: '.rawurlencode('1_kt_sid').'=; Max-Age='.(time() - 60*60).'; Path=/');
			$db->query("DELETE FROM `kt_sessions` WHERE `session_id` = '{$sid}'");
			$this->sdata = array();
			$this->__construct();
			return true;
		} else { // not logged in. why are you calling it
			return false;
		}
	}
	
	// Creates a new session. 
	private function createSession() {
		global $db;
		$time = time();
		//$this->ip = preg_replace('/[^0-9.]/', '', $_SERVER['REMOTE_ADDR']);
		$useragent = mysql_real_escape_string(((isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'None'));
		$sid = $time.$this->ip.rand(0,100);
		$sid = md5(base64_encode($sid));
		
		$this->data['session_id'] = $sid;
		$this->data['session_time'] = $time;
		$this->data = array_merge($this->sdata, $this->data);
		$this->sdata = $this->data;
		$this->setSessionID($sid);
		
		$data = '';
		foreach ($this->data as $id => $value) {
			if ($value != 'logged_in') $data .= mysql_real_escape_string((string) $id).'='.mysql_real_escape_string((string) $value).',';
		}
		$data = substr($data, 0, strlen($data)-1);
		
		$sesssql = "INSERT INTO `kt_sessions` VALUES ('{$sid}', '0', '0', '{$time}', '{$time}', '{$this->ip}', '{$useragent}', '', '{$data}')";
		$session = $db->query($sesssql);
		
		header('Set-Cookie: '.rawurlencode('1_kt_sid').'='.rawurlencode($this->getSessionID()).'; Max-Age='.(time() + 60*60*24*7).'; Path=/'); 
		
		$this->updateData('isGuest', true);
		$this->updateData('logged_in', 0); $this->loggedIn = 0;
		
		if (!$session) return $session;
		return true;
	}
	
	public function updateSession() {
		global $db;
		if (!isset($this->sdata['user_id']) || !isset($this->sdata['lastvisit'])) return false;
		$this->data = array_merge($this->sdata, $this->data);
		
		$data = '';
		foreach ($this->data as $id => $value) {
			if ($value != 'logged_in') $data .= mysql_real_escape_string((string) $id).'='.mysql_real_escape_string((string) $value).',';
		}
		$data = substr($data, 0, strlen($data)-1);
		
		$userid = $this->sdata['user_id'];
		$lastvisit = $this->sdata['lastvisit'];
		$sid = $this->getSessionID();
		$updatesql = "UPDATE `kt_sessions` SET session_user_id = '{$userid}', session_last_visit = '{$lastvisit}', session_data = '{$data}' WHERE session_id = '{$sid}'";
		$update = $db->query($updatesql);
		
		if (!$update) return $update;
		return true;
	}
	
	public function getSessionID() {
		return $this->sessionID;
	}
	
	public function setSessionID($sid) {
		$this->sessionID = $sid;
	}
	
	public function isLoggedIn() {
		return $this->logged_in === 1;
	}
	
	public function setLoggedIn($login) {
		$this->logged_in = $login;
		$this->updateData('logged_in', $login);
	}
	
	public function getUsername() {
		return $this->data['username'];
	}
	
	public function getData($key) {
		return $this->data[$key];
	}
	
	public function hasPermission($acl) {
		return in_array($acl, $this->permissions);
	}
	
	public function addPermission($acl) {
		global $db;
		$this->permissions[] = $acl;
		$perm = $db->escape(implode(',', $this->permissions));
		return $db->query("UPDATE kt_users SET user_permissions = '{$perm}'");
	}
	
	public function is($user) {
		return $this->getData('username') == $user || $this->getData('user_id') == $user;
	}
}

/**
*	The user class, which provides all functions available for users.
*/
class user extends session {
	
}
?>