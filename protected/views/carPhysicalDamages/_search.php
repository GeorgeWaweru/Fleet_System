<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'htmlOptions'=>array('autocomplete'=>'off'),
	'method'=>'get',
)); 
?>
<table>
<tr>
<td width="50">
<b>Car</b>
</td>
<td>
<?php
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$Cars=Cars::model()->findAll("status='1' AND is_default=0 AND company_id=".$LOGGED_IN_COMPANY."");
$data = array();
foreach ($Cars as $item)
{
$CarMake=CarMake::model()->findByPk($item->make_id);
$CarModels=CarModels::model()->findByPk($item->model_id);
$narrative=$CarMake->title." ".$CarModels->title."  (".$item->number_plate.")";
$data[$item->id]=$narrative;  
}
echo CHtml::activeDropDownList($model, 'car_id', $data ,array('empty' => '--Select Car--'));
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
</div>