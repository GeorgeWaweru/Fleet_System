<?php
/* @var $this EnginesController */
/* @var $model Engines */

$this->breadcrumbs=array(
	'Engines'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Engines', 'url'=>array('index')),
	array('label'=>'Create Engines', 'url'=>array('create')),
	array('label'=>'Update Engines', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Engines', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Engines', 'url'=>array('admin')),
);
?>

<h1>View Engines #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'status',
	),
)); ?>
