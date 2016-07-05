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
<table border="1">
	<tr>
    	<th width="100px" align="center">
		     <b>Car</b>
         </th>
		<th width="300px" align="center">
		     <b>Date Added</b>
         </th>

         <th width="80px" align="center">
		     <b>Driver</b>
         </th>
         
           <th width="80px" align="center">
		     <b>Spare Tyre</b>
         </th>
         
           <th width="80px" align="center">
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
    	<td align="center" width="230"><?php echo $item['car_make']." ".$item['car_model']."(".$item['number_plate'].")"; ?></td>
        <td align="center" width="100"><?php echo DateFormart($item['created_at']); ?></td>
        <td align="center" width="180"><?php echo $item['first_name']." ".$item['last_name']; ?></td>
        <td align="center" width="100"><?php if(intval($item['spare_tire'])==1){?> Yes <?php }else{?> No <?php } ?></td>
        <td align="center" width="100"><?php if(intval($item['fire_extinguisher'])==1){?> Yes <?php }else{?> No <?php } ?></td>
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
     
