<?php
/* @var $this RequestsController */
/* @var $data Requests */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_type')); ?>:</b>
	<?php echo CHtml::encode($data->request_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('system_id')); ?>:</b>
	<?php echo CHtml::encode($data->system_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subsystem_id')); ?>:</b>
	<?php echo CHtml::encode($data->subsystem_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('previous_millage')); ?>:</b>
	<?php echo CHtml::encode($data->previous_millage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('current_millage')); ?>:</b>
	<?php echo CHtml::encode($data->current_millage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('consumption')); ?>:</b>
	<?php echo CHtml::encode($data->consumption); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>