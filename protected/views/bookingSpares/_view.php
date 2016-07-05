<?php
/* @var $this BookingSparesController */
/* @var $data BookingSpares */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('booking_comment_id')); ?>:</b>
	<?php echo CHtml::encode($data->booking_comment_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spare_id')); ?>:</b>
	<?php echo CHtml::encode($data->spare_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spare_cost')); ?>:</b>
	<?php echo CHtml::encode($data->spare_cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>