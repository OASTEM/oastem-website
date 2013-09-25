<?php
require('../config.php');
require('./mysql.php');

$db = new MySQL($dbhost, $dbport, $dbname, $dbuser, $dbpass);

print time() - 60*60*24*7;

$db->query("DELETE FROM `kt_sessions` WHERE `session_last_visit` < " . time() - 60*60*24*7);