<?php
/* @var $this CarModelsController */
/* @var $model CarModels */

$this->breadcrumbs=array(
	'Car Models'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CarModels', 'url'=>array('index')),
	array('label'=>'Create CarModels', 'url'=>array('create')),
	array('label'=>'Update CarModels', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarModels', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarModels', 'url'=>array('admin')),
);
?>

<h1>View CarModels #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'make_id',
		'title',
		'created_at',
		'status',
	),
)); ?>
