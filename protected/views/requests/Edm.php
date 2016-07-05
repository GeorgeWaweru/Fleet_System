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
$Requests=Requests::model()->findByPk($id);

$Cars=Cars::model()->findByPk($Requests->car_id);
$Users=Users::model()->findByPk($Requests->user_id);
$Companies=Companies::model()->findByPk($Requests->company_id);
$System=System::model()->findByPk($Requests->system_id);
$SubSystem=SubSystem::model()->findByPk($Requests->subsystem_id);
$CarMake=CarMake::model()->findByPk($Cars->make_id);
$CarModels=CarModels::model()->findByPk($Cars->model_id);


$CarRequested=$CarMake->title." ".$CarModels->title." (".$Cars->number_plate.")";
$user_Requested_names=$Users->first_name." ".$Users->last_name;
$user_Requested_email=$Users->email;
$user_Requested_company=$Companies->title;


$request_type=$Requests->request_type;
$previous_millage=$Requests->previous_millage;
$current_millage=$Requests->current_millage;
$fuel_quantity=$Requests->fuel_quantity;
$consumption=$Cars->consumption;
$currentConsumption=$fuelConsumption=round(($current_millage-$previous_millage)/$fuel_quantity,1);


$description=$Requests->description;
$no_description=$Requests->no_description;
$on_behalf=$Requests->on_behalf;
$request_raised_user_id=$Requests->request_raised_user_id;
$created_at=$Requests->created_at;

$Requester=Users::model()->findByPk($Requests->request_raised_user_id);
$Requester_names=$Requester->first_name." ".$Requester->last_name;


if(intval($on_behalf)==1){
	$intro= $Requester_names."has raised a ".$request_type." request on your bahalf of the driver (".$user_Requested_names.") for the the car ".$CarRequested."";
}else{
	$intro=" The Driver ".$user_Requested_names." has raised a ".$request_type." request for the car ".$CarRequested;
}


if($request_type=='service' || $request_type=='repair')
{
	$summary="<b>System</b>: ".$System->title. "<br><br><b>Sub System </b>".$SubSystem->title."<br><br>";
	
	
}else if($request_type=='fuel')
{
	$summary="<b>Previous Millage</b>: ".$previous_millage. "<br><br><b>Current Millage </b>".$current_millage."<br><br><b> Consumption </b>".$consumption." Curent Consumption".$currentConsumption."<br><br>";
}

if($no_description==0 && !empty($description))
{
	$summary=$summary."<b> Description </b>".$description;
}

$Roles=Roles::model()->findByAttributes(array('is_tm'=>1,'status'=>1));
$tm_role_id=$Roles->id;	
$TMUserData=Users::model()->findByAttributes(array('role_id'=>$tm_role_id,'company_id'=>$Requests->company_id));
$tmEmailAddress=$TMUserData->email;



					

function SendEmail($email_subject, $email_body, $send_to_email, $user_names,$tmEmailAddress, $debug_mode = 0){
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
Dear '.$user_Requested_names.',
<br><br>


'.$intro.'<br><br>

Below is a summary of the '.$request_type.' Request.<br><br>


'.$summary.'
	
</body>
</html>
';

$edmTitle=ucfirst($request_type)." Request";
SendEmail($edmTitle, $email_body, $user_Requested_email,$user_Requested_names,$tmEmailAddress, $debug_mode = 0);
Requests::model()->updateByPk($id,array('email_sent'=>1));
?>