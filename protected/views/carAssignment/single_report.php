<?php
$CarAssignment_model=new CarAssignment;
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
 
    
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


function DateFormart($Date)
{
	$Day= date("d", strtotime($Date));
	$Month= date("M", strtotime($Date));
	$Year= date("Y", strtotime($Date));
	return $Day."-".$Month."-".$Year;
}
?>

<?php if(count($Cars)>0)
{
	?>
    <?php
if(($LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM') || $LOGGED_IN_USER_KIND=='company_user'){
	?>
    
    <?php
}
?>

<table border="1">


<tr>
<td width="120">
<b>Car Assigned</b>
</td>
<td align="left" width="300"><?php echo $car_assigned;?></td> 
</tr>


<tr>
<td width="120">
<b>User (Driver)</b>
</td>
<td align="left" width="300"><?php echo $user_assigned_names;?></td> 
</tr>

<tr>
<td width="120">
<b>Assignment Date</b>
</td>
<td align="left" width="300"><?php echo DateFormart($CarAssignment->created_at);?></td> 
</tr>

<tr>
<td width="120">
<b>Spare Tyre</b>
</td>
<td align="left" width="300"><?php echo $spare_tire;?></td> 
</tr>

<tr>
<td width="120">
<b>Fire Extinguisher</b>
</td>
<td align="left" width="300"><?php echo $fire_extinguisher;?></td> 
</tr>

<tr>
<td width="120">
<b>Jerk</b>
</td>
<td align="left" width="300"><?php echo $jerk;?></td> 
</tr>

<tr>
<td width="120">
<b>Wheel Spanner</b>
</td>
<td align="left" width="300"><?php echo $wheel_spanner;?></td> 
</tr>




<?php
if($no_physical_damages==0 && !empty($physical_damages))
{
	?>
<tr>
<td width="120">
<b>Physical Damages</b>
</td>
<td align="left" width="300"><?php echo $physical_damages;?></td> 
</tr>
    <?php
}
?>


<?php
$CarAssignPhysicalDamages=CarAssignPhysicalDamages::model()->findAllByAttributes(array('car_assignment_id'=>$id));
if(count($CarAssignPhysicalDamages)>0)
{
	foreach($CarAssignPhysicalDamages as $item)
	{
		?>
		<tr>
		<td width="120" height="100" valign="middle" align="center">
		 <?php echo $CarAssignment_model->ReportImage($item->photo,'car_assign_physical_damage'); ?>
		</td> 
		<td align="left" width="300"><?php echo $item->description;?></td> 
		</tr>
		<?php
	}
}
?>



<?php
if($no_mechanical_issues==0 && !empty($mechanical_issues))
{
	?>
<tr>
<td width="120">
<b>Mechanical Issues</b>
</td>
<td align="left" width="300"><?php echo $mechanical_issues;?></td> 
</tr>
    <?php
}
?>


<?php
$CarAssignMechanicalIssues=CarAssignMechanicalIssues::model()->findAllByAttributes(array('car_assignment_id'=>$id));
if(count($CarAssignMechanicalIssues)>0)
{
	foreach($CarAssignMechanicalIssues as $item)
	{
		?>
		<tr>
		<td width="120" height="100" valign="middle" align="center">
		 <?php echo $CarAssignment_model->ReportImage($item->photo,'car_assign_mechanical_issues'); ?>
		</td> 
		<td align="left" width="300"><?php echo $item->description;?></td> 
		</tr>
		<?php
	}
}
?>





</table>
    <?php
	
}
?>
