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

$CarAssignment=CarAssignment::model()->findByPk($id);

$Cars=Cars::model()->findByPk($CarAssignment->car_id);
$Users=Users::model()->findByPk($CarAssignment->user_id);
$Companies=Companies::model()->findByPk($CarAssignment->company_id);
$CarMake=CarMake::model()->findByPk($Cars->make_id);
$CarModels=CarModels::model()->findByPk($Cars->model_id);


$car_assigned=$CarMake->title." ".$CarModels->title." (".$Cars->number_plate.")";
$user_assigned_names=$Users->first_name." ".$Users->last_name;
$user_assigned_email=$Users->email;
$user_assigned_company=$Companies->title;


$spare_tire=(intval($CarAssignment->spare_tire) == 1 ? 'Yes' : 'No');
$fire_extinguisher=(intval($CarAssignment->fire_extinguisher) == 1 ? 'Yes' : 'No');
$jerk=(intval($CarAssignment->jerk) == 1 ? 'Yes' : 'No');
$wheel_spanner=(intval($CarAssignment->wheel_spanner) == 1 ? 'Yes' : 'No');


$physical_damages=$CarAssignment->physical_damages;
$no_physical_damages=$CarAssignment->no_physical_damages;
$mechanical_issues=$CarAssignment->mechanical_issues;
$no_mechanical_issues=$CarAssignment->no_mechanical_issues;



if($no_physical_damages==0 && !empty($physical_damages))
{
	$physical_damages_section="<b>Physical Damages</b><br>".$physical_damages."";
	$CarAssignPhysicalDamages=CarAssignPhysicalDamages::model()->findAllByAttributes(array('car_assignment_id'=>$id));
	if(count($CarAssignPhysicalDamages)>0)
	{
		$subData="<table>";
	foreach($CarAssignPhysicalDamages as $item)
	{
		$base_path=Yii::app()->user->getState('site_path',Yii::app()->params['site_path']);
		$Imagepath=$base_path.'/car_assign_physical_damage/'.$item->photo;
		$subData=$subData."<tr><td><img src='".$Imagepath."' width='80' height='80'></td><td>".$item->description."</td></tr>";
	}
		$subData=$subData."</table>";
	}
	$physical_damages_section=$physical_damages_section.$subData;
}


if($no_mechanical_issues==0 && !empty($mechanical_issues))
{
	$mechanical_issues_section="<b>Mechanical Issues</b><br>".$mechanical_issues."";
	$CarAssignMechanicalIssues=CarAssignMechanicalIssues::model()->findAllByAttributes(array('car_assignment_id'=>$id));
	if(count($CarAssignMechanicalIssues)>0)
	{
		$subData="<table>";
	foreach($CarAssignMechanicalIssues as $item)
	{
		$base_path=Yii::app()->user->getState('site_path',Yii::app()->params['site_path']);
		$Imagepath=$base_path.'/car_assign_mechanical_issues/'.$item->photo;
		$subData=$subData."<tr><td><img src='".$Imagepath."' width='80' height='80'></td><td>".$item->description."</td></tr>";
	}
		$subData=$subData."</table>";
	}
	$mechanical_issues_section=$mechanical_issues_section.$subData;
}

$Roles=Roles::model()->findByAttributes(array('is_tm'=>1,'status'=>1));
$tm_role_id=$Roles->id;	
$TMUserData=Users::model()->findByAttributes(array('role_id'=>$tm_role_id,'company_id'=>$Requests->company_id));
$tmEmailAddress=$TMUserData->email;



					

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
Dear '.$user_assigned_names.',
<br><br>
You have been assigned the car <b>'.$car_assigned.'</b><br><br>

Below is a summary of the car details.<br><br>

<b>Spare Tyre</b> : '.$spare_tire.'<br><br>
<b>Fire Extinguisher</b> : '.$fire_extinguisher.'<br><br>
<b>Jerk</b> : '.$jerk.'<br><br>
<b>Wheel Spanner</b> : '.$wheel_spanner.'<br><br>

'.$physical_damages_section.'
<br><br>
'.$mechanical_issues_section.'
	
</body>
</html>
';

SendEmail("Car Assignment", $email_body, $user_assigned_email,$user_assigned_names, $tmEmailAddress, $debug_mode = 0);
CarAssignment::model()->updateByPk($id,array('email_sent'=>1));
?>