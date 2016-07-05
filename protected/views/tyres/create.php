<?php
$this->breadcrumbs=array(
	'Tyres'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Tyres', 'url'=>array('index')),
	array('label'=>'Manage Tyres', 'url'=>array('admin')),
);
?>

<h3>Add Tyres</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>