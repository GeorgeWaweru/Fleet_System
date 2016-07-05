<?php
/* @var $this SystemController */
/* @var $model System */

$this->breadcrumbs=array(
	'Systems'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List System', 'url'=>array('index')),
	array('label'=>'Manage System', 'url'=>array('admin')),
);
?>

<h3>Add System</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>