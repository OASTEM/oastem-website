<?php

// Sample values provided.
$dbhost = 'your-hostname';
$dbport = '3306';
$dbname = 'database_name';
$dbuser = 'user_name';
$dbpass = 'user_password';

$wwwRoot = __DIR__;
$libRoot = dirname($wwwRoot) . '/lib';

$db_list = array(
	"id" => array(
		"user" => "user",
		"password" => "password",
		"db" => "db"
	),
	"id"=> array(
		"user" => "user",
		"password" => "passworc",
		"db" => "db"
	)
);

$DRIVE_SCOPE = 'https://www.googleapis.com/auth/drive';
$SERVICE_ACCOUNT_EMAIL = 'EMAIL@developer.gserviceaccount.com';
$SERVICE_ACCOUNT_PKCS12_FILE_PATH = 'path/to/key.p12';
$MEDIA_FOLDER_ID = "id_string";
$SLIDER_FOLDER_ID = "id_string";


function connect_db($dbid){
		global $db_list;
		if(array_key_exists($dbid,$db_list)){
				$duser = $db_list[$dbid]["user"];
				$dpassword = $db_list[$dbid]["password"];
				$ddb = $db_list[$dbid]["db"];
				$dhost = array_key_exists('host',$db_list[$dbid]) ? $db_list[$dbid]["host"] : "localhost";
		}
		error_log("Params: " . $dhost . " | " . $duser . " | " . $dpassword . " | " . $ddb);
		$dconn = mysqli_connect($dhost,$duser,$dpassword,$ddb);
		if ($dconn->connect_error) {
			die('Connect Error (' . $dconn->connect_errno . ') ' . $dconn->connect_error);
		}

		return $dconn;
}
