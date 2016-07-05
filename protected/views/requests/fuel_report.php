<?php
$Requests_model=new Requests;
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;

if($LOGGED_IN_USER_KIND=='company_user'){
	$CompaniesData=Companies::model()->findByPk($LOGGED_IN_COMPANY);
	$header_text="<font color='#000099'><font size='5'><b>".$CompaniesData->title." Fuel Requests</b></font></font>";
	$colspan=7;
}else if($LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM'){
	$CompaniesData=Companies::model()->findByPk($LOGGED_IN_COMPANY);
	$header_text="<font color='#000099'><font size='5'><b>".$CompaniesData->title." Fuel Requests</b></font></font>";
	$colspan=7;
}else if($LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='Driver'){
	$UsersData=Users::model()->findByPk($LOGGED_IN_USER_ID);
	$header_text="<font color='#000099'><font size='5'><b>Service Requests Raised By ".$UsersData->first_name." ".$UsersData->last_name."</b></font></font>";
	$colspan=6;
}


function DateFormart($Date)
{
	$Day= date("d", strtotime($Date));
	$Month= date("M", strtotime($Date));
	$Year= date("Y", strtotime($Date));
	return $Day."-".$Month."-".$Year;
}
?>
<?php if ($model !== null):?>
<table border="1">
<tr>
<td colspan="<?php echo $colspan;?>" align="center">
<?php
echo $header_text;
?>
</td>
</tr>
	<tr>
    	<th width="100px" align="center">
		     <b>Request Narrative</b>
         </th>
         
          <th width="100px" align="center">
		     <b>Car</b>
         </th>
         
         <?php
		 	if(($LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM') || $LOGGED_IN_USER_KIND=='company_user'){
				?>
                <th width="100px" align="center">
                <b>User (Driver)</b>
                </th>
                <?php
			}
		 ?>
         <th width="100px" align="center">
		    <b>Previous Millage </b>
         </th>
         
		<th width="80px" align="center">
		    <b>Current Millage </b>
         </th>

         <th width="150px" align="center">
		   <b>Consumption</b>
         </th>
        
         <th width="80px" align="center">
		    <b>Current Consumption</b>
         </th>
         
          <th width="80px" align="center">
		   <b>Quantity Requested</b>
         </th>
         
          <th width="400px" align="center">
		   <b>Description</b>
         </th>
          <th width="400px" align="center">
		   <b>Status</b>
         </th>
         
        
          
 	</tr>
    
<?php $loop_count=0;?>
<?php foreach($model as $item): ?>

<?php
$previous_millage=$item['previous_millage'];
$current_millage=$item['current_millage'];
$fuel_quantity=$item['fuel_quantity'];
$Cars=Cars::model()->findByPk($item['car_id']);
$consumption=$Cars->consumption;
$currentConsumption=round(($current_millage-$previous_millage)/$fuel_quantity,1);
if($currentConsumption<($consumption-5)){
	$currentConsumptiontext="<font color='#FF0000'><b>".$currentConsumption."</b></font>";
}else{
	$currentConsumptiontext="<font color='#000099'>".$currentConsumption."</font>";
}
$description=$item['description'];
?>


<tr>     
<td align="center" width="300"><?php echo $Requests_model->requestNarative($item['car_id'],$item['on_behalf'],$item['user_id'],$item['request_raised_user_id']); ?></td> 
<td align="center" width="100"><?php echo $item['number_plate']; ?></td>
<?php
if(($LOGGED_IN_USER_KIND=='company_sub_user' && $COMPANY_SUB_USER_ROLE=='TM') || $LOGGED_IN_USER_KIND=='company_user'){
?>
<td align="center" width="100"><?php echo $item['first_name']." ".$item['last_name']; ?></td>
<?php
}
?>
<td align="center" width="100"><?php echo $previous_millage; ?> KM</td>
<td align="center" width="100"><?php echo $current_millage; ?> KM</td> 
<td align="center" width="150"><?php echo $consumption; ?> (KM/L)</td> 
<td align="center" width="150"><?php echo $currentConsumptiontext; ?> (KM/L)</td> 
<td align="center" width="150"><?php echo $fuel_quantity; ?> Litters</td> 
<td align="center" width="150"><?php echo $description; ?></td>
<?php
if(intval($item['status'])==1){
$status_text="<font color='#000099'>Active</font>";
}else{
$status_text="<font color='#FF0000'>Inactive</font>";
}
?>
<td align="center" width="80"><?php echo $status_text; ?></td>
</tr>
    <?php $loop_count++;?>
     <?php endforeach; ?>
</table>
<?php endif; ?>
<br />
<b>Total Records</b>
<?php echo $loop_count;?>
     
