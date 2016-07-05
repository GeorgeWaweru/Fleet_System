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

$user_names=isset($_REQUEST['names']) ? base64_decode($_REQUEST['names']):'';
$email=isset($_REQUEST['email']) ? base64_decode($_REQUEST['email']):'';
$position=isset($_REQUEST['position']) ? base64_decode($_REQUEST['position']):'';
$location=isset($_REQUEST['location']) ? base64_decode($_REQUEST['location']):'';

$party=isset($_REQUEST['party']) ? base64_decode($_REQUEST['party']):'';
$party_profile_pic=isset($_REQUEST['party_profile_pic']) ? base64_decode($_REQUEST['party_profile_pic']):'';


$candidate_password=isset($_REQUEST['password']) ? base64_decode($_REQUEST['password']):'';


function SendEmail($email_subject, $email_body, $send_to_email, $user_names, $debug_mode = 0){
  $mail = new PHPMailer();
  $mail->IsHTML(true);
  //$mail->AddEmbeddedImage("mpesa_logo.png", "mpesa_logo", "mpesa_logo.png");
  $mail->AddEmbeddedImage("athletics_edm.jpg", "athletics_edm", "athletics_edm.jpg");
  $mail->AddEmbeddedImage("call.jpg", "call", "call.jpg");
  $mail->IsSMTP();
  $mail->SMTPDebug  = false;
  $mail->do_debug = 0;
  $mail->SMTPAuth   = false;
  $mail->Host       = SMPT_SERVER_HOST;
  $mail->SetFrom(EMAIL_SENDING_ADDRESS, EMAIL_SENDING_NAME);
  $mail->Subject    = !empty($email_subject) ? $email_subject : "";
  $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
  $email_body = !empty($email_body) ? $email_body : "";
  $mail->MsgHTML($email_body);
  $send_to_name = !empty($send_to_name) ? $send_to_name : "";
  $mail->AddAddress($send_to_email, $send_to_name);
  if(!$mail->Send()) {
   //return $mail->ErrorInfo;
  } else {
	  
    //return true;
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
        <td style="color: #6CB536; font-size: 18px; font-weight: bold; font-family:'.$Century_Gothic.', helvetica, san-serif;">Dear '.$user_names.'</td>
      </tr>
      <tr><td height="10"></td></tr>
      <tr>
        <td style="font-size:13px; font-family: '.$Century_Gothic.', helvetica, serif;" >
		
		Your account has been updated successfully. Below are your details. <br>
		
		<b>Email:</b>  '.$email.'<br><br>
		<b>Position:</b> '.$position.'<br><br>
		<b>Location:</b> '.$location.'<br><br>
		<b>Party:</b> '.$party.'<br><br>
		
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
SendEmail("Safaricom Athletics", $email_body, $email,$user_names, $debug_mode = 0);

?>