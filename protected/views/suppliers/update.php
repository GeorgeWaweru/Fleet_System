<?php
/* @var $this SuppliersController */
/* @var $model Suppliers */

$this->breadcrumbs=array(
	'Suppliers'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'List Suppliers', 'url'=>array('admin')),
	array('label'=>'Add Supplier', 'url'=>array('create')),
	//array('label'=>'View Suppliers', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Suppliers', 'url'=>array('admin')),
);
?>

<h3>Update Supplier</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>