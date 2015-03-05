<?php
require_once('../common.php');
require_once('../google_common.php');
require_once('../config.php');

$templ->setTitle('Media');
$templ->render('header');

$lc = "Started at " . microtime();

function logg($text, $start){
	global $lc;
	$clock = microtime(true) - $start;
	$lc .= "\n[" . microtime() . "] $text";
	$lc .= "\n	Took $clock";
}

$log = "/var/www/stem/google_log.txt";


$drive = getDriveService();

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function append($folder_id,$name){
	$ct = microtime(true);
	
	global $drive;
	$files = listFileIdInFolder($drive,$folder_id);
	$isRoot = $name == "ROOT";
	
	logg("Grabbed folder " . $folder_id,$ct);
	
	echo "<div id='" . ($isRoot ? 'media-content' : preg_replace("/[^A-Za-z0-9]/", "", $name))
		. "' class='media-folder'>";
		echo $isRoot ? "" : "<h1>" . $name . "</h1>"; 
	foreach($files as $f){
		$ct = microtime(true);
		
		$data = $drive->files->get($f);
		
		if($data->getMimeType() == 'application/vnd.google-apps.folder'){
			append($data->getId(),$data->getTitle());
		}
		if(startsWith($data->getMimeType(),'image/')){
			echo "<div class='thumb quarter column' style=\"background-image:url('" . $data->getThumbnailLink() ."'\")>
			</div>";
			
		}
		logg("Processed " . $data->getId(),$ct);
	}
	echo "</div>";

}
?>

<style>
#media-content{
	margin:0 auto;
	width:1000px;
}
.media-folder{
	border:solid black 1px;
}	
/*
.media-image{
	width:100px;
}*/
</style>

<?php
append($MEDIA_FOLDER_ID,"ROOT");
file_put_contents($log,$lc);
?>

<?php
$templ->render('footer');
?>