<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<table>
<tr>
<td><b>Tyre Size</b></td>
<td>
<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
</td>
</tr>
<tr>
<td>
<b>Status</b>
</td>
<td>
<?php echo $form->dropdownlist($model,'status',array(''=>'--Select Status--','1'=>'Active','0'=>'Inactive'),array('class'=>'parent_form_elements')); ?>
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