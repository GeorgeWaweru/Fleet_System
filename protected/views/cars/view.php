<?php
/* @var $this CarsController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'Cars'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Cars', 'url'=>array('index')),
	array('label'=>'Create Cars', 'url'=>array('create')),
	array('label'=>'Update Cars', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Cars', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cars', 'url'=>array('admin')),
);
?>

<h1>View Cars #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'make_id',
		'model_id',
		'number_plate',
		'photo',
		'service_millage',
		'car_year',
		'created_at',
		'status',
	),
)); ?>
