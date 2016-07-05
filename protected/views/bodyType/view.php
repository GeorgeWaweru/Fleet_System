<?php
/* @var $this BodyTypeController */
/* @var $model BodyType */

$this->breadcrumbs=array(
	'Body Types'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List BodyType', 'url'=>array('index')),
	array('label'=>'Create BodyType', 'url'=>array('create')),
	array('label'=>'Update BodyType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BodyType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BodyType', 'url'=>array('admin')),
);
?>

<h1>View BodyType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'status',
	),
)); ?>
