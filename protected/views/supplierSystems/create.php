<?php
$this->breadcrumbs=array(
	'Supplier Systems'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List SupplierSystems', 'url'=>array('index')),
	array('label'=>'Manage Supplier Systems', 'url'=>array('admin')),
);
?>

<h3>Add Supplier System</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>