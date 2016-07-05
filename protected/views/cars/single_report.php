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
$Cars=Cars::model()->findByPk($id);		
$Make=CarMake::model()->findByPk($Cars->make_id);	
$Model=CarModels::model()->findByPk($Cars->model_id);
$BodyType=BodyType::model()->findByPk($Cars->body_type_id);
$Company=Companies::model()->findByPk($Cars->company_id);

$Engines=Engines::model()->findByPk($Cars->engine_id);	
$Tyres=Tyres::model()->findByPk($Cars->tyre_id);	
$CarYears=CarYears::model()->findByPk($Cars->year_id);	

?>

<?php if(count($Cars)>0)
{
	?>
    <table border="1">
    <?php
	if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
	?>
    <tr>
    <td>
    <b>Company</b>
    </td>
    <td align="right">
    <?php echo $Company->title;?>
    </td>
    </tr>
    <?php
	}
	?>
    
    
    <tr>
    <td width="140">
    <b>Car Photo</b>
    </td>
    <td align="right" width="140" height="100"><?php echo $cars_model->ReportImage($Cars->photo,'cars'); ?></td> 
    </tr>
    
    <tr>
    <td>
    <b>Registration Number</b>
    </td>
    <td align="right">
    <?php echo $Cars->number_plate;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Car Make</b>
    </td>
    <td align="right">
    <?php echo $Make->title;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Car Model</b>
    </td>
    <td align="right">
    <?php echo $Model->title;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Body Type</b>
    </td>
    <td align="right">
    <?php echo $BodyType->title;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Year</b>
    </td>
    <td align="right">
    <?php echo $CarYears->title;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Chasis Number</b>
    </td>
     <td align="right">
    <?php echo $Cars->chasis_number;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Engine Number</b>
    </td>
    <td align="right">
    <?php echo $Engines->title;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Consumption</b>
    </td>
    <td align="right">
    <?php echo $Cars->consumption;?> KM/L
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Fuel Type</b>
    </td>
    <td align="right">
    <?php echo $Cars->fuel_type;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Millage</b>
    </td>
    <td align="right">
    <?php echo $Cars->millage;?> KM
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Country</b>
    </td>
    <td align="right">
    <?php echo $Cars->country;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Tyre Size</b>
    </td>
    <td align="right">
    <?php echo $Tyres->title;?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Last Service Date</b>
    </td>
    <td align="right">
    <?php echo DateFormart($Cars->last_service_date);?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Last Service Millage</b>
    </td>
    <td align="right">
    <?php echo $Cars->last_service_millage;?> KM
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Insurance Exp. Date</b>
    </td>
    <td align="right">
    <?php echo DateFormart($Cars->insurance_exp_date);?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Serice Millage</b>
    </td>
    <td align="right">
    <?php echo $Cars->service_millage;?> KM
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Spare Tyre</b>
    </td>
    <td align="right">
    <?php if(intval($Cars->spare_tire==1)){ ?> Yes <?php } else{?> No <?php }?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Fire Extinguisher</b>
    </td>
    <td align="right">
    <?php if(intval($Cars->fire_extinguisher==1)){ ?> Yes <?php } else{?> No <?php }?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Jerk</b>
    </td>
    <td align="right">
    <?php if(intval($Cars->jerk==1)){ ?> Yes <?php } else{?> No <?php }?>
    </td>
    </tr>
    
    <tr>
    <td>
    <b>Wheel Spanner</b>
    </td>
    <td align="right">
    <?php if(intval($Cars->wheel_spanner==1)){ ?> Yes <?php } else{?> No <?php }?>
    </td>
    </tr>
    
    <?php
    if(intval($Cars->no_physical_damages)==1)
	{
		?>
        <tr>
        <td>
        <b>Physical Damages</b>
        </td>
        <td align="right">
        No Physical Damages
        </td>
        </tr>
        <?php
	}else{
		?>
        <tr>
        <td>
        <b>Physical Damages</b>
        </td>
        <td align="right">
        <?php echo $Cars->physical_damages;?>
        </td>
        </tr>
        <?php
		$CarPhysicalDamages=CarPhysicalDamages::model()->findAllByAttributes(array('car_id'=>$Cars->id));
		if(count($CarPhysicalDamages)>0){
			?>
            <tr>
            <td>
            <b>Photo</b>
            </td>
            <td align="right">
            <b>Physical Damage</b>
            </td>
            </tr>
            
            <?php
			foreach($CarPhysicalDamages as $item)
			{
				?>
                <tr>
                <td width="140" height="100">
                <?php echo $cars_model->ReportImage($item->photo,'car_physical_damage'); ?>
                </td>
                <td align="right">
                <?php echo $item->description;?>
                </td>
                </tr>
                <?php
			}
			?>
            <?php
		}
	}
	?>
    
    <?php
    if(intval($Cars->no_mechanical_issues)==1)
	{
		?>
        <tr>
        <td>
        <b>Mechanical Issues</b>
        </td>
        <td align="right">
         No Mechanical Issues
        </td>
        </tr>
        <?php
	}else{
		?>
        <tr>
        <td>
        <b>Mechanical Issues</b>
        </td>
        <td align="right">
        <?php echo $Cars->mechanical_issues;?>
        </td>
        </tr>
        <?php
		$CarMechanicalIssues=CarMechanicalIssues::model()->findAllByAttributes(array('car_id'=>$Cars->id));
		if(count($CarMechanicalIssues)>0){
			?>
            <tr>
            <td>
            <b>Photo</b>
            </td>
            <td align="right">
            <b>Mechanical Issue</b>
            </td>
            </tr>
            
            <?php
			foreach($CarMechanicalIssues as $item)
			{
				?>
                <tr>
                <td  width="140" height="100">
                <?php echo $cars_model->ReportImage($item->photo,'car_mechanical_issues'); ?>
                </td>
                <td align="right">
                <?php echo $item->description;?>
                </td>
                </tr>
                <?php
			}
			?>
            <?php
		}
	}
	?>
    <tr>
    <td>
    <b>Status</b>
    </td>
    <td align="right">
    <?php if(intval($Cars->status==1)){ ?> <font color="#000099">Active</font> <?php } else{?> <font color="#FF0000">Inactive</font> <?php }?>
    </td>
    </tr>
    
    
   
    </table>
    <?php
	
}
?>
