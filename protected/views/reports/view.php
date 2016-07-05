<?php
/* @var $this ReportsController */
/* @var $model Votes */

$this->breadcrumbs=array(
	'Votes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Votes', 'url'=>array('index')),
	array('label'=>'Create Votes', 'url'=>array('create')),
	array('label'=>'Update Votes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Votes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Votes', 'url'=>array('admin')),
);
?>

<h1>View Votes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'candidate_id',
		'position_id',
		'created_at',
		'status',
	),
)); ?>
