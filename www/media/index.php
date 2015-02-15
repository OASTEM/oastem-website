<?php
require_once('../common.php');
require_once('../google_common.php');
require_once('../config.php');

$templ->setTitle('Media');
$templ->render('header');

$drive = getDriveService();

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function append($folder_id,$name){
	global $drive;
	$files = listFileIdInFolder($drive,$folder_id);
	$isRoot = $name == "ROOT";
	echo "<div id='" . ($isRoot ? 'media-content' : preg_replace("/[^A-Za-z0-9]/", "", $name))
		. "' class='media-folder'>";
		echo $isRoot ? "" : "<h1>" . $name . "</h1>"; 
	foreach($files as $f){
		$data = $drive->files->get($f);
		if($data->getMimeType() == 'application/vnd.google-apps.folder'){
			append($data->getId(),$data->getTitle());
		}
		if(startsWith($data->getMimeType(),'image/')){
			echo "<div class='media-image quarter column'>
				<img width='100px' src='" .  str_replace("export=download","export=view",$data->getWebContentLink()) . "'>
			</div>";
		}
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

<div id="loading">
Please wait for all the pictures to load; this may take a while for Google is slow af.
</div>

<script>
var dialog;
$(document).ready(function(e) {
    dialog = $('#loading').dialog({
		title:"Loading...",
		autoOpen: true,
		modal:true,
		resizable:false,
		draggable:true,
		width:1000,
		height:500});
});
$(window).load(function(e) {
    dialog.dialog("close");
	$(document).remove('#loading');
});
</script>

<?php
append($MEDIA_FOLDER_ID,"ROOT");
?>

<?php
$templ->render('footer');
?>