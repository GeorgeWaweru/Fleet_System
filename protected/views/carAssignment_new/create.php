<?php
/* @var $this CarAssignmentController */
/* @var $model CarAssignment */

$this->breadcrumbs=array(
	'Car Assignments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CarAssignment', 'url'=>array('index')),
	array('label'=>'Manage CarAssignment', 'url'=>array('admin')),
);
?>

<h1>Create CarAssignment</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>