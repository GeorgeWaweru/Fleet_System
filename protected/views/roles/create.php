<?php
$this->breadcrumbs=array(
	'Roles'=>array('admin'),
	'Create',
);
$this->menu=array(
	//array('label'=>'List Roles', 'url'=>array('index')),
	array('label'=>'Manage User Roles', 'url'=>array('admin')),
);
?>
<h3>Add User Role</h3>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>