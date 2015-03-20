<?php
require_once('../google_common.php');
require_once('../config.php');

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}


if(isset($_GET['list'])){
	$drive = getDriveService();
	$folders = array();
	foreach(listFileIdInFolder($drive,$MEDIA_FOLDER_ID) as $item){
		$data = $drive->files->get($item);
		if($data->getMimeType() == 'application/vnd.google-apps.folder'){
			array_push($folders,$data->getId());
		}
	}
	echo json_encode($folders);
}elseif(isset($_GET['get'])){
	if(isset($_POST['fid'])){
		$drive = getDriveService();
		$fid = $_POST['fid'];
		
		foreach(listFileIdInFolder($drive,$fid) as $item){
			$data = $drive->files->get($item);
			if(startsWith($data->getMimeType(),'image/')){
				echo "<div class='m-img' style=\"background-image:url('" . $data->getThumbnailLink() ."')\">
				</div>";
				
			}
		}

	}else{
		echo 'error';
	}
}

?>