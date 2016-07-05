<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'htmlOptions'=>array('autocomplete'=>'off'),
	'method'=>'get',
)); 

$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";
?>

<table>
<tr>
<td width="105">
<b>Car Assignment</b><br><span class="narrative">(Narrative)</span>
</td>
<td>
<?php
$CarAssignment=new CarAssignment;
$assignments=CarAssignment::model()->findAll("status='1' AND company_id=".$LOGGED_IN_COMPANY."");
$data = array();
foreach ($assignments as $item)
{
$CarsData=Cars::model()->findByPk($item->car_id);
$UsersData=Users::model()->findByPk($item->user_id);
$created_at=$CarAssignment->fomartDate($item->created_at);

$CarMake=CarMake::model()->findByPk($CarsData->make_id);
$CarModels=CarModels::model()->findByPk($CarsData->model_id);
$narrative=$CarMake->title." ".$CarModels->title."  (".$CarsData->number_plate.") Assigned to ".$UsersData->first_name." ".$UsersData->last_name." on ".$created_at;
$data[$item->id]=$narrative;  
}
echo $form->dropdownlist($model, 'car_assignment_id', $data ,array('empty' => '--Select Car Assignment--'));
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