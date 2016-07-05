<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'htmlOptions'=>array('autocomplete'=>'off'),
	'method'=>'get',
)); ?>
<table>
<tr>
<td>
<b>Industry</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'industry_id',CHtml::listData(Industries::model()->findAll("status='1' AND is_default=0"),'id','title') ,array('empty' => '--Select Industry--')); ?>
</td>
</tr>


<tr>
<td width="100">
<b>Company</b>
</td>
<td>
<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>


<tr>
<td>
<b>Contact person</b>
</td>
<td>
<?php echo $form->textField($model,'contact_person',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>


<tr>
<td>
<b>Email</b>
</td>
<td>
<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>


<tr>
<td>
<b>Phone Number</b>
</td>
<td>
<?php echo $form->textField($model,'phone_number',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>


<tr>
<td>
<b>Location</b>
</td>
<td>
<?php echo $form->textField($model,'location',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>


<tr>
<td>
<b>Employees No.</b>
</td>
<td>
<?php echo $form->textField($model,'no_employees',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>

<tr>
<td>
<b>Vehicles No.</b>
</td>
<td>
<?php echo $form->textField($model,'no_vehicles',array('size'=>50,'maxlength'=>50)); ?>
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