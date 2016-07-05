<?php
/* @var $this EnginesController */
/* @var $model Engines */

$this->breadcrumbs=array(
	'Engines'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Engines', 'url'=>array('index')),
	//array('label'=>'Create Engines', 'url'=>array('create')),
	//array('label'=>'View Engines', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Engines', 'url'=>array('admin')),
);
?>

<h3>Update Engine Number</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>