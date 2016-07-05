<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<table>
<tr>
<td width="110px">
<b>Car Sub System</b>
</td>
<td>
<?php echo CHtml::activeDropDownList($model,'sub_system_id',CHtml::listData(SubSystem::model()->findAll("is_default=0 AND status=1"),'id','title') ,array('empty' => '--Car Sub System--')); ?>
</td>
</tr>

<tr>
<td>
<b>Spare Part</b>
</td>
<td>
<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
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