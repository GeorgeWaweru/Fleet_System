<?php
$this->breadcrumbs=array(
	'Tyres'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Tyres', 'url'=>array('index')),
	//array('label'=>'Create Tyres', 'url'=>array('create')),
	//array('label'=>'View Tyres', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Tyres', 'url'=>array('admin')),
);
?>

<h3>Update Tyre</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>