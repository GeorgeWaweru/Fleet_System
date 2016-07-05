<?php
/* @var $this IndustriesController */
/* @var $model Industries */

$this->breadcrumbs=array(
	'Industries'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Industries', 'url'=>array('index')),
	array('label'=>'Create Industries', 'url'=>array('create')),
	array('label'=>'Update Industries', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Industries', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Industries', 'url'=>array('admin')),
);
?>

<h1>View Industries #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'industry_desc',
		'status',
	),
)); ?>
