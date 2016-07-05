<?php
/* @var $this CarModelsController */
/* @var $model CarModels */

$this->breadcrumbs=array(
	'Car Models'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'List Car Models', 'url'=>array('index')),
	//array('label'=>'Create CarModels', 'url'=>array('create')),
	//array('label'=>'View CarModels', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage CarModels', 'url'=>array('admin')),
);
?>

<h3>Update Car Models </h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>