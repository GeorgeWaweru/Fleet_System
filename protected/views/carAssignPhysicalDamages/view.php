<?php
/* @var $this CarAssignPhysicalDamagesController */
/* @var $model CarAssignPhysicalDamages */

$this->breadcrumbs=array(
	'Car Assign Physical Damages'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CarAssignPhysicalDamages', 'url'=>array('index')),
	array('label'=>'Create CarAssignPhysicalDamages', 'url'=>array('create')),
	array('label'=>'Update CarAssignPhysicalDamages', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarAssignPhysicalDamages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarAssignPhysicalDamages', 'url'=>array('admin')),
);
?>

<h1>View CarAssignPhysicalDamages #<?php echo $model->id; ?></h1>

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
