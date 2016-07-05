<div class="wide form">
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'htmlOptions'=>array('autocomplete'=>'off'),
	'method'=>'get',
)); ?>

<table>

<tr>
<td width="100px"><b>System Name</b></td>
<td>
<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
</td>
</tr>


<tr>
<td>
<b>Service Type</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'service_type',array(''=>'--Select Service Type--','Service'=>'Service','Repair'=>'Repair')); ?>
</td>
</tr>


<tr>
<td><b>Status</b></td>
<td>
<?php echo $form->dropdownlist($model,'status',array(''=>'--Select Status--','1'=>'Active','0'=>'Inactive')); ?>
</td>
</tr>


<tr>
<td></td>
<td>
<?php echo CHtml::submitButton('Search'); ?>
</td>
</tr>
</table>


<?php $this->endWidget(); ?>

</div><!-- search-form -->