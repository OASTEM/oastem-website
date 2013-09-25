<?php

/* 	There are 3 types of top pop-ups:
*	notice (green),
*	error (red),
*	report (yellow)
*/
function setMsg($typea, $msga, &$smarty) {
	global $type, $msg;
	$type = $typea;
	$msg = $msga;
	$smarty->assign('litbox', $type);
	$smarty->assign('litboxmsg', $msg);
}

function randomString($num_chars = 8)
{
	$rand_str = unique_id($num_chars);
	$rand_str = str_replace('0', 'Z', strtoupper(base_convert($rand_str, 16, 35)));

	return substr($rand_str.md5(time()).sha1(time()).md5(rand(0,1000000)), 0, $num_chars);
}

function unique_id($num, $extra = 'c') {
	//static $dss_seeded = false;
	$val = rand(0,1000000) . microtime().time().rand(0,1000000).md5(time());
	$val = hash('sha512', $val).md5(time()).sha1(time()).md5(rand(0,1000000));
	//$config['rand_seed'] = md5(rand(0,1000000) . $val . $extra);

	return substr($val, 0, $num);
}

function doLoginEntry() {
	global $user;
	if ($user->isLoggedIn()) {
		return $user->getUsername() . ' (<a id="logout">logout</a>)';
	} else {
		return '<a id="login">Login</a>';
	}
}

function generateBreadCrumbs() {
	$ret = "";
	$sep = " &raquo; ";
	
	$base = explode('/', $_SERVER['REQUEST_URI']);
	array_shift($base); array_pop($base);
	
	$ret .= "Home" . $sep;
	foreach ($base as $name) {
		$ret .= $name . $sep;
	}
	$ret = substr($ret, 0, -1 * strlen($sep));
	return $ret;
}

function getErrorMessage($code, $params = array()) {
	switch ($code) {
		case 400: 
			return array(
				'msg' => 'Bad Request',
				'desc' => 'Syntax error. Please check your spelling and try again.'
			);
		break;
		
		case 401: 
			return array(
				'msg' => 'Unauthorized',
				'desc' => 'This server could not verify that you are authorized to access the document requested. Either you supplied the wrong credentials, or your browser doesn\'t understand how to supply the credentials required.'
			);
		break;
		
		case 402: 
			return array(
				'msg' => 'Payment Required',
				'desc' => 'Since when do we have subscription services?'
			);
		break;
		
		case 403: 
			return array(
				'msg' => 'Forbidden',
				'desc' => 'You don\'t have permission to access '.htmlspecialchars($params[0]).' on this server.'
			);
		break;
		
		case 404: 
			return array(
				'msg' => 'Not Found',
				'desc' => 'File not found ('.htmlspecialchars($params[0]).'). Please check your spelling and try again.'
			);
		break;
		
		case 405: 
			return array(
				'msg' => 'Method Not Allowed',
				'desc' => 'The script did not accept the method.'
			);
		break;
		
		case 406: 
			return array(
				'msg' => 'Not Acceptable',
				'desc' => 'The file '.htmlspecialchars($params[0]).' could not be read by your browser.'
			);
		break;
		
		case 407: 
			return array(
				'msg' => 'Proxy Authentication Required',
				'desc' => 'You must authenticate with your proxy.'
			);
		break;
		
		case 408: 
			return array(
				'msg' => 'Request Timeout',
				'desc' => 'Your browser did not supply any data in the time alloted.'
			);
		break;
		
		case 409: 
			return array(
				'msg' => 'Conflict',
				'desc' => 'The request could not be made due to a conflict with the request.'
			);
		break;
		
		case 410: 
			return array(
				'msg' => 'Gone',
				'desc' => 'Ohh (hey!), I\'ve been travelin on this road too long (too long). Just tryin\' to find my way back home (back home). The old me is dead and gone, dead and gone.'
			);
		break;
		
		case 411: 
			return array(
				'msg' => 'Length Required',
				'desc' => 'The script requires a length.'
			);
		break;
		
		case 412: 
			return array(
				'msg' => 'Precondition Failed',
				'desc' => 'The script could not meed the preconditions required.'
			);
		break;
		
		case 413: 
			return array(
				'msg' => 'Request Entity Too Large',
				'desc' => 'The request was too large to process.'
			);
		break;
		
		case 414: 
			return array(
				'msg' => 'Request-URI Too Long',
				'desc' => 'The request was too large to process.'
			);
		break;
		
		case 415: 
			return array(
				'msg' => 'Unsupported Media Type',
				'desc' => 'The media type is unsupported.'
			);
		break;
		
		case 416: 
			return array(
				'msg' => 'Requested Range Not Satisfiable',
				'desc' => 'The requested portion of the file could not be obtained.'
			);
		break;
		
		case 417: 
			return array(
				'msg' => 'Expectation Failed',
				'desc' => 'The requirements could not be fulfilled.'
			);
		break;
		
		case 418: 
			return array(
				'msg' => 'I\'m a teapot',
				'desc' => 'The coffee could not be brewed because the script is a short and stout teapot.'
			);
		break;
		
		case 426: 
			return array(
				'msg' => 'Upgrade Required',
				'desc' => 'A different protocol must be used.'
			);
		break;
		
		case 500: 
			return array(
				'msg' => 'Internal Server Error',
				'desc' => 'The server encountered an internal error or misconfiguration and was unable to complete your request.'
			);
		break;
		
		case 501: 
			return array(
				'msg' => 'Not Implemented',
				'desc' => 'The requested method was not recognizable.'
			);
		break;
		
		case 502: 
			return array(
				'msg' => 'Bad Gateway',
				'desc' => 'An invalid response from the server was received.'
			);
		break;
		
		case 503: 
			return array(
				'msg' => 'Service Unavailable',
				'desc' => 'The server is down due to maintenance or overload.'
			);
		break;
		
		case 504: 
			return array(
				'msg' => 'Gateway Timeout',
				'desc' => 'The server could not produce a response in the alloted time.'
			);
		break;
		
		case 505: 
			return array(
				'msg' => 'HTTP Version Not Supported',
				'desc' => 'Your browser may be obsolete. Please upgrade to the latest version or a modern browser.'
			);
		break;
		
		case 506: 
			return array(
				'msg' => 'Variant Also Negotiates',
				'desc' => 'A circular reference has occured.'
			);
		break;
		
		case 509: 
			return array(
				'msg' => 'Bandwidth Limit Exceeded',
				'desc' => 'The server is down due to overload.'
			);
		break;
		
		case 510: 
			return array(
				'msg' => 'Not Extended',
				'desc' => 'The server requires additional extensions to fulfill this request.'
			);
		break;
	}
}

function sanitizeSQL($arr) {
	global $db;
	foreach ($arr as $i => $data) {
		if (is_array($data)) {
			$arr[$i] = sanitizeSQL($data);
		} else {
			$arr[$i] = $db->escape($data);
		}
	}
	return $arr;
}