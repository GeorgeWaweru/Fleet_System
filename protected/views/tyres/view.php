<?php
/* @var $this TyresController */
/* @var $model Tyres */

$this->breadcrumbs=array(
	'Tyres'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Tyres', 'url'=>array('index')),
	array('label'=>'Create Tyres', 'url'=>array('create')),
	array('label'=>'Update Tyres', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Tyres', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tyres', 'url'=>array('admin')),
);
?>

<h1>View Tyres #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'status',
	),
)); ?>
