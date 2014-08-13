<?php
session_start();

$starttime = microtime(true);

require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require($rtexact.'include/mysqli.php');
require($rtexact.'include/template.php');

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