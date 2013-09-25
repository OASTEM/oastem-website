<?
class functions {
	var $connect;
	var $refer;
	var $data;
	//	var $logarr;
	function uberbar($text = null, $return = false) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/include/ktomegaland.lock')) { 
			if ($return) return '<div id="uberbar">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/include/ktomegaland.lock').'</div>';
			else { print '<div id="uberbar">'.file_get_contents($_SERVER['DOCUMENT_ROOT'].'/include/ktomegaland.lock').'</div>'; return true; }
		} elseif (isset($text)) {
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
	function mkheaderfs($mini = false, $css = '/css/new.css', $title = 'Hax', $header1 = 'WHAT', $header2 = 'NINE THOUSAND', $head = null) {
		print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<link rel=\"StyleSheet\" href=\"{$css}\" type=\"text/css\" />
<script src=\"/js/mootools-1.2-core.js\"></script>
<script src=\"/js/ktomegaland.js\"></script>
";
		if (isset($head)) print $head;
		print "
<title>{$title} - KTOmega Land</title>
</head>
<body>

";
		self::uberbar();
		print "

<div id=\"outer\">
	<div id=\"logo\">
		<h1>{$header1}</h1>
		<h2>{$header2}</h2>
	</div>";
		$this->sqllogin('base');
		$query = mysql_query('SELECT * FROM navbar', $this->connect) or die(mysql_error());
		$row = $this->mysql_fetch_rowsarr($query, MYSQL_ASSOC);
		//$ini_array = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . "/navbar.ini");
		//$i = 1;
		print "<div id=\"nav\"><h4>Navigation</h4><ul class=\"navbar\">\n";
		foreach ($row as $id => $data) 
			print "	<li><a href=\"{$data['link']}\">{$data['name']}</a></li>\n";
		/*while ($i <= 250 && isset($ini_array[$i])) {
			$asdf = $i . "a";
			if (is_null($ini_array[$asdf])) {
				print "	<li>";
				trigger_error('URL for <b>' . $ini_array[$i] . '</b> is null ', E_USER_WARNING);
				print "</li><li>$ini_array[$i]</li>\n";
			} else {
				print "	<li><a href=\"$ini_array[$asdf]\">$ini_array[$i]</a></li>\n";
			}
			$i++;
		}*/ print "</ul></div>";
	}
	function mkfooterfs($mini = false, $extratext = false) {
		$extratext = ($extratext) ? $extratext : '';
		print '    <div id="footer">
		<p>Copyright &copy; 2007 KTOmega. All rights reserved. Some CSS adapted from <a href="http://www.dcarter.co.uk">dcarter</a>. Layout from <a href="http://articles.techrepublic.com.com/5100-22-5296198.html">techrepublic</a>. '.$extratext.'</p>
	</div>
</div>
</body>
</html>';
	}
	
	function sqllogin($database = 'ktomega_45', $user = 'ktomega_45', $password = '5263', $host = 'localhost:2204') {
		//Awardspace
		$this->connect = mysql_connect($host, $user, $password);
		@mysql_select_db($database) or die("Unable to select database");
		return $this->connect;
	}
	function sqlquery($query, $array = false) {
		$query = @mysql_query($query, $this->connect);
		if (!$query) return mysql_error().$query;
		if ($array) return $this->mysql_fetch_rowsarr($query, MYSQL_ASSOC);
		return $query;
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
		$rand_str = $this->unique_id();
		$rand_str = str_replace('0', 'Z', strtoupper(base_convert($rand_str, 16, 35)));

		return substr($rand_str, 0, $num_chars);
	}
	function unique_id($extra = 'c')
	{
		static $dss_seeded = false;

		$val = rand(0,1000000) . microtime();
		$val = md5($val);
		$config['rand_seed'] = md5(rand(0,1000000) . $val . $extra);

		return substr($val, 4, 16);
	}
}
?>
