<?php
/* @var $this SubSystemController */
/* @var $model SubSystem */

$this->breadcrumbs=array(
	'Sub Systems'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List SubSystem', 'url'=>array('index')),
	array('label'=>'Create SubSystem', 'url'=>array('create')),
	array('label'=>'Update SubSystem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SubSystem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubSystem', 'url'=>array('admin')),
);
?>

<h1>View SubSystem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'system_id',
		'title',
		'created_at',
		'status',
	),
)); ?>
