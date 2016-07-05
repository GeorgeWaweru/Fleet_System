<?php
$this->breadcrumbs=array(
	'Engines'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Engines', 'url'=>array('index')),
	array('label'=>'Manage Engines', 'url'=>array('admin')),
);
?>

<h3>Add Engine Number</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>