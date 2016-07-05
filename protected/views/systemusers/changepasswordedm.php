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

$pass_reset_names=isset($_SESSION['pass_reset_names']) ? $_SESSION['pass_reset_names']:'';
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
<!DOCTYPE html>
<html>
<head>
	<title>Safaricom Athleticd</title>
    <style type="text/css" >
    	html, body, img{margin:0; padding:0;}
		@media only screen and (max-width : 600px) {
			.expand{width:100%;}
			.tbody{width:100%;}
			.inner{width:95%;}
		}
    </style>
</head>	
<body bgcolor="#eee" style="background:#eee;">

<table width="600" align="center" cellpadding="0" cellspacing="0" class="tbody" bgcolor="#ffffff" style="margin:0 auto;">
  <tr>
    <td><img src="cid:athletics_edm" class="expand"  alt="safaricom athletics"/></td>
  </tr>
  <tr>
    <td>
    <!-- main body  --> 
    <table width="560" align="center" class="inner" cellspacing="0" cellpadding="0" style="margin:0 auto;" >
      <tr><td height="20"></td></tr>
      <tr>
        <td style="color: #6CB536; font-size: 18px; font-weight: bold; font-family:'.$Century_Gothic.', helvetica, san-serif;">Dear '.$pass_reset_names.'</td>
      </tr>
      <tr><td height="10"></td></tr>
      <tr>
        <td style="font-size:13px; font-family: '.$Century_Gothic.', helvetica, serif;" >
		
		You have successfully updated your password.
		
		<br><br>
		
          </td>
      </tr>
      <tr><td height="5"></td></tr>
   
 
      <tr><td height="20"></td></tr>
   
      <tr><td height="20"></td></tr>
    </table>
    </td>
  </tr>
  
</table>

</body>
</html>';
SendEmail("Password Update", $email_body, $email,$user_names, $debug_mode = 0);

unset($_SESSION['edm_user_names']);
unset($_SESSION['edm_pass_token']);
unset($_SESSION['edm_email']);
unset($_SESSION['edm_reset_type']);

unset($_SESSION['pass_reset_names']);
unset($_SESSION['pass_reset_email']);
unset($_SESSION['pass_reset_record']);
unset($_SESSION['pass_reset_record_type']);


?>