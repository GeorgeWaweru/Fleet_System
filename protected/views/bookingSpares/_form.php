<?php
/* @var $this BookingSparesController */
/* @var $model BookingSpares */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'booking-spares-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'booking_comment_id'); ?>
		<?php echo $form->textField($model,'booking_comment_id'); ?>
		<?php echo $form->error($model,'booking_comment_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'spare_id'); ?>
		<?php echo $form->textField($model,'spare_id'); ?>
		<?php echo $form->error($model,'spare_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'spare_cost'); ?>
		<?php echo $form->textField($model,'spare_cost',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'spare_cost'); ?>
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