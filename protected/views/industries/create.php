<?php
/* @var $this IndustriesController */
/* @var $model Industries */

$this->breadcrumbs=array(
	'Industries'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Industries', 'url'=>array('index')),
	array('label'=>'Manage Industries', 'url'=>array('admin')),
);
?>

<h3>Add Industries</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>