<?php
	require('./common.php');
	require('./google_common.php');

	$drive = getDriveService();
	$ct = 0;
	file_put_contents('desc.txt',downloadFile($drive, $drive->files->get('0ByDyUerJE7tFLVB4aDVIazVCU1U'), getClient()));
	$sets = split("\n",file_get_contents('desc.txt'));
	$desc = array();
	foreach($sets as $val){
		$set = split(':', $val);
		$descA = array();
		$descA['title'] = $set[1];
		$descA['desc'] = $set[2];
		$desc[$set[0]] = $descA;
	}
	foreach(listFileIdInFolder($drive,$SLIDER_FOLDER_ID) as $item){
		$data = $drive->files->get($item);
		$con = str_replace('&export=download','',$data->getWebContentLink());
		
		$ct++;
		
		$descSel = $data->getTitle();
		
		$contentTitle = array_key_exists($descSel,$desc) ? $desc[$descSel]['title'] : 'Ooops';
		$contentBody = array_key_exists($descSel,$desc) ? $desc[$descSel]['desc'] : 'Content will come soon!';
		
		if(startsWith($data->getMimeType(),'image/')){
			echo "
				<li class='slideshowImage'>
				<img src='$con' alt='$ct' />
				<span class='bottom'>
				<h3>$contentTitle</h3>
				<p>$contentBody</p>
				</span>
				</li>
			";		
		}
	}

?>
