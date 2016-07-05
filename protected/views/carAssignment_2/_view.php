<?php
/* @var $this CarAssignmentController */
/* @var $data CarAssignment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_id')); ?>:</b>
	<?php echo CHtml::encode($data->car_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spare_tire')); ?>:</b>
	<?php echo CHtml::encode($data->spare_tire); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fire_extinguisher')); ?>:</b>
	<?php echo CHtml::encode($data->fire_extinguisher); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('jerk')); ?>:</b>
	<?php echo CHtml::encode($data->jerk); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wheel_spanner')); ?>:</b>
	<?php echo CHtml::encode($data->wheel_spanner); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('physical_damages')); ?>:</b>
	<?php echo CHtml::encode($data->physical_damages); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_physical_damages')); ?>:</b>
	<?php echo CHtml::encode($data->no_physical_damages); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mechanical_issues')); ?>:</b>
	<?php echo CHtml::encode($data->mechanical_issues); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('no_mechanical_issues')); ?>:</b>
	<?php echo CHtml::encode($data->no_mechanical_issues); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>