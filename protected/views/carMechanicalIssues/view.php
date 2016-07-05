<?php
/* @var $this CarMechanicalIssuesController */
/* @var $model CarMechanicalIssues */

$this->breadcrumbs=array(
	'Car Mechanical Issues'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CarMechanicalIssues', 'url'=>array('index')),
	array('label'=>'Create CarMechanicalIssues', 'url'=>array('create')),
	array('label'=>'Update CarMechanicalIssues', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarMechanicalIssues', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarMechanicalIssues', 'url'=>array('admin')),
);
?>

<h1>View CarMechanicalIssues #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'car_id',
		'photo',
		'description',
		'status',
	),
)); ?>
