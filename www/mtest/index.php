<?php

require_once('../google_common.php');

printFilesInFolder(getDriveService(),$_GET['id']);

?>