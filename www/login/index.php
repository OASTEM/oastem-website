<?php
require "../common.php";

if($logged_in){
	header("Location: http://". $_SERVER['SERVER_NAME']);
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>

<script src="../js/jquery.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/jquery.form.js"></script>
<script src="../js/uac.js"></script>

<link rel="icon" href="/favicon.png" type="image/png">
<link rel="stylesheet" href="/css/post.css" />
<link rel="StyleSheet" href="/js/jquery-ui/redmond/jquery-ui-1.8.23.custom.css" />

<style>
body{
	font-family:'Titilium Web';
	font-size:12px;
}
</style>

</head>

<body>
	<div id="login-dialog"></div>
    
    <div id="login" class="container">
        <img src="../images/lock.svg" height="37px">
        <h2>Login</h2>
    </div>
</body>
</html>