<?php
/* @var $this CarModelsController */
/* @var $model CarModels */

$this->breadcrumbs=array(
	'Car Models'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Car Models', 'url'=>array('index')),
	//array('label'=>'Manage CarModels', 'url'=>array('admin')),
);
?>

<h3>Create Car Models</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>