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

<script src="/js/uac.js"></script>
<script src="../../js/posts.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	<?php print Template::getInstance()->getVar('header', 'jsLoad'); ?>
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
<link rel="stylesheet" href="/css/post.css" />
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
		<h1><span>Oxford Academy STEM</span></h1>
		<nav>
			<ul id="navmain">
				<li><a href="/index.html">Home</a></li>
				<li><a target="_blank" href="/docs/STEMMemberApp.pdf">Apply</a></li>
				<li><a href="/about.html">About</a></li>
				<li><a href="/faq.html">FAQ</a></li>
				<li><a href="/contact.html">Contact</a></li>
			</ul>
		</nav>
	</header>