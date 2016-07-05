<?php
$this->breadcrumbs=array(
	'Drivers'=>array('admin'),
	$model->id=>array('admin'),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Drivers', 'url'=>array('index')),
	//array('label'=>'Create Drivers', 'url'=>array('create')),
	//array('label'=>'View Drivers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h3>Update User</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>