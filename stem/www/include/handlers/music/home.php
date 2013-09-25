<?php
$songs = iTunesXmlParser("C:/Users/KTOmega/Music/iTunes/iTunes Music Library.xml");
if ($songs)
{
	// create a table
	$output = '<table>';
	
	// fill the first row with headings
	$output .= '<tr>';
	$output .= '<td>name</td>';
	$output .= '<td>artist</td>';
	$output .= '<td>genre</td>';
	//$output .= '<td><font size="1">rating</font></td>';
	$output .= '</tr>';
		
	// loop through the songs in the array and get 4 fields that I want to see
	foreach ($songs as $song)
	{
		$output .= '<tr>';
		if (isset($song['Name'])) $output .= '<td><font size="2">'.$song["Name"].'</font></td>';
		if (isset($song['Artist'])) $output .= '<td><font size="2">'.$song["Artist"].'</font></td>';
		if (isset($song['Genre'])) $output .= '<td><font size="2">'.$song["Genre"].'</font></td>';
		//$output .= '<td><font size="2">'.$song["Rating"].'</font></td>';
		$output .= '</tr>';
	}
	
	// end the table
	$output .= '</table>';
	
	// show my new table
	print ($output);
}
/*
header('content-type: text/plain');
$dataz = file_get_contents("C:/Users/KTOmega/Music/iTunes/iTunes Music Library.xml");
//var_dump($dataz);
if (!$dataz) die($php_errmsg);
$plist = new SimpleXMLElement($dataz);
//var_dump($plist);
//die;
$l = "\n";
//print '#EXTM3U'.$l;
printf("%35s | %35s | %50s\n", "Genre", "Artist", "Title");
print str_repeat('-', 137)."\n";
foreach ($plist->dict->dict->dict as $id => $data) {
	//print_r($data);
	if ($data->string[1] == 'MPEG-4 video file' || $data->string[2] == 'MPEG-4 video file' || $data->string[3] == 'MPEG-4 video file' ||
		$data->string[2] == 'Voice Memos' || $data->string[3] == 'Voice Memo') continue;
	//print 'Track ' . $data->integer[0] . ' ('. $data->string[1] . ' - '. $data->string[0] . ' => ' . str_replace('/', '\\', str_replace('file://localhost/', '', urldecode($data->string[count($data->string) - 1]))) . "\n";
	// #EXTINF:238,Evanescence - Bring Me To Life
	$time = (int)($data->integer[2] / 1000);
	//print "#EXTINF:{$time},{$data->string[1]} - {$data->string[0]}{$l}";
	//print str_replace('/', '\\', str_replace('file://localhost/', '', urldecode($data->string[count($data->string) - 1]))).$l;
	printf("%35s | %35s | %50s\n", $data->string[3], $data->string[1], $data->string[0]);
	//print str_replace('/', '\\', str_replace('file://localhost/', '', urldecode($data->string[count($data->string) - 1]))).$l;
}*/