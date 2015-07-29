<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php print Template::getInstance()->getVar('header', 'title'); ?> &raquo; OA STEM</title>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
</script>
<![endif]-->
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/jquery.timeago.js"></script>
<script type="text/javascript" src="/js/s3Slider.js"></script>
<script type="text/javascript" src="/js/global.js"></script>

<script src="/js/nav.js"></script>

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
<link rel="icon" href="/images/Rhombus-Favicon.png">
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
			<div id="mobile-logo"><a href="/"><img width="205" height="58" src="/images/r11-White-OA.svg"></a></div>
			<div id="button"><span></span></div>

			<ul id="nav">
            	<li>
					<a href="/team">Team</a>
                </li>
            	<li><a href="/media">Media</a></li>
				<li><a href="/about">About</a></li>
				<li id="logo"><a href="/"><img width="205" height="58" src="/images/r11-White-OA.svg"></a></li>
				<li><a href="/faq">FAQ</a></li>
				<li>
                    <a target="_blank" href="http://oastem.org/summersignup">Apply</a>
                </li>
				<li><a href="/contact">Contact</a></li>
			</ul>
		</nav>
	</header>
	<div id="primary-content">
