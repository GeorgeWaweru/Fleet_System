<?php 
$companies_model=new Companies;
if ($model !== null):?>
<table border="1">
<tr>
 	<th width="100px" align="center">
    <b>Company Logo</b>
    </th>
    <th width="100px" align="center">
    <b>Company Name</b>
    </th>
    <th width="100px" align="center">
    <b>Industry</b>
    </th>
    <th width="100px" align="center">
    <b>Contact Person</b>
    </th>
    <th width="100px" align="center">
    <b>Email</b>
    </th>
    <th width="100px" align="center">
    <b>Phone Number</b>
    </th>
    <th width="100px" align="center">
    <b>Location</b>
    </th>
    <th width="100px" align="center">
    <b>Employees</b>
    </th>
    <th width="100px" align="center">
    <b>Vehicles</b>
    </th>
    <th width="100px" align="center">
    <b>Status</b>
    </th>
</tr>
    
    <?php $loop_count=0;?>
	 <?php foreach($model as $item): ?>
	<tr>  
    <td align="center" width="120" height="80"><img src="<?php echo $companies_model->ReportImage($item['photo'],'companies'); ?>" width="80" height="80"></td>    
    <td align="center" width="150"><?php echo $item['title']; ?></td>
    <td align="center" width="100"><?php echo $item['industry']; ?></td>
    <td align="center" width="120"><?php echo $item['contact_person']; ?></td>
    <td align="center" width="180"><?php echo $item['email']; ?></td>
    <td align="center" width="120"><?php echo $item['phone_number']; ?></td>
    <td align="center" width="120"><?php echo $item['location']; ?></td>
    <td align="center" width="100"><?php echo intval($item['no_employees']); ?></td>
    <td align="center" width="100"><?php echo intval($item['no_vehicles']); ?></td>
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
     
