<?php
/* @var $this CarAssignmentController */
/* @var $model CarAssignment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'car-assignment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'car_id'); ?>
		<?php echo $form->textField($model,'car_id'); ?>
		<?php echo $form->error($model,'car_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->textField($model,'company_id'); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'spare_tire'); ?>
		<?php echo $form->textField($model,'spare_tire'); ?>
		<?php echo $form->error($model,'spare_tire'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fire_extinguisher'); ?>
		<?php echo $form->textField($model,'fire_extinguisher'); ?>
		<?php echo $form->error($model,'fire_extinguisher'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jerk'); ?>
		<?php echo $form->textField($model,'jerk'); ?>
		<?php echo $form->error($model,'jerk'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wheel_spanner'); ?>
		<?php echo $form->textField($model,'wheel_spanner'); ?>
		<?php echo $form->error($model,'wheel_spanner'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'physical_damages'); ?>
		<?php echo $form->textArea($model,'physical_damages',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'physical_damages'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'no_physical_damages'); ?>
		<?php echo $form->textField($model,'no_physical_damages'); ?>
		<?php echo $form->error($model,'no_physical_damages'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mechanical_issues'); ?>
		<?php echo $form->textArea($model,'mechanical_issues',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'mechanical_issues'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'no_mechanical_issues'); ?>
		<?php echo $form->textField($model,'no_mechanical_issues'); ?>
		<?php echo $form->error($model,'no_mechanical_issues'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email_sent'); ?>
		<?php echo $form->textField($model,'email_sent'); ?>
		<?php echo $form->error($model,'email_sent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deleted_status'); ?>
		<?php echo $form->textField($model,'deleted_status'); ?>
		<?php echo $form->error($model,'deleted_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->