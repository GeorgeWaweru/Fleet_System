<?php
/* @var $this CarAssignmentController */
/* @var $model CarAssignment */

$this->breadcrumbs=array(
	'Car Assignments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CarAssignment', 'url'=>array('index')),
	array('label'=>'Create CarAssignment', 'url'=>array('create')),
	array('label'=>'Update CarAssignment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarAssignment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarAssignment', 'url'=>array('admin')),
);
?>

<h1>View CarAssignment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'car_id',
		'user_id',
		'spare_tire',
		'fire_extinguisher',
		'jerk',
		'wheel_spanner',
		'physical_damages',
		'no_physical_damages',
		'mechanical_issues',
		'no_mechanical_issues',
		'created_at',
		'status',
	),
)); ?>
