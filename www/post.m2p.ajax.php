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

if(checkKeys($_POST['sid'],$_POST['key']){
    $processedMsg = stripSig($_POST['message']); 
    $processedMsg = lastRepl("--","",$processedMsg);
    post($_POST['uid'],$processedMsg,$_POST["subject"]);
    echo "success";
}else{
    echo "error";
}

//Check auth
function checkKeys($sid, $key){
    global $m2p_sessions, $m2p_salt;
    $db = connect_db("nfd");
    
    $sid = $db->real_escape_string($sid);
    
    $sql = "SELECT * FROM $m2p_sessions WHERE sid='$sid'";
    
    $res = $db->query($sql)->fetch_assoc();
    
    $keytime = strtotime($res['timestamp']);
        
    $auth = sha1($res['skey'] . $m2p_salt) == $key && time() - $keytime < 45;
    
    $sql = "DELETE FROM $m2p_sessions WHere sid='$sid'";
    $db->query($sql);
    $db->close();
    return $auth;
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

function stripSig($str){
    $dom = new DOMDocument;
    $dom->loadHTML($str);
    
    $divs = $dom->getElementsByTagName("div");
    
    for($i = $divs->length - 1; $i >= 0; $i--){
        $div = $divs->item($i);
        echo $div->getAttribute("dir");
        if($div->getAttribute("dir") == "ltr"){
            $div->parentNode->removeChild($div);
            break;
        }
    }
    /**foreach($divs as $div){
        if($div->attributes->getNamedIten("dir") == "ltr"){
            $div->parentNode->removeChild($div);
            break;
        }
    }*/
    return $dom->saveHTML();
}

function lastRepl($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}

?>