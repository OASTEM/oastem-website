<?php
 require_once "./common.php";

$m2p_post_param_keys = array(
    "sid", "key", "uid", "subject", "message"
);

$acceptable_tags = "
    <!DOCTYPE>
    <a>
    <abbr>
    <acronym>
    <address>
    <applet>
    <area>
    <article>
    <aside>
    <audio>
    <b>
    <base>
    <basefont>
    <bdi>
    <bdo>
    <big>
    <blockquote>
    <body>
    <br>
    <button>
    <canvas>
    <caption>
    <center>
    <cite>
    <code>
    <col>
    <colgroup>
    <command>
    <datalist>
    <dd>
    <del>
    <details>
    <dfn>
    <dir>
    <dl>
    <dt>
    <em>
    <embed>
    <fieldset>
    <figcaption>
    <figure>
    <font>
    <footer>
    <form>
    <frame>
    <frameset>
    <h1>
    <h2>
    <h3>
    <h4>
    <h5>
    <h6>
    <head>
    <header>
    <hgroup>
    <hr>
    <html>
    <i>
    <iframe>
    <img>
    <input>
    <ins>
    <kbd>
    <keygen>
    <label>
    <legend>
    <li>
    <link>
    <map>
    <mark>
    <menu>
    <meta>
    <meter>
    <nav>
    <noframes>
    <noscript>
    <object>
    <ol>
    <optgroup>
    <option>
    <output>
    <p>
    <param>
    <pre>
    <progress>
    <q>
    <rp>
    <rt>
    <ruby>
    <s>
    <samp>
    <script>
    <section>
    <select>
    <small>
    <source>
    <span>
    <strike>
    <strong>
    <style>
    <sub>
    <summary>
    <sup>
    <table>
    <tbody>
    <td>
    <textarea>
    <tfoot>
    <th>
    <thead>
    <time>
    <title>
    <tr>
    <track>
    <tt>
    <u>
    <ul>
    <var>
    <video>
    <wbr>

";

foreach($m2p_post_param_keys as $key){
    if(!isset($_POST[$key])){
        exit("MissingParameter");
    }
}

if(checkKeys($_POST['sid'],$_POST['key'])){
    post($_POST['uid'],strip_tags($_POST['message'],$acceptable_tags),$_POST["subject"]);
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

?>