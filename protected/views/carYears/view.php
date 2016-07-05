<?php
/* @var $this CarYearsController */
/* @var $model CarYears */

$this->breadcrumbs=array(
	'Car Years'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CarYears', 'url'=>array('index')),
	array('label'=>'Create CarYears', 'url'=>array('create')),
	array('label'=>'Update CarYears', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarYears', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarYears', 'url'=>array('admin')),
);
?>

<h1>View CarYears #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'status',
	),
)); ?>
