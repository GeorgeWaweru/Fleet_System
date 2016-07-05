<?php
/* @var $this CarYearsController */
/* @var $model CarYears */

$this->breadcrumbs=array(
	'Car Years'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List CarYears', 'url'=>array('index')),
	array('label'=>'Manage CarYears', 'url'=>array('admin')),
);
?>

<h3>Add Car Year</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>