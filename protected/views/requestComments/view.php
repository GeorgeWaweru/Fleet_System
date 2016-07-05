<?php
/* @var $this RequestCommentsController */
/* @var $model RequestComments */

$this->breadcrumbs=array(
	'Request Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RequestComments', 'url'=>array('index')),
	array('label'=>'Create RequestComments', 'url'=>array('create')),
	array('label'=>'Update RequestComments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RequestComments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RequestComments', 'url'=>array('admin')),
);
?>

<h1>View RequestComments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'request_id',
		'user_id',
		'no_photo',
		'photo',
		'description',
		'no_description',
		'created_at',
		'status',
	),
)); ?>
