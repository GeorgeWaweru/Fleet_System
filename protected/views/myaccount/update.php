<?php
/* @var $this MyaccountController */
/* @var $model Systemusers */

$this->breadcrumbs=array(
	'Systemusers'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List Systemusers', 'url'=>array('index')),
	array('label'=>'Create Systemusers', 'url'=>array('create')),
	array('label'=>'View Systemusers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Systemusers', 'url'=>array('admin')),
);*/
?>

<h3>Update Password</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>