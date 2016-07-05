<?php
/* @var $this CarAssignmentController */
/* @var $model CarAssignment */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'car_id'); ?>
		<?php echo $form->textField($model,'car_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'spare_tire'); ?>
		<?php echo $form->textField($model,'spare_tire'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fire_extinguisher'); ?>
		<?php echo $form->textField($model,'fire_extinguisher'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'jerk'); ?>
		<?php echo $form->textField($model,'jerk'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wheel_spanner'); ?>
		<?php echo $form->textField($model,'wheel_spanner'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'physical_damages'); ?>
		<?php echo $form->textArea($model,'physical_damages',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'no_physical_damages'); ?>
		<?php echo $form->textField($model,'no_physical_damages'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mechanical_issues'); ?>
		<?php echo $form->textArea($model,'mechanical_issues',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'no_mechanical_issues'); ?>
		<?php echo $form->textField($model,'no_mechanical_issues'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email_sent'); ?>
		<?php echo $form->textField($model,'email_sent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deleted_status'); ?>
		<?php echo $form->textField($model,'deleted_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->