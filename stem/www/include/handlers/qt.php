<?php
if (isset($_POST['submit'])) {
	switch ($action[1]) {
	}
} else { 
	switch($action[1]) {
		case 'submit':
			require($rtexact . 'loggar.php');
		break;
		
		case 'queue':
			header('Content-Type: text/plain');
			require($rtexact . 'qt-log.txt');
		break;
	
		case 'log':
		default:
			header('Content-Type: text/plain');
			require($rtexact . 'qt.txt');
		break;
	}
}
