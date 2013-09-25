<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require($rtexact.'include/mysqli.php');

$db = new MySQL($dbhost, $dbport, $dbname, $dbuser, $dbpass);

$n = strtolower($db->escape($_GET['l']));
$link = $db->getValue("SELECT link_to FROM links WHERE link_name = '{$n}'", 'link_to');

header('Location: '.$link);
