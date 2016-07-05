<?php
/* @var $this BookingsController */
/* @var $model Bookings */

$this->breadcrumbs=array(
	'Bookings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Bookings', 'url'=>array('index')),
	array('label'=>'Create Bookings', 'url'=>array('create')),
	array('label'=>'Update Bookings', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Bookings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Bookings', 'url'=>array('admin')),
);
?>

<h1>View Bookings #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'request_id',
		'supplier_id',
		'created_at',
		'status',
	),
)); ?>
