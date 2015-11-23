<?php
require_once('../common.php');
require '../../PHPMailer/PHPMailerAutoload.php';

$templ->setTitle('Sign Up');
$templ->render('header');

$isPosted = isset($_POST["submit"]);
if ($isPosted){
$name = $_POST["name"];
$email = $_POST["email"];
$parent = $_POST["parent"];
$grade = $_POST["grade"];
$departments = $_POST["departments"];
$message = $_POST["message"];
$subject = "Member Sign Up";
$mail = new PHPMailer;

$body = "The following student is interested in joining your department!<br>";
$body .= "Name: " . $name . "<br>Email: " . $email;
if (isset($_POST["parent"]))
    $body .= "<br>Parent Email: " . $parent;
$body .= "<br>Grade: " . $grade;
if (isset($_POST["message"]))
    $body .= "<br><br>The student also had the following message:<br>" . $message;

$mail->isSMTP();
$mail->Host = 'mail.google.com';
$mail->SMTPAuth = false;
//$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('contact@oastem.org', 'Robot from the Website');
$mail->isHTML(true);
$mail->addAddress('executives@oastem.org');
$mail->Subject = $subject;
$mail->Body = $body;

if(in_array('science', $departments))
    $mail->addCC('science@oastem.org');
if(in_array('technology', $departments))
    $mail->addCC('technology@oastem.org');
if(in_array('robotic', $departments))
    $mail->addCC('engineering@oastem.org');
if(in_array('civil', $departments))
    $mail->addCC('civilengineering@oastem.org');
if(in_array('math', $departments)){
    if($grade > 8)
        $mail->addCC('math@oastem.org');
    else
        $mail->addCC('mathcounts@oastem.org');
}

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if(!$mail->send()) {
        setflash("error", "Message could not be sent. Mailer Error: " . $mail ->ErrorInfo);
    } else {
        setflash("success", "Success! Submission has been sent.");
    }
}
else{
    setflash("error", "Please enter a valid email address");
}
}
?>
<section>
<div class="row post">
<form method="POST">
    <div class="col-6">
    <h2>Your Name*</h2>
        <input type="text" name="name" required>
    <h2>Your E-mail*</h2>
        <p>Please do not put your AUHSD email.</p>
        <input type="text" name="email" required>
    <h2>Parent E-Mail</h2>
        <p>If your parents would like to receive updates, leave their email here.</p>
        <input type="text" name="parent">
    <h2>Grade*</h2>
        <input type="radio" name="grade" value="7" required>7th
        <input type="radio" name="grade" value="8">8th
        <input type="radio" name="grade" value="9">9th
        <input type="radio" name="grade" value="10">10th
        <input type="radio" name="grade" value="11">11th
        <input type="radio" name="grade" value="12">12th
    </div>
    <div class="col-6">
    <h2>Interested Departments*</h2>
        <p>All meetings are in room 306 afterschool unless otherwise noted. We also take both Junior High and High School students but please note the specified meeting times if noted.</p>
        <input type="checkbox" name="departments[]" value="science"><b>Science: </b>Thursday 8th Period (HS), After School (JH/HS)<br>
        <input type="checkbox" name="departments[]" value="technology"><b>Technology: </b>Wednesday<br>
        <input type="checkbox" name="departments[]" value="robotic"><b>Robotic Engineering: </b>Monday (HS), Friday (JH), Saturday 9AM-12 (All)<br>
        <input type="checkbox" name="departments[]" value="civil"><b>Civil Engineering: </b>Thursday Lunch in Room 511<br>
        <input type="checkbox" name="departments[]" value="math"><b>Mathematics: </b>Tuesday Room 306 (HS), Room 504 (JH)<br>
    <h2>Additional Notes</h2>
    <p>If you have any questions or comments to send to us, you can put words in this box!</p>
    <textarea rows="4" name="message"></textarea>
    <input type="submit" name="submit" value="Submit">
    </div>
</form>
</div>
</section>
<?php
$templ->render('footer');
?>