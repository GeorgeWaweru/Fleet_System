<?php
/* @var $this SpareController */
/* @var $model Spare */

$this->breadcrumbs=array(
	'Spares'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Spare', 'url'=>array('index')),
	//array('label'=>'Create Spare', 'url'=>array('create')),
	//array('label'=>'View Spare', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Spare', 'url'=>array('admin')),
);
?>

<h3>Update Spare Part</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>