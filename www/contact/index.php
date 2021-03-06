<?php
require('../common.php');

if (isset($_POST['submit'])) {
	if (isset($_SESSION['lastMessage']) && time() - $_SESSION['lastMessage'] < 60) {
		setFlash("error", "Woah, calm down there. Send your message again in a minute!");
	} else if (isset($_SESSION['hash']) && isset($_POST['token']) && $_SESSION['hash'] != $_POST['token']) {
		setFlash("error", "There was an error submitting the form.");
	} else {
		$email = str_replace(array("\r", "\n"), '', $_POST['email']);
		$headers = 'Reply-To: ' . $email . "\r\n" .
    			'X-Mailer: PHP/' . phpversion();
		mail("contact@oastem.org", "[Message from {$_POST['name']} ({$_SERVER['REMOTE_ADDR']})] {$_POST['subject']}", $_POST['message']."\n\n\nE-mail: {$email}", $headers);
		setFlash("success", "Thank you! Your message has been sent.");
	}
	$_SESSION['lastMessage'] = time();
} else if (!isset($_SESSION['hash'])) {
	$hash = md5(mt_rand(1,1000000) . $salt);
	$_SESSION['hash'] = $hash;
}

$templ->setTitle('Contact Us');
$templ->render('header');
?>
	<div id="content">
		<div class="two column post">
			<h1><span>Contact Us</span></h1>s
			<p>Thanks for your interest in Oxford Academy STEM! If you have any additional questions about our STEM program specifically, you can reach us using the contact form below, or at <a href="mailto:contact@oastem.org">contact@oastem.org</a>.</p>
			<p>If you would like to reach us through mail, you can write to us, Oxford Academy STEM, at <a href="http://maps.google.com/maps?q=5172+Orange+Ave,+Room+301,+Cypress,+CA+90630&gl=us&t=m&z=16">5172 Orange Ave, Room 301, Cypress, CA 90630</a>.</p>
		</div>
		
		<div class="two column post">
			<form method="POST">
				<input type="hidden" name="token" value="<?php print $_SESSION['hash']; ?>" />
				<table class="plain" id="contact">
					<tr>
						<td>Name</td><td><input type="text" name="name" /></td>
						<td>E-mail</td><td><input type="text" name="email" /></td>
					</tr>
                    <tr>
                    	<td>Subject</td><td colspan="3"><input type="text" name="subject" class="sub_input" /></td>
                    </tr>
					<tr>
						<td colspan="4"><textarea name="message" rows="14" cols="50"></textarea></td>
					</tr>
					<tr>
						<td colspan="4" class="text-right"><input type="submit" name="submit" value="Submit" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
<?php
$templ->render('footer');
?>