<?php
/* @var $this RequestCommentsController */
/* @var $model RequestComments */

$this->breadcrumbs=array(
	'Request Comments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RequestComments', 'url'=>array('index')),
	array('label'=>'Manage RequestComments', 'url'=>array('admin')),
);
?>

<h1>Create RequestComments</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>