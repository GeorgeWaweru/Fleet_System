<?php
/* @var $this RequestSubDetailsController */
/* @var $model RequestSubDetails */

$this->breadcrumbs=array(
	'Request Sub Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RequestSubDetails', 'url'=>array('index')),
	array('label'=>'Create RequestSubDetails', 'url'=>array('create')),
	array('label'=>'Update RequestSubDetails', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RequestSubDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RequestSubDetails', 'url'=>array('admin')),
);
?>

<h1>View RequestSubDetails #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'request_id',
		'photo',
		'description',
		'created_at',
		'status',
	),
)); ?>
