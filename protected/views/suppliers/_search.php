<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table>
<tr>
<td width="115">
<b>Company</b>
</td>
<td>
<?php echo CHtml::activeDropDownList($model,'company_id',CHtml::listData(Companies::model()->findAll("status='1' AND is_default=0"),'id','title') ,array('empty' => '--Select Company--')); ?>
</td>
</tr>
<tr>
<td>
<b>Supplier's Name</b>
</td>
<td>
<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>
<tr>
<td>
<b>Registration No.</b>
</td>
<td>
<?php echo $form->textField($model,'reg_no',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>
<tr>
<td>
<b>Contact Person</b>
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
<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
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