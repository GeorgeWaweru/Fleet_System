<?php
session_start();
error_reporting(0);
require("class.phpmailer.php");
$names=isset($_REQUEST['names']) ? base64_decode($_REQUEST['names']):'';
$role=isset($_REQUEST['role']) ? base64_decode($_REQUEST['role']):'';
$email=isset($_REQUEST['email']) ? base64_decode($_REQUEST['email']):'';
$password=isset($_REQUEST['password']) ? base64_decode($_REQUEST['password']):'';
$site_path=Yii::app()->user->getState('pageSize',Yii::app()->params['site_path']);
$login_link="<a href=".$site_path." target='_blank'>".$site_path."</a>";


function SendEmail($email_subject, $email_body, $send_to_email, $user_names, $debug_mode = 0){
	$mail=new PHPMailer();
	$mail->From = 'info@fleetfy.com';
	$mail->FromName = 'Fleet System';
	$mail->addAddress($send_to_email, $user_names);
	$mail->isHTML(true);
	$mail->Subject = $subject;
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
Dear '.$names.'
<br><br>
Your account has been successfully created use the blow details to login. <br><br>
<b>Login Url:</b>  '.$login_link.'<br><br>
<b>Email:</b>  '.$email.'<br><br>
<b>Password:</b> '.$password.'<br><br>
		
		
</body>
</html>
';
SendEmail("Account Created", $email_body, $email,$user_names, $debug_mode = 0);

?>