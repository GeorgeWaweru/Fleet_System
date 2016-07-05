<?php
/* @var $this SpareController */
/* @var $model Spare */

$this->breadcrumbs=array(
	'Spares'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Spare', 'url'=>array('index')),
	array('label'=>'Manage Spare Part', 'url'=>array('admin')),
);
?>

<h3>Add Spare Part</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>