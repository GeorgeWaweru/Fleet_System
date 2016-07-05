<?php
session_start();
$cars_model=new Cars;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";

function DateFormart($Date)
{
	$Day= date("d", strtotime($Date));
	$Month= date("M", strtotime($Date));
	$Year= date("Y", strtotime($Date));
	return $Day."-".$Month."-".$Year;
}
?>
<?php if ($model !== null):?>


<?php //echo $users_model->ReportBanner("logo_gova.png"); ?>
<table border="1">
	<tr>
    
    	<?php
		if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
			?>
            <th width="100px" align="center">
		     <b>Company</b>
         	</th>
            <?php
		}
		?>
    	<th width="100px" align="center">
		     <b>Photo</b>
         </th>
         <th width="100px" align="center">
		     <b>Registration No.</b>
         </th>
         
		<th width="80px" align="center">
		     <b>Make</b>
         </th>

         <th width="80px" align="center">
		     <b>Model</b>
         </th>
         
          <th width="80px" align="center">
		     <b>Body Type</b>
         </th>
         <th width="80px" align="center">
		     <b>Year</b>
         </th>
          <th width="80px" align="center">
		     <b>Chasis No.</b>
         </th>
         
          <th width="80px" align="center">
		     <b>Engine No.</b>
         </th>
          <th width="80px" align="center">
		     <b>Consumption</b>
         </th>
         
          <th width="80px" align="center">
		     <b>Fuel type</b>
         </th>
          <th width="80px" align="center">
		     <b>Millage</b>
         </th>
          <th width="80px" align="center">
		     <b>Country</b>
         </th>
         
          <th width="80px" align="center">
		     <b>Tyre size</b>
         </th>
          <th width="150px" align="center">
		     <b>Last Service Date</b>
         </th>
          <th width="150px" align="center">
		     <b>Last Service Millage</b>
         </th>
         
          <th width="150px" align="center">
		     <b>Insurance Expiry Date</b>
         </th>
         
          <th width="80px" align="center">
		     <b>Serice Millage</b>
         </th>
          <th width="80px" align="center">
		     <b>Spare Tyre</b>
         </th>
          <th width="150px" align="center">
		     <b>Fire Extinguisher</b>
         </th>
         
         <th width="80px" align="center">
		     <b>Jerk</b>
         </th>
         <th width="80px" align="center">
		     <b>Wheel Spanner</b>
         </th>
         <th width="80px" align="center">
		     <b>Status</b>
         </th>
          
 	</tr>
    
<?php $loop_count=0;?>
<?php foreach($model as $item): ?>
<tr>    
<?php
if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
?>
<td align="center" width="100"><?php echo $item['Company']; ?></td> 
<?php
}
?>          
<td align="center" width="85" height="80"><?php echo $cars_model->ReportImage($item['photo'],'cars'); ?></td> 
<td align="center" width="100"><?php echo $item['number_plate']; ?></td>
<td align="center" width="100"><?php echo $item['car_make']; ?></td>
<td align="center" width="100"><?php echo $item['car_model']; ?></td>
<td align="center" width="100"><?php echo $item['body_type']; ?></td> 
<td align="center" width="100"><?php echo $item['Car_year']; ?></td> 
<td align="center" width="100"><?php echo $item['chasis_number']; ?></td> 
<td align="center" width="100"><?php echo $item['Engine_model']; ?></td> 
<td align="center" width="100"><?php echo $item['consumption']; ?> KM/L</td>
<td align="center" width="100"><?php echo $item['fuel_type']; ?></td> 
<td align="center" width="100"><?php echo $item['millage']; ?> KM</td> 
<td align="center" width="100"><?php echo $item['country']; ?></td>
<td align="center" width="100"><?php echo $item['car_Tyre']; ?></td>
<td align="center" width="150"><?php echo DateFormart($item['last_service_date']); ?></td>
<td align="center" width="150"><?php echo $item['last_service_millage']; ?> KM</td>
<td align="center" width="150"><?php echo DateFormart($item['insurance_exp_date']); ?></td>
<td align="center" width="100"><?php echo $item['service_millage']; ?> KM</td>
<td align="center" width="100"><?php if(intval($item['spare_tire'])==1){?> Yes <?php }else{?> No <?php } ?></td>
<td align="center" width="150"><?php if(intval($item['fire_extinguisher'])==1){?> Yes <?php }else{?> No <?php } ?></td>
<td align="center" width="100"><?php if(intval($item['jerk'])==1){?> Yes <?php }else{?> No <?php } ?></td>
<td align="center" width="100"><?php if(intval($item['wheel_spanner'])==1){?> Yes <?php }else{?> No <?php } ?></td>
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
     
