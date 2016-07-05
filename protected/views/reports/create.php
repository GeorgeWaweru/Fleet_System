<?php
/* @var $this ReportsController */
/* @var $model Votes */

$this->breadcrumbs=array(
	'Votes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Votes', 'url'=>array('index')),
	array('label'=>'Manage Votes', 'url'=>array('admin')),
);
?>

<h1>Create Votes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>