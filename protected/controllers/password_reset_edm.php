<?php
error_reporting(0);	
require_once("class.phpmailer.php");
function NotifyUser($user_name,$user_email,$subject,$reset_params)
{
$redirect_path=Yii::app()->controller->createUrl('admin');
$site_path=Yii::app()->params['site_path'];
$email_url=$site_path."admin/index.php?r=site/updatepassword&params=".$reset_params;
$year=date('Y');
$date_sent=strtoupper(date('d'))." / ".strtoupper(date('M'))." / ".date('Y');
$Century_Gothic="Century Gothic";
$email_body='

Dear '.$user_name.', <br><br>
Kindly click on the link below to reset your password. <br><br>
<a target="_blank" href="'.$email_url.'">'.$email_url.'</a>
';

$mail=new PHPMailer();
$mail->From = 'george@buyfromout.com';
$mail->FromName = 'Diaspora Kenya';
$mail->AddEmbeddedImage("edm_logo.jpg", "edm_logo", "edm_logo.jpg");
$mail->addAddress($user_email, $user_name);
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body    = $email_body;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
if(!$mail->send()) {
} else {
}
}


$reset_params=isset($_SESSION['reset_params']) ? $_SESSION['reset_params']:"";
$reset_names=isset($_SESSION['reset_names']) ? $_SESSION['reset_names']:"";
$reset_email=isset($_SESSION['reset_email']) ? $_SESSION['reset_email']:"";
$user_name=$reset_names;
$user_email=$reset_email;

$subject="Reset Password";
NotifyUser($user_name,$user_email,$subject,$reset_params);
?>