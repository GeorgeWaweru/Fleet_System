<?php
/* @var $this SpareController */
/* @var $model Spare */

$this->breadcrumbs=array(
	'Spares'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Spare', 'url'=>array('index')),
	array('label'=>'Create Spare', 'url'=>array('create')),
	array('label'=>'Update Spare', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Spare', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Spare', 'url'=>array('admin')),
);
?>

<h1>View Spare #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sub_system_id',
		'title',
		'status',
	),
)); ?>
