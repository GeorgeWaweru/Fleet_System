<?php
/* @var $this CarMakeController */
/* @var $model CarMake */

$this->breadcrumbs=array(
	'Car Makes'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CarMake', 'url'=>array('index')),
	array('label'=>'Create CarMake', 'url'=>array('create')),
	array('label'=>'Update CarMake', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CarMake', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CarMake', 'url'=>array('admin')),
);
?>

<h1>View CarMake #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'created_at',
		'status',
	),
)); ?>
