<?php
$Requests_model=new Requests;
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
    
  
$Requests=Requests::model()->findByPk($id);	
$Cars=Cars::model()->findByPk($Requests->car_id);
$CarMake=CarMake::model()->findByPk($Cars->make_id);
$CarModels=CarModels::model()->findByPk($Cars->model_id);

$System=System::model()->findByPk($Requests->system_id);
$SubSystem=SubSystem::model()->findByPk($Requests->subsystem_id);



$Users=Users::model()->findByPk($Requests->user_id);
$current_car=$CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.")";
$driver=$Users->first_name." ".$Users->last_name;
$narrative="<font color='#000099'><b>Repair Request for</b></font> - ".$Requests_model->requestNarativeReport($Requests->car_id,$Requests->on_behalf,$Requests->user_id,$Requests->request_raised_user_id);
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
<b>Request Narrative</b>
</td>
<td align="left" width="300"><?php echo $narrative;?></td> 
</tr>


<tr>
<td width="120">
<b>Car</b>
</td>
<td align="left" width="300"><?php echo $current_car;?></td> 
</tr>

<tr>
<td width="120">
<b>User (Driver)</b>
</td>
<td align="left" width="300"><?php echo $driver;?></td> 
</tr>

<tr>
<td width="120">
<b>Request Raised on </b>
</td>
<td align="left" width="300"><?php echo DateFormart($Requests->created_at);?></td> 
</tr>

<tr>
<td width="120">
<b>System</b>
</td>
<td align="left" width="300"><?php echo $System->title;?></td> 
</tr>

<tr>
<td width="120">
<b>Sub System</b>
</td>
<td align="left" width="300"><?php echo $SubSystem->title;?></td> 
</tr>

<?php
if(intval($Requests->no_description)==0)
{
	?>
<tr>
<td width="120">
<b>Description</b>
</td>
<td align="left" width="300"><?php echo $Requests->description;?></td> 
</tr>
    <?php
}
?>




<?php
if(intval($Requests->no_description)==0)
{
$RequestSubDetails=RequestSubDetails::model()->findAllByAttributes(array('request_id'=>$Requests->id));
	if(count($RequestSubDetails)>0)
	{
		?>
        
            <tr>
            <td colspan="2" align="center">
            <font color="#000099"><b>Request Details</b></font>
            </td>
            </tr>
            
            <tr>
            <td align="center">
            <b>Photo</b>
            </td>
            <td align="center">
            <b>Description</b>
            </td>
            </tr>
            <?php
			foreach($RequestSubDetails as $item)
			{
				?>
                <tr>
                <td width="140" height="100" valign="middle" align="center">
                <?php echo $Requests_model->ReportImage($item->photo,'requests'); ?>
                </td>
                <td align="left">
                <?php echo $item->description;?>
                </td>
                </tr>
                <?php
			}
	}
}
?> 
</table>
    <?php
	
}
?>
