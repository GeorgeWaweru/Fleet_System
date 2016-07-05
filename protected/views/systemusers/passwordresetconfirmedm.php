<?php
session_start();
error_reporting(0);
define('SMPT_SERVER_HOST','mail.scangroup.biz');// SMPT_SERVER_HOST
define('SMPT_SERVER_PORT','2525');// SMPT_SERVER_PORT
define('SMPT_EMAIL_ACCOUNT','');// SMPT_EMAIL_ACCOUNT
define('SMPT_EMAIL_PASSWORD','');// SMPT_EMAIL_PASSWORD
define('EMAIL_SENDING_ADDRESS','george.waweru@squaddigital.com');// EMAIL_SENDING_ADDRESS
define('EMAIL_SENDING_NAME','Safaricom Athletics');// EMAIL_SENDING_NAME
define('EMAIL_SUBJECT','Safaricom Athletics');// EMAIL_SUBJECT
require("class.phpmailer.php");

$user_names=isset($_SESSION['pass_reset_names']) ? $_SESSION['pass_reset_names']:'';
$email=isset($_SESSION['pass_reset_email']) ? $_SESSION['pass_reset_email']:'';


function SendEmail($email_subject, $email_body, $send_to_email, $user_names, $debug_mode = 0){
  $mail=new PHPMailer();
	$mail->From = 'info@fleetfy.com';
	$mail->FromName = 'Fleet Management System';
	$mail->addAddress($send_to_email, $user_names);
	$mail->isHTML(true);
	$mail->Subject = $email_subject;
	$mail->Body    = $email_body;
	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	if(!$mail->send()) {
		
	} else {
		
	}
 }


$Century_Gothic='Century Gothic'; 
$apostrophy="'";
$email_body='
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
Dear '.$user_names.',
<br><br>
You have successfully updated your password.
</body>
</html>
';
SendEmail("Password changed", $email_body, $email,$user_names, $debug_mode = 0);
unset($_SESSION['pass_reset_names']);
unset($_SESSION['pass_reset_email']);
unset($_SESSION['pass_reset_record']);
unset($_SESSION['pass_reset_record_type']);


?>