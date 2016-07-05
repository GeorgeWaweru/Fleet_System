<?php
/* @var $this RequestsController */
/* @var $model Requests */

$this->breadcrumbs=array(
	'Requests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Requests', 'url'=>array('index')),
	array('label'=>'Create Requests', 'url'=>array('create')),
	array('label'=>'Update Requests', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Requests', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Requests', 'url'=>array('admin')),
);
?>

<h1>View Requests #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'request_type',
		'system_id',
		'subsystem_id',
		'previous_millage',
		'current_millage',
		'consumption',
		'created_at',
		'status',
	),
)); ?>
