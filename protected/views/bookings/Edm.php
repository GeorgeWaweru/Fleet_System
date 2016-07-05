<?php
session_start();
//error_reporting(0);
define('SMPT_SERVER_HOST','mail.scangroup.biz');// SMPT_SERVER_HOST
define('SMPT_SERVER_PORT','2525');// SMPT_SERVER_PORT
define('SMPT_EMAIL_ACCOUNT','');// SMPT_EMAIL_ACCOUNT
define('SMPT_EMAIL_PASSWORD','');// SMPT_EMAIL_PASSWORD
define('EMAIL_SENDING_ADDRESS','george.waweru@squaddigital.com');// EMAIL_SENDING_ADDRESS
define('EMAIL_SENDING_NAME','Fleet Management System');// EMAIL_SENDING_NAME
define('EMAIL_SUBJECT','Fleet Management System');// EMAIL_SUBJECT
require("class.phpmailer.php");

$id=isset($_REQUEST['id']) ? intval(base64_decode($_REQUEST['id'])):0;
$Bookings=Bookings::model()->findByPk($id);

$request_type=$Bookings->request_type;

$Suppliers=Suppliers::model()->findByPk($Bookings->supplier_id);
$Requests=Requests::model()->findByPk($Bookings->request_id);

$Companies=Companies::model()->findByPk($Requests->company_id);

$Cars=Cars::model()->findByPk($Requests->car_id);
$CarMake=CarMake::model()->findByPk($Cars->make_id);
$CarModels=CarModels::model()->findByPk($Cars->model_id);
$System=System::model()->findByPk($Requests->system_id);
$SubSystem=SubSystem::model()->findByPk($Requests->subsystem_id);

$narative = $CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.") -".$System->title." / ".$SubSystem->title;
$Roles=Roles::model()->findByAttributes(array('is_tm'=>1,'status'=>1));
$tm_role_id=$Roles->id;	
$TMUserData=Users::model()->findByAttributes(array('role_id'=>$tm_role_id,'company_id'=>$Requests->company_id));
$tmEmailAddress=$TMUserData->email;

$supplieEmail=$Suppliers->email;
$supplierNames=$Suppliers->contact_person;
$CompaniesName=$Companies->title;

			

function SendEmail($email_subject, $email_body, $send_to_email, $user_names, $tmEmailAddress, $debug_mode = 0){
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
Dear '.$supplierNames.',
<br><br>

The company '.$CompaniesName.' has booked the below request. <br><br>
'.$narative.'
<br><br>
Kindly action it.
	
</body>
</html>
';

SendEmail($request_type." Request Booking", $email_body, $supplieEmail,$supplierNames, $tmEmailAddress, $debug_mode = 0);
CarAssignment::model()->updateByPk($id,array('email_sent'=>1));
?>