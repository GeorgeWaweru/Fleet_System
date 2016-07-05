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

$previous_millage=$Requests->previous_millage;
$current_millage=$Requests->current_millage;
$fuel_quantity=$Requests->fuel_quantity;
$consumption=$Cars->consumption;
$currentConsumption=round(($current_millage-$previous_millage)/$fuel_quantity,1);


$Users=Users::model()->findByPk($Requests->user_id);
$current_car=$CarMake->title . ' '. $CarModels->title." (".$Cars->number_plate.")";
$driver=$Users->first_name." ".$Users->last_name;
$narrative="<font color='#000099'><b>Fuel Request for</b></font> - ".$Requests_model->requestNarativeReport($Requests->car_id,$Requests->on_behalf,$Requests->user_id,$Requests->request_raised_user_id);
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
<td width="160">
<b>Request Narrative</b>
</td>
<td align="left" width="300"><?php echo $narrative;?></td> 
</tr>


<tr>
<td>
<b>Car</b>
</td>
<td align="left" width="300"><?php echo $current_car;?></td> 
</tr>

<tr>
<td>
<b>User (Driver)</b>
</td>
<td align="left" width="300"><?php echo $driver;?></td> 
</tr>

<tr>
<td>
<b>Request Raised on </b>
</td>
<td align="left" width="300"><?php echo DateFormart($Requests->created_at);?></td> 
</tr>

<tr>
<td>
<b>Previous Millage </b>
</td>
<td align="left" width="300"><?php echo $previous_millage;?> KM</td> 
</tr>

<tr>
<td>
<b>Current Millage </b>
</td>
<td align="left" width="300"><?php echo $current_millage;?> KM </td> 
</tr>

<tr>
<td>
<b>Consumption</b>
</td>
<td align="left" width="300"><?php echo $consumption;?> (KM/L)</td> 
</tr>

<tr>
<td>
<b>Current Consumption</b>
</td>
<?php
if($currentConsumption<($consumption-5)){
	$currentConsumptiontext="<font color='#FF0000'><b>".$currentConsumption."</b></font>";
}else{
	$currentConsumptiontext="<font color='#000099'>".$currentConsumption."</font>";
}
?>
<td align="left" width="300"><?php echo $currentConsumptiontext;?> (KM/L)</td> 
</tr>

<tr>
<td>
<b>Quantity Requested</b>
</td>
<td align="left" width="300"><?php echo $fuel_quantity;?> Litters</td> 
</tr>


<?php
if(intval($Requests->no_description)==0)
{
	?>
<tr>
<td>
<b>Description</b>
</td>
<td align="left" width="300"><?php echo $Requests->description;?></td> 
</tr>
    <?php
}
?> 
</table>
    <?php
	
}
?>
