<?
//if ($_SERVER['SERVER_NAME'] == 'ums.sytes.net' && substr($_SERVER['REQUEST_URI'], 0, 3) != '/ms') { header('Location: /ms'.$_SERVER['REQUEST_URI']); die; }
//if ($_SERVER['SERVER_NAME'] == 'the.quotelog.co.cc') { header('Location: /qt-season/'.$_SERVER['REQUEST_URI']); die; }
//die;
trigger_error('Use of this function library is depreciated; the new foundation should be used');
//define('SERVER_SIGNATURE', '<i>'.$_SERVER['SERVER_SOFTWARE'].' Server Codename Windoze - PHP v'.PHP_VERSION.' via '.PHP_SAPI.'</i>');
class functions {
	var $connect;
	var $refer;
	var $data;
	//	var $logarr;
	function uberbar($text = null, $return = false) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/include/ktomegaland.lock')) { 
			if ($return) return '<div id="uberbar">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/include/ktomegaland.lock').'</div>';
			else { print '<div id="uberbar">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/include/ktomegaland.lock').'</div>'; return true; }
		} elseif (!is_null($text)) {
			if ($return) return '<div id="uberbar">'.$text.'</div>';
			else print '<div id="uberbar">'.$text.'</div>';
		} else return false;
	}
	function removeInjectionCode($string){
		$injections = array(">", "<", "=", "'", "?", "\\", "/",
		"&", "|","-", "+", "%", "$", "#", "*",
		"or", "and", "drop", "insert", "rename");

		$string = str_replace($injections, "", $string);
		
		return $string;
	} 
	function mkloginbox() {
		print <<<LOGIN_END
		<div id="outer"><div id="main">
		<form method="POST">
Username: <input type="text" name="username" /><br />
Password: <input type="password" name="password" /><br />
		<input type="submit" name="submit" value="Submit" />
		</form>
		</div></div>
LOGIN_END;
		/*
		session_start();
		if (isset($_COOKIE['loggedin'])) {
			$_SESSION['loggedin'] = $_COOKIE['loggedin'];
		} elseif (isset($_POST['submit'])) {
			if (!isset($_POST['username']) || !isset($_POST['password'])) {
				die('One field was not filled out correctly.');
			}
			if ($_POST['username'] != 'username') {
				die('Incorrect username.');
			} elseif ($_POST['password'] != 'password') {
				die('Incorrect password.');
			} elseif ($_POST['username'] == 'username' && $_POST['password'] == 'password') {
				$_SESSION['loggedin'] = true;
				setcookie('loggedin', $_SESSION['loggedin'], time()+3600*24*7, '/');
			}
		}
		*/
	}
	function mkheaderfs($mini = false, $css = '/css/new2.css', $title = 'Hax', $header1 = 'WHAT', $header2 = 'NINE THOUSAND', $uberbar = null, $head = null) {
		global $session;
		print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
";
		if (isset($head)) print $head;
		print "
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<link rel=\"StyleSheet\" href=\"{$css}\" type=\"text/css\" />
<script src=\"/js/mootools-release-1.11.js\" type=\"text/javascript\"></script>
<script src=\"/js/ktomegaland.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\">
var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");
document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));
</script>
<script type=\"text/javascript\">
try {
var pageTracker = _gat._getTracker(\"UA-10650242-2\");
pageTracker._trackPageview();
} catch(err) {}</script>
<title>{$title} - KTOmega Land</title>
</head>
<body>

";
		self::uberbar($uberbar);
		print "
<div id=\"container\">
<div id=\"logograd\">
	<div id=\"logo\">
		<div id=\"logotext\">
			<h1>{$header1}</h1>
			<h2>{$header2}</h2>
		</div>
	</div>
</div>
<div id=\"outer\">
	<div id=\"main\">
		<div id=\"nav\">";
		/*$this->sqllogin('base');
		//@mysql_select_db('base') or die("Unable to select database");
		$navbar = $this->sqlquery('SELECT * FROM navbar2 ORDER BY nav_name ASC, nav_id ASC', true);
		$navcat = $this->sqlquery('SELECT * FROM nav_category', true);
		$nav = array();
		$cat = array();
		foreach ($navcat as $id => $data) {
			$cat[$data['cat_name']] = array(
				'id' => $data['cat_id'],
				'name' => $data['cat_name'],
				'realname' => $data['cat_real_name'],
				'login' => (($data['need_login'] == '0') ? false : true),
				'acl' => explode(',', $data['need_acl']),
			);
		}
		foreach ($navbar as $id => $data) {
			$nav[$data['nav_name']][] = array(
				'id' => $data['nav_id'],
				'name' => $data['name'],
				'link' => $data['link'],
				'login' => (($data['need_login'] == '0') ? false : true),
				'acl' => (($data['need_acl'] == '') ? false : explode(',', $data['need_acl'])),
				'nav' => $data['nav_name']
			);
		}*/
		//print '<!--'.print_r($nav, true).print_r($cat, true).'-->';
		/*foreach ($nav as $navname => $navdata) {
			if (($cat[$navname]['login'] && is_object($session) && $session->logged_in) || !$cat[$navname]['login'])
				print '
			<h4 onclick="nav(this, \''.$navname.'\');">'.$cat[$navname]['realname'].'</h4>
			<ul id="'.$navname.'" class="navbar" style="display:none;">';
			foreach ($navdata as $id => $data) {
				if (($data['login'] && is_object($session) && $session->logged_in) || !$data['login'])
					print '
				<li><a href="'.$data['link'].'">'.$data['name'].'</a></li>';
			}
			if (($cat[$navname]['login'] && is_object($session) && $session->logged_in) || !$cat[$navname]['login'])
				print '
			</ul>';
		}*/
		print '
		</div>
';
	}
	function mkfooterfs($mini = false, $extratext = false) {
		$extratext = (isset($extratext)) ? $extratext : '';
		print '</div>
	<div id="footer">
		<p>Copyright &copy; 2008 KTOmega. All rights reserved. '.$extratext.'</p>
	</div>
</div>
</div>
</body>
</html>';
	}
	
	function sqllogin($database = 'lolsite', $user = 'ktomega_45', $password = '5263', $host = 'localhost:2204') {
		//Awardspace
		$this->connect = mysql_connect($host, $user, $password);
		@mysql_select_db($database) or die("Unable to select database");
		return $this->connect;
	}
	function sqldb($database) {
		return mysql_select_db($database, $this->connect) or die("Unable to select database");
	}
	function sqlquery($query, $array = false) {
		trigger_error('Using the old MySQL wrapper functions');
		$querya = @mysql_query($query, $this->connect);
		if (!$querya) { trigger_error('Ruh-roh. MySQL error! '.$query.'... '.mysql_error(), E_USER_WARNING); return mysql_error().$query; }
		if ($array) return $this->mysql_fetch_rowsarr($querya, MYSQL_ASSOC);
		return $querya;
	}
	function set_sqlrsc($sql) {
		$this->connect = $sql;
	}
	function mysql_fetch_rowsarr($result, $numass=MYSQL_BOTH) {
		$got = array();

		if(mysql_num_rows($result) == 0)
		return $got;

		mysql_data_seek($result, 0);

		while ($row = mysql_fetch_array($result, $numass)) {
			array_push($got, $row);
		}

		return $got;
	}
	function confirmUser($username, $password){
		//SQL Injection prevention
		$username = preg_replace("/[^A-Za-z0-9]/", "", $username);
		$password = preg_replace("/[^A-Za-z0-9]/", "", $password);
		// check username
		if (!is_resource($this->connect)) $this->sqllogin();
		$check = mysql_query("SELECT username FROM users WHERE username = '$username'")
		or die(mysql_error());
		$check2 = mysql_num_rows($check);
		if ($check2 == 0) {
			return 1; //Indicates username failure
		}
		//check password
		$check = mysql_query("SELECT password FROM users WHERE password = '$password'")
		or die(mysql_error());
		$check2 = mysql_num_rows($check);
		if ($check2 !== 0) {
			return 0; //Success! Username and password confirmed
		}
		else {
			return 2; //Indicates password failure
		}
	}
	function checkLogin(){
		/* Check if user has been remembered */
		if(isset($_COOKIE['ktuser']) && isset($_COOKIE['ktpass']) && isset($_COOKIE['ktlevel'])){
			$this->data['username'] = $_COOKIE['ktuser'];
			$this->data['password'] = $_COOKIE['ktpass'];
			$this->data['level'] = $_COOKIE['ktlevel'];
		}

		/* Username and password have been set */
		if(isset($this->data['username']) && isset($this->data['password']) && isset($this->data['level'])){
			/* Confirm that username and password are valid */
			if($this->confirmUser($this->data['username'], $this->data['password']) !== 0){
				/* Variables are incorrect, user not logged in */
				unset($this->data['username']);
				unset($this->data['password']);
    				@setcookie("ktuser", 'WTFHAX', time()-60*60*24*100, "/");
   				@setcookie("ktpass", 'WTFHAX', time()-60*60*24*100, "/");
   				@setcookie("ktlevel", '0', time()-60*60*24*100, "/");
				return false;
			}
			return true;
			
		}
		/* User not logged in */
		else{
			return false;
		}
	}
	function displayLogin(){
		if (!isset($this->refer)) {
			$this->refer = $_SERVER['DOCUMENT_ROOT'] . '/index.html';
		} elseif ($this->refer == $_SERVER['DOCUMENT_ROOT'] . '/login.php' || $this->refer == $_SERVER['DOCUMENT_ROOT'] . '/logout.php') {
			$this->refer = $_SERVER['DOCUMENT_ROOT'] . '/index.html';
		}
		
		global $logged_in;
		if($logged_in){
			echo "<h1>Logged In!</h1>";
			print "Welcome <b>" . $this->data['username'] . "</b>, you are logged in. Your browser will now redirect you to the previous page in 3 seconds.
	<ul>
	<li><a href=\"logout.php\">Logout</a>
	<li><a href=\"" . $this->refer . "\">Go back</a>
	</ul><br>
	<br><br><br><br><br><br><br><br><br><br><br><br>";
			sleep(3);
			echo "<meta http-equiv=\"Refresh\" content=\"0;url=" . $this->refer . "\">";
			unset($this->refer);
			return;
			
		}
		else { 
			print "<h1>Login Form</h1>
<form name=\"login\" id=\"login\" action=\"/login.php\" method=\"post\">
<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
<tr><td>Username:</td><td><input type=\"text\" name=\"username\" maxlength=\"30\"></td></tr>
<tr><td>Password:</td><td><input type=\"password\" name=\"password\" maxlength=\"30\"></td></tr>
<tr><td><input type=\"checkbox\" name=\"autologin\" tabindex=\"3\" />Log me on automatically each visit</td></tr>
<tr><td><input type=\"checkbox\" name=\"viewonline\" tabindex=\"4\" />Hide my online status this session</td></tr>
<tr><td><input type=\"hidden\" name=\"redirect\" value=\"" . $_SESSION['refer'] . "\" /></td></tr>
<tr><td colspan=\"2\" align=\"right\"><input type=\"submit\" name=\"login\" value=\"Login\"></td></tr>
</table>
</form><br><br><br><br><br><br><br><br>";
		}
	}
	function adduser ($user, $pass, $level) {
		//SQL Injection prevention
		$user = preg_replace("/[^A-Za-z0-9]/", "", $user);
		$pass = preg_replace("/[^A-Za-z0-9]/", "", $pass);
		$level = (int) preg_replace("/[^0-9]/", "", $level);
		$check = mysql_query("SELECT username FROM users WHERE username = '$user'")
		or die(mysql_error());
		$check2 = mysql_num_rows($check);
		if ($check2 != 0) {
			return 1; //Indicates  that the username is in use
		}
		$pass5 = md5($pass);
		$insert = "INSERT INTO users (username, password, level)
VALUES ('" . $user . "', '" . $pass5 . "', '" . $level . "')";
		$add_member = mysql_query($insert);
		return true; //Success
	}
	function sqllist ($table) {
		$getdata = @mysql_query("SELECT * FROM $table") or die(mysql_error());
		while ($row = mysql_fetch_array($getdata, MYSQL_BOTH)) {
			return $row;
		}
		mysql_free_result($getdata);
	}
	function gen_rand_string($num_chars = 8)
	{
		$rand_str = $this->unique_id($num_chars);
		$rand_str = str_replace('0', 'Z', strtoupper(base_convert($rand_str, 16, 35)));

		return substr($rand_str.md5(time()).sha1(time()).md5(rand(0,1000000)), 0, $num_chars);
	}
	function unique_id($num, $extra = 'c')
	{
		static $dss_seeded = false;
		$val = rand(0,1000000) . microtime().time().rand(0,1000000).md5(time());
		$val = hash('sha512', $val).md5(time()).sha1(time()).md5(rand(0,1000000));
		$config['rand_seed'] = md5(rand(0,1000000) . $val . $extra);

		return substr($val, 0, $num);
	}
}
?>
