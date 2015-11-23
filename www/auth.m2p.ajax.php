<?php
require_once "./common.php";

foreach($m2p_auth_params as $param){
    if(!isset($_POST[$param])){
        exit("Unauthorized");
    }else{
        if(!$_POST[$param] == $m2p_auth[$param]){
            exit("AuthFailure");
        }
    }
}

echo json_encode(generateSessionKeyPair());

function generateSessionKeyPair(){
    global $m2p_sessions;
    $db = connect_db("nfd");
    
    $sid = $db->real_escape_string(genSess());
    $key = $db->real_escape_string(genKey());
    
    $sql = "INSERT INTO $m2p_sessions (sid,skey) VALUES ('$sid', '$key')";
    
    $db->query($sql);
    
    return array("sid" => $sid, "key" => $key);
    
}

function genKey() {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    return gen(20, $chars);
}

function genSess() {
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return gen(10, $chars);
}

function gen($length, $chars){
    $val = substr(str_shuffle($chars), 0, $length);
    return $val;
}

?>