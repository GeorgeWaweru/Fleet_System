<?php
session_start();
error_reporting(0);
require("class.phpmailer.php");
$company_name=isset($_REQUEST['company_name']) ? base64_decode($_REQUEST['company_name']):'';
$contact_person=isset($_REQUEST['contact_person']) ? base64_decode($_REQUEST['contact_person']):'';
$email=isset($_REQUEST['email']) ? base64_decode($_REQUEST['email']):'';
$site_path=Yii::app()->user->getState('pageSize',Yii::app()->params['site_path']);
$login_link="<a href=".$site_path." target='_blank'>".$site_path."</a>";

if(!empty($company_name)){
	$narative="The password for company <b>".$company_name."</b> has been changed successfully.<br><br> Kindly click on ".$login_link." to login.";
}else{
	$narative="Your password has been changed successfully.<br><br> Kindly click on ".$login_link." to login.";
}
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
<title></title>
</head>
<body>
Dear '.$contact_person.'
<br><br>
'.$narative.'
<br><br>
</body>
</html>';
SendEmail("Password changed", $email_body, $email,$user_names, $debug_mode = 0);
echo 1;
?>