<?php
session_start();

$starttime = microtime(true);

require('config.php');
require($wwwRoot . '/google_common.php');
require($wwwRoot . '/include/mysqli.php');
require($wwwRoot . '/include/template.php');

$user = null;
$db = null; 

$templ = Template::getInstance();

// TODO: user session library

function setFlash($severity, $str) {
	$_SESSION['flashtype'] = $severity;
	$_SESSION['flash'] = $str;
}

function hasFlash() {
	return isset($_SESSION['flash']);
}

function getFlashType() {
	$type = $_SESSION['flashtype'];
	unset($_SESSION['flashtype']);
	return $type;
}

function getFlash() {
	$msg = $_SESSION['flash'];
	unset($_SESSION['flash']);
	return $msg;
}
$first_sid = session_id();

session_write_close();

$uacPHP = $wwwRoot . "ajax_acct.php";
$uacJs = $wwwRoot . "js/uac.js";
$postPHP = $wwwRoot . "ajax_posts.php";
$postJs = $wwwRoot . "js/posts.js";
$includes = $wwwRoot . "resources/php/includes.php";

$logged_in = false; //site-wide 
$cookie = isset($_COOKIE['nfd_sid']);
if($cookie){
	session_id($_COOKIE['nfd_sid']); //set the session id
	session_start();
	setcookie('nfd_sid',session_id(),time()+3600 * 24 * 30,'/','.oastem.phantastyc.tk'); //so expiry gets extended each 
	$logged_in = isset($_SESSION['uid']);
}
function getData($uid,$db){ //return user data array from db
	$sql = "SELECT * FROM users WHERE uid=$uid";
	$result = $db->query($sql);
	
	return $result->fetch_assoc();
}

function getCat($cid,$db){//return category data
	$sql = "SELECT * FROM categories WHERE cid=$cid";
	$result = $db->query($sql);
	return $result->fetch_assoc();
}

