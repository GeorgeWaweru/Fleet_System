<?php
session_start();
define('EMAIL_SENDING_NAME','Fleet Management System');// EMAIL_SENDING_NAME
define('EMAIL_SUBJECT','Fleet Management System');// EMAIL_SUBJECT
require("class.phpmailer.php");
$id=isset($_REQUEST['id']) ? intval(base64_decode($_REQUEST['id'])):0;

$BookingComments=BookingComments::model()->findByPk($id);
$BookingSpares=BookingSpares::model()->findByAttributes(array('booking_comment_id'=>$id));

$booking_id=$BookingComments->booking_id;
$supplier_id=$BookingComments->supplier_id;
$user_id=$BookingComments->user_id;
$UsersData=Users::model()->findByAttributes(array('is_default'=>1));
$Defaultuser_id=$UsersData->id;
$SuppliersData=Suppliers::model()->findByAttributes(array('is_default'=>1));
$Defaultsupplier_id=$SuppliersData->id;


if(($supplier_id!==$Defaultsupplier_id) && ($Defaultuser_id==$user_id))
{
	$BookingsModel=new Bookings;
	$Suppliers=Suppliers::model()->findByPk($supplier_id);
	$SuppliersName=$Suppliers->title;
	$Bookings=Bookings::model()->findByPk($booking_id);
	$Companies=Companies::model()->findByPk($Bookings->company_id);
	$Roles=Roles::model()->findByAttributes(array('is_tm'=>1,'status'=>1));
	$Users=Users::model()->findByAttributes(array('company_id'=>$Companies->id,'role_id'=>$Roles->id));
	$RecipientEmailAddress=$Users->email;
	$RecipientNames=$Users->first_name." ".$Users->last_name;
	$narrative=" The supplier ".$SuppliersName." has commented on the <b>".$Bookings->request_type."</b> Booking for "."
    the request <b> ".$BookingsModel->requestNarrative($Bookings->request_id)."</b>";
	
}else if(($Defaultuser_id!==$user_id) && ($supplier_id==$Defaultsupplier_id))
{
	$BookingsModel=new Bookings;
	$Bookings=Bookings::model()->findByPk($booking_id);
	$Suppliers=Companies::model()->findByPk($Bookings->supplier_id);
	$Companies=Companies::model()->findByPk($Bookings->company_id);
	$Users=Users::model()->findByPk($user_id);
	$Roles=Roles::model()->findByPk($Users->role_id);
	$RecipientNames=$Suppliers->contact_person;
	$RecipientEmailAddress=$Suppliers->email;
	$narrative="The ".$Roles->title." (".$Users->first_name." ".$Users->last_name.") of company- ".$Companies->title." has commented on the<b>".$Bookings->request_type."</b> Booking for "."
    the request <b> ".$BookingsModel->requestNarrative($Bookings->request_id)."</b>";
}



	$BookingComments_section=$BookingComments->comment."<br>";
	if(count($BookingSpares)>0)
	{
	$subData="<table>";
	foreach($BookingSpares as $item)
	{
	$Spare=Spare::model()->findByPk($item->spare_id);
	$subData=$subData."<tr><td>".$Spare->title."</td><td>".$item->spare_cost."</td></tr>";
	}
	$subData=$subData."</table>";
	}
	$BookingComments_section=$BookingComments_section.$subData;
						


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
Dear '.$RecipientNames.',
<br><br>
'.$narrative.'

Below is a summary of the comment.<br><br>
'.$BookingComments_section.'	
</body>
</html>
';
SendEmail("Booking Comments", $email_body, $RecipientEmailAddress,$RecipientNames, $tmEmailAddress, $debug_mode = 0);
?>