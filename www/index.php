<?php
require('common.php');

if (isset($_GET['404'])) {
	setFlash("error", "Sorry! We couldn't find what you were looking for. Perhaps the navigation bar below will help?");
}

$templ->setTitle('Home');
$templ->setVar('header', 'jsLoad', '$(\'div#slideshow\').s3Slider({timeOut: 4000});');
$templ->render('header');
?>
<link rel="stylesheet" href="/css/post.css" />
<script src="/js/uac.js"></script>
<script src="/js/posts.js"></script>

<!--
	<div id="slideshow">
    <ul id="slideshowContent">
    	<img id="loading2" src="/images/ajax-loader.gif">
    </ul>
    </div>
    -->
<div id="jumbotron">
    <a href="summer/"><img src="images/summerjumbo.jpg"></a>
</div>
    <div id="nfd-wrapper">        
    <?php
        if($logged_in){
    ?>
        <div id="dialog-new">
            <form id="new-post-form" method="post" action="/ajax_posts.php?new">
                <label for="title" class="form-element">Title</label>
                <input type="text" name="title" id="new-title" class="form-element">
                <label for="content" class="form-element">Content</label>
                <textarea name="content" id="new-content" class="form-element"></textarea>
            </form>
        </div>
        <div id="dialog-edit" title="Edit Post">
            <form id="edit-form" method="post" action="/ajax_posts.php?modify">
                    <label for="ntitle" class="form-element">Title</label>
                    <input type="text" name="ntitle" id="title-edit-box" class="form-element">
                    <label for="ncontent" class="form-element">Content</label>
                    <textarea name="ncontent" id="content-edit-box" class="form-element"></textarea>
            </form>
        </div>
     <?php
        }
     ?>
        <h1 id='cat-head'>Filter by department</h1>
    
        <div id="controls">
            <?php
                if($logged_in){
            ?>
            <div id="new-post" class="container">
                <img src="/images/plus.svg" height="37px">
                <h2>New Post</h2>
            </div>
            <div id="logout" class="container">
                <img src="/images/lock.svg" height="37px">
              <h2>Logout</h2>
            </div>
            <?php
            }
            ?>
        </div>
        
        <ul id="cat">
            <li id="sci" class='container'>
                <img src="/images/Atom.svg" height="37px">
               <h2>Science</h2>
            </li>
            
            <li id="tech" class='container'>
                <img src="/images/Pointer.svg" height="37px">
                <h2>Technology</h2>
            </li>
        
            <li id="eng" class='container'>
                <img src="/images/Gear.svg" height="37px">
                <h2>Engineering</h2>
            </li>
            
            <li id="math" class='container'>
                <img src="/images/Pi.svg" height="37px">
                <h2>Math</h2>
            </li>
        </ul>
        <div id="feed-wrapper">
        </div>
        <div id="load-wrap">
        	<img id="loading" src="/images/ajax-loader.gif">
        </div>


		<!--<div class="one column post">
			<h1><span>Welcome to Oxford Academy STEM!</span></h1>
			<p>First of all, thank you for your interest in Oxford Academy STEM, the leader of STEM education at Oxford Academy. Our team 
strives to inspire students in and outside of Oxford Academy to pursue a career in the fields of science, technology, engineering, and mathematics (STEM) by giving them the 
experience to excel in their endeavors.</p>
			<p>If you are interested in joining Oxford Academy STEM, <a href="/docs/STEMMemberApp.pdf">fill out this application</a> and either bring it to the first meeting or <a href="/contact.html">shoot us an email</a>.</p>
			<p>If you would like to learn more about the program, head over the to <a href="/about.html">About</a> tab.</p>
		</div>
	</div>-->
<?php
$templ->render('footer');
?>
