<?php
/* @var $this BookingSparesController */
/* @var $model BookingSpares */

$this->breadcrumbs=array(
	'Booking Spares'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BookingSpares', 'url'=>array('index')),
	array('label'=>'Create BookingSpares', 'url'=>array('create')),
	array('label'=>'Update BookingSpares', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BookingSpares', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BookingSpares', 'url'=>array('admin')),
);
?>

<h1>View BookingSpares #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'booking_comment_id',
		'spare_id',
		'spare_cost',
		'status',
	),
)); ?>
