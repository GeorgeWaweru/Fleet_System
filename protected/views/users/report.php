<?php
session_start();
$users_model=new Users;
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
	<?php
    if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
    ?>
    <th width="80px" align="center">
    <b>Company</b>
    </th>
    <?php
    }
    ?>
    <th width="80px" align="center">
		     <b>User Role</b>
         </th>
 
    	<th width="100px" align="center">
		     <b>Photo</b>
         </th>
		<th width="80px" align="center">
		     <b>First Name</b>
         </th>

         <th width="80px" align="center">
		     <b>Last Name</b>
         </th>
         
          <th width="80px" align="center">
		     <b>Email</b>
         </th>
         <th width="200px" align="center">
		     <b>Phone Number</b>
         </th>
         
         <th width="200px" align="center">
		     <b>Car</b>
         </th>
         
         <th width="200px" align="center">
		     <b>Qualified</b>
         </th>
         
         <th width="200px" align="center">
		     <b>DL Photo</b>
         </th>
         
         <th width="200px" align="center">
		     <b>DL Number</b>
         </th>
         
         <th width="200px" align="center">
		     <b>DL Expiry Date</b>
         </th>
         
       
       
 	</tr>
    
    <?php $loop_count=0;?>
	 <?php foreach($model as $item): ?>
	<tr>     
		<?php
        if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
        ?>
        <td align="center" width="100"><?php echo $item['company_name']; ?></td>
        <?php
        }
        ?>
    	<td align="center" width="100"><?php echo $item['role_title']; ?></td>
    	<td align="center" width="85" height="80"><?php echo $users_model->ReportImage($item['photo'],'users'); ?></td> 
        <td align="center" width="100"><?php echo $item['first_name']; ?></td>
        <td align="center" width="100"><?php echo $item['last_name']; ?></td>
        <td align="center" width="170"><?php echo $item['email']; ?></td>
        <td align="center" width="120"><?php echo $item['phone_number']; ?></td> 
        <td align="center" width="120"><?php echo $item['number_plate']; ?></td> 
        <td align="center" width="100"><?php if(intval($item['qualified_status'])==1){?> Yes <?php }else{?> No <?php } ?></td>
        <td align="center" width="85" height="80"><?php if(intval($item['qualified_status'])==1){ echo $users_model->ReportImage($item['dl_photo'],'dl_photo'); }else{ echo '--';} ?></td> 
        <td align="center" width="85" height="80"><?php if(intval($item['qualified_status'])==1){ echo $item['dl_number'];}else{ echo '--';} ?></td> 
        <td align="center" width="85" height="80"><?php if(intval($item['qualified_status'])==1){ echo DateFormart($item['dl_expiry']);}else{ echo '--';} ?></td>
    </tr>
    <?php $loop_count++;?>
     <?php endforeach; ?>
</table>
<?php endif; ?>
<br />
<b>Total Records</b>
<?php echo $loop_count;?>
     
