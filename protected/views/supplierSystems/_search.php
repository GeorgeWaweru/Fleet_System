<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


<table>

<tr>
<td width="75">
<b>Car System</b>
</td>
<td>
 <?php echo CHtml::activeDropDownList($model,'system_id',CHtml::listData(System::model()->findAll("status='1' AND is_default=0"),'id','title') ,array('empty' => '--Select System--','class'=>'parent_fields parent_form_elements')); ?>
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