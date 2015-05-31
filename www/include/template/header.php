<!DOCTYPE html>
<html>
<head>
<title><?php print Template::getInstance()->getVar('header', 'title'); ?> &raquo; OA STEM</title>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/jquery.timeago.js"></script>

<script type="text/javascript" src="/js/s3Slider.js"></script>
<script type="text/javascript" src="/js/global.js"></script>


<script type="text/javascript">
$(document).ready(function() {
	$('#slideshowContent').empty();
	$.ajax({
		url:'/getSlider.php',
		dataType:"html",
		success:function(response){
			$('#slideshowContent').html(response);
			<?php print Template::getInstance()->getVar('header', 'jsLoad'); ?>
		}
	});
});

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44336641-1', 'oastem.org');
  ga('send', 'pageview');
</script>
<?php print Template::getInstance()->getVar('header', 'head'); ?>
<link rel="icon" href="/favicon.png" type="image/png">
<link rel="StyleSheet" href="/css/style.css" />
<link rel="StyleSheet" href="/js/jquery-ui/redmond/jquery-ui-1.8.23.custom.css" />
</head>
<body>
<?php if (hasFlash()) { ?>
<div class="flash <?=getFlashType()?>">
	<p><?=getFlash();?></p> <span class="small">[CLICK TO CLOSE]</span>
</div>
<?php } ?>
<div id="container">
	<header>
		<nav>
			<ul id="navmain">
            	<li>
                <a href="/team">Team</a>
                <ul class="sub" style="left:-1em;">
                	<li><a href="/team#board">Board</a></li>
                    <li><a href="/team#mentors">Mentors</a></li>
                </ul>
                </li>
            	<li><a href="/media">Media</a></li>
				<li><a href="/about">About</a></li>
				<li id="logo"><a href="/index.html"><img src="../../images/r10-White-OA.svg"></a></li>
				<li><a href="/faq">FAQ</a></li>
				<li>
                    <a target="_blank" href="/docs/STEMMemberApp.pdf">Apply</a>
                    <ul class="sub" style="right:8em;">
                        <li><a href="/docs/STEMMemberApp.pdf">Member</a></li>
                        <li><a href="/docs/STEMAdminApp.pdf">Board</a></li>
                    </ul>
                </li>
				<li><a href="/contact">Contact</a></li>
			</ul>
		</nav>
	</header>
    <div id="sm-wrap">
        <ul id="social-media">
            <li><a href="http://facebook.com/OASTEM/" target="_blank"><img src="../../images/facebook.svg"></a></li>
            <li><a href="http://instagram.com/oa_stem/" target="_blank"><img src="../../images/instagram.svg"></a></li>
            <li><a href="http://github.com/OASTEM" target="_blank"><img src="../../images/github.svg"></a></li>
            <li><a href="http://ask.fm/OASTEM" target="_blank"><img src="../../images/ask_fm.svg"></a></li>
        </ul>
	</div>
	<div id="primary-content">