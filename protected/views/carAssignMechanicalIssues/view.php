<?php
/* @var $this CarAssignMechanicalIssuesController */
/* @var $model CarAssignMechanicalIssues */

$this->breadcrumbs=array(
	'Car Assign Mechanical Issues'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CarAssignMechanicalIssues', 'url'=>array('index')),
	array('label'=>'Create CarAssignMechanicalIssues', 'url'=>array('create')),
	array('label'=>'Update CarAssignMechanicalIssues', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarAssignMechanicalIssues', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarAssignMechanicalIssues', 'url'=>array('admin')),
);
?>

<h1>View CarAssignMechanicalIssues #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'car_assignment_id',
		'photo',
		'description',
		'created_at',
		'status',
	),
)); ?>
