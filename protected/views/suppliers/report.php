<?php
session_start();
$Suppliers_model=new Suppliers;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
?>
<?php if ($model !== null):?>
<table border="1">
	<tr>
    
			<?php
            if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
            ?>
            <th width="120px" align="center">
            <b>Company</b>
            </th>
            <?php
            }
            ?>
         
            <th width="120px" align="center">
		     <b>Supplier's Name</b>
         </th>
           <th width="120px" align="center">
		     <b>Dealers In</b>
         </th>
            <th width="120px" align="center">
		     <b>Registration Number</b>
         </th>
            <th width="120px" align="center">
		     <b>Contact Person</b>
         </th>
         
         
    	<th width="120px" align="center">
		     <b>Email</b>
         </th>
		
       
       
 	</tr>
    
    <?php $loop_count=0;?>
	 <?php foreach($model as $item): ?>
    <tr>   
	<?php
    if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
    ?>  
    <td align="center"><?php echo $item['company_name']; ?></td>
    <?php
    }
    ?>
    <td align="center"><?php echo $item['title']; ?></td>
    <td align="center">
    
    <?php
    $supplier_id=$item['id'];
    $SupplierSystems=SupplierSystems::model()->findAllByAttributes(array('supplier_id'=>$supplier_id));
	foreach($SupplierSystems as $SupplierSystem){
		$systems=System::model()->findByPk($SupplierSystem->system_id);
		 echo "-".$systems->title."<br>";
	}
    ?>
    </td>
    <td align="center"><?php echo $item['reg_no']; ?></td>
    <td align="center"><?php echo $item['contact_person']; ?></td>
    <td align="center"><?php echo $item['email']; ?></td>
    </tr>
    <?php $loop_count++;?>
     <?php endforeach; ?>
</table>
<?php endif; ?>
<br />
<b>Total Records</b>
<?php echo $loop_count;?>
     
