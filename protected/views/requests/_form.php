<?php
/* @var $this RequestsController */
/* @var $model Requests */
/* @var $form CActiveForm */
?>

<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'requests-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'request_type'); ?>
		<?php echo $form->textField($model,'request_type',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'request_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_id'); ?>
		<?php echo $form->textField($model,'system_id'); ?>
		<?php echo $form->error($model,'system_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subsystem_id'); ?>
		<?php echo $form->textField($model,'subsystem_id'); ?>
		<?php echo $form->error($model,'subsystem_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'previous_millage'); ?>
		<?php echo $form->textField($model,'previous_millage',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'previous_millage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'current_millage'); ?>
		<?php echo $form->textField($model,'current_millage',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'current_millage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'consumption'); ?>
		<?php echo $form->textField($model,'consumption',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'consumption'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
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