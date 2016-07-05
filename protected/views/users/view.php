<?php
/* @var $this DriversController */
/* @var $model Drivers */

$this->breadcrumbs=array(
	'Drivers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Drivers', 'url'=>array('index')),
	array('label'=>'Create Drivers', 'url'=>array('create')),
	array('label'=>'Update Drivers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Drivers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Drivers', 'url'=>array('admin')),
);
?>

<h1>View Drivers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'car_id',
		'first_name',
		'last_name',
		'email',
		'photo',
		'password',
		'created_at',
		'status',
	),
)); ?>
