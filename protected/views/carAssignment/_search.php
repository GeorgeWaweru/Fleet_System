<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));


$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
?>


<table>
<tr>
<td width="90">
<b>Car</b>
</td>
<td>
<?php
$cars=Cars::model()->findAll("status='1' AND is_default=0 AND company_id=$LOGGED_IN_COMPANY"); 
$Carsdata = array();
foreach ($cars as $item){
$CarMake=CarMake::model()->findByPk($item->make_id);
$CarModels=CarModels::model()->findByPk($item->model_id);
$Carsdata[$item->id] = $CarMake->title . ' '. $CarModels->title." (".$item->number_plate.")"; 
}
echo CHtml::activeDropDownList($model, 'car_id', $Carsdata ,array('empty' => '--Select Car--'));
?>
</td>
</tr>


<tr>
<td>
<b>User (Driver) </b>
</td>
<td>
<?php 
$is_driver=Roles::model()->findByAttributes(array('is_driver'=>1,'status'=>1));
$default_car=Cars::model()->findByAttributes(array('is_default'=>1,'status'=>1));
$driver_role_id=$is_driver->id;
$default_car_id=$default_car->id;
$users = Users::model()->findAll("status='1' AND role_id=".$driver_role_id." AND company_id=$LOGGED_IN_COMPANY");
$data = array();
foreach ($users as $item)
{
$data[$item->id] = $item->first_name . ' '. $item->last_name;   
}
echo CHtml::activeDropDownList($model, 'user_id', $data ,array('empty' => '--Select Driver--'));
?>
</td>
</tr>

<tr>
<td>
<b>Status</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'status',array(''=>'--Select Status--','1'=>'Active','0'=>'Inactive')); ?>
</td>
</tr>


<tr>
<td>
</td>
<td>
<?php echo CHtml::submitButton('Search'); ?>
</td>
</tr>

	
</table>
<?php $this->endWidget(); ?>
</div><!-- search-form -->