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


$edm_reset_type=isset($_REQUEST['edm_reset_type']) ? intval($_REQUEST['edm_reset_type']):0;
$edm_pass_token=isset($_REQUEST['edm_pass_token']) ? base64_decode($_REQUEST['edm_pass_token']):'';
$user_names=isset($_REQUEST['edm_user_names']) ? base64_decode($_REQUEST['edm_user_names']):'';
$email=isset($_REQUEST['edm_email']) ? base64_decode($_REQUEST['edm_email']):'';



$final_token=base64_encode($edm_reset_type."(##)".$edm_pass_token);


define('SITE_BASE_URL','http://buyfromout.com');// SITE_BASE_URL
$url=SITE_BASE_URL.Yii::app()->controller->createUrl('Site/updatepassword')."&token=".$final_token."";								

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

<br><br><br>

Kindly click on this link or copy paste it to your browser to reset your password.<br><br>
<a href='.$url.' target="_blank">'.$url.'</a>


</body>
</html>

';

SendEmail("Password Reset", $email_body, $email,$user_names, $debug_mode = 0);
?>