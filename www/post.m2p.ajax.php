<?php
 require_once "./common.php";

$m2p_post_param_keys = array(
    "sid", "key", "uid", "subject", "message"
);

foreach($m2p_post_param_keys as $key){
    if(!isset($_POST[$key])){
        exit("MissingParameter");
    }
}

if(checkKeys($_POST['sid'],$_POST['key'])) post($_POST['uid'],$_POST['message'],$_POST["subject"]);

//Check auth
function checkKeys($sid, $key){
    global $m2p_sessions, $m2p_salt;
    $db = connect_db("nfd");
    
    $sid = $db->real_escape_string($sid);
    
    $sql = "SELECT skey FROM $m2p_sessions WHERE sid='$sid'";
    
    $res = $db->query($sql)->fetch_assoc();
    
    $db->close();
    return sha1($res['skey'] . $m2p_salt) == $key;
}

//Insert
function post($uid, $msg, $subj){
    global $DBT_POSTS;
    $db = connect_db("nfd");
    
    $msg = $db->real_escape_string($msg);
    $subj = $db->real_escape_string($subj);
    
    $sql = "INSERT INTO $DBT_POSTS (uid,title,content) VALUES ($uid,'$subj','$msg')";
    
    $db->query($sql);
    
    $db->close();
}

?>