<?php
require_once('../common.php');

$templ->setTitle('Media');
$templ->render('header');
?>
<script src="media.js"></script>
<link href="media.css" rel="stylesheet">

<div id="media-content">
</div>

<div id="media-control">
<button id="prev">Previous</button>
<button id="next">Next</button>
</div>

<?php
$templ->render('footer');
?>