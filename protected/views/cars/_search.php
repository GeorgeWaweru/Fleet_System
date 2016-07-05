<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'htmlOptions'=>array('autocomplete'=>'off'),
	'method'=>'get',
)); ?>
<table>

<?php
$LOGGED_IN_COMPANY=isset($_SESSION['LOGGED_IN_COMPANY']) ? intval($_SESSION['LOGGED_IN_COMPANY']) : 0;
$LOGGED_IN_USER_ID=isset($_SESSION['LOGGED_IN_USER_ID']) ? intval($_SESSION['LOGGED_IN_USER_ID']) : 0;
$COMPANY_SUB_USER_ROLE=isset($_SESSION['COMPANY_SUB_USER_ROLE']) ? $_SESSION['COMPANY_SUB_USER_ROLE'] : '';
$LOGGED_IN_USER_KIND=isset($_SESSION['LOGGED_IN_USER_KIND']) ? $_SESSION['LOGGED_IN_USER_KIND'] : "";


if($LOGGED_IN_USER_ID>0 && $LOGGED_IN_USER_KIND=='admin_user'){
?>
<tr>
<td width="100">
<b>Company</b>
</td>
<td>
<?php echo CHtml::activeDropDownList($model,'company_id',CHtml::listData(Companies::model()->findAll("status='1' AND is_default=0"),'id','title') ,array('empty' => '--Select Company--')); ?>
</td>
</tr>
<?php
}
?>

<tr>
<td width="100">
<b>Car Make</b>
</td>
<td>
<?php echo CHtml::activeDropDownList($model,'make_id',CHtml::listData(CarMake::model()->findAll("status='1' AND is_default='0'"),'id','title') ,array('empty' => '--Select Car Make--','onchange'=>'getModels(this)')); ?>
</td>
</tr>
    
    
<tr>
<td>
<b>Car Model</b>
</td>
<td>
<select class="dropDownElements" name="Cars[model_id]" id="Cars_model_id">
<option value="" value="">--Select Car Model--</option>
</select>
<div id="car_model_preloader_div" class="preloader_div"><img src="images/loader.gif" /></div>
</td>
</tr>


<tr>
<td>
<b>Body Type</b>
</td>
<td>
<?php 
echo CHtml::activeDropDownList($model,'body_type_id',CHtml::listData(BodyType::model()->findAll("status='1'"),'id','title') ,array('empty' => '--Select Body Type--','class'=>'parent_form_elements'));
?>
</td>
</tr>

<tr>
<td>
<b>Year</b>
</td>
<td>
<?php 
echo CHtml::activeDropDownList($model,'year_id',CHtml::listData(CarYears::model()->findAll("status='1'"),'id','title') ,array('empty' => '--Select Year--','class'=>'parent_form_elements'));
?>
</td>
</tr>

<tr>
<td>
<b>Engine Model</b>
</td>
<td>
<?php 
echo CHtml::activeDropDownList($model,'engine_id',CHtml::listData(Engines::model()->findAll("status='1'"),'id','title') ,array('empty' => '--Select Engine Model--','class'=>'parent_form_elements'));
?>
</td>
</tr>

<tr>
<td>
<b>Tyre Size</b>
</td>
<td>
<?php 
echo CHtml::activeDropDownList($model,'tyre_id',CHtml::listData(Tyres::model()->findAll("status='1'"),'id','title') ,array('empty' => '--Select Tyre Size--','class'=>'parent_form_elements'));
?>
</td>
</tr>


<tr>
<td>
<b>Number Plate</b>
</td>
<td>
<?php echo $form->textField($model,'number_plate',array('size'=>50,'maxlength'=>50)); ?>
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