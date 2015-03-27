<?php
require_once('../common.php');

$templ->setTitle('Media');
$templ->render('header');
?>
<script src="media.js"></script>
<link href="media.css" rel="stylesheet">

<div id="load-wrap"><img id="loading" src="../images/ajax-loader.gif"></div>

<div id="media-content">
</div>

<div id="media-control">
<button id="prev">Previous</button>
<button id="next">Next</button>
</div>

<?php
$templ->render('footer');
?>