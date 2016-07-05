<?php
/* @var $this BookingCommentsController */
/* @var $model BookingComments */

$this->breadcrumbs=array(
	'Booking Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BookingComments', 'url'=>array('index')),
	array('label'=>'Create BookingComments', 'url'=>array('create')),
	array('label'=>'Update BookingComments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BookingComments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BookingComments', 'url'=>array('admin')),
);
?>

<h1>View BookingComments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'booking_id',
		'supplier_id',
		'user_id',
		'created_at',
		'status',
	),
)); ?>
