<?php
/* @var $this BookingSparesController */
/* @var $model BookingSpares */
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
		<?php echo $form->label($model,'booking_comment_id'); ?>
		<?php echo $form->textField($model,'booking_comment_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'spare_id'); ?>
		<?php echo $form->textField($model,'spare_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'spare_cost'); ?>
		<?php echo $form->textField($model,'spare_cost',array('size'=>50,'maxlength'=>50)); ?>
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