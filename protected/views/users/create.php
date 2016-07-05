<?php
$this->breadcrumbs=array(
	'Drivers'=>array('admin'),
	'Create',
);
$this->menu=array(
	//array('label'=>'List Drivers', 'url'=>array('index')),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h3>Add User</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>