<?php
/* @var $this CarPhysicalDamagesController */
/* @var $model CarPhysicalDamages */

$this->breadcrumbs=array(
	'Car Physical Damages'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CarPhysicalDamages', 'url'=>array('index')),
	array('label'=>'Create CarPhysicalDamages', 'url'=>array('create')),
	array('label'=>'Update CarPhysicalDamages', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarPhysicalDamages', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarPhysicalDamages', 'url'=>array('admin')),
);
?>

<h1>View CarPhysicalDamages #<?php echo $model->id; ?></h1>

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
