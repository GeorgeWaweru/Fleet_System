<?php if ($model !== null):?>
<table border="1">
	<tr>
    	<th width="100px" align="center">
		     <b>Body Type</b>
         </th>

         <th width="80px" align="center">
		     <b>Status</b>
         </th>
     
 	</tr>
    
    <?php $loop_count=0;?>
	 <?php foreach($model as $item): ?>
	<tr>     
        <td align="center" width="100"><?php echo $item['title']; ?></td>
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
     
