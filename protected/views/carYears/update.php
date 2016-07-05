<?php
/* @var $this CarYearsController */
/* @var $model CarYears */

$this->breadcrumbs=array(
	'Car Years'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List CarYears', 'url'=>array('index')),
	//array('label'=>'Create CarYears', 'url'=>array('create')),
	//array('label'=>'View CarYears', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CarYears', 'url'=>array('admin')),
);
?>

<h3>Update Car Year</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>