<div class="form">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'requests-form',
	'enableAjaxValidation'=>true,
)); ?>

	

<?php $this->endWidget(); ?>
</div>