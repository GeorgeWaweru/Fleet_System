<?php
/* @var $this RolesController */
/* @var $model Roles */

$this->breadcrumbs=array(
	'Roles'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Roles', 'url'=>array('index')),
	//array('label'=>'Create Roles', 'url'=>array('create')),
	//array('label'=>'View Roles', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage User Roles', 'url'=>array('admin')),
);
?>

<h3>Update User Role</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>