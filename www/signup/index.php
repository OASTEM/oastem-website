<?php
require_once('../common.php');
require '../../PHPMailer/PHPMailerAutoload.php';

$templ->setTitle('Sign Up');
$templ->render('header');

$name = $_POST["name"];
$email = $_POST["email"];
$parent = $_POST["parent"];
$grade = $_POST["grade"];
$departments = $_POST["departments"];
$message = $_POST["message"];
$subject = "Member Sign Up";
$mail = new PHPMailer;

$body = "The following student is interested in joining your department!<br>"
$body .= "Name: " . $name . "<br>Email: " . $email;
if (isset($_POST["parent"]))
    $body .= "<br>Parent Email: " . $parent;
$body .= "<br>Grade: " . $grade;
if (isset($_POST["message"]))
    $body .= "<br><br>The student also had the following message:<br>" . $message;

$mail->isSMTP();
$mail->Host = 'mail.google.com';
$mail->SMTPAuth = false; 
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('contact@oastem.org', 'Robot from the Website');
$mail->isHTML(true);
$mail->addAddress('executives@veblockparty.com');
$mail->Subject = $subject;
$mail->Body = $body;

if(in_array('science'))
    $mail->addCC('science@oastem.org');
if(in_array('technology'))
    $mail->addCC('technology@oastem.org');
if(in_array('robotic'))
    $mail->addCC('engineering@oastem.org');
if(in_array('civil'))
    $mail->addCC('civilengineering@oastem.org');
if(in_array('math')){
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
?>
<form method="POST">
    <h3>Your Name*</h3>
        <input type="text" name="name" required>
    <h3>Your E-mail*</h3>
        <p>Please do not put your AUHSD email.</p>
        <input type="text" name="email" required>
    <h3>Parent E-Mail</h3>
        <p>If your parents would like to receive updates, leave their email here.</p>
        <input type="text" name="parent">
    <h3>Grade</h3>
        <input type="radio" name="grade" value="7">7th
        <input type="radio" name="grade" value="8">8th
        <input type="radio" name="grade" value="9">9th
        <input type="radio" name="grade" value="10">10th
        <input type="radio" name="grade" value="11">11th
        <input type="radio" name="grade" value="12">12th
    <h3>Interested Departments</h3>
        <p>All meetings are in room 306 afterschool unless otherwise noted. We also take both Junior High and High School students but please note the specified meeting times if noted.</p>
        <input type="checkbox" name="departments[]" value="science">Science: Thursday 8th Period (HS), After School (JH/HS)
        <input type="checkbox" name="departments[]" value="technology">Technology: Wednesday
        <input type="checkbox" name="departments[]" value="robotic">Engineering: Monday (HS), Friday (JH), Saturday 9:00-12:00 (All)
        <input type="checkbox" name="departments[]" value="civil">Civil Engineering: Thursday Lunch in Room 511 
        <input type="checkbox" name="departments[]" value="math">Mathematics: Tuesday Room 306 (HS), Room 504 (JH)
    <h3>Additional Notes</h3>
    <p>If you have any questions or comments to send to us, you can put words in this box!</p>
    <textarea rows="4" name="message"></textarea>
    <input type="submit" name="submit" value="Submit">
</form>
<?php
$templ->render('footer');
?>