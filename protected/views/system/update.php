<?php
$this->breadcrumbs=array(
	'Systems'=>array('admin'),
	$model->title=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List System', 'url'=>array('index')),
	//array('label'=>'Create System', 'url'=>array('create')),
	//array('label'=>'View System', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage System', 'url'=>array('admin')),
);
?>

<h3>Update System</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>